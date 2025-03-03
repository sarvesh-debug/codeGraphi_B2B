<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditCardApplication extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'phone', 'pincode', 'pan_no', 'bank', 'retailer_name', 'retailer_username'
    ];
}
