<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Session;
class CustomerModel extends Authenticatable
{
    use HasFactory;
    protected $table = 'customer'; // Ensure this matches the actual table name in the database.
    protected $fillable = [
        'name', 
        'username', 
        'email', 
        'phone', 
        'dis_phone',
        'dis_name',
        'pin', 
        'owner', 
        'balance', 
        'role',
        'password',
        'address_aadhar',   // Aadhar address field
        'city',             // City
        'state',            // State
        'pincode',
        'aadhar_no',        // Aadhar number
        'pan_no',           // PAN number
        'account_no',       // Bank account number
        'ifsc_code',        // IFSC Code
        'bank_name',        // Bank name
        'aadhar_front',     // Path to Aadhar front image
        'aadhar_back',      // Path to Aadhar back image
        'pan_image',        // Path to PAN image
        'bank_document',
        'mpin',    // Path to Bank document image
    ];

   

    public static function getMpin()
    {
        $mobile = Session::get('mobile'); // Get the session mobile number
        return self::where('mobile', $mobile)->value('mpin');
    }
   

}
