<?php

namespace Tests\Feature;

use App\Mail\StudentOtpMail;
use App\Models\Student;
use App\Models\StudentOtp;
use App\Services\StudentOtpService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class EmailOnlyOtpTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_uses_email_otp_only_and_saves_phone_number(): void
    {
        Mail::fake();

        $response = $this->post('/register', [
            'full_name' => 'Test Student',
            'matric_number' => 'U20/CSC/1001',
            'email' => 'student@example.com',
            'phone' => '08012345678',
            'password' => 'secret123',
        ]);

        $response->assertRedirect('/register/verify');

        $student = Student::where('matric_number', 'U20/CSC/1001')->firstOrFail();

        $this->assertSame('08012345678', $student->phone);
        $this->assertNull($student->phone_verified_at);
        $this->assertDatabaseCount('student_otps', 1);
        $this->assertDatabaseHas('student_otps', [
            'student_id' => $student->id,
            'purpose' => StudentOtpService::PURPOSE_REGISTRATION,
            'channel' => 'email',
            'destination' => 'student@example.com',
        ]);

        Mail::assertSent(StudentOtpMail::class, fn (StudentOtpMail $mail) => $mail->hasTo('student@example.com'));

        $otp = StudentOtp::firstOrFail();
        $otp->forceFill(['code_hash' => Hash::make('123456')])->save();

        $verifyResponse = $this
            ->withSession(['student_registration_id' => $student->id])
            ->post('/register/verify', [
                'email_otp' => '123456',
            ]);

        $verifyResponse->assertRedirect('/login');

        $student->refresh();

        $this->assertNotNull($student->email_verified_at);
        $this->assertNull($student->phone_verified_at);
    }

    public function test_forgot_password_uses_registered_email_otp_only(): void
    {
        Mail::fake();

        $student = Student::create([
            'full_name' => 'Reset Student',
            'matric_number' => 'U20/CSC/1002',
            'email' => 'reset@example.com',
            'email_verified_at' => now(),
            'phone' => '08022222222',
            'phone_verified_at' => null,
            'password' => Hash::make('oldpass'),
        ]);

        $response = $this->post('/forgot-password', [
            'email' => 'reset@example.com',
        ]);

        $response->assertRedirect('/forgot-password/verify');
        $this->assertDatabaseCount('student_otps', 1);
        $this->assertDatabaseHas('student_otps', [
            'student_id' => $student->id,
            'purpose' => StudentOtpService::PURPOSE_PASSWORD_RESET,
            'channel' => 'email',
            'destination' => 'reset@example.com',
        ]);

        Mail::assertSent(StudentOtpMail::class, fn (StudentOtpMail $mail) => $mail->hasTo('reset@example.com'));

        $otp = StudentOtp::firstOrFail();
        $otp->forceFill(['code_hash' => Hash::make('654321')])->save();

        $verifyResponse = $this
            ->withSession(['student_password_reset_id' => $student->id])
            ->post('/forgot-password/verify', [
                'email_otp' => '654321',
                'password' => 'newpass123',
                'password_confirmation' => 'newpass123',
            ]);

        $verifyResponse->assertRedirect('/login');

        $student->refresh();

        $this->assertTrue(Hash::check('newpass123', $student->password));
    }

    public function test_phone_profile_change_is_confirmed_by_current_email_otp(): void
    {
        Mail::fake();

        $student = Student::create([
            'full_name' => 'Profile Student',
            'matric_number' => 'U20/CSC/1003',
            'email' => 'profile@example.com',
            'email_verified_at' => now(),
            'phone' => '08033333333',
            'phone_verified_at' => now(),
            'password' => Hash::make('secret123'),
        ]);

        $response = $this
            ->withSession(['student_id' => $student->id])
            ->post('/student/profile', [
                'email' => 'profile@example.com',
                'phone' => '08044444444',
            ]);

        $response->assertRedirect('/student/profile/verify');

        $student->refresh();

        $this->assertSame('08033333333', $student->phone);
        $this->assertDatabaseCount('student_otps', 1);
        $this->assertDatabaseHas('student_otps', [
            'student_id' => $student->id,
            'purpose' => StudentOtpService::PURPOSE_PROFILE_UPDATE,
            'channel' => 'email',
            'destination' => 'profile@example.com',
        ]);

        Mail::assertSent(StudentOtpMail::class, fn (StudentOtpMail $mail) => $mail->hasTo('profile@example.com'));

        $otp = StudentOtp::firstOrFail();
        $otp->forceFill(['code_hash' => Hash::make('222222')])->save();

        $verifyResponse = $this
            ->withSession([
                'student_id' => $student->id,
                'student_profile_update' => [
                    'student_id' => $student->id,
                    'email' => 'profile@example.com',
                    'phone' => '08044444444',
                    'verify_email' => false,
                    'verify_phone' => true,
                    'email_otp_destination' => null,
                    'phone_change_email_destination' => 'profile@example.com',
                ],
            ])
            ->post('/student/profile/verify', [
                'phone_change_otp' => '222222',
            ]);

        $verifyResponse->assertRedirect('/');

        $student->refresh();

        $this->assertSame('08044444444', $student->phone);
        $this->assertNull($student->phone_verified_at);
    }

    public function test_used_email_otp_cannot_be_used_again(): void
    {
        $student = Student::create([
            'full_name' => 'Secure Student',
            'matric_number' => 'U20/CSC/1004',
            'email' => 'secure@example.com',
            'email_verified_at' => now(),
            'phone' => '08055555555',
            'password' => Hash::make('secret123'),
        ]);

        StudentOtp::create([
            'student_id' => $student->id,
            'purpose' => StudentOtpService::PURPOSE_PASSWORD_RESET,
            'channel' => 'email',
            'destination' => 'secure@example.com',
            'code_hash' => Hash::make('111111'),
            'expires_at' => now()->addMinutes(10),
        ]);

        $otpService = app(StudentOtpService::class);

        [$firstOk] = $otpService->verify(
            $student,
            StudentOtpService::PURPOSE_PASSWORD_RESET,
            'email',
            '111111',
            'secure@example.com'
        );

        [$secondOk, $secondError] = $otpService->verify(
            $student,
            StudentOtpService::PURPOSE_PASSWORD_RESET,
            'email',
            '111111',
            'secure@example.com'
        );

        $this->assertTrue($firstOk);
        $this->assertFalse($secondOk);
        $this->assertSame('No active OTP was found. Please request a new code.', $secondError);
    }

    public function test_expired_email_otp_does_not_work(): void
    {
        $student = Student::create([
            'full_name' => 'Expired Student',
            'matric_number' => 'U20/CSC/1005',
            'email' => 'expired@example.com',
            'email_verified_at' => now(),
            'phone' => '08066666666',
            'password' => Hash::make('secret123'),
        ]);

        StudentOtp::create([
            'student_id' => $student->id,
            'purpose' => StudentOtpService::PURPOSE_PASSWORD_RESET,
            'channel' => 'email',
            'destination' => 'expired@example.com',
            'code_hash' => Hash::make('333333'),
            'expires_at' => now()->subMinute(),
        ]);

        [$ok, $error] = app(StudentOtpService::class)->verify(
            $student,
            StudentOtpService::PURPOSE_PASSWORD_RESET,
            'email',
            '333333',
            'expired@example.com'
        );

        $this->assertFalse($ok);
        $this->assertSame('This OTP has expired. Please request a new code.', $error);
    }

    public function test_wrong_email_otp_attempts_are_limited(): void
    {
        $student = Student::create([
            'full_name' => 'Attempt Student',
            'matric_number' => 'U20/CSC/1006',
            'email' => 'attempts@example.com',
            'email_verified_at' => now(),
            'phone' => '08077777777',
            'password' => Hash::make('secret123'),
        ]);

        StudentOtp::create([
            'student_id' => $student->id,
            'purpose' => StudentOtpService::PURPOSE_PASSWORD_RESET,
            'channel' => 'email',
            'destination' => 'attempts@example.com',
            'code_hash' => Hash::make('444444'),
            'expires_at' => now()->addMinutes(10),
        ]);

        $otpService = app(StudentOtpService::class);

        for ($attempt = 1; $attempt <= 5; $attempt++) {
            [$ok, $error] = $otpService->verify(
                $student,
                StudentOtpService::PURPOSE_PASSWORD_RESET,
                'email',
                '000000',
                'attempts@example.com'
            );

            $this->assertFalse($ok);
            $this->assertSame('The OTP you entered is incorrect.', $error);
        }

        [$ok, $error] = $otpService->verify(
            $student,
            StudentOtpService::PURPOSE_PASSWORD_RESET,
            'email',
            '444444',
            'attempts@example.com'
        );

        $this->assertFalse($ok);
        $this->assertSame('Too many incorrect attempts. Please request a new code.', $error);
    }

    public function test_profile_contact_otps_are_marked_used_only_after_all_codes_are_correct(): void
    {
        Mail::fake();

        $student = Student::create([
            'full_name' => 'Batch Student',
            'matric_number' => 'U20/CSC/1007',
            'email' => 'batch@example.com',
            'email_verified_at' => now(),
            'phone' => '08088888888',
            'password' => Hash::make('secret123'),
        ]);

        $response = $this
            ->withSession(['student_id' => $student->id])
            ->post('/student/profile', [
                'email' => 'new-batch@example.com',
                'phone' => '08099999999',
            ]);

        $response->assertRedirect('/student/profile/verify');

        StudentOtp::where('destination', 'new-batch@example.com')
            ->firstOrFail()
            ->forceFill(['code_hash' => Hash::make('121212')])
            ->save();

        StudentOtp::where('destination', 'batch@example.com')
            ->firstOrFail()
            ->forceFill(['code_hash' => Hash::make('343434')])
            ->save();

        $pending = [
            'student_id' => $student->id,
            'email' => 'new-batch@example.com',
            'phone' => '08099999999',
            'verify_email' => true,
            'verify_phone' => true,
            'email_otp_destination' => 'new-batch@example.com',
            'phone_change_email_destination' => 'batch@example.com',
        ];

        $failedAttempt = $this
            ->withSession([
                'student_id' => $student->id,
                'student_profile_update' => $pending,
            ])
            ->post('/student/profile/verify', [
                'email_otp' => '121212',
                'phone_change_otp' => '000000',
            ]);

        $failedAttempt->assertSessionHasErrors('phone_change_otp');

        $this->assertNull(
            StudentOtp::where('destination', 'new-batch@example.com')->firstOrFail()->verified_at
        );

        $successfulRetry = $this
            ->withSession([
                'student_id' => $student->id,
                'student_profile_update' => $pending,
            ])
            ->post('/student/profile/verify', [
                'email_otp' => '121212',
                'phone_change_otp' => '343434',
            ]);

        $successfulRetry->assertRedirect('/');

        $student->refresh();

        $this->assertSame('new-batch@example.com', $student->email);
        $this->assertSame('08099999999', $student->phone);
        $this->assertDatabaseMissing('student_otps', [
            'student_id' => $student->id,
            'purpose' => StudentOtpService::PURPOSE_PROFILE_UPDATE,
        ]);
    }
}
