<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use App\Helpers\ApiHelper;
use Illuminate\Support\Facades\Log;
class electricityBillController extends Controller
{
    public function index()
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
             "categoryKey" => "C04",
             "updatedAfterDate" => ""
         ]);
     
        
        // return $response->json();die();
       // die();
         if ($response->successful()) {
            $billers = collect($response['data']['records'])->map(function ($record) {
                return [
                    'billerId' => $record['billerId'],
                    'billerName' => $record['billerName'],
                ];
            });
            // Pass data to the viewwsw
           return view('user.electricityBill.index', compact('billers'));
         } else {
             // Return an error message if the API call fails
             return response()->json(['error' => 'Failed to retrieve bank data.'], 500);
         }
    
}

public function electricityBillFetch(Request $request){
   //return $request;die();
   //$ipAddress = $request->ip();  // Client's IP address
     $ipAddress="103.254.205.164";
//    $macAddress = exec('getmac');
//    $macAddress = strtok($macAddress, ' ');



$macAddress="00-15-5D-6D-D3-36";
   $consumerNumber=$request->input('consumerNumber');
   $mobile=$request->input('mobile');
   $billerId=$request->input('operator');
   $geoCode=$request->input('geoCode');
   $externalRef = 'TXN' . date('Y') . '' . round(microtime(true) * 1000);
    $customerOutletId = intval(session('outlet'));

    $paymentAmountExactnessData=Http::withHeaders([
        'Content-Type' => 'application/json',
    ])->post(env('liveUrl').'v1/bbps/getBillerDetails', [

        'outLet' =>$customerOutletId,
        "billerId"=> $billerId,
    ]);
   // return $paymentAmountExactness['data']['paymentAmountExactness'];die();
   $paymentAmountExactness=$paymentAmountExactnessData['data']['paymentAmountExactness'] ?? 0;
    $response = Http::withHeaders([
        'Content-Type' => 'application/json',
    ])->post(env('liveUrl').'v1/bbps/billEnquiry', [
    //
        'outLet' =>$customerOutletId,
        "billerId"=> $billerId,
        "initChannel" => "AGT",
        "externalRef" => $externalRef,
    
        'inputParameters' => [
            'param1' => $consumerNumber,
            'param2' => $mobile
        ],
        'deviceInfo' => [
            'mac' => $macAddress,
            'ip' => $ipAddress,
        ],
        'remarks' => [
            'param1' => $mobile
        ],
        'transactionAmount'=>"10"

    ]);
    $data = $response;
  
    Log::info('API Response Electricity Fetch:', ['response' => $data]);
//  $message=$data['message'];  return $message;
//     die();
    // return $data->json();
    // die();
    if ($data['statuscode'] === "TXN") {   
         session(['exID'=>$data['data']['enquiryReferenceId']]);
    $filteredData = [
        'geoCode' =>$geoCode,
        'mobile'=>$mobile,
        'billerId'=>$billerId,
        'enquiryReferenceId' => $data['data']['enquiryReferenceId'] ?? null,
        'customerName' => $data['data']['CustomerName'] ?? null,
        'billNumber' => $data['data']['BillNumber'] ?? null,
        'billPeriod' => $data['data']['BillPeriod'] ?? null,
        'billDate' => $data['data']['BillDate'] ?? null,
        'billDueDate' => $data['data']['BillDueDate'] ?? null,
        'billAmount' => $data['data']['BillAmount'] ?? null,
        'customerParamsDetails' => $data['data']['CustomerParamsDetails'][0]["Value"] ?? [],
        'billDetails' => $data['data']['BillDetails'] ?? [],
        'additionalDetails' => $data['data']['AdditionalDetails'] ?? [],
        'paymentAmountExactness'=>$paymentAmountExactness
    ];    
  //  return $filteredData;die();
        return back()->with('success', 'Bill Fetch Successfully.')->with('data', $filteredData);
    } else {
        $message=$data['message'];
             return back()->with('success', ''.$message);
    }

}

public function electricityBillPay(Request $request)
{
      Log::info('API Response Electricity Pay Request:', ['response' => $request]);

    // return $request;
    // die();
      $mpin=session('mpin');
    $mobile=session('mobile');
    // Get request inputs
    $getMpin = $request->input('mpin');
    $mobile1 = $request->input('mobile');
    $geoCode=$request->input('geoCode');
    $billerId = $request->input('billerId');
     $billerNo = $request->input('billNumber');
     $customerParamsDetails= $request->input('customerParamsDetails');
    $enquiryReferenceId = $request->input('enquiryReferenceId');
    $rechargeAmount = $request->input('billAmount');
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
            'billerId' => $billerId,
            'externalRef' => $externalRef,
            'enquiryReferenceId' => $enquiryReferenceId,
            'telecomCircle' => '',
            'inputParameters' => [
                'param1' => $customerParamsDetails
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
                'param1' => $mobile1
            ],
            'transactionAmount' => $rechargeAmount,
            'customerPan' => ''
        ]);

        $responseData = $response->json();
          Log::info('API Response Electricity Pay Respose:', ['response' => $responseData]);

        //return $responseData;die();
        DB::table('utility_payments')->insert([
            'mobile' => session('mobile'),
            'biller_id' => $billerId,
            'external_ref' => $externalRef,
            'telecom_circle' => $circle ?? '',
            'payment_mode' => "cash",
            'payment_remarks' => "C04",
            'transaction_amount' => $rechargeAmount,
            'response_body' => json_encode($responseData),
            'opening_balance' => $opBal,
            'closing_balance' => $opBal,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->updateCustomerBalance($mobile, $role, $externalRef);
        // return $response->json();
        // die();
        // Check API response
        $data = $response['response']['data'];

        $filteredData = [
            'externalRef' => $data['externalRef'] ?? null,
            'txnValue' => $data['txnValue'] ?? null,
            'billerDetails' => $data['billerDetails'] ?? []
        ];
        
        // if ($response['statuscode'] === "TXN" || $response['statuscode'] === "TUP") {
        //     return back()->with('success', 'Recharge Successfully.')->with('data', $filteredData);
        // } else {
        //     return back()->with('error', 'Failed Recharge.')->with('data', $filteredData);
        // }
          if ($response['statuscode'] === "TXN" || $response['statuscode'] === "TUP") {
            // return back()->with('success', 'Recharge Successfully.')->with('data', $filteredData);
            return view('user.electricity.payment_res', compact('responseData'));
        } else {
            return back()->with('error', 'Failed Recharge.');
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
        'service' => 'ElectricityBill',
        'sub_services' => 'ElectricityBill',
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
            'services' => 'ElectricityBill',
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
            'services' => 'ElectricityBill',
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

 $apiBalance = ApiHelper::decreaseBalance(env('Business_Email'), $realAmount, 'ElectricityBill');
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
        ->where('service', 'C04')
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
