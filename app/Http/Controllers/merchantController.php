<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Response;
use App\Models\CustomerModel;
use Illuminate\Support\Facades\DB;
class merchantController extends Controller
{
    public function showSignupForm()
    {
        return view('user.marchant-onboard.signup_initiate');
    }
    public function showOtpMobile()
    {
        return view('user.marchant-onboard.changeMobile');
    }
//     public function initiateSignup(Request $request) 
// {
//     $request->validate([
//         'mobile' => 'required|string',
//         'email' => 'required|email',
//         'aadhaar' => 'required|string',
//         'pan' => 'required|string',
//         'bankAccountNo' => 'required|string',
//         'bankIfsc' => 'required|string',
//         'latitude' => 'required|string',
//         'longitude' => 'required|string',
//         'consent' => 'required|string|in:Y,N',
//     ]);

//     // Encrypt Aadhaar Number
//     $aadhaarNumber = $request->aadhaar;
//     $encryptionKey = env('IPAY_KEY');
//     $ivlen = openssl_cipher_iv_length('aes-256-cbc');
//     $iv = openssl_random_pseudo_bytes($ivlen);
//     $ciphertext = openssl_encrypt($aadhaarNumber, 'aes-256-cbc', $encryptionKey, OPENSSL_RAW_DATA, $iv);
//     $encryptedData = base64_encode($iv . $ciphertext);

//     // Send data to the API
//     $response = Http::withHeaders([
//         'X-Ipay-Auth-Code' => env('IPAY_AUTH_CODE'),
//         'X-Ipay-Client-Id' => env('IPAY_CLIENT_ID'),
//         'X-Ipay-Client-Secret' => env('IPAY_CLIENT_SECRET'),
//         'X-Ipay-Endpoint-Ip' => env('IPAY_ENDPOINT_IP'),
//         'Content-Type' => 'application/json',
//     ])->post('https://api.instantpay.in/user/outlet/signup/initiate', [
//         'mobile' => $request->mobile,
//         'email' => $request->email,
//         'aadhaar' => $encryptedData,
//         'pan' => $request->pan,
//         'bankAccountNo' => $request->bankAccountNo,
//         'bankIfsc' => $request->bankIfsc,
//         'latitude' => $request->latitude,
//         'longitude' => $request->longitude,
//         'consent' => $request->consent,
//     ]);

//     if ($response->successful()) {
//         $responseData = $response->json();

//         return response()->json([
//             'success' => true,
//             'data' => $responseData
//         ]);
//     }

//     return response()->json([
//         'success' => false,
//         'error' => 'Failed to initiate signup.',
//         'response' => $response->json()
//     ]);
// }


public function mobileValidateOtp(Request $request)
{
  
    $response = Http::withHeaders([
        
        'Content-Type' => 'application/json',
    ])->post(env('liveUrl') .'user/onboard/mobileChange', [
        'existingMobileNumber' => $request->existingMobileNumber,
        'newMobileNumber' => $request->newMobileNumber,
       
    ]);
    // return $response->json();
    // die();
    
        $responseData = $response->json();

        // Check for error statuscode
        // if (isset($responseData['statuscode']) && $responseData['statuscode'] === 'ERR') {
        //     $errorMessage = $responseData['status'] ?? $responseData['message'];

        //     return view('user.marchant-onboard.mobile_validate', [
        //         'error' => $errorMessage,
        //         'existingMobileNumber'=>$request->existingMobileNumber,
        //         'newMobileNumber'=>$request->newMobileNumber,
        //     ]);
        // }
        $errorMessage = $responseData['status'] ?? $responseData['message'];
        return view('user.marchant-onboard.mobile_validate', [
            // 'message1'=>$responseData['data']['existing'],
            // 'message2'=>$responseData['data']['new'],
            'error' => $errorMessage,
            'existingMobileNumber'=>$request->existingMobileNumber,
            'newMobileNumber'=>$request->newMobileNumber,
        ]);
    
}


public function mobileValidateVerify(Request $request)
{

    $response = Http::withHeaders([
       
        'Content-Type' => 'application/json',

    ])->post(env('liveUrl') .'user/onboard/mobileChange/verify', [
        "existingMobileNumber" => $request->existingMobileNumber,
        "newMobileNumber" => $request->newMobileNumber,
        "otp" => [
            "existingMobileNumber" => $request->otp['existingMobileNumber'],
            "newMobileNumber" => $request->otp['newMobileNumber'],
        ]
    ]);
    
    // return $response->json();
    // die();
    if ($response->successful()) {
        $responseData = $response->json();

        // return $responseData;
        // die();
        // Check for error statuscode
        if (isset($responseData['statuscode']) && $responseData['statuscode'] === 'ERR') {
            $errorMessage = $responseData['status'] ?? 'Unknown error';
            return view('user.marchant-onboard.mobile_validate', [
                'error' => $errorMessage,
                'existingMobileNumber'=>$request->existingMobileNumber,
                'newMobileNumber'=>$request->newMobileNumber,
            ]);
        }
        
$mobile=session('phone');
        // $otpReferenceID = $responseData['data']['otpReferenceID'] ?? null;
        // $hash = $responseData['data']['hash'] ?? null;
        DB::table('customer')
        ->where('phone', $mobile)
        ->update(['phone' => $request->newMobileNumber]);

    // Redirect to the KYC form or return a view
    return redirect('user/kyc-form');
    }
}
public function initiateSignup(Request $request)
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

    // Send data to the API
    $response = Http::withHeaders([
        'Content-Type' => 'application/json',
    ])->post(env('liveUrl') . 'user/onboard/signup', [
        'mobile' => $request->mobile,
        'email' => $request->email,
        'aadhaar' => $request->aadhaar, // Fixed typo
        'pan' => $request->pan,
        'bankAccountNo' => $request->bankAccountNo,
        'bankIfsc' => $request->bankIfsc,
        'latitude' => $request->latitude,
        'longitude' => $request->longitude,
        'consent' => $request->consent,
    ]);
        return $response->json();
        die();
        $responseData = $response->json();
        return view('user.marchant-onboard.signup_validate', [
                    'otpReferenceID' => $otpReferenceID,
                    'hash' => $hash,
        ]);


    // Check if the API call was successful
    // if ($response->successful()) {
     

    //     // Check for error status code
    //     if (isset($responseData['data']['statuscode']) && $responseData['data']['statuscode'] === 'ERR') {
    //         $errorMessage = $responseData['data']['status'] ?? 'Unknown error';
    //         return view('user.marchant-onboard.signup_validate', [
    //             'error' => $errorMessage,
    //         ]);
    //     }

    //     // Extract OTP reference ID and hash
    //     $otpReferenceID = $responseData['data']['otpReferenceID'] ?? null;
    //     $hash = $responseData['data']['hash'] ?? null;

    //     
    //     ]);
    

    // Handle failed API response
    // return view('user.marchant-onboard.signup_validate', [
    //     'error' => 'Failed to initiate signup. Please try again.',
    // ]);
}




public function validateOtp(Request $request) 
{
    // return $request;
    // die();
    $username = session('username');
    $response = Http::withHeaders([
        'Content-Type' => 'application/json',
    ])->timeout(120)->post(env('liveUrl') .'user/onboard/signup/verify', [
        'otpReferenceID' => $request->otpReferenceID,
        'otp' => $request->otp,
        'hash' => $request->hash,
    ]);

    $responseData = $response->json();
    // return $responseData;
    // die(); 
    $outletId = $responseData['outletId'] ?? 0; // Use null coalescing for safety
    //$customer = CustomerModel::findOrFail($id);
    $customer = CustomerModel::where('username', $username)->first();
    $customer->update([
        'pin' =>  $outletId,
    ]);
//  return $response;
//     die();
    // Return to the Blade view with response data
    return view('user.marchant-onboard.otp-validation-result', [
        'status' => 'success',
        'message' => $responseData['status'] ?? $responseData['message'] ?? '',
        'data' => $responseData ?? null,
    ]);

}


//json view 
// public function validateOtp(Request $request) 
// {
//     $response = Http::withHeaders([
//         'X-Ipay-Auth-Code' => env('IPAY_AUTH_CODE'),
//         'X-Ipay-Client-Id' => env('IPAY_CLIENT_ID'),
//         'X-Ipay-Client-Secret' => env('IPAY_CLIENT_SECRET'),
//         'X-Ipay-Endpoint-Ip' => env('IPAY_ENDPOINT_IP'),
//         'Content-Type' => 'application/json',
//     ])->post('https://api.instantpay.in/user/outlet/signup/validate', [
//         'otpReferenceID' => $request->otpReferenceID,
//         'otp' => $request->otp,
//         'hash' => $request->hash,
//     ]);

//     // Decode the response to access the original message
//     $responseData = $response->json();

//     // Return JSON response with status, message, and original response data
//     return response()->json([
//         'status' => $responseData['statuscode'] === 'ERR' ? 'error' : 'success',
//         'message' => $responseData['status'], // Extracted message
//         'data' => $responseData, // Original response data
//     ]);
// }

public function merchantList(Request $request)
{
    $data = [
    
            "pageNumber" => 1,
            "recordsPerPage" => 100,

    ];

    $response = Http::withHeaders([
        'Content-Type' => 'application/json',
    ])->post(env('liveUrl') .'user/onboard/list', $data);

    // Decode the response to get the data
    $responseData = $response->json();

    // return $responseData;
    // die();
    // Pass the response data to the Blade view
    return view('user.marchant-onboard.merchant_list', compact('responseData'));
}
 
 




    // public function validateOtp(Request $request)
    // {
    //     $response = Http::withHeaders([
    //         'X-Ipay-Auth-Code' => env('IPAY_AUTH_CODE'),
    //         'X-Ipay-Client-Id' => env('IPAY_CLIENT_ID'),
    //         'X-Ipay-Client-Secret' => env('IPAY_CLIENT_SECRET'),
    //         'X-Ipay-Endpoint-Ip' => env('IPAY_ENDPOINT_IP'),
    //         'Content-Type' => 'application/json',
    //     ])->post('https://api.instantpay.in/user/outlet/signup/validate', [
    //         'otpReferenceID' => $request->otpReferenceID,
    //         'otp' => $request->otp,
    //         'hash' => $request->hash,
    //     ]);
    
    //     // Check if the response is successful
    //     if ($response->successful()) {
    //         return response()->json([
    //             'status' => 'success',
    //             'message' => 'OTP validated successfully.',
    //             'data' => $response->json() // Include the original response data
    //         ]);
    //     } else {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Failed to validate OTP.',
    //             'error' => $response->json() // Include the error response data
    //         ]);
    //     }
    // }
    
    
}
