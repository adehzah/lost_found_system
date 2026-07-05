<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Services\StudentOtpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class StudentAuthController extends Controller
{
    public function loginPage()
    {
        return view('student-login');
    }

    public function showLogin()
    {
        return view('student-login');
    }

    public function registerPage()
    {
        return view('student-register');
    }

    public function showRegister()
    {
        return view('student-register');
    }

    public function register(Request $request, StudentOtpService $otpService)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'matric_number' => 'required|string|max:255|unique:students,matric_number',
            'email' => 'required|email|max:255|unique:students,email',
            'phone' => 'required|string|max:30',
            'password' => 'required|string|min:4',
        ]);

        $student = Student::create([
            'full_name' => $request->full_name,
            'matric_number' => $request->matric_number,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        $this->clearStudentSession();
        $this->clearAdminSession();
        $this->clearOtpSessions();

        session(['student_registration_id' => $student->id]);

        $this->sendRegistrationOtp($student, $otpService);

        return redirect('/register/verify')
            ->with('success', 'Registration saved. Enter the OTP code sent to your email.');
    }

    public function registrationOtpPage()
    {
        $student = $this->studentFromSession('student_registration_id');

        if (!$student) {
            return redirect('/register')->with('error', 'Please register first.');
        }

        $verifyEmail = (bool) ($student->email && !$student->email_verified_at);

        if (!$verifyEmail) {
            return redirect('/login')->with('success', 'Your account is already verified. You can login.');
        }

        return view('student-register-verify', [
            'student' => $student,
            'maskedEmail' => $this->maskEmail($student->email),
            'verifyEmail' => $verifyEmail,
        ]);
    }

    public function verifyRegistrationOtp(Request $request, StudentOtpService $otpService)
    {
        $student = $this->studentFromSession('student_registration_id');

        if (!$student) {
            return redirect('/register')->with('error', 'Please register first.');
        }

        $verifyEmail = (bool) ($student->email && !$student->email_verified_at);

        if (!$verifyEmail) {
            return redirect('/login')->with('success', 'Your account is already verified. You can login.');
        }

        $request->validate([
            'email_otp' => 'required|digits:6',
        ]);

        $emailError = $this->verifyEmailOtp(
            $request,
            $otpService,
            $student,
            StudentOtpService::PURPOSE_REGISTRATION,
            'email_otp',
            $student->email
        );

        if ($emailError) {
            return back()->withErrors(['email_otp' => $emailError]);
        }

        $student->email_verified_at = now();

        $student->save();

        $otpService->clearPurpose($student, StudentOtpService::PURPOSE_REGISTRATION);
        session()->forget('student_registration_id');

        return redirect('/login')->with('success', 'Registration verified. You can now login.');
    }

    public function resendRegistrationOtp(StudentOtpService $otpService)
    {
        $student = $this->studentFromSession('student_registration_id');

        if (!$student) {
            return redirect('/register')->with('error', 'Please register first.');
        }

        $this->sendRegistrationOtp($student, $otpService);

        return back()->with('success', 'A new OTP code has been sent to your email.');
    }

    public function login(Request $request, StudentOtpService $otpService)
    {
        $request->validate([
            'matric_number' => 'required|string',
            'password' => 'required|string',
        ]);

        $matricNumber = trim($request->matric_number);
        $password = $request->password;

        $student = Student::whereRaw('LOWER(matric_number) = ?', [strtolower($matricNumber)])->first();

        if (!$student || !Hash::check($password, $student->password)) {
            return back()->with('error', 'Invalid matric number or password.');
        }

        $emailNeedsVerification = $student->email && !$student->email_verified_at;

        if ($emailNeedsVerification) {
            $this->clearStudentSession();
            $this->clearAdminSession();
            $this->clearOtpSessions();

            session(['student_registration_id' => $student->id]);

            $otpService->send($student, StudentOtpService::PURPOSE_REGISTRATION, StudentOtpService::CHANNEL_EMAIL, $student->email);

            return redirect('/register/verify')
                ->with('error', 'Please verify your email before logging in.');
        }

        session([
            'student_id' => $student->id,
            'student_name' => $student->full_name,
            'student_matric' => $student->matric_number,
            'student_phone' => $student->phone,
            'student_profile_picture' => $student->profile_picture,
        ]);

        $this->clearAdminSession();
        session()->forget('student_registration_id');

        return redirect('/');
    }

    public function logout()
    {
        $this->clearStudentSession();
        $this->clearOtpSessions();

        return redirect('/login')->with('success', 'You have been logged out successfully.');
    }

    public function updateProfile(Request $request, StudentOtpService $otpService)
    {
        if (!session('student_id')) {
            return redirect('/login')->with('error', 'Please login first.');
        }

        $student = Student::find(session('student_id'));

        if (!$student) {
            $this->clearStudentSession();

            return redirect('/login')->with('error', 'Student account not found. Please login again.');
        }

        $request->validate([
            'email' => 'required|email|max:255|unique:students,email,' . $student->id,
            'phone' => 'nullable|string|max:30',
            'password' => 'nullable|string|min:4',
            'profile_picture' => 'nullable|image|max:4096',
        ]);

        $newEmail = trim($request->email);
        $newPhone = $request->filled('phone') ? trim($request->phone) : null;
        $currentEmail = $student->email;

        $emailChanged = $newEmail !== $student->email;
        $phoneChanged = $newPhone !== $student->phone;
        $needsEmailOtp = $emailChanged;
        $needsPhoneOtp = $phoneChanged;

        if ($needsPhoneOtp && !$currentEmail) {
            return back()->with('error', 'A registered email address is required before changing your phone number.');
        }

        if ($request->filled('password')) {
            $student->password = Hash::make($request->password);
        }

        if ($request->hasFile('profile_picture')) {
            $oldProfilePicture = $student->profile_picture;

            $student->profile_picture = $request->file('profile_picture')
                ->store('profile_pictures', config('filesystems.uploads_disk'));

            if ($oldProfilePicture && Storage::disk(config('filesystems.uploads_disk'))->exists($oldProfilePicture)) {
                Storage::disk(config('filesystems.uploads_disk'))->delete($oldProfilePicture);
            }
        }

        $student->save();
        $this->refreshStudentSession($student);

        if (!$needsEmailOtp && !$needsPhoneOtp) {
            return back()->with('success', 'Profile updated successfully.');
        }

        session([
            'student_profile_update' => [
                'student_id' => $student->id,
                'email' => $newEmail,
                'phone' => $newPhone,
                'verify_email' => $needsEmailOtp,
                'verify_phone' => $needsPhoneOtp,
                'email_otp_destination' => $needsEmailOtp ? $newEmail : null,
                'phone_change_email_destination' => $needsPhoneOtp ? $currentEmail : null,
            ],
        ]);

        if ($needsEmailOtp) {
            $otpService->send($student, StudentOtpService::PURPOSE_PROFILE_UPDATE, StudentOtpService::CHANNEL_EMAIL, $newEmail);
        }

        if ($needsPhoneOtp) {
            $otpService->send($student, StudentOtpService::PURPOSE_PROFILE_UPDATE, StudentOtpService::CHANNEL_EMAIL, $currentEmail);
        }

        return redirect('/student/profile/verify')
            ->with('success', 'Enter the email OTP sent for each contact detail to finish updating your profile.');
    }

    public function profileOtpPage()
    {
        $pending = session('student_profile_update');
        $student = session('student_id') ? Student::find(session('student_id')) : null;

        if (!$student || !$pending || (int) $pending['student_id'] !== (int) $student->id) {
            return redirect('/')->with('error', 'No profile verification is pending.');
        }

        return view('student-profile-verify', [
            'pending' => $pending,
            'maskedEmail' => $this->maskEmail($pending['email_otp_destination'] ?? null),
            'maskedCurrentEmailForPhoneChange' => $this->maskEmail($pending['phone_change_email_destination'] ?? null),
        ]);
    }

    public function verifyProfileOtp(Request $request, StudentOtpService $otpService)
    {
        $pending = session('student_profile_update');
        $student = session('student_id') ? Student::find(session('student_id')) : null;

        if (!$student || !$pending || (int) $pending['student_id'] !== (int) $student->id) {
            return redirect('/')->with('error', 'No profile verification is pending.');
        }

        $request->validate($this->contactEmailOtpRules($pending));

        $checks = [];

        if ($pending['verify_email']) {
            $checks['email_otp'] = [
                'channel' => StudentOtpService::CHANNEL_EMAIL,
                'code' => $request->input('email_otp'),
                'destination' => $pending['email_otp_destination'],
            ];
        }

        if ($pending['verify_phone']) {
            $checks['phone_change_otp'] = [
                'channel' => StudentOtpService::CHANNEL_EMAIL,
                'code' => $request->input('phone_change_otp'),
                'destination' => $pending['phone_change_email_destination'],
            ];
        }

        [$verified, $errors] = $otpService->verifyBatch(
            $student,
            StudentOtpService::PURPOSE_PROFILE_UPDATE,
            $checks
        );

        if (!$verified) {
            return back()->withErrors($errors);
        }

        if ($pending['verify_email']) {
            $student->email = $pending['email'];
            $student->email_verified_at = now();
        }

        if ($pending['verify_phone']) {
            $student->phone = $pending['phone'];
            $student->phone_verified_at = null;
        }

        $student->save();
        $this->refreshStudentSession($student);
        $otpService->clearPurpose($student, StudentOtpService::PURPOSE_PROFILE_UPDATE);
        session()->forget('student_profile_update');

        return redirect('/')->with('success', 'Profile contact details verified and updated successfully.');
    }

    public function resendProfileOtp(StudentOtpService $otpService)
    {
        $pending = session('student_profile_update');
        $student = session('student_id') ? Student::find(session('student_id')) : null;

        if (!$student || !$pending || (int) $pending['student_id'] !== (int) $student->id) {
            return redirect('/')->with('error', 'No profile verification is pending.');
        }

        if ($pending['verify_email']) {
            $otpService->send($student, StudentOtpService::PURPOSE_PROFILE_UPDATE, StudentOtpService::CHANNEL_EMAIL, $pending['email_otp_destination']);
        }

        if ($pending['verify_phone']) {
            $otpService->send($student, StudentOtpService::PURPOSE_PROFILE_UPDATE, StudentOtpService::CHANNEL_EMAIL, $pending['phone_change_email_destination']);
        }

        return back()->with('success', 'New email OTP has been sent for each pending contact change.');
    }

    public function forgotPasswordPage()
    {
        return view('student-forgot-password');
    }

    public function requestPasswordResetOtp(Request $request, StudentOtpService $otpService)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $student = Student::whereRaw('LOWER(email) = ?', [strtolower(trim($request->email))])
            ->first();

        if (
            !$student ||
            !$student->email ||
            !$student->email_verified_at
        ) {
            return back()->with('error', 'No student account with a verified email was found for that email address.');
        }

        $this->clearOtpSessions();
        session(['student_password_reset_id' => $student->id]);

        $this->sendPasswordResetOtp($student, $otpService);

        return redirect('/forgot-password/verify')
            ->with('success', 'Enter the OTP code sent to your email to reset your password.');
    }

    public function passwordResetOtpPage()
    {
        $student = $this->studentFromSession('student_password_reset_id');

        if (!$student) {
            return redirect('/forgot-password')->with('error', 'Please request a password reset first.');
        }

        return view('student-forgot-password-verify', [
            'student' => $student,
            'maskedEmail' => $this->maskEmail($student->email),
        ]);
    }

    public function resetPassword(Request $request, StudentOtpService $otpService)
    {
        $student = $this->studentFromSession('student_password_reset_id');

        if (!$student) {
            return redirect('/forgot-password')->with('error', 'Please request a password reset first.');
        }

        $request->validate([
            'email_otp' => 'required|digits:6',
            'password' => 'required|string|min:4|confirmed',
        ]);

        $emailError = $this->verifyEmailOtp(
            $request,
            $otpService,
            $student,
            StudentOtpService::PURPOSE_PASSWORD_RESET,
            'email_otp',
            $student->email
        );

        if ($emailError) {
            return back()->withErrors(['email_otp' => $emailError]);
        }

        $student->password = Hash::make($request->password);
        $student->save();

        $otpService->clearPurpose($student, StudentOtpService::PURPOSE_PASSWORD_RESET);
        session()->forget('student_password_reset_id');

        return redirect('/login')->with('success', 'Password reset successful. You can now login.');
    }

    public function resendPasswordResetOtp(StudentOtpService $otpService)
    {
        $student = $this->studentFromSession('student_password_reset_id');

        if (!$student) {
            return redirect('/forgot-password')->with('error', 'Please request a password reset first.');
        }

        $this->sendPasswordResetOtp($student, $otpService);

        return back()->with('success', 'A new OTP code has been sent to your email.');
    }

    public function dashboard()
    {
        if (!session('student_id')) {
            return redirect('/login')->with('error', 'Please login first.');
        }

        $student = Student::find(session('student_id'));

        if (!$student) {
            $this->clearStudentSession();

            return redirect('/login')->with('error', 'Student account not found. Please login again.');
        }

        $lostItems = \App\Models\LostItem::where('matric_number', $student->matric_number)
            ->latest()
            ->get();

        $foundItems = \App\Models\FoundItem::where('matric_number', $student->matric_number)
            ->latest()
            ->get();

        $claims = \App\Models\Claim::where('matric_number', $student->matric_number)
            ->with('foundItem')
            ->latest()
            ->get();

        return view('student-dashboard', compact(
            'student',
            'lostItems',
            'foundItems',
            'claims'
        ));
    }

    public function notifications()
    {
        if (!session('student_id')) {
            return redirect('/login')->with('error', 'Please login first.');
        }

        $notifications = \App\Models\Claim::with('foundItem')
            ->where('matric_number', session('student_matric'))
            ->whereIn('status', ['approved', 'rejected'])
            ->latest()
            ->get();

        \App\Models\Claim::where('matric_number', session('student_matric'))
            ->whereIn('status', ['approved', 'rejected'])
            ->whereNull('notification_read_at')
            ->update([
                'notification_read_at' => now(),
            ]);

        return view('student-notifications', compact('notifications'));
    }

    private function verifyEmailOtp(
        Request $request,
        StudentOtpService $otpService,
        Student $student,
        string $purpose,
        string $inputName,
        string $destination
    ): ?string {
        [$ok, $error] = $otpService->verify(
            $student,
            $purpose,
            StudentOtpService::CHANNEL_EMAIL,
            (string) $request->input($inputName),
            $destination
        );

        return $ok ? null : $error;
    }

    private function contactEmailOtpRules(array $pending): array
    {
        $rules = [];

        if ($pending['verify_email']) {
            $rules['email_otp'] = 'required|digits:6';
        }

        if ($pending['verify_phone']) {
            $rules['phone_change_otp'] = 'required|digits:6';
        }

        return $rules;
    }

    private function sendRegistrationOtp(Student $student, StudentOtpService $otpService): void
    {
        $otpService->send($student, StudentOtpService::PURPOSE_REGISTRATION, StudentOtpService::CHANNEL_EMAIL, $student->email);
    }

    private function sendPasswordResetOtp(Student $student, StudentOtpService $otpService): void
    {
        $otpService->send($student, StudentOtpService::PURPOSE_PASSWORD_RESET, StudentOtpService::CHANNEL_EMAIL, $student->email);
    }

    private function studentFromSession(string $key): ?Student
    {
        $studentId = session($key);

        return $studentId ? Student::find($studentId) : null;
    }

    private function refreshStudentSession(Student $student): void
    {
        session([
            'student_name' => $student->full_name,
            'student_matric' => $student->matric_number,
            'student_phone' => $student->phone,
            'student_profile_picture' => $student->profile_picture,
        ]);
    }

    private function clearStudentSession(): void
    {
        session()->forget([
            'student_id',
            'student_name',
            'student_matric',
            'student_phone',
            'student_profile_picture',
        ]);
    }

    private function clearAdminSession(): void
    {
        session()->forget([
            'is_admin',
            'admin_name',
        ]);
    }

    private function clearOtpSessions(): void
    {
        session()->forget([
            'student_registration_id',
            'student_password_reset_id',
            'student_profile_update',
        ]);
    }

    private function maskEmail(?string $email): string
    {
        if (!$email || !str_contains($email, '@')) {
            return 'your email';
        }

        [$name, $domain] = explode('@', $email, 2);
        $prefix = substr($name, 0, 1);

        return $prefix . str_repeat('*', max(strlen($name) - 1, 3)) . '@' . $domain;
    }

}
