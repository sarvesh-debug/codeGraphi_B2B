<?php

namespace App\Http\Controllers;

use App\Models\Kyc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Response;
use Illuminate\Support\Facades\DB;
class KycController extends Controller
{
    // Show KYC form
    public function create()
    {
        return view('admin.kyc.kyc-form');
    }

    public function userCreate()
    {
        $mobile = session('mobile');
       $remitterData= DB::table('customer')
        ->where('phone', $mobile)
        ->first();
       // return $remitterData;
        return view('user/kyc.appy_kyc',compact('remitterData'));
    }
    // Store KYC form submission
    public function store(Request $request)
{
    $request->validate([
        'mobile' => 'required|string',
        'email' => 'required|email',
        'aadhaar' => 'required|string',
        'pan' => 'required|string',
        'bankAccountNo' => 'required|string',
        'bankIfsc' => 'required|string',
        'latitude' => 'required|string',
        'longitude' => 'required|string',
        'consent' => 'required|string|in:Y,N',
    ]);

    // Send data to the API with 180 seconds timeout
    $responseData = Http::withHeaders([
        'Content-Type' => 'application/json',
    ])->timeout(180)->post(env('liveUrl') . 'user/onboard/signup', [
        'mobile' => $request->mobile,
        'email' => $request->email,
        'aadhaar' => $request->aadhaar,
        'pan' => $request->pan,
        'bankAccountNo' => $request->bankAccountNo,
        'bankIfsc' => $request->bankIfsc,
        'latitude' => $request->latitude,
        'longitude' => $request->longitude,
        'consent' => $request->consent,
    ]);

    $otpReferenceID = $responseData['otpReferenceID'] ?? null;
    $hash = $responseData['hash'] ?? null;
    $msg = $responseData['status'] ?? $responseData['message'] ?? ''; // status or message fallback

//return $responseData;die();
    return view('user.marchant-onboard.signup_validate', [
        'otpReferenceID' => $otpReferenceID,
        'hash' => $hash,
        'msg' => $msg,
    ]);
}

   
    public function getAllData(Request $request)
    {
        // Retrieve all KYC records
        $users = Kyc::all(); 
    
     // Check if there are no records
    if ($users->isEmpty()) {
        return response()->json([
            'status' => 'error',
            'message' => 'No KYC records found'
        ], 404);
    }

    // Handle JSON and view responses
    if ($request->expectsJson()) {
        return response()->json([
            'status' => 'success',
            'data' => $users
        ], 200);
    }
    
        // Otherwise, return the view for HTML rendering
        return view('admin/kyc.kyc-all-list', compact('users'));
    }
    


    public function showKycDetails() 
{
    // Retrieve the customer from the session
    $customer = session('customer');
    
    // Ensure the customer is available in the session
    if (!$customer) {
        return redirect()->back()->with('error', 'User not logged in.');
    }

    // Get the customer ID using the username from the session
    $customerId = $customer->username; // Assuming 'username' is stored in the session
    
    // Retrieve the KYC details using the customer ID
    $kycDetails = Kyc::where('username', $customerId)->first();
    
    // Check if KYC details are available
    if (!$kycDetails) {
        return redirect()->back()->with('error', 'No KYC details found.');
    }

    // Check if KYC is done
    if ($kycDetails->done == 0) {
        // If KYC is pending, return a view with a script to show the alert
        return view('user.kyc.kyc-pending');
    }

    // Return the KYC details view if KYC is done
    return view('user.kyc.kyc-details', compact('kycDetails'));
}

    


    // Admin
    public function show($id)
    {
        // Retrieve user by ID
        $user = Kyc::findOrFail($id); // Change 'User' to the appropriate model if different

        // Return the view with user data
        return view('admin.kyc.preview-kyc', compact('user'));
    }



    public function update(Request $request, $id) 
    {
        // Validate the request
        $request->validate([
            'status' => 'required|in:ok,not_ok',
        ]);
    
        // Find the KYC record
        $kyc = Kyc::findOrFail($id);
   // return $request;
        // Update the KYC status based on the provided status
        $kyc->done = $request->status === 'ok' ? 1 : 0; // Assuming 'done' is an integer (0 or 1)
        
        // Save the updated KYC record
        $kyc->save();
    
        // Redirect back with success message, including the KYC ID in the route
        return redirect()->route('admin/kyc.details', ['id' => $id])->with('success', 'KYC status updated successfully.');
    }
    

   


}
