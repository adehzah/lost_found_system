<?php

namespace App\Services;

use App\Mail\StudentOtpMail;
use App\Models\Student;
use App\Models\StudentOtp;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use InvalidArgumentException;

class StudentOtpService
{
    public const CHANNEL_EMAIL = 'email';

    public const PURPOSE_REGISTRATION = 'registration';
    public const PURPOSE_PASSWORD_RESET = 'password_reset';
    public const PURPOSE_PROFILE_UPDATE = 'profile_update';

    public function send(Student $student, string $purpose, string $channel, string $destination): void
    {
        if ($channel !== self::CHANNEL_EMAIL) {
            throw new InvalidArgumentException('Unsupported OTP channel.');
        }

        $code = (string) random_int(100000, 999999);

        StudentOtp::where('student_id', $student->id)
            ->where('purpose', $purpose)
            ->where('channel', $channel)
            ->where('destination', $destination)
            ->whereNull('verified_at')
            ->delete();

        StudentOtp::create([
            'student_id' => $student->id,
            'purpose' => $purpose,
            'channel' => $channel,
            'destination' => $destination,
            'code_hash' => Hash::make($code),
            'expires_at' => now()->addMinutes(10),
        ]);

        Mail::to($destination)->send(new StudentOtpMail($code, $purpose));
    }

    public function verify(
        Student $student,
        string $purpose,
        string $channel,
        string $code,
        ?string $destination = null
    ): array {
        if ($channel !== self::CHANNEL_EMAIL) {
            return [false, 'Unsupported OTP channel.'];
        }

        $query = StudentOtp::where('student_id', $student->id)
            ->where('purpose', $purpose)
            ->where('channel', $channel)
            ->whereNull('verified_at')
            ->latest();

        if ($destination !== null) {
            $query->where('destination', $destination);
        }

        $otp = $query->first();

        if (!$otp) {
            return [false, 'No active OTP was found. Please request a new code.'];
        }

        if (now()->greaterThan($otp->expires_at)) {
            return [false, 'This OTP has expired. Please request a new code.'];
        }

        if ($otp->attempts >= 5) {
            return [false, 'Too many incorrect attempts. Please request a new code.'];
        }

        $otp->attempts++;

        if (!Hash::check($code, $otp->code_hash)) {
            $otp->save();

            return [false, 'The OTP you entered is incorrect.'];
        }

        $otp->verified_at = now();
        $otp->save();

        return [true, null];
    }

    public function verifyBatch(Student $student, string $purpose, array $checks): array
    {
        $validOtps = [];
        $errors = [];

        foreach ($checks as $inputName => $check) {
            $channel = $check['channel'] ?? self::CHANNEL_EMAIL;
            $code = (string) ($check['code'] ?? '');
            $destination = $check['destination'] ?? null;

            if ($channel !== self::CHANNEL_EMAIL) {
                $errors[$inputName] = 'Unsupported OTP channel.';
                continue;
            }

            $query = StudentOtp::where('student_id', $student->id)
                ->where('purpose', $purpose)
                ->where('channel', $channel)
                ->whereNull('verified_at')
                ->latest();

            if ($destination !== null) {
                $query->where('destination', $destination);
            }

            $otp = $query->first();

            if (!$otp) {
                $errors[$inputName] = 'No active OTP was found. Please request a new code.';
                continue;
            }

            if (now()->greaterThan($otp->expires_at)) {
                $errors[$inputName] = 'This OTP has expired. Please request a new code.';
                continue;
            }

            if ($otp->attempts >= 5) {
                $errors[$inputName] = 'Too many incorrect attempts. Please request a new code.';
                continue;
            }

            if (!Hash::check($code, $otp->code_hash)) {
                $otp->attempts++;
                $otp->save();

                $errors[$inputName] = 'The OTP you entered is incorrect.';
                continue;
            }

            $validOtps[] = $otp;
        }

        if ($errors) {
            return [false, $errors];
        }

        foreach ($validOtps as $otp) {
            $otp->attempts++;
            $otp->verified_at = now();
            $otp->save();
        }

        return [true, []];
    }

    public function clearPurpose(Student $student, string $purpose): void
    {
        StudentOtp::where('student_id', $student->id)
            ->where('purpose', $purpose)
            ->delete();
    }
}
