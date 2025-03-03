<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class walletToWalletController extends Controller
{
    public function index(Request $request)
    {
        // Get the mobile number from the request
        $mobile = $request->input('mobileNumber');
    
        // Retrieve data from the 'customer' table based on the provided mobile number
        $data = DB::table('customer')
                  ->where('phone', $mobile)
                  ->first();  // Use 'first' if expecting only one result, or 'get' for multiple results
    
        // Check if data exists
        if (!$data) {
            // If no user found, you can return an error or redirect back
            return redirect()->back()->withErrors(['message' => 'No user found with this mobile number.']);
        }
    
        // Return the view with the fetched user data
        return view('user.wallet.fetch', ['user' => $data]);
    }

    public function sendMoney(Request $request)
    {
        
        // Validate input
        $request->validate([
            'sender' => 'required|string|exists:customer,username',
            'reciver' => 'required|string|exists:customer,username|different:sender',
            'amount' => 'required|numeric|min:1',
            'remark' => 'nullable|string|max:255',
        ]);
        // return $request;
        // die();
        $senderUsername = $request->input('sender');
        $receiverUsername = $request->input('reciver');
        $amount = $request->input('amount');
        $remark = $request->input('remark', '');
        $transId = 'ZPAY' . uniqid(); // Generate unique transaction ID
    
        // Fetch sender and receiver data
        $senderData = DB::table('customer')->where('username', $senderUsername)->lockForUpdate()->first();
        $receiverData = DB::table('customer')->where('username', $receiverUsername)->lockForUpdate()->first();
        
        if (!$senderData || !$receiverData) {
            return view('user.wallet.send', ['status' => 'invalid_user']);
        }
        
        $senderOpeningBalance = $senderData->balance;
        $receiverOpeningBalance = $receiverData->balance;
    
        // Ensure sender has enough balance after deducting a minimum balance of 50
        if (($senderOpeningBalance - 50) < $amount) {
            return view('user.wallet.send', ['status' => 'insufficient_balance']);
        }
    
        // Calculate closing balances
        $senderClosingBalance = $senderOpeningBalance - $amount;
        $receiverClosingBalance = $receiverOpeningBalance + $amount;
    
        DB::beginTransaction();
        try {
            // Update balances
            DB::table('customer')->where('username', $senderUsername)->decrement('balance' , $amount);
            DB::table('customer')->where('username', $receiverUsername)->increment('balance', $amount);
    
            // Insert transaction logs
            DB::table('wallet_transfers')->insert([
                [
                    'sender_id' => $senderUsername,
                    'receiver_id' => $receiverUsername,
                    'amount' => $amount,
                    'opening_balance' => $senderOpeningBalance,
                    'closing_balance' => $senderClosingBalance,
                    'charges' => 0,
                    'tds' => 0,
                    'remark' => $remark,
                    'transfer_id' => $transId,
                    'type' => 'Debit',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'sender_id' => $receiverUsername,
                    'receiver_id' => $senderUsername,
                    'amount' => $amount,
                    'opening_balance' => $receiverOpeningBalance,
                    'closing_balance' => $receiverClosingBalance,
                    'charges' => 0,
                    'tds' => 0,
                    'remark' => $remark,
                    'transfer_id' => $transId,
                    'type' => 'Credit',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
    //  dd($senderClosingBalance,$receiverClosingBalance,$senderOpeningBalance,$receiverOpeningBalance);
    //     die();
            DB::commit();
            return view('user.wallet.send', ['status' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Transaction failed', ['error' => $e->getMessage()]);
            return view('user.wallet.send', ['status' => 'error']);
            //return $e->getMessage();
        }
    }
    


    public function disTransRel(Request $request)
{
    // return $request;
    // die();
    $currentBalance=$request->input('currentBalance');
    $sender = $request->input('sender');
    $receiver = $request->input('reciver');
    $senderData=DB::table('customer')
    ->where('username', $sender)->first();
    $receiverData=DB::table('customer')
    ->where('username', $receiver)->first();
    //return $senderData;
    $sender_opening_bl=$senderData->balance;
    $receiver_opening_bl=$receiverData->balance;
    // dd($senderData,$receiverData,$sender_opening_bl,$receiver_opening_bl);
    // die();
    //$opening_bl = session('balance'); // Fetch the opening balance from the session
    $chkbl=$sender_opening_bl-50;
    //$closing_bl = 0; // Initialize the closing balance
    $sender_closing_bl=0;
    $receiver_closing_bl=0;
    // Retrieve input data
    $sender = $request->input('sender');
    $receiver = $request->input('reciver');
    $amount = $request->input('amount');
    $transaction_type = $request->input('transaction_type');
    $remark = $request->input('remark');
    $transId = 'AbheePay' . uniqid(); // Generate a unique transaction ID

    try {
        // Check transaction type
        if ($transaction_type === 'Debit') {
            if ($currentBalance < $amount) {
                return view('user.wallet.send', ['status' => 'blance']);
            }

            $sender_closing_bl = $sender_opening_bl + $amount;
            $receiver_closing_bl = $receiver_opening_bl - $amount;

            // Update balances
            DB::table('customer')
                ->where('username', $sender)
                ->increment('balance', $amount);

            DB::table('customer')
                ->where('username', $receiver)
                ->decrement('balance', $amount);
        } elseif ($transaction_type === 'Credit') {
            if ($chkbl < $amount) {
                return view('user.wallet.send', ['status' => 'blance']);
            }
            $receiver_closing_bl = $receiver_opening_bl + $amount;
            $sender_closing_bl = $sender_opening_bl - $amount;

            // Update balances
            DB::table('customer')
                ->where('username', $sender)
                ->decrement('balance', $amount);

            DB::table('customer')
                ->where('username', $receiver)
                ->increment('balance', $amount);
        } else {
            //  return back()->with('error', 'Invalid transaction type.');
        }

        // Insert transaction record into `wallet_transfers` table
        //sender
        $inserted= DB::table('wallet_transfers')->insert([
            [
              'sender_id' => $receiver,
                'receiver_id' => $sender,
                'amount' => $amount,
                'opening_balance' => $sender_opening_bl,
                'closing_balance' => $sender_closing_bl,
                'charges' => 0,
                'tds' => 0,
                'remark' => $remark,
                'transfer_id' => $transId,
                'type' => 'Debit',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'sender_id' => $sender,
                'receiver_id' => $receiver,
                'amount' => $amount,
                'opening_balance' => $receiver_opening_bl,
                'closing_balance' => $receiver_closing_bl,
                'charges' => 0,
                'tds' => 0,
                'remark' => $remark,
                'transfer_id' => $transId,
                'type' => 'Credit',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);


        // dd($sender_closing_bl,$sender_opening_bl,$receiver_closing_bl,$receiver_opening_bl);
        // die();
        //reviver
        
        // dd($inserted);
        // die();
        //return "Done";
        // Redirect to success page with a success message
        return view('users.onboard.add-wallet', [
            'message' => 'Successfully transferred wallet money.',
            'transaction_id' => $transId,
        ]);
    } catch (\Exception $e) {
        // Handle exceptions and rollback changes if necessary
        return back()->with('error', 'An error occurred during the transaction: ' . $e->getMessage());
    }
}

public function walletHistory()
{
    $userId=session('username');
    $responseData = DB::table('wallet_transfers')
        ->where('sender_id', $userId)
        ->get();

        return view('user.wallet.wallet_history',compact('responseData'));
}



public function adminTransRel(Request $request)
{
    
    $currentBalance=$request->input('currentBalance');
 $receiver = $request->input('reciver');
     $receiverData=DB::table('customer')
                ->where('username', $receiver)->first();
//  return $receiverData;
//     die();
    $opening_bl = $receiverData->balance; // Fetch the opening balance from the session
    $chkbl=$opening_bl-50;
    $closing_bl = 0; // Initialize the closing balance
      
    // Retrieve input data
    $adminWallet=session('adminBalance');
    $sender = $request->input('sender');
    $receiver = $request->input('reciver');
    $amount = $request->input('amount');
    $transaction_type = $request->input('transaction_type');
    $remark = $request->input('remark');
    $transId = 'ZPAY' . uniqid(); // Generate a unique transaction ID

    try {
        if ($adminWallet < $amount) {
            return view('admin.wallet.send', ['status' => 'blance']);
        }
        // Check transaction type
        if ($transaction_type === 'Debit') {
            
            if ($currentBalance < $amount) {
                return view('admin.user-details.sendError', ['status' => 'blance']);
            }

            $closing_bl = $opening_bl - $amount;

            // Update balances
            // DB::table('customer')
            //     ->where('username', $sender)
            //     ->decrement('balance', $amount);

            DB::table('customer')
                ->where('username', $receiver)
                ->decrement('balance', $amount);
                DB::table('business')
                ->where('business_id', session('business_id'))
                ->increment('balance', $amount);    

        $balanceAd = DB::table('business')
     ->where('business_id', session('business_id'))
     ->value('balance');
     // Store the retrieved balance in the session
     session(['adminBalance'=> $balanceAd]);
        } elseif ($transaction_type === 'Credit') {
            $closing_bl = $opening_bl + $amount;

            // Update balances
            // DB::table('customer')
            //     ->where('username', $sender)
            //     ->increment('balance', $amount);

            DB::table('customer')
                ->where('username', $receiver)
                ->increment('balance', $amount);
            DB::table('business')
                ->where('business_id', session('business_id'))
                ->decrement('balance', $amount);    

        $balanceAd = DB::table('business')
     ->where('business_id', session('business_id'))
     ->value('balance');
     // Store the retrieved balance in the session
     session(['adminBalance'=> $balanceAd]);
        } else {
            //  return back()->with('error', 'Invalid transaction type.');
        }

        // Insert transaction record into `wallet_transfers` table
        $inserted=DB::table('wallet_transfers')->insert([
            'sender_id' => 'Admin',
            'receiver_id' => $receiver,
            'amount' => $amount,
            'opening_balance' => $opening_bl,
            'closing_balance' => $closing_bl,
            'charges' => 0,
            'tds' => 0,
            'remark' => $remark,
            'transfer_id' => $transId,
            'type' => $transaction_type,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
       // dd($inserted);
        //return "Done";
        // Redirect to success page with a success message
        return view('users.onboard.add-wallet', [
            'message' => 'Successfully transferred wallet money.',
            'transaction_id' => $transId,
        ]);
    } catch (\Exception $e) {
        // Handle exceptions and rollback changes if necessary
        return back()->with('error', 'An error occurred during the transaction: ' . $e->getMessage());
    }
}
   


public function walletHistoryAdmin()
{
   
    $responseData = DB::table('wallet_transfers')->orderBy('id','desc')
        ->get();

        return view('admin.reports.fund-transfer',compact('responseData'));
}



public function lockRealese(Request $request)
{
    
    $balance = $request->input('currentBalance');
    $sender = $request->input('sender');
    $receiver = $request->input('receiver'); // Fixed typo
    $amount = $request->input('amount');
    $transaction_type = $request->input('transaction_type');
    $remark = $request->input('remark');
    
    
    // dd($balance,$amount,$lock,$release,$receiver);
    // die();
    //$transId = 'AbheePay' . uniqid(); // Unique transaction ID

    try {
        DB::beginTransaction(); // Start transaction

        if ($transaction_type === 'Debit') {
            $lock=$balance-$amount;
            // Lock balance and reduce available balance
            DB::table('customer')
                ->where('username', $receiver)
                ->increment('LockBalance', $amount);

            DB::table('customer')
                ->where('username', $receiver)
                ->decrement('balance', $amount);
        } elseif ($transaction_type === 'Credit') {
            $release=$amount;
            // Release locked balance and increase available balance
            DB::table('customer')
                ->where('username', $receiver)
                ->decrement('LockBalance', $amount);

            DB::table('customer')
                ->where('username', $receiver)
                ->increment('balance', $amount);
        } else {
            return back()->with('error', 'Invalid transaction type.');
        }

        DB::commit(); // Commit transaction

        return redirect()->back()->with('success', 'Successfully' );
    } catch (\Exception $e) {
        DB::rollback(); // Rollback on failure
        return back()->with('error', 'An error occurred during the transaction: ' . $e->getMessage());
    }
}


}
