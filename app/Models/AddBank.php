<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddBank extends Model
{
    use HasFactory;
    protected $table=['add_bank'];
    protected $fillable = [
        'bank_name',
        'ifsc',
        'account_no',
    ];
}
