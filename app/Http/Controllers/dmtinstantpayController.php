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
    // return $request;
     $mobile = $request->input('mobile');
    $account = $request->input('account');
    $ifsc = $request->input('ifsc');
    $referenceKey = $request->input('referenceKey');
    return view('user.dmtinstantpay.send-money-form', compact('mobile', 'account', 'ifsc', 'referenceKey'));
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
// return $response->json();
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
    $getAmount=session('balance');
    $totalAmount=$getAmount;
    $lockAmount=session('lockBalance');
    $getAmount-=50;
 
// dd($totalAmount,$getAmount);
// die();

if ($totalAmount < $amountTr)
{
    
    return back()->with('alert', 'Unable to proceed. Please connect your Admin.');
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
    $getAmount=session('balance');
    $opb=$getAmount;
    $getAmount-=50;
// return $getAmount;
// die();

$balance = ApiHelper::getBalance(env('Business_Email'));
if ($balance >= $getAmount && $getAmount > $amountTr) 
    if($getAmount > $amountTr)  //450 > 400
    {

        
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
                'reference_key' => $request->input('transferMode'),
                'customer_outlet_id' => $customerOutletId,  // Store customerOutletId
                'response_data' => json_encode($data),
                'opening_balance' =>$opb,
                'closing_balance' =>$opb,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $mode=$request->input('transferMode');
            if($data['statuscode']=="TXN")
            {
                //$this->updateCustomerBalance(session('mobile'),'mode');
                $this->updateCustomerBalance(session('mobile'), $mode,$role,$externalRef);
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
private function updateCustomerBalance($mobile,$mode,$role,$externalRef)
{ //dd('hello');
    //die()
    $closing_bl = 0;;
    $getDisComm=0;
    $ff=0;
    $comA=0;
    $tds=0;
    // Fetch the latest transaction for the given mobile number
    $lastRecord = DB::table('transactions_dmt_instant_pay')
        ->where('remitter_mobile_number', $mobile)
        ->latest('created_at') // Sort by created_at to get the most recent record
        ->first();
        // dd($lastRecord);
        // die();

    if ($lastRecord) {
        // Decode the response data from the latest transaction
        $response_data = json_decode($lastRecord->response_data, true);

        // Check if payableValue exists and update the balance
        if (isset($response_data['data']['txnValue'])  && isset($response_data['statuscode']) && $response_data['statuscode'] === 'TXN') {
            $payableValue = $response_data['data']['txnValue'];
            

            $getCommission = DB::table('commission_plan')
            ->where('packages', $role)
            ->where('service', 'DMT')
            ->where('sub_service',$mode)
            ->get();

            $commissionAmount = 0;
            $comA=0;
            $tds=0;
            // return $getCommission;
            // die();
            foreach ($getCommission as $commission) {
                // Check if the payable value falls within the commission range
                if ($payableValue >= $commission->from_amount && $payableValue <= $commission->to_amount) {
                   
                    // Initialize variables
                    $commissionAmount = 0;
                    $comA = 0;
                    $tds = 0;
            
                    // Calculate charge (percentage or fixed)
                    if ($commission->charge_in === 'Percentage') {
                        $commissionAmount = $payableValue * $commission->charge / 100;
                    } else { // Fixed amount
                        $commissionAmount = $commission->charge;
                    }
            
                    // Calculate commission (percentage or fixed)
                    if ($commission->commission_in === 'Percentage') {
                        $comA = $commissionAmount * $commission->commission / 100;
                    } else { // Fixed amount
                        $comA = $commission->commission;
                    }
            
                    // Calculate TDS (percentage or fixed)
                    if ($commission->tds_in === 'Percentage') {
                        $tds = $comA * $commission->tds / 100;
                    } else { // Fixed amount
                        $tds = $commission->tds;
                    }
            
                    // Update the payable value
                    $payableValue += ($commissionAmount);
            
                    // Exit the loop once the relevant commission range is found and applied
                    break;
                }
            }
           
        //dd($commission->commission);
        // $opening_bl=$response_data['data']['txnValue'];
        // $closing_bl=$payableValue;


        $opening_bl=session('balance');
        $closing_bl=session('balance')-$payableValue;

        
        
            // // Update the customer's balance
            // DB::table('customer')
            //     ->where('phone', $mobile)
            //     ->decrement('balance', $payableValue);


                $getDis = DB::table('customer')
                ->where('phone', $mobile)
                ->first(); // Fetch the first record


               
            if ($getDis) {
                
                $disPhone=$getDis->dis_phone;

            if ($getDis && is_null($getDis->dis_phone)) {
                $getDisComm =0;
                $newpayableValue=$payableValue;
            } else {
               // echo "Dis not Done";
               $getDisComm += $payableValue * 0.01/100;
               $newpayableValue=$payableValue+$getDisComm;
              
            }
        }
        else
        {

        }
        // Update the distibuter's balance
        DB::table('customer')
        ->where('phone', $disPhone)
        ->increment('balance', $getDisComm);

        $disData = DB::table('customer')
        ->where('phone', $disPhone)->first();
        
if($disData)
{
    $opB=$disData->balance;
    $clB=$opB+$getDisComm;
    $dis_no= $disPhone;
    $ret_no=$mobile;
    $comm=$getDisComm;
    $service='DMT1';
    DB::table('dis_commission')->insert([
        'dis_no' => $dis_no,
        'services'=>$service,
        'retailer_no' =>$ret_no ,
        'commission' => $comm, // Store customerOutletId
        'opening_balance' => $opB,
        'closing_balance' => $clB,
        'created_at' => now(),
        'updated_at' => now(),
    ]);
}

         // Update the customer's balance
        



        $latestTransaction = DB::table('transactions_dmt_instant_pay')
    ->where('remitter_mobile_number', $mobile)
    ->latest('created_at') // Fetch the latest record based on created_at
    ->first();

if ($latestTransaction) {
        DB::table('transactions_dmt_instant_pay')
        ->where('id', $latestTransaction->id)
        // Ensure this condition matches the correct record
        ->update([
            'opening_balance' => $opening_bl,
            'closing_balance' => $closing_bl,
            'charges'=>$commissionAmount,
            'tds'=>$tds,
            'commission'=>$comA
        ]);
    }

    $nowOp=$closing_bl;
    $nowCl=$closing_bl+($comA-$tds);
    $coms=$comA;
    //dd($nowCl,$nowOp,$coms);
    

    DB::table('getcommission')->insert([
        'retailermobile' => $mobile,
        'service'=>'Money Transfer',
        'sub_services' => 'IMPS', // Store customerOutletId
        'opening_bal' => $nowOp,
        'commission' => ($comA-$tds),
        'tds' => $tds,
        'externalRef'=>$externalRef,
        'amount' => $payableValue,
        'closing_bal' => $nowCl,
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    DB::table('customer')
    ->where('phone', $mobile)
    ->decrement('balance', $newpayableValue-($comA-$tds));
     //DMT Balance Update
     $balance = DB::table('customer')
     ->where('phone', $mobile)
     ->value('balance');
     // Store the retrieved balance in the session
     session(['balance'=> $balance]);

     $apiBalance = ApiHelper::decreaseBalance(env('Business_Email'), $newpayableValue-($comA-$tds), 'DMT');
     
    //  DB::table('business')
    //  ->where('business_id', session('business_id'))
    //  ->decrement('balance', $newpayableValue-($comA-$tds));    

$balanceAd = DB::table('business')
->where('business_id', session('business_id'))
->value('balance');
// Store the retrieved balance in the session
session(['adminBalance'=> $balanceAd]);

            // Store the last transaction amount in the session
            session(['totalPayableValue' => $newpayableValue-($comA-$tds)]);
        } else {
            session(['totalPayableValue' => 0]); // No payable value in the last transaction
        }
    } else {
        session(['totalPayableValue' => 0]); // No transactions found
    }
    
   
   //dd('ok');
   //dd($apiBalance);
   // dd($opB,$clB,$dis_no,$ret_no,$comm,$service,$disData,$disPhone,$getDis->dis_phone,$ff,$payableValue,$newpayableValue,$commission->charge,$commission->charge_in,$mode,$commissionAmount,$commissionAmount,$comA,$tds,$getDis,$getDisComm);
}



public function beneficiaryDelete(Request $request)
{
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
        'remitterMobileNumber' => $mobile,
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
    // return $status;
    // die();
            return view('user.dmtinstantpay.deleteOtp', [
                'response' => $data,
                'status' =>$status,
                'beneficiaryId' => $request->input('beneficiaryId'),
                'referenceKey' => $referenceKey,
                'mobile' => $mobile,
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
    //return $request;
    $customerOutletId = intval(session('outlet'));

    $mobile = $request->input('mobile');

    // Define API endpoint and headers
    $url = env('liveUrl').'v1/dmt/verifyDeleteBeneficiary';
    $headers = [
        
        'Content-Type' => 'application/json',
    ];

    // Prepare the request body with user input
    $body = [
        'outlet'=>$customerOutletId,
        'remitterMobileNumber' => $mobile,
        'beneficiaryId'=>$request->input('beneficiaryId'),
        'otp' => $request->input('otp'),
        'referenceKey' => $request->input('referenceKey'),
    ];
    $response = Http::withHeaders($headers)->post($url, $body);
    $data = $response->json();
//    return $data;
//    die();

    return view('user.dmtinstantpay.deleteVerifyResult', [
        'response' => $data
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

    // Return the view with the filtered transactions
    return view('user.dmtinstantpay.transactionHistory', [
        'transactions' => $transactions,
    ]);
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



}