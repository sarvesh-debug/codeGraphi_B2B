<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use App\Helpers\ApiHelper;
class digifintelController extends Controller
{

    public function generateToken(){
        $response = Http::withHeaders([
        'Content-Type' => 'application/json',
    ])->post(env('OFFLINE_SERVICES_URL') . '/login', [
    //
        "email" =>env('OFFLINE_SERVICES_EMAIL'),
        "password" =>env('OFFLINE_SERVICES_PASSWORD')

    ]);

    //return $response;
     if (!$response->successful()) {
        return redirect('customer/digifintel/dashboard')->with('error', 'Service not available')->send();
        exit;
    }

    return $response;

    }


    public function getSubCategories($token, $value){
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
       'Authorization' => 'Bearer ' . $token
    ])->post(env('OFFLINE_SERVICES_URL') . '/bbps/get/sub-categories', [
    //
     "displayName" =>$value

    ]);

    return $response;
}

 public function getParams($token, $productId){
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
       'Authorization' => 'Bearer ' . $token
    ])->post(env('OFFLINE_SERVICES_URL') . '/bbps/fetch/parameters', [
    //
     "productId"=> $productId

    ]);

    return $response;
}

 public function getBill($token, $productId, $paramInfo){
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
       'Authorization' => 'Bearer ' . $token
    ])->post(env('OFFLINE_SERVICES_URL') . '/bbps/fetch-bill', [
    //
     "productId"=> $productId,
     "mode"=>'offline',
     "paramInfo"=>$paramInfo,

    ]);

    return $response;
}

public function digifintelbillPay(Request $request){
    // return $request;
     //return session()->all();
    // die();

    $mobile = session('mobile');
    $role = session('role');
    $amountTr = $request->billAmount;
    $getAmount = session('balance');
    $opBal = $getAmount;
    $getAmount -= 50;
    $externalRef = 'RPR' . date('Y') . '' . round(microtime(true) * 1000);

    // $getAmount > $amountTr
    if ($getAmount > $amountTr) {

        $token = digifintelController::generateToken()['token'];

        $payload = [
    "productId" => session('digifintelProductId'),
    "mode" => 'offline',
    "billAmount" => $request->billAmount,
    "latitude" => session('data')['latitude'],
    "longitude" => session('data')['longitude'],
    "paramInfo" => session('data')['digifintelParamInfo'],
];

if (!empty(session('data')['enquiryReferenceId'])) {
    $payload['txnid'] = session('data')['enquiryReferenceId'];
}

if (!empty(session('data')['billFetch'])) {
    $payload['billFetch'] = session('data')['billFetch'];
}

    $response = Http::withHeaders([
            'Content-Type' => 'application/json',
       'Authorization' => 'Bearer ' . $token
    ])->post(env('OFFLINE_SERVICES_URL') . '/bbps/pay-bill', $payload);

    // return $response;

    

    $responseData = $response->json();

    $responseData = $response->json();
        DB::table('utility_payments')->insert([
            'mobile' => session('mobile'),
            'biller_id' => session('data')['billerId'],
            'external_ref' => $externalRef,
            'telecom_circle' => $circle ?? '',
            'payment_mode' => "cash",
            'payment_remarks' => "BBPS Bill Payment",
            'transaction_amount' => $request->billAmount,
            'response_body' => json_encode($responseData),
            'opening_balance' => $opBal,
            'closing_balance' => $opBal,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->updateCustomerBalance($mobile, $role, $externalRef, $request->billAmount, $request->billerId);



    session()->forget('data');
    if ($response['status'] === true) {
        if($response['response_code'] === 1){
            return redirect()->route('customer/digifintel/dashboard')->with('success', 'Transaction successful!');

        } else if($response['response_code'] === 2) {
            return redirect()->route('customer/digifintel/dashboard')->with('success', 'Transaction pending');

        } else{
            return redirect()->route('customer/digifintel/dashboard')->with('error', 'Transaction Failed and amount reversed');

        }
        } else {
            return redirect()->route('customer/digifintel/dashboard')->with('error', 'Failed Recharge.');
            //return back()->with('error', 'Failed Recharge.')->with('data', $filteredData);
        }

    }
    else{
        
        session()->forget('data');
        // Redirect back with the error message
        return redirect()->route('customer/digifintel/dashboard')->with('error', 'Insufficient Balance.');
    }


    

}


private function updateCustomerBalance($mobile,$role,$externalRef, $amount, $billerId)
{
   

    $transaction = DB::table('utility_payments')
       ->where('mobile', $mobile)
                ->latest('created_at')
                ->first();

    if (!$transaction) return;

    $response_data = json_decode($transaction->response_body, true);
    if (
    $response_data['status'] === false || 
    ($response_data['status'] === true && $response_data['response_code'] === 2)
) return;

    $txnAmount = $amount;
  $realAmount =$amount;
    // Retailer info
    $retailer = DB::table('customer')->where('phone', $mobile)->first();
    if (!$retailer) return;

    // Distributor & Super Distributor info
    $distributor = DB::table('customer')->where('phone', $retailer->dis_phone)->first();
    $superDistributor = $distributor ? DB::table('customer')->where('phone', $distributor->dis_phone)->first() : null;

    // Retailer Commission
    $retailerData = $this->calculateCommission($txnAmount, 'retailer', $retailer->packageId, $billerId);
    $retailerCommission = $retailerData['commission'];
    $charge = $retailerData['charge'];
    $tds = $retailerData['tds'];

    // Distributor Commission
    $distributorCommission = 0;
    $distributorData = ['commission' => 0];
    if ($distributor) {
        $distributorData = $this->calculateCommission($txnAmount, 'distibuter',  $distributor->packageId, $billerId);
        $distributorCommission = $distributorData['commission'];
    }

    // Super Distributor Commission
    $superCommission = 0;
    $superData = ['commission' => 0];
    if ($superDistributor) {
        $superData = $this->calculateCommission($txnAmount, 'sd',  $superDistributor->packageId, $billerId);
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
        'service' => 'OfflineBillService',
        'sub_services' => 'OfflineBillService',
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
            'services' => 'OfflineBillService',
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
            'services' => 'OfflineBillService',
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

 $apiBalance = ApiHelper::decreaseBalance(env('Business_Email'), $realAmount, 'OfflineBillService');
//     dd([
//     'Retailer Commission' => $retailerCommission,
//     'Retailer TDS' => $tds,
//     'Retailer Charge' => $charge,
//     'Distributor Earning' => $distributorEarning,
//     'Super Distributor Earning' => $superEarning,
//     'Retailer Final Balance' => $retailerClosing + ($retailerCommission - $tds),
// ]);


}

private function calculateCommission($amount, $role, $packageId, $serviceCode)
{
    $commissionRows = DB::table('commission_plan')
        ->where('packages', $role)
        ->where('service', $serviceCode)
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



    public function index() {
        return view('user.digifintelhome-page');
    }

    public function electricityBill() {

        $token = digifintelController::generateToken()['token'];

        $response = digifintelController::getSubCategories($token, "Electricity");

        // return $response;
        // die();
        $responseData = $response->json();

        // return $responseData;
        // die();

        if ($response->successful()) {
        $operators = $responseData['data'];
        return view('user.digifintelElectricityRecharge.index', compact('operators'));
           } else {
               // Return an error message if the API call fails
               return response()->json(['error' => 'Failed to retrieve bank data.'], 500);
           }

    }

     public function electricityBillFetchParams(Request $request) {

        // return $request;
        // die();
         

        $token = digifintelController::generateToken()['token'];
        $res = digifintelController::getParams($token, $request->operator);

        session([
        'digifintelProductId' => $request->operator,
    ]);
        //$res = digifintelController::getParams($token, 429);

        $response = $res->json();

       
        if ($res->successful()) {
            return view('user.digifintelElectricityRecharge.fetchParams', compact('response'));
        } else {
               // Return an error message if the API call fails
               return response()->json(['error' => 'Failed to retrieve bank data.'], 500);
           }

    }


    public function electricityBillFetch(Request $request) {
        // return $request;
        // die();

        $inputs = $request->except(['_token']);

        $paramInfo = [];

        foreach ($inputs as $key => $value) {
            $paramInfo[] = [
                'paramName' => $key,
                'value' => $value
            ];
        }



        if ($request->FetchPay == 0) {
        $billData = [
        // 'customerName' => $res['data']['name'],
        //'billNumber' => '123456',
        //'billDate' => '2025-05-30',
        // 'billDueDate' => $res['data']['duedate'],
        'billAmount' => $request->rechargeAmount,
        // 'enquiryReferenceId' => $res['data']['txnid'],
        'billerId' => 'C04',
        'mobile' => session('mobile'),
        'geoCode' => $request->geocode,
        'latitude' => $request->latitude,
        'longitude' => $request->longitude,
        'geoCode' => $request->geoCode,
        // 'billFetch' => $res['data']['bill_fetch'],
        'digifintelParamInfo' => $paramInfo
    ];

        session(['data' => $billData]);

        $data = [
            [
                'billerId' => 'C04',
                'billAmount' => $request->rechargeAmount
            ]
        ];

        $this->digifintelbillPay(response()->json($data));



        } 
        
        
        else {

             // return $paramInfo;
        // die();

        $token = digifintelController::generateToken()['token'];
        $res = digifintelController::getBill($token, session('digifintelProductId'), $paramInfo);

        // return $res;
        // die();

        if ($res->successful()) {
        $billData = [
        'customerName' => $res['data']['name'],
        //'billNumber' => '123456',
        //'billDate' => '2025-05-30',
        'billDueDate' => $res['data']['duedate'],
        'billAmount' => $res['data']['amount'],
        'enquiryReferenceId' => $res['data']['txnid'],
        'billerId' => 'C04',
        'mobile' => session('mobile'),
        'geoCode' => $request->geocode,
        'latitude' => $request->latitude,
        'longitude' => $request->longitude,
        'geoCode' => $request->geoCode,
        'billFetch' => $res['data']['bill_fetch'],
        'digifintelParamInfo' => $paramInfo
    ];

    // // Store in session
    // session(['data' => $billData]);

    // $token = digifintelController::generateToken()['token'];
        $res1 = digifintelController::getParams($token, session('digifintelProductId'));

        //$res = digifintelController::getParams($token, 429);

        $response = $res1->json();

       
           if ($res1->successful() && $res->successful()) {
            // Store in session
             session(['data' => $billData]);
             return view('user.digifintelElectricityRecharge.fetchParams', compact('response'));
           } 
           else {
               // Return an error message if the API call fails
               return response()->json(['error' => 'Failed to retrieve bank data.'], 500);
           }
    }

        }


       
}


    

public function insuranceBill() {

        $token = digifintelController::generateToken()['token'];

        $response = digifintelController::getSubCategories($token, "Insurance");

        // return $response;
        // die();
        $responseData = $response->json();

        // return $responseData;
        // die();

        if ($response->successful()) {
        $operators = $responseData['data'];
        return view('user.digifintelInsuranceRecharge.index', compact('operators'));
           } else {
               // Return an error message if the API call fails
               return response()->json(['error' => 'Failed to retrieve bank data.'], 500);
           }

    }

    public function insuranceBillFetchParams(Request $request) {

        // return $request;
        // die();
         

        $token = digifintelController::generateToken()['token'];
        $res = digifintelController::getParams($token, $request->operator);

        session([
        'digifintelProductId' => $request->operator,
    ]);
        //$res = digifintelController::getParams($token, 429);

        $response = $res->json();

       
        if ($res->successful()) {
            return view('user.digifintelInsuranceRecharge.fetchParams', compact('response'));
        } else {
               // Return an error message if the API call fails
               return response()->json(['error' => 'Failed to retrieve bank data.'], 500);
           }

    }

    public function insuranceBillFetch(Request $request) {
        // return $request;
        // die();

        $inputs = $request->except(['_token']);

        $paramInfo = [];

        foreach ($inputs as $key => $value) {
            $paramInfo[] = [
                'paramName' => $key,
                'value' => $value
            ];
        }



        if ($request->FetchPay == 0) {
        $billData = [
        // 'customerName' => $res['data']['name'],
        //'billNumber' => '123456',
        //'billDate' => '2025-05-30',
        // 'billDueDate' => $res['data']['duedate'],
        'billAmount' => $request->rechargeAmount,
        // 'enquiryReferenceId' => $res['data']['txnid'],
        'billerId' => 'C11',
        'mobile' => session('mobile'),
        'geoCode' => $request->geocode,
        'latitude' => $request->latitude,
        'longitude' => $request->longitude,
        'geoCode' => $request->geoCode,
        // 'billFetch' => $res['data']['bill_fetch'],
        'digifintelParamInfo' => $paramInfo
    ];

        session(['data' => $billData]);

        $data = [
            [
                'billerId' => 'C11',
                'billAmount' => $request->rechargeAmount
            ]
        ];

        $this->digifintelbillPay(response()->json($data));

        } 
        else {

             // return $paramInfo;
        // die();

        $token = digifintelController::generateToken()['token'];
        $res = digifintelController::getBill($token, session('digifintelProductId'), $paramInfo);

        // return $res;
        // die();

        if ($res->successful()) {
        $billData = [
        'customerName' => $res['data']['name'],
        //'billNumber' => '123456',
        //'billDate' => '2025-05-30',
        'billDueDate' => $res['data']['duedate'],
        'billAmount' => $res['data']['amount'],
        'enquiryReferenceId' => $res['data']['txnid'],
        'billerId' => 'C11',
        'mobile' => session('mobile'),
        'geoCode' => $request->geocode,
        'latitude' => $request->latitude,
        'longitude' => $request->longitude,
        'geoCode' => $request->geoCode,
        'billFetch' => $res['data']['bill_fetch'],
        'digifintelParamInfo' => $paramInfo
    ];

    // // Store in session
    // session(['data' => $billData]);

    // $token = digifintelController::generateToken()['token'];
        $res1 = digifintelController::getParams($token, session('digifintelProductId'));

        //$res = digifintelController::getParams($token, 429);

        $response = $res1->json();

       
           if ($res1->successful() && $res->successful()) {
            // Store in session
             session(['data' => $billData]);
             return view('user.digifintelInsuranceRecharge.fetchParams', compact('response'));
           } 
           else {
               // Return an error message if the API call fails
               return response()->json(['error' => 'Failed to retrieve bank data.'], 500);
           }
    }

        }


       
}


public function emiBill() {

        $token = digifintelController::generateToken()['token'];

        $response = digifintelController::getSubCategories($token, "EMI");

        // return $response;
        // die();
        $responseData = $response->json();

        // return $responseData;
        // die();

        if ($response->successful()) {
        $operators = $responseData['data'];
        return view('user.digifintelEmiRecharge.index', compact('operators'));
           } else {
               // Return an error message if the API call fails
               return response()->json(['error' => 'Failed to retrieve bank data.'], 500);
           }

    }

    public function emiBillFetchParams(Request $request) {

        // return $request;
        // die();
         

        $token = digifintelController::generateToken()['token'];
        $res = digifintelController::getParams($token, $request->operator);

        session([
        'digifintelProductId' => $request->operator,
    ]);
        //$res = digifintelController::getParams($token, 429);

        $response = $res->json();

       
        if ($res->successful()) {
            return view('user.digifintelEmiRecharge.fetchParams', compact('response'));
        } else {
               // Return an error message if the API call fails
               return response()->json(['error' => 'Failed to retrieve bank data.'], 500);
           }

    }

    public function emiBillFetch(Request $request) {
        // return $request;
        // die();

        $inputs = $request->except(['_token']);

        $paramInfo = [];

        foreach ($inputs as $key => $value) {
            $paramInfo[] = [
                'paramName' => $key,
                'value' => $value
            ];
        }



        if ($request->FetchPay == 0) {
        $billData = [
        // 'customerName' => $res['data']['name'],
        //'billNumber' => '123456',
        //'billDate' => '2025-05-30',
        // 'billDueDate' => $res['data']['duedate'],
        'billAmount' => $request->rechargeAmount,
        // 'enquiryReferenceId' => $res['data']['txnid'],
        'billerId' => 'C13',
        'mobile' => session('mobile'),
        'geoCode' => $request->geocode,
        'latitude' => $request->latitude,
        'longitude' => $request->longitude,
        'geoCode' => $request->geoCode,
        // 'billFetch' => $res['data']['bill_fetch'],
        'digifintelParamInfo' => $paramInfo
    ];

        session(['data' => $billData]);

        $data = [
            [
                'billerId' => 'C13',
                'billAmount' => $request->rechargeAmount
            ]
        ];

        $this->digifintelbillPay(response()->json($data));

        } 
        else {

             // return $paramInfo;
        // die();

        $token = digifintelController::generateToken()['token'];
        $res = digifintelController::getBill($token, session('digifintelProductId'), $paramInfo);

        // return $res;
        // die();

        if ($res->successful()) {
        $billData = [
        'customerName' => $res['data']['name'],
        //'billNumber' => '123456',
        //'billDate' => '2025-05-30',
        'billDueDate' => $res['data']['duedate'],
        'billAmount' => $res['data']['amount'],
        'enquiryReferenceId' => $res['data']['txnid'],
        'billerId' => 'C13',
        'mobile' => session('mobile'),
        'geoCode' => $request->geocode,
        'latitude' => $request->latitude,
        'longitude' => $request->longitude,
        'geoCode' => $request->geoCode,
        'billFetch' => $res['data']['bill_fetch'],
        'digifintelParamInfo' => $paramInfo
    ];

    // // Store in session
    // session(['data' => $billData]);

    // $token = digifintelController::generateToken()['token'];
        $res1 = digifintelController::getParams($token, session('digifintelProductId'));

        //$res = digifintelController::getParams($token, 429);

        $response = $res1->json();

       
           if ($res1->successful() && $res->successful()) {
            // Store in session
             session(['data' => $billData]);
             return view('user.digifintelEmiRecharge.fetchParams', compact('response'));
           } 
           else {
               // Return an error message if the API call fails
               return response()->json(['error' => 'Failed to retrieve bank data.'], 500);
           }
    }

        }


       
}

public function gasBill() {

        $token = digifintelController::generateToken()['token'];

        $response = digifintelController::getSubCategories($token, "Gas");

        // return $response;
        // die();
        $responseData = $response->json();

        // return $responseData;
        // die();

        if ($response->successful()) {
        $operators = $responseData['data'];
        return view('user.digifintelGasRecharge.index', compact('operators'));
           } else {
               // Return an error message if the API call fails
               return response()->json(['error' => 'Failed to retrieve bank data.'], 500);
           }

    }

    public function gasBillFetchParams(Request $request) {

        // return $request;
        // die();
         

        $token = digifintelController::generateToken()['token'];
        $res = digifintelController::getParams($token, $request->operator);

        session([
        'digifintelProductId' => $request->operator,
    ]);
        //$res = digifintelController::getParams($token, 429);

        $response = $res->json();

       
        if ($res->successful()) {
            return view('user.digifintelGasRecharge.fetchParams', compact('response'));
        } else {
               // Return an error message if the API call fails
               return response()->json(['error' => 'Failed to retrieve bank data.'], 500);
           }

    }

    public function gasBillFetch(Request $request) {
        // return $request;
        // die();

        $inputs = $request->except(['_token']);

        $paramInfo = [];

        foreach ($inputs as $key => $value) {
            $paramInfo[] = [
                'paramName' => $key,
                'value' => $value
            ];
        }



        if ($request->FetchPay == 0) {
        $billData = [
        // 'customerName' => $res['data']['name'],
        //'billNumber' => '123456',
        //'billDate' => '2025-05-30',
        // 'billDueDate' => $res['data']['duedate'],
        'billAmount' => $request->rechargeAmount,
        // 'enquiryReferenceId' => $res['data']['txnid'],
        'billerId' => 'C07',
        'mobile' => session('mobile'),
        'geoCode' => $request->geocode,
        'latitude' => $request->latitude,
        'longitude' => $request->longitude,
        'geoCode' => $request->geoCode,
        // 'billFetch' => $res['data']['bill_fetch'],
        'digifintelParamInfo' => $paramInfo
    ];

        session(['data' => $billData]);

        $data = [
            [
                'billerId' => 'C07',
                'billAmount' => $request->rechargeAmount
            ]
        ];

        $this->digifintelbillPay(response()->json($data));

        } 
        else {

             // return $paramInfo;
        // die();

        $token = digifintelController::generateToken()['token'];
        $res = digifintelController::getBill($token, session('digifintelProductId'), $paramInfo);

        // return $res;
        // die();

        if ($res->successful()) {
        $billData = [
        'customerName' => $res['data']['name'],
        //'billNumber' => '123456',
        //'billDate' => '2025-05-30',
        'billDueDate' => $res['data']['duedate'],
        'billAmount' => $res['data']['amount'],
        'enquiryReferenceId' => $res['data']['txnid'],
        'billerId' => 'C07',
        'mobile' => session('mobile'),
        'geoCode' => $request->geocode,
        'latitude' => $request->latitude,
        'longitude' => $request->longitude,
        'geoCode' => $request->geoCode,
        'billFetch' => $res['data']['bill_fetch'],
        'digifintelParamInfo' => $paramInfo
    ];

    // // Store in session
    // session(['data' => $billData]);

    // $token = digifintelController::generateToken()['token'];
        $res1 = digifintelController::getParams($token, session('digifintelProductId'));

        //$res = digifintelController::getParams($token, 429);

        $response = $res1->json();

       
           if ($res1->successful() && $res->successful()) {
            // Store in session
             session(['data' => $billData]);
             return view('user.digifintelGasRecharge.fetchParams', compact('response'));
           } 
           else {
               // Return an error message if the API call fails
               return response()->json(['error' => 'Failed to retrieve bank data.'], 500);
           }
    }

        }


       
}


public function lpgBill() {

        $token = digifintelController::generateToken()['token'];

        $response = digifintelController::getSubCategories($token, "LPG");

        // return $response;
        // die();
        $responseData = $response->json();

        // return $responseData;
        // die();

        if ($response->successful()) {
        $operators = $responseData['data'];
        return view('user.digifintelLpgRecharge.index', compact('operators'));
           } else {
               // Return an error message if the API call fails
               return response()->json(['error' => 'Failed to retrieve bank data.'], 500);
           }

    }

    public function lpgBillFetchParams(Request $request) {

        // return $request;
        // die();
         

        $token = digifintelController::generateToken()['token'];
        $res = digifintelController::getParams($token, $request->operator);

        session([
        'digifintelProductId' => $request->operator,
    ]);
        //$res = digifintelController::getParams($token, 429);

        $response = $res->json();

       
        if ($res->successful()) {
            return view('user.digifintelLpgRecharge.fetchParams', compact('response'));
        } else {
               // Return an error message if the API call fails
               return response()->json(['error' => 'Failed to retrieve bank data.'], 500);
           }

    }

    public function lpgBillFetch(Request $request) {
        // return $request;
        // die();

        $inputs = $request->except(['_token']);

        $paramInfo = [];

        foreach ($inputs as $key => $value) {
            $paramInfo[] = [
                'paramName' => $key,
                'value' => $value
            ];
        }



        if ($request->FetchPay == 0) {
        $billData = [
        // 'customerName' => $res['data']['name'],
        //'billNumber' => '123456',
        //'billDate' => '2025-05-30',
        // 'billDueDate' => $res['data']['duedate'],
        'billAmount' => $request->rechargeAmount,
        // 'enquiryReferenceId' => $res['data']['txnid'],
        'billerId' => 'C14',
        'mobile' => session('mobile'),
        'geoCode' => $request->geocode,
        'latitude' => $request->latitude,
        'longitude' => $request->longitude,
        'geoCode' => $request->geoCode,
        // 'billFetch' => $res['data']['bill_fetch'],
        'digifintelParamInfo' => $paramInfo
    ];

        session(['data' => $billData]);

        $data = [
            [
                'billerId' => 'C14',
                'billAmount' => $request->rechargeAmount
            ]
        ];

        $this->digifintelbillPay(response()->json($data));

        } 
        else {

             // return $paramInfo;
        // die();

        $token = digifintelController::generateToken()['token'];
        $res = digifintelController::getBill($token, session('digifintelProductId'), $paramInfo);

        // return $res;
        // die();

        if ($res->successful()) {
        $billData = [
        'customerName' => $res['data']['name'],
        //'billNumber' => '123456',
        //'billDate' => '2025-05-30',
        'billDueDate' => $res['data']['duedate'],
        'billAmount' => $res['data']['amount'],
        'enquiryReferenceId' => $res['data']['txnid'],
        'billerId' => 'C14',
        'mobile' => session('mobile'),
        'geoCode' => $request->geocode,
        'latitude' => $request->latitude,
        'longitude' => $request->longitude,
        'geoCode' => $request->geoCode,
        'billFetch' => $res['data']['bill_fetch'],
        'digifintelParamInfo' => $paramInfo
    ];

    // // Store in session
    // session(['data' => $billData]);

    // $token = digifintelController::generateToken()['token'];
        $res1 = digifintelController::getParams($token, session('digifintelProductId'));

        //$res = digifintelController::getParams($token, 429);

        $response = $res1->json();

       
           if ($res1->successful() && $res->successful()) {
            // Store in session
             session(['data' => $billData]);
             return view('user.digifintelLpgRecharge.fetchParams', compact('response'));
           } 
           else {
               // Return an error message if the API call fails
               return response()->json(['error' => 'Failed to retrieve bank data.'], 500);
           }
    }

        }


       
}


public function dthBill() {

        $token = digifintelController::generateToken()['token'];

        $response = digifintelController::getSubCategories($token, "DTH");

        // return $response;
        // die();
        $responseData = $response->json();

        // return $responseData;
        // die();

        if ($response->successful()) {
        $operators = $responseData['data'];
        return view('user.digifintelDthRecharge.index', compact('operators'));
           } else {
               // Return an error message if the API call fails
               return response()->json(['error' => 'Failed to retrieve bank data.'], 500);
           }

    }

    public function dthBillFetchParams(Request $request) {

        // return $request;
        // die();
         

        $token = digifintelController::generateToken()['token'];
        $res = digifintelController::getParams($token, $request->operator);

        session([
        'digifintelProductId' => $request->operator,
    ]);
        //$res = digifintelController::getParams($token, 429);

        $response = $res->json();

       
        if ($res->successful()) {
            return view('user.digifintelDthRecharge.fetchParams', compact('response'));
        } else {
               // Return an error message if the API call fails
               return response()->json(['error' => 'Failed to retrieve bank data.'], 500);
           }

    }

    public function dthBillFetch(Request $request) {
        // return $request;
        // die();

        $inputs = $request->except(['_token']);

        $paramInfo = [];

        foreach ($inputs as $key => $value) {
            $paramInfo[] = [
                'paramName' => $key,
                'value' => $value
            ];
        }



        if ($request->FetchPay == 0) {
        $billData = [
        // 'customerName' => $res['data']['name'],
        //'billNumber' => '123456',
        //'billDate' => '2025-05-30',
        // 'billDueDate' => $res['data']['duedate'],
        'billAmount' => $request->rechargeAmount,
        // 'enquiryReferenceId' => $res['data']['txnid'],
        'billerId' => 'C03',
        'mobile' => session('mobile'),
        'geoCode' => $request->geocode,
        'latitude' => $request->latitude,
        'longitude' => $request->longitude,
        'geoCode' => $request->geoCode,
        // 'billFetch' => $res['data']['bill_fetch'],
        'digifintelParamInfo' => $paramInfo
    ];

        session(['data' => $billData]);

        $data = [
            [
                'billerId' => 'C03',
                'billAmount' => $request->rechargeAmount
            ]
        ];

        $this->digifintelbillPay(response()->json($data));

        } 
        else {

             // return $paramInfo;
        // die();

        $token = digifintelController::generateToken()['token'];
        $res = digifintelController::getBill($token, session('digifintelProductId'), $paramInfo);

        // return $res;
        // die();

        if ($res->successful()) {
        $billData = [
        'customerName' => $res['data']['name'],
        //'billNumber' => '123456',
        //'billDate' => '2025-05-30',
        'billDueDate' => $res['data']['duedate'],
        'billAmount' => $res['data']['amount'],
        'enquiryReferenceId' => $res['data']['txnid'],
        'billerId' => 'C03',
        'mobile' => session('mobile'),
        'geoCode' => $request->geocode,
        'latitude' => $request->latitude,
        'longitude' => $request->longitude,
        'geoCode' => $request->geoCode,
        'billFetch' => $res['data']['bill_fetch'],
        'digifintelParamInfo' => $paramInfo
    ];

    // // Store in session
    // session(['data' => $billData]);

    // $token = digifintelController::generateToken()['token'];
        $res1 = digifintelController::getParams($token, session('digifintelProductId'));

        //$res = digifintelController::getParams($token, 429);

        $response = $res1->json();

       
           if ($res1->successful() && $res->successful()) {
            // Store in session
             session(['data' => $billData]);
             return view('user.digifintelDthRecharge.fetchParams', compact('response'));
           } 
           else {
               // Return an error message if the API call fails
               return response()->json(['error' => 'Failed to retrieve bank data.'], 500);
           }
    }

        }


       
}


public function waterBill() {

        $token = digifintelController::generateToken()['token'];

        $response = digifintelController::getSubCategories($token, "Water");

        // return $response;
        // die();
        $responseData = $response->json();

        // return $responseData;
        // die();

        if ($response->successful()) {
        $operators = $responseData['data'];
        return view('user.digifintelWaterRecharge.index', compact('operators'));
           } else {
               // Return an error message if the API call fails
               return response()->json(['error' => 'Failed to retrieve bank data.'], 500);
           }

    }

    public function waterBillFetchParams(Request $request) {

        // return $request;
        // die();
         

        $token = digifintelController::generateToken()['token'];
        $res = digifintelController::getParams($token, $request->operator);

        session([
        'digifintelProductId' => $request->operator,
    ]);
        //$res = digifintelController::getParams($token, 429);

        $response = $res->json();

       
        if ($res->successful()) {
            return view('user.digifintelWaterRecharge.fetchParams', compact('response'));
        } else {
               // Return an error message if the API call fails
               return response()->json(['error' => 'Failed to retrieve bank data.'], 500);
           }

    }

    public function waterBillFetch(Request $request) {
        // return $request;
        // die();

        $inputs = $request->except(['_token']);

        $paramInfo = [];

        foreach ($inputs as $key => $value) {
            $paramInfo[] = [
                'paramName' => $key,
                'value' => $value
            ];
        }



        if ($request->FetchPay == 0) {
        $billData = [
        // 'customerName' => $res['data']['name'],
        //'billNumber' => '123456',
        //'billDate' => '2025-05-30',
        // 'billDueDate' => $res['data']['duedate'],
        'billAmount' => $request->rechargeAmount,
        // 'enquiryReferenceId' => $res['data']['txnid'],
        'billerId' => 'C08',
        'mobile' => session('mobile'),
        'geoCode' => $request->geocode,
        'latitude' => $request->latitude,
        'longitude' => $request->longitude,
        'geoCode' => $request->geoCode,
        // 'billFetch' => $res['data']['bill_fetch'],
        'digifintelParamInfo' => $paramInfo
    ];

        session(['data' => $billData]);

        $data = [
            [
                'billerId' => 'C08',
                'billAmount' => $request->rechargeAmount
            ]
        ];

        $this->digifintelbillPay(response()->json($data));

        } 
        else {

             // return $paramInfo;
        // die();

        $token = digifintelController::generateToken()['token'];
        $res = digifintelController::getBill($token, session('digifintelProductId'), $paramInfo);

        // return $res;
        // die();

        if ($res->successful()) {
        $billData = [
        'customerName' => $res['data']['name'],
        //'billNumber' => '123456',
        //'billDate' => '2025-05-30',
        'billDueDate' => $res['data']['duedate'],
        'billAmount' => $res['data']['amount'],
        'enquiryReferenceId' => $res['data']['txnid'],
        'billerId' => 'C08',
        'mobile' => session('mobile'),
        'geoCode' => $request->geocode,
        'latitude' => $request->latitude,
        'longitude' => $request->longitude,
        'geoCode' => $request->geoCode,
        'billFetch' => $res['data']['bill_fetch'],
        'digifintelParamInfo' => $paramInfo
    ];

    // // Store in session
    // session(['data' => $billData]);

    // $token = digifintelController::generateToken()['token'];
        $res1 = digifintelController::getParams($token, session('digifintelProductId'));

        //$res = digifintelController::getParams($token, 429);

        $response = $res1->json();

       
           if ($res1->successful() && $res->successful()) {
            // Store in session
             session(['data' => $billData]);
             return view('user.digifintelWaterRecharge.fetchParams', compact('response'));
           } 
           else {
               // Return an error message if the API call fails
               return response()->json(['error' => 'Failed to retrieve bank data.'], 500);
           }
    }

        }


       
}


public function landlineBill() {

        $token = digifintelController::generateToken()['token'];

        $response = digifintelController::getSubCategories($token, "Landline");

        // return $response;
        // die();
        $responseData = $response->json();

        // return $responseData;
        // die();

        if ($response->successful()) {
        $operators = $responseData['data'];
        return view('user.digifintelLandlineRecharge.index', compact('operators'));
           } else {
               // Return an error message if the API call fails
               return response()->json(['error' => 'Failed to retrieve bank data.'], 500);
           }

    }

    public function landlineBillFetchParams(Request $request) {

        // return $request;
        // die();
         

        $token = digifintelController::generateToken()['token'];
        $res = digifintelController::getParams($token, $request->operator);

        session([
        'digifintelProductId' => $request->operator,
    ]);
        //$res = digifintelController::getParams($token, 429);

        $response = $res->json();

       
        if ($res->successful()) {
            return view('user.digifintelLandlineRecharge.fetchParams', compact('response'));
        } else {
               // Return an error message if the API call fails
               return response()->json(['error' => 'Failed to retrieve bank data.'], 500);
           }

    }

    public function landlineBillFetch(Request $request) {
        // return $request;
        // die();

        $inputs = $request->except(['_token']);

        $paramInfo = [];

        foreach ($inputs as $key => $value) {
            $paramInfo[] = [
                'paramName' => $key,
                'value' => $value
            ];
        }



        if ($request->FetchPay == 0) {
        $billData = [
        // 'customerName' => $res['data']['name'],
        //'billNumber' => '123456',
        //'billDate' => '2025-05-30',
        // 'billDueDate' => $res['data']['duedate'],
        'billAmount' => $request->rechargeAmount,
        // 'enquiryReferenceId' => $res['data']['txnid'],
        'billerId' => 'C02',
        'mobile' => session('mobile'),
        'geoCode' => $request->geocode,
        'latitude' => $request->latitude,
        'longitude' => $request->longitude,
        'geoCode' => $request->geoCode,
        // 'billFetch' => $res['data']['bill_fetch'],
        'digifintelParamInfo' => $paramInfo
    ];

        session(['data' => $billData]);

        $data = [
            [
                'billerId' => 'C02',
                'billAmount' => $request->rechargeAmount
            ]
        ];

        $this->digifintelbillPay(response()->json($data));

        } 
        else {

             // return $paramInfo;
        // die();

        $token = digifintelController::generateToken()['token'];
        $res = digifintelController::getBill($token, session('digifintelProductId'), $paramInfo);

        // return $res;
        // die();

        if ($res->successful()) {
        $billData = [
        'customerName' => $res['data']['name'],
        //'billNumber' => '123456',
        //'billDate' => '2025-05-30',
        'billDueDate' => $res['data']['duedate'],
        'billAmount' => $res['data']['amount'],
        'enquiryReferenceId' => $res['data']['txnid'],
        'billerId' => 'C02',
        'mobile' => session('mobile'),
        'geoCode' => $request->geocode,
        'latitude' => $request->latitude,
        'longitude' => $request->longitude,
        'geoCode' => $request->geoCode,
        'billFetch' => $res['data']['bill_fetch'],
        'digifintelParamInfo' => $paramInfo
    ];

    // // Store in session
    // session(['data' => $billData]);

    // $token = digifintelController::generateToken()['token'];
        $res1 = digifintelController::getParams($token, session('digifintelProductId'));

        //$res = digifintelController::getParams($token, 429);

        $response = $res1->json();

       
           if ($res1->successful() && $res->successful()) {
            // Store in session
             session(['data' => $billData]);
             return view('user.digifintelLandlineRecharge.fetchParams', compact('response'));
           } 
           else {
               // Return an error message if the API call fails
               return response()->json(['error' => 'Failed to retrieve bank data.'], 500);
           }
    }

        }


       
}

public function cableBill() {

        $token = digifintelController::generateToken()['token'];

        $response = digifintelController::getSubCategories($token, "Cable");

        // return $response;
        // die();
        $responseData = $response->json();

        // return $responseData;
        // die();

        if ($response->successful()) {
        $operators = $responseData['data'];
        return view('user.digifintelCableRecharge.index', compact('operators'));
           } else {
               // Return an error message if the API call fails
               return response()->json(['error' => 'Failed to retrieve bank data.'], 500);
           }

    }

    public function cableBillFetchParams(Request $request) {

        // return $request;
        // die();
         

        $token = digifintelController::generateToken()['token'];
        $res = digifintelController::getParams($token, $request->operator);

        session([
        'digifintelProductId' => $request->operator,
    ]);
        //$res = digifintelController::getParams($token, 429);

        $response = $res->json();

       
        if ($res->successful()) {
            return view('user.digifintelCableRecharge.fetchParams', compact('response'));
        } else {
               // Return an error message if the API call fails
               return response()->json(['error' => 'Failed to retrieve bank data.'], 500);
           }

    }

    public function cableBillFetch(Request $request) {
        // return $request;
        // die();

        $inputs = $request->except(['_token']);

        $paramInfo = [];

        foreach ($inputs as $key => $value) {
            $paramInfo[] = [
                'paramName' => $key,
                'value' => $value
            ];
        }



        if ($request->FetchPay == 0) {
        $billData = [
        // 'customerName' => $res['data']['name'],
        //'billNumber' => '123456',
        //'billDate' => '2025-05-30',
        // 'billDueDate' => $res['data']['duedate'],
        'billAmount' => $request->rechargeAmount,
        // 'enquiryReferenceId' => $res['data']['txnid'],
        'billerId' => 'C06',
        'mobile' => session('mobile'),
        'geoCode' => $request->geocode,
        'latitude' => $request->latitude,
        'longitude' => $request->longitude,
        'geoCode' => $request->geoCode,
        // 'billFetch' => $res['data']['bill_fetch'],
        'digifintelParamInfo' => $paramInfo
    ];

        session(['data' => $billData]);

        $data = [
            [
                'billerId' => 'C06',
                'billAmount' => $request->rechargeAmount
            ]
        ];

        $this->digifintelbillPay(response()->json($data));

        } 
        else {

             // return $paramInfo;
        // die();

        $token = digifintelController::generateToken()['token'];
        $res = digifintelController::getBill($token, session('digifintelProductId'), $paramInfo);

        // return $res;
        // die();

        if ($res->successful()) {
        $billData = [
        'customerName' => $res['data']['name'],
        //'billNumber' => '123456',
        //'billDate' => '2025-05-30',
        'billDueDate' => $res['data']['duedate'],
        'billAmount' => $res['data']['amount'],
        'enquiryReferenceId' => $res['data']['txnid'],
        'billerId' => 'C06',
        'mobile' => session('mobile'),
        'geoCode' => $request->geocode,
        'latitude' => $request->latitude,
        'longitude' => $request->longitude,
        'geoCode' => $request->geoCode,
        'billFetch' => $res['data']['bill_fetch'],
        'digifintelParamInfo' => $paramInfo
    ];

    // // Store in session
    // session(['data' => $billData]);

    // $token = digifintelController::generateToken()['token'];
        $res1 = digifintelController::getParams($token, session('digifintelProductId'));

        //$res = digifintelController::getParams($token, 429);

        $response = $res1->json();

       
           if ($res1->successful() && $res->successful()) {
            // Store in session
             session(['data' => $billData]);
             return view('user.digifintelCableRecharge.fetchParams', compact('response'));
           } 
           else {
               // Return an error message if the API call fails
               return response()->json(['error' => 'Failed to retrieve bank data.'], 500);
           }
    }

        }


       
}

public function muncipalityBill() {

        $token = digifintelController::generateToken()['token'];

        $response = digifintelController::getSubCategories($token, "Municipality");

        // return $response;
        // die();
        $responseData = $response->json();

        // return $responseData;
        // die();

        if ($response->successful()) {
        $operators = $responseData['data'];
        return view('user.digifintelMuncipalityRecharge.index', compact('operators'));
           } else {
               // Return an error message if the API call fails
               return response()->json(['error' => 'Failed to retrieve bank data.'], 500);
           }

    }

    public function muncipalityBillFetchParams(Request $request) {

        // return $request;
        // die();
         

        $token = digifintelController::generateToken()['token'];
        $res = digifintelController::getParams($token, $request->operator);

        session([
        'digifintelProductId' => $request->operator,
    ]);
        //$res = digifintelController::getParams($token, 429);

        $response = $res->json();

       
        if ($res->successful()) {
            return view('user.digifintelMuncipalityRecharge.fetchParams', compact('response'));
        } else {
               // Return an error message if the API call fails
               return response()->json(['error' => 'Failed to retrieve bank data.'], 500);
           }

    }

    public function muncipalityBillFetch(Request $request) {
        // return $request;
        // die();

        $inputs = $request->except(['_token']);

        $paramInfo = [];

        foreach ($inputs as $key => $value) {
            $paramInfo[] = [
                'paramName' => $key,
                'value' => $value
            ];
        }



        if ($request->FetchPay == 0) {
        $billData = [
        // 'customerName' => $res['data']['name'],
        //'billNumber' => '123456',
        //'billDate' => '2025-05-30',
        // 'billDueDate' => $res['data']['duedate'],
        'billAmount' => $request->rechargeAmount,
        // 'enquiryReferenceId' => $res['data']['txnid'],
        'billerId' => 'C19',
        'mobile' => session('mobile'),
        'geoCode' => $request->geocode,
        'latitude' => $request->latitude,
        'longitude' => $request->longitude,
        'geoCode' => $request->geoCode,
        // 'billFetch' => $res['data']['bill_fetch'],
        'digifintelParamInfo' => $paramInfo
    ];

        session(['data' => $billData]);

        $data = [
            [
                'billerId' => 'C19',
                'billAmount' => $request->rechargeAmount
            ]
        ];

        $this->digifintelbillPay(response()->json($data));

        } 
        else {

             // return $paramInfo;
        // die();

        $token = digifintelController::generateToken()['token'];
        $res = digifintelController::getBill($token, session('digifintelProductId'), $paramInfo);

        // return $res;
        // die();

        if ($res->successful()) {
        $billData = [
        'customerName' => $res['data']['name'],
        //'billNumber' => '123456',
        //'billDate' => '2025-05-30',
        'billDueDate' => $res['data']['duedate'],
        'billAmount' => $res['data']['amount'],
        'enquiryReferenceId' => $res['data']['txnid'],
        'billerId' => 'C19',
        'mobile' => session('mobile'),
        'geoCode' => $request->geocode,
        'latitude' => $request->latitude,
        'longitude' => $request->longitude,
        'geoCode' => $request->geoCode,
        'billFetch' => $res['data']['bill_fetch'],
        'digifintelParamInfo' => $paramInfo
    ];

    // // Store in session
    // session(['data' => $billData]);

    // $token = digifintelController::generateToken()['token'];
        $res1 = digifintelController::getParams($token, session('digifintelProductId'));

        //$res = digifintelController::getParams($token, 429);

        $response = $res1->json();

       
           if ($res1->successful() && $res->successful()) {
            // Store in session
             session(['data' => $billData]);
             return view('user.digifintelMuncipalityRecharge.fetchParams', compact('response'));
           } 
           else {
               // Return an error message if the API call fails
               return response()->json(['error' => 'Failed to retrieve bank data.'], 500);
           }
    }

        }


       
}

public function fastagBill() {

        $token = digifintelController::generateToken()['token'];

        $response = digifintelController::getSubCategories($token, "Fastag");

        // return $response;
        // die();
        $responseData = $response->json();

        // return $responseData;
        // die();

        if ($response->successful()) {
        $operators = $responseData['data'];
        return view('user.digifintelFastagRecharge.index', compact('operators'));
           } else {
               // Return an error message if the API call fails
               return response()->json(['error' => 'Failed to retrieve bank data.'], 500);
           }

    }

    public function fastagBillFetchParams(Request $request) {

        // return $request;
        // die();
         

        $token = digifintelController::generateToken()['token'];
        $res = digifintelController::getParams($token, $request->operator);

        session([
        'digifintelProductId' => $request->operator,
    ]);
        //$res = digifintelController::getParams($token, 429);

        $response = $res->json();

       
        if ($res->successful()) {
            return view('user.digifintelFastagRecharge.fetchParams', compact('response'));
        } else {
               // Return an error message if the API call fails
               return response()->json(['error' => 'Failed to retrieve bank data.'], 500);
           }

    }

    public function fastagBillFetch(Request $request) {
        // return $request;
        // die();

        $inputs = $request->except(['_token']);

        $paramInfo = [];

        foreach ($inputs as $key => $value) {
            $paramInfo[] = [
                'paramName' => $key,
                'value' => $value
            ];
        }



        if ($request->FetchPay == 0) {
        $billData = [
        // 'customerName' => $res['data']['name'],
        //'billNumber' => '123456',
        //'billDate' => '2025-05-30',
        // 'billDueDate' => $res['data']['duedate'],
        'billAmount' => $request->rechargeAmount,
        // 'enquiryReferenceId' => $res['data']['txnid'],
        'billerId' => 'C10',
        'mobile' => session('mobile'),
        'geoCode' => $request->geocode,
        'latitude' => $request->latitude,
        'longitude' => $request->longitude,
        'geoCode' => $request->geoCode,
        // 'billFetch' => $res['data']['bill_fetch'],
        'digifintelParamInfo' => $paramInfo
    ];

        session(['data' => $billData]);

        $data = [
            [
                'billerId' => 'C10',
                'billAmount' => $request->rechargeAmount
            ]
        ];

        $this->digifintelbillPay(response()->json($data));

        } 
        else {

             // return $paramInfo;
        // die();

        $token = digifintelController::generateToken()['token'];
        $res = digifintelController::getBill($token, session('digifintelProductId'), $paramInfo);

        // return $res;
        // die();

        if ($res->successful()) {
        $billData = [
        'customerName' => $res['data']['name'],
        //'billNumber' => '123456',
        //'billDate' => '2025-05-30',
        'billDueDate' => $res['data']['duedate'],
        'billAmount' => $res['data']['amount'],
        'enquiryReferenceId' => $res['data']['txnid'],
        'billerId' => 'C10',
        'mobile' => session('mobile'),
        'geoCode' => $request->geocode,
        'latitude' => $request->latitude,
        'longitude' => $request->longitude,
        'geoCode' => $request->geoCode,
        'billFetch' => $res['data']['bill_fetch'],
        'digifintelParamInfo' => $paramInfo
    ];

    // // Store in session
    // session(['data' => $billData]);

    // $token = digifintelController::generateToken()['token'];
        $res1 = digifintelController::getParams($token, session('digifintelProductId'));

        //$res = digifintelController::getParams($token, 429);

        $response = $res1->json();

       
           if ($res1->successful() && $res->successful()) {
            // Store in session
             session(['data' => $billData]);
             return view('user.digifintelFastagRecharge.fetchParams', compact('response'));
           } 
           else {
               // Return an error message if the API call fails
               return response()->json(['error' => 'Failed to retrieve bank data.'], 500);
           }
    }

        }


       
}

public function broadbandBill() {

        $token = digifintelController::generateToken()['token'];

        $response = digifintelController::getSubCategories($token, "Broadband");

        // return $response;
        // die();
        $responseData = $response->json();

        // return $responseData;
        // die();

        if ($response->successful()) {
        $operators = $responseData['data'];
        return view('user.digifintelBroadbandRecharge.index', compact('operators'));
           } else {
               // Return an error message if the API call fails
               return response()->json(['error' => 'Failed to retrieve bank data.'], 500);
           }

    }

    public function broadbandBillFetchParams(Request $request) {

        // return $request;
        // die();
         

        $token = digifintelController::generateToken()['token'];
        $res = digifintelController::getParams($token, $request->operator);

        session([
        'digifintelProductId' => $request->operator,
    ]);
        //$res = digifintelController::getParams($token, 429);

        $response = $res->json();

       
        if ($res->successful()) {
            return view('user.digifintelBroadbandRecharge.fetchParams', compact('response'));
        } else {
               // Return an error message if the API call fails
               return response()->json(['error' => 'Failed to retrieve bank data.'], 500);
           }

    }

    public function broadbandBillFetch(Request $request) {
        // return $request;
        // die();

        $inputs = $request->except(['_token']);

        $paramInfo = [];

        foreach ($inputs as $key => $value) {
            $paramInfo[] = [
                'paramName' => $key,
                'value' => $value
            ];
        }



        if ($request->FetchPay == 0) {
        $billData = [
        // 'customerName' => $res['data']['name'],
        //'billNumber' => '123456',
        //'billDate' => '2025-05-30',
        // 'billDueDate' => $res['data']['duedate'],
        'billAmount' => $request->rechargeAmount,
        // 'enquiryReferenceId' => $res['data']['txnid'],
        'billerId' => 'C05',
        'mobile' => session('mobile'),
        'geoCode' => $request->geocode,
        'latitude' => $request->latitude,
        'longitude' => $request->longitude,
        'geoCode' => $request->geoCode,
        // 'billFetch' => $res['data']['bill_fetch'],
        'digifintelParamInfo' => $paramInfo
    ];

        session(['data' => $billData]);

        $data = [
            [
                'billerId' => 'C05',
                'billAmount' => $request->rechargeAmount
            ]
        ];

        $this->digifintelbillPay(response()->json($data));

        } 
        else {

             // return $paramInfo;
        // die();

        $token = digifintelController::generateToken()['token'];
        $res = digifintelController::getBill($token, session('digifintelProductId'), $paramInfo);

        // return $res;
        // die();

        if ($res->successful()) {
        $billData = [
        'customerName' => $res['data']['name'],
        //'billNumber' => '123456',
        //'billDate' => '2025-05-30',
        'billDueDate' => $res['data']['duedate'],
        'billAmount' => $res['data']['amount'],
        'enquiryReferenceId' => $res['data']['txnid'],
        'billerId' => 'C05',
        'mobile' => session('mobile'),
        'geoCode' => $request->geocode,
        'latitude' => $request->latitude,
        'longitude' => $request->longitude,
        'geoCode' => $request->geoCode,
        'billFetch' => $res['data']['bill_fetch'],
        'digifintelParamInfo' => $paramInfo
    ];

    // // Store in session
    // session(['data' => $billData]);

    // $token = digifintelController::generateToken()['token'];
        $res1 = digifintelController::getParams($token, session('digifintelProductId'));

        //$res = digifintelController::getParams($token, 429);

        $response = $res1->json();

       
           if ($res1->successful() && $res->successful()) {
            // Store in session
             session(['data' => $billData]);
             return view('user.digifintelBroadbandRecharge.fetchParams', compact('response'));
           } 
           else {
               // Return an error message if the API call fails
               return response()->json(['error' => 'Failed to retrieve bank data.'], 500);
           }
    }

        }


       
}

public function datacardprepaidBill() {

        $token = digifintelController::generateToken()['token'];

        $response = digifintelController::getSubCategories($token, "Datacard Prepaid");

        // return $response;
        // die();
        $responseData = $response->json();

        // return $responseData;
        // die();

        if ($response->successful()) {
        $operators = $responseData['data'];
        return view('user.digifintelDatacardPrepaidRecharge.index', compact('operators'));
           } else {
               // Return an error message if the API call fails
               return response()->json(['error' => 'Failed to retrieve bank data.'], 500);
           }

    }

    public function datacardprepaidBillFetchParams(Request $request) {

        // return $request;
        // die();
         

        $token = digifintelController::generateToken()['token'];
        $res = digifintelController::getParams($token, $request->operator);

        session([
        'digifintelProductId' => $request->operator,
    ]);
        //$res = digifintelController::getParams($token, 429);

        $response = $res->json();
        // $response['data']['fetchBill'] = 0;
        // dd($response);

       
        if ($res->successful()) {
            return view('user.digifintelDatacardPrepaidRecharge.fetchParams', compact('response'));
        } else {
               // Return an error message if the API call fails
               return response()->json(['error' => 'Failed to retrieve bank data.'], 500);
           }

    }

    public function datacardprepaidBillFetch(Request $request) {
        // return $request;
        // die();

        $inputs = $request->except(['_token']);

        $paramInfo = [];

        foreach ($inputs as $key => $value) {
            $paramInfo[] = [
                'paramName' => $key,
                'value' => $value
            ];
        }



        if ($request->FetchPay == 0) {
        $billData = [
        // 'customerName' => $res['data']['name'],
        //'billNumber' => '123456',
        //'billDate' => '2025-05-30',
        // 'billDueDate' => $res['data']['duedate'],
        'billAmount' => $request->rechargeAmount,
        // 'enquiryReferenceId' => $res['data']['txnid'],
        'billerId' => 'C00', //to check with Sarvesh
        'mobile' => session('mobile'),
        'geoCode' => $request->geocode,
        'latitude' => $request->latitude,
        'longitude' => $request->longitude,
        'geoCode' => $request->geoCode,
        // 'billFetch' => $res['data']['bill_fetch'],
        'digifintelParamInfo' => $paramInfo
    ];

        session(['data' => $billData]);

        $data = [
            [
                'billerId' => 'C00',
                'billAmount' => $request->rechargeAmount
            ]
        ];

        $request = new \Illuminate\Http\Request();
        $request->replace($data);


        $this->digifintelbillPay($request);

        } 
        else {

             // return $paramInfo;
        // die();

        $token = digifintelController::generateToken()['token'];
        $res = digifintelController::getBill($token, session('digifintelProductId'), $paramInfo);

        // return $res;
        // die();

        if ($res->successful()) {
        $billData = [
        'customerName' => $res['data']['name'],
        //'billNumber' => '123456',
        //'billDate' => '2025-05-30',
        'billDueDate' => $res['data']['duedate'],
        'billAmount' => $res['data']['amount'],
        'enquiryReferenceId' => $res['data']['txnid'],
        'billerId' => 'C00',
        'mobile' => session('mobile'),
        'geoCode' => $request->geocode,
        'latitude' => $request->latitude,
        'longitude' => $request->longitude,
        'geoCode' => $request->geoCode,
        'billFetch' => $res['data']['bill_fetch'],
        'digifintelParamInfo' => $paramInfo
    ];

    // // Store in session
    // session(['data' => $billData]);

    // $token = digifintelController::generateToken()['token'];
        $res1 = digifintelController::getParams($token, session('digifintelProductId'));

        //$res = digifintelController::getParams($token, 429);

        $response = $res1->json();

       
           if ($res1->successful() && $res->successful()) {
            // Store in session
             session(['data' => $billData]);
             return view('user.digifintelDatacardPrepaidRecharge.fetchParams', compact('response'));
           } 
           else {
               // Return an error message if the API call fails
               return response()->json(['error' => 'Failed to retrieve bank data.'], 500);
           }
    }

        }


       
}

public function datacardpostpaidBill() {

        $token = digifintelController::generateToken()['token'];

        $response = digifintelController::getSubCategories($token, "Datacard Postpaid");

        // return $response;
        // die();
        $responseData = $response->json();

        // return $responseData;
        // die();

        if ($response->successful()) {
        $operators = $responseData['data'];
        return view('user.digifintelDatacardPostpaidRecharge.index', compact('operators'));
           } else {
               // Return an error message if the API call fails
               return response()->json(['error' => 'Failed to retrieve bank data.'], 500);
           }

    }

    public function datacardpostpaidBillFetchParams(Request $request) {

        // return $request;
        // die();
         

        $token = digifintelController::generateToken()['token'];
        $res = digifintelController::getParams($token, $request->operator);

        session([
        'digifintelProductId' => $request->operator,
    ]);
        //$res = digifintelController::getParams($token, 429);

        $response = $res->json();

       
        if ($res->successful()) {
            return view('user.digifintelDatacardPostpaidRecharge.fetchParams', compact('response'));
        } else {
               // Return an error message if the API call fails
               return response()->json(['error' => 'Failed to retrieve bank data.'], 500);
           }

    }

    public function datacardpostpaidBillFetch(Request $request) {
        // return $request;
        // die();

        $inputs = $request->except(['_token']);

        $paramInfo = [];

        foreach ($inputs as $key => $value) {
            $paramInfo[] = [
                'paramName' => $key,
                'value' => $value
            ];
        }



        if ($request->FetchPay == 0) {
        $billData = [
        // 'customerName' => $res['data']['name'],
        //'billNumber' => '123456',
        //'billDate' => '2025-05-30',
        // 'billDueDate' => $res['data']['duedate'],
        'billAmount' => $request->rechargeAmount,
        // 'enquiryReferenceId' => $res['data']['txnid'],
        'billerId' => 'C01', //to check with Sarvesh
        'mobile' => session('mobile'),
        'geoCode' => $request->geocode,
        'latitude' => $request->latitude,
        'longitude' => $request->longitude,
        'geoCode' => $request->geoCode,
        // 'billFetch' => $res['data']['bill_fetch'],
        'digifintelParamInfo' => $paramInfo
    ];

        session(['data' => $billData]);

        $data = [
            [
                'billerId' => 'C01',
                'billAmount' => $request->rechargeAmount
            ]
        ];

        $this->digifintelbillPay(response()->json($data));

        } 
        else {

             // return $paramInfo;
        // die();

        $token = digifintelController::generateToken()['token'];
        $res = digifintelController::getBill($token, session('digifintelProductId'), $paramInfo);

        // return $res;
        // die();

        if ($res->successful()) {
        $billData = [
        'customerName' => $res['data']['name'],
        //'billNumber' => '123456',
        //'billDate' => '2025-05-30',
        'billDueDate' => $res['data']['duedate'],
        'billAmount' => $res['data']['amount'],
        'enquiryReferenceId' => $res['data']['txnid'],
        'billerId' => 'C01',
        'mobile' => session('mobile'),
        'geoCode' => $request->geocode,
        'latitude' => $request->latitude,
        'longitude' => $request->longitude,
        'geoCode' => $request->geoCode,
        'billFetch' => $res['data']['bill_fetch'],
        'digifintelParamInfo' => $paramInfo
    ];

    // // Store in session
    // session(['data' => $billData]);

    // $token = digifintelController::generateToken()['token'];
        $res1 = digifintelController::getParams($token, session('digifintelProductId'));

        //$res = digifintelController::getParams($token, 429);

        $response = $res1->json();

       
           if ($res1->successful() && $res->successful()) {
            // Store in session
             session(['data' => $billData]);
             return view('user.digifintelDatacardPostpaidRecharge.fetchParams', compact('response'));
           } 
           else {
               // Return an error message if the API call fails
               return response()->json(['error' => 'Failed to retrieve bank data.'], 500);
           }
    }

        }


       
}


public function postpaidBill() {

        $token = digifintelController::generateToken()['token'];

        $response = digifintelController::getSubCategories($token, "Postpaid");

        // return $response;
        // die();
        $responseData = $response->json();

        // return $responseData;
        // die();

        if ($response->successful()) {
        $operators = $responseData['data'];
        return view('user.digifintelPostpaidRecharge.index', compact('operators'));
           } else {
               // Return an error message if the API call fails
               return response()->json(['error' => 'Failed to retrieve bank data.'], 500);
           }

    }

    public function postpaidBillFetchParams(Request $request) {

        // return $request;
        // die();
         

        $token = digifintelController::generateToken()['token'];
        $res = digifintelController::getParams($token, $request->operator);

        session([
        'digifintelProductId' => $request->operator,
    ]);
        //$res = digifintelController::getParams($token, 429);

        $response = $res->json();

       
        if ($res->successful()) {
            return view('user.digifintelPostpaidRecharge.fetchParams', compact('response'));
        } else {
               // Return an error message if the API call fails
               return response()->json(['error' => 'Failed to retrieve bank data.'], 500);
           }

    }

    public function postpaidBillFetch(Request $request) {
        // return $request;
        // die();

        $inputs = $request->except(['_token']);

        $paramInfo = [];

        foreach ($inputs as $key => $value) {
            $paramInfo[] = [
                'paramName' => $key,
                'value' => $value
            ];
        }



        if ($request->FetchPay == 0) {
        $billData = [
        // 'customerName' => $res['data']['name'],
        //'billNumber' => '123456',
        //'billDate' => '2025-05-30',
        // 'billDueDate' => $res['data']['duedate'],
        'billAmount' => $request->rechargeAmount,
        // 'enquiryReferenceId' => $res['data']['txnid'],
        'billerId' => 'C01',
        'mobile' => session('mobile'),
        'geoCode' => $request->geocode,
        'latitude' => $request->latitude,
        'longitude' => $request->longitude,
        'geoCode' => $request->geoCode,
        // 'billFetch' => $res['data']['bill_fetch'],
        'digifintelParamInfo' => $paramInfo
    ];

        session(['data' => $billData]);

        $data = [
            [
                'billerId' => 'C01',
                'billAmount' => $request->rechargeAmount
            ]
        ];

        $this->digifintelbillPay(response()->json($data));

        } 
        else {

             // return $paramInfo;
        // die();

        $token = digifintelController::generateToken()['token'];
        $res = digifintelController::getBill($token, session('digifintelProductId'), $paramInfo);

        // return $res;
        // die();

        if ($res->successful()) {
        $billData = [
        'customerName' => $res['data']['name'],
        //'billNumber' => '123456',
        //'billDate' => '2025-05-30',
        'billDueDate' => $res['data']['duedate'],
        'billAmount' => $res['data']['amount'],
        'enquiryReferenceId' => $res['data']['txnid'],
        'billerId' => 'C01',
        'mobile' => session('mobile'),
        'geoCode' => $request->geocode,
        'latitude' => $request->latitude,
        'longitude' => $request->longitude,
        'geoCode' => $request->geoCode,
        'billFetch' => $res['data']['bill_fetch'],
        'digifintelParamInfo' => $paramInfo
    ];

    // // Store in session
    // session(['data' => $billData]);

    // $token = digifintelController::generateToken()['token'];
        $res1 = digifintelController::getParams($token, session('digifintelProductId'));

        //$res = digifintelController::getParams($token, 429);

        $response = $res1->json();

       
           if ($res1->successful() && $res->successful()) {
            // Store in session
             session(['data' => $billData]);
             return view('user.digifintelPostpaidRecharge.fetchParams', compact('response'));
           } 
           else {
               // Return an error message if the API call fails
               return response()->json(['error' => 'Failed to retrieve bank data.'], 500);
           }
    }

        }


       
}


}
