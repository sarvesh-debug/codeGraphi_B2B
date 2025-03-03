<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VeriidyAccount extends Model
{
    use HasFactory;
    protected $table='veriidy_accounts';
    protected $fillable = [
      'updated',
        'mobile',
        'benename',
        'beneMmobile',
        'accno',
        'bankId',
        'ifsc',
    ];
}
