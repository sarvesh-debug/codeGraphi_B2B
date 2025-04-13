<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class cgPayoutController extends Controller
{
    public function verifyUserForm()
    {
        return view('user.cgpayout.tokenGen');
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
    
        // ✅ Fee calculation
        if ($payamount >= 100 && $payamount < 1000) {
            $charges = 5;
            $tds = $charges * 0.02;
        } elseif ($payamount >= 1000 && $payamount < 25000) {
            $charges = 10;
            $tds = $charges * 0.10;
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
                 'ifsc'         => $request->ifsc,
                 'accountNo'    => $request->account_no,
                 'clientIP'     => $request->ip_address,
                 'Business_Email' =>$request->Business_Email,
                 'Business_Id' =>$request->Business_Id,
                 'token'=>$token,
                 'rtId'=>$request->rtId
                
             ]);
             
             $responseData=$response->json();
             $status=$responseData['status'];
             $rrn=$responseData['rrn'];
             $amount=$responseData['amount'];
             $latestId = DB::table('cgpayout')
             ->where('phone', session('mobile'))
             ->where('retailerId', session('username'))
             ->orderByDesc('id')
             ->value('id');
 
         if ($latestId) {
             $ok=DB::table('cgpayout')
                 ->where('id', $latestId)
                 ->update([
                     'status' => $status,
                     'response' => $responseData,
                     'updated_at' => now(),
                 ]);
         }
         
        $wBalance= DB::table('customer')->where('username', session('username'))->value('balance');
        session(['balance' => $wBalance]);
            // return $response->json();
            return redirect()->route('payout.msg')->with('success', 'Payout Successful! RRR No :'.$rrn);
 
        

    } catch (\Exception $e) {
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
