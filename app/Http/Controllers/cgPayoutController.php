<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Helpers\ApiHelper;

use Illuminate\Support\Facades\Log;

class cgPayoutController extends Controller
{
    public function verifyUserForm()
    {
        
        
        return view('user.cgpayout.tokenGen');
        //return view('user.cgpayout.serveDown');
    }

    public function profile()
    {
        $userid = session('username');

        $beneFiciary = DB::table('payoutbeneficiary')
            ->where('userId', $userid)
            ->orderBy('id', 'desc') // or 'created_at', if available
            ->get();

        $todayTxn = DB::table('cgpayout')
    ->where('retailerId', $userid)
    ->where('status', 'CREDITED')
    ->whereDate('created_at', Carbon::today())
    ->sum('amount');

$monthTxn = DB::table('cgpayout')
    ->where('retailerId', $userid)
     ->where('status', 'CREDITED')
    ->whereMonth('created_at', Carbon::now()->month)
    ->whereYear('created_at', Carbon::now()->year)
    ->sum('amount');

$totalTxn = DB::table('cgpayout')
    ->where('retailerId', $userid)
     ->where('status', 'CREDITED')
    ->sum('amount');

        
       // return $beneFiciary;

        return view('user.cgpayout.cgpDashboard',compact('beneFiciary','todayTxn','monthTxn','totalTxn'));
    }

    public function addBeneficiaryForm()
    {
        return view('user.cgpayout.addBeneficiary');
    }
   public function addBeneficiary(Request $request)
{
    // Step 0: Validate
    $validator = Validator::make($request->all(), [
        'benename'    => 'required|string|max:100',
        'beneMobile'  => 'required|size:10',
        'accno'       => 'required|string|min:6|max:20',
        'bankname'    => 'required|string',
        'ifsc'        => 'required|string|size:11',
    ], [
        'benename.required' => 'Beneficiary name is required.',
        'beneMobile.required' => 'Mobile number is required.',
        'beneMobile.digits_between' => 'Mobile number must be exactly 10 digits.',
        'accno.required' => 'Account number is required.',
        'bankname.required' => 'Bank name is required.',
        'ifsc.required' => 'IFSC code is required.',
        'ifsc.size' => 'IFSC code must be exactly 11 characters.',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    try {
        // Step 1: Get wallet balance
        try {
            $walletAmt = DB::table('customer')
                ->where('username', session('username'))
                ->value('balance');

            if (!$walletAmt) {
                throw new \Exception('User not found or balance field missing.');
            }

            if ($walletAmt <= 10) {
                return redirect()->back()->with('error', 'Insufficient wallet balance to verify beneficiary.');
            }
        } catch (\Exception $e) {
            Log::error("Wallet Balance Check Error: " . $e->getMessage());
            return redirect()->back()->with('error', 'Unable to check wallet balance.');
        }

        // Step 2: Verify Account
        try {

//               $verificationResponse = [
//     "code" => "200",
//     "model" => [
//         "status" => "SUCCESS",
//         "clientRefNum" => "1f2205b1-3e17-4d58-adc4-0754da665e1e",
//         "transactionId" => "ce94ff80270b4007850f43c5c1ad4c4e",
//         "paymentMode" => "STANDARD",
//         "rrn" => "515913025582",
//         "beneficiaryName" => "SARVESH .",
//         "isNameMatch" => true,
//         "matchingScore" => 100,
//     ]
// ];
            $verificationResponse = Http::timeout(60)->post('https://api.codegraphi.in/api/account-verification', [
                'ifsc'            => $request->ifsc,
                'accNo'           => $request->accno,
                'benificiaryName' => $request->benename,
                'address'         => 'New Delhi',
            ]);
         
            $verification = $verificationResponse->json();
        } catch (\Exception $e) {
            Log::error("API Verification Error: " . $e->getMessage());
            return redirect()->back()->with('error', 'Verification API failed.');
        }

        // Step 3: Check verification response
        if (
            isset($verification['code']) && $verification['code'] == '200' &&
            isset($verification['model']['rrn']) && !empty($verification['model']['rrn']) &&
            isset($verification['model']['matchingScore']) && $verification['model']['matchingScore'] > 85
        ) {
            // Step 4: Deduct via API
            try {
                $deductResponse = ApiHelper::decreaseBalance(env('Business_Email'), 4, 'Bank Account Verification');

                if (!$deductResponse) {
                    throw new \Exception('API returned false or failed deduction.');
                }
            } catch (\Exception $e) {
                Log::error("API Deduction Error: " . $e->getMessage());
                return redirect()->back()->with('error', 'Failed to deduct balance via API.');
            }

            // Step 5: Deduct locally in DB
            try {
                $userDeduct = DB::table('customer')
                    ->where('username', session('username'))
                    ->decrement('balance', 4); // Fixed typo from 'balamce' to 'balance'

                     $balance = DB::table('customer')
                   ->where('username', session('username'))
                    ->value('balance');  // Store the retrieved balance in the session
                    session(['balance'=> $balance]);

                if (!$userDeduct) {
                    throw new \Exception('Local balance deduction failed.');
                }
            } catch (\Exception $e) {
                Log::error("Local DB Deduction Error: " . $e->getMessage());
                return redirect()->back()->with('error', 'Local wallet deduction failed.');
            }

            // Step 6: Save beneficiary
            try {
                DB::table('payoutbeneficiary')->insert([
                    'businessId'     => env('business_id'),
                    'businessEmail'  => env('Business_Email'),
                    'beneName'       => $request->benename,
                    'beneAccount'    => $request->accno,
                    'beneBankName'   => $request->bankname,
                    'beneIFSC'       => $request->ifsc,
                    'beneMobileNo'   => $request->beneMobile,
                    'retailerMobile' => session('mobile'),
                    'userId'         => session('username'),
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ]);
            } catch (\Exception $e) {
                Log::error("Beneficiary Save Error: " . $e->getMessage());
                return redirect()->back()->with('error', 'Failed to save beneficiary.');
            }

            return redirect()->route('usercg.verifyForm')->with('success', 'Beneficiary verified and registered successfully!');
        } else {
            Log::warning("Verification failed with response: " . json_encode($verification));
            return redirect()->back()->with('error', 'Account verification failed. Please enter correct details.');
        }
    } catch (\Exception $e) {
        Log::error('Add Beneficiary General Error: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Something went wrong. Please try again.');
    }
}

      public function deleteBeneficiary(Request $request)
{
    $request->validate([
        'beneficiaryId' => 'required|integer|exists:payoutbeneficiary,id',
    ]);

    $businessId = session('business_id'); // or use auth()->id() if logged-in user is the business

    $beneficiary = DB::table('payoutbeneficiary')
        ->where('id', $request->beneficiaryId)
        ->where('userid', session('username'))
        ->first();

    if (!$beneficiary) {
        return redirect()->back()->with('error', 'Beneficiary not found or unauthorized.');
    }

    DB::table('payoutbeneficiary')->where('id', $request->beneficiaryId)->delete();

    return redirect()->route('usercg.verifyForm')->with('success',  'Beneficiary deleted successfully!');
}
    
public function sendMoneyForm(Request $request)
{
    //return $request;
     if ($request->amount % 100 !== 0) {
        //return "hello";
        //return redirect()->back()->with('success', 'Amount must be divisible by 100.');
        return redirect()->route('payout.profile')->with('success',  'Amount must be divisible by 100.');

    }
        
    
        // ✅ Optional: Store additional data if needed
        $BusinessEmail = env('Business_Email');
        $BusinessId = env('Business_Id');
    
        // ✅ Prepare the API request using cURL
        $url = 'https://api.codegraphi.in/api/cg/token';
       // $url = 'http://127.0.0.1:8081/api/cg/token';
    
        $payload = [
            'username'     => $BusinessEmail,
            'password'     => $BusinessId,
        ];
    
        $curl = curl_init();
    
        curl_setopt_array($curl, [
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_HTTPHEADER     => ['Content-Type: application/json'],
            CURLOPT_POSTFIELDS     => json_encode($payload),
        ]);
    
        $response = curl_exec($curl);
        $error = curl_error($curl);
        curl_close($curl);
        $data = json_decode($response, true);
    // return $data;
    // die();
        
        // ✅ Handle cURL error
        if ($error) {
            return response()->json([
                'status' => false,
                'message' => 'API call failed',
                'error' => $error
            ], 500);
        }
    
        // ✅ Return API success response
        $data = json_decode($response, true);
        $token = $data['token'] ?? null;


        $charges=0;
        $tds=0;
        $newAmount=0;
        $payamount=$request->amount;
         $realAmountTx = $payamount;

        $realAmount=DB::table('customer')->where('username', session('username'))->value('balance');

        // return $token;
        // die();


        if (!$realAmount || $realAmount < $payamount) {
            return response()->json([
                'status' => false,
                'message' => 'Insufficient Wallet Balance Plese Connect Admin',
            ], 400);
        }

        $openingBal = $realAmount;
        $charges = 0;
        $tds = 0;

         if ($payamount >= 100 && $payamount < 1000) {
            $charges = 3;
            $tds = $charges * 0.02;
        } elseif ($payamount >= 1000 && $payamount < 25000) {
            $charges = 5;
            $tds = $charges * 0.02;
        }
         elseif ($payamount >=25000 && $payamount < 100000) {
            $charges = 8;
            $tds = $charges * 0.02;
        }
         elseif ($payamount >=100000 && $payamount < 150000) {
            $charges = 12;
            $tds = $charges * 0.02;
        }
        elseif ($payamount >=150000) {
            $charges = 22;
            $tds = $charges * 0.02;
        }
        $deductAmount = $payamount; // Total requested amount
        $totalDeduct = $payamount + $charges + $tds;
        $closingBal = $realAmount - $totalDeduct;

        DB::table('customer')
        ->where('username', session('username'))
        ->decrement('balance', $totalDeduct); // ✅ fixed typo from 'balanec' to 'balance'

        DB::table('cgpayout')->insert([
            
            'retailerId' =>session('username'),
            'phone' =>session('mobile'),
            'amount' => $payamount,
            'charges' => $charges,
            'tds' => $tds,
            'commission'=>0,
            'status' => 'pending',
            'openingBal' => $openingBal,
            'closingBal' => $closingBal,
            'response'=>'',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        try{
            $response = Http::withHeaders([
                // 'bearerToken' => $token, // truncate in code, store securely in .env ideally
             ])->post('https://api.codegraphi.in/api/cg/initiate-payout', [
                
                 'amount'       => $request->amount,
                 'receiverName' => $request->name,
                 'paymentMode'  => 'IMPS',
                 'ifsc' => strtoupper($request->ifsc),
                 'accountNo'    => $request->account,
                 'clientIP'     => $request->ip_address,
                 'Business_Email' =>env('Business_Email'),
                 'Business_Id' =>env('Business_Id'),
                 'token'=>$token,
                 'rtId'=>session('username')
                
             ]);
             
            //  return $response->json();
            //  die();
             
             $responseData=$response->json();
              $statusCode=$responseData['statuscode'] ?? '';
             $status=$responseData['status']?? '';
             $rrn=$responseData['rrn']?? '';
             $amount=$responseData['amount']?? '';
             $message=$responseData['message']?? '';
             $latestId = DB::table('cgpayout')
             ->where('phone', session('mobile'))
             ->where('retailerId', session('username'))
             ->orderByDesc('id')
             ->value('id');
             
              if($statusCode=="TXN")
             {
                 $apiBalance = ApiHelper::decreaseBalance(env('Business_Email'), $realAmountTx, 'PAYOUT');
                if ($latestId) {
                    $ok=DB::table('cgpayout')
                        ->where('id', $latestId)
                        ->update([
                            'status' => $status,
                            'response' => $responseData,
                            'updated_at' => now(),
                        ]);
                }
                
             }
            else
            {
                if ($latestId) {
                    $ok=DB::table('cgpayout')
                        ->where('id', $latestId)
                        ->update([
                            'status' => 'Failled',
                            'response' => $responseData,
                            'updated_at' => now(),
                            'closingBal' => $openingBal,
                        ]);
                } 
                DB::table('customer')
                ->where('username', session('username'))
                ->increment('balance', $totalDeduct); // ✅ fixed typo from 'balanec' to 'balance'


            }
//  return $response;
//  die();
        //  if ($latestId) {
        //      $ok=DB::table('cgpayout')
        //          ->where('id', $latestId)
        //          ->update([
        //              'status' => $status,
        //              'response' => $responseData,
        //              'updated_at' => now(),
        //          ]);
        //  }
         
        $wBalance= DB::table('customer')->where('username', session('username'))->value('balance');
        session(['balance' => $wBalance]);
            // return $response->json();
            if($statusCode=="TXN")
            {
                
                return view('user.cgpayout.printPage',compact('responseData'));
           // return redirect()->route('payout.msg')->with('success', 'Payout Success! RRR No :'.$rrn);
            }
            else{
                  return redirect()->route('payout.msg')->with('error', 'Payout Failled.'.$message);
            }
 
        

    } catch (\Exception $e) {
           $wBalance= DB::table('customer')->where('username', session('username'))->value('balance');
        session(['balance' => $wBalance]);
        return redirect()->route('payout.msg')->with('error', 'Something went wrong.');
        // return response()->json([
        //     'status' => false,
        //     'message' => 'Payout API failed: ' . $e->getMessage()
        // ], 500);
    }


        


}
    public function verifyUser(Request $request)
    {

        $retailerPhone = $request->phone;
        $rtId=$request->username;
      
        // ✅ Check if phone exists in 'customer' table
        $isRetailerValid = DB::table('customer')->where('phone', $retailerPhone)->where('username',$rtId)->exists();
        // return $isRetailerValid;
        // die();
        if (!$isRetailerValid) {
            return response()->json([
                'status' => false,
                'message' => 'Retailer not found!'
            ], 404);
        }
    
        // ✅ Optional: Store additional data if needed
        $BusinessEmail = $request->Business_Email;
        $BusinessId = $request->Business_Id;
    
        // ✅ Prepare the API request using cURL
        $url = 'https://api.codegraphi.in/api/cg/token';
       // $url = 'http://127.0.0.1:8081/api/cg/token';
    
        $payload = [
            'username'     => $BusinessEmail,
            'password'     => $BusinessId,
        ];
    
        $curl = curl_init();
    
        curl_setopt_array($curl, [
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_HTTPHEADER     => ['Content-Type: application/json'],
            CURLOPT_POSTFIELDS     => json_encode($payload),
        ]);
    
        $response = curl_exec($curl);
        $error = curl_error($curl);
        curl_close($curl);
        $data = json_decode($response, true);
    // return $data;
    // die();
        
        // ✅ Handle cURL error
        if ($error) {
            return response()->json([
                'status' => false,
                'message' => 'API call failed',
                'error' => $error
            ], 500);
        }
    
        // ✅ Return API success response
        $data = json_decode($response, true);
        $token = $data['token'] ?? null;
        return view('user.cgpayout.payoutpage',compact('token','rtId'));
    }

    public function payout(Request $request)
    {

// return $request;
// die();
        $charges=0;
        $tds=0;
        $newAmount=0;
        $token=$request->token;
        $payamount=$request->amount;
        $realAmount=DB::table('customer')->where('username', session('username'))->value('balance');

        // return $request;
        // die();


        if (!$realAmount || $realAmount < $payamount) {
            return response()->json([
                'status' => false,
                'message' => 'Insufficient Wallet Balance Plese Connect Admin',
            ], 400);
        }

        $openingBal = $realAmount;
        $charges = 0;
        $tds = 0;

        // $verificationResponse = Http::timeout(60)->post('https://api.codegraphi.in/api/account-verification', [
        //     'ifsc'            => $request->ifsc,
        //     'accNo'           => $request->account_no,
        //     'benificiaryName' => $request->receiver_name,
        //     'address'         => 'New Delhi',
        // ]);
        // $verification = $verificationResponse->json();
        // return $verification;
        // die();
        // if (
        //     isset($verification['code']) && $verification['code'] == '200' &&
        //     isset($verification['model']['rrn']) && !empty($verification['model']['rrn']) &&
        //     isset($verification['model']['matchingScore']) && $verification['model']['matchingScore'] > 85
        // ) 
        // {
        //     // Step 3: Deduct Balance
        //     $deductResponse = Http::post('https://api.codegraphi.in/api/customer/decrease-balance', [
        //         'email'   => $request->Business_Email,
        //         'amount'  => 5,
        //         'service' => 'Account Verify',
        //     ]);
        // }
        // else
        // {
        //     return redirect()->route('payout.msg')->with('error', 'Pls Enter Currect Bank Details.');
        // } 

    
        // ✅ Fee calculation
        // if ($payamount >= 100 && $payamount < 1000) {
        //     $charges = 5;
        //     $tds = $charges * 0.02;
        // } elseif ($payamount >= 1000 && $payamount < 25000) {
        //     $charges = 10;
        //     $tds = $charges * 0.10;
        // }
        if ($payamount >= 100 && $payamount < 1000) {
            $charges = 3;
            $tds = $charges * 0.02;
        } elseif ($payamount >= 1000 && $payamount < 25000) {
            $charges = 5;
            $tds = $charges * 0.02;
        }
         elseif ($payamount >=25000 && $payamount < 100000) {
            $charges = 8;
            $tds = $charges * 0.02;
        }
         elseif ($payamount >=100000 && $payamount < 150000) {
            $charges = 12;
            $tds = $charges * 0.02;
        }
        elseif ($payamount >=150000) {
            $charges = 22;
            $tds = $charges * 0.02;
        }
        $deductAmount = $payamount; // Total requested amount
        $totalDeduct = $payamount + $charges + $tds;
        $closingBal = $realAmount - $totalDeduct;

        DB::table('customer')
        ->where('username', session('username'))
        ->decrement('balance', $totalDeduct); // ✅ fixed typo from 'balanec' to 'balance'

        DB::table('cgpayout')->insert([
            
            'retailerId' =>session('username'),
            'phone' =>session('mobile'),
            'amount' => $payamount,
            'charges' => $charges,
            'tds' => $tds,
            'commission'=>0,
            'status' => 'pending',
            'openingBal' => $openingBal,
            'closingBal' => $closingBal,
            'response'=>'',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        

        try{
            $response = Http::withHeaders([
                // 'bearerToken' => $token, // truncate in code, store securely in .env ideally
             ])->post('https://api.codegraphi.in/api/cg/initiate-payout', [
                
                 'amount'       => $request->amount,
                 'receiverName' => $request->receiver_name,
                 'paymentMode'  => $request->payment_mode,
              'ifsc' => strtoupper($request->ifsc),
                 'accountNo'    => $request->account_no,
                 'clientIP'     => $request->ip_address,
                 'Business_Email' =>$request->Business_Email,
                 'Business_Id' =>$request->Business_Id,
                 'token'=>$token,
                 'rtId'=>$request->rtId
                
             ]);
             
            //  return $response->json();
            //  die();
             
             $responseData=$response->json();
              $statusCode=$responseData['statuscode'] ?? '';
             $status=$responseData['status']?? '';
             $rrn=$responseData['rrn']?? '';
             $amount=$responseData['amount']?? '';
             $message=$responseData['message']?? '';
             $latestId = DB::table('cgpayout')
             ->where('phone', session('mobile'))
             ->where('retailerId', session('username'))
             ->orderByDesc('id')
             ->value('id');
             
              if($statusCode=="TXN")
             {
                if ($latestId) {
                    $ok=DB::table('cgpayout')
                        ->where('id', $latestId)
                        ->update([
                            'status' => $status,
                            'response' => $responseData,
                            'updated_at' => now(),
                        ]);
                }
                
             }
            else
            {
                if ($latestId) {
                    $ok=DB::table('cgpayout')
                        ->where('id', $latestId)
                        ->update([
                            'status' => 'Failled',
                            'response' => $responseData,
                            'updated_at' => now(),
                            'closingBal' => $openingBal,
                        ]);
                } 
                DB::table('customer')
                ->where('username', session('username'))
                ->increment('balance', $totalDeduct); // ✅ fixed typo from 'balanec' to 'balance'


            }
//  return $response;
//  die();
        //  if ($latestId) {
        //      $ok=DB::table('cgpayout')
        //          ->where('id', $latestId)
        //          ->update([
        //              'status' => $status,
        //              'response' => $responseData,
        //              'updated_at' => now(),
        //          ]);
        //  }
         
        $wBalance= DB::table('customer')->where('username', session('username'))->value('balance');
        session(['balance' => $wBalance]);
            // return $response->json();
            if($statusCode=="TXN")
            {
                return view('user.cgpayout.printPage',compact('responseData'));
           // return redirect()->route('payout.msg')->with('success', 'Payout Success! RRR No :'.$rrn);
            }
            else{
                  return redirect()->route('payout.msg')->with('error', 'Payout Failled.'.$message);
            }
 
        

    } catch (\Exception $e) {
           $wBalance= DB::table('customer')->where('username', session('username'))->value('balance');
        session(['balance' => $wBalance]);
        return redirect()->route('payout.msg')->with('error', 'Something went wrong.');
        // return response()->json([
        //     'status' => false,
        //     'message' => 'Payout API failed: ' . $e->getMessage()
        // ], 500);
    }

    
    }

    public function payoutMsg()
    {
        return view('user.cgpayout.payoutMsg');
    }
    public function payoutHistory()
    {
        $payOutHistory = DB::table('cgpayout')
        ->where('retailerId', session('username'))
        ->orderBy('id', 'desc') // Replace 'id' with the actual column you want to sort by
        ->get();
    
        return view('user.cgpayout.payoutHistory',compact('payOutHistory'));
    }
    
}
