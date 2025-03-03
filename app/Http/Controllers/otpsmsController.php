<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class otpsmsController extends Controller
{
    public function verifyOtp(Request $request)
{
    // return $request;
    // die();

    
    $request->validate([
        'otp' => 'required|numeric',
        
    ]);
    $mobile=$request->mobile;

    // Check if OTP matches the session OTP
    if ($request->otp == session('otp')) {
        session()->forget('otp'); // Clear OTP from session
       // return redirect()->intended('customer/dashboard');
       return view('admin.client-sign',compact('mobile'));
    }

    return view('user.otp-sms.invalid');
}

}
