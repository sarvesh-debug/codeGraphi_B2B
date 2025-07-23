<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadLink extends Model
{
    use HasFactory;

    protected $table = 'lead_links';

    protected $fillable = [
        'refid',
        'request_id',
        'link',
        'retailer_id',
        'name',
        'mobile',
    ];
}
