<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomerModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\DB;



class PasswordResetController extends Controller
{
    // Show the form to request a password reset
    public function showRequestForm()
    {
        return view('user.auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        
        $request->validate([
            'mobile' => 'required',
            'email' => 'required|email|exists:customer,email',
        ]);
$mobile= $request->mobile;
        // Find the user by username and email
        $customer = CustomerModel::where('phone', $request->mobile)
                                  ->where('email', $request->email)
                                  ->first();

                                //   return $customer;
                                //   die();                     

        if ($customer) {

            $token = Str::random(60);
            $customer->reset_token = $token;
            $customer->save();

            // Send the user to the reset form with the token in URL
            //return redirect()->route('password.reset', ['token' => $token]);
            return view('user.auth.reset-password',compact('mobile'));
        }

        return redirect()->back()->withErrors(['email' => 'Invalid mobile or email.']);
    }


    public function forgetPasswors(Request $request)
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
       //return view('admin.client-sign',compact('mobile'));
       return redirect()->route('password.reset', ['mobile' => $mobile]);
    }

    return view('user.otp-sms.invalid');
} 

    

    // Show the reset password form
    public function showResetForm(Request $request)
    {
        $mobile = $request->query('mobile');
        // return $mobile;
        // die();
        return view('user.auth.reset-password',compact('mobile'));
    }

    // Handle the password reset
    public function resetPassword(Request $request)
    {
        
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Find the user with the matching reset token
        $customer = CustomerModel::where('phone', $request->mobile)->first();
        // return $customer;
        // die();
        if ($customer) {
            // Update the customer's password
            $customer->password = Hash::make($request->password);
            $customer->reset_token = null; // Clear the reset token
            $customer->save();

            return redirect()->route('customer.login')->with('success', 'Password updated successfully.');
        }

        return redirect()->route('password.request')->withErrors(['token' => 'Invalid or expired token.']);
    }


    public function sendResetLink1(Request $request)
    {
        // return $request;
        // die();
        $request->validate([
            'mobile' => 'required',
            'email' => 'required|email|exists:users,email',
        ]);

       
        // Find the user by username and email
      

            $customer = User::where('phone', $request->mobile)->
            where('email',$request->email)->first();
           $mobile= $customer->phone;

            $otp = rand(100000, 999999);
            //$otp=123456;
                session(['otp' => $otp]);

                
                        // Set OTP or message
                        $message="Dear customer {$otp} is your OTP please do not share with anyone Team Paybrill";

                $url = "http://136.243.135.116/http-tokenkeyapi.php?" . http_build_query([
                    'authentic-key' => '31355041594252494c4c3130301750752451',
                    'senderid'      => 'PYBRFT',
                    'route'         => '1',
                    'number'        => $mobile,
                    'message'       => $message,
                    'templateid'    => '1007440975322577025'
                ]);

                $response = file_get_contents($url);


            if($response)
            {
                //return view('admin.auth.resetPass',compact('mobile'));
                return view('admin.auth.getOTP',compact('mobile'));
            }
            else
            {
                return redirect()->back()->withErrors(['mobile' => 'No account found with this mobile number.']);

            }
         
    }

    public function forgetPasswors1(Request $request)
    {
    //        return $request;
    // die();

    
    $request->validate([
        'otp' => 'required|numeric',
        
    ]);
    $mobile=$request->mobile;

    // Check if OTP matches the session OTP
    if ($request->otp == session('otp')) {
        session()->forget('otp'); // Clear OTP from session
       // return redirect()->intended('customer/dashboard');
       //return view('admin.client-sign',compact('mobile'));
       return redirect()->route('password.reset1', ['mobile' => $mobile]);
    }

    return view('user.otp-sms.invalid');
}

public function showResetForm1(Request $request)
{
    $mobile = $request->query('mobile');
    return view('admin.auth.resetPass',compact('mobile'));
}

public function resetPassword1(Request $request)
{
    // Validate the incoming request
    $request->validate([
        'mobile' => 'required|string', // Ensure the mobile field is present
        'password' => 'required|string|min:8|confirmed',
    ]);

    // Find the user with the matching phone number
    $customer = User::where('phone', $request->mobile)->first();

    if ($customer) {
        // Ensure the password is only hashed once
        $customer->password = $request->password;
        $customer->save();

        // Redirect with success message
        return redirect()->route('admin.login')->with('success', 'Password updated successfully. Please log in with your new password.');
    }

    // If the customer does not exist, redirect back with an error message
    return redirect()->back()->withErrors(['mobile' => 'No account found with this mobile number.']);
}

public function resetPasswordProfile(Request $request)
{

   // return $request;
    // Validate the incoming request
    $request->validate([
        'mobile' => 'required|string', // Ensure the mobile field is present
        'password' => 'required|string|min:8|confirmed',
    ]);

   
    // Find the user with the matching phone number
    $customer = CustomerModel::where('phone', $request->mobile)->first();

    // return $customer;
    // die();

    if ($customer) {
        // Ensure the password is only hashed once
        $customer->password = Hash::make($request->password);
        $customer->save();

        // Redirect with success message
        //return redirect()->route('admin.login')->with('success', 'Password updated successfully. Please log in with your new password.');
        return redirect()->back()->with('success', 'Password updated successfully. Please log in with your new password.');
    }

    // If the customer does not exist, redirect back with an error message
    //return redirect()->back()->withErrors(['mobile' => 'No account found with this mobile number.']);
    return redirect()->back()->with('error', 'No account found with this mobile number.');
}
}