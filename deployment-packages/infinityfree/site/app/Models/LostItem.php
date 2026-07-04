<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}