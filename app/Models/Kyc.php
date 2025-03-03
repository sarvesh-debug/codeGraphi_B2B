<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kyc extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'username',
        'aadhaar',
        'pan',
        'city',
        'state',
        'pincode',
        'outlet_name',
        'aadhaar_front',
        'aadhaar_back',
        'pan_card',
        'bank',
        'ifsc'

    ];
}
