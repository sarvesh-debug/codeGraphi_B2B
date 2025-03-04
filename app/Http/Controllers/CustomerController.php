<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomerModel;
use Illuminate\Support\Facades\Auth;
use Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
class CustomerController extends Controller
{
    public function showForm()
    {
        return view('user.auth.index');
    }
    public function addnewForm()
    {
        return view('user.onboard.add-new');
    }
    public function changePassForm()
    {
        return view('user.auth.changePassword');
    }
public function veryfyRetailer(Request $request)
{
    $phone = $request->mobile;

    // Check if the phone number already exists in the 'customer' table
    $customerExists = DB::table('customer')->where('phone', $phone)->exists();

    if ($customerExists) {
        // If the phone number exists, return to the same page with an error message
        return back()->with('error', 'This phone number is already registered.');
    }

   // $mobile=
   // return $mobile;
    //Generate a 6-digit OTP
        $otp = rand(100000, 999999);
        session(['otp' => $otp]);

        // Send OTP via SMS (replace with your SMS API logic)
        $apikey = "Q5aq9iNxvaSeiOWS";
        $senderid = "ABHEPY";
        $mobile = $request->mobile;
        $message = urlencode("Dear Customer your login otp for Abheepay will be $otp TEAM-ABHEEPAY");
        
        $url = "https://manage.txly.in/vb/apikey.php?apikey=$apikey&senderid=$senderid&number=$mobile&message=$message";

        // Send the request to the SMS gateway
        $response = file_get_contents($url);

        if ($response) {
           // return redirect()->route('generate.otp')->with('success', 'OTP sent successfully! Please verify.');
           return view('user.otp-sms.getOtpForm', ['otp' => $otp, 'mobile' => $request->mobile]);
        }

    }
   // return view('admin.client-sign',compact($request));
   //return view('admin.client-sign', ['requestData' => $request->all()]);

   public function store(Request $request)
   {
    // return $request;
    // die();
       // Validate the incoming request
       $request->validate([
        
           'name' => 'required|string|max:255',
           'shop_name' => 'required|string|max:255',
           'mobile' => 'required|string|max:10|unique:users,phone',
           'email' => 'required|email|unique:users,email',
           'password' => 'required|string|min:8|confirmed',
           'balance' => 'required|numeric|min:0',
           'role' => 'required|string|in:Admin,User,Retailer,Distributor',
    
       ]);


       try {
           // Generate a unique username and initialize a pin
           $username = $this->generateUsername();
           $pin = 0;
           $balance=0;
           $role="Retailer";

       
           // Store the user in the database
           CustomerModel::create([
               'name' => $request->name,
               'username' => $username,
               'email' => $request->email,
               'phone' => $request->mobile,
               'pin' => $pin,
               'owner' => $request->shop_name,
               'balance' => $balance,
               'role' => $role,
               'password' => bcrypt($request->password),
              
           ]);

           // If successful, return the success view
           return view('user.otp-sms.welcomeUser', [
               'username' => $request->name,
               'rt_number' => $username // Simulated RT number
           ]);
       } catch (Exception $e) {
           // If an error occurs, return the error view
           return view('user.otp-sms.errorUser', [
               'message' => $e->getMessage()
           ]);
       }
   }

   public function storeKyc(Request $request)
      {

        $username=session('username');
        $user=DB::table('customer')->where('username',$username)->first();
        // // return $user;
        // die();
    //    return $request;
    //    die();
          // Validate the incoming request
          $request->validate([
             
             
             
              'address' => 'required|string|max:255',
              'city' => 'required|string|max:255',
              'state' => 'required|string|max:255',
              'pincode' => 'required|string|max:6',
              'aadhar' => 'required|string|max:12',
              'pan' => 'required|string|max:10',
              'account_no' => 'required|string|max:20',
              'ifsc' => 'required|string|max:11',
              'bank_name' => 'required|string|max:255',

              // File validations
              'aadhar_front' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
              'aadhar_back' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
              'pan_image' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
              'bank_image' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
          ]);
   
        // Check if aadhar_no, pan_no, or email already exists in the 'customer' table
   $aadharExists = DB::table('customer')->where('aadhar_no', $request->aadhar)->exists();
   $panExists = DB::table('customer')->where('pan_no', $request->pan)->exists();
   $emailExists = DB::table('customer')->where('email', $request->email)->exists();
   
   if ($aadharExists || $panExists || $emailExists) {
       $messages = [];
   
       if ($aadharExists) {
           $messages[] = 'This Aadhar number is already registered.';
       }
   
       if ($panExists) {
           $messages[] = 'This PAN number is already registered.';
       }
   
       if ($emailExists) {
           $messages[] = 'This Email address is already registered.';
       }
   
       // Return the error view with all the messages
       return view('user.otp-sms.errorUser', [
           'messages' => $messages
       ]);
   }
   
          try {
              // Generate a unique username and initialize a pin
              $pin = 0;
   
            $aadharFrontPath = $request->file('aadhar_front')->store('uploads/aadhar', 's3');
            $aadharBackPath = $request->file('aadhar_back')->store('uploads/aadhar', 's3');
            $panImagePath = $request->file('pan_image')->store('uploads/pan', 's3');
            $bankImagePath = $request->file('bank_image')->store('uploads/bank', 's3');
    
            // Make the uploaded files publicly accessible
            $aadharFrontUrl = Storage::disk('s3')->url($aadharFrontPath);
            $aadharBackUrl = Storage::disk('s3')->url($aadharBackPath);
            $panImageUrl = Storage::disk('s3')->url($panImagePath);
            $bankImageUrl = Storage::disk('s3')->url($bankImagePath);
   
              // Store the user in the database
              $ok=CustomerModel::where('username', $username)->update([
                'address_aadhar' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'pincode' => $request->pincode,
                'aadhar_no' => $request->aadhar,
                'pan_no' => $request->pan,
                'account_no' => $request->account_no,
                'ifsc_code' => $request->ifsc,
                'bank_name' => $request->bank_name,
                'aadhar_front' => $aadharFrontUrl,
                'aadhar_back' => $aadharBackUrl,
                'pan_image' => $panImageUrl,
                'bank_document' => $bankImageUrl,
                'status'=>'active',
            ]);
            
   
              //return $ok;
              //If successful, return the success view
              return view('user.otp-sms.welcomeKyc', [
                  'username' => $request->name,
                  'rt_number' => $username // Simulated RT number
              ]);
           // return redirect('user.kyc-form');
          } catch (Exception $e) {
              //If an error occurs, return the error view
              return view('user.otp-sms.errorUser', [
                  'message' => $e->getMessage()
              ]);
           // return $e->getMessage();
          }
      }
    


//    public function store(Request $request)
//    {
//     return $request;
//     die();
//        // Validate the incoming request
//        $request->validate([
//            'name' => 'required|string|max:255',
//            'shop_name' => 'required|string|max:255',
//            'mobile' => 'required|string|max:10|unique:users,phone',
//            'email' => 'required|email|unique:users,email',
//            'address' => 'required|string|max:255',
//            'city' => 'required|string|max:255',
//            'state' => 'required|string|max:255',
//            'pincode' => 'required|string|max:6',
//            'aadhar' => 'required|string|max:12',
//            'pan' => 'required|string|max:10',
//            'account_no' => 'required|string|max:20',
//            'ifsc' => 'required|string|max:11',
//            'bank_name' => 'required|string|max:255',
//            'password' => 'required|string|min:8|confirmed',
//            'balance' => 'required|numeric|min:0',
//            'role' => 'required|string|in:Admin,User,Retailer,Distributor',

//            // File validations
//            'aadhar_front' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
//            'aadhar_back' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
//            'pan_image' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
//            'bank_image' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
//        ]);

//      // Check if aadhar_no, pan_no, or email already exists in the 'customer' table
// $aadharExists = DB::table('customer')->where('aadhar_no', $request->aadhar)->exists();
// $panExists = DB::table('customer')->where('pan_no', $request->pan)->exists();
// $emailExists = DB::table('customer')->where('email', $request->email)->exists();

// if ($aadharExists || $panExists || $emailExists) {
//     $messages = [];

//     if ($aadharExists) {
//         $messages[] = 'This Aadhar number is already registered.';
//     }

//     if ($panExists) {
//         $messages[] = 'This PAN number is already registered.';
//     }

//     if ($emailExists) {
//         $messages[] = 'This Email address is already registered.';
//     }

//     // Return the error view with all the messages
//     return view('user.otp-sms.errorUser', [
//         'messages' => $messages
//     ]);
// }

//        try {
//            // Generate a unique username and initialize a pin
//            $username = $this->generateUsername();
//            $pin = 0;

//         //    // Handle file uploads
//         //    $aadharFrontPath = $request->file('aadhar_front')->store('uploads/aadhar', 'public');
//         //    $aadharBackPath = $request->file('aadhar_back')->store('uploads/aadhar', 'public');
//         //    $panImagePath = $request->file('pan_image')->store('uploads/pan', 'public');
//         //    $bankImagePath = $request->file('bank_image')->store('uploads/bank', 'public');
//          // Upload files to AWS S3
//          $aadharFrontPath = $request->file('aadhar_front')->store('uploads/aadhar', 's3');
//          $aadharBackPath = $request->file('aadhar_back')->store('uploads/aadhar', 's3');
//          $panImagePath = $request->file('pan_image')->store('uploads/pan', 's3');
//          $bankImagePath = $request->file('bank_image')->store('uploads/bank', 's3');
 
//          // Make the uploaded files publicly accessible
//          $aadharFrontUrl = Storage::disk('s3')->url($aadharFrontPath);
//          $aadharBackUrl = Storage::disk('s3')->url($aadharBackPath);
//          $panImageUrl = Storage::disk('s3')->url($panImagePath);
//          $bankImageUrl = Storage::disk('s3')->url($bankImagePath);

//            // Store the user in the database
//            CustomerModel::create([
//                'name' => $request->name,
//                'username' => $username,
//                'email' => $request->email,
//                'phone' => $request->mobile,
//                'pin' => $pin,
//                'owner' => $request->shop_name,
//                'balance' => $request->balance,
//                'role' => $request->role,
//                'password' => bcrypt($request->password),
//                'address_aadhar' => $request->address,
//                'city' => $request->city,
//                'state' => $request->state,
//                'pincode' => $request->pincode,
//                'aadhar_no' => $request->aadhar,
//                'pan_no' => $request->pan,
//                'account_no' => $request->account_no,
//                'ifsc_code' => $request->ifsc,
//                'bank_name' => $request->bank_name,
//                'aadhar_front' => $aadharFrontUrl,
//                'aadhar_back' => $aadharBackUrl,
//                'pan_image' => $panImageUrl,
//                'bank_document' => $bankImageUrl,
//            ]);

//            // If successful, return the success view
//            return view('user.otp-sms.welcomeUser', [
//                'username' => $request->name,
//                'rt_number' => $username // Simulated RT number
//            ]);
//        } catch (Exception $e) {
//            // If an error occurs, return the error view
//            return view('user.otp-sms.errorUser', [
//                'message' => $e->getMessage()
//            ]);
//        }
//    }


   public function addUserbyAdmin(Request $request)
   { 
    // return $request;
    // die();

 
    //    $request->validate([
    //        'name' => 'required|string|max:255',
    //        'owner' => 'required|string|max:255',
    //        'phone' => 'required|string|max:15',
    //        'email' => 'required|email',
    //        'address' => 'required|string|max:255',
    //        'city' => 'required|string|max:100',
    //        'state' => 'required|string|max:100',
    //        'pincode' => 'required|numeric',
    //        'aadhar_no' => 'required|numeric|digits:12',
    //        'pan_no' => 'required|string|max:10',
    //        'account_no' => 'required|string|max:20',
    //        'ifsc_code' => 'required|string|max:20',
    //        'bank_name' => 'required|string|max:100',
    //        'password' => 'required|confirmed|min:8',
    //        'role' => 'required|string|max:50',
    //        'balance' => 'required|numeric',
    //        'dis_no'=>'required',
    //        'dis_name'=>'required',
    //        'aadhar_front' => 'nullable|image|mimes:jpeg,png,jpg',
    //        'aadhar_back' => 'nullable|image|mimes:jpeg,png,jpg',
    //        'pan_image' => 'nullable|image|mimes:jpeg,png,jpg',
    //        'bank_document' => 'nullable|image|mimes:jpeg,png,jpg',
    //    ]);
   
       $role = $request->role;
      
       try {
           // Generate a unique username and initialize a pin
           $username = $this->generateUsernameby($role);
           $pin = 0;
           $balance=0;
        //    return $username;
        //    die();
           // Handle file uploads
        //    $aadharFrontPath = $request->file('aadhar_front') ? $request->file('aadhar_front')->store('uploads/aadhar', 's3') : null;
        //    $aadharBackPath = $request->file('aadhar_back') ? $request->file('aadhar_back')->store('uploads/aadhar', 's3') : null;
        //    $panImagePath = $request->file('pan_image') ? $request->file('pan_image')->store('uploads/pan', 's3') : null;
        //    $bankImagePath = $request->file('bank_document') ? $request->file('bank_document')->store('uploads/bank', 's3') : null;
   
        //    // Make the uploaded files publicly accessible
        //    $aadharFrontUrl = $aadharFrontPath ? Storage::disk('s3')->url($aadharFrontPath) : null;
        //    $aadharBackUrl = $aadharBackPath ? Storage::disk('s3')->url($aadharBackPath) : null;
        //    $panImageUrl = $panImagePath ? Storage::disk('s3')->url($panImagePath) : null;
        //    $bankImageUrl = $bankImagePath ? Storage::disk('s3')->url($bankImagePath) : null;
   
           // Store the user in the database
           CustomerModel::create([
               'name' => $request->name,
               'username' => $username,
               'email' => $request->email,
               'phone' => $request->phone,
               'dis_phone'=>$request->dis_no ?? 'Admin',
               'dis_name'=>$request->dis_name ?? 'Admin',
               'pin' => $pin,
               'owner' => $request->owner,
               'balance' => $balance,
               'role' => $request->role,
               'password' => bcrypt($request->password),
            //    'address_aadhar' => $request->address,
            //    'city' => $request->city,
            //    'state' => $request->state,
            //    'pincode' => $request->pincode,
            //    'aadhar_no' => $request->aadhar_no, // Fixed key
            //    'pan_no' => $request->pan_no,       // Fixed key
            //    'account_no' => $request->account_no,
            //    'ifsc_code' => $request->ifsc_code,
            //    'bank_name' => $request->bank_name,
            //    'aadhar_front' => $aadharFrontUrl,
            //    'aadhar_back' => $aadharBackUrl,
            //    'pan_image' => $panImageUrl,
            //    'bank_document' => $bankImageUrl,
           ]);
   
           return redirect()->back()->with('success', 'Add '.$role.' completed successfully!');
       } catch (Exception $e) {
           return redirect()->back()->with('error', 'Add '.$role.' failed. Please try again.'.$e);
       }
   }
   
   

    // public function store(Request $request)  
    // {
    //     // Validate the incoming request
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'shop_name' => 'required|string|max:255',
    //         'mobile' => 'required|string|max:10|unique:users,phone',
    //         'email' => 'required|email|unique:users,email',
    //         'address' => 'required|string|max:255',
    //         'city' => 'required|string|max:255',
    //         'state' => 'required|string|max:255',
    //         'pincode' => 'required|string|max:6',
    //         'aadhar' => 'required|string|max:12',
    //         'pan' => 'required|string|max:10',
    //         'account_no' => 'required|string|max:20',
    //         'ifsc' => 'required|string|max:11',
    //         'bank_name' => 'required|string|max:255',
    //         'password' => 'required|string|min:8|confirmed',
    //         'balance' => 'required|numeric|min:0',
    //         'role' => 'required|string|in:Admin,User,Retailer,Distributor',
    
    //         // File validations
    //         'aadhar_front' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
    //         'aadhar_back' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
    //         'pan_image' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
    //         'bank_image' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
    //     ]);
    
    //     // Generate a unique username
    //     $username = $this->generateUsername();
    // $pin=0;
    //     // Handle file uploads
    //     $aadharFrontPath = $request->file('aadhar_front')->store('uploads/aadhar', 'public');
    //     $aadharBackPath = $request->file('aadhar_back')->store('uploads/aadhar', 'public');
    //     $panImagePath = $request->file('pan_image')->store('uploads/pan', 'public');
    //     $bankImagePath = $request->file('bank_image')->store('uploads/bank', 'public');
    
    //     // Store the user in the database
    //     CustomerModel::create([
    //         'name' => $request->name,
    //         'username' => $username,
    //         'email' => $request->email,
    //         'phone' => $request->mobile, // Using 'mobile' for phone
    //        'pin'=>$pin,
    //         'owner' => $request->shop_name, // Mapping 'shop_name' to 'owner'
    //         'balance' => $request->balance,
    //         'role' => $request->role,
    //         'password' => bcrypt($request->password),
    //         'address_aadhar' => $request->address, 
    //         'city' => $request->city,
    //         'state' => $request->state,
    //         'pincode' => $request->pin,
    //         'aadhar_no' => $request->aadhar,
    //         'pan_no' => $request->pan,
    //         'account_no' => $request->account_no,
    //         'ifsc_code' => $request->ifsc,
    //         'bank_name' => $request->bank_name,
    
    //         // File upload paths
    //         'aadhar_front' => $aadharFrontPath,
    //         'aadhar_back' => $aadharBackPath,
    //         'pan_image' => $panImagePath,
    //         'bank_document' => $bankImagePath,
    //     ]);
    
    //     // Redirect to the customer login route with a success message
    //     return view('');
    // }
    

    
    
    /**
     * Generate a unique username with the format 'PMLT' + 6 random digits
     *
     * @return string
     */
    // protected function generateUsername()
    // {
    //     $prefix = 'PMLT';
    //     $randomNumber = mt_rand(100000, 999999); // Generate a 6-digit random number
    //     return $prefix . $randomNumber;
    // }
    protected function generateUsername()
{
    $prefix = 'ZPR';
    do {
        $randomNumber = mt_rand(100000, 999999); // Generate a 6-digit random number
        $username = $prefix . $randomNumber;
    } while (CustomerModel::where('username', $username)->exists()); // Check for uniqueness

    return $username;
} 
protected function generateUsernameby($role)
{
    // if($role==='distibuter')
    // {
    //     $prefix = 'ZPD';
    // }
    // elsegenerateUsernameby
    // {
    //     $prefix = 'ZPR';
    // }
    $prefix = ($role === 'distibuter') ? 'ZPD' : 'ZPR';
    
    do {
        $randomNumber = mt_rand(100000, 999999); // Generate a 6-digit random number
        $username = $prefix . $randomNumber;
    } while (CustomerModel::where('username', $username)->exists()); // Check for uniqueness

    return $username;
}  
// public function login(Request $request)
// {
//     // Validate the request
//     $request->validate([
//         'phone' => 'required|numeric',
//         'password' => 'required',
//     ]);

//     // Retrieve the customer by phone number
//     $customer = CustomerModel::where('phone', $request->phone)->first();

//     // Check if customer exists and the "password" matches the hashed password
//     if ($customer && Hash::check($request->password, $customer->password)) {
//         // Log the customer in using the Auth facade and custom guard
//         Auth::guard('customer')->login($customer);

//         // Store necessary customer details in the session
//         session([
//             'customer' => $customer,
//             'last_activity' => now(),
//             'outlet' => (int)$customer->pin,
//             'username' => $customer->username,
//             'user_name' => $customer->name,
//             'mobile' => $customer->phone,
//             'id' => $customer->id,
//         ]);

//         // Generate a 6-digit OTP
//         $otp = rand(100000, 999999);
//         session(['otp' => $otp]);

//         // Send OTP via SMS (replace with your SMS API logic)
//         $apikey = "Q5aq9iNxvaSeiOWS";
//         $senderid = "ABHEPY";
//         $mobile = $customer->phone;
//         $message = urlencode("Dear Customer your login otp for Abheepay will be $otp TEAM-ABHEEPAY");
        
//         $url = "https://manage.txly.in/vb/apikey.php?apikey=$apikey&senderid=$senderid&number=$mobile&message=$message";

//         // Send the request to the SMS gateway
//         $response = file_get_contents($url);

//         if ($response) {
//            // return redirect()->route('generate.otp')->with('success', 'OTP sent successfully! Please verify.');
//            return view('user.otp-sms.getOtpForm', ['otp' => $otp, 'phone' => $customer->phone]);
//         }

//         return redirect()->back()->withErrors(['otp' => 'Failed to send OTP. Please try again.']);
//     }

//     // Return back with error message if credentials are incorrect
//     return redirect()->back()->withErrors(['phone' => 'Invalid login credentials.']);
// }



public function login(Request $request)
{
    // Validate the request
    $request->validate([
        'phone' => 'required|numeric',
        'password' => 'required',
    ]);

    // Retrieve the customer by phone number
    $customer = CustomerModel::where('phone', $request->phone)->first();

    // Check if customer exists and the "password" matches the hashed password
    if ($customer && Hash::check($request->password, $customer->password)) {
        // Log the customer in using the Auth facade and custom guard
        Auth::guard('customer')->login($customer);

        // Store the customer and the current time in the session
        session(['customer' => $customer, 'last_activity' => now()]);
        // session(['outlet'=>$customer->pin]);
        session(['outlet' => (int)$customer->pin]);
        session(['username'=> $customer->username]);
        session(['user_name'=> $customer->name]);
        session(['mobile'=> $customer->phone]);
        session(['id'=> $customer->id]);
        session(['role'=> $customer->role]);
        session(['balance'=> $customer->balance]);
        session(['dis_phone'=> $customer->dis_phone]);
        session(['adhar_no'=> $customer->aadhar_no]);
        session(['email'=> $customer->email]);
        session(['mpin'=> $customer->mpin]);
        session(['txnpin'=> $customer->txnpin]);

        $deviceId=md5(string: request()->ip() . request()->header('User-Agent'));
        $today = Carbon::today();
        $mobile=$customer->phone;

       
        
        // Redirect to customer dashboard or intended page
        // if($customer->role==="Retailer"){
        //     return redirect()->intended('customer/dashboard');
        // }
        // elseif($customer->role==="distibuter"){
            
        //     return redirect()->intended('/distibuter/dashboard');
        // }
        if ($customer->status==="active") {

            $existingLogin = CustomerModel::where('phone', $mobile)
        ->where('device_id', $deviceId)
        ->whereDate('sent_date', $today)
        ->first();

       if($existingLogin)
       {
        return redirect()->intended('customer/dashboard');
       }
       else
       {
    //     $otp = rand(100000, 999999);
    //     session(['otp' => $otp]);

    //     // Send OTP via SMS (replace with your SMS API logic)
    //     $apikey = "Q5aq9iNxvaSeiOWS";
    //     $senderid = "ABHEPY";
    //     $mobile=$customer->phone;
    //     $message = urlencode("Dear Customer your login otp for Abheepay will be $otp TEAM-ABHEEPAY");
        
    //     $url = "https://manage.txly.in/vb/apikey.php?apikey=$apikey&senderid=$senderid&number=$mobile&message=$message";

    //     // Send the request to the SMS gateway
    //     $response = file_get_contents($url);

    //     // CustomerModel::where('phone', $mobile)->update([
    //     //     'device_id' => $deviceId,
    //     //     'otp' => $otp,
    //     //     'verified' => false,
    //     //     'sent_date' => $today,
    //     // ]);
        

    //     if ($response) {
    //        // return redirect()->route('generate.otp')->with('success', 'OTP sent successfully! Please verify.');
    //        return view('user.auth.logOtp', ['otp' => $otp, 'mobile' => $mobile]);
    //     }

    //    }

            return redirect()->intended('customer/dashboard');


        } 
    }
        else {
            return redirect()->back()->withErrors(['phone' => 'Retailer is not active Please connect Distibutor.']); 
        }
        
       // return redirect()->intended('customer/dashboard');
        
    }

    // Return back with error message if credentials are incorrect
    return redirect()->back()->withErrors(['phone' => 'Invalid login credentials.']);
}

public function oneVerifyOtp(Request $request)
{
    // return $request;
    // die();
    $deviceId=md5(string: request()->ip() . request()->header('User-Agent'));
        $today = Carbon::today();
        $mobile=$request->mobile;
   // return $request;
    $request->validate([
        'otp' => 'required|numeric',
        
    ]);
    //$mobile=$request->mobile;
   $ok= CustomerModel::where('phone', $mobile)->update([
        'device_id' => $deviceId,
        'otp' => $request->otp,
        'verified' => true,
        'sent_date' => $today,
    ]);
// return $ok;
// die();
    // Check if OTP matches the session OTP
    if ($request->otp == session('otp')) {
        session()->forget('otp'); // Clear OTP from session
       // return redirect()->intended('customer/dashboard');
      // return view('admin.client-sign',compact('mobile'));
      return redirect()->intended('customer/dashboard');
    }

    return view('admin.auth.invalidOtp');

}

public function logout(Request $request)
{
    Auth::guard('customer')->logout();
    session()->forget(['customer', 'last_activity']);
    return redirect()->route('customer.login')->with('status', 'You have been logged out.');
}



public function verifyPin(Request $request)
{
    $request->validate([
        'pin' => 'required|string',
    ]);

    $customer = Auth::guard('customer')->user();

    // Verify the entered PIN matches the customer's stored PIN
    if ($customer->pin === $request->pin) {
        return redirect()->intended('customer/dashboard');  // Redirect to dashboard
    }

    // If PIN is incorrect
    return redirect()->back()->withErrors(['pin' => 'Invalid PIN entered.']);
}

public function showUser(Request $request)
{
    $role = $request->input('role');
    $status = $request->input('status');

    // Query the customers based on role and status if provided
    $customers = CustomerModel::when($role, function ($query, $role) {
            return $query->where('role', $role);
        })
        ->when($status, function ($query, $status) {
            return $query->where('status', $status);
        })
        ->orderBy('id', 'desc')
        ->get();

        $disList = CustomerModel::where('role', 'distibuter')->get();
    // Count individual totals
    $totalRetailers = CustomerModel::where('role', 'Retailer')->count();
    $totalDistributors = CustomerModel::where('role', 'distibuter')->count();
    $totalActive = CustomerModel::where('status', 'Active')->count();
    $totalDeactive = CustomerModel::where('status', 'Deactive')->count();
    $total = CustomerModel::count();

    return view('admin.user-details.user-list', compact(
        'customers', 
        'disList',
        'totalRetailers', 
        'totalDistributors', 
        'totalActive', 
        'totalDeactive',
        'total'
    ));
}


public function showUserLock(Request $request)
{
    $role = $request->input('role');
    $status = $request->input('status');

    // Query the customers based on role and status if provided
    $customers = CustomerModel::when($role, function ($query, $role) {
            return $query->where('role', $role);
        })
        ->when($status, function ($query, $status) {
            return $query->where('status', $status);
        })
        ->orderBy('id', 'desc')
        ->get();

        $disList = CustomerModel::where('role', 'distibuter')->get();
    // Count individual totals
    $totalRetailers = CustomerModel::where('role', 'Retailer')->count();
    $totalDistributors = CustomerModel::where('role', 'distibuter')->count();
    $totalActive = CustomerModel::where('status', 'Active')->count();
    $totalDeactive = CustomerModel::where('status', 'Deactive')->count();
    $total = CustomerModel::count();

    return view('admin.user-details.lockReleseAmt', compact(
        'customers', 
        'disList',
        'totalRetailers', 
        'totalDistributors', 
        'totalActive', 
        'totalDeactive',
        'total'
    ));
}
public function updateServices(Request $request, $id)
{
    $customer = CustomerModel::findOrFail($id);

    // Update the service columns based on form input
    $customer->aeps = $request->has('aeps') ? 1 : 0;
    $customer->dmt = $request->has('dmt') ? 1 : 0;
    $customer->dmt2 = $request->has('dmt2') ? 1 : 0;
    $customer->payout = $request->has('payout') ? 1 : 0;
    $customer->cc_bill_payment = $request->has('cc_bill_payment') ? 1 : 0;
    $customer->pan = $request->has('pan') ? 1 : 0;
    $customer->cc_links = $request->has('cc_links') ? 1 : 0;

    $customer->save();
//return $request;
    return redirect()->back()->with('success', 'Services updated successfully.');
}
public function updateServicesD(Request $request, $id)
{
    $customer = CustomerModel::findOrFail($id);

    // Update the service columns based on form input
    $customer->aeps = $request->has('aeps') ? 1 : 0;
    $customer->dmt = $request->has('dmt') ? 1 : 0;
    $customer->dmt2 = $request->has('dmt2') ? 1 : 0;
    $customer->payout = $request->has('payout') ? 1 : 0;
    $customer->cc_bill_payment = $request->has('cc_bill_payment') ? 1 : 0;
    $customer->pan = $request->has('pan') ? 1 : 0;
    $customer->cc_links = $request->has('cc_links') ? 1 : 0;

    $customer->save();
//return $request;
    return redirect()->back()->with('success', 'Services updated successfully.');
}

public function edit($id)
{
    // Retrieve the user by ID
    $user = CustomerModel::findOrFail($id);

    // Pass the user data to the edit view
    return view('admin.user-details.user-edit', compact('user'));
}

public function update(Request $request, $id)
{
    // Retrieve the user by ID
    $user = CustomerModel::findOrFail($id);

    // Debug log for existing username
    logger()->info('Existing Username:', ['username' => $user->username]);

    // Check if the role is distributor and adjust username prefix
    if ($request->role == "distibuter" && str_starts_with($user->username, 'ZPR')) {
        $user->username = preg_replace('/^ZPR/', 'ZPD', $user->username);
    }

    // Handle file uploads only if files are provided
    $aadharFrontUrl = $user->aadhar_front;
    $aadharBackUrl = $user->aadhar_back;
    $panImageUrl = $user->pan_image;
    $bankImageUrl = $user->bank_document;

    if ($request->hasFile('aadhar_front')) {
        $aadharFrontPath = $request->file('aadhar_front')->store('uploads/aadhar', 's3');
        $aadharFrontUrl = Storage::disk('s3')->url($aadharFrontPath);
    }

    if ($request->hasFile('aadhar_back')) {
        $aadharBackPath = $request->file('aadhar_back')->store('uploads/aadhar', 's3');
        $aadharBackUrl = Storage::disk('s3')->url($aadharBackPath);
    }

    if ($request->hasFile('pan_image')) {
        $panImagePath = $request->file('pan_image')->store('uploads/pan', 's3');
        $panImageUrl = Storage::disk('s3')->url($panImagePath);
    }

    if ($request->hasFile('bank_document')) {
        $bankImagePath = $request->file('bank_document')->store('uploads/bank', 's3');
        $bankImageUrl = Storage::disk('s3')->url($bankImagePath);
    }

    // Update the user's data
    $user->update([
        'name' => $request->name,
        'owner' => $request->owner,
        'phone' => $request->phone,
        'email' => $request->email,
        'address_aadhar' => $request->address,
        'city' => $request->city,
        'state' => $request->state,
        'pincode' => $request->pincode,
        'aadhar_no' => $request->aadhar_no,
        'pan_no' => $request->pan_no,
        'account_no' => $request->account_no,
        'ifsc_code' => $request->ifsc_code,
        'bank_name' => $request->bank_name,
        'pin' => $request->pin,
        'balance' => $request->balance,
        'role' => $request->role,
        'aadhar_front' => $aadharFrontUrl,
        'aadhar_back' => $aadharBackUrl,
        'pan_image' => $panImageUrl,
        'bank_document' => $bankImageUrl,
    ]);

    // Redirect with success message
    return redirect()->route('admin/user-list')->with('success', $request->role.' updated successfully.');
}

public function listData()
{
    $dis_no = session('mobile');

    // return $dis_no;
    // die();
    $customers = CustomerModel::where('dis_phone', $dis_no)->orderBy('id', 'desc')->get();

    // Pass the data to the view
    return view('user.onboard.all-list', compact('customers'));
}

public function active($id)
    {
        // Find the customer by ID
        $customer = CustomerModel::findOrFail($id);

        // Toggle the status
        $customer->status = ($customer->status === 'active') ? 'deactive' : 'active';
        $customer->save();


        // Redirect or respond accordingly
        return redirect()->back()->with('success', 'Customer status updated successfully.');
    }


    public function approveFund(Request $request)
    {
        $adminBalance=session('adminBalance');
         // Extract the required data from the request
    $mobile = $request->phone;
    $idCode = $request->id_code;
    $amount = $request->amount;
    $id=$request->id;
    //Get Data 
    if ($adminBalance < $amount) {
        return view('admin.wallet.send', ['status' => 'blance']);
    }
    $getData = DB::table('customer')
        ->where('phone', $mobile)
        ->where('username', $idCode)
        ->first();
        $opB= $getData->balance;
        $clB=$opB+$amount;
            //dd($opB,$clB);
        //die();
    // Update the customer's balance
    $balanceUpdated = DB::table('customer')
        ->where('phone', $mobile)
        ->where('username', $idCode)
        ->increment('balance', $amount);

        DB::table('business')
        ->where('business_id', session('business_id'))
        ->decrement('balance', $amount);    

$balanceAd = DB::table('business')
->where('business_id', session('business_id'))
->value('balance');
// Store the retrieved balance in the session
session(['adminBalance'=> $balanceAd]);
    // Update the status to 1 in the associated table (e.g., `add_moneys`)
    $statusUpdated = DB::table('add_moneys')
        ->where('phone', $mobile)
        ->where('id', $id)
        ->update([
            'status' => 1,
            'openingBalance'=>$opB,
            'closingBalance'=>$clB
        ]);

    // Check if both updates were successful
    if ($balanceUpdated && $statusUpdated) {
        // Return success message
        return redirect()->back()->with('success', 'Successfully Approved!');
    } else {
        // Return error message if either update failed
        return redirect()->back()->with('error', 'Approval Failed. Please try again.');
    }


    }
    public function rejectFund(Request $request)
    {
        // return $request;
        // die();
         // Extract the required data from the request
  
    $id=$request->id;
    $remark=$request->remark;


    // Update the status to 1 in the associated table (e.g., `add_moneys`)
    $record = DB::table('add_moneys')->where('id', $id)->first();

if ($record) {
    $currentUtr = $record->utr;

    // Check if UTR already contains '_Rejected'
    if (strpos($currentUtr, '_Rejected') !== false) {
        preg_match_all('/_Rejected(\d*)$/', $currentUtr, $matches);

        // Get the last number and increment it
        $lastNumber = isset($matches[1][0]) && is_numeric($matches[1][0]) ? (int)$matches[1][0] : 0;
        $newUtr = preg_replace('/_Rejected\d*$/', '_Rejected' . ($lastNumber + 1), $currentUtr);
    } else {
        $newUtr = $currentUtr . '_Rejected1';
    }

    $statusUpdated = DB::table('add_moneys')
        ->where('id', $id)
        ->update([
            'status' => -1,
            'remark' => $remark,
            'utr' => $newUtr
        ]);
}



    // Check if both updates were successful
    if ( $statusUpdated) {
        // Return success message
        return redirect()->back()->with('success', 'Successfully Rejected!');
    } else {
        // Return error message if either update failed
        return redirect()->back()->with('error', 'Rejection Failed. Please try again.');
    }

    }


    public function disCommission()
{
    $dis_no = session('mobile');

    // return $dis_no;
    // die();
    $customers = DB::table('dis_commission')->where('dis_no', $dis_no)->orderBy('id', 'desc')->get();
// return $customers;
//     die();
    //Pass the data to the view
    return view('user.onboard.disCommission', compact('customers'));
}

public function adminMapp(Request $request)
{
    //  return $request;
    //     die();
    // Retrieve inputs from request
    $retailerId = $request->id;
    
    $disPhone = $request->distributor;
    $disNameget = CustomerModel::where('phone', $disPhone)->first();
    // return $disNameget->name;
    // die();
    $disName=$disNameget->name ?? 'Admin';
    // Find the customer by username (retailerId)
    $customer = CustomerModel::where('username', $retailerId)->first();

    // Check if customer exists
    if ($customer) {
        // Update the distributor's name and phone number
        $customer->dis_name = $disName;
        $customer->dis_phone = $disPhone;

        $ok=$customer->save();
        // return $ok;
        // die();
        // Save the changes
        if ($customer->save()) {
            // Return the updated customer details in the response
            return redirect()->back()->with('success', 'Retailer Mapping updated successfully');
            
        } else {
        
            return redirect()->back()->with('error', 'Failed to update Retailer Mapping.');
        }
    }

    // Return an error if customer with given username not found
    return redirect()->back()->with('error', 'Retailer not found.');

}


public function getProfile()
{
    $phone = session('mobile');
    $getprofile = CustomerModel::where('phone', $phone)->first();

    if ($getprofile) {
        return view('user.include.profile', ['profile' => $getprofile]);
    } else {
        return redirect()->back()->with('error', 'Profile not found.');
    }
}
    
// public function showServices()
// {
//     $customer = session('customer');
    
//     // Fetch services that are active and belong to the current customer
//     $activeServices = CustomerModel::where('id', $customer->id)
//                               ->where('active', 1)
//                               ->get();
    
//     return view('user.services', compact('activeServices', 'customer'));
// }

public function getMpin(Request $request)
{
    $mpin = CustomerModel::getMpin();
    return response()->json(['mpin' => $mpin]);
}
public function changeMpin(Request $request)
{
    
    $request->validate([
        'mobile' => 'required',
        'old_mpin' => 'required',
        'new_mpin' => 'required|min:4|max:4',
    ]);

    $user = CustomerModel::where('phone', $request->mobile)->first();

    if (!$user || $user->mpin !== $request->old_mpin) {
        return back()->with('error', 'Old MPIN is incorrect.');
    }

    // Update MPIN
    $user->update(['mpin' => $request->new_mpin]);
    session(['mpin'=> $request->new_mpin]);
    return back()->with('success', 'MPIN updated successfully.');
}

}
