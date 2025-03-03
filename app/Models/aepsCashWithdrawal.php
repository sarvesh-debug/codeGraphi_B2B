<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class aepsCashWithdrawal extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',      // ID of the user making the request
        'amount',       // Amount being withdrawn
        'transaction_id',  // Transaction ID of the API response
        'status',       // Status of the withdrawal (e.g., success, failed)
    ];
}
