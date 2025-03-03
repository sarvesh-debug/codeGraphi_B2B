<?php


namespace App\Http\Controllers;

use App\Models\panResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
class PanCardController extends Controller
{
    // Display New PAN Card Form
    public function newPanForm()
    {
        return view('user.pan.index');
    }


//     public function submitNewPan(Request $request)
// {
//     $username = session('username');
//     $name = session('user_name');
//     $amountTr = 107;
//     $getAmount = session('balance');
//     $getAmount -= 50;

//     if ($getAmount > $amountTr) {
//         $validatedData = $request->validate([
//             'number' => 'required|digits:10',
//             'mode' => 'required|in:EKYC,ESIGN',
//         ]);

//         $orderid = 'PAN' . time();
//         $balance = '107';
//         $applyFor = "New";

//         $parameters = [
//             'vle_id' => env('NSDL_VLE_ID'),
//             'api_key' => env('NSDL_API_KEY'),
//             'orderid' => $orderid,
//             'number' => $validatedData['number'],
//             'mode' => $validatedData['mode'],
//             'callback_url' => route('pan.callback') // Set the callback URL
//         ];
// return $parameters;
// die();
//         // Send API Request
//         $response = Http::post('https://pancenter.in/api/epan/new', $parameters);
//         $rawResponse = $response->body();

//         // Check if the response is HTML (successful response format)
//         if (str_contains($rawResponse, '<form')) {
//             // Extract the value of the "req" field from the HTML response
//             preg_match('/<input type="hidden" name="req" id="req" value=\'(.*?)\'\/>/', $rawResponse, $matches);
//             if (isset($matches[1])) {
//                 $reqData = json_decode($matches[1], true); // Decode the JSON inside the "req" field
//                 $txnid = $reqData['reqEntityData']['txnid'] ?? null;

//                 // Save response to database
//                 panResponse::create([
//                     'order_id' => $orderid,
//                     'name' => $name,
//                     'username' => $username,
//                     'number' => $validatedData['number'],
//                     'mode' => $validatedData['mode'],
//                     'apply_for' => $applyFor,
//                     'balance' => $balance,
//                     'response_body' => $rawResponse,
//                     'status' => 'success', // Save status
//                     'txnid' => $txnid     // Save txnid
//                 ]);

//                 // Return txnid to the user
//                 return response()->json(['status' => 'success', 'txnid' => $txnid]);
//             } else {
//                 // If "req" field is missing
//                 return response()->json(['status' => 'error', 'message' => 'Invalid response structure'], 500);
//             }
//         }

//         // Handle failure response (JSON format)
//         $jsonResponse = json_decode($rawResponse, true);
//         if (json_last_error() === JSON_ERROR_NONE) {
//             // Check for failure status
//             if (isset($jsonResponse['status']) && strtolower($jsonResponse['status']) === 'failed') {
//                 return response()->json($jsonResponse); // Return failure response
//             }
//         }

//         // Handle unexpected response format
//         return response()->json(['status' => 'error', 'message' => 'Unexpected response format'], 500);
//     } else {
//         return response()->json(['status' => 'error', 'message' => 'Insufficient Wallet Balance']);
//     }
// }


public function callback(Request $request)
{
    // Log the incoming callback request for debugging
   //  Log::info('PAN Callback Received: ', $request->all());
// return $request;
// die();
    // Extract callback parameters
    $txid = $request->get('txid');    // Transaction ID
    $status = $request->get('status'); // Transaction status (success/failure)
    $opid = $request->get('opid');    // Operator ID (optional)

    // Check if all required parameters are present
    if (!$txid || !$status) {
        return response()->json(['status' => 'error', 'message' => 'Invalid callback data'], 400);
    }

    // Find the related record in your database using the transaction ID
    $panResponse = panResponse::where('order_id', $opid)->first();

    if (!$panResponse) {
        // If no record is found, log an error and return a response
        Log::error('PAN Callback Error: Transaction not found', ['txid' => $txid]);
        return response()->json(['status' => 'error', 'message' => 'Transaction not found'], 404);
    }

    // Update the record based on the status
    if (strtolower($status) === 'success') {
        $panResponse->status = 'success';
        $panResponse->operator_id = $opid; // Save operator ID if present
    } else {
        $panResponse->status = 'failed';
    }

    // Save the updated record
    $panResponse->save();

    // Return a success response to the callback sender
    return response()->json(['status' => 'success', 'message' => 'Callback processed successfully']);
}


    public function submitNewPan(Request $request)
{
    $username = session('username');
    $name = session('user_name');

    $amountTr=107;
    $getAmount=session('balance');
    $getAmount-=50;
// return $getAmount;
// die();
    if($getAmount > $amountTr)  //450 > 400
    {
        $validatedData = $request->validate([
            'number' => 'required|digits:10',
            'mode' => 'required|in:EKYC,ESIGN',
        ]); 
    
        $orderid = 'PAN' . time();
            $balance='107';
            $applyFor="New";
        $parameters = [
            'vle_id' => env('NSDL_VLE_ID'),
            'api_key' => env('NSDL_API_KEY'),
            'orderid' => $orderid,
            'number' => $validatedData['number'],
            'mode' => $validatedData['mode'],
            //'callback_url' => route('pan.callback') // Register callback UR
        ];
    
        $response = Http::post('https://pancenter.in/api/epan/new', $parameters);
        $rawResponse = $response->body();
    
        // Save response to database with number and mode
        $panResponse = panResponse::create([
            'order_id' => $orderid,
            'name' => $name,
            'username' => $username,
            'number' => $validatedData['number'],
            'mode' => $validatedData['mode'],
            'apply_for' => $applyFor,
            'balance' => $balance,
            'status' =>'pending',
            'response_body' => $rawResponse,
        ]);
        if ($panResponse) {
            $this->updateCustomerBalance();
        }
        
        // Remove HTML comments if present
        $cleanedResponse = preg_replace('/<!--.*?-->/', '', $rawResponse);
    
        // Optionally, check if cleaned response is valid JSON
        $jsonResponse = json_decode($cleanedResponse, true);
    
        $data=$jsonResponse;
    
        // If valid JSON, return as JSON, else return raw content
        if (json_last_error() === JSON_ERROR_NONE) {
            //    return response()->json($jsonResponse);
            return view('user.pan.response', compact('data'));
        } else {
            return response($cleanedResponse);
        }

    }
    else
    {
        return "Insufficient Wallet Balance";

    }

    
}

  








    

    // Display PAN Correction Form
    public function correctionForm()
    {
        return view('user.pan.correction');
    }

 

    public function submitCorrection(Request $request)
    {
        $username = session('username');
    $name = session('user_name');


    $amountTr=107;
    $getAmount=session('balance');
    $getAmount-=50;
// return $getAmount;
// die();
    if($getAmount > $amountTr)  //450 > 400
    {

        $validatedData = $request->validate([
            'number' => 'required|digits:10',
            'mode' => 'required|in:EKYC,ESIGN',
            
        ]);
        $orderid = 'PAN' . time();
        $balance='107';
        $applyFor="Correction";

        $parameters = [
            'vle_id' => env('NSDL_VLE_ID'),
            'api_key' => env('NSDL_API_KEY'),
            'orderid' => $orderid,
            'number' => $validatedData['number'],
            'mode' => $validatedData['mode'],
        ];
    
        $response = Http::post('https://pancenter.in/api/epan/correction', $parameters);
        
        $rawResponse = $response->body();

        $panResponse = panResponse::create([
            'order_id' => $orderid,
            'name' => $name,
            'username' => $username,
            'number' => $validatedData['number'],
            'mode' => $validatedData['mode'],
            'apply_for' => $applyFor,
            'balance' => $balance,
            'response_body' => $rawResponse,
        ]);
        
        if ($panResponse) {
            $this->updateCustomerBalance();
        }
        // Remove HTML comments if present
        $cleanedResponse = preg_replace('/<!--.*?-->/', '', $rawResponse);
    
        // Optionally decode JSON response
        $data = json_decode($cleanedResponse, true);
    
    
    
        // Return the appropriate response
         // Pass the response data to the view
    return view('user.pan.response', compact('data'));
        // if (json_last_error() === JSON_ERROR_NONE) {
        //     return response()->json($jsonResponse);
        // } else {
        //     return response($cleanedResponse);
        // }
    }
    else
    {
        return "Insufficient Wallet Balance";
    }
        
    }
    



    // Display Check Status Form
    public function statusForm()
    {
        return view('user.pan.status');
    }


    public function checkStatus(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'orderid' => 'required',
        ]);
    
        // Set the parameters for the API request
        $parameters = [
            'username' => env('NSDL_VLE_ID'),
            'api_key' => env('NSDL_API_KEY'),
            'orderid' => $validatedData['orderid'],
        ];
    
        // Send GET request to the NSDL API to check status
        $response = Http::get('https://epan.teknoindia.in/api/check_status.php', $parameters);
    //return $response;
        //Get the raw response body
        $rawResponse = $response->body();
    
        // Remove HTML comments if present
        $cleanedResponse = preg_replace('/<!--.*?-->/', '', $rawResponse);
    
        // Decode the cleaned response to check if it's valid JSON
        $data = json_decode($cleanedResponse, true);
    
      

        //Return the cleaned and decoded response as a view
        return view('user.pan.response', compact('response', ));
    }
    


    //Check PAN Status
//     public function checkStatus(Request $request)
//     {
//         $validatedData = $request->validate([
//             'orderid' => 'required',
//         ]);

//         $parameters = [
//             'username' => env('NSDL_VLE_ID'),
//             'api_key' => env('NSDL_API_KEY'),
//             'orderid' => $validatedData['orderid'],
//         ];

//         $response = Http::get('https://epan.teknoindia.in/api/check_status.php', $parameters);
//         //$data = $response->json();
// return $response;
//         //return view('user.pan.response', compact('data'));
//     }

public function handleCallback(Request $request)
    {
        // Log the incoming callback request
        Log::info('Epan Callback Received:', $request->all());

        // Validate request parameters
        $request->validate([
            'txid' => 'required',
            'status' => 'required',
            'opid' => 'required',
        ]);

        // Find the transaction using txid
        $transaction = panResponse::where('order_id', $request->txid)->first();
        $chkId=$request->txid;
        if ($transaction) {
            // Update the transaction status
            $transaction->status = $request->status;
            $transaction->txnid = $request->opid;
            $transaction->save();
            $this->updateCustomerBalanceCallBack($chkId);

            //updateCustomerBalance()
            // if($transaction->status)
            // {

            // }
            // else
            // {
                
            // }
            return response()->json(['message' => 'Callback processed successfully'], 200);
        } else {
            return response()->json(['error' => 'Transaction not found'], 404);
        }
    }

public function panHistory()
{
    $username = session('username');
    // Fetch all data from the database and order by the latest date
    $responses = panResponse::where('username',$username)->orderBy('created_at', 'desc')->get();
    // return $responses;
    // die();
    return view('user.pan.history', ['responses' => $responses]);
}

public function panHistoryAdmin()
{
    $balance=0;
    $url = "https://pancenter.in/api/epan/balance";
    $apiKey = env('NSDL_API_KEY');

    $response = Http::get($url, [
        'api_key' => $apiKey,
    ]);

    if ($response->successful()) {
        $data = $response->json();

        if ($data['status'] === 'SUCCESS') {
            $balance = $data['balance']; // Extract the balance

        } else {
            return [
                'error' => true,
                'message' => 'API response did not indicate success.',
            ];
        }
    }

    // Fetch all data from the database and order by the latest date
    $responses = panResponse::orderBy('created_at', 'desc')->get();



    return view('admin.pancard.historyPan', compact('responses','balance'));


}

public function updateCustomerBalanceCallBack($chkId)
{
    // Retrieve session variables
    $mobile = session('mobile');
    $username = session('username');
    $updateSuccess='';
    $getBalance=DB::table('customer')
    ->where('phone', $mobile)
    ->first();
    // return $getBalance;
    // die();
    $openingB=$getBalance->balance;
    $closingB=0;
    // Fetch the latest transaction for the given username
    $lastRecord = DB::table('pancard')
        ->where('username', $username)
        ->where('order_id',$chkId) // Fetch the latest record based on creation time
        ->first();

        // dd($lastRecord);
        // die();
    if (!$lastRecord) {
        // No record found for the username
        session(['totalPayableValue' => 0]);
        return false;
    }

    
    if ($lastRecord->status == 'FAILED') {
        // Update balance in the pancard table to 0
        DB::table('pancard')
            ->where('username', $username)
            ->update([
                'balance' => 0,
                'openingB' =>$openingB,
                'closingB'=>$openingB-107
            ]);

        // Decrement customer balance by 107
        $updateSuccess = DB::table('customer')
            ->where('phone', $mobile)
            ->increment('balance', 107);

        if ($updateSuccess) {
            // Store the decrement amount in the session
            session(['totalPayableValue' => 107]);
            return true;
        }
    }
// dd($updateSuccess);
// die();
    // If the response status is not FAILED or update fails
    session(['totalPayableValue' => 0]);
    return false;
}

protected function updateCustomerBalance()
{
    // Retrieve session variables
    $mobile = session('mobile');
    $username = session('username');
    $updateSuccess='';
  
    $getBalance=DB::table('customer')
            ->where('phone', $mobile)
            ->first();
            // return $getBalance;
            // die();
            $openingB=$getBalance->balance;
            $closingB=0;
    // Fetch the latest transaction for the given username
    $lastRecord = DB::table('pancard')
        ->where('username', $username)
        ->latest('created_at') // Fetch the latest record based on creation time
        ->first();

        // dd($lastRecord->status);
        // die();
    if (!$lastRecord) {
        // No record found for the username
        session(['totalPayableValue' => 0]);
        return false;
    }

    
    if (!$lastRecord->status == 'FAILED') {
        // Update balance in the pancard table to 0
        DB::table('pancard')
            ->where('username', $username)
            ->update([
                'balance' => 0,
                'openingB' =>$openingB,
                'closingB'=>$openingB-107
            ]);

        // Decrement customer balance by 107
        $updateSuccess = DB::table('customer')
            ->where('phone', $mobile)
            ->decrement('balance', 107);

        if ($updateSuccess) {
            // Store the decrement amount in the session
            session(['totalPayableValue' => 107]);
            return true;
        }
    }
// dd($updateSuccess);
// die();
    // If the response status is not FAILED or update fails
    session(['totalPayableValue' => 0]);
    return false;
}


// private function updateCustomerBalance()
// {
//     // Retrieve session variables
//     $mobile = session('mobile');
//     $username = session('username');

//     if (!$username) {
//         // If username is not in the session, set totalPayableValue to 0 and return
//         session(['totalPayableValue' => 0]);
//         return;
//     }

//     // Fetch the latest transaction for the given username
//     $lastRecord = DB::table('pancard')
//         ->where('username', $username)
//         ->latest('created_at') // Ensure we fetch the latest record based on creation time
//         ->first();

//     if ($lastRecord) {

//         $response_data = json_decode($lastRecord->response_body, true);
//         if (!isset($response_data['status'])==='FAILED') 
//         {
//             DB::table('pancard')
//             ->where('username', $username)
//             ->update(['balance'=>0]);

//             $updateSuccess = DB::table('customer')
//             ->where('username', $username)
//             ->decrement('balance', 107);

//         if ($updateSuccess) {
//             // Store the decrement amount in the session
//             session(['totalPayableValue' => 107]);
//         } else {
//             // If decrement fails, set session value to 0
//             session(['totalPayableValue' => 0]);
//         }
//     } else {
//         // If the response status is "Failure" or invalid JSON, set session value to 0
//         session(['totalPayableValue' => 0]);
//     }

//         }
//         else
//         {
//             return "Error";
//         }
        
           
     
// }

function getEpanBalance()
{
    $url = "https://pancenter.in/api/epan/balance";
    $apiKey = env('NSDL_API_KEY');

    $response = Http::get($url, [
        'api_key' => $apiKey,
    ]);

    if ($response->successful()) {
        return $response->json(); // Return the parsed JSON response
    } else {
        return [
            'error' => true,
            'message' => $response->body(), // Return the error response
        ];
    }
}


}
// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Http;

// class PanCardController extends Controller
// {
//     public function index()
//     {
//         return view('user.pan.index');
//     }
//     public function submitForm(Request $request)
//     {
//         $validatedData = $request->validate([
//             'api_type' => 'required',
//             'orderid' => 'required',
//             'number' => 'required_if:api_type,new,correction|digits:10',
//             'mode' => 'required_if:api_type,new,correction|in:EKYC,ESIGN',
//         ]);

//         $apiType = $validatedData['api_type'];
//         $url = '';
//         $parameters = [
//             'vle_id' => env('NSDL_VLE_ID'),
//             'api_key' => env('NSDL_API_KEY'),
//             'orderid' => $validatedData['orderid'],
//         ];

//         if ($apiType === 'new') {
//             $parameters['number'] = $validatedData['number'];
//             $parameters['mode'] = $validatedData['mode'];
//             $url = 'https://epan.teknoindia.in/api/new_pan.php';
//         } elseif ($apiType === 'correction') {
//             $parameters['number'] = $validatedData['number'];
//             $parameters['mode'] = $validatedData['mode'];
//             $url = 'https://epan.teknoindia.in/api/correction.php';
//         } elseif ($apiType === 'status') {
//             $url = 'https://epan.teknoindia.in/api/check_status.php';
//         } else {
//             return back()->with('error', 'Invalid API Type');
//         }

//         $response = Http::get($url, $parameters);
//         $data = $response->json();

//         return view('user.pan.response', compact('data'));
//     }
    
   
// }
// public function submitNewPan(Request $request) 
//     {
//         $validatedData = $request->validate([
//             'number' => 'required|digits:10',
//             'mode' => 'required|in:EKYC,ESIGN',
//         ]);
    
//         $orderid = 'PAN' . time();
    
//         $parameters = [
//             'vle_id' => env('NSDL_VLE_ID'),
//             'api_key' => env('NSDL_API_KEY'),
//             'orderid' => $orderid,
//             'number' => $validatedData['number'],
//             'mode' => $validatedData['mode'],
//         ];
    
//         $response = Http::get('https://epan.teknoindia.in/api/new_pan.php', $parameters);
//         $data = $response->json();
    
//         return response()->json($data, 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
//     }