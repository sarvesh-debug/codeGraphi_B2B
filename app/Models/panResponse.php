<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class panResponse extends Model
{
    use HasFactory;
    protected $table="pancard";
    protected $fillable = ['order_id','name','username','number', 'mode','apply_for','balance', 'response_body'];
}
