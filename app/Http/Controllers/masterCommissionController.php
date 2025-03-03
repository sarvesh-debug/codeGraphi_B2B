<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class masterCommissionController extends Controller
{
    // -------------- Master commission common function ------------------
    private function updateCustomerBalance($mobile, $service, $mode, $role, $externalRef)
    {
        // dd('hello');
        // die()
        $closing_bl = 0;
        $getDisComm = 0;
        $ff = 0;
        $comA = 0;
        $tds = 0;
        // Fetch the latest transaction for the given mobile number
        $lastRecord = DB::table('transactions_dmt_instant_pay')
            ->where('remitter_mobile_number', $mobile)
            ->latest('created_at')  // Sort by created_at to get the most recent record
            ->first();
        // dd($lastRecord);
        // die();

        if ($lastRecord) {
            // Decode the response data from the latest transaction
            $response_data = json_decode($lastRecord->response_data, true);

            // Check if payableValue exists and update the balance
            if (isset($response_data['data']['txnValue']) && (isset($response_data['statuscode']) && $response_data['statuscode'] === 'TXN')) {
                $payableValue = $response_data['data']['txnValue'];

                $getCommission = DB::table('commission_plan')
                    ->where('packages', $role)
                    ->where('service', $service)
                    ->where('sub_service', $mode)
                    ->get();

                $commissionAmount = 0;
                $comA = 0;
                $tds = 0;
                // return $getCommission;
                // die();
                foreach ($getCommission as $commission) {
                    if (strtolower($service) == 'cc_bill'){
                        


                    }
                    else if (strtolower($service) == 'dmt'){
                        // Check if the payable value falls within the commission range
                        if ($payableValue >= $commission->from_amount && $payableValue <= $commission->to_amount) {
                            // Initialize variables
                            $commissionAmount = 0;
                            $comA = 0;
                            $tds = 0;

                            // Calculate charge (percentage or fixed)
                            if ($commission->charge_in === 'Percentage') {
                                $commissionAmount = $payableValue * $commission->charge / 100;
                            } else {
                                $commissionAmount = $commission->charge;
                            }

                            // Calculate commission (percentage or fixed)
                            if ($commission->commission_in === 'Percentage') {
                                $comA = $commissionAmount * $commission->commission / 100;
                            } else {
                                $comA = $commission->commission;
                            }

                            // Calculate TDS (percentage or fixed)
                            if ($commission->tds_in === 'Percentage') {
                                $tds = $comA * $commission->tds / 100;
                            } else {
                                $tds = $commission->tds;
                            }

                            // Update the payable value
                            $payableValue += ($commissionAmount);

                            // Exit the loop once the relevant commission range is found and applied
                            break;
                        }
                    }
                    else if (strtolower($service) === 'fundtransfer') {


                    } else if (strtolower($service) === 'bbps') {


                    } else if (strtolower($service) === 'aeps') {


                    }
                    else {

                    }
                }

                // dd($commission->commission);
                // $opening_bl=$response_data['data']['txnValue'];
                // $closing_bl=$payableValue;

                $opening_bl = session('balance');
                $closing_bl = session('balance') - $payableValue;

                // // Update the customer's balance
                // DB::table('customer')
                //     ->where('phone', $mobile)
                //     ->decrement('balance', $payableValue);

                $getDis = DB::table('customer')
                    ->where('phone', $mobile)
                    ->first();  // Fetch the first record

                if ($getDis) {
                    $disPhone = $getDis->dis_phone;

                    if ($getDis && is_null($getDis->dis_phone)) {
                        $getDisComm = 0;
                        $newpayableValue = $payableValue;
                    } else {
                        // echo "Dis not Done";
                        $getDisComm += $payableValue * 0.01 / 100;
                        $newpayableValue = $payableValue + $getDisComm;
                    }
                } else {
                }
                // Update the distibuter's balance
                DB::table('customer')
                    ->where('phone', $disPhone)
                    ->increment('balance', $getDisComm);

                $disData = DB::table('customer')
                    ->where('phone', $disPhone)
                    ->first();

                if ($disData) {
                    $opB = $disData->balance;
                    $clB = $opB + $getDisComm;
                    $dis_no = $disPhone;
                    $ret_no = $mobile;
                    $comm = $getDisComm;
                    $service = 'DMT1';
                    DB::table('dis_commission')->insert([
                        'dis_no' => $dis_no,
                        'services' => $service,
                        'retailer_no' => $ret_no,
                        'commission' => $comm,  // Store customerOutletId
                        'opening_balance' => $opB,
                        'closing_balance' => $clB,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

                // Update the customer's balance

                $latestTransaction = DB::table('transactions_dmt_instant_pay')
                    ->where('remitter_mobile_number', $mobile)
                    ->latest('created_at')  // Fetch the latest record based on created_at
                    ->first();

                if ($latestTransaction) {
                    DB::table('transactions_dmt_instant_pay')
                        ->where('id', $latestTransaction->id)
                        // Ensure this condition matches the correct record
                        ->update([
                            'opening_balance' => $opening_bl,
                            'closing_balance' => $closing_bl,
                            'charges' => $commissionAmount,
                            'tds' => $tds,
                            'commission' => $comA
                        ]);
                }

                $nowOp = $closing_bl;
                $nowCl = $closing_bl + ($comA - $tds);
                $coms = $comA;
                // dd($nowCl,$nowOp,$coms);

                DB::table('getcommission')->insert([
                    'retailermobile' => $mobile,
                    'service' => 'Money Transfer',
                    'sub_services' => 'IMPS',  // Store customerOutletId
                    'opening_bal' => $nowOp,
                    'commission' => ($comA - $tds),
                    'tds' => $tds,
                    'externalRef' => $externalRef,
                    'amount' => $payableValue,
                    'closing_bal' => $nowCl,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                DB::table('customer')
                    ->where('phone', $mobile)
                    ->decrement('balance', $newpayableValue - ($comA - $tds));

                // Store the last transaction amount in the session
                session(['totalPayableValue' => $newpayableValue - ($comA - $tds)]);
            } else {
                session(['totalPayableValue' => 0]);  // No payable value in the last transaction
            }
        } else {
            session(['totalPayableValue' => 0]);  // No transactions found
        }

        // dd('ok');

        // dd($opB,$clB,$dis_no,$ret_no,$comm,$service,$disData,$disPhone,$getDis->dis_phone,$ff,$payableValue,$newpayableValue,$commission->charge,$commission->charge_in,$mode,$commissionAmount,$commissionAmount,$comA,$tds,$getDis,$getDisComm);
    }

    public function getMasterCommissionFunction($mobile, $mode, $role, $externalRef)
    {
        return $this->updateCustomerBalance($mobile, $mode, $role, $externalRef);
    }
}
