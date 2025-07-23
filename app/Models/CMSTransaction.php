<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CMSTransaction extends Model
{
    protected $table='cms_transactions';
    protected $fillable = [
        'refid', 'retailer_id','event', 'amount', 'biller_id', 'biller_name', 'mobile_no',
        'commission', 'utr', 'ackno', 'unique_id', 'status', 'errormsg', 'datetime'
    ];

    protected $casts = [
        'datetime' => 'datetime',
    ];
}
