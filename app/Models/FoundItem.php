<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class FoundItem extends Model
{
    protected $fillable = [
        'reporter_name',
        'matric_number',
        'item_name',
        'category',
        'description',
        'location_found',
        'date_found',
        'contact_number',
        'image',
        'status',
    ];

    public function claims()
    {
        return $this->hasMany(Claim::class, 'found_item_id');
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->image
            ? Storage::disk(config('filesystems.uploads_disk'))->url($this->image)
            : null;
    }

    public function getDateFoundDisplayAttribute(): string
    {
        return $this->date_found
            ? Carbon::parse($this->date_found)->format('d/m/Y')
            : 'Not provided';
    }
}
