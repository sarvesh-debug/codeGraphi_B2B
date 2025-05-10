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
        // Retrieve the customer's name (stored in session as 'pin')
        $customerOutletId = intval(session('outlet'));  // 'pin' holds the customer's name
        //  return $customerName;
        //  die();
        $response = Http::withHeaders([
        
            'Content-Type' => 'application/json',
        ])->post(env('liveUrl') .'v1/aeps/outletLoginStatus', [
            
        ]);

        $data = json_decode($response->getBody()->getContents(), true);

        // return $data;
        return view('user.AEPS.outlet-login-status-result', compact('data'));
    }

    public function outletLogin(Request $request)
    {   $mobile=session('mobile');
        $realAmount=0.95;
        // Validate inputs
        $request->validate([
            'type' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'aadhaar' => 'required|digits:12',  // Aadhaar number must be 12 digits
            'biometricData' => 'required|json',  // Ensure valid JSON
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
        // return $response->json();
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
        $mobile = session('mibile');
        $role = session('role');
        $externalRef = 'APAePS-' . strtoupper(uniqid(date('YmdHis')));
        $customerOutletId = intval(session('outlet'));
        //$externalRef = 'APAePS-' . strtoupper(uniqid(date('YmdHis')));
        // $externalRef = 'APAePS-' . date('Ymd') . '' . str_pad(mt_rand(1, 999), 3, '0', STR_PAD_LEFT);
        $externalRef = 'APAePS' . date('Y') . '' . round(microtime(true) * 1000);

        $this->updateCustomerBalance(session('mobile'), session('role'), $externalRef);
    }
    private function updateCustomerBalance($mobile, $role, $externalRef)
    {
        $payableValue = 0;
        $commissionAmount = 0;
        $tds = 0;
        $distributorCommission = 0;
        $realAmount=0;
        // Fetch the latest transaction for the given mobile number
        $lastTransaction = DB::table('cash_withdrawals')
            ->where('mobile', $mobile)
            ->latest('created_at')
            ->first();
    
        if ($lastTransaction) {
            $responseData = json_decode($lastTransaction->response_data, true);
    
            if (isset($responseData['data']['transactionValue']) && $responseData['statuscode'] === 'TXN') {
                $payableValue = $responseData['data']['transactionValue'];
                $realAmount=$responseData['data']['transactionValue'];
    
                // Fetch commission details
                $commissionPlans = DB::table('commission_plan')
                    ->where('packages', $role)
                    ->where('service', 'AEPS')
                    ->get();
    
                foreach ($commissionPlans as $plan) {
                    if ($payableValue >= $plan->from_amount && $payableValue <= $plan->to_amount) {
                        $commissionAmount = ($plan->commission_in === 'Percentage')
                            ? ($payableValue * $plan->commission / 100)
                            : $plan->commission;
    
                        $tds = ($plan->tds_in === 'Percentage')
                            ? ($commissionAmount * $plan->tds / 100)
                            : $plan->tds;
                        break;
                    }
                }
            }
        }
    
        $openingBalance = session('balance');
        $closingBalance = $openingBalance + ($payableValue + ($commissionAmount - $tds));
    
        // Fetch distributor details
        $customer = DB::table('customer')->where('phone', $mobile)->first();
        if ($customer && !is_null($customer->dis_phone)) {
            $distributorPhone = $customer->dis_phone;
            $distributorCount = DB::table('customer')->where('dis_phone', $distributorPhone)->count();
    
            if ($distributorCount > 0) {
                $distributorCommissionData = DB::table('map_commission_plan')
                    ->where('service', 'AEPS')
                    ->whereRaw('? BETWEEN from_rt_count AND to_rt_count', [$distributorCount])
                    ->selectRaw(
                        "CASE 
                            WHEN commission_in = 'Percentage' THEN ? * commission / 100 
                            ELSE commission 
                        END AS commission_value",
                        [$payableValue]
                    )
                    ->first();
                
                $distributorCommission = $distributorCommissionData->commission_value ?? 0;
            }
        }
    
        // Update distributor balance
        if ($distributorCommission > 0) {
            $distributorData = DB::table('customer')->where('phone', $distributorPhone)->first();
            if ($distributorData) {
                DB::table('customer')
                    ->where('phone', $distributorPhone)
                    ->increment('balance', $distributorCommission);
                
                DB::table('dis_commission')->insert([
                    'dis_no' => $distributorPhone,
                    'services' => 'AEPS',
                    'retailer_no' => $mobile,
                    'commission' => $distributorCommission,
                    'opening_balance' => $distributorData->balance,
                    'closing_balance' => $distributorData->balance + $distributorCommission,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    
        // Update customer's latest transaction balances
        if ($lastTransaction) {
            DB::table('cash_withdrawals')
                ->where('id', $lastTransaction->id)
                ->update([
                    'opening_balance' => $openingBalance,
                    'closing_balance' => $closingBalance,
                    'commissions' => $commissionAmount,
                    'tds' => $tds,
                ]);
        }
    
        // Insert commission details
        DB::table('getcommission')->insert([
            'retailermobile' => $mobile,
            'service' => 'AEPS',
            'sub_services' => 'aeps',
            'opening_bal' => $closingBalance,
            'commission' => $commissionAmount,
            'tds' => $tds,
            'externalRef' => $externalRef,
            'amount' => $payableValue,
            'closing_bal' => $closingBalance + $commissionAmount,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    
        // Update customer's balance
        DB::table('customer')
            ->where('phone', $mobile)
            ->increment('balance', $payableValue + ($commissionAmount - $tds));
    
        // Update session balance
        $newBalance = DB::table('customer')->where('phone', $mobile)->value('balance');
        session(['balance' => $newBalance, 'totalPayableValue' => $payableValue + ($commissionAmount - $tds)]);
        //$apiBalance = ApiHelper::increaseBalance(env('Business_Email'), $payableValue + ($commissionAmount - $tds), 'AEPS');
        $apiBalance = ApiHelper::increaseBalance(env('Business_Email'), $realAmount, 'AEPS');
      
       
        // DB::table('business')
        // ->where('business_id', session('business_id'))
        // ->increment('balance', $payableValue + ($commissionAmount - $tds));    
   
   $balanceAd = DB::table('business')
   ->where('business_id', session('business_id'))
   ->value('balance');
   // Store the retrieved balance in the session
   session(['adminBalance'=> $balanceAd]);
//dd('ok');
dd($apiBalance);
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
        return view('user.aeps.cash_deposit');
    }
    public function cashDeposit(Request $request)
    {
        return $request;
    }
}