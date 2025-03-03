<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
class RemitterController extends Controller
{
    public function showQueryForm()
    {
        return view('user.remitter.query');
    }
    public function showRegisterForm()
    {
        return view('user.remitter.register');
    }
public function showKycForm()
{
    return view('user.remitter.remitter-kyc');
}


public function queryRemitter(Request $request)
{
    $client = new Client();
    $url = env('API_URL') . '/api/v1/service/dmt/kyc/remitter/queryremitter';

    $response = $client->post($url, [
        'headers' => [
            'Authorisedkey' => env('AUTH_KEY'),
            'Content-Type' => 'application/json',
            'Token' => env('API_TOKEN'),
            'Accept' => 'application/json',
        ],
        'json' => [
            'mobile' => $request->input('mobile'),
        ],
    ]);

    $data = json_decode($response->getBody(), true);
return $data;
die();
    if ($data['response_code'] == 1) {
        // Redirect to the remitter account details page
        return view('user.remitter.remitter-details', ['data' => $data['data']]);
    } elseif ($data['response_code'] == 2) {
        // Redirect to the e-KYC page
        return redirect()->route('remitter.kyc.form')->with('mobile', $data['data']['mobile']);
    } elseif ($data['response_code'] == 3) {
        // Redirect to the remitter registration page
        return redirect()->route('remitter.register.form')->with([
            'mobile' => $data['data']['mobile'],
            'stateresp' => $data['data']['stateResp'], // Corrected key case
            'ekyc_id' => $data['data']['ekyc_id'],
        ]);
    } else {
        // Handle unexpected response codes
        return redirect()->back()->with('error', 'Unexpected response code received.');
    }
}








public function kycRemitter(Request $request)
{
    // Validate form data
    $request->validate([
        'mobile' => 'required|numeric',
        'lat' => 'required|numeric',
        'long' => 'required|numeric',
        'aadhaar_number' => 'required|numeric',
        'biometricData'=>'required',
     
    ]);
//  $piddata=$request->input('biometricData');
//  $piddata = trim($piddata, '"');
//  return $piddata;
// die();
    // Get form data    
    $mobile = $request->input('mobile');
    $lat = $request->input('lat');
    $long = $request->input('long');
    $aadhaar_number = $request->input('aadhaar_number');
    $piddata=$request->input('biometricData');
    $piddata=trim($piddata,'"');

    // Encryption logic for PID data
    $key = env('AUTH_KEY'); // Use your actual encryption key
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('AES-128-CBC'));
    $ciphertext_raw = openssl_encrypt($piddata, "AES-128-CBC", $key, OPENSSL_RAW_DATA, $iv);
    $enctoken = base64_encode($ciphertext_raw);
// return $enctoken ."".$request;

// die();
    // Initialize Guzzle HTTP client
    $client = new Client();
    $url = 'https://api.paysprint.in/api/v1/service/dmt/kyc/remitter/queryremitter/kyc';

    try {
        // Send the POST request to the API
        $response = $client->post($url, [
            'headers' => [
                'Authorisedkey' => env('AUTH_KEY'),
                'Token' => env('API_TOKEN'),
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'mobile' => $mobile,
                'lat' => $lat,
                'long' => $long,
                'aadhaar_number' => $aadhaar_number,
                'data' => $enctoken, // Encrypted PID data
                'accessmode'=>'WEB'
            ]
        ]);
        $data = json_decode($response->getBody(), true);
        // return $data;
        // die();
        return redirect()->route('remitter.register.form')->with([
            'mobile' => $data['data']['mobile'],
            'ekyc_id' => $data['data']['kyc_id'],
            'stateresp' => $data['data']['stateresp'], // Corrected key case
         
        ]);

        // // Get the response body and return it as JSON
        // $data = json_decode($response->getBody(), true);
        // return response()->json($data);

         // Decode the JSON response
         //$data = json_decode($response->getBody(), true);

         // Pass data to the view
        // return view('user.remitter.register', ['data' => $data]);

    } catch (\Exception $e) {
        return response()->json(['error' => 'Request failed', 'message' => $e->getMessage()], 500);
    }
}


    
    // public function queryRemitter(Request $request)
    // {
    //     $client = new Client();
    //     $url = env('API_URL') . '/service-api/api/v1/service/dmt/remitter/queryremitter';
    
    //     try {
    //         $response = $client->post($url, [
    //             'headers' => [
    //                 'Authorisedkey' => env('AUTH_KEY'),
    //                 'Content-Type' => 'application/json',
    //                 'Token' => env('API_TOKEN'),
    //                 'accept' => 'application/json',
    //             ],
    //             'json' => [
    //                 'mobile' => $request->input('mobile'),
    //                 'bank3_flag' => $request->input('bank3_flag'),
    //                 'bank4_flag' => $request->input('bank4_flag'),
    //                 'merchantcode' => $request->input('merchantcode'),
    //             ]
    //         ]);
    
    //         $data = json_decode($response->getBody(), true);
    
    //         // Extract the specific fields
    //         $remitterData = [
    //             'fname' => $data['data']['fname'] ?? null,
    //             'lname' => $data['data']['lname'] ?? null,
    //             'mobile' => $data['data']['mobile'] ?? null,
    //             'response_code' => $data['stateresp'] ?? null,
    //             // 'status' => $data['data']['status'] ?? null,
    //             'bank3_limit' => $data['data']['bank3_limit'] ?? null,
    //             'bank2_limit' => $data['data']['bank2_limit'] ?? null,
    //             'bank1_limit' => $data['data']['bank1_limit'] ?? null,
    //             'bank3_status' => $data['data']['bank3_status'] ?? null,
    //             'message' => $data['message'] ?? null,
              
    //         ];
    
    //         return view('user.remitter.remitter-details', compact('remitterData'));
    //     } catch (\Exception $e) {
    //         return view('user.remitter.remitter-details', ['error' => 'Failed to fetch remitter details']);
    //     }
    // }
    // public function queryRemitter(Request $request)
    // {
    //     $client = new Client();
    //     $response = $client->post(env('API_URL') . '/service-api/api/v1/service/dmt/remitter/queryremitter', [
    //         'headers' => [
    //             'Authorisedkey' => env('AUTH_KEY'),
    //             'Content-Type' => 'application/json',
    //             'Token' => env('API_TOKEN'),
    //             'accept' => 'application/json',
    //         ],
    //         'json' => [
    //             'mobile' => $request->mobile,
    //             'bank3_flag' => $request->bank3_flag,
    //             'bank4_flag' => $request->bank4_flag,
    //             'merchantcode' => $request->merchantcode,
    //         ]
    //     ]);

    //     return response()->json(json_decode($response->getBody(), true));
    // }



public function registerRemitter(Request $request)
{
    $client = new Client();
    $url = env('API_URL') . '/api/v1/service/dmt/kyc/remitter/registerremitter';

    try {
        $response = $client->post($url, [
            'headers' => [
                'Authorisedkey' => env('AUTH_KEY'),
                'Content-Type' => 'application/json',
                'Token' => env('API_TOKEN'),
                'accept' => 'application/json',
            ],
            'json' => [
                'mobile' => $request->input('mobile'),
                'otp' => $request->input('otp'),
                'stateresp' => $request->input('stateresp'),
                'ekyc_id' => $request->input('kyc_id'),

             
            ]
        ]);

        $data = json_decode($response->getBody(), true);
        // return $data;
        // die();
return view('user.remitter.remitter-details', ['data' => $data['data']]);
        //return view('user.remitter.register-remitter', ['response' => $data]);
    } catch (\Exception $e) {
        
        return view('user.remitter.register-remitter', ['error' => 'Failed to register remitter "The OTP field must be exactly 4 characters in length"']);
    }
}
    // public function registerRemitter(Request $request)
    // {
    //     $client = new Client();

    //     $response = $client->post(env('API_URL') . '/service-api/api/v1/service/dmt/remitter/registerremitter', [
    //         'headers' => [
    //             'Authorisedkey' => env('AUTH_KEY'),
    //             'Content-Type' => 'application/json',
    //             'Token' => env('API_TOKEN'),
    //             'accept' => 'application/json',
    //         ],
    //         'json' => [
    //             'mobile' => $request->mobile,
    //             'firstname' => $request->firstname,
    //             'lastname' => $request->lastname,
    //             'address' => $request->address,
    //             'otp' => $request->otp,
    //             'pincode' => $request->pincode,
    //             'stateresp' => $request->stateresp,
    //             'bank3_flag' => $request->bank3_flag,
    //             'dob' => $request->dob,
    //             'gst_state' => $request->gst_state,
    //             'bank4_flag' => $request->bank4_flag,
    //         ]
    //     ]);

    //     return response()->json(json_decode($response->getBody(), true));
    // }
}
