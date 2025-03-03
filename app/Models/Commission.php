<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    use HasFactory;
    protected $tabele='commission_plan';
    protected $fillable = [
        'service',
        'from_amount',
        'to_amount',
        'charge',
        'commission',
        'tds',
        'charge_in',
        'commission_in',
        'tds_in',
    ];

    // public function customer()
    // {
    //     return $this->belongsTo(CustomerModel::class);
    // }
    public function customer()
{
    return $this->belongsTo(CustomerModel::class, 'customer_id');
}
}
