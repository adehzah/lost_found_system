<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}