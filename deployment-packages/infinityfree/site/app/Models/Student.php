<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
