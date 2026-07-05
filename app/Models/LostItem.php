<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class LostItem extends Model
{
    protected $fillable = [
        'reported_by',
        'matric_number',
        'item_name',
        'category',
        'description',
        'location_lost',
        'date_lost',
        'contact_number',
        'image',
        'status'
    ];

    public function getImageUrlAttribute(): ?string
    {
        return $this->image
            ? Storage::disk(config('filesystems.uploads_disk'))->url($this->image)
            : null;
    }

    public function getDateLostDisplayAttribute(): string
    {
        return $this->date_lost
            ? Carbon::parse($this->date_lost)->format('d/m/Y')
            : 'Not provided';
    }
}
