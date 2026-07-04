<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StudentOtpMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public function __construct(
        public string $code,
        public string $purpose
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subjectForPurpose(),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.student-otp',
            with: [
                'code' => $this->code,
                'purposeLabel' => $this->purposeLabel(),
            ],
        );
    }

    private function subjectForPurpose(): string
    {
        return match ($this->purpose) {
            'registration' => 'Verify your student account',
            'profile_update' => 'Verify your profile update',
            'password_reset' => 'Reset your student password',
            default => 'Your verification code',
        };
    }

    private function purposeLabel(): string
    {
        return match ($this->purpose) {
            'registration' => 'student account registration',
            'profile_update' => 'profile update',
            'password_reset' => 'password reset',
            default => 'verification',
        };
    }
}
