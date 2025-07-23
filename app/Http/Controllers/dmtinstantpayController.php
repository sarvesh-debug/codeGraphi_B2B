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
class dmtinstantpayController extends Controller
{

    public function remitterProfileShow()
    {
        $mobile = session('mobile');
        $latestTransactions = DB::table('transactions_dmt_instant_pay')
        ->where('remitter_mobile_number', $mobile)
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
        return view('user.dmtinstantpay.remitter_profile',compact('latestTransactions'));
    } 
    public function showSendMoneyForm(Request $request)
{
    //return $request;die();
     $mobile = $request->input('mobile');
    $account = $request->input('account');
    $ifsc = $request->input('ifsc');
    $beneName = $request->input('beneName');
    $referenceKey = $request->input('referenceKey');
    return view('user.dmtinstantpay.send-money-form', compact('mobile', 'account', 'ifsc', 'beneName','referenceKey'));
}

  
    public function remitterKycForm()
    {
        return view('user.dmtinstantpay.remitter_kyc_page');
    }
    public function getBanksdmt()
    {
        // Make the API call
        $customerOutletId = intval(session('outlet'));
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post(env('liveUrl').'v1/dmt/BankDetails', [
        //
            'outLet' =>$customerOutletId
        ]);
    // return $response;
    // die();
        if ($response->successful()) {
            $responseData = $response->json();
            return $responseData;
        } else {
            // Return an error message if the API call fails
            return response()->json(['error' => 'Failed to retrieve bank data.'], 500);
        }
    }
    
    public function beneficiaryRegistrationForm(Request $request)
    {

        $mobileNumber = $request->query('mobileNumber');
        $responseData = $this->getBanksdmt(); // Use the correct function name here
        // return $responseData;
        // die();
        return view('user.dmtinstantpay.beneficiaryRegistrationForm', compact('mobileNumber', 'responseData'));
    }
    
    
    public function remitterProfile(Request $request)
{
    // return $request;
    // die();
    // Validate the user input
    $request->validate([
        'mobileNumber' => 'required|digits:10',
    ]);
    $customerOutletId = intval(session('outlet'));

    
    // Get the mobile number from the request
    $mobileNumber = $request->input('mobileNumber');

    // Make the API call using Laravel's HTTP client
    $response = Http::withHeaders([
        
        'Content-Type' => 'application/json',
    ])->post(env('liveUrl').'v1/dmt/remitterProfile', [
        'mobileNumber' => $mobileNumber,
        'outlet' => $customerOutletId
    ]);
// return $response;
//  die();

    // Check for a successful response

        $responseData = $response->json();
        $wadh = $responseData['data']['pidOptionWadh'] ?? '';
        session(['wadh' => $wadh]);
        // echo session('wadh');
        // die();
        // If Remitter Not Found
        if ($responseData['statuscode'] === 'RNF') {
            return view('user.dmtinstantpay.remitter_registration', compact('responseData','mobileNumber'));
        }

        // If Success (Transaction)
        if ($responseData['statuscode'] === 'TXN') {
            return view('user.dmtinstantpay.remitter_profile_show', compact('responseData'));
        }
    

 

    // Redirect back with error message
    return view('user.dmtinstantpay.remitter_profile')->withErrors('Failed to fetch remitter profile. Please try again later.');

    // // Return the response in JSON format
    // if ($response->successful()) {
    //     return response()->json($response->json(), 200);
    // }

    // // Log the error details and return an error response in JSON


    // return response()->json([
    //     'error' => 'Failed to fetch remitter profile. Please try again later.',
    // ], $response->status());
}





public function remitterRegistration(Request $request)
{
    $customerOutletId = intval(session('outlet'));

   // Validate the inputs
   $request->validate([
    'mobileNumber' => 'required|digits:10', // Ensure it's a 10-digit number
    'aadhaarNumber' => 'required|digits:12', // Ensure it's a 12-digit Aadhaar number
    'referenceKey' => 'required|string',
]);

// Extract input values
$mobileNumber = $request->input('mobileNumber');
$aadhaarNumber = $request->input('aadhaarNumber');
$referenceKey = $request->input('referenceKey');


// API Request
$response = Http::withHeaders([
   
    'Content-Type' => 'application/json',
])->post(env('liveUrl').'v1/dmt/remitterRegistration', [
    'outlet'=>$customerOutletId,
    'mobileNumber' => $mobileNumber,
    'aadhaarNumber' => $aadhaarNumber,
    'referenceKey' => $referenceKey,
]);

$responseData=$response->json();
// return $responseData;
// die();
 // Return only the status and data to the view
 return view('user.dmtinstantpay.remitter_registration_verify', [
    'status' => $responseData['message'] ?? $responseData['status'] ??null,
    'data' => $responseData['data'] ?? null,
    'mobileNumber'=>$mobileNumber,
]);

}


public function verifyRemitterRegistration(Request $request)
{
    $customerOutletId = intval(session('outlet'));

    // Validate the input
    $request->validate([
        
        'mobileNumber' => 'required|digits:10',
        'otp' => 'required|numeric',
        'referenceKey' => 'required|string',
    ]);
$mobile=$request->input('mobile');
    // Define API endpoint and headers
    $url = env('liveUrl').'v1/dmt/verifyRemitterRegistration';
    $headers = [
       
        'Content-Type' => 'application/json',
    ];

    // Prepare the request body with user input
    $body = [
        'outlet' => $customerOutletId,
        'mobileNumber' => $request->input('mobileNumber'),
        'otp' => $request->input('otp'),
        'referenceKey' => $request->input('referenceKey'),
    ];

    try {
        // Make the HTTP POST request
        $response = Http::withHeaders($headers)->post($url, $body);

        // Decode the response body
        $data = $response->json();
// return $data;
// die();
        // Check for specific status codes and redirect if necessary
        if (isset($data['statuscode']) && $data['statuscode'] === 'KYC') {
            // Redirect to the KYC page with status and data
            return  view('user.dmtinstantpay.remitter_kyc_page', [
                'status' => $data['status'],
                'referenceKey' => $data['data']['referenceKey'],
                'mobile'=>$mobile,

            ]);
        }

        // Pass only the statuscode and status to the view
        return view('user.dmtinstantpay.remitter-verification_error', [
            'statuscode' => $data['statuscode'] ?? 'N/A',
            'status' => $data['status'] ?? 'N/A',
        ]);
    } catch (\Exception $e) {
        // Handle errors and pass error message to the view
        //return 
       return view('user.dmtinstantpay.remitter-verification_error', ['error' => $e->getMessage()]);
    }
}


public function remitterKyc(Request $request)
{
    // return $request;
    // die();
    $customerOutletId = intval(session('outlet'));

    // Validate the input
    $request->validate([
        'mobileNumber' => 'required|numeric',
        'referenceKey' => 'required|string',
        'latitude' => 'required|numeric',
        'longitude' => 'required|numeric',
        'biometricData' => 'required', // Ensure biometricData is valid JSON
    ]);

    try {
        $url = env('liveUrl').'v1/dmt/remitterKyc';
        $headers = [
            'Content-Type' => 'application/json',
        ];

        // Prepare the request body with user input
        $body = [
            'outlet' => $customerOutletId,
            "mobileNumber" => $request->input('mobileNumber'),
            "referenceKey" => $request->input('referenceKey'),
            "latitude" => $request->input('latitude'),
            "longitude" => $request->input('longitude'),
            "externalRef" => Str::uuid()->toString(),
            "biometricData" => $request->input('biometricData'),
        ];
// return $body;
// die();
        // Make the HTTP POST request
        $response = Http::withHeaders($headers)->post($url, $body);

        // Decode the response body
        $data = $response->json();
// return $data;
// die();
        // Handle successful responses
        if (isset($data['statuscode']) && $data['statuscode'] === 'TXN') {
            return view('user.dmtinstantpay.remitter_kyc_success', ['response' => $data]);
        }

        // Handle unsuccessful responses
        return view('user.dmtinstantpay.remitter_kyc_error', [
            'statuscode' => $data['statuscode'] ?? 'N/A',
            'status' => $data['status'] ?? 'N/A',
        ]);
    } catch (\Exception $e) {
        // Handle general errors
        return view('user.dmtinstantpay.remitter_kyc_error', ['error' => $e->getMessage()]);
    }
}

public function beneficiaryRegistration(Request $request)
{
    $mobile=session('mobile');
    $realAmount=4;
    $customerOutletId = intval(session('outlet'));
    $request->validate([
        
        'mobile' => 'required|numeric',
        'benename' => 'required|string|max:255',
        'beneMobile' => 'required|numeric',
        'accno' => 'required|numeric',
        'bankId' => 'required|numeric',
        'ifsc' => 'required|string|max:255',
    ]);

    $url = env('liveUrl').'v1/dmt/beneficiaryRegistration';
    $headers = [
        'Content-Type' => 'application/json',
    ];

    // Prepare the request body with user input
    $body = [
        'outlet' =>$customerOutletId,
        'beneficiaryMobileNumber' => $request->input('beneMobile'),
        'remitterMobileNumber' => $request->input('mobile'),
        'accountNumber' => $request->input('accno'),
        'ifsc' =>$request->input('ifsc'),
        'bankId' =>$request->input('bankId'),
        'name' =>$request->input('benename'),
    ];

    try {
        // Make the HTTP POST request
        $response = Http::withHeaders($headers)->post($url, $body);

        // Decode the response body
        $data = $response->json();

// return $response;
// die();
        // Check if status is OTP sent successfully
        if (isset($data['statuscode']) && $data['statuscode'] === 'OTP') {
            //$apiBalance = ApiHelper::decreaseBalance(env('Business_Email'), $realAmount, 'Bank Account Verification');
            $balance = DB::table('customer')
     ->where('phone', $mobile)
     ->value('balance');
     $retailerClosing=$balance;
            

             
     // Store the retrieved balance in the session
    //  session(['balance'=> $balance]);

     DB::table('getcommission')->insert([
        'retailermobile' => $mobile,
        'service' => 'Account Verify',
        'sub_services' => 'Account_Verify',
         'externalRef' => 'TXN' . mt_rand(1000000000, 9999999999), // TXN + 10 digits

        'amount'=>3,
        'commission'=>0,
        'tds' => 0,
        'opening_bal' => $retailerClosing,
        'closing_bal' => $retailerClosing -3,
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    DB::table('customer')
            ->where('phone', $mobile)
            ->decrement('balance',3);
    $balance1 = DB::table('customer')
     ->where('phone', $mobile)
     ->value('balance');
    session(['balance'=> $balance1]);
            return view('user.dmtinstantpay.beneficiaryRegistrationSuccess', [
                'beneficiaryId' => $data['data']['beneficiaryId'],
                'referenceKey' => $data['data']['referenceKey'],
                'validity' => $data['data']['validity'],
                'status' => $data['status'],
                'mobile'=>$request->input('mobile'),
            ]);
        }

        // If the status is not OTP, handle accordingly
        return view('user.dmtinstantpay.beneficiaryRegistrationError', [
            'error' => 'Error registering beneficiary: ' . $data['status']
        ]);

    } catch (\Exception $e) {
        // Handle error, e.g., API request failure
        return view('user.dmtinstantpay.beneficiaryRegistrationError', [
            'error' => 'Failed to register beneficiary: ' . $e->getMessage()
        ]);
    }
    }



public function beneficiaryRegistrationVerify(Request $request)
{
    
    // return $request;
    // die();
    $customerOutletId = intval(session('outlet'));

    // Validate the request data
    // $validated = $request->validate([
    //     'beneMobile' => 'required|numeric',
    //     'otp' => 'required|string',
    //     'beneficiaryId' => 'required|numeric',
    //     'referenceKey' => 'required|numeric',
    // ]);

    $mobile = $request->input('beneMobile');

    // Define API endpoint and headers
    $url = env('liveUrl').'v1/dmt/verifyBeneficiaryRegistration';
    $headers = [
        'Content-Type' => 'application/json',
    ];

    // Prepare the request body with user input
    $body = [
        'outlet' =>$customerOutletId,
        'remitterMobileNumber' => $mobile,
        'otp' => $request->input('otp'),
        'beneficiaryId' => $request->input('beneficiaryId'),
        'referenceKey' => $request->input('referenceKey'),
    ];

    try {
        // Make the HTTP POST request
        $response = Http::withHeaders($headers)->post($url, $body);

        // Decode the response body
        $data = $response->json();
        // return $data;
        // die();

        // Pass the entire response to the view
        return view('user.dmtinstantpay.beneficiaryRegistrationResponse', [
            'response' => $data,
            'remitterMobileNumber' =>$mobile
        ]);

    } catch (\Exception $e) {
        // Pass the exception message to the view
        return view('user.dmtinstantpay.beneficiaryRegistrationResponse', [
            'response' => [
                'error' => 'Failed to register beneficiary: ' . $e->getMessage(),
            ],
        ]);
    }
}


public function generateTransactionOtp(Request $request)
{
    //return $request;

   
    $customerOutletId = intval(session('outlet'));

    // Validate the request data
    // $request->validate([
    //     'amount' => 'required|numeric',
    //     'mobile' => 'required|string',
    //     'account' => 'required|numeric',
    //     'ifsc'=>'required|string',
    //     'referenceKey' => 'required|numeric',
       
    // ]);

    $amountTr=$request->input('amount');
    $getAmount=DB::table('customer')
    ->where('username', session('username'))
    ->value('balance');
    $totalAmount=$getAmount;
    $lockAmount=session('lockBalance');
    $getAmount-=50;
 
// dd($totalAmount,$getAmount);
// die();

if ($totalAmount < $amountTr)
{
    
    return back()->with('alert', 'Insufficient balance.');

}
else
{
    if($getAmount > $amountTr)  //450 > 400
    {
       
        $mobile = $request->input('mobile');    
    // Define API endpoint and headers
    $url = env('liveUrl').'v1/dmt/generateTransactionOtp';
    $headers = [
        'Content-Type' => 'application/json',
    ];

    // Prepare the request body with user input
    $body = [
        'outlet' =>$customerOutletId,
        'remitterMobileNumber' => $request->input('mobile'),
        'amount' => $request->input('amount'),
      
        'referenceKey' => $request->input('referenceKey'),
    ];

    try {
        // Make the HTTP POST request
        $response = Http::withHeaders($headers)->post($url, $body);

        // Decode the response body
        $data = $response->json();
// return $data;
// die();
        // Check if status is OTP sent successfully
        if (isset($data['statuscode']) && $data['statuscode'] === 'OTP') {
            return view('user.dmtinstantpay.transationDmt', [
              
                'referenceKey' => $data['data']['referenceKey'],
                'validity' => $data['data']['validity'],
                'status' => $data['status'],
                'mobile'=>$mobile,
                'account'=>$request->input('account'),
                'ifsc'=>$request->input('ifsc'),
                'amount'=> $request->input('amount'),
                'beneName'=> $request->input('beneName'),
            ]);
        }

        // If the status is not OTP, handle accordingly
        return view('user.dmtinstantpay.beneficiaryRegistrationError', [
            'error' => 'Error registering beneficiary: ' . $data['status']
        ]);

    } catch (\Exception $e) {
        // Handle error, e.g., API request failure
        return view('user.dmtinstantpay.beneficiaryRegistrationError', [
            'error' => 'Failed to register beneficiary: ' . $e->getMessage()
        ]);
    }

    }
    else
    {
       // return view('user.dmtinstantpay.transation-error');
        return back()->with('alert', 'Insufficient Wallet Balance');
       // return view('user.dmtinstantpay.send-money-form')->with('alert', 'Insufficient Wallet Balance');


    }
}

    

    
}

public function transaction(Request $request)
{
    $customerOutletId = intval(session('outlet'));  // Get customerOutletId from session
    $role = session('role');
    $pry_mobile=session('mobile');
    //$mobile = $request->input('mobileNumber');
    $mobile = $request->input('mobileNumber');
    $amountTr=$request->input('amount');
   // $getAmount=session('balance');
   
// return $getAmount;
// die();

    $getAmount=DB::table('customer')
    ->where('username', session('username'))
    ->value('balance');
    $opb=$getAmount;
    $getAmount-=50;  
    // return $getAmount;
    // die();
$balanceAd = ApiHelper::getBalance(env('Business_Email'));

$balance = $balanceAd['wallet'];
// return $balance;
// die();
 
if ($balance >= $amountTr && $getAmount > $amountTr) 
    //if($getAmount > $amountTr)  //450 > 400
    {
        
        // return "Hello";
        // die();
        $externalRef = 'TXN' . date('Y') . '' . round(microtime(true) * 1000);

        // Define API endpoint and headers
        $url = env('liveUrl').'v1/dmt/dmtTransaction';
        $headers = [
     
            'Content-Type' => 'application/json',
        ];
    
        // Prepare the request body with user input
        $body = [
            'outlet' =>$customerOutletId,
            'remitterMobileNumber' => $mobile,
            'accountNumber' => $request->input('account'),
            'ifsc' => $request->input('ifsc'),
            'transferMode' => $request->input('transferMode'),
            'transferAmount' => $request->input('amount'),
            'latitude' => $request->input('latitude'),
            'longitude' => $request->input('longitude'),
            'otp' => $request->input('otp'),
            'referenceKey' => $request->input('referenceKey'),
             'externalRef' => $externalRef,  // Add externalRef here
        ];
        $mode=$request->input('transferMode');
        try {
            $response = Http::withHeaders($headers)->post($url, $body);
            $data = $response->json();
     
            // Store the transaction data, including customerOutletId
            DB::table('transactions_dmt_instant_pay')->insert([
                'remitter_mobile_number' => $pry_mobile,
                'second_no'=>$mobile,
              //  'reference_key' => $request->input('transferMode'),
              'reference_key' => $externalRef,
                'customer_outlet_id' => $customerOutletId,  // Store customerOutletId
                'response_data' => json_encode($data),
                'opening_balance' =>$opb,
                'closing_balance' =>$opb,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $mode=$request->input('transferMode');
            if ($response['statuscode'] === "TXN" || $response['statuscode'] === "TUP") {
                $this->updateCustomerBalance(session('mobile'), $mode, $role, $externalRef);
            }
            
            return view('user.dmtinstantpay.transactionSuccess', [
                'response' => $data,
            ]);
        } catch (\Exception $e) {
            return view('user.dmtinstantpay.transactionSuccess', [
                'response' => null,
                'error' => 'Transaction failed: ' . $e->getMessage(),
            ]);
        }
    

    }
    else
    {
        return view('user.dmtinstantpay.transation-error');
          // Set flash message for insufficient balance
        //   session()->flash('error', 'Your balance is not sufficient.');

        //   // Redirect back with the error message
        //   return redirect()->back();
    }
}

public function demotest()
{ 
    $mobile=session('mobile');
    $role=session('role');
    $mode='IMPS';
    $externalRef = 'TXN-' . strtoupper(uniqid(date('YmdHis')));
   // dd($externalRef);
    $this->updateCustomerBalance($mobile,$mode,$role,$externalRef);

//$deviceId = md5(string: request()->ip() . request()->header('User-Agent'));
//return $deviceId;


}


private function updateCustomerBalance($mobile, $mode,$role,$externalRef)
{
   

    $transaction = DB::table('transactions_dmt_instant_pay')
        ->where('remitter_mobile_number', $mobile)
        ->latest('created_at')
        ->first();

    if (!$transaction) return;

    $response_data = json_decode($transaction->response_data, true);
    if (!isset($response_data['data']['txnValue']) || !in_array($response_data['statuscode'], ['TXN', 'TUP'])) return;

    $txnAmount = $response_data['data']['txnValue'];
    $realAmount = $response_data['data']['txnValue'];
    // Retailer info
    $retailer = DB::table('customer')->where('phone', $mobile)->first();
    if (!$retailer) return;

    // Distributor & Super Distributor info
    $distributor = DB::table('customer')->where('phone', $retailer->dis_phone)->first();
    $superDistributor = $distributor ? DB::table('customer')->where('phone', $distributor->dis_phone)->first() : null;

    // Retailer Commission
    $retailerData = $this->calculateCommission($txnAmount, 'retailer', $mode, $retailer->packageId);
    $retailerCommission = $retailerData['commission'];
    $charge = $retailerData['charge'];
    $tds = $retailerData['tds'];

    // Distributor Commission
    $distributorCommission = 0;
    $distributorData = ['commission' => 0];
    if ($distributor) {
        $distributorData = $this->calculateCommission($txnAmount, 'distibuter', $mode, $distributor->packageId);
        $distributorCommission = $distributorData['commission'];
    }

    // Super Distributor Commission
    $superCommission = 0;
    $superData = ['commission' => 0];
    if ($superDistributor) {
        $superData = $this->calculateCommission($txnAmount, 'sd', $mode, $superDistributor->packageId);
        $superCommission = $superData['commission'];
    }

    // Commission Differences
    $distributorEarning = max(0, $retailerCommission - $distributorCommission);
    $superEarning = max(0, $distributorCommission - $superCommission);

    // 1. Retailer Balance Update
    $retailerOpening = $retailer->balance;
    $retailerClosing = $retailerOpening - $txnAmount - $charge;
    $retailerFinalBalance = $retailerClosing + ($retailerCommission - $tds);

    DB::table('customer')->where('phone', $mobile)->update(['balance' => $retailerFinalBalance]);

    DB::table('transactions_dmt_instant_pay')->where('id', $transaction->id)->update([
        'opening_balance' => $retailerOpening,
        'closing_balance' => $retailerClosing,
        'commission' => $retailerCommission,
        'charges' => $charge,
        'tds' => $tds,
    ]);

    DB::table('getcommission')->insert([
        'retailermobile' => $mobile,
        'service' => 'Money Transfer',
        'sub_services' => $mode,
        'externalRef' =>$externalRef,
        'amount'=>$txnAmount,
        'commission' => $retailerCommission,
        'tds' => $tds,
        'opening_bal' => $retailerClosing,
        'closing_bal' => $retailerClosing + ($retailerCommission - $tds),
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    // 2. Distributor Balance Update
    if ($distributor && $distributorEarning > 0) {
        $disOpening = $distributor->balance;
        $disClosing = $disOpening + $distributorEarning;

        DB::table('customer')->where('phone', $distributor->phone)->update(['balance' => $disClosing]);

        DB::table('dis_commission')->insert([
            'dis_no' => $distributor->phone,
            'services' => 'DMT1',
            'retailer_no' => $mobile,
            'commission' => $distributorEarning,
            'opening_balance' => $disOpening,
            'closing_balance' => $disClosing,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    // 3. Super Distributor Balance Update
    if ($superDistributor && $superEarning > 0) {
        $superOpening = $superDistributor->balance;
        $superClosing = $superOpening + $superEarning;

        DB::table('customer')->where('phone', $superDistributor->phone)->update(['balance' => $superClosing]);

        DB::table('dis_commission')->insert([
            'dis_no' => $superDistributor->phone,
            'services' => 'DMT1',
            'retailer_no' => $mobile,
            'commission' => $superEarning,
            'opening_balance' => $superOpening,
            'closing_balance' => $superClosing,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

     $balance = DB::table('customer')
     ->where('phone', $mobile)
     ->value('balance');
     // Store the retrieved balance in the session
     session(['balance'=> $balance]);

    $apiBalance = ApiHelper::decreaseBalance(env('Business_Email'), $realAmount, 'DMT');
//     dd([
//     'Retailer Commission' => $retailerCommission,
//     'Retailer TDS' => $tds,
//     'Retailer Charge' => $charge,
//     'Distributor Earning' => $distributorEarning,
//     'Super Distributor Earning' => $superEarning,
//     'Retailer Final Balance' => $retailerClosing + ($retailerCommission - $tds),
// ]);


}
private function calculateCommission($amount, $role, $mode, $packageId)
{
    $commissionRows = DB::table('commission_plan')
        ->where('packages', $role)
        ->where('service', 'DMT')
        ->where('sub_service', $mode)
        ->where('packegesId', $packageId)
        ->get();

    $charge = 0;
    $commission = 0;
    $tds = 0;

    foreach ($commissionRows as $row) {
                if ($amount >= $row->from_amount && $amount <= $row->to_amount) {
                    
                    // Calculate charge
                    $charge = $row->charge_in === 'Percentage'
                        ? ($amount * $row->charge / 100)
                        : $row->charge;
            
                    // Calculate commission
                    $commission = $row->commission_in === 'Percentage'
                        ? ($amount * $row->commission / 100)
                        : $row->commission;
            
                    // Calculate TDS
                    $tds = $row->tds_in === 'Percentage'
                        ? ($commission * $row->tds / 100)
                        : $row->tds;
            
                    break; // Stop after finding the first match
                }
            }

    return [
        'charge' => $charge,
        'commission' => $commission,
        'tds' => $tds,
    ];
}

public function beneficiaryDelete(Request $request)
{
   //return $request;die();
    $remMobile=$request->remMobile;
    // Get the outlet ID from session
    $customerOutletId = intval(session('outlet'));

    // Get mobile number from the form
      $mobile = session('mobile');
    // Define API endpoint and headers
    $url = env('liveUrl').'v1/dmt/deleteBeneficiary';
    $headers = [
        'X-Ipay-Outlet-Id' => $customerOutletId,
        'Content-Type' => 'application/json',
    ];

    // Prepare the request body
    $body = [
        'outlet' =>$customerOutletId,
        'remitterMobileNumber' => $remMobile,
        'beneficiaryId' => $request->input('beneficiaryId'),
    ];

    try {
        // Make the API request
        $response = Http::withHeaders($headers)->post($url, $body);
        $data = $response->json();
        // return $data;
        // die();
        // Check if the response contains an error
        if ($data['statuscode'] === 'OTP') {
            // Return the error response to the view
            $beneficiaryId = $data['data']['beneficiaryId'] ?? null;
            $referenceKey = $data['data']['referenceKey'] ?? null;
            $status =$data['status'] ?? '';
            session()->put('referenceKey', $referenceKey);    
            return view('user.dmtinstantpay.deleteOtp', [
                'response' => $data,
                'status' =>$status,
                'beneficiaryId' => $request->input('beneficiaryId'),
                'referenceKey' => $referenceKey,
                'mobile' => $mobile,
                'remMobile'=>$remMobile,
            ]);
        }

        // If no error, process the successful response
        return view('user.dmtinstantpay.deleteOtpError', [
            'response' => $data,
            'status' =>$data['status'] ?? '',
            'error' => $data['status'] ?? 'Unknown error',
        ]);

    } catch (\Exception $e) {
        // Handle any exceptions during the request
        return view('user.dmtinstantpay.deleteOtp', [
            'response' => null,
            'error' => 'Transaction failed: ' . $e->getMessage(),
        ]);
    }
}

   
public function DeleteVerify(Request $request)
{
    //return $request;die();
    $customerOutletId = intval(session('outlet'));
    $remMobile=$request->input('beneMobile');
    $mobile = $request->input('mobile');

    // Define API endpoint and headers
    $url = env('liveUrl').'v1/dmt/verifyDeleteBeneficiary';
    $headers = [
        
        'Content-Type' => 'application/json',
    ];

    // Prepare the request body with user input
    $body = [
        'outlet'=>$customerOutletId,
        'remitterMobileNumber' => $remMobile,
        'beneficiaryId'=>$request->input('beneficiaryId'),
        'otp' => $request->input('otp'),
        'referenceKey' =>session('referenceKey'),
    ];
    $response = Http::withHeaders($headers)->post($url, $body);
    $data = $response->json();
//    return $response;
//    die();

    return view('user.dmtinstantpay.deleteVerifyResult', [
        'response' => $data,
        'remitterMobileNumber' =>$remMobile
    ]);


}



public function getAllTransactions(Request $request)
{
    // Get the customer outlet ID from the session
    $mobile = session('mobile');
    
    // Initialize the query
    $query = DB::table('transactions_dmt_instant_pay')
               ->where('remitter_mobile_number', $mobile);

    // Apply filters if dates are provided
    if ($request->has('start_date')) {
        $query->where('created_at', '>=', $request->start_date);
    }

    if ($request->has('end_date')) {
        $query->where('created_at', '<=', $request->end_date);
    }

    // Retrieve filtered data
    $transactions = $query->orderBy('created_at', 'desc')->get();
//return $transactions;die();
    // Return the view with the filtered transactions
    return view('user.dmtinstantpay.transactionHistory', [
        'transactions' => $transactions,
    ]);
}

public function DuplicateRcpt(Request $request)
{
    $id=$request->id;
    //return $id;die();

     $response = DB::table('transactions_dmt_instant_pay')
               ->where('id', $id)->first();
               //return $response;die();
    return view('user.dmtinstantpay.dplReciept',compact('response'));
}

public function DuplicateRcptAd(Request $request)
{
    $id=$request->id;
    //return $id;die();

     $response = DB::table('transactions_dmt_instant_pay')
               ->where('id', $id)->first();
               //return $response;die();
    return view('admin.reports.dmtRcpt',compact('response'));
}

// public function getAllTransactions()
// {
//     // Get the customer outlet ID from the session
//     $mobile = session('mobile');
//     // Retrieve data from the transactions_dmt_instant_pay table based on the customerOutletId
//     $transactions = DB::table('transactions_dmt_instant_pay')
//                       ->where('remitter_mobile_number', $mobile)
//                       ->orderBy('created_at', 'desc')
//                       ->get();


//                      // return $transactions;
//     // Return the view with the filtered transactions
//     return view('user.dmtinstantpay.transactionHistory', ['transactions' => $transactions]);
// }


public function pendingTransaction(Request $request)
{
    $mobile = session('mobile');

    // Fetch transaction record
    $pendingRecord = DB::table('transactions_dmt_instant_pay')
        ->where('remitter_mobile_number', $mobile)
        ->get();

    $transactions = [];

    foreach ($pendingRecord as $record) {
        // Decode response_data
        $responseData = json_decode($record->response_data, true);

        // Check if statuscode is "TXN"
        if (isset($responseData['statuscode']) && $responseData['statuscode'] === "TUP") {
            $transactions[] = [
                'id' => $record->id,
                'remitter_mobile' => $record->remitter_mobile_number,
                'beneficiary_account' => $responseData['data']['beneficiaryAccount'] ?? null,
                'beneficiary_ifsc' => $responseData['data']['beneficiaryIfsc'] ?? null,
                'beneficiary_name' => $responseData['data']['beneficiaryName'] ?? null,
                'txn_value' => $responseData['data']['txnValue'] ?? null,
                'txn_reference_id' => $responseData['data']['txnReferenceId'] ?? null,
                'external_ref' => $responseData['data']['externalRef'] ?? null,
                'pool_reference_id' => $responseData['data']['poolReferenceId'] ?? null,
                'opening_balance' => $record->opening_balance,
                'closing_balance' => $record->closing_balance,
                'charges' => $record->charges,
                'commission' => $record->commission,
                'tds' => $record->tds,
                'created_at' => $record->created_at
            ];
        }
    }

    // Return JSON if the request is an API call
    if ($request->wantsJson()) {
        return response()->json([
            'success' => true,
            'transactions' => $transactions
        ]);
    }

    // Return data for Blade view
    return view('user.dmtinstantpay.dmtPendingTransaction', compact('transactions'));
}

public function pendingTransaction_api()
{
    

    

    // Fetch transaction record
    $pendingRecord = DB::table('transactions_dmt_instant_pay')
    ->orderBy('id', 'desc') // Sort by ID in descending order
    ->get();


    $transactions = [];

    foreach ($pendingRecord as $record) {
        // Decode response_data
        $responseData = json_decode($record->response_data, true);
        
        // Ensure response_data contains 'data' key
        $data = $responseData['data'] ?? [];

        // Check if statuscode is "TXN"
        if (isset($responseData['statuscode']) && $responseData['statuscode'] === "TUP") {
            $transactions[] = [
                'id' => $record->id,
                'remitter_mobile' => $record->remitter_mobile_number,
                'beneficiary_account' => $data['beneficiaryAccount'] ?? null,
                'beneficiary_ifsc' => $data['beneficiaryIfsc'] ?? null,
                'beneficiary_name' => $data['beneficiaryName'] ?? null,
                'txn_value' => $data['txnValue'] ?? null,
                'txn_reference_id' => $data['txnReferenceId'] ?? null,
                'external_ref' => $data['externalRef'] ?? null,
                'pool_reference_id' => $data['poolReferenceId'] ?? null,
                'opening_balance' => $record->opening_balance,
                'closing_balance' => $record->closing_balance,
                'charges' => $record->charges,
                'commission' => $record->commission,
                'tds' => $record->tds,
                'created_at' => $record->created_at
            ];
        }
    }

    // Return JSON response
    return response()->json([
        'success' => true,
        'message' => count($transactions) > 0 ? 'Pending transactions found' : 'No pending transactions available',
        'transactions' => $transactions
    ]);
}

public function pendingResponse(Request $request)
{
    \Log::info('Received Pending DMT Data:', $request->all());

    // Extract top-level externalRef
    $topLevelExternalRef = $request->externalRef;

    // Optional: Also extract nested externalRef inside data key if needed
    $nestedExternalRef = $request->input('data.externalRef');

    // For safety, log both
    \Log::info("Top Level externalRef: " . $topLevelExternalRef);
    \Log::info("Nested externalRef from data: " . $nestedExternalRef);

    // Use the top-level externalRef to update the record
    $updatePending = DB::table('transactions_dmt_instant_pay')
        ->where('reference_key', $topLevelExternalRef)
        ->update([
            'response_data' => json_encode($request->all())
        ]);

    // Optional: Return a confirmation response
    return response()->json([
        'success' => true,
        'message' => 'Pending transaction data received and stored.',
        'externalRef' => $topLevelExternalRef
    ]);
}


}