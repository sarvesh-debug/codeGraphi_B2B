<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class infoController extends Controller
{
    // AEPS
    // public function getUsernameByMobile($mobile) {
    //     return DB::table('customer')
    //              ->select('name', 'username')
    //              ->where('phone', $mobile)
    //              ->first();
    // }
    
    public function aepsReport(Request $request)
    {
        $today = now()->format('Y-m-d');
        $currentMonth = now()->format('Y-m');
    
        $todayTransactions = DB::table('cash_withdrawals')
            ->whereDate('created_at', $today)
            ->get();
    
        $monthlyTransactions = DB::table('cash_withdrawals')
            ->where('created_at', 'like', "$currentMonth%")
            ->get();
    
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
    
        $allDataQuery = DB::table('cash_withdrawals');
        if ($startDate && $endDate) {
            $allDataQuery->whereBetween('created_at', [$startDate, $endDate]);
        }
    
        $allData = $allDataQuery->orderBy('created_at', 'desc')->get();
    
        $todaySuccessCount = 0;
        $todayFailedCount = 0;
        $todayTotal = 0;
    
        foreach ($todayTransactions as $transaction) {
            $response_data = json_decode($transaction->response_data, true);
            if (isset($response_data['statuscode']) && $response_data['statuscode'] === "TXN") {
                $todaySuccessCount++;
                $todayTotal += $response_data['data']['payableValue'] ?? 0;
            } else {
                $todayFailedCount++;
            }
        }
    
        $monthlySuccessCount = 0;
        $monthlyFailedCount = 0;
        $monthlyTotal = 0;
    
        foreach ($monthlyTransactions as $transaction) {
            $response_data = json_decode($transaction->response_data, true);
            if (isset($response_data['statuscode']) && $response_data['statuscode'] === "TXN") {
                $monthlySuccessCount++;
                $monthlyTotal += $response_data['data']['payableValue'] ?? 0;
            } else {
                $monthlyFailedCount++;
            }
        }
    
        // Attach name & username to each transaction in $allData
        foreach ($allData as $item) {
            $mobile = $item->mobile ?? null; // Adjust based on your column name (could be 'user_id' or 'phone')
            $user = $this->getUsernameByMobile($mobile);
            $item->username = $user->username ?? 'N/A';
            $item->name = $user->name ?? 'N/A';
        }
    
        // return $allData;
        // die();
        return view('admin.reports.aeps', [
            'todayTotal' => $todayTotal,
            'todaySuccessCount' => $todaySuccessCount,
            'todayFailedCount' => $todayFailedCount,
            'monthlyTotal' => $monthlyTotal,
            'monthlySuccessCount' => $monthlySuccessCount,
            'monthlyFailedCount' => $monthlyFailedCount,
            'allData' => $allData,
        ]);
    }
    
    
// return response()->json([
    //     // 'today_transactions' => $todayTransactions,
    //     'today_total' => $todayTotal,
    //     'today_success_count' => $todaySuccessCount,
    //     'today_failed_count' => $todayFailedCount,
    //     // 'monthly_transactions' => $monthlyTransactions,
    //     'monthly_total' => $monthlyTotal,
    //     'monthly_success_count' => $monthlySuccessCount,
    //     'monthly_failed_count' => $monthlyFailedCount,
    //     'allData'=>$allData,
    // ]);

    //DMT 1
    public function dmt1Report(Request $request)
    {
        $today = now()->format('Y-m-d');
        $currentMonth = now()->format('Y-m');
    
        $todayTransactions = DB::table('transactions_dmt_instant_pay')
            ->whereDate('created_at', $today)
            ->get();
    
        $monthlyTransactions = DB::table('transactions_dmt_instant_pay')
            ->where('created_at', 'like', "$currentMonth%")
            ->get();
    
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
    
        $allDataQuery = DB::table('transactions_dmt_instant_pay');
    
        if ($startDate && $endDate) {
            $allDataQuery->whereBetween('created_at', [$startDate, $endDate]);
        }
    
        $allData = $allDataQuery->orderBy('created_at', 'desc')->get();
    
        $todaySuccessCount = 0;
        $todayFailedCount = 0;
        $todayTotal = 0;
    
        foreach ($todayTransactions as $transaction) {
            $response_data = json_decode($transaction->response_data, true);
            if (isset($response_data['statuscode']) && $response_data['statuscode'] === "TXN") {
                $todaySuccessCount++;
                $todayTotal += $response_data['data']['txnValue'] ?? 0;
            } else {
                $todayFailedCount++;
            }
        }
    
        $monthlySuccessCount = 0;
        $monthlyFailedCount = 0;
        $monthlyTotal = 0;
    
        foreach ($monthlyTransactions as $transaction) {
            $response_data = json_decode($transaction->response_data, true);
            if (isset($response_data['statuscode']) && $response_data['statuscode'] === "TXN") {
                $monthlySuccessCount++;
                $monthlyTotal += $response_data['data']['txnValue'] ?? 0;
            } else {
                $monthlyFailedCount++;
            }
        }
    
        // Attach customer name and username to each transaction
        foreach ($allData as $item) {
            $mobile = $item->remitter_mobile_number ?? $item->second_no ?? null; // Adjust if column name is different
            $user = $this->getUsernameByMobile($mobile);
            $item->username = $user->username ?? 'N/A';
            $item->name = $user->name ?? 'N/A';
        }
    
       // return $allData;die();
        return view('admin.reports.dmt1', [
            'todayTotal' => $todayTotal,
            'todaySuccessCount' => $todaySuccessCount,
            'todayFailedCount' => $todayFailedCount,
            'monthlyTotal' => $monthlyTotal,
            'monthlySuccessCount' => $monthlySuccessCount,
            'monthlyFailedCount' => $monthlyFailedCount,
            'allData' => $allData,
        ]);
    }
    
    // DMT 2
    public function bbpsReport(Request $request)
    {
        $today = now()->format('Y-m-d');
        $currentMonth = now()->format('Y-m');
    
        $todayTransactions = DB::table('utility_payments')
            ->whereDate('created_at', $today)
            ->get();
    
        $monthlyTransactions = DB::table('utility_payments')
            ->where('created_at', 'like', "$currentMonth%")
            ->get();
    
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
    
        $allDataQuery = DB::table('utility_payments');
    
        if ($startDate && $endDate) {
            $allDataQuery->whereBetween('created_at', [$startDate, $endDate]);
        }
    
        $allData = $allDataQuery->orderBy('created_at', 'desc')->get();
    
        $todaySuccessCount = 0;
        $todayFailedCount = 0;
        $todayTotal = 0;
    
        foreach ($todayTransactions as $transaction) {
            $response_data = json_decode($transaction->response_body, true);
            if (isset($response_data['statuscode']) && $response_data['statuscode'] === "TXN") {
                $todaySuccessCount++;
                $todayTotal += $response_data['data']['txnValue'] ?? 0;
            } else {
                $todayFailedCount++;
            }
        }
    
        $monthlySuccessCount = 0;
        $monthlyFailedCount = 0;
        $monthlyTotal = 0;
    
        foreach ($monthlyTransactions as $transaction) {
            $response_data = json_decode($transaction->response_body, true);
            if (isset($response_data['statuscode']) && $response_data['statuscode'] === "TXN") {
                $monthlySuccessCount++;
                $monthlyTotal += $response_data['data']['txnValue'] ?? 0;
            } else {
                $monthlyFailedCount++;
            }
        }
    
        // Attach customer name and username to each transaction
        foreach ($allData as $item) {
            $mobile = $item->mobile ?? $item->second_no ?? null; // Adjust if column name is different
            $user = $this->getUsernameByMobile($mobile);
            $item->username = $user->username ?? 'N/A';
            $item->name = $user->name ?? 'N/A';
        }
    
       // return $allData;die();
        return view('admin.reports.bbps', [
            'todayTotal' => $todayTotal,
            'todaySuccessCount' => $todaySuccessCount,
            'todayFailedCount' => $todayFailedCount,
            'monthlyTotal' => $monthlyTotal,
            'monthlySuccessCount' => $monthlySuccessCount,
            'monthlyFailedCount' => $monthlyFailedCount,
            'allData' => $allData,
        ]);
    }

//payout
public function payoutReport(Request $request)
{
    $today = now()->format('Y-m-d');
    $currentMonth = now()->format('Y-m');

    $todayTransactions = DB::table('cgpayout')
        ->whereDate('created_at', $today)
        ->get();

    $monthlyTransactions = DB::table('cgpayout')
        ->where('created_at', 'like', "$currentMonth%")
        ->get();

    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');

    $allDataQuery = DB::table('cgpayout');

    if ($startDate && $endDate) {
        $allDataQuery->whereBetween('created_at', [$startDate, $endDate]);
    }

    $allData = $allDataQuery->orderBy('created_at', 'desc')->get();

    $todaySuccessCount = 0;
    $todayFailedCount = 0;
    $todayTotal = 0;

    foreach ($todayTransactions as $transaction) {
        $response_data = json_decode($transaction->response, true);
        if (isset($response_data['statuscode']) && $response_data['statuscode'] === "TXN") {
            $todaySuccessCount++;
            $todayTotal += $response_data['data']['txnValue'] ?? 0;
        } else {
            $todayFailedCount++;
        }
    }

    $monthlySuccessCount = 0;
    $monthlyFailedCount = 0;
    $monthlyTotal = 0;

    foreach ($monthlyTransactions as $transaction) {
        $response_data = json_decode($transaction->response, true);
        if (isset($response_data['statuscode']) && $response_data['statuscode'] === "TXN") {
            $monthlySuccessCount++;
            $monthlyTotal += $response_data['data']['txnValue'] ?? 0;
        } else {
            $monthlyFailedCount++;
        }
    }

    // Attach customer name and username to each transaction
    foreach ($allData as $item) {
        $mobile = $item->phone ?? $item->second_no ?? null; // Adjust if column name is different
        $user = $this->getUsernameByMobile($mobile);
        $item->username = $user->username ?? 'N/A';
        $item->name = $user->name ?? 'N/A';
    }

   // return $allData;die();
    return view('admin.reports.payout', [
        'todayTotal' => $todayTotal,
        'todaySuccessCount' => $todaySuccessCount,
        'todayFailedCount' => $todayFailedCount,
        'monthlyTotal' => $monthlyTotal,
        'monthlySuccessCount' => $monthlySuccessCount,
        'monthlyFailedCount' => $monthlyFailedCount,
        'allData' => $allData,
    ]);
}



    public function index()
{
    $mobile = session('mobile'); // Retrieve mobile from session
    $userId = session('username'); // Retrieve mobile from session

    // Initialize variables to store totals
    $totalAmount = 0;
    $individualTotals = [
        'AEPS' => 0,
        'DMT' => 0,
        'DMT2' => 0,
        'BBPS' => 0,
        'Commission' =>0,
        'Fund' =>0,
         'FundRequest' =>0,
         'Payment1' =>0,
    ];
    $allTransactions = []; // To store all transaction data

    // Fund History
    $getFunds = DB::table('wallet_transfers')
    ->where('receiver_id', $userId)
    ->orWhere('sender_id', $userId)
    ->get();


foreach ($getFunds as $getFund) {
    $txnAmount = $getFund->amount ?? 0; // Default to 0 if null
    $individualTotals['Fund'] = ($individualTotals['Fund'] ?? 0) + $txnAmount;
    $totalAmount = ($totalAmount ?? 0) + $txnAmount;
    $comm = ($commission->commission ?? 0) + ($commission->tds ?? 0); // Safe addition
    
    $creditAmount = ($getFund->type == 'Credit') ? ($getFund->amount ?? 0) : '';
    $debitAmount = ($getFund->type == 'Debit') ? ($getFund->amount ?? 0) : '';

    $creditDes = ($getFund->type == 'Debit') ? 'Transfer Fund to '.($getFund->receiver_id ?? 0) : '';
    $debitDes = ($getFund->type == 'Credit') ? 'Received Fund from '.($getFund->sender_id ?? 0) : '';
    
    
    $allTransactions[] = [
        'source' => 'Fund Transfer',
        'credit' => $creditAmount ?? 0,
        'debit' => $debitAmount ?? 0,
        'commission' => $commission->commissions ?? 0,
        'tds' => 0,
        'charges' => $commission->charges ?? 0,
        'status' => 'Success',
        'timestamp' => $getFund->created_at ?? "N/A",
        'type' => $getFund->type ?? '',
        'desc' => ($creditDes?? '') . ' ' . ($debitDes ?? ''),
        'trans_id' => ''  ?? 0,
        'rrn' => '' ?? 0,
        'ext_ref' => $getFund->transfer_id ?? 0,
        'openingB' => $getFund->opening_balance ?? 0,
        'clsoingB' => $getFund->closing_balance ?? 0, // Fixed spelling
    ];
    
}

//Fund Rise
   // Fund History
    $getFunds = DB::table('add_moneys')
    ->where('id_code', $userId)
    ->orWhere('id_code', $userId)
    ->get();


foreach ($getFunds as $getFund) {
    $txnAmount = $getFund->amount ?? 0; // Default to 0 if null
    $individualTotals['FundRequest'] = ($individualTotals['FundRequest'] ?? 0) + $txnAmount;
    $totalAmount = ($totalAmount ?? 0) + $txnAmount;
    $comm = ($commission->commission ?? 0) + ($commission->tds ?? 0); // Safe addition
    
   
    
    
    $allTransactions[] = [
        'source' => 'Fund Transfer',
        'credit' => $txnAmount ?? 0,
        'debit' => 0,
        'commission' => $commission->commissions ?? 0,
        'tds' =>$getFund->tds ?? 0 ,
        'charges' => $getFund->charges ?? 0,
     'status' => ($getFund->status == 1) ? 'SUCCESS' : 'PROCESSING',

        'timestamp' => $getFund->created_at ?? "N/A",
        'type' => $getFund->type ?? '',
        'desc' => ($creditDes?? '') . ' ' . ($debitDes ?? ''),
        'trans_id' => ''  ?? 0,
        'rrn' => $getFund->utr ?? 0,
        'ext_ref' => $getFund->transfer_id ?? 0,
        'openingB' => $getFund->openingBalance ?? 0,
        'clsoingB' => $getFund->closingBalance ?? 0, // Fixed spelling
    ];
    
}
//payout
$transactionsDMT1 = DB::table('cgpayout') ->where('phone', $mobile)
->get();

foreach ($transactionsDMT1 as $transaction) {
    $responseData = json_decode($transaction->response, true);

    $txnAmount = (float)($transaction->amount ?? 0);
    $individualTotals['Payout'] = ($individualTotals['Payout'] ?? 0) + $txnAmount;
    $totalAmount = ($totalAmount ?? 0) + $txnAmount;

   $statusRaw = strtoupper(trim($responseData['status'] ?? ''));
      $status = isset($responseData['statuscode']) && $responseData['statuscode'] == 'TXN' ? 'Success' : 'Failed';
 //$ststus=0;
    switch ($statusRaw) {
        case 'TRANSACTION SUCCESSFUL':
            $status = 'SUCCESS';
            break;
        case 'FAILED':
            $status = 'FAILED';
            break;
        case 'PENDING':
            $status = 'PENDING';
            break;
        default:
            $status = 'FAILED';
            break;
    }
    

    $allTransactions[] = [
        'source'     => 'Payout',
        'credit'     => 0,
        'debit'      => $txnAmount ?? 0,
        'mobile'     => $transaction->phone ?? 'N/A',
        'status'     => $status,
        'timestamp'  => $transaction->created_at ?? 'N/A',
        'type'       => 'Deposit',
'desc' => 'Transaction to ' . ($transaction->retailerId ?? 'N/A') . 
          ' and Charges Apply ' . ($transaction->charges ?? 0) . 
          ' And TDS ' . ($transaction->tds ?? 0),
'tds' => $transaction->tds ?? 0,
'commission' => $transaction->commission ?? 0,
'charges' => $transaction->charges ?? 0,
        'trans_id'   => $responseData['rrn'] ?? 0,
        'rrn'        => $responseData['payment_id'] ?? 0,
        'ext_ref'    => $responseData['crn'] ?? 0,
        'openingB'   => $transaction->openingBal ?? 0,
        'clsoingB'   => $transaction->closingBal ?? 0,
    ];
}

//Fatch data from 'commission'

// $getCommission = DB::table('getcommission')
//     ->where('retailermobile', $mobile)
//     ->get();

// foreach ($getCommission as $commission) {
//     $txnAmount = $commission->commission ?? 0; // Default to 0 if null
//     $individualTotals['Commission'] = ($individualTotals['Commission'] ?? 0) + $txnAmount;
//     $totalAmount = ($totalAmount ?? 0) + $txnAmount;
//     $comm = ($commission->commission ?? 0); // Safe addition
    
//     $allTransactions[] = [
//         'source' => 'Commission',
//         'credit' => $commission->commission ?? 0,
//         'debit' => 0,
//         'commission' => $commission->commissions ?? 0,
//         'tds' => $commission->tds ?? 0,
//         'charges' => $commission->charges ?? 0,
//         'status' => isset($commission->commission) ? 'Success' : 'Failed',
//         'timestamp' => $commission->created_at ?? "N/A",
//         'type' => '',
//         'desc' => ($commission->service ?? 'Unknown Service') . ' Commission ' . $comm . ', Debit TDS ' . ($commission->tds ?? 0),
//         'trans_id' => '',
//         'rrn' => '',
//         'ext_ref' => $commission->externalRef ?? 0,
//         'openingB' => $commission->opening_bal ?? 0,
//         'clsoingB' => $commission->closing_bal ?? 0,
//     ];
// }

    // Fetch data from 'cash_withdrawals'
    $cashWithdrawals = DB::table('cash_withdrawals')
        ->where('mobile', $mobile)
        ->get();
    foreach ($cashWithdrawals as $withdrawal) {
        $responseData = json_decode($withdrawal->response_data, true);
        $payableValue=0;
        if(isset($responseData['statuscode']) && $responseData['statuscode'] == 'TXN')
        {
            $payableValue = (float)($responseData['data']['transactionValue'] ?? 0);
            $individualTotals['AEPS'] += $payableValue;
            $totalAmount += $payableValue;
        }
       
        $status = isset($responseData['statuscode']) && $responseData['statuscode'] == 'TXN' ? 'Success' : 'Failed';
        $allTransactions[] = [
            'source' => 'AEPS',
            'credit' => $payableValue ?? 0,
            'debit'=>0,
            'commission'=>$withdrawal->commissions ?? 0,
            'tds'=> $withdrawal->tds ?? 0,
            'charges' =>0,
            'status' => $status,
            'timestamp' => $responseData['timestamp'] ?? "N/A",
            'type' => 'Withdrawal',
            'desc' => 'AePS Withdrawal  '.($payableValue).' from ' . ($responseData['data']['accountNumber'] ?? 'N/A').' and Commission '.($withdrawal->commissions ?? 0),
            
            'trans_id'=>$responseData['data']['ipayId'] ?? 'N/A',
            'ext_ref'=>$withdrawal->external_ref,
            'openingB'=>$withdrawal->opening_balance ?? 0,
            'rrn'=>$responseData['data']['ipayId'] ?? 0,
            'clsoingB'=>$withdrawal->closing_balance ?? 0,
        ];
    }

    // Fetch data from 'utility_payments'
    $utilityPayments = DB::table('utility_payments')
        ->where('mobile', $mobile)
        ->get();
    foreach ($utilityPayments as $payment) {
        $responseData = json_decode($payment->response_body, true);
        $txnValue = (float)($responseData['respose']['data']['txnValue'] ?? 0);
        $individualTotals['BBPS'] += $txnValue;
        $totalAmount += $txnValue;
        $status = (
            isset($responseData['status']) &&
            in_array($responseData['status'], ["Transaction Successful", "Transaction Under Process"])
        ) ? 'Success' : 'Failed';
        
        $allTransactions[] = [
            'source' => 'BBPS',
            'credit' => 0,
            'debit'=>($txnValue) ?? 0,
            'commission'=>$payment->commissions ?? 0,
            'tds'=> $payment->tds,
            'charges' =>$payment->charges ?? 0,
            'status' => $status,
            'timestamp' => $responseData['timestamp'] ?? "N/A",
            'type'=>'Deposit',
            'desc'=>'Utility Payments for'.($responseData['billerDetails']['name'] ?? 0),
            'trans_id'=>$responseData['data']['poolReferenceId'] ?? 0,
            // 'rrn'=>$responseData['data']['poolReferenceId'] ?? 0,
            'ext_ref'=>$responseData['data']['externalRef'] ?? 0,
            'openingB'=>$payment->opening_balance ?? 0,
            'rrn'=>$responseData['data']['ipayId'] ?? 0,
            'clsoingB'=>$payment->closing_balance ?? 0,


        ];
    }

    // Fetch data from 'transactions_d_m_t1'
    $transactionsDMT1 = DB::table('transactions_d_m_t1')
        ->where('mobile', $mobile)
        ->get();
    foreach ($transactionsDMT1 as $transaction) {
        $responseData = json_decode($transaction->response_data, true);
        $txnAmount = (float)($responseData['txn_amount'] ?? 0);
        $individualTotals['DMT2'] += $txnAmount;
        $totalAmount += $txnAmount;
        $status = isset($responseData['status']) && $responseData['status'] == 'true' ? 'Success' : 'Failed';

        $allTransactions[] = [
            'source' => 'DMT2',
            'credit'=>0,
            'debit' => $txnAmount ?? 0,
          'commission'=>$transaction->commissions ?? 0,
            'tds'=> $transaction->tds ?? 0,
            'charges' =>$transaction->charges ?? 0,
            'status' => $status,
            'timestamp' => $transaction->created_at ?? "N/A",
             'type'=>'Deposit',
             'desc'=>'Transaction to '.($responseData['benename'] ?? 'N/A'),
            'trans_id'=>$responseData['benename'] ?? 0,
            'rrn'=>$responseData['data']['txnReferenceId'] ?? 0,
            'ext_ref'=>$responseData['data']['externalRef'] ??0,
            'openingB'=>$transaction->opening_balance ?? 0,
            'clsoingB'=>$transaction->closing_balance ?? 0,

        ];
    }

    // // Fetch data from 'transactions_dmt_instant_pay'
    $transactionsDMTInstantPay = DB::table('transactions_dmt_instant_pay')
        ->where('remitter_mobile_number', $mobile)
        ->get();
    foreach ($transactionsDMTInstantPay as $transaction) {
        $responseData = json_decode($transaction->response_data, true);
        $amount = (float)($responseData['data']['txnValue'] ?? 0);
        $individualTotals['DMT'] += $amount;
        $totalAmount += $amount;
        $status = isset($responseData['statuscode']) && $responseData['statuscode'] == 'TXN' ? 'Success' : 'Failed';

        $allTransactions[] = [
            'source' => 'DMT',
            'credit'=>0,
            'debit' => ($amount) ?? 0,
            'commission'=>$transaction->commission?? 0,
            'tds'=> $transaction->tds ?? 0,
            'charges' =>$transaction->charges ?? 0,
            'status' => $status,
            'timestamp' => $responseData['timestamp'] ?? "N/A",
            'type'=>'Deposit',
            'desc'=>'Money Transfer to '.($responseData['data']['beneficiaryName']??'N/A').' ₹'.($amount ?? 0).' and Charges '.($transaction->charges ?? 0),
            'trans_id'=>$responseData['data']['txnReferenceId']?? 'Null',
            'rrn'=>$responseData['data']['txnReferenceId'] ?? 0,
            'ext_ref'=>$responseData['data']['externalRef'] ??0,
            'openingB'=>$transaction->opening_balance ?? 0,
            'clsoingB'=>$transaction->closing_balance ?? 0,


        ];
    }

    //PAyemet 1
     // // Fetch data from 'transactions_dmt_instant_pay'
    $transactionsDMT = DB::table('nifi_payouts')
        ->where('mobile', $mobile)
        ->get();
    foreach ($transactionsDMT as $transaction) {
        $responseData = json_decode($transaction->responseBody, true);
        $amount = (float)($responseData['deduction']['amount'] ?? 0);
        $individualTotals['Payment1'] += $amount;
        $totalAmount += $amount;
        $status = isset($responseData['statuscode']) && $responseData['statuscode'] == '10000' ? 'Success' : 'Failed';

        $allTransactions[] = [
            'source' => 'Payment1',
            'credit'=>0,
            'debit' => ($amount) ?? 0,
            'commission'=>$transaction->commission?? 0,
            'tds'=> $transaction->tds ?? 0,
            'charges' =>$transaction->charges ?? 0,
            'status' => $status,
           'timestamp' => isset($responseData['timestamp']) 
                ? \Carbon\Carbon::parse($responseData['timestamp'])->format('Y-m-d H:i:s') 
                : 'N/A',
            'type'=>'Deposit',
            'desc'=>'Money Transfer to '.($responseData['data']['recipient_name']??'N/A').' ₹'.($amount ?? 0).' and Charges '.($transaction->charges ?? 0),
            'trans_id'=>$responseData['data']['bank_ref_num']?? 'Null',
            'rrn'=>$responseData['data']['bank_ref_num'] ?? 0,
            'ext_ref'=>$responseData['data']['externalRef'] ??0,
            'openingB'=>$transaction->openingBal ?? 0,
            'clsoingB'=>$transaction->closingBal ?? 0,


        ];
    }

//     //Fatch data from 'commission'
//     $getCommission = DB::table('getcommission')
//             ->where('retailermobile', $mobile)
//             ->get();
// foreach($getCommission as $commission)
// {

//     $txnAmount=$commission->commission;
//     $individualTotals['Commission'] += $txnAmount;
//             $totalAmount += $txnAmount;

//             $allTransactions[] = [
//                 'source' => 'Commission',
//                 'credit'=>$commission->commission ?? 0,
//                 'debit' => $commission->amount ?? 0,
//                 'commission'=>$commission->commissions ?? 0,
//                 'tds'=>$commission->tds ?? 0,
//                 'charges' =>$commission->charges ?? 0,
//               'status' => $commission->commission === null ? 'Failed' : 'Success',
//                 'timestamp' => $commission->created_at ?? "N/A",
//                 'type'=>'',
//                 'desc'=>'Get Commission on '.($commission->service),
//                 'trans_id'=>'',
//                 'rrn'=>'',
//                 'ext_ref'=> '',
//                 'openingB'=>$commission->opening_bal ?? 0,
//                 'clsoingB'=>$commission->closing_bal ?? 0,

//             ];

// }
        
    // Fetch data from 'pancard'
    // $pancards = DB::table('pancard')
    //         ->where('number', $mobile)
    //         ->get();
    //     foreach ($pancards as $pancard) {
    //         $responseData = json_decode($pancard->response_body, true);
    //         $txnAmount = $pancard->balance;
    //         $individualTotals['PAN'] += $txnAmount;
    //         $totalAmount += $txnAmount;

    //             $debitAmount = ($pancard->status == 'pending'||$pancard->status =='Success') ? ($pancard->balance ?? 0) : '';
    //          $creditAmount = ($pancard->status == 'Failled') ? ($pancard->balance ?? 0) : '';

    //          $creditDes = ($pancard->status == 'pending'||$pancard->status =='success') ? 'Apply for pan Card charges'.($pancard->balance ?? 0) : '';
    //          $debitDes = ($pancard->status == 'Failled') ? 'Refund due to pan card apply failled'.($pancard->balance ?? 0) : '';


    //          $allTransactions[] = [
    //                     'source' => 'pancard',
    //                     'credit'=>$creditAmount,
    //                     'debit' =>$debitAmount ,
    //                     'commission'=>$pancard->commissions ?? 0,
    //                     'tds'=>$pancard->tds ?? 0,
    //                     'charges' =>$pancard->charges ?? 0,
    //                     'status' => $pancard->status ?? "Success",
    //                     'timestamp' => $pancard->created_at ?? "N/A",
    //                     'type'=>'Deposit',
    //                     'desc'=>($creditDes?? '') . ' ' . ($debitDes ?? ''),
    //                     'trans_id'=>$pancard->order_id,
    //                     'rrn'=>$responseData['data']['txnReferenceId'] ?? 0,
    //                     'ext_ref'=>$pancard->order_id ??0,
    //                     'openingB'=>$pancard->opening_balance ?? 0,
    //                     'clsoingB'=>$pancard->closing_balance ?? 0,
    
    
    //                 ];

            // if (isset($responseData['status'])==='FAILED') 
            // {
            //     $allTransactions[] = [
            //         'source' => 'pancard',
            //         'credit'=>'',
            //         'debit' => '107',
            //         'commission'=>$pancard->commissions ?? 0,
            //         'tds'=>$pancard->tds ?? 0,
            //         'charges' =>$pancard->charges ?? 0,
            //         'status' => $responseData['status'] ?? "Success",
            //         'timestamp' => $pancard->created_at ?? "N/A",
            //         'type'=>'Deposit',
            //         'desc'=>'Apply For Pan Card',
            //         'trans_id'=>$pancard->order_id,
            //         'rrn'=>$responseData['data']['txnReferenceId'] ?? 0,
            //         'ext_ref'=>$pancard->order_id ??0,
            //         'openingB'=>$pancard->opening_balance ?? 0,
            //         'clsoingB'=>$pancard->closing_balance ?? 0,


            //     ];
            // }
            // else
            // {
            //     $allTransactions[] = [
            //         'source' => 'pancard',
            //         'credit'=>'',
            //         'debit' => '107',
            //         'commission'=>$pancard->commissions ?? 0,
            //         'tds'=>$pancard->tds ?? 0,
            //         'charges' =>$pancard->charges ?? 0,
            //         'status' => $responseData['status'] ?? "Unknown",
            //         'timestamp' => $pancard->created_at ?? "N/A",
            //         'type'=>'Deposit',
            //         'desc'=>'Apply For Pan Card',
            //         'trans_id'=>$pancard->order_id,
            //         'rrn'=>$responseData['data']['txnReferenceId'] ?? 0,
            //         'ext_ref'=>$pancard->order_id ??0,
            //         'openingB'=>$pancard->opening_balance ?? 0,
            //         'clsoingB'=>$pancard->closing_balance ?? 0,


            //     ];

            // }
       // }

    // Sort transactions by timestamp (date)
    usort($allTransactions, function ($a, $b) {
        return strtotime($b['timestamp']) - strtotime($a['timestamp']); // Descending order
    });    // Return the view with transaction data
    return view('user.laser-statement', [
        'mobile' => $mobile,
        'totalAmount' => $totalAmount,
        'individualTotals' => $individualTotals,
        'transactions' => $allTransactions,
    ]);
}
public function getUsernameByMobile($mobile) {
    return DB::table('customer')
    ->select('name', 'username','pan_no')
    ->where('phone', $mobile)
    ->first(); // returns a single object
}

public function indexAdmin()
{
    //$mobile = session('mobile'); // Retrieve mobile from session
    // Initialize variables to store totals
    $totalAmount = 0;
    $individualTotals = [
        'AEPS' => 0,
        'DMT1' => 0,
         'DMT2' => 0,
        'BBPS' => 0,
        // 'PAN' =>0,
        'Commission' =>0,
        'Fund' =>0,
        'Payout'=>0,
        'Payment1'=>0
    ];
    $allTransactions = []; // To store all transaction data

 // Fund History
 $getFunds = DB::table('wallet_transfers')
 ->get();


foreach ($getFunds as $getFund) {
 $txnAmount = $getFund->amount ?? 0; // Default to 0 if null
 $individualTotals['Fund'] = ($individualTotals['Fund'] ?? 0) + $txnAmount;
 $totalAmount = ($totalAmount ?? 0) + $txnAmount;
 $comm = ($commission->commission ?? 0) + ($commission->tds ?? 0); // Safe addition
 
 $creditAmount = ($getFund->type == 'Credit') ? ($getFund->amount ?? 0) : '';
 $debitAmount = ($getFund->type == 'Debit') ? ($getFund->amount ?? 0) : '';

 $creditDes = ($getFund->type == 'Debit') ? ($getFund->sender_id ?? 0).' Transfer Fund to '.($getFund->receiver_id ?? 0) : '';
 $debitDes = ($getFund->type == 'Credit') ? 'Received Fund from '.($getFund->sender_id ?? 0) : '';
 
 $mobile = $getFund->sender_id;
$usernameDetails = $this->getUsernameByMobile($mobile);

 
 $allTransactions[] = [
     'source' => 'Fund Transfer',
     'credit' => $creditAmount  ?? 0,
     'debit' => $debitAmount ?? 0,
     'commission' => $commission->commissions ?? 0,
     'tds' =>$commission->tds ?? 0,
     'charges' => $commission->charges ?? 0,
     'status' => 'Success',
     'timestamp' => $getFund->created_at ?? "N/A",
     'type' => $getFund->type ?? '',
     'mobile'=>$getFund->sender_id,
     'desc' => ($creditDes?? '') . ' ' . ($debitDes ?? ''),
     'trans_id' => '' ?? 0,
     'rrn' => '' ?? 0,
     'username' => $usernameDetails->username ?? 'N/A',
     'name' => $usernameDetails->name ?? 'N/A',
     'ext_ref' => $getFund->transfer_id ?? 0,
     'openingB' => $getFund->opening_balance ?? 0,
     'clsoingB' => $getFund->closing_balance ?? 0, // Fixed spelling
 ];
 
}
//Fetch data from 'transactions_d_m_t1'
$transactionsDMT1 = DB::table('cgpayout')->get();

foreach ($transactionsDMT1 as $transaction) {
    $responseData = json_decode($transaction->response, true);

    $txnAmount = (float)($transaction->amount ?? 0);
    $individualTotals['Payout'] = ($individualTotals['Payout'] ?? 0) + $txnAmount;
    $totalAmount = ($totalAmount ?? 0) + $txnAmount;

    $mobile = $transaction->phone;
    $usernameDetails = $this->getUsernameByMobile($mobile);
    $statusRaw = strtoupper(trim($responseData['status'] ?? ''));
      $status = isset($responseData['statuscode']) && $responseData['statuscode'] == 'TXN' ? 'Success' : 'Failed';
 //$ststus=0;
    switch ($statusRaw) {
        case 'TRANSACTION SUCCESSFUL':
            $status = 'SUCCESS';
            break;
        case 'FAILED':
            $status = 'FAILED';
            break;
        case 'PENDING':
            $status = 'PENDING';
            break;
        default:
            $status = 'FAILED';
            break;
    }
    

    $allTransactions[] = [
        'source'     => 'Payout',
        'credit'     => 0,
        'debit'      => $txnAmount ?? 0,
        'mobile'     => $transaction->phone ?? 'N/A',
        'status'     => $status ?? 0,
        'timestamp'  => $transaction->created_at ?? 'N/A',
        'type'       => 'Deposit',
        'desc' => 'Transaction to ' . ($transaction->retailerId ?? 'N/A') . 
          ' and Charges Apply ' . ($transaction->charges ?? 0) . 
          ' And TDS ' . ($transaction->tds ?? 0),
        'tds' => $transaction->tds ?? 0,
        'charges' => $transaction->charges ?? 0,
        'commission' => $transaction->commission ?? 0,
       'trans_id'   => $responseData['rrn'] ?? 0,
        'rrn'        => $responseData['payment_id'] ?? 0,
        'username' => $usernameDetails->username ?? 'N/A',
        'name' => $usernameDetails->name ?? 'N/A',
        'ext_ref'    => $responseData['crn'] ?? 0,
        'openingB'   => $transaction->openingBal ?? 0,
        'clsoingB'   => $transaction->closingBal ?? 0,
    ];
}


    //Fatch data from 'commission'
// $getCommission = DB::table('getcommission')
// ->get();
// foreach($getCommission as $commission)
// {

// $txnAmount=$commission->commission;
// $individualTotals['Commission'] += $txnAmount;
// $totalAmount += $txnAmount;
//     $comm = ($commission->commission ?? 0); // Safe addition

//     $mobile = $commission->retailermobile;
//     $usernameDetails = $this->getUsernameByMobile($mobile);
// $allTransactions[] = [
//     'source' => 'Commission',
//     'credit'=>$commission->commission ?? 0,
//     'debit' => 0,
//     'commission'=>$commission->commissions ?? 0,
//     'tds'=>$commission->tds ?? 0,
//     'charges' =>$commission->charges ?? 0,
//    'status' => $commission->commission === null ? 'Failed' : 'Success',
//     'timestamp' => $commission->created_at ?? "N/A",
//     'type'=>'',
//     'mobile'=>$commission->retailermobile,
//     'desc'=>($commission->service).' Commission '.$comm.',Debit TDS '.($commission->tds ?? 0),
//     'trans_id'=>'',
//     'rrn'=>'',
//     'username' => $usernameDetails->username ?? 'N/A',
//     'name' => $usernameDetails->name ?? 'N/A',
//     'ext_ref'=> $commission->externalRef ?? 0,
//     'openingB'=>$commission->opening_bal ?? 0,
//     'clsoingB'=>$commission->closing_bal ?? 0,

// ];

// }

    // Fetch data from 'cash_withdrawals'
    $cashWithdrawals = DB::table('cash_withdrawals')->get();
    foreach ($cashWithdrawals as $withdrawal) {
        $responseData = json_decode($withdrawal->response_data, true);
        $payableValue=0;

        if(isset($responseData['statuscode']) && $responseData['statuscode'] == 'TXN')
        {
            $payableValue = (float)($responseData['data']['transactionValue'] ?? 0);
            $individualTotals['AEPS'] += $payableValue;
            $totalAmount += $payableValue;
        }

        $mobile = $withdrawal->mobile;
        $usernameDetails = $this->getUsernameByMobile($mobile);
        // $payableValue = (float)($responseData['data']['payableValue'] ?? 0);
        // $individualTotals['AEPS'] += $payableValue;
        // $totalAmount += $payableValue;
        $status = isset($responseData['statuscode']) && $responseData['statuscode'] == 'TXN' ? 'Success' : 'Failed';
        $allTransactions[] = [
           'source' => 'AEPS',
            'credit' => $payableValue ?? 0,
            'debit'=>0,
            'mobile'=>$withdrawal->mobile,
            'commission'=>$withdrawal->commissions ?? 0,
            'charges'=>$withdrawal->charges ?? 0,
            'status' => $status ?? 0,
            'timestamp' => $responseData['timestamp'] ?? "N/A",
            'type' => 'Withdrawal',
            'desc' => 'AePS Withdrawal form ' . ($responseData['data']['accountNumber'] ?? 'N/A').' and Commission '.($withdrawal->commissions ?? 0),
            'tds' =>$withdrawal->tds,
            'trans_id'=>$responseData['data']['ipayId'] ?? 'N/A',
            'ext_ref'=>$withdrawal->external_ref ?? 0,
            'openingB'=>$withdrawal->opening_balance ?? 0,
            'rrn'=>$responseData['data']['ipayId'] ?? 0,
            'username' => $usernameDetails->username ?? 'N/A',
             'name' => $usernameDetails->name ?? 'N/A',
            'clsoingB'=>$withdrawal->closing_balance ?? 0,
        ];
    }

    // Fetch data from 'utility_payments'
    $utilityPayments = DB::table('utility_payments')->get();
    foreach ($utilityPayments as $payment) {
        $responseData = json_decode($payment->response_body, true);
        $txnValue = (float)($responseData['respose']['data']['txnValue'] ?? 0);
        $individualTotals['BBPS'] += $txnValue;
        $totalAmount += $txnValue;
        $status = (
            isset($responseData['status']) &&
            in_array($responseData['status'], ["Transaction Successful", "Transaction Under Process"])
        ) ? 'Success' : 'Failed';

        $mobile = $payment->mobile;
        $usernameDetails = $this->getUsernameByMobile($mobile);
        $allTransactions[] = [
           'source' => 'BBPS',
            'credit' => 0,
            'debit'=>$txnValue ?? 0,
            'mobile'=>$payment->mobile,
            'status' => $status ?? 0,
             'tds' => $payment->tds ?? 0,
            'commission'=>$payment->commission,
            'charges'=>$payment->charges ?? 0,
            'timestamp' => $responseData['timestamp'] ?? "N/A",
            'type'=>'Deposit',
            'desc'=>'Utility Payments for'.($responseData['billerDetails']['name'] ?? ''),
            'trans_id'=>$responseData['data']['poolReferenceId'] ?? 0,
            // 'rrn'=>$responseData['data']['poolReferenceId'] ?? 0,
            'ext_ref'=>$responseData['data']['externalRef']?? 0,
            'openingB'=>$payment->opening_balance ?? 0,
            'rrn'=>$responseData['data']['ipayId'] ?? 0,
            'username' => $usernameDetails->username ?? 'N/A',
    'name' => $usernameDetails->name ?? 'N/A',
            'clsoingB'=>$payment->closing_balance ?? 0,
        ];
    }

    // Fetch data from 'transactions_d_m_t1'
    $transactionsDMT1 = DB::table('transactions_d_m_t1')->get();
    foreach ($transactionsDMT1 as $transaction) {
        $responseData = json_decode($transaction->response_data, true);
        $txnAmount = (float)($responseData['txn_amount'] ?? 0);
        $individualTotals['DMT2'] += $txnAmount;
        $totalAmount += $txnAmount;
        $status = isset($responseData['status']) && $responseData['status'] == 'true' ? 'Success' : 'Failed';
        $mobile = $transaction->mobile;
        $usernameDetails = $this->getUsernameByMobile($mobile);
        $allTransactions[] = [
           'source' => 'DMT2',
            'credit'=>0,
            'debit' => $txnAmount ?? 0,
             'tds' => $transaction->tds ?? 0,
              'commission'=>$transaction->commission ?? 0,
            'charges'=>$transaction->charges ?? 0,
            'mobile'=>$transaction->mobile,
            'status' => $status ?? 0,
            'timestamp' => $transaction->created_at ?? "N/A",
             'type'=>'Deposit',
             'desc'=>'Transaction to '.($responseData['benename'] ?? 'N/A'),
            'trans_id'=>$responseData['benename'] ?? 0,
            'rrn'=>$responseData['data']['txnReferenceId'] ?? 0,
            'username' => $usernameDetails->username ?? 'N/A',
            'name' => $usernameDetails->name ?? 'N/A',
            'ext_ref'=>$responseData['data']['externalRef'] ??0,
            'openingB'=>$transaction->opening_balance ?? 0,
            'clsoingB'=>$transaction->closing_balance ?? 0,
        ];
    }

    // Fetch data from 'transactions_dmt_instant_pay'
    $transactionsDMTInstantPay = DB::table('transactions_dmt_instant_pay')->get();
    foreach ($transactionsDMTInstantPay as $transaction) {
        $responseData = json_decode($transaction->response_data, true);
        $amount = (float)($responseData['data']['txnValue'] ?? 0);
        $individualTotals['DMT1'] += $amount;
        $totalAmount += $amount;
        $status = isset($responseData['statuscode']) && $responseData['statuscode'] == 'TXN' ? 'Success' : 'Failed';
        $mobile = $transaction->second_no;
        $usernameDetails = $this->getUsernameByMobile($mobile);
        $allTransactions[] = [
            'source' => 'DMT1',
            'credit'=>0,
            'debit' => ($amount) ?? 0,
            'status' => $status,
            'tds' =>$transaction->tds ?? 0,
            'commission'=>$transaction->commission ?? 0,
            'charges'=>$transaction->charges ?? 0,
            'mobile'=>$transaction->second_no ?? 0,
            'timestamp' => $responseData['timestamp'] ?? "N/A",
            'type'=>'Deposit',
             'desc'=>'Money Transfer to '.($responseData['data']['beneficiaryName']??'N/A').' ₹'.($amount ?? 0).' and Charges '.($transaction->charges ?? 0),
            'trans_id'=>$responseData['data']['txnReferenceId']?? 'Null',
            'rrn'=>$responseData['data']['txnReferenceId'] ?? 0,
            'username' => $usernameDetails->username ?? 'N/A',
            'name' => $usernameDetails->name ?? 'N/A',
            'ext_ref'=>$responseData['data']['externalRef'] ??0,
            'openingB'=>$transaction->opening_balance ?? 0,
            'clsoingB'=>$transaction->closing_balance ?? 0,
        ];
    }

     //PAyemet 1
     // // Fetch data from 'transactions_dmt_instant_pay'
    $transactionsDMT = DB::table('nifi_payouts')

        ->get();
    foreach ($transactionsDMT as $transaction) {
        $responseData = json_decode($transaction->responseBody, true);
        $amount = (float)($responseData['deduction']['amount'] ?? 0);
        $individualTotals['Payment1'] += $amount;
        $totalAmount += $amount;
        $status = isset($responseData['statuscode']) && $responseData['statuscode'] == '10000' ? 'Success' : 'Failed';
        $usernameDetails = $this->getUsernameByMobile($mobile);
        $allTransactions[] = [
            'source' => 'Payment1',
            'credit'=>0,
            'debit' => ($amount) ?? 0,
            'commission'=>$transaction->commission?? 0,
            'tds'=> $transaction->tds ?? 0,
            'charges' =>$transaction->charges ?? 0,
            'status' => $status,
           'timestamp' => isset($responseData['timestamp']) 
                ? \Carbon\Carbon::parse($responseData['timestamp'])->format('Y-m-d H:i:s') 
                : 'N/A',
            'type'=>'Deposit',
               'mobile'=>$transaction->second_no ?? 0,
            'desc'=>'Money Transfer to '.($responseData['data']['recipient_name']??'N/A').' ₹'.($amount ?? 0).' and Charges '.($transaction->charges ?? 0),
            'trans_id'=>$responseData['data']['bank_ref_num']?? 'Null',
            'rrn'=>$responseData['data']['bank_ref_num'] ?? 0,
            'username' => $usernameDetails->username ?? 'N/A',
            'name' => $usernameDetails->name ?? 'N/A',
            'ext_ref'=>$responseData['data']['externalRef'] ??0,
            'openingB'=>$transaction->openingBal ?? 0,
            'clsoingB'=>$transaction->closingBal ?? 0,


        ];
    }

// Fetch data from 'pancard'
    $pancards = DB::table('pancard')
            ->get();
        foreach ($pancards as $pancard) {
            $responseData = json_decode($pancard->response_body, true);

            if (isset($responseData['status'])==='FAILED') 
            {
                $allTransactions[] = [
                    'source' => 'pancard',
                    'credit'=>0,
                    'debit' => '107' ?? 0,
                     'tds' =>$pancard->tds ?? 0,
                      'charges' =>$pancard->tds ?? 0,
                     'commission' =>$pancard->tds ?? 0,
                    'mobile'=>$pancard->username,
                    'status' => $responseData['status'] ?? "Success",
                    'timestamp' => $pancard->created_at ?? "N/A",
                    'type'=>'Deposit',
                    'desc'=>'Apply For Pan Card',
                    'trans_id'=>$pancard->order_id,
                    'rrn'=>$responseData['data']['txnReferenceId'] ?? 0,
                    'ext_ref'=>$pancard->order_id ??0,
                    'username' => $usernameDetails->username ?? 'N/A',
                    'name' => $usernameDetails->name ?? 'N/A',
                    'openingB'=>$pancard->opening_balance ?? 0,
                    'clsoingB'=>$pancard->closing_balance ?? 0,


                ];
            }
            else
            {
                $allTransactions[] = [
                     'source' => 'pancard',
                    'credit'=>'',
                    'debit' => '107',
                     'tds' =>$pancard->tds ?? 0,
                     'charges' =>$pancard->tds ?? 0,
                     'commission' =>$pancard->tds ?? 0,
                    'mobile'=>$pancard->username,
                    'status' => $responseData['status'] ?? "Unknown",
                    'timestamp' => $pancard->created_at ?? "N/A",
                    'type'=>'Deposit',
                    'desc'=>'Apply For Pan Card',
                    'trans_id'=>$pancard->order_id,
                    'rrn'=>$responseData['data']['txnReferenceId'] ?? 0,
                    'username' => $usernameDetails->username ?? 'N/A',
                    'name' => $usernameDetails->name ?? 'N/A',
                    'ext_ref'=>$pancard->order_id ??0,

                    'openingB'=>$pancard->opening_balance ?? 0,
                    'clsoingB'=>$pancard->closing_balance ?? 0,


                ];

            }
        }
        // }

    // Sort transactions by timestamp (date)
    usort($allTransactions, function ($a, $b) {
        return strtotime($b['timestamp']) - strtotime($a['timestamp']); // Descending order
    });    // Return the view with transaction data

   // return $allTransactions;die();
    return view('admin.reports.ledger', [
        'totalAmount' => $totalAmount,
        'individualTotals' => $individualTotals,
        'transactions' => $allTransactions,
    ]);
}
public function indexAdminAPI()
{
    //$mobile = session('mobile'); // Retrieve mobile from session
    // Initialize variables to store totals
    $totalAmount = 0;
    $individualTotals = [
        'AEPS' => 0,
        'DMT1' => 0,
        'DMT2' => 0,
        'BBPS' => 0,
        'PAN' =>0,
        'Commission' =>0,
        'Fund' =>0,
        'MobileRecharge'=>0
    ];
    $allTransactions = []; // To store all transaction data

 
   

    // Fetch data from 'cash_withdrawals'
    $cashWithdrawals = DB::table('cash_withdrawals')->get();
    foreach ($cashWithdrawals as $withdrawal) {
        $responseData = json_decode($withdrawal->response_data, true);
        $payableValue=0;

        if(isset($responseData['statuscode']) && $responseData['statuscode'] == 'TXN')
        {
            $payableValue = (float)($responseData['data']['transactionValue'] ?? 0);
            $individualTotals['AEPS'] += $payableValue;
            $totalAmount += $payableValue;
        }
        // $payableValue = (float)($responseData['data']['payableValue'] ?? 0);
        // $individualTotals['AEPS'] += $payableValue;
        // $totalAmount += $payableValue;
        $status = isset($responseData['statuscode']) && $responseData['statuscode'] == 'TXN' ? 'Success' : 'Failed';
        $allTransactions[] = [
           'source' => 'AEPS',
            'credit' => $payableValue,
            'debit'=>'',
            'mobile'=>$withdrawal->mobile,
            'status' => $status,
            'timestamp' => $responseData['timestamp'] ?? "N/A",
            'type' => 'Withdrawal',
            'desc' => 'AePS Withdrawal form ' . ($responseData['data']['accountNumber'] ?? 'N/A').' and Commission '.($withdrawal->commissions ?? 0),
            
            'trans_id'=>$responseData['data']['ipayId'] ?? 'N/A',
            'ext_ref'=>$withdrawal->external_ref,
            'openingB'=>$withdrawal->opening_balance ?? 0,
            'rrn'=>$responseData['data']['ipayId'] ?? 0,
            'clsoingB'=>$withdrawal->closing_balance ?? 0,
        ];
    }

    // Fetch data from 'utility_payments'
    // $utilityPayments = DB::table('utility_payments')->get();
    // foreach ($utilityPayments as $payment) {
    //     $responseData = json_decode($payment->response_body, true);
    //     $txnValue = (float)($responseData['respose']['data']['txnValue'] ?? 0);
    //     $individualTotals['BBPS'] += $txnValue;
    //     $totalAmount += $txnValue;
        
    //     $allTransactions[] = [
    //        'source' => 'BBPS',
    //         'credit' => '',
    //         'debit'=>$txnValue,
    //         'mobile'=>$payment->mobile,
    //         'status' => $responseData['status'] ?? "Unknown",
    //         'timestamp' => $responseData['timestamp'] ?? "N/A",
    //         'type'=>'Deposit',
    //         'desc'=>'Utility Payments for'.($responseData['billerDetails']['name'] ?? 0),
    //         'trans_id'=>$responseData['data']['poolReferenceId'] ?? 0,
    //         // 'rrn'=>$responseData['data']['poolReferenceId'] ?? 0,
    //         'ext_ref'=>$responseData['data']['externalRef']?? 0,
    //         'openingB'=>$payment->opening_balance ?? 0,
    //         'rrn'=>$responseData['data']['ipayId'] ?? 0,
    //         'clsoingB'=>$payment->closing_balance ?? 0,
    //     ];
    // }

    // //Fetch data from 'transactions_d_m_t1'
    // $transactionsDMT1 = DB::table('cgpayout')->get();
    // foreach ($transactionsDMT1 as $transaction) {
    //     $responseData = json_decode($transaction->response, true);
    //     $txnAmount = (float)($transaction['amount'] ?? 0);
    //     $individualTotals['MobileRecharge'] += $txnAmount;
    //     $totalAmount += $txnAmount;
    //     $status = isset($transaction['status']) && $transaction['status'] == 'CREDITED' ? 'Success' : 'Failed';

    //     $allTransactions[] = [
    //        'source' => 'Payout',
    //         'credit'=>'',
    //         'debit' => $txnAmount,
    //         'mobile'=>$transaction->phone,
    //         'status' => $status,
    //         'timestamp' => $transaction->created_at ?? "N/A",
    //          'type'=>'Deposit',
    //          'desc'=>'Transaction to '.($transaction->retailerId ?? 'N/A'),
    //         'trans_id'=>$responseData['payment_id'] ?? 0,
    //         'rrn'=>$responseData['rrn'] ?? 0,
    //         'ext_ref'=>$responseData['crn'] ??0,
    //         'openingB'=>$transaction->opening_balance ?? 0,
    //         'clsoingB'=>$transaction->closing_balance ?? 0,
    //     ];
    // }

    // Fetch data from 'transactions_dmt_instant_pay'
    $transactionsDMTInstantPay = DB::table('transactions_dmt_instant_pay')->get();
    foreach ($transactionsDMTInstantPay as $transaction) {
        $responseData = json_decode($transaction->response_data, true);
        $amount = (float)($responseData['data']['txnValue'] ?? 0);
        $individualTotals['DMT1'] += $amount;
        $totalAmount += $amount;
        $status = isset($responseData['statuscode']) && $responseData['statuscode'] == 'TXN' ? 'Success' : 'Failed';

        $allTransactions[] = [
            'source' => 'DMT',
            'credit'=>'',
            'debit' => ($amount+$transaction->charges),
            'status' => $status,
            'mobile'=>$transaction->second_no,
            'timestamp' => $responseData['timestamp'] ?? "N/A",
            'type'=>'Deposit',
             'desc'=>'Money Transfer to '.($responseData['data']['beneficiaryName']??'N/A').' ₹'.($amount ?? 0).' and Charges '.($transaction->charges ?? 0),
            'trans_id'=>$responseData['data']['txnReferenceId']?? 'Null',
            'rrn'=>$responseData['data']['txnReferenceId'] ?? 0,
            'ext_ref'=>$responseData['data']['externalRef'] ??0,
            'openingB'=>$transaction->opening_balance ?? 0,
            'clsoingB'=>$transaction->closing_balance ?? 0,
        ];
    }
// Fetch data from 'pancard'
    $pancards = DB::table('pancard')
            ->get();
        foreach ($pancards as $pancard) {
            $responseData = json_decode($pancard->response_body, true);

            if (isset($responseData['status'])==='FAILED') 
            {
                $allTransactions[] = [
                    'source' => 'pancard',
                    'credit'=>'',
                    'debit' => '107',
                    'mobile'=>$pancard->username,
                    'status' => $responseData['status'] ?? "Success",
                    'timestamp' => $pancard->created_at ?? "N/A",
                    'type'=>'Deposit',
                    'desc'=>'Apply For Pan Card',
                    'trans_id'=>$pancard->order_id,
                    'rrn'=>$responseData['data']['txnReferenceId'] ?? 0,
                    'ext_ref'=>$pancard->order_id ??0,
                    'openingB'=>$pancard->opening_balance ?? 0,
                    'clsoingB'=>$pancard->closing_balance ?? 0,


                ];
            }
            else
            {
                $allTransactions[] = [
                     'source' => 'pancard',
                    'credit'=>'',
                    'debit' => '107',
                    'mobile'=>$pancard->username,
                    'status' => $responseData['status'] ?? "Unknown",
                    'timestamp' => $pancard->created_at ?? "N/A",
                    'type'=>'Deposit',
                    'desc'=>'Apply For Pan Card',
                    'trans_id'=>$pancard->order_id,
                    'rrn'=>$responseData['data']['txnReferenceId'] ?? 0,
                    'ext_ref'=>$pancard->order_id ??0,
                    'openingB'=>$pancard->opening_balance ?? 0,
                    'clsoingB'=>$pancard->closing_balance ?? 0,


                ];

            }
        }
        // }

    // Sort transactions by timestamp (date)
    usort($allTransactions, function ($a, $b) {
        return strtotime($b['timestamp']) - strtotime($a['timestamp']); // Descending order
    });    // Return the view with transaction data
    return response()->json([
        'totalAmount' => $totalAmount,
        'individualTotals' => $individualTotals,
        'transactions' => $allTransactions,
    ]);
    
}




public function tdsReport(Request $request)
{
    $queryUsername = $request->input('username');
    $queryPan = $request->input('pan_no');

    $tdsTransactions = [];

    // Helper function
    $shouldInclude = function ($user) use ($queryUsername, $queryPan) {
        if ($queryUsername && stripos($user->username ?? '', $queryUsername) === false) return false;
        if ($queryPan && stripos($user->pan_no ?? '', $queryPan) === false) return false;
        return true;
    };

    // Fund Transfers
    $funds = DB::table('wallet_transfers')->get();
    foreach ($funds as $fund) {
        if ($fund->tds > 0) {
            $user = $this->getUsernameByMobile($fund->sender_id);
            if (!$shouldInclude($user)) continue;
            $tdsTransactions[] = [
                'username' => $user->username ?? 'N/A',
                'name' => $user->name ?? 'N/A',
                'service' => 'Fund Transfer',
                'pan_no' => $user->pan_no ?? 'N/A',
                'tds' => $fund->tds,
            ];
        }
    }
    // Fund History
    $funds1 = DB::table('add_moneys')->get();
    foreach ($funds1 as $fund1) {
        if ($fund->tds > 0) {
            $user = $this->getUsernameByMobile($fund1->phone);
            if (!$shouldInclude($user)) continue;
            $tdsTransactions[] = [
                'username' => $user->username ?? 'N/A',
                'name' => $user->name ?? 'N/A',
                'service' => 'Fund Transfer',
                'pan_no' => $user->pan_no ?? 'N/A',
                'tds' => $fund->tds,
            ];
        }
    }

    // AEPS
    $aeps = DB::table('cash_withdrawals')->get();
    foreach ($aeps as $row) {
        if ($row->tds > 0) {
            $user = $this->getUsernameByMobile($row->mobile);
            if (!$shouldInclude($user)) continue;
            $tdsTransactions[] = [
                'username' => $user->username ?? 'N/A',
                'name' => $user->name ?? 'N/A',
                'service' => 'AEPS',
                'pan_no' => $user->pan_no ?? 'N/A',
                'tds' => $row->tds,
            ];
        }
    }

    // BBPS
    $bbps = DB::table('utility_payments')->get();
    foreach ($bbps as $row) {
        if ($row->tds > 0) {
            $user = $this->getUsernameByMobile($row->mobile);
            if (!$shouldInclude($user)) continue;
            $tdsTransactions[] = [
                'username' => $user->username ?? 'N/A',
                'name' => $user->name ?? 'N/A',
                'service' => 'BBPS',
                'pan_no' => $user->pan_no ?? 'N/A',
                'tds' => $row->tds,
            ];
        }
    }

    // DMT1
    $dmt1 = DB::table('transactions_dmt_instant_pay')->get();
    foreach ($dmt1 as $row) {
        if ($row->tds > 0) {
            $user = $this->getUsernameByMobile($row->second_no);
            if (!$shouldInclude($user)) continue;
            $tdsTransactions[] = [
                'username' => $user->username ?? 'N/A',
                'name' => $user->name ?? 'N/A',
                'service' => 'DMT1',
                'pan_no' => $user->pan_no ?? 'N/A',
                'tds' => $row->tds,
            ];
        }
    }
 // payment1
    $dmt1 = DB::table('nifi_payouts')->get();
    foreach ($dmt1 as $row) {
        if ($row->tds > 0) {
            $user = $this->getUsernameByMobile($row->mobile);
            if (!$shouldInclude($user)) continue;
            $tdsTransactions[] = [
                'username' => $user->username ?? 'N/A',
                'name' => $user->name ?? 'N/A',
                'service' => 'Payment1',
                'pan_no' => $user->pan_no ?? 'N/A',
                'tds' => $row->tds,
            ];
        }
    }
    // DMT2
    $dmt2 = DB::table('transactions_d_m_t1')->get();
    foreach ($dmt2 as $row) {
        if ($row->tds > 0) {
            $user = $this->getUsernameByMobile($row->mobile);
            if (!$shouldInclude($user)) continue;
            $tdsTransactions[] = [
                'username' => $user->username ?? 'N/A',
                'name' => $user->name ?? 'N/A',
                'service' => 'DMT2',
                'pan_no' => $user->pan_no ?? 'N/A',
                'tds' => $row->tds,
            ];
        }
    }

    // Sort by TDS (optional)
    usort($tdsTransactions, fn($a, $b) => $b['tds'] <=> $a['tds']);
$totalTds = array_sum(array_column($tdsTransactions, 'tds'));
    return view('admin.reports.tds', [
        'transactions' => $tdsTransactions,
         'totalTds' => $totalTds, // Pass total to view
        'filters' => [
            'username' => $queryUsername,
            'pan_no' => $queryPan,
        ],
    ]);
//     return response()->json([
//     'status' => 'success',
//     'filters' => [
//         'username' => $queryUsername,
//         'pan_no' => $queryPan,
//     ],
//     'transactions' => $tdsTransactions,
// ]);

}


public function exportTdsReport(Request $request)
{
    $queryUsername = $request->input('username');
    $queryPan = $request->input('pan_no');
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');

    $tdsTransactions = [];
    $totalTds = 0;

    $shouldInclude = function ($user) use ($queryUsername, $queryPan) {
        if ($queryUsername && stripos($user->username ?? '', $queryUsername) === false) return false;
        if ($queryPan && stripos($user->pan_no ?? '', $queryPan) === false) return false;
        return true;
    };

    $sources = [
        ['table' => 'wallet_transfers', 'mobileField' => 'sender_id', 'label' => 'Fund Transfer', 'dateField' => 'created_at'],
        ['table' => 'cash_withdrawals', 'mobileField' => 'mobile', 'label' => 'AEPS', 'dateField' => 'created_at'],
        ['table' => 'utility_payments', 'mobileField' => 'mobile', 'label' => 'BBPS', 'dateField' => 'created_at'],
        ['table' => 'transactions_dmt_instant_pay', 'mobileField' => 'second_no', 'label' => 'DMT1', 'dateField' => 'created_at'],
        ['table' => 'transactions_d_m_t1', 'mobileField' => 'mobile', 'label' => 'DMT2', 'dateField' => 'created_at'],
    ];

    foreach ($sources as $source) {
        $query = DB::table($source['table']);

        // Apply date filters if provided
        if ($startDate) {
            $query->whereDate($source['dateField'], '>=', $startDate);
        }
        if ($endDate) {
            $query->whereDate($source['dateField'], '<=', $endDate);
        }

        $rows = $query->get();

        foreach ($rows as $row) {
            if ($row->tds > 0) {
                $user = $this->getUsernameByMobile($row->{$source['mobileField']});
                if (!$shouldInclude($user)) continue;

                $tds = (float)$row->tds;
                $totalTds += $tds;

                $tdsTransactions[] = [
                    'RetailerId' => $user->username ?? 'N/A',
                    'Name' => $user->name ?? 'N/A',
                    'Service' => $source['label'],
                    'PAN No' => $user->pan_no ?? 'N/A',
                    'TDS (₹)' => $tds,
                ];
            }
        }
    }

    usort($tdsTransactions, fn($a, $b) => $b['TDS (₹)'] <=> $a['TDS (₹)']);

    $filename = 'tds_report_' . now()->format('Ymd_His') . '.csv';
    $headers = [
        'Content-Type' => 'text/csv',
        'Content-Disposition' => "attachment; filename=\"$filename\"",
    ];

    $callback = function () use ($tdsTransactions, $totalTds) {
        $file = fopen('php://output', 'w');
        fputcsv($file, ['Username', 'Name', 'Service', 'PAN No', 'TDS (₹)']);
        foreach ($tdsTransactions as $row) {
            fputcsv($file, $row);
        }
        fputcsv($file, ['', '', '', 'Total TDS', number_format($totalTds, 2)]);
        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}


}


