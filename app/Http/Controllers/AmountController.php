<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class AmountController extends Controller
{
//     public function getSenderAmount()
//     {
//         $mobile = session('mobile');
//     $withdrawals = DB::table('customer')
//         ->where('phone', $mobile)
//         ->orderBy('created_at', 'desc')  // Order by created date descending
//         ->get();

// return $withdrawals->balance;
//     //return view('user.AEPS.historyAeps', ['withdrawals' => $withdrawals]);
//     }

public function getSenderAmount() 
{
    // Get the mobile number from the session
    $mobile = session('mobile');

    // Query the customer table to find the record based on the mobile number
    $sender = DB::table('customer')
        ->where('phone', $mobile)
        ->first(); // Get the first matching record

        $balance=$sender->balance;
       //return $balance;
       session(['balance' => $balance]);
       return view('user/home-page');
   
}

public function getAEPSamount()
{
   
        $mobile = session('mobile');

     // Query the cash_withdrawals table to find records based on the mobile number
     $records = DB::table('transactions_dmt_instant_pay')
             ->where('remitter_mobile_number', $mobile)
            ->get();

     $totalPayableValue = 0;
     foreach ($records as $record) {
//         // Decode the JSON response_data for each record        
 $response_data = json_decode($record->response_data, true);

       // Safely access nested data and add it to the totalPayableValue
         if (isset($response_data['data']['txnValue'])) {
            $totalPayableValue += $response_data['data']['txnValue'];
         }
     }
// return $totalPayableValue;
// die();
     // Update the customer's balance in the customer table
     DB::table('customer')
        ->where('phone', $mobile)
         ->increment('balance', $totalPayableValue);

     //return "Balance updated successfully by $totalPayableValue.";
     session(['totalPayableValue' => $totalPayableValue]);
//     dd(session('totalPayableValue'));    

}


public function getCommission()
{
    $id=session('id');
    
    $sender = DB::table('commissions')
        ->where('customer_id', $id)
        ->first(); // Get the first matching record

       // $balance=$sender->balance;
      $aeps= $sender->aeps_commission;
      $rtgs= $sender->aeps_commission;
      $imps= $sender->aeps_commission;
      $neft= $sender->aeps_commission;

      echo "AEPS Commission: {$aeps}%<br>";
      echo "RTGS Commission: {$rtgs}%<br>";
      echo "IMPS Commission: {$imps}%<br>";
      echo "NEFT Commission: {$neft}%<br>";
}


//add here a function to add(sum) $payableValue to customer table in balance tabel where phone =$mobile 

// public function addPayableValueToBalance()
// {
//     $mobile = session('mobile');

//     // Query the cash_withdrawals table to find records based on the mobile number
//     $records = DB::table('cash_withdrawals')
//         ->where('mobile', $mobile)
//         ->get();

//     $totalPayableValue = 0;

//     foreach ($records as $record) {
//         // Decode the JSON response_data for each record
//         $response_data = json_decode($record->response_data, true);

//         // Safely access nested data and add it to the totalPayableValue
//         if (isset($response_data['data']['payableValue'])) {
//             $totalPayableValue += $response_data['data']['payableValue'];
//         }
//     }

//     // Update the customer's balance in the customer table
//     DB::table('customer')
//         ->where('phone', $mobile)
//         ->increment('balance', $totalPayableValue);

//     //return "Balance updated successfully by $totalPayableValue.";
//     session(['totalPayableValue' => $totalPayableValue]);
//     dd(session('totalPayableValue'));
//    // return view('user/home-page');
// }


// public function getPandata()
// {
//     $pay=550;
//     $role = session('role');
//     $getCommission = DB::table('commission_plan')
//         ->where('packages', $role)
//         ->where('service', 'AEPS')
//         ->get(); // Execute the query and get the results as a collection

//     if($commission->from_amount<=100 && $commission->to_amount>=1000 )
//     {
//         if($commission->commission_in==='Percentage')
//         {
//             $pay=$pay*100/$commission->commission;
//         }
//         else
//         {
//             $pay=$pay+$commission->commission;
//         }

//     }
//     elseif($commission->from_amount<=10001 && $commission->to_amount>=2000 )
//     {

//     if($commission->commission_in==='Percentage')
//     {
//         $pay=$pay*100/$commission->commission;
//     }
//     else
//     {
//         $pay=$pay+$commission->commission;
//     }
//     }
//     return $pay;

//         // foreach ($getCommission as $commission) {
//         //     echo "ID: " . $commission->id . "\n";
//         //     echo "Service: " . $commission->service . "\n";
//         //     echo "From Amount: " . $commission->from_amount . "\n";
//         //     echo "To Amount: " . $commission->to_amount . "\n";
//         //     echo "Charge: " . $commission->charge . "\n";
//         //     echo "Commission: " . $commission->commission . "\n";
//         //     echo "TDS: " . $commission->tds . "\n";
//         //     echo "Charge In: " . $commission->charge_in . "\n";
//         //     echo "Commission In: " . $commission->commission_in . "\n";
//         //     echo "TDS In: " . $commission->tds_in . "\n";
//         //     echo "Created At: " . $commission->created_at . "\n";
//         //     echo "Updated At: " . $commission->updated_at . "\n";
//         //     echo "Sub Service: " . $commission->sub_service . "\n";
//         //     echo "Packages: " . $commission->packages . "\n";
//         //     echo "--------------------------\n".'<br>';
//         // }
//     //return response()->json($getCommission); // Return the result as a JSON response
// }


public function getPandata()
{
    $pay = 1100; // Initial payment amount
    $role = session('role');

    // Fetch all commission plans for the current role and AEPS service
    $getCommission = DB::table('commission_plan')
        ->where('packages', $role)
        ->where('service', 'DMT')
        ->where('sub_service', 'IMPS')
        ->get();

    $commissionApplied = null;
    $commissionAmount = 0;

    foreach ($getCommission as $commission) {
        // Check if the pay amount falls within the range
        if ($pay >= $commission->from_amount && $pay <= $commission->to_amount) {
            // Apply commission based on type (Percentage or Fixed Amount)
            if ($commission->commission_in === 'Percentage') {
                $commissionAmount = $pay * $commission->commission / 100;
                $pay += $commissionAmount;
            } else { // Fixed Amount
                $commissionAmount = $commission->commission;
                $pay += $commissionAmount;
            }
            $commissionApplied = $commission;
            break;
        }
    }

    if ($commissionApplied) {
        return [
            'final_pay' => $pay,
            'commission_type' => $commissionApplied->commission_in,
            'commission_amount' => $commissionAmount,
        ];
    }

    // If no commission applied, return default
    return [
        'final_pay' => $pay,
        'commission_type' => 'None',
        'commission_amount' => 0,
    ];
}
}
