<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Student extends Model
{
    protected $fillable = [
        'full_name',
        'matric_number',
        'email',
        'email_verified_at',
        'phone',
        'phone_verified_at',
        'password',
        'profile_picture'
    ];

    protected $hidden = [
        'password'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
    ];

    public function otps()
    {
        return $this->hasMany(StudentOtp::class);
    }

    public function getProfilePictureUrlAttribute(): ?string
    {
        return $this->profile_picture
            ? Storage::disk(config('filesystems.uploads_disk'))->url($this->profile_picture)
            : null;
    }
}
