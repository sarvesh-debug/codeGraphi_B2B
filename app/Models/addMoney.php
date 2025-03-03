<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class addMoney extends Model
{
    use HasFactory;
    protected $table=['add_moneys'];
    protected $fillable = [
        'bank_id',
        'ifsc',
        'account_no',
        'amount',
        'utr',
        'date',
        'mode',
        'slip_images',
        'remark',
        'status',
    ];

     /**
     * Cast attributes to specific types.
     *
     * @var array
     */
    protected $casts = [
        'slip_images' => 'array', // Automatically casts slip_images to an array
    ];
}
