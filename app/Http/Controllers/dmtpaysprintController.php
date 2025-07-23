<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\VeriidyAccount;
use App\Helpers\ApiHelper;
use GuzzleHttp\Client;
use App\Models\BankDetail;

class dmtpaysprintController extends Controller
{
     public function showRegisterForm()
    {
        return view('user.dmtpaysprint.register');
    }
public function showKycForm()
{
    return view('user.dmtpaysprint.remitter-kyc');
}
      public function remitterProfileShow()
    {
        $mobile = session('mobile');
        $latestTransactions = DB::table('transactions_d_m_t1')
        ->where('mobile', $mobile)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($transaction) {
                // Decode the JSON response_data column
                $responseData = json_decode($transaction->response_data, true);
    
                // Check if the 'status' key exists and update accordingly
                $status = isset($responseData['status']) ? strtolower($responseData['status']) : 'unknown';
                $statusDisplay = ($status === 'transaction successful') ? 'success' : 'Failed';
                $amount = isset($responseData['data']['txnValue']) ? $responseData['data']['txnValue'] : 'N/A';
                return [
                    'amount' =>  $amount,
                    'date' => \Carbon\Carbon::parse($transaction->created_at)->format('d M Y, h:i A'),
                    'status' => $statusDisplay, // Display Success or Failed
                ];
            });
        return view('user.dmtpaysprint.remitter_profile',compact('latestTransactions'));
    } 

    
    public function remitterProfile(Request $request)
{
    // return $request;
    // die();
    // Validate the user input
    $request->validate([
        'mobileNumber' => 'required|digits:10',
    ]);
    $cgapi = env('cgapi');

    //return $cgapi;die();
    // Get the mobile number from the request
    $mobileNumber = $request->input('mobileNumber');
  $url=(env('API_URL').'/cg/query-remitter');
    // Make the API call using Laravel's HTTP client
    $response = Http::withHeaders([
      
        'Content-Type' => 'application/json',
    ])->post($url, [
        'mobile' => $mobileNumber,
        'CGAPI' => $cgapi
    ]);

    $data=$response;
    //return $data;die();
    // Check for a successful response

        if ($data['response_code'] == 1) {
        // Redirect to the remitter account details page
        return view('user.remitter.remitter-details', ['data' => $data['data']]);
    } elseif ($data['response_code'] == 2) {
        // Redirect to the e-KYC page
        return redirect()->route('1remitter.kyc.form')->with('mobile', $data['data']['mobile']);
    } elseif ($data['response_code'] == 3) {
        // Redirect to the remitter registration page
        return redirect()->route('1remitter.register.form')->with([
            'mobile' => $data['data']['mobile'],
            'stateresp' => $data['data']['stateresp'], // Corrected key case
            'ekyc_id' => $data['data']['ekyc_id'],
        ]);
    } else {
        // Handle unexpected response codes
        return redirect()->back()->with('error', 'Unexpected response code received.');
    }

 

    // Redirect back with error message
    return view('user.dmtpaysprint.remitter_profile')->withErrors('Failed to fetch remitter profile. Please try again later.');

    // // Return the response in JSON format
    // if ($response->successful()) {
    //     return response()->json($response->json(), 200);
    // }

    // // Log the error details and return an error response in JSON


    // return response()->json([
    //     'error' => 'Failed to fetch remitter profile. Please try again later.',
    // ], $response->status());
}

public function registerRemitter(Request $request)
{
   // return $request;die();
    $client = new Client();
    $url = env('API_URL') . '/cg/register-remitter';

    try {
        $response = $client->post($url, [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'mobile' => $request->input('mobile'),
                'otp' => $request->input('otp'),
                'stateresp' => $request->input('stateresp'),
                'ekyc_id' => $request->input('kyc_id'),
                'CGAPI'=>env('cgapi')

             
            ]
        ]);

        $data = json_decode($response->getBody(), true);
        // return $data;
        // die();
return view('user.remitter.remitter-details', ['data' => $data['data']]);
        //return view('user.remitter.register-remitter', ['response' => $data]);
    } catch (\Exception $e) {
        
        return $e;
        //return view('user.remitter.register-remitter', ['error' => 'Failed to register remitter "The OTP field must be exactly 4 characters in length"']);
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
    $CGAPI=env('cgapi'); 
    $mobile = $request->input('mobile');
    $lat = $request->input('lat');
    $long = $request->input('long');
    $aadhaar_number = $request->input('aadhaar_number');
    // $piddata=$request->input('biometricData');
    // $piddata=trim($piddata,'"');

    // // Encryption logic for PID data
    // $key = env('AUTH_KEY'); // Use your actual encryption key
    // $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('AES-128-CBC'));
    // $ciphertext_raw = openssl_encrypt($piddata, "AES-128-CBC", $key, OPENSSL_RAW_DATA, $iv);
    // $enctoken = base64_encode($ciphertext_raw);
// return $enctoken ."".$request;

// die();
    // Initialize Guzzle HTTP client
    $client = new Client();
  $url=(env('API_URL').'/cg/kyc-remitter');

    try {
        // Send the POST request to the API
        $response = $client->post($url, [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'mobile' => $mobile,
                'lat' => $lat,
                'long' => $long,
                'aadhaar_number' => $aadhaar_number,
                'biometricData' => $request->input('biometricData'),
                'CGAPI'=>$CGAPI
            ]
        ]);
        $data = json_decode($response->getBody(), true);
        // return $data;
        // die();
        return redirect()->route('1remitter.register.form')->with([
            'mobile' => $data['mobile'],
            'ekyc_id' => $data['ekyc_id'],
            'stateresp' => $data['stateresp'], // Corrected key case
         
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

//Beneficiary
 // Display forms
    public function registerForm($mobile) {
       // return $mobile;
        $bankData=BankDetail::all();
       //return $mobile;
        // $mobile = $request->query('mobile'); // Get the mobile number from the query string
        //return view('user.beneficiary.register-form', compact('mobile'));
        return view('user.dmtpaysprint.beneRegister',compact('bankData','mobile'));
    }

    public function registerBeneficiary(Request $request)
    {
        $mobile = $request->input('mobile');
        $client = new Client();
        $url= $url=(env('API_URL').'/cg/register-beneficiary');
        try {
            $response = $client->post($url, [
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'remitterMobile'    => $mobile,  // Using the $mobile variable here
                    'benename'  => $request->input('benename'),
                    'bankid'    => $request->input('bankid'),
                    'accno'     => $request->input('accno'),
                    'ifsccode'  => $request->input('ifsccode'),
                    'CGAPI'     =>env('cgapi')
                   
                ]
            ]);
    
            $data = json_decode($response->getBody(), true);
    //return $data;die();
            // You can optionally return the response data or something else
            //return view('user.beneficiary.fetch', ['mobile' => $mobile]);
            return view('user.dmtpaysprint.fetch', ['mobile' => $mobile, 'message' => $data['message']]);
    
        } catch (\Exception $e) {
            // Handle the error and return a custom error message

            return view('user.dmtpaysprint.beneregister-details', ['error' => 'Failed to register beneficiary: ' . $e->getMessage()]);
        }
    
    }
 public function fetchForm()
    {
        $mobile = session('mobile');
    // return $mobile;
    // die();  
        // Fetch the latest transactions from the database for the logged-in user
        $latestTransactions = DB::table('transactions_d_m_t1')
            ->where('mobile', $mobile)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($transaction) {
                // Decode the JSON response_data column
                $responseData = json_decode($transaction->response_data, true);
    
                // Default values in case keys are missing in the JSON
                $txnAmount = $responseData['txn_amount'] ?? 'N/A';
                $message = strtolower($responseData['message'] ?? 'unknown');
                $statusDisplay = ($message === 'transaction successful.') ? 'success' : 'Failed';
    
                return [
                    'amount' => $txnAmount,
                    'date' => \Carbon\Carbon::parse($transaction->created_at)->format('d M Y, h:i A'),
                    'status' => $statusDisplay,
                ];
            });
    
        //Return the transformed transaction data
       // return $latestTransactions;
    
        // Uncomment this if you want to render a Blade view
         return view('user.dmtpaysprint.fetch', compact('latestTransactions'));
    }
    public function fetchBeneficiary(Request $request)
    {
      
    // Get the `mobile` parameter from the request
    $mobile = $request->input('mobile');
    session(['mobile' => $mobile]);
    // Make the API request using Laravel's Http client\
$url=(env('API_URL').'/cg/fetch-beneficiary');
    $response = Http::withHeaders([
        
        'Content-Type' => 'application/json',
       
    ])->post($url, [
        'mobile' => $mobile,
        'CGAPI'=>env('cgapi')
    ]);

    // Decode the JSON response
    $data = $response->json();
// return $data;
// die();
 // Check if the API call was successful
 if ($response->successful() && isset($data['status']) && $data['status'] === true) {
    // Pass the beneficiary data to the view
    return view('user.dmtpaysprint.fetch-details', [
        'beneficiaries' => $data['data'] ?? [],
        'mobile' => $mobile,
    ]);
}

// If the API response was not successful, return an error
$errorMessage = $data['message'] ?? 'Failed to fetch beneficiaries.';
return redirect()->back()->with('error', $errorMessage);

    }

     public function deleteForm($mobile,$bene_id) {
        return view('user.dmtpaysprint.delete',compact('mobile','bene_id'));
    }

    public function deleteBeneficiary(Request $request)
{
    // Prepare the data payload
    $data = [
        'mobile' => $request->input('mobile'),
        'bene_id' => $request->input('bene_id'),
        'CGAPI' =>env('cgapi')
    ];
    $url=(env('API_URL').'/cg/delete-beneficiary');
    // Make the API request
    $response = Http::withHeaders([
        
        'Content-Type' => 'application/json',
       
    ])->post($url, $data);

    // Decode the response and pass it to the view
    $responseData = $response->json();
   // return $responseData;die();
    return view('user.dmtpaysprint.delete-beneficiary', compact('responseData'));
}

//transaction
 public function show()
 {

        return view('user.dmtpaysprint.money-transfer');
    }
    public function showOTP($mobile, $bene_id)
    {
        return view('user.dmtpaysprint.send_otp',compact('mobile', 'bene_id'));
    }
     public function showRefund()
    {
        return view('user.dmtpaysprint.refund_otp');
    }
    public function showStatus()
    {
        return view('user.dmtpaysprint.transaction_status');
    }
     public function sent_otp(Request $request)
    {
        //return $request;die();
        // Validate the input data
        $validatedData = $request->validate([
            'mobile' => 'required|numeric',
            'bene_id' => 'required|string',
            'txntype' => 'required|string',
            'amount' => 'required|numeric',
            'latitude'=>'required',
            'longitude'=>'required',
        ]);
    
        // Generate a unique reference ID if not provided
        $referenceId = $request->input('referenceid') ?? 'TXN' . str_pad(mt_rand(0, 99999999), 8, '0', STR_PAD_LEFT);
    $url=(env('API_URL').'/cg/send-otp');
        // Set headers
        $headers = [
          
            'Content-Type' => 'application/json',
        ];
    
        // Prepare data payload
        $data = [
            'mobile' => $validatedData['mobile'],
            'referenceid' => $referenceId,
            'pincode' => '110015',
            'address' => 'New Delhi',
            'dob' => '01-01-1990',
            'gst_state' => '07',
            'bene_id' => $validatedData['bene_id'],
            'txntype' => $validatedData['txntype'],
            'amount' => $validatedData['amount'],
             "lat"=> $validatedData['latitude'],
            "long"=> $validatedData['longitude'],
            'CGAPI'=>env('cgapi')
        ];
    
        try {
            // Make the API request
            $response = Http::withHeaders($headers)->post(
                $url,
                $data
            );
    
            // Decode the API response
            $responseData = $response->json();
    // return $responseData;
    // die();
            if ($response->successful() && isset($responseData['status']) && $responseData['status'] === true) {
                // Extract required data from the response
                $stateresp = $responseData['stateresp'] ?? null;
    
                // Return the view with all the data
                return view('user.dmtpaysprint.money-transfer', [
                    'stateresp' => $stateresp,
                    'mobile' => $validatedData['mobile'],
                    'referenceid' => $referenceId,
                    'pincode' => $data['pincode'],
                    'address' => $data['address'],
                    'dob' => $data['dob'],
                    'gst_state' => $data['gst_state'],
                    'bene_id' => $validatedData['bene_id'],
                    'txntype' => $validatedData['txntype'],
                    'amount' => $validatedData['amount'],
                ]);


            } else {
                 // Extract error message from the response
    $errorMessage = $responseData['message'] ?? 'Unknown error occurred';

    // Pass the error message to the error view
    return view('user.dmtpaysprint.money-transferError', [
        'error' => $errorMessage,
    ]);
            }
        } catch (\Exception $e) {
            // Handle exceptions
            return view('user.dmtpaysprint.money-transfer', [
                'error' => 'Request failed: ' . $e->getMessage(),
            ]);
        }
    }

    
    public function transact(Request $request)
    {
       // return $request;die();
        $role = session('role');
        $txnType=$request->input('txntype');
        // Set headers for the API request
        $headers = [
            
            'content-type' => 'application/json', // Sending JSON data in the request
        ];
    
        // Prepare the data payload for the API request
        $data = [
            'mobile' => $request->input('mobile'),
            'referenceid' => $request->input('referenceid'),
            'pincode' => '110015',                  // Fixed Pincode for New Delhi
            'address' => 'New Delhi',               // Fixed Address for New Delhi
            'dob' => '01-01-1990',                  // Fixed Date of Birth (Modify as needed)
            'gst_state' => '07',                    // GST State code for Delhi (Modify as needed)
            'bene_id' => $request->input('bene_id'),
            'txntype' => $request->input('txntype'),
            'amount' => $request->input('amount'),
            'stateresp' => $request->input('stateresp'),
            'otp' => $request->input('otp'),       // OTP field from the form
            'CGAPI'=>env('cgapi')
        ];
     $url=(env('API_URL').'/cg/transact');
        // Make the API request with the headers and data
        $response = Http::withHeaders($headers)->post($url, $data);
    
        // Extract the response data from the API response
        $responseData = $response->json();
    // return $response;
    // die();
        // Log the response for debugging (optional)
        Log::info('API Response:', $responseData);
    
        // Store the response, mobile, and referenceid in the database
        try {
            \DB::table('transactions_d_m_t1')->insert([
                'mobile' => $request->input('mobile'),
                'referenceid' => $request->input('referenceid'), // Store referenceid
                'response_data' => json_encode($responseData),  // Store the entire response as JSON
                'created_at' => now(),                          // Timestamp
                'updated_at' => now(),                          // Timestamp
            ]);


        } catch (\Exception $e) {
            // Log any database insertion errors
            Log::error('Database Insert Error:', ['error' => $e->getMessage()]);
        }
    
        // Handle successful and error responses
        if ($response->successful() && isset($responseData['status']) && $responseData['status'] === true) {

            // $this->updateCustomerBalance(session('mobile'),'txnType');

            //$this->updateCustomerBalance(session('mobile'), $txnType,$role);
            // Send data to the success view
            return view('user.dmtpaysprint.transaction_result', [
                'transactionData' => $responseData,
                'referenceid' => $request->input('referenceid'), // Pass the referenceid to the view
            ]);
        } else {
            // Send the error message to the error view
            return view('user.dmtpaysprint.money-transferError', [
                'error' => $responseData['message'] ?? 'Unknown error occurred',
            ]);
        }



    }

}
