<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentOtp extends Model
{
    protected $fillable = [
        'student_id',
        'purpose',
        'channel',
        'destination',
        'code_hash',
        'attempts',
        'expires_at',
        'verified_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'verified_at' => 'datetime',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
