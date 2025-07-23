<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use App\Helpers\ApiHelper;
class dthRechargeController extends Controller
{
    public function dthRecharge()
    {
           // Make the API call
           $customerOutletId = intval(session('outlet'));
           $response = Http::withHeaders([
               'Content-Type' => 'application/json',
           ])->post(env('liveUrl').'v1/bbps/getBillers', [
           //
               'outLet' =>$customerOutletId,
               "pageNumber"=> 1,
               "recordsPerPage" => 120,
               "categoryKey" => "C03",
               "updatedAfterDate" => ""
           ]);
       
          
         // die();
           if ($response->successful()) {
              $billers = collect($response['data']['records'])->map(function ($record) {
                  return [
                      'billerId' => $record['billerId'],
                      'billerName' => $record['billerName'],
                  ];
              });
              // Pass data to the viewwsw
             return view('user.dth.index', compact('billers'));
           } else {
               // Return an error message if the API call fails
               return response()->json(['error' => 'Failed to retrieve bank data.'], 500);
           }
        ;
    }
  

    public function dthRechargePay(Request $request)
{
    
    // return $request;
    // die();
    // Get request inputs
       $mpin=session('mpin');
    $getMpin = $request->input('mpin');
    $mobile = $request->input('mobile');
    $geoCode=$request->input('geoCode');
    $operator = $request->input('operator');
    $circle = $request->input('circle');
    $rechargeAmount = $request->input('rechargeAmount');
    $customerOutletId = session('outlet') ? intval(session('outlet')) : 0;
    $externalRef = 'TXN' . date('Y') . '' . round(microtime(true) * 1000);
    // API request
    $role = session('role');
    $amountTr = $rechargeAmount;
    $getAmount = session('balance');
    $opBal = $getAmount;
    $getAmount -= 50;

     if ($mpin != $getMpin)
     {
         return back()->with('error', 'Invalid MPin');
       
     } 
    if ($getAmount > $amountTr) {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post(env('liveUrl') . 'v1/bbps/paymentBiller', [
            'outlet' => $customerOutletId,
            'billerId' => $operator,
            'externalRef' => $externalRef,
            'enquiryReferenceId' => '',
            'telecomCircle' => $circle,
            'inputParameters' => [
                'param1' => $mobile
            ],
            'initChannel' => 'AGT',
            'deviceInfo' => [
                'terminalId' => '12813923',
                'mobile' => $mobile,
                'postalCode' => '110044',
                'geoCode' => $geoCode
            ],
            'paymentMode' => 'Cash',
            'paymentInfo' => [
                'Remarks' => 'CashPayment'
            ],
            'remarks' => [
                'param1' => $mobile
            ],
            'transactionAmount' => $rechargeAmount,
            'customerPan' => ''
        ]);

        $responseData = $response->json();
        DB::table('utility_payments')->insert([
            'mobile' => session('mobile'),
            'biller_id' => $operator,
            'external_ref' => $externalRef,
            'telecom_circle' => $circle ?? '',
            'payment_mode' => "cash",
            'payment_remarks' => "C03",
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
        $data = $response['respose']['data'];

        $filteredData = [
            'externalRef' => $data['externalRef'] ?? null,
            'txnValue' => $data['txnValue'] ?? null,
            'billerDetails' => $data['billerDetails'] ?? []
        ];
        
        if ($response['statuscode'] === "TXN" || $response['statuscode'] === "TUP") {
            return back()->with('success', 'Recharge Successfully.')->with('data', $filteredData);
        } else {
           $message=$data['message'];
             return back()->with('success', ''.$message);
        }
        
        
    }
    else
    {
        session()->flash('error', 'Your balance is not sufficient.');

        // Redirect back with the error message
        return redirect()->back();
    }
  
}

public function mobiletest()
    {
       
        $mobile = session('mobile');
        $role = session('role');
      
        // $externalRef = 'RPF-' . strtoupper(uniqid(date('YmdHis')));
        $externalRef = 'TXN' . date('Y') . '' . round(microtime(true) * 1000);
        // dd($externalRef);
        // dd($mobile,$role,$externalRef);
        // die();
      //  $this->updateCustomerBalance($mobile, $role, $externalRef);
        $this->updateCustomerBalance($mobile, $role, $externalRef);
    }


private function updateCustomerBalance($mobile,$role,$externalRef)
{
   

    $transaction = DB::table('utility_payments')
       ->where('mobile', $mobile)
                ->latest('created_at')
                ->first();

    if (!$transaction) return;

    $response_data = json_decode($transaction->response_body, true);
    if (!isset($response_data['respose']['data']['txnValue']) || !in_array($response_data['statuscode'], ['TXN', 'TUP'])) return;

    $txnAmount = $response_data['respose']['data']['txnValue'];
       $realAmount =$response_data['respose']['data']['txnValue'];
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

    // Distributor Commissions
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
        'service' => 'DTH Recharge',
        'sub_services' => 'DTH Recharge',
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
            'services' => 'DTH Recharge',
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
            'services' => 'DTH Recharge',
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

    $apiBalance = ApiHelper::decreaseBalance(env('Business_Email'), $realAmount, 'DTH Recharge');
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
        ->where('service', 'C03')
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


}
