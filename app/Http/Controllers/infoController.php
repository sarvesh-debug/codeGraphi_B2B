<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class infoController extends Controller
{
    // AEPS

    public function aepsReport(Request $request)
    {
        // Get today's date and current month
        $today = now()->format('Y-m-d');
        $currentMonth = now()->format('Y-m');
    
        // Fetch today's transactions
        $todayTransactions = DB::table('cash_withdrawals')
            ->whereDate('created_at', $today)
            ->get();
    
        // Fetch monthly transactions
        $monthlyTransactions = DB::table('cash_withdrawals')
            ->where('created_at', 'like', "$currentMonth%")
            ->get();
    
        // Get start_date and end_date from request
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
    
        // Build the query for filtered data
        $allDataQuery = DB::table('cash_withdrawals');
    
        if ($startDate && $endDate) {
            $allDataQuery->whereBetween('created_at', [$startDate, $endDate]);
        }
    
        // Get filtered data
        $allData = $allDataQuery->orderBy('created_at', 'desc')->get();
    
        // Initialize counters and totals for today's transactions
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
    
        // Initialize counters and totals for monthly transactions
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
    
        // Pass data to the view
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
        // Get today's date and current month
        $today = now()->format('Y-m-d');
        $currentMonth = now()->format('Y-m');
    
        // Fetch today's transactions
        $todayTransactions = DB::table('transactions_dmt_instant_pay')
            ->whereDate('created_at', $today)
            ->get();
    
        // Fetch monthly transactions
        $monthlyTransactions = DB::table('transactions_dmt_instant_pay')
            ->where('created_at', 'like', "$currentMonth%")
            ->get();
    
        // Get start_date and end_date from request
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
    
        // Build the query for filtered data
        $allDataQuery = DB::table('transactions_dmt_instant_pay');
    
        if ($startDate && $endDate) {
            $allDataQuery->whereBetween('created_at', [$startDate, $endDate]);
        }
    
        // Get filtered data
        $allData = $allDataQuery->orderBy('created_at', 'desc')->get();
    
        // Initialize counters and totals for today's transactions
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
    
        // Initialize counters and totals for monthly transactions
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
    
        //Pass data to the view
        return view('admin.reports.dmt1', [
            'todayTotal' => $todayTotal,
            'todaySuccessCount' => $todaySuccessCount,
            'todayFailedCount' => $todayFailedCount,
            'monthlyTotal' => $monthlyTotal,
            'monthlySuccessCount' => $monthlySuccessCount,
            'monthlyFailedCount' => $monthlyFailedCount,
            'allData' => $allData,
        ]);

    //      return response()->json([
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
    }

    // DMT 2



    public function index()
{
    $mobile = session('mobile'); // Retrieve mobile from session
    $userId = session('username'); // Retrieve mobile from session

    // Initialize variables to store totals
    $totalAmount = 0;
    $individualTotals = [
        'AEPS' => 0,
        'DMT' => 0,
        'BBPS' => 0,
        'Commission' =>0,
        'Fund' =>0,
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
        'credit' => $creditAmount,
        'debit' => $debitAmount,
        'commission' => $commission->commissions ?? 0,
        'tds' => $commission->tds ?? 0,
        'charges' => $commission->charges ?? 0,
        'status' => 'Success',
        'timestamp' => $getFund->created_at ?? "N/A",
        'type' => $getFund->type ?? '',
        'desc' => ($creditDes?? '') . ' ' . ($debitDes ?? ''),
        'trans_id' => '',
        'rrn' => '',
        'ext_ref' => $getFund->transfer_id ?? 0,
        'openingB' => $getFund->opening_balance ?? 0,
        'clsoingB' => $getFund->closing_balance ?? 0, // Fixed spelling
    ];
    
}

//Fatch data from 'commission'

$getCommission = DB::table('getcommission')
    ->where('retailermobile', $mobile)
    ->get();

foreach ($getCommission as $commission) {
    $txnAmount = $commission->commission ?? 0; // Default to 0 if null
    $individualTotals['Commission'] = ($individualTotals['Commission'] ?? 0) + $txnAmount;
    $totalAmount = ($totalAmount ?? 0) + $txnAmount;
    $comm = ($commission->commission ?? 0) + ($commission->tds ?? 0); // Safe addition
    
    $allTransactions[] = [
        'source' => 'Commission',
        'credit' => $commission->commission ?? 0,
        'debit' => '',
        'commission' => $commission->commissions ?? 0,
        'tds' => $commission->tds ?? 0,
        'charges' => $commission->charges ?? 0,
        'status' => isset($commission->commission) ? 'Success' : 'Failed',
        'timestamp' => $commission->created_at ?? "N/A",
        'type' => '',
        'desc' => ($commission->service ?? 'Unknown Service') . ' Commission ' . $comm . ', Debit TDS ' . ($commission->tds ?? 0),
        'trans_id' => '',
        'rrn' => '',
        'ext_ref' => $commission->externalRef ?? 0,
        'openingB' => $commission->opening_bal ?? 0,
        'clsoingB' => $commission->closing_bal ?? 0,
    ];
}

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
            'credit' => $payableValue,
            'debit'=>'',
            'commission'=>$withdrawal->commissions ?? 0,
            'tds'=>$withdrawal->tds ?? 0,
            'charges' =>'',
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
        
        $allTransactions[] = [
            'source' => 'BBPS',
            'credit' => '',
            'debit'=>($txnValue),
            'commission'=>$payment->commissions ?? 0,
            'tds'=>$payment->tds ?? 0,
            'charges' =>$payment->charges ?? 0,
            'status' => $responseData['status'] ?? "Unknown",
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
            'credit'=>'',
            'debit' => $txnAmount,
          'commission'=>$transaction->commissions ?? 0,
            'tds'=>$transaction->tds ?? 0,
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
            'credit'=>'',
            'debit' => ($amount+$transaction->charges),
            'commission'=>$transaction->commission?? 0,
            'tds'=>$transaction->tds ?? 0,
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

    //Fatch data from 'commission'
    $getCommission = DB::table('getcommission')
            ->where('retailermobile', $mobile)
            ->get();
foreach($getCommission as $commission)
{

    $txnAmount=$commission->commission;
    $individualTotals['Commission'] += $txnAmount;
            $totalAmount += $txnAmount;

            $allTransactions[] = [
                'source' => 'Commission',
                'credit'=>$commission->commission,
                'debit' => '',
                'commission'=>$commission->commissions ?? 0,
                'tds'=>$commission->tds ?? 0,
                'charges' =>$commission->charges ?? 0,
              'status' => $commission->commission === null ? 'Failed' : 'Success',
                'timestamp' => $commission->created_at ?? "N/A",
                'type'=>'',
                'desc'=>'Get Commission on '.($commission->service),
                'trans_id'=>'',
                'rrn'=>'',
                'ext_ref'=> '',
                'openingB'=>$commission->opening_bal ?? 0,
                'clsoingB'=>$commission->closing_bal ?? 0,

            ];

}
        
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
        'PAN' =>0,
        'Commission' =>0,
        'Fund' =>0,
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
 
 
 $allTransactions[] = [
     'source' => 'Fund Transfer',
     'credit' => $creditAmount,
     'debit' => $debitAmount,
     'commission' => $commission->commissions ?? 0,
     'tds' => $commission->tds ?? 0,
     'charges' => $commission->charges ?? 0,
     'status' => 'Success',
     'timestamp' => $getFund->created_at ?? "N/A",
     'type' => $getFund->type ?? '',
     'mobile'=>$getFund->sender_id,
     'desc' => ($creditDes?? '') . ' ' . ($debitDes ?? ''),
     'trans_id' => '',
     'rrn' => '',
     'ext_ref' => $getFund->transfer_id ?? 0,
     'openingB' => $getFund->opening_balance ?? 0,
     'clsoingB' => $getFund->closing_balance ?? 0, // Fixed spelling
 ];
 
}


    //Fatch data from 'commission'
$getCommission = DB::table('getcommission')
->get();
foreach($getCommission as $commission)
{

$txnAmount=$commission->commission;
$individualTotals['Commission'] += $txnAmount;
$totalAmount += $txnAmount;
    $comm = ($commission->commission ?? 0) + ($commission->tds ?? 0); // Safe addition
$allTransactions[] = [
    'source' => 'Commission',
    'credit'=>$commission->commission,
    'debit' => '',
    'commission'=>$commission->commissions ?? 0,
    'tds'=>$commission->tds ?? 0,
    'charges' =>$commission->charges ?? 0,
   'status' => $commission->commission === null ? 'Failed' : 'Success',
    'timestamp' => $commission->created_at ?? "N/A",
    'type'=>'',
    'mobile'=>$commission->retailermobile,
    //'desc'=>'Get Commission on '.($commission->service).' '.($commission->amount).' and tds '.($commission->tds),
    'desc'=>($commission->service).' Commission '.$comm.',Debit TDS '.($commission->tds ?? 0),
    'trans_id'=>'',
    'rrn'=>'',
    'ext_ref'=> $commission->externalRef ?? 0,
    'openingB'=>$commission->opening_bal ?? 0,
    'clsoingB'=>$commission->closing_bal ?? 0,

];

}

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
    $utilityPayments = DB::table('utility_payments')->get();
    foreach ($utilityPayments as $payment) {
        $responseData = json_decode($payment->response_body, true);
        $txnValue = (float)($responseData['respose']['data']['txnValue'] ?? 0);
        $individualTotals['BBPS'] += $txnValue;
        $totalAmount += $txnValue;
        
        $allTransactions[] = [
           'source' => 'BBPS',
            'credit' => '',
            'debit'=>$txnValue,
            'mobile'=>$payment->mobile,
            'status' => $responseData['status'] ?? "Unknown",
            'timestamp' => $responseData['timestamp'] ?? "N/A",
            'type'=>'Deposit',
            'desc'=>'Utility Payments for'.($responseData['billerDetails']['name'] ?? 0),
            'trans_id'=>$responseData['data']['poolReferenceId'] ?? 0,
            // 'rrn'=>$responseData['data']['poolReferenceId'] ?? 0,
            'ext_ref'=>$responseData['data']['externalRef']?? 0,
            'openingB'=>$payment->opening_balance ?? 0,
            'rrn'=>$responseData['data']['ipayId'] ?? 0,
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

        $allTransactions[] = [
           'source' => 'DMT2',
            'credit'=>'',
            'debit' => $txnAmount,
            'mobile'=>$transaction->mobile,
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

    // Fetch data from 'transactions_dmt_instant_pay'
    $transactionsDMTInstantPay = DB::table('transactions_dmt_instant_pay')->get();
    foreach ($transactionsDMTInstantPay as $transaction) {
        $responseData = json_decode($transaction->response_data, true);
        $amount = (float)($responseData['data']['txnValue'] ?? 0);
        $individualTotals['DMT1'] += $amount;
        $totalAmount += $amount;
        $status = isset($responseData['statuscode']) && $responseData['statuscode'] == 'TXN' ? 'Success' : 'Failed';

        $allTransactions[] = [
            'source' => 'DMT1',
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

    // Fetch data from 'transactions_d_m_t1'
    // $transactionsDMT1 = DB::table('transactions_d_m_t1')->get();
    // foreach ($transactionsDMT1 as $transaction) {
    //     $responseData = json_decode($transaction->response_data, true);
    //     $txnAmount = (float)($responseData['txn_amount'] ?? 0);
    //     $individualTotals['DMT2'] += $txnAmount;
    //     $totalAmount += $txnAmount;
    //     $status = isset($responseData['status']) && $responseData['status'] == 'true' ? 'Success' : 'Failed';

    //     $allTransactions[] = [
    //        'source' => 'DMT2',
    //         'credit'=>'',
    //         'debit' => $txnAmount,
    //         'mobile'=>$transaction->mobile,
    //         'status' => $status,
    //         'timestamp' => $transaction->created_at ?? "N/A",
    //          'type'=>'Deposit',
    //          'desc'=>'Transaction to '.($responseData['benename'] ?? 'N/A'),
    //         'trans_id'=>$responseData['benename'] ?? 0,
    //         'rrn'=>$responseData['data']['txnReferenceId'] ?? 0,
    //         'ext_ref'=>$responseData['data']['externalRef'] ??0,
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

}


