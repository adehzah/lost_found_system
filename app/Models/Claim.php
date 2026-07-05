<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Claim extends Model
{
    protected $fillable = [
        'found_item_id',
        'claimant_name',
        'matric_number',
        'contact_number',
        'proof_description',
        'proof_image',
        'status',
    ];

    public function foundItem()
    {
        return $this->belongsTo(FoundItem::class, 'found_item_id');
    }

    public function getProofImageUrlAttribute(): ?string
    {
        return $this->proof_image
            ? Storage::disk(config('filesystems.uploads_disk'))->url($this->proof_image)
            : null;
    }
}
