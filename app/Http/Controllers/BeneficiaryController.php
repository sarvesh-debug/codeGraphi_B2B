<?php

namespace App\Http\Controllers;

use App\Models\BankDetail;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
class BeneficiaryController extends Controller
{
    // Display forms
    public function registerForm($mobile) {
        $bankData=BankDetail::all();
       //return $mobile;
        // $mobile = $request->query('mobile'); // Get the mobile number from the query string
        //return view('user.beneficiary.register-form', compact('mobile'));
        return view('user.beneficiary.register',compact('bankData','mobile'));
    }

    public function deleteForm($mobile,$bene_id) {
        return view('user.beneficiary.delete',compact('mobile','bene_id'));
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
         return view('user.beneficiary.fetch', compact('latestTransactions'));
    }
    

    public function fetchByBeneIdForm() {
        return view('user.beneficiary.fetch_beneid');
    }


    public function registerBeneficiary(Request $request) 
    {
        $mobile = $request->input('mobile');
        $client = new Client();
    
        try {
            $response = $client->post(env('API_URL') . '/api/v1/service/dmt/kyc/beneficiary/registerbeneficiary', [
                'headers' => [
                    'Authorisedkey' => env('AUTH_KEY'),
                    'Content-Type' => 'application/json',
                    'Token' => env('API_TOKEN'),
                    'accept' => 'application/json',
                ],
                'json' => [
                    'mobile'    => $mobile,  // Using the $mobile variable here
                    'benename'  => $request->input('benename'),
                    'bankid'    => $request->input('bankid'),
                    'accno'     => $request->input('accno'),
                    'ifsccode'  => $request->input('ifsccode'),
                    'verified'  => '1',
                    'gst_state' => '07',
                    'dob'       => '1990-03-02',
                    'address'   => 'New delhi',
                    'pincode'   => '2XXXX6',
                ]
            ]);
    
            $data = json_decode($response->getBody(), true);
    
            // You can optionally return the response data or something else
            //return view('user.beneficiary.fetch', ['mobile' => $mobile]);
            return view('user.beneficiary.fetch', ['mobile' => $mobile, 'message' => $data['message']]);
    
        } catch (\Exception $e) {
            // Handle the error and return a custom error message
            return view('user.beneficiary.register-details', ['error' => 'Failed to register beneficiary: ' . $e->getMessage()]);
        }
    }
    
    // Handle Register Beneficiary
    // public function registerBeneficiary(Request $request)
    // {
    //     // Validate request data
    //     $validatedData = $request->validate([
    //         'mobile' => 'required|string|max:10',
    //         'benename' => 'required|string|max:255',
    //         'bankid' => 'required|string',
    //         'accno' => 'required|string',
    //         'ifsccode' => 'required|string',
    //         'verified' => 'required|in:0,1',
    //         'gst_state' => 'required|string',
    //         'dob' => 'required|date',
    //         'address' => 'required|string|max:255',
    //         'pincode' => 'required|string|max:6',
    //     ]);

    //     // Fetching environment variables
    //     $baseUrl = env('BENEFICIARY_BASE_URL');
    //     $authKey = env('BENEFICIARY_AUTH_KEY');
    //     $token = env('BENEFICIARY_TOKEN');

    //     // Sending the POST request
    //     $response = Http::withHeaders([
    //         'Authorisedkey' => $authKey,
    //         'Content-Type'  => 'application/json',
    //         'Token'         => $token,
    //         'accept'        => 'application/json',
    //     ])->post("{$baseUrl}/registerbeneficiary", [
    //         'mobile'    => $validatedData['mobile'],
    //         'benename'  => $validatedData['benename'],
    //         'bankid'    => $validatedData['bankid'],
    //         'accno'     => $validatedData['accno'],
    //         'ifsccode'  => $validatedData['ifsccode'],
    //         'verified'  => $validatedData['verified'],
    //         'gst_state' => $validatedData['gst_state'],
    //         'dob'       => $validatedData['dob'],
    //         'address'   => $validatedData['address'],
    //         'pincode'   => $validatedData['pincode'],
    //     ]);

    //     // Check response status
    //     if ($response->successful()) {
    //         return response()->json(['message' => 'Beneficiary registered successfully!'], 200);
    //     } else {
    //         return response()->json(['error' => 'Failed to register beneficiary.'], 400);
    //     }
    // }

// delete

public function deleteBeneficiary(Request $request)
{
    // Prepare the data payload
    $data = [
        'mobile' => $request->input('mobile'),
        'bene_id' => $request->input('bene_id'),
    ];

    // Make the API request
    $response = Http::withHeaders([
        'Authorisedkey' => env('AUTH_KEY'),
        'Content-Type' => 'application/json',
        'Token' => env('API_TOKEN'),
        'accept' => 'application/json',
    ])->post(env('API_URL') . '/api/v1/service/dmt/kyc/beneficiary/registerbeneficiary/deletebeneficiary', $data);

    // Decode the response and pass it to the view
    $responseData = $response->json();
    
    return view('user.beneficiary.delete-beneficiary', compact('responseData'));
}


    // public function deleteBeneficiary(Request $request)
    // {
    //     // Validate request data
    //     $validatedData = $request->validate([
    //         'mobile' => 'required|string|max:10',
    //         'bene_id' => 'required|string',
    //     ]);

    //     // Retrieve API keys from environment variables
    //     $authorizedKey = env('AUTH_KEY');
    //     $token = env('API_TOKEN');

    //     // Sending the DELETE request
    //     $response = Http::withHeaders([
    //         'Authorisedkey' => $authorizedKey,
    //         'Content-Type'  => 'application/json',
    //         'Token'         => $token,
    //         'accept'        => 'application/json',
    //     ])->post(env('API_URL') . '/service-api/api/v1/service/dmt/beneficiary/registerbeneficiary/deletebeneficiary', [
    //         'mobile'   => $validatedData['mobile'],
    //         'bene_id'  => $validatedData['bene_id'],
    //     ]);

    //     // Check response status
    //     if ($response->successful()) {
    //         return response()->json(['message' => 'Beneficiary deleted successfully!'], 200);
    //     } else {
    //         return response()->json(['error' => 'Failed to delete beneficiary.'], 400);
    //     }
    // }

    // fetch
    public function fetchBeneficiary(Request $request)
{
    // Get the `mobile` parameter from the request
    $mobile = $request->input('mobile');
    session(['mobile' => $mobile]);
    // Make the API request using Laravel's Http client
    $response = Http::withHeaders([
        'Authorisedkey' => env('AUTH_KEY'),
        'Content-Type' => 'application/json',
        'Token' => env('API_TOKEN'),
        'Accept' => 'application/json',
    ])->post(env('API_URL') . '/api/v1/service/dmt/kyc/beneficiary/registerbeneficiary/fetchbeneficiary', [
        'mobile' => $mobile,
    ]);

    // Decode the JSON response
    $data = $response->json();
return $data;
die();
 // Check if the API call was successful
 if ($response->successful() && isset($data['status']) && $data['status'] === true) {
    // Pass the beneficiary data to the view
    return view('user.beneficiary.fetch-details', [
        'beneficiaries' => $data['data'] ?? [],
        'mobile' => $mobile,
    ]);
}

// If the API response was not successful, return an error
$errorMessage = $data['message'] ?? 'Failed to fetch beneficiaries.';
return redirect()->back()->with('error', $errorMessage);

    // Check if the request was successful and status is true
    // if ($response->successful() && $data['status'] && $data['response_code'] === 1) {
    //     if (!empty($data['data'])) {
    //         // If data is not empty, redirect to fetch-details view with data
    //         return view('user.money-transfer.send_otp', [
    //             'data' => $data['data'],
    //             'mobile' => session('mobile'),
    //             'beneficiary' => $data['data'][0] // Assuming beneficiary data is inside the 'data' array
    //         ]);
    //     } else {
    //         // If data is empty, redirect to register view
    //         $bankData = BankDetail::all();
    //         return view('user.beneficiary.register',  compact('bankData', 'mobile'));
    //     }
    // } else {
    //     // Handle API failure or unsuccessful response
    //     return redirect()->back()->withErrors(['error' => 'Failed to fetch beneficiary details. Please try again.']);
    // }
}

    // fech
    public function fetchBeneficiaryByBeneId(Request $request)
    {
        // Validate request data
        $validatedData = $request->validate([
            'mobile' => 'required|string|max:10',
            'beneid' => 'required|string',
        ]);

        // Retrieve API keys from environment variables
        $authorizedKey = env('AUTH_KEY');
        $token = env('API_TOKEN');

        // Prepare the request body
        $body = [
            'mobile' => $validatedData['mobile'],
            'beneid' => $validatedData['beneid'],
        ];

        // Sending the POST request to fetch beneficiary by beneficiary ID
        $response = Http::withHeaders([
            'Authorisedkey' => $authorizedKey,
            'Content-Type'  => 'application/json',
            'Token'         => $token,
            'accept'        => 'application/json',
        ])->post(env('API_URL') . '/api/v1/service/dmt/beneficiary/registerbeneficiary/fetchbeneficiarybybeneid', $body);

        // Check response status
        if ($response->successful()) {
            return response()->json(['beneficiary' => $response->json()], 200);
        } else {
            return response()->json(['error' => 'Failed to fetch beneficiary.'], 400);
        }
    }
}
