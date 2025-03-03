<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http; // Add this line

class TransactionController extends Controller
 {
    public function show()
    {
        return view('user.money-transfer.money-transfer');
    }
    public function showOTP($mobile, $bene_id)
    {
        return view('user.money-transfer.send_otp',compact('mobile', 'bene_id'));
    }
    public function showRefund()
    {
        return view('user.money-transfer.refund_otp');
    }
    public function showStatus()
    {
        return view('user.money-transfer.transaction_status');
    }

//     public function transact(Request $request)
//     {
//         // Generate a unique reference ID if not provided
//         $referenceId = $request->input('referenceid') ?? 'AP' . str_pad(mt_rand(0, 99999999), 8, '0', STR_PAD_LEFT);
    
//         // Set headers
//         $headers = [
//             'Authorisedkey' => env('AUTH_KEY'),
//             'Token' => env('API_TOKEN'),
//             'accept' => 'application/json',
//             'content-type' => 'application/json',
//         ];
    
//         // Prepare data payload
//         $data = [
//             'mobile' => $request->input('mobile'),
//             'referenceid' => $referenceId,
//             'pipe' => $request->input('pipe'),
//             'pincode' => $request->input('pincode'),
//             'address' => $request->input('address'),
//             'dob' => $request->input('dob'),
//             'gst_state' => $request->input('gst_state'),
//             'bene_id' => $request->input('bene_id'),
//             'txntype' => $request->input('txntype'),
//             'amount' => $request->input('amount'),
//             'merchantcode' => $request->input('merchantcode'),
//         ];
    
//         // Make the API request
//         $response = Http::withHeaders($headers)->post(env('SERVICE_API_BASE_URL'), $data);
    
//         // Check if the response was successful
//         if ($response->successful()) {
//             // Pass the response data to the Blade view
//             return view('user.money-transfer.transaction_result', ['transactionData' => $response->json()]);
//         } else {
//             // Pass an error message to the Blade view in case of failure
//             return view('user.money-transfer.transaction_result', ['error' => 'Transaction failed. Please try again.']);
//         }
//     }
    


    // public function transact(Request $request)
    // {
    //     // Set headers
    //     $headers = [
    //         'Authorisedkey' => env('AUTH_KEY'),
    //         'Token' => env('API_TOKEN'),
    //         'accept' => 'application/json',
    //         'content-type' => 'application/json',
    //     ];
    
    //     // Prepare data payload
    //     $data = [
    //         'mobile' => $request->input('mobile'),
    //         'referenceid' => $request->input('referenceid'),
    //         'pipe' => $request->input('pipe'),
    //         'pincode' => $request->input('pincode'),
    //         'address' => $request->input('address'),
    //         'dob' => $request->input('dob'),
    //         'gst_state' => $request->input('gst_state'),
    //         'bene_id' => $request->input('bene_id'),
    //         'txntype' => $request->input('txntype'),
    //         'amount' => $request->input('amount'),
    //         'merchantcode' => $request->input('merchantcode'),
    //     ];
    
    //     // Make the API request
    //     $response = Http::withHeaders($headers)->post(env('SERVICE_API_BASE_URL'), $data);
    
    //     // Return the JSON response
    //     return response()->json($response->json());
    // }

    public function transact(Request $request)
    {
        $role = session('role');
        $txnType=$request->input('txntype');
        // Set headers for the API request
        $headers = [
            'Authorisedkey' => env('AUTH_KEY'),   // Authorization Key from .env
            'Token' => env('API_TOKEN'),         // API Token from .env
            'accept' => 'application/json',      // Accept response in JSON format
            'content-type' => 'application/json', // Sending JSON data in the request
        ];
    
        // Prepare the data payload for the API request
        $data = [
            'mobile' => $request->input('mobile'),
            'referenceid' => $request->input('referenceid'),
            'pincode' => '110015',                  // Fixed Pincode for New Delhi
            'address' => 'New Delhi',               // Fixed Address for New Delhi
            'dob' => '01-01-1990',                  // Fixed Date of Birth (Modify as needed)
            'gst_state' => '07',                    // GST State code for Delhi (Modify as needed)
            'bene_id' => $request->input('bene_id'),
            'txntype' => $request->input('txntype'),
            'amount' => $request->input('amount'),
            'stateresp' => $request->input('stateresp'),
            'otp' => $request->input('otp'),       // OTP field from the form
        ];
    
        // Make the API request with the headers and data
        $response = Http::withHeaders($headers)->post(env('SERVICE_API_BASE_URL'), $data);
    
        // Extract the response data from the API response
        $responseData = $response->json();
    // return $responseData;
    // die();
        // Log the response for debugging (optional)
        \Log::info('API Response:', $responseData);
    
        // Store the response, mobile, and referenceid in the database
        try {
            \DB::table('transactions_d_m_t1')->insert([
                'mobile' => $request->input('mobile'),
                'referenceid' => $request->input('referenceid'), // Store referenceid
                'response_data' => json_encode($responseData),  // Store the entire response as JSON
                'created_at' => now(),                          // Timestamp
                'updated_at' => now(),                          // Timestamp
            ]);


        } catch (\Exception $e) {
            // Log any database insertion errors
            \Log::error('Database Insert Error:', ['error' => $e->getMessage()]);
        }
    
        // Handle successful and error responses
        if ($response->successful() && isset($responseData['status']) && $responseData['status'] === true) {

            // $this->updateCustomerBalance(session('mobile'),'txnType');

            $this->updateCustomerBalance(session('mobile'), $txnType,$role);
            // Send data to the success view
            return view('user.money-transfer.transaction_result', [
                'transactionData' => $responseData,
                'referenceid' => $request->input('referenceid'), // Pass the referenceid to the view
            ]);
        } else {
            // Send the error message to the error view
            return view('user.money-transfer.money-transferError', [
                'error' => $responseData['message'] ?? 'Unknown error occurred',
            ]);
        }



    }


    private function updateCustomerBalance($mobile,$txnType,$role)
{


    $id=session('id');
    
    // Fetch the latest transaction for the given mobile number
    $lastRecord = DB::table('transactions_d_m_t1')
        ->where('mobile', $mobile)
        ->latest('created_at') // Sort by created_at to get the most recent record
        ->first();

    if ($lastRecord) {
        // Decode the response data from the latest transaction
        $response_data = json_decode($lastRecord->response_data, true);

        // Check if payableValue exists and update the balance
        if (isset($response_data['txn_amount'])) {
            $payableValue = $response_data['txn_amount'];
           
            $getCommission = DB::table('commission_plan')
            ->where('packages', $role)
            ->where('service', 'DMT')
            ->where('sub_service',$txnType)
            ->get();
            // return $getCommission;
            // die();
        foreach ($getCommission as $commission) {
           
            // Check if the pay amount falls within the range
            if ($payableValue >= $commission->from_amount && $payableValue <= $commission->to_amount) {
               
                // Apply commission based on type (Percentage or Fixed Amount)
                if ($commission->commission_in === 'Percentage') {
                 
                    $payableValue += $payableValue * $commission->commission / 100;
                } else {
                    
                    $payableValue += $commission->commission;
                }   
                break;
            }
        }

        $opening_bl=$response_data['txn_amount'];
        $closing_bl=$payableValue; 

        DB::table('transactions_d_m_t1')
        ->where('mobile', $mobile) // Ensure this condition matches the correct record
        ->update([
            'opening_balance' => $opening_bl,
            'closing_balance' => $closing_bl,
        ]);
            // Update the customer's balance
            DB::table('customer')
                ->where('phone', $mobile)
                ->decrement('balance', $payableValue);

            // Store the last transaction amount in the session
            session(['totalPayableValue' => $payableValue]);
        } else {
            session(['totalPayableValue' => 0]); // No payable value in the last transaction
        }
    } else {
        session(['totalPayableValue' => 0]); // No transactions found
    }
}
    

    
    
    //Send OTP



    public function sent_otp(Request $request)
    {
        // Validate the input data
        $validatedData = $request->validate([
            'mobile' => 'required|numeric',
            'bene_id' => 'required|string',
            'txntype' => 'required|string',
            'amount' => 'required|numeric',
        ]);
    
        // Generate a unique reference ID if not provided
        $referenceId = $request->input('referenceid') ?? 'AP' . str_pad(mt_rand(0, 99999999), 8, '0', STR_PAD_LEFT);
    
        // Set headers
        $headers = [
            'Authorisedkey' => env('AUTH_KEY'),
            'Token' => env('API_TOKEN'),
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];
    
        // Prepare data payload
        $data = [
            'mobile' => $validatedData['mobile'],
            'referenceid' => $referenceId,
            'pincode' => '110015',
            'address' => 'New Delhi',
            'dob' => '01-01-1990',
            'gst_state' => '07',
            'bene_id' => $validatedData['bene_id'],
            'txntype' => $validatedData['txntype'],
            'amount' => $validatedData['amount'],
        ];
    
        try {
            // Make the API request
            $response = Http::withHeaders($headers)->post(
                env('API_URL') . '/api/v1/service/dmt/kyc/transact/transact/send_otp',
                $data
            );
    
            // Decode the API response
            $responseData = $response->json();
    // return $responseData;
    // die();
            if ($response->successful() && isset($responseData['status']) && $responseData['status'] === true) {
                // Extract required data from the response
                $stateresp = $responseData['stateresp'] ?? null;
    
                // Return the view with all the data
                return view('user.money-transfer.money-transfer', [
                    'stateresp' => $stateresp,
                    'mobile' => $validatedData['mobile'],
                    'referenceid' => $referenceId,
                    'pincode' => $data['pincode'],
                    'address' => $data['address'],
                    'dob' => $data['dob'],
                    'gst_state' => $data['gst_state'],
                    'bene_id' => $validatedData['bene_id'],
                    'txntype' => $validatedData['txntype'],
                    'amount' => $validatedData['amount'],
                ]);


            } else {
                 // Extract error message from the response
    $errorMessage = $responseData['message'] ?? 'Unknown error occurred';

    // Pass the error message to the error view
    return view('user.money-transfer.money-transferError', [
        'error' => $errorMessage,
    ]);
            }
        } catch (\Exception $e) {
            // Handle exceptions
            return view('user.money-transfer.money-transfer', [
                'error' => 'Request failed: ' . $e->getMessage(),
            ]);
        }
    }
    


    // public function sent_otp(Request $request)
    // {
    //     // Generate a unique reference ID if not provided
    //     $referenceId = $request->input('referenceid') ?? 'AP' . str_pad(mt_rand(0, 99999999), 8, '0', STR_PAD_LEFT);
    
    //     // Set headers
    //     $headers = [
    //         'Authorisedkey' => env('AUTH_KEY'),
    //         'Token' => env('API_TOKEN'),
    //         'accept' => 'application/json',
    //         'content-type' => 'application/json',
    //     ];
    
    //     // Prepare data payload
    //     $data = [
    //         'mobile' => $request->input('mobile'),
    //         'referenceid' => $referenceId,
    //         'pincode' => '110015',
    //         'address' => 'New Delhi',
    //         'dob' => '01-01-1990',
    //         'gst_state' => '07',
    //         'bene_id' => $request->input('bene_id'),
    //         'txntype' => $request->input('txntype'),
    //         'amount' => $request->input('amount'),
    
    //     ];
    
    //     // Make the API request
    //     $response = Http::withHeaders($headers)->post(env('API_URL') . '/service-api/api/v1/service/dmt/kyc/transact/transact/send_otp', $data);

    
    //     // Return the JSON response
    //    // return response()->json($response->json());



    // }


public function queryTransaction(Request $request)
{
    // Assume `referenceid` is coming from a request parameter
    $referenceId = $request->input('referenceid');

    // Make the API request using Laravel's Http client
    $response = Http::withHeaders([
        'Authorisedkey' => env('AUTH_KEY'),
        'Content-Type' => 'application/json',
        'Token' => env('API_TOKEN'),
        'accept' => 'application/json',
    ])->post(env('API_URL') . '/api/v1/service/dmt/kyc/transact/transact/querytransact', [
        'referenceid' => $referenceId,
    ]);

    // return $response->json();
    // die();
    // Check if the response was successful and send data to the view
    if ($response->successful()) {
        return view('user.money-transfer.query-result', ['queryData' => $response->json()]);
    } else {
        return view('user.money-transfer.query-result', ['error' => 'Unable to fetch transaction details.']);
    }
}


public function refundOtp(Request $request)
{
    // Retrieve referenceId and ackno from the request
    $referenceId = $request->input('referenceid');
    $ackno = $request->input('ackno');

    // Make the API request using Laravel's Http client
    $response = Http::withHeaders([
        'Authorisedkey' => env('AUTH_KEY'),
        'Content-Type' => 'application/json',
        'Token' => env('API_TOKEN'),
        'accept' => 'application/json',
    ])->post(env('API_URL') . '/api/v1/service/dmt/kyc/refund/refund/resendotp', [
        'referenceid' => $referenceId,
        'ackno' => $ackno,
    ]);

    // Check if the response was successful and send data to the view
    if ($response->successful()) {
        return view('user.money-transfer.claim_refund', [
            'queryData' => $response->json(),  // API response data
            'referenceId' => $referenceId,    // Pass referenceId to the view
            'ackno' => $ackno,                // Pass ackno to the view
        ]);
    } else {
        return view('user.money-transfer.claim_refund', [
            'error' => 'Unable to fetch transaction details.',
            'referenceId' => $referenceId,    // Pass referenceId to the view for context
            'ackno' => $ackno,                // Pass ackno to the view for context
        ]);
    }
}


public function refundOtpClaim(Request $request)
{
    // Retrieve referenceId, ackno, and OTP from the request
    $referenceId = $request->input('referenceid');
    $ackno = $request->input('ackno');
    $otp = $request->input('otp');

    // Make the API request using Laravel's Http client
    $response = Http::withHeaders([
        'Authorisedkey' => env('AUTH_KEY'),
        'Content-Type' => 'application/json',
        'Token' => env('API_TOKEN'),
        'accept' => 'application/json',
    ])->post(env('API_URL') . '/api/v1/service/dmt/kyc/refund/refund/', [
        'referenceid' => $referenceId,
        'ackno' => $ackno,
        'otp' => $otp,
    ]);

    // Parse the API response
    $responseData = $response->json();

    // Check if the response was successful
    if ($response->successful() && isset($responseData['status']) && $responseData['status'] === true) {
        // Render the success view with response data
        return view('user.money-transfer.claim_refund_success', [
            'message' => $responseData['message'], // Transaction message
            'referenceId' => $referenceId,        // Reference ID
            'ackno' => $ackno,                    // Ackno
        ]);
    } else {
        // Render the error view with response data
        return view('user.money-transfer.claim_refund_error', [
            'error' => $responseData['message'] ?? 'An error occurred. Please try again.',
            'referenceId' => $referenceId,
            'ackno' => $ackno,
        ]);
    }
}


public function history(Request $request) 
{
    $mobile = session('mobile'); // Get mobile number from session

    // Retrieve the start and end dates from the request
    $startDate = $request->start_date;
    $endDate = $request->end_date;

    // Build the query
    $query = DB::table('transactions_d_m_t1')->where('mobile', $mobile);

    if ($startDate) {
        $query->whereDate('created_at', '>=', $startDate);
    }

    if ($endDate) {
        $query->whereDate('created_at', '<=', $endDate);
    }

    $transactions = $query->orderBy('created_at', 'desc')->get();

    // Return the view with the filtered transactions
  //  return view('user.transactions', ['transactions' => $transactions]);
  return view('user.money-transfer.dmtps-history', ['transactions' => $transactions]);
}

private function getAllTransactions()
{
    // Get the mobile number from the session
    $mobile = session('mobile');
// return $mobile;
// die();
    // Fetch transactions where the mobile number matches, and order by 'created_at' in descending order
    return DB::table('transactions_d_m_t1')
        ->where('mobile', $mobile)  // Filter based on the mobile number
        ->orderBy('created_at', 'desc')  // Order by created_at in descending order
        ->get();
}

    // public function transact(Request $request)
    // {
    //     $response = Http::withHeaders(headers: [
    //         'Authorisedkey' => env('AUTH_KEY'),
    //         'Token' => env('API_TOKEN'),
    //         'accept' => 'application/json',
    //         'content-type' => 'application/json',
    //     ])->post(env('SERVICE_API_BASE_URL'), [
    //         'mobile' => $request->input('mobile'),
    //         'referenceid' => $request->input('referenceid'),
    //         'pipe' => $request->input('pipe'),
    //         'pincode' => $request->input('pincode'),
    //         'address' => $request->input('address'),
    //         'dob' => $request->input('dob'),
    //         'gst_state' => $request->input('gst_state'),
    //         'bene_id' => $request->input('bene_id'),
    //         'txntype' => $request->input('txntype'),
    //         'amount' => $request->input('amount'),
    //         'merchantcode' => $request->input('merchantcode'),
    //     ]);

    //     // Handle the response as needed
    //     return response()->json($response->json());
    // }
}
