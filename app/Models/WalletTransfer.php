<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletTransfer extends Model
{
    use HasFactory;
    protected $table = 'wallet_transfers';

    // Define the fields that can be mass assigned
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'amount',
        'opening_balance',
        'closing_balance',
        'charges',
        'tds',
        'remark',
        'transfer_id',
    ];
}
