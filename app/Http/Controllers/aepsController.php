<?php

namespace App\Http\Controllers;

use App\Models\aepsCashWithdrawal;
use App\Services\AEPSService;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Helpers\ApiHelper;
class aepsController extends Controller
{
    public function showForm()
    {
        $mobile = session('mobile');
        $latestTransactions = DB::table('cash_withdrawals')
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

                return [
                    'amount' => $transaction->amount,
                    'transactionAmount' => isset($responseData['data']['transactionValue']) ? $responseData['data']['transactionValue'] : 'N/A',
                    'date' => \Carbon\Carbon::parse($transaction->created_at)->format('d M Y, h:i A'),
                    'status' => $statusDisplay,  // Display Success or Failed
                ];
            });

        // Pass the transactions to the view
        return view('user.AEPS.cash-withdrawal', compact('latestTransactions'));
    }

    public function balanceInquiry_show()
    {
        return view(
            'user.AEPS.balance-enquiry',
        );
        // return view('user.AEPS.balance-enquiry');
    }

    public function miniStatement()
    {
        return view(
            'user.AEPS.mini-statement',
        );
        // return view('user.AEPS.balance-enquiry');
    }

    public function outlet_show()
    {
        return view('user.AEPS.outlet-login-status-form');
    }

    public function outletLog()
    {
        return view('user.AEPS.outlet-login-form');
    }

    public function checkOutletLoginStatus()
    {
        //return "hello";die();
        // Retrieve the customer's name (stored in session as 'pin')
        $customerOutletId = intval(session('outlet'));  // 'pin' holds the customer's name
        //  return $customerName;
        //  die();
        $response = Http::withHeaders([
        
            'Content-Type' => 'application/json',
        ])->post(env('liveUrl') .'v1/aeps/outletLoginStatus', [
            'outLet'=>$customerOutletId
        ]);

        $data = json_decode($response->getBody()->getContents(), true);
        $act=$data['actcode'];
        //return $data;die();

        if($act=='LOGINREQUIRED')
        {
            //return route('outlet-login/aeps.form');
            return view('user.AEPS.outlet-login-form');
        }
        else if($act=='LOGGEDIN')
        {
           return redirect()->route('cash.withdrawal.form');

        }
        else{
        return view('user.AEPS.outlet-login-status-result', compact('data'));

        }
    }

    public function outletLogin(Request $request)
    {  
      //  return $request;die();
         $mobile=session('mobile');
        $realAmount=0.95;
        // Validate inputs
        $amountTr=50;
        $getAmount=DB::table('customer')
    ->where('username', session('username'))
    ->value('balance');
    
         if($getAmount < $realAmount) 
         {
           // return $getAmount;die();
            return back()->with('alert', 'Insufficient balance.');
         }
        $request->validate([
            'type' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'aadhaar' => 'required|digits:12',  // Aadhaar number must be 12 digits
            'biometricData' => 'required',  // Ensure valid JSON
        ]);
    //   return $request;
    //   die();
        // Generate a unique transaction ID for externalRef
        $externalRef = uniqid('TXN', true);

        // Prepare headers for the API request
        $customerOutletId = intval(session('outlet'));
        $headers = [
            'Content-Type' => 'application/json',
        ];

        // API request payload
        $payload = [
            'outLet' =>$customerOutletId,
            'type' => $request->input('type'),
            'latitude' => $request->input('latitude'),
            'longitude' => $request->input('longitude'),
            'aadhaar' => $request->input('aadhaar'),
            'externalRef' => $externalRef,
            'biometricData' => $request->input('biometricData'),
        ];

        // Send the data to the API
        $response = Http::withHeaders($headers)->post(env('liveUrl').'v1/aeps/outletLogin', $payload);
        $responseData = $response->json();
        // return $response;
        // die();
        // Determine response status
        if ($responseData['statuscode'] === 'ERR') {
            $message = $responseData['status'] ?? $responseData['message'] ?? '';
            $type = 'error';
        } elseif ($responseData['statuscode'] === 'TXN') {
            $message = $responseData['status'] ?? $responseData['message'] ?? '';
            $type = 'success';
            $apiBalance = ApiHelper::decreaseBalance(env('Business_Email'), $realAmount, 'AePS Bio Auth Fee');

            DB::table('customer')
            ->where('phone', $mobile)
            ->decrement('balance', $realAmount);


        } else {
            $message = $responseData['status'] ?? $responseData['message'] ?? '';
            $type = 'unknown';
        }

        $data = $responseData['data'] ?? null;
        $pool = $data['pool'] ?? [];
        // return $response->json();
        // die();
        // Pass data to the view
        return view('user.AEPS.outletLoginResult', compact('responseData', 'message', 'type', 'pool', 'data'));
    }

    public function balanceInquiry(Request $request)
    {
       
        $externalRef = uniqid('TXN', true);

        // Prepare headers for the API request
        $customerOutletId = intval(session('outlet'));
        $headers = [
            'Content-Type' => 'application/json',
        ];

        // API request payload
        $payload = [
                    'outLet' =>$customerOutletId,
                    'bankiin' => $request->input('bankiin'),
                    'latitude' => $request->input('latitude'),
                    'longitude' => $request->input('longitude'),
                    'aadhaar' => $request->input('aadhaarNumber'),
                    'mobile' => $request->input('mobile'),
                    'externalRef' => $externalRef,
                    'biometricData' => $request->input('biometricData'),
        ];

        // Send the data to the API
        $response = Http::withHeaders($headers)->post(env('liveUrl').'v1/aeps/balanceInquiry', $payload);
        $responseData = $response->json();
        // return $response;
        // die();
        // Determine response status
        if ($responseData['statuscode'] === 'TXN') {
            return view('user.AEPS.balanceEQResponse', ['response' => $responseData]);
          
        } else {
            return view('user.AEPS.balanceEQResponse', [
                'response' => [
                    'status' => $responseData['status'] ?? $responseData['message'] ?? '',
                    'data' =>null,
                    'timestamp' => now()->toDateTimeString(),
                    'orderid' => $responseData['orderid'] ?? '',
                    'message' => $responseData['status'] ?? $responseData['message'] ?? ''
                ]
            ]);
        }

        
    }
       
    

    public function balanceStatement(Request $request)
    {
        $externalRef = uniqid('TXN', true);

        // Prepare headers for the API request
        $customerOutletId = intval(session('outlet'));
        $headers = [
            'Content-Type' => 'application/json',
        ];

        // API request payload
        $payload = [
                    'outLet' =>$customerOutletId,
                    'bankiin' => $request->input('bankiin'),
                    'latitude' => $request->input('latitude'),
                    'longitude' => $request->input('longitude'),
                    'aadhaar' => $request->input('aadhaarNumber'),
                    'mobile' => $request->input('mobile'),
                    'externalRef' => $externalRef,
                    'biometricData' => $request->input('biometricData'),
        ];

        // Send the data to the API
        $response = Http::withHeaders($headers)->post(env('liveUrl').'v1/aeps/miniStatement', $payload);
        $responseData = $response->json();
        // return $response;
        // die();
        // Determine response status
        if ($responseData['statuscode'] === 'TXN') {
           // return view('user.AEPS.balanceEQResponse', ['response' => $responseData]);
            return view('user.AEPS.balanceSTEesponse', ['response' => $responseData]);
          
        } else {
            return view('user.AEPS.balanceSTEesponse', [
                'response' => [
                    'status' => $responseData['status'] ?? $responseData['message'] ?? '',
                    'data' =>null,
                    'timestamp' => now()->toDateTimeString(),
                    'orderid' => $responseData['orderid'] ?? '',
                    'message' => $responseData['status'] ?? $responseData['message'] ?? ''
                ]
            ]);
        }

       

       
    }

    public function cashWithdrawal(Request $request)
    {
        
        $getAmount = session('balance');
        $opb = $getAmount;
        $aadhaarNumber = $request->input('aadhaarNumber');
        $encryptionKey = env('IPAY_KEY');  // Ensure this is set in your .env file
        $role = session('role');

        
            $externalRef = uniqid('TXN', true);

            // Prepare headers for the API request
            $customerOutletId = intval(session('outlet'));
            $headers = [
                'Content-Type' => 'application/json',
            ];
    
            // API request payload
            $payload = [
                'outLet' =>$customerOutletId,
                'bankiin' => $request->input('bankiin'),
                'latitude' => $request->input('latitude'),
                'longitude' => $request->input('longitude'),
                'aadhaar' => $request->input('aadhaarNumber'),
                'mobile' => $request->input('mobile'),
                'amount' => $request->input('amount'),
                'externalRef' => $externalRef,
                'biometricData' => $request->input('biometricData'),
            ];
    
            // Send the data to the API
            $response = Http::withHeaders($headers)->post(env('liveUrl').'v1/aeps/cashWithdrawal', $payload);
            $responseData = $response->json();
      
            // Parse API response
            //$responseData = json_decode($response->getBody(), true);
            // return $responseData;
            // die();
            // Store transaction data
            
            DB::table('cash_withdrawals')->insert([
                'aadhaar_encrypted' => $request->input('aadhaarNumber'),
                'mobile' => session('mobile'),
                'external_ref' => $externalRef,
                'amount' => $request->input('amount'),
                'biometric_data' => json_encode($request->input('biometricData'),),
                'response_data' => json_encode($responseData),
                'opening_balance' => $opb,
                'closing_balance' => $opb,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            if ($responseData['statuscode'] == 'TXN') {
                $this->updateCustomerBalance(session('mobile'), session('role'), $externalRef);
            }
            // Update customer balance for the last transaction
            //return view('user.AEPS.cashWithdrawalResult', compact('responseData', 'status'));

            if ($responseData['statuscode'] === 'TXN') {
                $status = $responseData['status'] ?? $responseData['message'] ?? '';
                // Return success view
                return view('user.AEPS.cashWithdrawalResult', compact('responseData', 'status'));
               
             } else {
                return view('user.AEPS.cashWithdrawalResult', [
                    'status' => $responseData['status'] ?? $responseData['message'] ?? '',
                    'data' =>null,
                    'timestamp' => now()->toDateTimeString(),
                    'orderid' => $responseData['orderid'] ?? '',
                    'message' => $responseData['status'] ?? $responseData['message'] ?? ''
                ]);
             }
    }

    /**
     * Update the customer's balance for the last transaction.
     */
    public function testDemo()
    {
        // return "Hello";
        // die();
        // $email=env('Business_Email');
        // return $email;die();
        $mobile = session('mibile');
        $role = session('role');
        $externalRef = 'APAePS-' . strtoupper(uniqid(date('YmdHis')));
        $customerOutletId = intval(session('outlet'));
        //$externalRef = 'APAePS-' . strtoupper(uniqid(date('YmdHis')));
        // $externalRef = 'APAePS-' . date('Ymd') . '' . str_pad(mt_rand(1, 999), 3, '0', STR_PAD_LEFT);
        $externalRef = 'APAePS' . date('Y') . '' . round(microtime(true) * 1000);

        $this->updateCustomerBalance(session('mobile'), session('role'), $externalRef);
    }
   private function updateCustomerBalance($mobile,$role,$externalRef)
{
   

    $transaction = DB::table('cash_withdrawals')
            ->where('mobile', $mobile)
            ->latest('created_at')
            ->first();

    if (!$transaction) return;

    $response_data = json_decode($transaction->response_data, true);
    if (!isset($response_data['data']['transactionValue']) || !in_array($response_data['statuscode'], ['TXN', 'TUP'])) return;

    $txnAmount = $response_data['data']['transactionValue'];
    $realAmount = $response_data['data']['transactionValue'];


    // Retailer info
    $retailer = DB::table('customer')->where('phone', $mobile)->first();
    if (!$retailer) return;

    // Distributor & Super Distributor info
    $distributor = DB::table('customer')->where('phone', $retailer->dis_phone)->first();
    $superDistributor = $distributor ? DB::table('customer')->where('phone', $distributor->dis_phone)->first() : null;

    // Retailer Commission
    $retailerData = $this->calculateCommission($txnAmount, 'retailer', $retailer->packageId);
    $retailerCommission = $retailerData['commission'];
    $charge = $retailerData['charge'];
    $tds = $retailerData['tds'];

    // Distributor Commission
    $distributorCommission = 0;
    $distributorData = ['commission' => 0];
    if ($distributor) {
        $distributorData = $this->calculateCommission($txnAmount, 'distibuter', $distributor->packageId);
        $distributorCommission = $distributorData['commission'];
    }

    // Super Distributor Commission
    $superCommission = 0;
    $superData = ['commission' => 0];
    if ($superDistributor) {
        $superData = $this->calculateCommission($txnAmount, 'sd', $superDistributor->packageId);
        $superCommission = $superData['commission'];
    }

    // Commission Differences
    $distributorEarning = max(0, $retailerCommission - $distributorCommission);
    $superEarning = max(0, $distributorCommission - $superCommission);

    // 1. Retailer Balance Update
    $retailerOpening = $retailer->aepsWallet;
    $retailerClosing = $retailerOpening + $txnAmount - $charge;
    $retailerFinalBalance = $retailerClosing + ($retailerCommission - $tds);

    DB::table('customer')->where('phone', $mobile)->update(['aepsWallet' => $retailerFinalBalance]);

    DB::table('cash_withdrawals')->where('id', $transaction->id)->update([
        'opening_balance' => $retailerOpening,
        'closing_balance' => $retailerClosing,
        'commissions' => $retailerCommission,
        'tds' => $tds,
    ]);

    DB::table('getcommission')->insert([
        'retailermobile' => $mobile,
        'service' => 'AEPS',
        'sub_services' => 'cash_withdrawals',
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
            'services' => 'AEPS',
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
            'services' => 'AEPS',
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
    $apiBalance = ApiHelper::increaseBalance(env('Business_Email'), $realAmount, 'AEPS');

 
//     // dd([
//     // 'Retailer Commission' => $retailerCommission,
//     // 'Retailer TDS' => $tds,
//     // 'Retailer Charge' => $charge,
//     // 'Distributor Earning' => $distributorEarning,
//     // 'Super Distributor Earning' => $superEarning,
//     // 'Retailer Final Balance' => $retailerClosing + ($retailerCommission - $tds),
//     // 'API DOCS' =>$apiBalance,
// ]);


}
private function calculateCommission($amount, $role, $packageId)
{
    $commissionRows = DB::table('commission_plan')
        ->where('packages', $role)
        ->where('service', 'AEPS')
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


    
    public function history(Request $request)
    {
        $mobile = session('mobile');

        // Get date inputs from the request
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Build the query
        $query = DB::table('cash_withdrawals')
            ->where('mobile', $mobile);

        // Apply date filtering if both start and end dates are provided
        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        // Get the results
        $withdrawals = $query->orderBy('created_at', 'desc')->get();

        // Return the view with the filtered results
        return view('user.AEPS.historyAeps', ['withdrawals' => $withdrawals]);
    }

    public function showCashWithdrawalForm()
    {
        // Fetch the 5 latest transactions from the database
    }

    public function cashDepositForm()
    {
        return view('user.AEPS.cash_deposit');
    }
    public function cashDeposit(Request $request)
    {
        return $request;
    }

    public function walletTxnForm()
    {
        return view('user.AEPS.aepsWalletTxn');
    }


public function transfer(Request $request)
{
    $request->validate([
        'amount' => 'required|numeric|min:1',
        'remarks' => 'nullable|string|max:255',
    ]);

    $email = session('email');
    $mobile=session('mobile');
    $txnAmount = $request->amount;
    $remark = $request->remarks;

    $avlBalanceAEPS = DB::table('customer')->where('email', $email)->value('aepsWallet');
    $usableBalance = $avlBalanceAEPS - 50;

    if ($usableBalance >= $txnAmount) {
        DB::beginTransaction();
        try {
            $openingBal = $avlBalanceAEPS;
            $closingBal = $openingBal - $txnAmount;

            // Update balances
            DB::table('customer')->where('email', $email)->decrement('aepsWallet', $txnAmount);
            DB::table('customer')->where('email', $email)->increment('balance', $txnAmount);

            $responseData = [
    
        "success" => true,
        "actcode" => null,
        "statuscode" => "TXN",
        "status" => "AePS Wallet Transfer To Main Wallet",
        "data" => [
            "externalRef" => "",
            "bankName" => "",
            "accountNumber" => "",
            "ipayId" => "",
            "transactionMode" => "CR",
            "payableValue" => "",
            "transactionValue" => $txnAmount,
            "openingBalance" => $openingBal,
            "closingBalance" => $closingBal,
            "operatorId" => "",
            "walletIpayId" => "",
            "bankAccountBalance" => "",
            "miniStatement" => []
        ],
        "timestamp" => "",
        "ipay_uuid" => "",
        "orderid" => "",
        "environment" => "LIVE"
    
];

            // Log transaction
            DB::table('aeps_wallet_transfers')->insert([
                'email' => $email,
                'amount' => $txnAmount,
                'remarks' => $remark,
                'from_wallet' => 'AEPS',
                'to_wallet' => 'Main',
                'openingBal' => $openingBal,
                'closingBal' => $closingBal,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

              DB::table('cash_withdrawals')->insert([
                'aadhaar_encrypted' => " ",
                'mobile' => session('mobile'),
                'external_ref' => "",
                'amount' => $txnAmount,
                'biometric_data' =>" ",
                'response_data' => json_encode($responseData),
                'opening_balance' => $openingBal,
                'closing_balance' => $closingBal,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $currentBalance = DB::table('customer')->where('email', $email)->value('balance');
            session(['balance' => $currentBalance]);

            $avlBalance = $currentBalance - $txnAmount;
         DB::table('wallet_transfers')->insert([
                    'sender_id' => session('username'),
                    'receiver_id' => "Self",
                    'amount' => $txnAmount,
                    'opening_balance' => $avlBalance,
                    'closing_balance' => $currentBalance,
                    'charges' => 0,
                    'tds' => 0,
                    'remark' => $remark,
                    'transfer_id' => "",
                    'type' => 'Credit',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

            // ✅ Print both updated balances for verification
            $finalAEPSBalance = DB::table('customer')->where('email', $email)->value('aepsWallet');
            $finalMainBalance = DB::table('customer')->where('email', $email)->value('balance');

            // You can use either one:
            // Option 1: Log for later debugging
            Log::info("Transfer Debug:", [
                'finalAEPSBalance' => $finalAEPSBalance,
                'finalMainBalance' => $finalMainBalance
            ]);

            // Option 2: Temporary print
            // dd([
            //     'finalAEPSBalance' => $finalAEPSBalance,
            //     'finalMainBalance' => $finalMainBalance
            // ]);

            DB::commit();
            return back()->with('success', 'Transfer successful!');
        } catch (\Exception $e) {
            DB::rollBack();
            // Optional: log the error
            Log::error("Transfer Failed: " . $e->getMessage());

            return back()->with('error', 'Transfer failed. Please try again.');
        }
    } else {
        return back()->with('error', 'Insufficient AEPS balance. ₹50 must remain in wallet.');
    }
}



public function aepsTxn()
{
    $email=session('email');
   
    $getLadger = DB::table('aeps_wallet_transfers')
    ->where('email', $email)
    ->orderBy('id', 'desc')
    ->get();

    //return $getLadger;die();
    return view('user.aeps.aepsToWallet',compact('getLadger'));
}


}