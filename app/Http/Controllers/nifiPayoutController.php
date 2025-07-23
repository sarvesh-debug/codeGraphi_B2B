<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Helpers\AesEncryption;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
 use Carbon\Carbon;

class nifiPayoutController extends Controller
{

    public function index()
    {
        $getDetails=DB::table('customer')->where('username',session('username'))->first();
        //return $getDetails;die();
        return view('user.nifiPayout.index',compact('getDetails'));
    }

public function sendImpsPayout(Request $request)
{
    $packageId = session('packageId');
    $txnId = 'TXN' . now()->format('YmdHis');
    $txnAmount = $request->p4;

    // ✅ Max limit check
    if ($txnAmount > 49500) {
        return redirect()->back()->with('error', 'Maximum transfer limit is ₹49,500 per transaction.');
    }

    // ✅ Fetch balance
    $getAmount = DB::table('customer')->where('username', session('username'))->value('balance');
    $op = $getAmount;

    if ($getAmount < $txnAmount) {
        return redirect()->back()->with('error', 'Insufficient balance');
    }

    // ✅ Get commission & charges
    $commissionRows = DB::table('commission_plan')
        ->where('packages', 'Retailer')
        ->where('service', 'PAYOUT')
        ->where('packegesId', $packageId)
        ->get();

    $charge = 0;
    $commission = 0;
    $tds = 0;

    foreach ($commissionRows as $row) {
        if ($txnAmount >= $row->from_amount && $txnAmount <= $row->to_amount) {
            $charge = $row->charge_in === 'Percentage'
                ? ($txnAmount * $row->charge / 100)
                : $row->charge;

            $commission = $row->commission_in === 'Percentage'
                ? ($txnAmount * $row->commission / 100)
                : $row->commission;

            $tds = $row->tds_in === 'Percentage'
                ? ($charge * $row->tds / 100)
                : $row->tds;
            break;
        }
    }

    $totalDeduct = $txnAmount + $charge + $tds;

    // ✅ Prepare payload
    $payload = [
        "p1" => $request->p1,
        "p2" => $request->p2,
        "p3" => $txnId,
        "p4" => $txnAmount,
        "p5" => $request->p5,
        "p6" => $request->p6,
        "p7" => $request->p7,
        "p8" => "Paybrill",
        "p9" => $request->p9 ?? 'Payout',
        "p10" => $request->p10,
        "p11" => $request->p11,
    ];

    $encryptedPayload = AesEncryption::encrypt($payload);

    DB::beginTransaction();

    try {
        // ✅ Save in payouts table
        DB::table('nifi_payouts')->insert([
            'rtId' => session('username'),
            'mobile' => session('mobile'),
            'name' => session('user_name'),
            'charges' => $charge,
            'tds' => $tds,
            'commission' => 0,
            'amount' => $txnAmount,
            'status' => 'pending',
            'closingBal' => $op,
            'openingBal' => $op - $totalDeduct,
            'requestBody' => json_encode($payload),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // ✅ Save in wallet transfers
        DB::table('wallet_transfers')->insert([
            'sender_id' => 'Admin',
            'receiver_id' => session('username'),
            'amount' => $txnAmount,
            'opening_balance' => $op,
            'closing_balance' => $op - $totalDeduct,
            'charges' => $charge,
            'tds' => $tds,
            'remark' => "Payout Transfer",
            'transfer_id' => "",
            'type' => 'Debit',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // ✅ Call the API
        $response = Http::withHeaders([
            'x-client-id' => env('NIFI_CLIENT_ID'),
            'x-api-key' => env('NIFI_API_KEY'),
            'Content-Type' => 'application/json'
        ])->post(env('NIFI_PAYOUT_URL'), [
            'body' => $encryptedPayload
        ]);

        if ($response->successful() && isset($response['body'])) {
            $decryptedResponse = AesEncryption::decrypt($response['body']);

            // ✅ Log the response
            Log::channel('daily')->info('IMPS Payout Response:', [
                'txnId' => $txnId,
                'username' => session('username'),
                'decryptedResponse' => $decryptedResponse,
            ]);

            // ✅ Deduct balance
            DB::table('customer')->where('username', session('username'))->decrement('balance', $totalDeduct);

            // ✅ Update payout status
            DB::table('nifi_payouts')
                ->where('rtId', session('username'))
                ->where('amount', $txnAmount)
                ->latest('id')
                ->limit(1)
                ->update([
                    'status' => 'success',
                    'responseBody' => json_encode($decryptedResponse),
                    'updated_at' => now(),
                ]);

            // ✅ Update wallet transfer with txn ID
            DB::table('wallet_transfers')
                ->where('receiver_id', session('username'))
                ->where('amount', $txnAmount)
                ->where('type', 'Debit')
                ->latest('id')
                ->limit(1)
                ->update([
                    'transfer_id' => $decryptedResponse['data']['externalRef'] ?? null,
                    'updated_at' => now(),
                ]);

            DB::commit(); // ✅ Commit changes to DB

            // return response()->json([
            //     'status' => 'success',
            //     'decrypted' => $decryptedResponse,
            //     'op' =>$op,
            //     'cl'=>$op-$totalDeduct,
            //     'tds'=>$tds,
            //     'charges' =>$charge,
            //     'total' =>$totalDeduct
            // ]);
                        return view('user.nifiPayout.response', [
                'decrypted' => $decryptedResponse,
                'op' => $op,
                'cl' => $op - $totalDeduct,
                'tds' => $tds,
                'charges' => $charge,
                'total' => $totalDeduct
            ]);

        } else {
           // DB::rollBack(); // ❌ API failed – rollback
            Log::channel('daily')->error('IMPS API Failed', [
                'response' => $response->json()
            ]);

            return response()->json([
                'status' => 'error',
                'response' => $response->json()
            ], $response->status());
        }
    } catch (\Exception $e) {
       // DB::rollBack(); // ❌ Exception occurred – rollback
        Log::error('IMPS Payout Exception', ['message' => $e->getMessage()]);
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ]);
    }
}


   public function getWalletBalance()
{
    $response = Http::withHeaders([
        'accept' => 'application/json',
        'Content-Type' => 'application/json',
        'x-client-id' => env('NIFI_CLIENT_ID'),
        'x-api-key' => env('NIFI_API_KEY'),
    ])->get(env('NIFI_GET_WALLET_URL'));


   

     if ($response->successful() && isset($response['body'])) {
        // 5. Decrypt the response body
        $decryptedResponse = AesEncryption::decrypt($response['body']);

        return response()->json([
            'status' => 'success',
            'decrypted' => $decryptedResponse
        ]);
    } else {
        return response()->json([
            'status' => 'error',
            'response' => $response->json()
        ], $response->status());
    }
    // if ($response->successful()) {
    //     $data = $response->json();
    //     return view('user.nifiPayout.wallet', compact('data'));
    // } else {
    //     return back()->with('error', 'Failed to fetch wallet balance');
    // }
}


public function checkTxnStatus($txn_id)
{
    //return $txn_id;die();
    // Encrypt transaction ID
    $encryptedTxnId = AesEncryption::encrypt($txn_id);

    $url = env('NIFI_TXN_STATUS_URL') . '/' . $encryptedTxnId;

    $response = Http::withHeaders([
        'accept' => 'application/json',
        'Content-Type' => 'application/json',
        'x-client-id' => env('NIFI_CLIENT_ID'),
        'x-api-key' => env('NIFI_API_KEY'),
    ])->get($url);
 return $response;die();
    if ($response->successful()) {
        $data = $response->json();

        // If the response itself is encrypted, decrypt it
        if (isset($data['body'])) {
            $decrypted = AesEncryption::decrypt($data['body']);
            return response()->json(json_decode($decrypted, true));
        }

        return response()->json($data);
    }

    return response()->json(['error' => 'Failed to fetch status'], 500);
}


public function getReport()
{
    $rtid=session('username');
    $transactions=DB::table('nifi_payouts')->where('rtid',$rtid)->get();
   // return $transactions;
    return view('user.nifiPayout.report',compact('transactions'));
}

public function printReceipt($id)
{
    $transaction = DB::table('nifi_payouts')->where('id', $id)->first();
    
    if (!$transaction) {
        abort(404, 'Transaction not found');
    }

    $response = json_decode($transaction->responseBody, true);

    return view('user.nifiPayout.receipt', compact('transaction', 'response'));
}


public function handleCallback(Request $request)
    {
        // Log the payload for debugging
        Log::info('NIFI Payment Webhook Received:', $request->all());

        // Example: Extract important info
        $txnId = $request->input('txn_id');
        $status = $request->input('status'); // success, failed, pending
        $amount = $request->input('amount');
        $refId  = $request->input('ref_id');

        // Store or update in DB based on txn_id
        // You can update a record like:
        // Transaction::where('txn_id', $txnId)->update([...]);

        return response()->json(['message' => 'Callback received successfully.'], 200);
    }



    public function remProfile()
    {
        return view('user.nifiPayout.remitter.remitter');
    }
   public function remProfilePost(Request $request)
{
    $mobile = $request->mobileNumber;

    $user = DB::table('cg_dmt')->where('mobile', $mobile)->first();

    if ($user) {
        $responseData = $user;

        // Fetch beneficiaries related to this remitter
        $beneficiaries = DB::table('benelistcg')
            ->where('mobile', $mobile)
            ->get();
     

$summary = DB::table('nifi_payouts')
    ->where('remeMobile_no', $mobile)
    ->where('status', 'success')
    ->whereMonth('created_at', Carbon::now()->month)
    ->whereYear('created_at', Carbon::now()->year)
    ->selectRaw('COUNT(*) as txn_count, SUM(amount) as total_amount')
    ->first();


//return $summary;die();


        return view('user.nifiPayout.remitter.profile', compact('responseData', 'beneficiaries','summary'));
    } else {
        $msg = "Remitter Not Found. Please Register.";

        return view('user.nifiPayout.remitter.remitterOnboard', compact('mobile', 'msg'));
    }
}


 public function remitterRegistration(Request $request)
{
    // Validate required input
    $request->validate([
        'mobileNumber'    => 'required|digits:10',
        'panno'           => 'required|string|max:15',
     
    ]);


    $otp = rand(100000, 999999); // OTP generate

    // Store data in session
    session([
        'otp'       => $otp,
        'mobile'    => $request->mobileNumber,
        'name'      => $request->name,
        'adharno'   => $request->aadhaarNumber,
        'panno'     => $request->panno,
        'pincode'   => $request->pincode,
        'city'      => $request->city,
    ]);

    // Send OTP via SMS API
   $mobile =  $request->mobileNumber;  // Set mobile number
                        // Set OTP or message
                        $message="Dear customer {$otp} is your OTP please do not share with anyone Team Paybrill";

                $url = "http://136.243.135.116/http-tokenkeyapi.php?" . http_build_query([
                    'authentic-key' => '31355041594252494c4c3130301750752451',
                    'senderid'      => 'PYBRFT',
                    'route'         => '1',
                    'number'        => $mobile,
                    'message'       => $message,
                    'templateid'    => '1007440975322577025'
                ]);

                $response = file_get_contents($url);
    $status = "OTP sent to {$request->mobileNumber}";
    return view('user.nifiPayout.remitter.otpPage', compact('status'));
}

public function remitterRegistrationVerify(Request $request)
{
    $request->validate([
        'otp' => 'required|digits:6'
    ]);

    if ($request->otp != session('otp')) {
        return view('user.nifiPayout.remitter.errorPage', [
            'message' => 'Invalid OTP entered. Please try again.',
            'back' => true
        ]);
    }

    // Call PAN details API
    $pan = session('panno');
    $response = Http::post('https://auth.codegraphi.in/api/cg/pan-details', [
        'pan'      => $pan,
        'consent'  => 'Y',
        'api_key'  => 'CGi6kUpG1sHHAvL8NhbXkNV6sJkvhjAbe1',
    ]);

    $apiData = $response->json();
//return $apiData;die();
    // Extract data from API response
    $result = $apiData['data']['result'] ?? [];
    $message=$apiData['data']['error'] ??  "";
    if($apiData['statuscode']=='ERR')
    {
        return view('user.nifiPayout.remitter.errorPage', [
            'message' => 'Invalid PAN no.',
            'back' => true
        ]);  
    }

   if ($apiData['statuscode'] == 'TXN') {
    Http::post('https://api.codegraphi.in/api/customer/decrease-balance', [
        'email'   => env('Business_Email'),
        'amount'  => 3,
        'service' => 'PAN Verify'
    ]);
}

    $name = $result['fullname'] ?? session('name');
    $aadhaar = $result['aadhaar_number'] ?? session('adharno');
    $pincode = $result['address']['pincode'] ?? session('pincode');
    $city = $result['address']['city'] ?? session('city');

    $remId = 'CGA' . str_pad(mt_rand(0, 9999999), 7, '0', STR_PAD_LEFT);

    $data = [
        'mobile'         => session('mobile'),
        'remId'          => $remId,
        'name'           => $name,
        'adhar_no'       => $aadhaar,
        'panno'          => $pan,
        'monthly_limit'  => 500000,
        'perday_limit'   => 49500,
        'pincode'        => $pincode,
        'city'           => $city,
        'created_at'     => now(),
        'updated_at'     => now(),
    ];

    DB::table('cg_dmt')->insert($data);

    session()->forget(['otp']);

    return view('user.nifiPayout.remitter.success', ['data' => $data]);
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
public function beneficiryReg(Request $request)
{
    //return $mobile;
     $mobileNumber = $request->query('mobile');
        $responseData = $this->getBanksdmt(); // Use the correct function name here
        // return $responseData;
        // die();
        return view('user.nifiPayout.remitter.addBene', compact('mobileNumber', 'responseData'));
}


public function beneficiryStore(Request $request)
{
    $mobile = session('mobile');
    $realAmount = 3;
    $customerOutletId = intval(session('outlet'));

    // Validate input
    $request->validate([
        'mobile'     => 'required|numeric',
        'benename'   => 'required|string|max:255',
        'beneMobile' => 'required|numeric',
        'accno'      => 'required|numeric',
        'bank_name'     => 'required',
        'ifsc'       => 'required|string|max:20',
    ]);

    // Generate a unique beneId (Example format: BENE123456)
    $beneId = 'BENE' . mt_rand(100000, 999999);

    // Insert beneficiary into beneListCG
    DB::table('benelistcg')->insert([
        'beneId'     => $beneId,
        'mobile'     => $request->input('mobile'),
        'benename'   => $request->input('benename'),
        'beneMobile' => $request->input('beneMobile'),
        'accno'      => $request->input('accno'),
        'bank_name'     => $request->input('bank_name'),
        'ifsc'       => $request->input('ifsc'),
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    // Update balance logic
    $balance = DB::table('customer')->where('phone', $mobile)->value('balance');
    $retailerClosing = $balance;

    DB::table('getcommission')->insert([
        'retailermobile' => $mobile,
        'service'        => 'Account Verify',
        'sub_services'   => 'Account_Verify',
        'externalRef'    => 'TXN' . mt_rand(1000000000, 9999999999),
        'amount'         => $realAmount,
        'commission'     => 0,
        'tds'            => 0,
        'opening_bal'    => $retailerClosing,
        'closing_bal'    => $retailerClosing - $realAmount,
        'created_at'     => now(),
        'updated_at'     => now(),
    ]);

    DB::table('customer')->where('phone', $mobile)->decrement('balance', $realAmount);

    $newBalance = DB::table('customer')->where('phone', $mobile)->value('balance');
    session(['balance' => $newBalance]);

    // Redirect to success view
    return view('user.nifiPayout.remitter.beneficiaryRegistrationSuccess', [
        'beneId'   => $beneId,
        'status'   => 'Beneficiary registered successfully!',
        'mobile'   => $request->input('mobile'),
        'name'     => $request->input('benename'),
        'accno'    => $request->input('accno'),
        'ifsc'     => $request->input('ifsc'),
        'bankId'   => $request->input('bank_name'),
    ]);
}


public function beneDelete(Request $request)
{
    $request->validate([
        'beneficiaryId' => 'required|string',
        'remMobile'     => 'required|string',
    ]);

    $deleted = DB::table('benelistcg')
        ->where('beneId', $request->beneficiaryId)
        ->where('mobile', $request->remMobile)
        ->delete();

    if ($deleted) {
        return view('user.nifiPayout.remitter.deleteResult', [
            'status' => 'success',
            'message' => '✅ Beneficiary deleted successfully.',
            'mobile' => $request->remMobile
        ]);
    } else {
        return view('user.nifiPayout.remitter.deleteResult', [
            'status' => 'error',
            'message' => '❌ Beneficiary not found or already deleted.',
            'mobile' => $request->remMobile
        ]);
    }
}

 public function showSendMoneyForm(Request $request)
{
    //return $request;die();
     $mobile = $request->input('mobile');
    $account = $request->input('account');
    $ifsc = $request->input('ifsc');
    $beneName = $request->input('beneName');
    $email = $request->input('email');
    return view('user.nifiPayout.remitter.send-money-form', compact('mobile', 'account', 'ifsc', 'beneName','email'));
}

public function generateTransactionOtp(Request $request)
{
    //return $request;die();

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

     $otp = rand(100000, 999999); // OTP generate
  // Store data in session
    session([
        'otp'       => $otp,
        'mobile5'    => $request->mobile,
        'name5'      => $request->beneName,
        'account5'   => $request->account,
        'ifsc5'     => $request->ifsc,
        'email5'   => $request->email, 
        'amount5'      => $request->amount,
    ]);

    $mobile =  $request->mobile;  // Set mobile number
                        // Set OTP or message
                        $message="Dear customer {$otp} is your OTP please do not share with anyone Team Paybrill";

                $url = "http://136.243.135.116/http-tokenkeyapi.php?" . http_build_query([
                    'authentic-key' => '31355041594252494c4c3130301750752451',
                    'senderid'      => 'PYBRFT',
                    'route'         => '1',
                    'number'        => $mobile,
                    'message'       => $message,
                    'templateid'    => '1007440975322577025'
                ]);

                $response = file_get_contents($url);
    $status = "OTP sent to {$request->mobile}";
    return view('user.nifiPayout.remitter.transationDmt', compact('status'));


}


public function transaction(Request $request)
{
   //return $request;die();

    $p1=$request->account;
    $p2=$request->ifsc;
    $p4=$request->amount;
    $p5=$request->beneName;
    $p6=$request->mobileNumber;
    $p7=$request->email;
    $p11=$request->p11;
    $p8="PayBrill";
    $p9="Payout";
    $p10='1';
    $request->validate([
        'otp' => 'required|digits:6'
    ]);

    if ($request->otp != session('otp')) {
            return redirect()->back()->with('error','Invalid OTP entered. Please try again.' );

       
    }
  $packageId = session('packageId');
    $txnId = 'TXN' . now()->format('YmdHis');
    $txnAmount = $p4;

    // ✅ Max limit check
    if ($txnAmount > 49500) {
        return redirect()->back()->with('error', 'Maximum transfer limit is ₹49,500 per transaction.');
    }

    // ✅ Fetch balance
    $getAmount = DB::table('customer')->where('username', session('username'))->value('balance');
    $op = $getAmount;

    if ($getAmount < $txnAmount) {
        return redirect()->back()->with('error', 'Insufficient balance');
    }

    // ✅ Get commission & charges
    $commissionRows = DB::table('commission_plan')
        ->where('packages', 'Retailer')
        ->where('service', 'PAYOUT')
        ->where('packegesId', $packageId)
        ->get();
        
      if ($commissionRows->isEmpty()) {
    //return response()->json(['status' => false, 'message' => 'Charges not set'], 404);
    return redirect()->back()->with('error','CHARGES NOT SET' );
        }

    $charge = 0;
    $commission = 0;
    $tds = 0;

    foreach ($commissionRows as $row) {
        if ($txnAmount >= $row->from_amount && $txnAmount <= $row->to_amount) {
            $charge = $row->charge_in === 'Percentage'
                ? ($txnAmount * $row->charge / 100)
                : $row->charge;

            $commission = $row->commission_in === 'Percentage'
                ? ($txnAmount * $row->commission / 100)
                : $row->commission;

            $tds = $row->tds_in === 'Percentage'
                ? ($charge * $row->tds / 100)
                : $row->tds;
            break;
        }
         else
        {
            return redirect()->back()->with('error','CHARGES NOT SET' );

        }
    }



    $totalDeduct = $txnAmount + $charge + $tds;
//return $totalDeduct;die();
    // ✅ Prepare payload
    $payload = [
        "p1" => $p1,
        "p2" => $p2,
        "p3" => $txnId,
        "p4" => $txnAmount,
        "p5" => $p5,
        "p6" => $p6,
        "p7" => $p7,
        "p8" => "Paybrill",
        "p9" => $p9 ?? 'Payout',
        "p10" => $p10,
        "p11" => $p11,
    ];
//dd($op,$op-$totalDeduct);die();
    $encryptedPayload = AesEncryption::encrypt($payload);

    DB::beginTransaction();

    try {
        // ✅ Save in payouts table
        DB::table('nifi_payouts')->insert([
            'rtId' => session('username'),
            'mobile' => session('mobile'),
             'remeMobile_no'=>$p6,
            'name' => session('user_name'),
            'charges' => $charge,
            'tds' => $tds,
            'commission' => 0,
            'amount' => $txnAmount,
            'status' => 'pending',
            'closingBal' => $op-$totalDeduct,
            'openingBal' =>$op,
            'requestBody' => json_encode($payload),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // ✅ Save in wallet transfers
        // DB::table('wallet_transfers')->insert([
        //     'sender_id' => 'Admin',
        //     'receiver_id' => session('username'),
        //     'amount' => $txnAmount,
        //     'opening_balance' => $op,
        //     'closing_balance' => $op - $totalDeduct,
        //     'charges' => $charge,
        //     'tds' => $tds,
        //     'remark' => "Payout Transfer",
        //     'transfer_id' => "",
        //     'type' => 'Debit',
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);

        // ✅ Call the API
        $response = Http::withHeaders([
            'x-client-id' => env('NIFI_CLIENT_ID'),
            'x-api-key' => env('NIFI_API_KEY'),
            'Content-Type' => 'application/json'
        ])->post(env('NIFI_PAYOUT_URL'), [
            'body' => $encryptedPayload
        ]);


       if ($response->successful() && isset($response['body'])) {
            $decryptedResponse = AesEncryption::decrypt($response['body']);


            // ✅ Log the response
            Log::channel('daily')->info('IMPS Payout Response:', [
                'txnId' => $txnId,
                'username' => session('username'),
                'decryptedResponse' => $decryptedResponse,
            ]);

            // ✅ Deduct balance
            DB::table('customer')->where('username', session('username'))->decrement('balance', $totalDeduct);
                  $balance = DB::table('customer')
                 ->where('username', session('username'))
                 ->value('balance');
                 // Store the retrieved balance in the session
                 session(['balance'=> $balance]);
            // ✅ Update payout status
            DB::table('nifi_payouts')
                ->where('rtId', session('username'))
                ->where('amount', $txnAmount)
                ->latest('id')
                ->limit(1)
                ->update([
                    'status' => 'success',
                    'responseBody' => json_encode($decryptedResponse),
                    'updated_at' => now(),
                ]);

            // ✅ Update wallet transfer with txn ID
            // DB::table('wallet_transfers')
            //     ->where('receiver_id', session('username'))
            //     ->where('amount', $txnAmount)
            //     ->where('type', 'Debit')
            //     ->latest('id')
            //     ->limit(1)
            //     ->update([
            //         'transfer_id' => $decryptedResponse['data']['externalRef'] ?? null,
            //         'updated_at' => now(),
            //     ]);

            DB::commit(); // ✅ Commit changes to DB

            // return response()->json([
            //     'status' => 'success',
            //     'decrypted' => $decryptedResponse,
            //     'op' =>$op,
            //     'cl'=>$op-$totalDeduct,
            //     'tds'=>$tds,
            //     'charges' =>$charge,
            //     'total' =>$totalDeduct
            // ]);
                        return view('user.nifiPayout.response', [
                'decryptedResponse' => $decryptedResponse,
                'op' => $op,
                'cl' => $op - $totalDeduct,
                'tds' => $tds,
                'msg' => "successful",
                'charges' => $charge,
                'total' => $totalDeduct
            ]);

        } else {
           // DB::rollBack(); // ❌ API failed – rollback
            Log::channel('daily')->error('IMPS API Failed', [
                'payload' => $payload,
                'response' => $response->json()
            ]);

            return view('user.nifiPayout.response', [
                'decryptedResponse' => '',
                'op' => '',
                'cl' => '',
                'tds' => '',
                'charges' => '',
                'msg' => $response['message'],
                'total' => ''
            ]);
            // return response()->json([
            //     'status' => 'error',
            //     'msg' =>$response['message'],
            //     'response' => $response->json()
            // ], $response->status());

            
        }
    } catch (\Exception $e) {
       // DB::rollBack(); // ❌ Exception occurred – rollback
        Log::error('IMPS Payout Exception', ['message' => $e->getMessage()]);
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ]);
    }

}
}
