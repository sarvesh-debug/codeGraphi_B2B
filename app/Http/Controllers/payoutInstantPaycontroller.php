<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Illuminate\Support\Str;



class payoutInstantPaycontroller extends Controller
{
    public function showForm()
    {
        return view('user.payout.payout-form');
    }

    public function showFormCard()
    {
        return view('user.payout.credit_cards');
    }


    public function getBankList()
    {
        $url = 'https://api.instantpay.in/payments/payout/banks';

    // Get the headers from environment variables
    $headers = [
        'X-Ipay-Auth-Code' => env('IPAY_AUTH_CODE'),
        'X-Ipay-Client-Id' => env('IPAY_CLIENT_ID'),
        'X-Ipay-Client-Secret' => env('IPAY_CLIENT_SECRET'),
        'X-Ipay-Endpoint-Ip' => env('IPAY_ENDPOINT_IP'),
        'Content-Type' => 'application/json',
    ];

    $response = Http::withHeaders($headers)->get($url);
    $responseData = $response->json(); // Getting the JSON data from the response

    return view('user.payout.bank-list', compact('responseData')); // Passing data to the view
    }

   


public function createPayout(Request $request)
{
    // return $request;
    // die();
    $externalRef = Str::uuid()->toString();
    // Define the API URL
    $url = 'https://api.instantpay.in/payments/payout';
    
    // Get the headers from environment variables
    $headers = [
        'X-Ipay-Auth-Code' => env('IPAY_AUTH_CODE'),
        'X-Ipay-Client-Id' => env('IPAY_CLIENT_ID'),
        'X-Ipay-Client-Secret' => env('IPAY_CLIENT_SECRET'),
        'X-Ipay-Endpoint-Ip' => env('IPAY_ENDPOINT_IP'),
        'Content-Type' => 'application/json',
    ];
    
    // Prepare the data from the form request
    $data = [
        'payer' => [
            'bankProfileId' => $request->input('bankProfileId'),
            'accountNumber' => $request->input('accountNumber'),
            
        ],
        'payee' => [
            'name' => $request->input('name'),
            'accountNumber' => $request->input('accountNumber'),
            'bankIfsc' => $request->input('bankIfsc'),
            'payeeListId' => $request->input('payeeListId'),
            
        ],
        'transferMode' => $request->input('transferMode'),
        'transferAmount' => $request->input('transferAmount'),
        'externalRef' => $externalRef,
        'latitude' => $request->input('latitude'),
        'longitude' => $request->input('longitude'), // Default empty if not provided
        'remarks' =>$request->input('remarks'),
        'purpose' => $request->input('purpose'),
        'otp' => '', // Default to true if not provided
        'otpReference' =>'',
    ];
    
    // Make the POST request to the API
    $response = Http::withHeaders($headers)->post($url, $data);
    
    // Return the response data (can be logged or displayed as needed)
    return response()->json($response->json());
}


public function createPayoutCard(Request $request)
{
    // return $request;
    // die();
    $externalRef = Str::uuid()->toString();
    // Define the API URL
    $url = 'https://api.instantpay.in/payments/payout';
    
    // Get the headers from environment variables
    $headers = [
        'X-Ipay-Auth-Code' => env('IPAY_AUTH_CODE'),
        'X-Ipay-Client-Id' => env('IPAY_CLIENT_ID'),
        'X-Ipay-Client-Secret' => env('IPAY_CLIENT_SECRET'),
        'X-Ipay-Endpoint-Ip' => env('IPAY_ENDPOINT_IP'),
        'Content-Type' => 'application/json',
    ];
    
    // Prepare the data from the form request
    $data = [
        'payer' => [
            'bankId' =>'0',
            'bankProfileId' => '0',
            'accountNumber' => $request->input('accountNumber'),
            'name'=>$request->input('name'),
            'paymentMode'=>$request->input('paymentMode'),
            'cardNumber'=>$request->input('cardNumber'),
            'cardSecurityCode'=>$request->input('cardSecurityCode'),
            'cardExpiry'=>[
                'month'=>$request->input('month'),
                'year'=>$request->input('year'),
            ],
            'referenceNumber'=>$request->input('referenceNumber')
            
        ],
        'payee' => [
            'name' => $request->input('payeeName'),
            'accountNumber' => $request->input('payeeAccountNumber')
            
        ],
        'transferMode' => $request->input('transferMode'),
        'transferAmount' => $request->input('transferAmount'),
        'externalRef' => $externalRef,
        'latitude' => $request->input('latitude'),
        'longitude' => $request->input('longitude'), // Default empty if not provided
        'remarks' =>$request->input('remarks'),
    'alertEmail'=>$request->input('alertEmail')
    ];
    
    // Make the POST request to the API
    $response = Http::withHeaders($headers)->post($url, $data);
    
    // Return the response data (can be logged or displayed as needed)
    return response()->json($response->json());

}















//     public function createPayout(Request $request)
// {
//     // Generate referenceNo automatically
//     $referenceNo = 'REF' . strtoupper(uniqid()); // Example: REF64D1A7B9D8F0

//     // Prepare payload for the API request
//     $payload = $request->all();
//     $payload['referenceNo'] = $referenceNo;

//     // Set up headers for the API request
//     $headers = [
//         'X-Ipay-Auth-Code'    => env('IPAY_AUTH_CODE'),
//         'X-Ipay-Client-Id'    => env('IPAY_CLIENT_ID'),
//         'X-Ipay-Client-Secret' => env('IPAY_CLIENT_SECRET'),
//         'X-Ipay-Endpoint-Ip'  => env('IPAY_ENDPOINT_IP'),
//         'Content-Type'        => 'application/json'
//     ];

//     // Make the API request
//     $response = Http::withHeaders($headers)->post(
//         'https://api.instantpay.in/payments/payout/link/create',
//         $payload
//     );

//     // Handle the API response
//     if ($response->successful()) {
//         return response()->json([
//             'success' => true,
//             'message' => 'Payout link created successfully!',
//             'data' => $response->json()
//         ], 200);
//     }

//     return response()->json([
//         'success' => false,
//         'message' => 'Failed to create payout link.',
//         'error' => $response->json(),
//     ], $response->status());
// }

    

    // public function createPayout(Request $request)
    // {
    //     $validated = $request->validate([
    //         'contactDetails.name' => 'required_if:verifyBene,true',
    //         'contactDetails.mobile' => 'required_if:verifyBene,true',
    //         'contactDetails.email' => 'required_if:verifyBene,true|email',
    //         'verifyBene' => 'required|boolean',
    //         'amount' => 'required|numeric',
    //         'purpose' => 'required|string|in:Refund,Cashback,Comission,Incentive,Payout,Greeting',
    //         'description' => 'required|string',
    //         'referenceNo' => 'nullable|string',
    //         'activatedAt' => 'required|date_format:Y-m-d H:i:s',
    //         'expiredAt' => 'required|date_format:Y-m-d H:i:s',
    //         'paymentModes' => 'required|array',
    //         'sendAlert' => 'nullable|boolean',
    //     ]);

    //     $headers = [
    //         'X-Ipay-Auth-Code' => env('X_IPAY_AUTH_CODE'),
    //         'X-Ipay-Client-Id' => env('X_IPAY_CLIENT_ID'),
    //         'X-Ipay-Client-Secret' => env('X_IPAY_CLIENT_SECRET'),
    //         'X-Ipay-Endpoint-Ip' => env('X_IPAY_ENDPOINT_IP'),
    //         'Content-Type' => 'application/json',
    //     ];

    //     $response = Http::withHeaders($headers)->post('https://api.instantpay.in/payments/payout/link/create', $validated);

    //     if ($response->successful()) {
    //         return back()->with('success', 'Payout link created successfully!');
    //     }

    //     return back()->withErrors(['error' => 'Failed to create payout link. Please try again.']);
    // }

}
