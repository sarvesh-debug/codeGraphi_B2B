<?php

namespace App\Http\Controllers;

use App\Models\CustomerModel;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin/auth.auth-log');
    }
    public function forgetPage()
    {
        return view('admin/auth/forgetPass');
    }
   
public function login(Request $request)
{
   // return $request;die();
    $request->validate([
        'email' => 'required|email', 
        'password' => 'required',
    ]);
   // return $request;die();
    $user = User::where('email', $request->email)->first();

     if ($user && trim($request->password) === $user->password) {
        Auth::login($user);
        //return  "Hello";die();
        $mobile = $user->phone;
        $details = DB::table('business')->where('phone','8303040988')->first();

        session(['adminBalance' => $details->balance ?? 0]);
        session(['business_id' => $details->business_id ?? null]);



         $otp = rand(100000, 999999);
            //$otp=123456;
                session(['otp' => $otp]);

                     // Set mobile number
                        $authorization = 'Utu5smrY82q1PHbiKzLOo6ewEFdv3Zp7ySfBcahIWk4gnJ9xVjWesiIKrTgkmSwZo8LzEHxabcRJACfn';
        $route = 'dlt';
        $sender_id = 'CGTSMS';
        $message = '186957';
        $variables_values = "$otp"; // customize this based on your SMS template
        $numbers = $mobile;

        $response = Http::get('https://www.fast2sms.com/dev/bulkV2', [
            'authorization'     => $authorization,
            'route'             => $route,
            'sender_id'         => $sender_id,
            'message'           => $message,
            'variables_values'  => $variables_values,
            'numbers'           => $numbers,
            'flash'             => '0',
            'schedule_time'     => '',
        ]);

        // Optional: Log SMS API response
        if (!$response->successful()) {
            Log::error('SMS sending failed: ' . $response->body());
        }

        if ($response) {
             return view('admin.auth.logOtp', ['otp' => $otp, 'mobile' => $mobile]);
        }

       

         //return redirect()->intended('/admin/dashboard');

    }

    return redirect()->back()->withErrors(['message' => 'Invalid credentials.']);
}


//     public function login(Request $request)
// {
    
//     // Validate the incoming request
//     $request->validate([
//         'email' => 'required|email', 
//         'password' => 'required',
//     ]);
// $user = User::where('email', $request->email)->first();

// dd([
//     'entered_password' => $request->password,
//     'db_hashed_password' => $user?->password,
//     'check_result' => $user ? Hash::check($request->password, $user->password) : null
// ]);

//     // Fetch the user from the database
//     $user = \App\Models\User::where('email', $request->email)->first();
// // dd(Hash::check($request->password, $user->password));
// dd(User::where('email', $request->email)->first()->password);

// die();
//     // Check if the user exists and verify the password using Hash::check
//     if ($user && Hash::check($request->password, $user->password)) {
//         // Authenticate the user
        
//         Auth::login($user);

//         // Retrieve user mobile number
//         $mobile = $user->phone;

//         $details=DB::table('business')->where('phone',$mobile)->first();
       
//         session(['adminBalance' =>$details->balance]);
//         session(['business_id'=> $details->business_id]);
        
//         // OTP Logic (Commented for now)
//         /*
//         $otp = rand(100000, 999999);
//         session(['otp' => $otp]);

//         // Send OTP via SMS (replace with your SMS API logic)
//         $apikey = "Q5aq9iNxvaSeiOWS";
//         $senderid = "ABHEPY";
//         $message = urlencode("Dear Customer, your login OTP for Abheepay is $otp. TEAM-ABHEEPAY");
        
//         $url = "https://manage.txly.in/vb/apikey.php?apikey=$apikey&senderid=$senderid&number=$mobile&message=$message";

//         // Send the request to the SMS gateway
//         $response = file_get_contents($url);

//         if ($response) {
//             return view('admin.auth.logOtp', ['otp' => $otp, 'mobile' => $mobile]);
//         }
//         */

//         // Redirect based on user role
//         if ($user->role === 'admin') {
//             return redirect()->intended('/admin/dashboard');
//         } else {
//             return redirect()->intended('/user/dashboard');
//         }
//     }

//     // If authentication fails
//     return redirect()->back()->withErrors(['message' => 'Invalid credentials.']);
// }


public function adminVerifyOtp(Request $request)
{
   // return $request;
    $request->validate([
        'otp' => 'required|numeric',
        
    ]);
    //$mobile=$request->mobile;

    // Check if OTP matches the session OTP
    if ($request->otp == session('otp')) {
        session()->forget('otp'); // Clear OTP from session
       // return redirect()->intended('customer/dashboard');
      // return view('admin.client-sign',compact('mobile'));
      return redirect()->intended('/admin/dashboard');
    }

    return view('admin.auth.invalidOtp');

}
    


    // public function login(Request $request)
    // {
    //     // Validate the input fields
    //     $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required',
    //     ]);
    
    //     // Fetch user directly from the database table
    //     $user = DB::table('users')->where('email', $request->email)->first();
    
    //     // Check if the user exists and verify the password
    //     if ($user && Hash::check($request->password, $user->password)) {
    //         // // Redirect based on the user's role
    //         // return $user->role === 'admin'
    //         //     ? redirect()->intended('/admin/dashboard')
    //         //     : redirect()->intended('/user/dashboard');
    //             //return "Ok";
    //             if($user->role==='admin')
    //             {
    //                 //return "1";
    //                 return redirect()->intended('/admin/dashboard');

    //             }
    //             else{
    //                 return "2";

    //             }
    //     }
    
    //     // If login fails, redirect back with an error message
    //     return redirect()->back()->withErrors(['message' => 'Invalid credentials.']);
    // }
    

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function index()
    {
        $totalCustomers = DB::table('customer')->where('role','Retailer')->count();
        $totalD = DB::table('customer')->where('role','distibuter')->count();
        $totalM = DB::table('customer')->count();
        //return view('total-customers', compact('totalCustomers'));
        return view('admin/home-page',compact('totalCustomers','totalD','totalM'));
    }

    public function loginAsCustomer($id)
    {
        // Retrieve the customer by ID
        $customer = CustomerModel::find($id);

        // Check if the customer exists
        if ($customer) {
            // Log out the admin if logged in
           // Auth::guard('admin')->logout();

            // Log the admin in as the customer
            Auth::guard('customer')->login($customer);
           // session(['customer' => $customer]);
            session(['customer' => $customer, 'last_activity' => now()]);
        // session(['outlet'=>$customer->pin]);
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
        session(['lockBalance'=> $customer->LockBalance]);
   session(['packageId'=> $customer->packageId]);
        //Bank Details
        session(['ifsc'=> $customer->ifsc_code]);
        session(['accountNo'=> $customer->account_no]);
        session(['bankName'=> $customer->bank_name]);


            // Redirect to the customer dashboard
            return redirect()->route('customer/dashboard')->with('success', 'Logged in as ' . $customer->name);
        }

        return redirect()->back()->withErrors(['message' => 'Customer not found.']);
    }
public function indexEmp(Request $request)
    {
       $query = User::where('role', 'emp');

    if ($request->has('search') && $request->search != '') {
        $query->where(function($q) use ($request) {
            $q->where('name', 'LIKE', '%'.$request->search.'%')
              ->orWhere('email', 'LIKE', '%'.$request->search.'%');
        });
    }

    $employees = $query->paginate(10);

    return view('admin.employees.index', compact('employees'));

    }
    public function create()
    {
        return view('admin.employees.create');
    }
     public function store(Request $request)
    {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email', // adjust table name if needed
                'phone' => 'required|string',
                'password' => 'required|string|min:6|confirmed', // <-- important
            ]);

       
        $latestId = User::where('role', 'emp')->max('id') ?? 0;
        $username = 'EMP' . ($latestId + 1);
        $subPass=$request->input('password');
        // User::create([
        //     'name' => $request->name,
        //     'username' => $username,
        //     'role' => 'emp',
        //     'email' => $request->email,
        //     'phone' => $request->phone,
        //     'password' => Hash::make(trim($request->password)),

        // ]);
        User::create([
    'name' => $request->name,
    'username' => $username,
    'role' => 'emp',
    'email' => $request->email,
    'phone' => $request->phone,
    'password' => trim($request->password), // 👈 No Hashing
    'subPass' => $subPass, // 👈 No Hashing
]);

        return redirect()->route('employees.index')->with('success', 'Employee Created');
    }

     public function edit($id)
{
    $employee = User::findOrFail($id); // assuming User is your employee model
    return view('admin.employees.edit', compact('employee'));
}


    public function update(Request $request, User $employee)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
        ]);

        // $employee->update([
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'phone' => $request->phone,
        //     'password' => $request->password ? Hash::make($request->password) : $employee->password,
        // ]);
        $employee->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => $request->password ? trim($request->password) : $employee->password, // 👈 No Hashing
        ]);
        return redirect()->route('employees.index')->with('success', 'Employee Updated');
    }

    public function destroy(User $employee)
{
    $employee->forceDelete(); // permanently deletes even if soft deletes are enabled

    return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
}

  public function showChangeEmpinForm()
    {
        return view('admin.auth.change-empin');
    }

    public function updateEmpin(Request $request)
    {
        $request->validate([
            'current_empin' => 'required',
            'new_empin' => 'required|digits:4',
            'confirm_empin' => 'required|same:new_empin',
        ]);

        $user = Auth::user();

        if ($request->current_empin !== $user->empin) {
            return back()->with('error', 'Current Empin does not match.');
        }

        $user->empin = $request->new_empin;
        $user->save();

        return back()->with('success', 'Empin updated successfully.');
    }
}



//     public function login(Request $request)
//     {
//         $request->validate([
//             'email' => 'required',
//             'password' => 'required',
//         ]);

// //dd($request);
//         if (Auth::attempt($request->only('email', 'password'))) {
//             $user = Auth::user();

//             if ($user->role == 'admin') {
//                 // Generate OTP
//                 $otp = rand(100000, 999999);
//                 Session::put('otp', $otp);

//                 // Send OTP to registered email
//                 Mail::raw("Your OTP is: $otp", function ($message) use ($user) {
//                     $message->to($user->email)
//                             ->subject('Admin OTP Verification');
//                 });

//                 return redirect()->route('otp.form');
//             }

//             return redirect()->route('dashboard');
//         }

//         return back()->withErrors(['email' => 'Invalid login credentials.']);
//     }
// }
