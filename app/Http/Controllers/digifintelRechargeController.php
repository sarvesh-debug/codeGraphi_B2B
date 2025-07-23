<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use App\Helpers\ApiHelper;
class digifintelRechargeController extends Controller
{
    public function generateToken(){
        $response = Http::withHeaders([
        'Content-Type' => 'application/json',
    ])->post('https://admin.digifintel.com/api/login', [
    //
        "email" =>"amarjeet123123@gmail.com",
        "password" =>"Welcome@123"

    ]);

    return $response;

    }

    public function getMobileRechargeSubCategories($token){
        $response = Http::withHeaders([
        'Content-Type' => 'application/json',
       'Authorization' => 'Bearer ' . $token
    ])->post('https://admin.digifintel.com/api/recharge/get/sub-categories', [
    //
     "displayName" =>"recharge_PREPAID"

    ]);

    return $response;

    }

    public function mobileRecharge()
    {
        // $res = digifintelRechargeController::generateToken();
        // $token = $res['token'];
        // return $token;
        // die();
        $token = digifintelRechargeController::generateToken()['token'];
        $operators = digifintelRechargeController::getMobileRechargeSubCategories($token)['data'];
    

         return view('user.digifintelMobileRecharge.index', compact('operators'));
    
}
public function mobileRechargePay(Request $request)
{
    $mobile=session('mobile');
    // return $request;
    // die();
    // Get request inputs
    $mobile1 = $request->input('mobile');
    $geoCode=$request->input('geoCode');
    $operator = $request->input('operator');
    $circle = $request->input('circle');
    $rechargeAmount = $request->input('rechargeAmount');
    $customerOutletId = session('outlet') ? intval(session('outlet')) : 0;
    $externalRef = 'TXN' . date('Y') . '' . round(microtime(true) * 1000);
    // API request
    $role = session('role');
    $amountTr = $rechargeAmount;
    // $getAmount = session('balance');
    // $opBal = $getAmount;
    // $getAmount -= 50;


    $getAmount=DB::table('customer')
    ->where('username', session('username'))
    ->value('balance');
    $opBal = $getAmount;
    $getAmount-=50;
    
$balanceAd = ApiHelper::getBalance(env('Business_Email'));

$balance = $balanceAd['wallet'];
    if ($balance >= $getAmount && $getAmount > $amountTr) 
    //if ($getAmount > $amountTr) 
{
        $token = digifintelRechargeController::generateToken()['token'];
        
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token,
        ])->post('https://admin.digifintel.com/api/recharge/pay', [
            'productId'=>$operator,
            'referanceId' => $externalRef,
            'amount'=>$rechargeAmount,
            'paramValue' =>$mobile1,
            'geocode'=> $geoCode,
            'customer_number'=> $mobile, // walking customer number
            'pincode'=> '201301'
        ]);
        

        $responseData = $response->json();
        // return $responseData;
        // die();
        DB::table('utility_payments')->insert([
            'mobile' => session('mobile'),
            'biller_id' => $operator,
            'external_ref' => $externalRef,
            'telecom_circle' => $circle ?? '',
            'payment_mode' => "cash",
            'payment_remarks' => "CashPayment",
            'transaction_amount' => $rechargeAmount,
            'response_body' => json_encode($responseData),
            'opening_balance' => $opBal,
            'closing_balance' => $opBal,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->updateCustomerBalance($mobile, $role, $externalRef);
        // return $response;
        // die();
        // Check API response
        $data = $response['data'] ?? null;

        $filteredData = [
            'externalRef' => $data['txnId'] ?? null,
            'txnValue' => $rechargeAmount ?? null,
            'billerDetails' => $data['billerDetails'] ?? []
        ];
        
        if (isset($data['status']) && $response['data']['status'] === "SUCCESS") {
            return back()->with('success', 'Recharge Successfully.')->with('data', $filteredData);
        } else {
            return back()->with('error', 'Failed Recharge.')->with('data', $filteredData);
        }
        
        
    }
    else
    {
        session()->flash('error', 'Your balance is not sufficient.');

        // Redirect back with the error message
        return redirect()->back();
    }
  
}

private function updateCustomerBalance($mobile,$role,$externalRef)
{
   

    $transaction = DB::table('utility_payments')
       ->where('mobile', $mobile)
                ->latest('created_at')
                ->first();

    if (!$transaction) return;

    $response_data = json_decode($transaction->response_body, true);
    // if (!isset($response_data['respose']['data']['txnValue']) || !in_array($response_data['statuscode'], ['TXN', 'TUP'])) return;
    if (!isset($response_data['data']['status']) || $response_data['data']['status'] !== 'SUCCESS') {
    return;
}

    $transaction_amount = $transaction->transaction_amount ?? 0;

    $txnAmount = $transaction_amount;
    $realAmount =$transaction_amount;

    // Retailer info
    $retailer = DB::table(table: 'customer')->where('phone', $mobile)->first();
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
        $distributorData = $this->calculateCommission($txnAmount, 'distibuter',  $distributor->packageId);
        $distributorCommission = $distributorData['commission'];
    }

    // Super Distributor Commission
    $superCommission = 0;
    $superData = ['commission' => 0];
    if ($superDistributor) {
        $superData = $this->calculateCommission($txnAmount, 'sd',  $superDistributor->packageId);
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

    DB::table('utility_payments')->where('id', $transaction->id)->update([
        'opening_balance' => $retailerOpening,
        'closing_balance' => $retailerClosing,
        'commission' => $retailerCommission,
        'charges' => $charge,
        'tds' => $tds,
    ]);

    DB::table('getcommission')->insert([
        'retailermobile' => $mobile,
        'service' => 'Mobile_Recharge',
        'sub_services' => 'Mobile Recharge',
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
            'services' => 'MobileRecharge',
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
            'services' => 'MobileRecharge',
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

     $apiBalance = ApiHelper::decreaseBalance(env('Business_Email'), $realAmount, 'MobileRecharge');
//     dd([
//     'Retailer Commission' => $retailerCommission,
//     'Retailer TDS' => $tds,
//     'Retailer Charge' => $charge,
//     'Distributor Earning' => $distributorEarning,
//     'Super Distributor Earning' => $superEarning,
//     'Retailer Final Balance' => $retailerClosing + ($retailerCommission - $tds),
// ]);


}
private function calculateCommission($amount, $role, $packageId)
{
    $commissionRows = DB::table('commission_plan')
        ->where('packages', $role)
        ->where('service', 'C00')
        ->where('packegesId', $packageId)
        ->get();

    $charge = 0;
    $commission = 0;
    $tds = 0;

    foreach ($commissionRows as $row) {
        if ($amount >= $row->from_amount && $amount <= $row->to_amount) {
            $charge = $row->charge_in === 'Percentage' ? ($amount * $row->charge / 100) : $row->charge;
            $commission = $row->commission_in === 'Percentage' ? ($charge * $row->commission / 100) : $row->commission;
            $tds = $row->tds_in === 'Percentage' ? ($commission * $row->tds / 100) : $row->tds;
            break;
        }
    }

    return [
        'charge' => $charge,
        'commission' => $commission,
        'tds' => $tds,
    ];
}

}
