<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Helpers\ApiHelper;
use function PHPUnit\Framework\returnCallback;
class prePaidRechargeController extends Controller
{
    public function mobileRecharge()
    {
        return view('user.mobileRecharge.index');
    }
    public function getISP()
    {
        // return "hello";
        // die();
        // Make the API call
        $customerOutletId = intval(session('outlet'));
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        //])->post('http://127.0.0.1:8000/api/v1/prepaid/mobileRecharge', [
         ])->post(env('liveUrl').'v1/prepaid/mobileRecharge', [

            'outlet' =>$customerOutletId
        ]);
    return $response;
    die();
        if ($response->successful()) {
            $responseData = $response->json();
            return $responseData;
        } else {
            // Return an error message if the API call fails
            return response()->json(['error' => 'Failed to retrieve  data.'], 500);
        }
    }

    public function mobileRechargePay(Request $request)
{
    
    // return $request;
    // die();
    // Get request inputs
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
        $data = $response['respose']['data'];

        $filteredData = [
            'externalRef' => $data['externalRef'] ?? null,
            'txnValue' => $data['txnValue'] ?? null,
            'billerDetails' => $data['billerDetails'] ?? []
        ];
        
        if ($response['statuscode'] === "TXN" || $response['statuscode'] === "TUP") {
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

public function mobiletest()
    {
       
        // return "Hello";
        // die();
        $mobile = session('mobile');
        $role = session('role');
      
        // $externalRef = 'RPF-' . strtoupper(uniqid(date('YmdHis')));
        $externalRef = 'TXN' . date('Y') . '' . round(microtime(true) * 1000);
        //dd($externalRef);
        //dd($mobile,$role,$externalRef);
         //die();
      //  $this->updateCustomerBalance($mobile, $role, $externalRef);
        $this->updateCustomerBalance($mobile, $role, $externalRef);
    }

private function updateCustomerBalance($mobile, $role, $externalRef){


    // dd($mobile,$role,$externalRef);
    // die();
    
    
    $closingBalance = 0;
    $getDisComm = 0;
    $commissionAmount = 0;
    $tds = 0;
    $commissionValue = 0;
    $newPayableValue = 0;
    $payableValue=0;
    $payAmount=0;
    try {
        // Fetch the latest transaction for the given mobile number
        try {
            $lastRecord = DB::table('utility_payments')
                ->where('mobile', $mobile)
                ->latest('created_at')
                ->first();
            //     dd($lastRecord);
            //     dd("    Hellowqq");
            //    die();
            if (!$lastRecord) {
                session(['totalPayableValue' => 0]);
                return;
            }
        } catch (\Exception $e) {
            dd('Error fetching the latest transaction: ' . $e->getMessage());
            session(['totalPayableValue' => 0]);
            return;
        }

        // Decode the response data from the latest transaction

        try {
            $responseData = json_decode($lastRecord->response_body, true);
            //dd('hello',$responseData );
            
        } catch (\Exception $e) {
            dd('Error decoding response data: ' . $e->getMessage());
            session(['totalPayableValue' => 0]);
            return;
        }

        // Validate and process transaction data
        if (isset($responseData['respose']['data']['txnValue'], $responseData['statuscode']) &&
                in_array($responseData['statuscode'], ['TXN', 'TUP'])) {
            $payableValue = $responseData['respose']['data']['txnValue'];
            $payAmount=$responseData['respose']['data']['txnValue'];

                    // dd($payableValue);
                    // die();
           
            // Fetch commission details based on role and service
            try {
                $commissions = DB::table('commission_plan')
                     ->where('packages', $role)
                    ->where('service', 'C00')
                    ->get();
                    // dd($commissions, $role);
            } catch (\Exception $e) {
                dd('Error fetching commission details: ' . $e->getMessage());
                session(['totalPayableValue' => 0]);
                return;
            }

            foreach ($commissions as $commission) { 
                if ($payableValue >= $commission->from_amount && $payableValue <= $commission->to_amount) {
                    try {
                        // Calculate commission, charges, and TDS
                        $commissionAmount = $commission->charge_in === 'Percentage'
                            ? $payableValue * $commission->charge / 100
                            : $commission->charge;

                        $commissionValue = $commission->commission_in === 'Percentage'
                            ? $commissionAmount * $commission->commission / 100
                            : $commission->commission;

                        $tds = $commission->tds_in === 'Percentage'
                            ? $commissionValue * $commission->tds / 100
                            : $commission->tds;

                        $payableValue += $commissionAmount;
                        break;
                    } catch (\Exception $e) {
                        dd('Error calculating commission: ' . $e->getMessage());
                        continue;
                    }
                }
            }

            try {
                // Calculate balances
                $openingBalance = session('balance');
                $closingBalance = $openingBalance - $payableValue;
              //  dd($openingBalance,$closingBalance);
            } catch (\Exception $e) {
                dd('Error calculating balances: ' . $e->getMessage());
                session(['totalPayableValue' => 0]);
                return;
            }
            try {
                //dd($openingBalance,$closingBalance);
                // Update transaction details
                DB::table('utility_payments')
                    ->where('id', $lastRecord->id)
                    ->update([
                        'opening_balance' => $openingBalance,
                        'closing_balance' => $closingBalance,
                        'charges' => $commissionAmount,
                        'tds' => $tds,
                        'commission' => $commissionValue,
                    ]);
            } catch (\Exception $e) {
                dd('Error updating transaction details: ' . $e->getMessage());
            }
            // Handle distributor commission
            try {
                // $customer = DB::table('customer')->where('phone', $mobile)->first();
                // if ($customer && !is_null($customer->dis_phone)) {
                //     $disPhone = $customer->dis_phone;
                //     $getDisComm = $payableValue * 0.01 / 100;
                //     $newPayableValue = $payableValue + $getDisComm;

                // New commission code
                $getMapService=DB::table('map_commission_plan')
                ->get();
                // dd($getMapService);
                // die();
                $getDis = DB::table('customer')
                    ->where('phone', $mobile)
                    ->first();  // Fetch the first record

                $disPhone = '';
                $disCommValue = 0;
                $dbName = env('DB_DATABASE');
                if ($getDis) {
                    $disPhone = $getDis->dis_phone;
                    $sql = DB::select('SELECT COUNT(dis_phone) as disCount FROM customer WHERE dis_phone = ?', [$disPhone]);
                    $disCount = $sql[0]->disCount;
                    if ($disCount > 0) {
                        $sql = DB::select("
                        SELECT 
                            FORMAT(
                                CASE 
                                    WHEN commission_in = 'Percentage' THEN ? * commission / 100 
                                    WHEN commission_in = 'Flat' THEN commission 
                                    ELSE 0 
                                END, 2
                            ) AS commission_value
                        FROM  {$dbName}.map_commission_plan
                        WHERE ? BETWEEN from_rt_count AND to_rt_count ",
                            [$payableValue, $disCount]);
                        $disCommValue = $sql[0]->commission_value;
                    }

                    if ($getDis && is_null($getDis->dis_phone)) {
                        $getDisComm = 0;
                        $newPayableValue = $payableValue;
                    } else {
                        // echo "Dis not Done";
                        $getDisComm += $disCommValue;
                        $newPayableValue = $payableValue + $getDisComm;
                    }
                }
                else{

                }
                //dd($disCommValue,$payableValue, $getDisComm, $newPayableValue);
                //die();

                // Update distributor balance
                DB::table('customer')->where('phone', $disPhone)->increment('balance', $getDisComm);

                // Log distributor commission
                
                $disData = DB::table('customer')->where('phone', $disPhone)->first();
                if ($disData) {
                    DB::table('dis_commission')->insert([
                        'dis_no' => $disPhone,
                        'services' => 'Mobile Recharge',
                        'retailer_no' => $mobile,
                        'commission' => $getDisComm,
                        'opening_balance' => $disData->balance,
                        'closing_balance' => $disData->balance + $getDisComm,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
                // } else {
                //     $newPayableValue = $payableValue;
                // }
            } catch (\Exception $e) {
                dd('Error handling distributor commission: ' . $e->getMessage());
            }

           

            try {
                // Update customer balance
                DB::table('customer')->where('phone', $mobile)->decrement('balance', $newPayableValue);
            } catch (\Exception $e) {
                dd('Error updating customer balance: ' . $e->getMessage());
            }

            try {
                // Log commission data
                DB::table('getcommission')->insert([
                    'retailermobile' => $mobile,
                    'service' => 'Mobile Recharge',
                    'sub_services' => 'Prepaid',
                    'opening_bal' => $closingBalance,
                    'commission' => ($commissionValue - $tds),
                    'tds' => $tds,
                    'externalRef' => $externalRef,
                    'amount' => $payableValue,
                    'closing_bal' => $closingBalance + $commissionValue,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } catch (\Exception $e) {
                dd('Error logging commission data: ' . $e->getMessage());
            }

            // Store the last transaction amount in the session
            session(['totalPayableValue' => $payableValue]);
        } else {
            session(['totalPayableValue' => 0]);
        }
          //DMT Balance Update
     $balance = DB::table('customer')
     ->where('phone', $mobile)
     ->value('balance');
     // Store the retrieved balance in the session
     session(['balance'=> $balance]);

     $apiBalance = ApiHelper::decreaseBalance(env('Business_Email'), $payAmount, 'MobileRecharge');
     
    //dd($payableValue, $commissionValue,($commissionValue-$tds), $role, $mobile, $newPayableValue);
        dd($apiBalance);
    } catch (\Exception $e) {
        dd('General error updating customer balance: ' . $e->getMessage());
        session(['totalPayableValue' => 0]);
    }
}
}
