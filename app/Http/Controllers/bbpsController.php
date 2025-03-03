<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class bbpsController extends Controller
{
    public function getRechargePlanForm()
    {
        return view('user.bbps.recharge-plan');
    }

    public function getTelecomCircle()
    {
        // Make the API call

        $customerOutletId = intval(session('outlet'));
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'X-Ipay-Auth-Code' => env('IPAY_AUTH_CODE'),
            'X-Ipay-Client-Id' => env('IPAY_CLIENT_ID'),
            'X-Ipay-Client-Secret' => env('IPAY_CLIENT_SECRET'),
            'X-Ipay-Endpoint-Ip' => env('IPAY_ENDPOINT_IP'),
            'X-Ipay-Outlet-Id' => $customerOutletId,
        ])->post('http://api.instantpay.in/marketplace/utilityPayments/telecomCircles', []);

        // return $response->json();
        // die();
        // Check if the request was successful
        if ($response->successful()) {
            $data = $response->json();
            return view('user.bbps.biller_Details', ['circles' => $data['data']]);
        } else {
            return view('user.bbps.biller_Details', ['circles' => [], 'error' => 'API request failed.']);
        }
    }

    public function getRechargePlan(Request $request)
    {
        $subProductCode = $request->input('subProductCode');
        $telecomCircle = $request->input('telecomCircle');
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        $externalRef = uniqid('ref_', true);
        $customerOutletId = intval(session('outlet'));

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'X-Ipay-Auth-Code' => env('IPAY_AUTH_CODE'),
            'X-Ipay-Client-Id' => env('IPAY_CLIENT_ID'),
            'X-Ipay-Client-Secret' => env('IPAY_CLIENT_SECRET'),
            'X-Ipay-Endpoint-Ip' => env('IPAY_ENDPOINT_IP'),
            'X-Ipay-Outlet-Id' => $customerOutletId,
        ])->post('https://api.instantpay.in/marketplace/utilityPayments/rechargePlans', [
            'subProductCode' => $subProductCode,
            'telecomCircle' => $telecomCircle,
            'externalRef' => $externalRef,
            'latitude' => $latitude,
            'longitude' => $longitude,
        ]);

        return response()->json($response->json());
    }

    // public function getRechargePlan(Request $request)
    // {
    //     // Retrieve form inputs
    //     $subProductCode = $request->input('subProductCode',);
    //     $telecomCircle = $request->input('telecomCircle',);
    //     $latitude = $request->input('latitude', ); // Default latitude
    //     $longitude = $request->input('longitude', ); // Default longitude

    //     // Auto-generate externalRef
    //     $externalRef = uniqid('ref_', true); // Example: ref_63e91a98a3b7b

    //     // Get the outlet ID from the session
    //     $customerOutletId = intval(session('outlet'));

    //     // Make the API call
    //     $response = Http::withHeaders([
    //         'Accept' => 'application/json',
    //         'Content-Type' => 'application/json',
    //         'X-Ipay-Auth-Code' => env('IPAY_AUTH_CODE'),
    //         'X-Ipay-Client-Id' => env('IPAY_CLIENT_ID'),
    //         'X-Ipay-Client-Secret' => env('IPAY_CLIENT_SECRET'),
    //         'X-Ipay-Endpoint-Ip' => env('IPAY_ENDPOINT_IP'),
    //         'X-Ipay-Outlet-Id' => $customerOutletId,
    //     ])->post('https://api.instantpay.in/marketplace/utilityPayments/rechargePlans', [
    //         'subProductCode' => $subProductCode,
    //         'telecomCircle' => $telecomCircle,
    //         'externalRef' => $externalRef,
    //         'latitude' => $latitude,
    //         'longitude' => $longitude,
    //     ]);

    //     // Return the API response
    //     // return $response->json();
    //     // die();
    //      // Check if the API returned a successful response
    // if ($response->ok()) {
    //     $data = $response->json();
    //     return view('user.bbps.rechargePlan_result', ['plans' => $data['data']['plans'] ?? []]);
    // }

    // return back()->with('error', 'Failed to fetch recharge plans.');
    // }

    public function getCategory()
    {
        // Make the API call
        $customerOutletId = intval(session('outlet'));
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'X-Ipay-Auth-Code' => env('IPAY_AUTH_CODE'),
            'X-Ipay-Client-Id' => env('IPAY_CLIENT_ID'),
            'X-Ipay-Client-Secret' => env('IPAY_CLIENT_SECRET'),
            'X-Ipay-Endpoint-Ip' => env('IPAY_ENDPOINT_IP'),
            'X-Ipay-Outlet-Id' => $customerOutletId,
        ])->get('https://api.instantpay.in/marketplace/utilityPayments/category', []);

        if ($response->ok()) {
            $categories = $response->json()['data'] ?? [];
            // return $response->json();
            // die();
            // Define the desired order of categories
            $preferredOrder = [
                'Mobile (Prepaid)',
                'Mobile (Postpaid)',
                'DTH',
                'Electricity',
                'Electricity (Prepaid)',
                'Landline',
                'Credit Card',
                'FASTag Recharge',
                'Broadband',
                'Gas (LPG Cylinder)',
                'Gas (PNG)',
                'NCMC Recharge',
                'Water',
                'Insurance'
            ];

            // Sort categories based on the preferred order
            $sortedCategories = collect($categories)->sortBy(function ($category) use ($preferredOrder) {
                $index = array_search($category['categoryName'], $preferredOrder);
                return $index === false ? PHP_INT_MAX : $index;
            })->values()->toArray();

            return view('user.bbps.category', ['categories' => $sortedCategories]);
        }

        return back()->with('error', 'Unable to fetch utility categories.');
    }

    public function getBillers($key)
    {
        // Ensure the outlet ID is an integer (fallback to 0 if not found)
        $customerOutletId = intval(session('outlet', 0));

        // Make the API call
        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'X-Ipay-Auth-Code' => env('IPAY_AUTH_CODE'),
            'X-Ipay-Client-Id' => env('IPAY_CLIENT_ID'),
            'X-Ipay-Client-Secret' => env('IPAY_CLIENT_SECRET'),
            'X-Ipay-Endpoint-Ip' => env('IPAY_ENDPOINT_IP'),
            'X-Ipay-Outlet-Id' => $customerOutletId,
        ])->post('https://api.instantpay.in/marketplace/utilityPayments/billers', [
            'pagination' => [
                'pageNumber' => 1,
                'recordsPerPage' => 100,
            ],
            'filters' => [
                'categoryKey' => $key,  // Correctly using the $key variable
                'updatedAfterDate' => ''
            ]
        ]);

        // Check if the response is successful
        if ($response->ok()) {
            // Extract the billers list
            $billers = $response->json()['data']['records'] ?? [];
            // return $billers;
            // die();
            // Pass data to the view
            return view('user.bbps.billers', ['billers' => $billers]);
        }

        // Handle failure and redirect with an error message
        return back()->with('error', 'Unable to fetch the billers list. Please try again.');
    }

    public function getBillerDetails(Request $request)
    {
        $billerId = $request->input(
            'billerId',
        );
        $customerOutletId = intval(session('outlet'));

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'X-Ipay-Auth-Code' => env('IPAY_AUTH_CODE'),
            'X-Ipay-Client-Id' => env('IPAY_CLIENT_ID'),
            'X-Ipay-Client-Secret' => env('IPAY_CLIENT_SECRET'),
            'X-Ipay-Endpoint-Ip' => env('IPAY_ENDPOINT_IP'),
            'X-Ipay-Outlet-Id' => $customerOutletId,
        ])->post('https://api.instantpay.in/marketplace/utilityPayments/billerDetails', [
            'billerId' => $billerId,
        ]);

        // return $response->json();
        // die();
        return view('user.bbps.biller_Details', ['response' => $response->json()]);
    }

    public function getAllData(Request $request)
    {
        // return $request;
        // die();
        $ipAddress = $request->ip();  // Client's IP address
        $macAddress = exec('getmac');
        $macAddress = strtok($macAddress, ' ');  // Extract MAC address
        // $externalRef = 'APBBPS-' . strtoupper(uniqid(date('YmdHis')));
        $externalRef = 'APBBPS' . date('Y') . '' . round(microtime(true) * 1000);
        // return $macAddress;
        // die();
        $billerId = $request->billerId;
        $initChannel = $request->initChannel;
        $paymentMode = $request->paymentMode;
        $param1 = $request->param1;
        $param2 = $request->param2;
        $terminalId = $request->terminalId;
        $geoCode = $request->geoCode;
        $selectedPlanAmount = $request->selectedPlanAmount;
        $remark = $request->remark;
        $supportValidation = $request->supportValidation;
        $fetchRequirement = $request->fetchRequirement;
        $telecomCircle = $request->telecomCircle1;
        $key=$request->key;
       
        if ($supportValidation == 'MANDATORY') {
            // echo "1";

            $customerOutletId = intval(session('outlet'));

            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'X-Ipay-Auth-Code' => env('IPAY_AUTH_CODE'),
                'X-Ipay-Client-Id' => env('IPAY_CLIENT_ID'),
                'X-Ipay-Client-Secret' => env('IPAY_CLIENT_SECRET'),
                'X-Ipay-Endpoint-Ip' => env('IPAY_ENDPOINT_IP'),
                'X-Ipay-Outlet-Id' => $customerOutletId,
            ])->post('https://api.instantpay.in/marketplace/utilityPayments/prePaymentEnquiry', [
                'billerId' => $billerId,
                'initChannel' => $initChannel,
                'externalRef' => $externalRef,
                'inputParameters' => [
                    'param1' => $param1,
                    'param2' => $param2
                ],
                'deviceInfo' => [
                    'mac' => $macAddress,
                    'ip' => $ipAddress
                ],
                'remarks' => [
                    'param1' => '9999999999'
                ],
                'transactionAmount' => $selectedPlanAmount
            ]);
            // return $response->json();
            // die();
            $responseData = $response->json();
            return view('user.bbps.billEnquiry_res', compact('responseData'));
        } elseif ($fetchRequirement == 'MANDATORY') {
            // echo "2";

            $customerOutletId = intval(session('outlet'));

            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'X-Ipay-Auth-Code' => env('IPAY_AUTH_CODE'),
                'X-Ipay-Client-Id' => env('IPAY_CLIENT_ID'),
                'X-Ipay-Client-Secret' => env('IPAY_CLIENT_SECRET'),
                'X-Ipay-Endpoint-Ip' => env('IPAY_ENDPOINT_IP'),
                'X-Ipay-Outlet-Id' => $customerOutletId,
            ])->post('https://api.instantpay.in/marketplace/utilityPayments/prePaymentEnquiry', [
                'billerId' => $billerId,
                'initChannel' => $initChannel,
                'externalRef' => $externalRef,
                'inputParameters' => [
                    'param1' => $param1,
                    'param2' => $param2
                ],
                'deviceInfo' => [
                    'mac' => $macAddress,
                    'ip' => $ipAddress
                ],
                'remarks' => [
                    'param1' => '9999999999'
                ],
                'transactionAmount' => $selectedPlanAmount
            ]);
            // return $response->json();
            // die();
            $responseData = $response->json();
            return view('user.bbps.validateBiller_res', compact('responseData', 'billerId', 'initChannel', 'macAddress', 'ipAddress'));
        } else {
            $mobile = session('mobile');
            $role = session('role');
            // dd($role,$mobile);
            // die();
            $amountTr = $selectedPlanAmount;
            $getAmount = session('balance');
            $opBal = $getAmount;
            $getAmount -= 50;

            if ($getAmount > $amountTr) {
                $customerOutletId = intval(session('outlet'));

                $response = Http::withHeaders([
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                    'X-Ipay-Auth-Code' => env('IPAY_AUTH_CODE'),
                    'X-Ipay-Client-Id' => env('IPAY_CLIENT_ID'),
                    'X-Ipay-Client-Secret' => env('IPAY_CLIENT_SECRET'),
                    'X-Ipay-Endpoint-Ip' => env('IPAY_ENDPOINT_IP'),
                    'X-Ipay-Outlet-Id' => $customerOutletId,
                ])->post('https://api.instantpay.in/marketplace/utilityPayments/payment', [
                    'billerId' => $billerId,
                    'externalRef' => $externalRef,
                    'telecomCircle' => $telecomCircle,
                    'inputParameters' => [
                        'param1' => $param1
                    ],
                    'initChannel' => $initChannel,
                    'deviceInfo' => [
                        'terminalId' => $terminalId,
                        'mobile' => $terminalId,
                        'postalCode' => '110044',
                        'geoCode' => $geoCode,
                    ],
                    'paymentMode' => 'Cash',
                    'paymentInfo' => [
                        'Remarks' => $remark,
                    ],
                    'remarks' => [
                        'param1' => '9999999999'
                    ],
                    'transactionAmount' => $selectedPlanAmount,
                ]);
                $responseData = $response->json();
                DB::table('utility_payments')->insert([
                    'mobile' => session('mobile'),
                    'biller_id' => $billerId,
                    'external_ref' => $externalRef,
                    'telecom_circle' => $telecomCircle ?? '',
                    'payment_mode' => $paymentMode,
                    'payment_remarks' => $remark,
                    'transaction_amount' => $selectedPlanAmount,
                    'response_body' => json_encode($responseData),
                    'opening_balance' => $opBal,
                    'closing_balance' => $opBal,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $this->updateCustomerBalance($mobile, $role, $externalRef,$key);

                // return $response->json();
                $responseData = $response->json();
                return view('user.bbps.payment_res', compact('responseData'));
            } else {
                session()->flash('error', 'Your balance is not sufficient.');

                // Redirect back with the error message
                return redirect()->back();
            }

            //    echo "3";
            //     $customerOutletId = intval(session('outlet'));

            //     $response = Http::withHeaders([
            //         'Accept' => 'application/json',
            //         'Content-Type' => 'application/json',
            //         'X-Ipay-Auth-Code' => env('IPAY_AUTH_CODE'),
            //         'X-Ipay-Client-Id' => env('IPAY_CLIENT_ID'),
            //         'X-Ipay-Client-Secret' => env('IPAY_CLIENT_SECRET'),
            //         'X-Ipay-Endpoint-Ip' => env('IPAY_ENDPOINT_IP'),
            //         'X-Ipay-Outlet-Id' => $customerOutletId,
            //     ])->post('https://api.instantpay.in/marketplace/utilityPayments/payment', [
            //         "billerId" => $billerId,

            //         "externalRef" => $externalRef,
            //         "telecomCircle"=>$telecomCircle,
            //         "inputParameters" => [
            //             "param1" => $param1
            //         ],
            //         "initChannel" => $initChannel,
            //         "deviceInfo" => [
            //             "terminalId" =>$terminalId,
            //             "mobile" =>$terminalId,
            //             "postalCode" => "110044",
            //             "geoCode"=>$geoCode,

            //         ],
            //         'paymentMode' => 'Cash',
            //         'paymentInfo' => [
            //             'Remarks' => $remark,
            //         ],
            //         "remarks" => [
            //             "param1" => "9999999999"
            //         ],
            //         "transactionAmount" => $selectedPlanAmount,
            //     ]);
            //     $responseData = $response->json();
            //     DB::table('utility_payments')->insert([

            //         'mobile' => session('mobile'),
            //         'biller_id'=>$billerId,
            //         'external_ref' => $externalRef,
            //         'telecom_circle'=>$telecomCircle ?? "",
            //         'payment_mode'=>$paymentMode,
            //         'payment_remarks'=>$remark,
            //         'transaction_amount'=>$selectedPlanAmount,
            //         'response_body' => json_encode($responseData),
            //         'created_at' => now(),
            //         'updated_at' => now(),
            //     ]);

            //     if(!$responseData['statuscode']=="ERR")
            //     {
            //         $this->updateCustomerBalance(session('mobile'),session('role'));

            //     }
            //    // return $response->json();
            //    $responseData = $response->json();
            // return view('user.bbps.payment_res', compact('responseData'));

            // $customerOutletId = intval(session('outlet'));

            // // Prepare the request headers and body
            // $headers = [
            //     'Accept' => 'application/json',
            //     'Content-Type' => 'application/json',
            //     'X-Ipay-Auth-Code' => env('IPAY_AUTH_CODE'),
            //     'X-Ipay-Client-Id' => env('IPAY_CLIENT_ID'),
            //     'X-Ipay-Client-Secret' => env('IPAY_CLIENT_SECRET'),
            //     'X-Ipay-Endpoint-Ip' => env('IPAY_ENDPOINT_IP'),
            //     'X-Ipay-Outlet-Id' => $customerOutletId,
            // ];

            // $body = [
            //     "billerId" => $billerId,
            //     "externalRef" => $externalRef,
            //     "telecomCircle" => $telecomCircle,
            //     "inputParameters" => [
            //         "param1" => $param1
            //     ],
            //     "initChannel" => $initChannel,
            //     "deviceInfo" => [
            //         "terminalId" => $terminalId,
            //         "mobile" => $terminalId,
            //         "postalCode" => "110044",
            //         "geoCode" => $geoCode,
            //     ],
            //     'paymentMode' => 'Cash',
            //     'paymentInfo' => [
            //         'Remarks' => $remark,
            //     ],
            //     "remarks" => [
            //         "param1" => "9999999999"
            //     ],
            //     "transactionAmount" => $selectedPlanAmount,
            // ];

            // // Send the request
            // $response = Http::withHeaders($headers)->post(
            //     'https://api.instantpay.in/marketplace/utilityPayments/payment',
            //     $body
            // );

            // // Collect logs
            // $logs = [
            //     'headers' => $headers,
            //     'body' => $body,
            //     'response' => $response->json(),
            //     'status_code' => $response->status(),
            // ];

            // // Return all logs
            // return $logs;
        }
    }

    public function paybill(Request $request)
    {
        $mobile = session('mobile');
        $role = session('role');
        // dd($role,$mobile);
        // die();

        // Generate a unique reference for the transaction
        // $externalRef = 'APBBPS-' . strtoupper(uniqid(date('YmdHis')));
        $externalRef = 'APBBPS' . date('Y') . '' . round(microtime(true) * 1000);
        // Validate request inputs

        // Retrieve necessary form data
        $billerId = $request->input('billerId');
        $initChannel = $request->input('initChannel');
        $billAmount = $request->input('billAmount');
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');

        // Extract specific values from arrays
        $customerParams = $request->input('customerParams');
        $customerMobile = $customerParams[0]['Value'] ?? null;
        $additionalDetails = $request->input('additionalDetails');
        $transactionAmount = $additionalDetails[0]['Value'] ?? null;

        // return $transactionAmount;
        // die();
        // Check session balance
        $currentBalance = session('balance', 0);
        $remainingBalance = $currentBalance - 50;

        if ($remainingBalance > $transactionAmount) {
            // Retrieve outlet ID from session
            $customerOutletId = intval(session('outlet'));

            // Prepare API headers
            $headers = [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
                'X-Ipay-Auth-Code' => env('IPAY_AUTH_CODE'),
                'X-Ipay-Client-Id' => env('IPAY_CLIENT_ID'),
                'X-Ipay-Client-Secret' => env('IPAY_CLIENT_SECRET'),
                'X-Ipay-Endpoint-Ip' => env('IPAY_ENDPOINT_IP'),
                'X-Ipay-Outlet-Id' => $customerOutletId,
            ];

            // Prepare API payload
            $payload = [
                'billerId' => $billerId,
                'externalRef' => $externalRef,
                'telecomCircle' => '',
                'inputParameters' => [
                    'param1' => $customerMobile,
                ],
                'initChannel' => $initChannel,
                'deviceInfo' => [
                    'terminalId' => $customerMobile,
                    'mobile' => $customerMobile,
                    'postalCode' => '110044',
                    'geoCode' => $longitude,
                ],
                'paymentMode' => 'Cash',
                'paymentInfo' => [
                    'Remarks' => 'Bill Payment',
                ],
                'remarks' => [
                    'param1' => $customerMobile,
                ],
                'transactionAmount' => $transactionAmount,
            ];

            // Make API request
            $response = Http::withHeaders($headers)->post(
                'https://api.instantpay.in/marketplace/utilityPayments/payment',
                $payload
            );

            $responseData = $response->json();
            // return $responseData;
            // die();
            // Log response and save to the database
            DB::table('utility_payments')->insert([
                'mobile' => session('mobile'),
                'biller_id' => $billerId,
                'external_ref' => $externalRef,
                'telecom_circle' => '',
                'payment_mode' => 'Cash',
                'payment_remarks' => 'Bill Payment',
                'transaction_amount' => $transactionAmount,
                'response_body' => json_encode($responseData),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Update customer balance if the transaction is successful

            // $this->updateCustomerBalance(session('mobile'), session('role'),$externalRef);
            $this->updateCustomerBalance($mobile, $role, $externalRef);

            // Return the response view
            return view('user.bbps.payment_res', compact('responseData'));
        } else {
            // Insufficient balance
            // session()->flash('error', 'Your balance is not sufficient.');
            // return redirect()->back();

            return view('user.bbps.error_res');
        }
    }

    public function bbpstest()
    {
        $mobile = session('mobile');
        $role = session('role');
        $mode = 'IMPS';
        // $externalRef = 'ZPAY-' . strtoupper(uniqid(date('YmdHis')));
        $externalRef = 'APBBPS' . date('Y') . '' . round(microtime(true) * 1000);
        // dd($externalRef);
        $this->updateCustomerBalance($mobile, $role, $externalRef);
    }

    private function updateCustomerBalance($mobile, $role, $externalRef){
        $closingBalance = 0;
        $getDisComm = 0;
        $commissionAmount = 0;
        $tds = 0;
        $commissionValue = 0;
        $newPayableValue = 0;
        try {
            // Fetch the latest transaction for the given mobile number
            try {
                $lastRecord = DB::table('utility_payments')
                    ->where('mobile', $mobile)
                    ->latest('created_at')
                    ->first();

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
            } catch (\Exception $e) {
                dd('Error decoding response data: ' . $e->getMessage());
                session(['totalPayableValue' => 0]);
                return;
            }

            // Validate and process transaction data
            if (isset($responseData['data']['txnValue'], $responseData['statuscode']) &&
                    in_array($responseData['statuscode'], ['TXN', 'TUP'])) {
                $payableValue = $responseData['data']['txnValue'];

                // Fetch commission details based on role and service
                try {
                    $commissions = DB::table('commission_plan')
                        ->where('packages', $role)
                        ->where('service', 'BBPS')
                        ->get();
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
                } catch (\Exception $e) {
                    dd('Error calculating balances: ' . $e->getMessage());
                    session(['totalPayableValue' => 0]);
                    return;
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
                    if ($getDis) {
                        $disPhone = $getDis->dis_phone;
                        $sql = DB::select('SELECT COUNT(dis_phone) as disCount FROM abhipay.customer WHERE dis_phone = ?', [$disPhone]);
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
                            FROM abhipay.map_commission_plan 
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
                    // dd($disCommValue,$payableValue, $getDisComm, $newPayableValue);
                    // die();

                    // Update distributor balance
                    DB::table('customer')->where('phone', $disPhone)->increment('balance', $getDisComm);

                    // Log distributor commission
                    $disData = DB::table('customer')->where('phone', $disPhone)->first();
                    if ($disData) {
                        DB::table('dis_commission')->insert([
                            'dis_no' => $disPhone,
                            'services' => 'BBPS',
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

                try {
                    // Update customer balance
                    DB::table('customer')->where('phone', $mobile)->increment('balance', $newPayableValue);
                } catch (\Exception $e) {
                    dd('Error updating customer balance: ' . $e->getMessage());
                }

                try {
                    // Log commission data
                    DB::table('getcommission')->insert([
                        'retailermobile' => $mobile,
                        'service' => 'BBPS',
                        'sub_services' => 'BBPS',
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
            dd($payableValue, $commissionValue, $role, $mobile, $newPayableValue);
            // dd('OK');
        } catch (\Exception $e) {
            dd('General error updating customer balance: ' . $e->getMessage());
            session(['totalPayableValue' => 0]);
        }
    }
}
