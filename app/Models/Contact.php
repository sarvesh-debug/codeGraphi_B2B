<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'logo', 
        'helpline_no', 
        'tsn_no', 
        'banners',
        'latest_news',
        'emergency_update'
    ];

    // Cast the banners field to an array when retrieving it from the database
    protected $casts = [
        'banners' => 'array',
    ];
}
