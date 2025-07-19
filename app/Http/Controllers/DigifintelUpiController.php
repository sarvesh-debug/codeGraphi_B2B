<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DigifintelService;
use Illuminate\Support\Facades\DB;
class DigifintelUpiController extends Controller
{
     protected $service;

    public function __construct(DigifintelService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return view('user.upiDigi.create');
    }

    public function createOrder(Request $request)
    {
       // return $request;die();
        $response = $this->service->createOrder(
            $request->amount,
            $request->email,
            $request->phone
        );

       $amount=$request->amount;
        $responseData=$response;
//dd(session('username'),session('mobile'), session('user_name'),$request->amount);
       $store = DB::table('upigateways')->insert([
    "retailerId"      => session('username'),
    "retailerMobile"  => session('mobile'),
    "retailerName"    => session('user_name'),
    'amount'          => $request->amount,
    'orderResponse'    =>json_encode($responseData),
    'status'          => 'pending',
    'created_at'      => now(),
    'updated_at'      => now(),
]);

     // return $responseData;die();
      //$message= $responseData['response']['error'];
    //  return $message;die();
        if($responseData['response']['statusCode']==200 && $responseData['response']['status']=='true')
        {

           $referenceIdG= $responseData['response']['data']['referenceId'];
           $referenceId= $responseData['referenceId'];
           $message= $responseData['response']['data']['message'];
           //dd($referenceId,$message);


           return view('user.upiDigi.pay',compact('referenceId','message','amount'));

            
        }
        elseif($responseData['response']['statusCode']==403)
        {
             $message= $responseData['response']['error'];
             return $message;die();
         //return back()->with('error', "Order Creation Failled".$message);
        }

        else
        {
            $message= $responseData['response']['message'];
             return $message;die();
        }
     
    }

    public function payOrder(Request $request)
    {
        //return $request;die();
        $response = $this->service->payOrder(
            $request->amount,
            $request->referenceId,
            $request->payerVpa,
            $request->payerName,
            $request->remarks
        );

         $responseData=$response;
 $latest = DB::table('upigateways')
    ->where('retailerId', session('username'))
    ->orderByDesc('id') // assuming 'id' is your primary key
    ->first();

if ($latest) {
    $updated = DB::table('upigateways')
        ->where('id', $latest->id)
        ->update([
            'status' => $responseData['data']['status'] ?? 'unknown',
            'payOrderResponse' => json_encode($responseData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
            'updated_at' => now(),
        ]);
}
         //return $responseData;die();
        if($responseData['statusCode']==200 && $responseData['status']=='true')
        {
           $referenceId= $responseData['data']['referenceid'];
           $message= $responseData['msg'];
           //dd($referenceId,$message);

           return view('user.upiDigi.status',compact('referenceId','message'));

            
        }

        else
        {
            return back()->with('response', "Order Creation Failled");
        }
    }
public function checkOrderStatus(Request $request)
{
    
    //return $request;die();
    try {
        $response = $this->service->checkOrderStatus($request->referenceId);
        $responseData = $response;

        \Log::info('Check Order Status Response:', $responseData);

        $utr = $responseData['data']['rrn'] ?? null;
 $latest = DB::table('upigateways')
    ->where('retailerId', session('username'))
    ->orderByDesc('id') // assuming 'id' is your primary key
    ->first();
        // Save response to upigateways
        DB::table('upigateways')
             ->where('id', $latest->id)
            ->update([
                'status' => $responseData['data']['status'] ?? 'unknown',
                'chkOrderResponse' => json_encode($responseData),
                'updated_at' => now(),
            ]);

        // Check if UTR already exists
        $utrExists = DB::table('add_moneys')->where('utr', $utr)->exists();

        // If UTR doesn't exist, insert and increment balance
        if (!$utrExists && ($responseData['statusCode'] ?? 0) == 200 && ($responseData['status'] ?? false) === true && ($responseData['data']['status'] ?? '') === 'SUCCESS') {

            DB::table('add_moneys')->insert([
                'request_by' => session('user_name'),
                'phone' => session('mobile'),
                'id_code' => session('username'),
                'bank_id' => 0,
                'ifsc' => 0,
                'account_no' => '0',
                'amount' => $responseData['data']['amount'] ?? 0,
                'utr' => $utr,
                'date' => now(),
                'mode' => "UPI",
              'slip_images' => json_encode(['UPI_' . ($utr ?? now()->format('Ymd_His'))]),

                'remark' => "UPI",
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Increment balance
            DB::table('customer')
                ->where('phone', session('mobile'))
                ->increment('balance', $responseData['data']['amount'] ?? 0);

            // Update balance in session
            $balance = DB::table('customer')
                ->where('phone', session('mobile'))
                ->value('balance');
            session(['balance' => $balance]);

            return view('user.upiDigi.success', compact('response'));
        }
        elseif (!$utrExists && ($responseData['statusCode'] ?? 0) == 200 && ($responseData['status'] ?? false) === true && ($responseData['data']['status'] ?? '') === 'PROCESSING') {

            DB::table('add_moneys')->insert([
                'request_by' => session('user_name'),
                'phone' => session('mobile'),
                'id_code' => session('username'),
                'bank_id' => 0,
                'ifsc' => 0,
                'account_no' => '0',
                'amount' => $responseData['data']['amount'] ?? 0,
                'utr' => $utr,
                'date' => now(),
                'mode' => "UPI",
              'slip_images' => json_encode(['UPI_' . ($utr ?? now()->format('Ymd_His'))]),

                'remark' => "UPI",
                'status' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Increment balance
          

            // Update balance in session
            $balance = DB::table('customer')
                ->where('phone', session('mobile'))
                ->value('balance');
            session(['balance' => $balance]);

            return view('user.upiDigi.success', compact('response'));
        }


        if ($utrExists) {
            return back()->with('error', '⚠️ This UTR has already been processed. Duplicate transactions are not allowed.');
        }

        return back()->with('error', '❌ UPI Transaction Failed. Please check Reference ID and try again.');

    } catch (\Exception $e) {
        \Log::error('UPI Order Check Failed:', ['error' => $e->getMessage()]);
        return back()->with('error', '⚠️ Something went wrong: ' . $e->getMessage());
    }
}


    public function payIntent(Request $request)
    {
        $response = $this->service->payIntent(
            $request->amount,
            $request->referenceId,
            $request->payerName,
            $request->remarks
        );

        
        //return back()->with('response', $response);
    }

    public function checkIntentStatus(Request $request)
    {
        $response = $this->service->checkIntentStatus($request->referenceId);
        return back()->with('response', $response);
    }

    public function verifyVpa(Request $request)
    {
        $response = $this->service->verifyVpa(
            $request->referenceId,
            $request->vpa
        );

        return back()->with('response', $response);
    }

   public function historyUPI(Request $request)
{
    $query = DB::table('upigateways')
        ->where('retailerId', session('username'));
        

    if ($request->filled('start_date') && $request->filled('end_date')) {
        $query->whereBetween('created_at', [
            Carbon::parse($request->start_date),
            Carbon::parse($request->end_date)
        ]);
    }

    $rawData = $query->orderBy('id', 'desc')->get();

    $transactions = $rawData->map(function ($item) {
        $order = json_decode($item->orderResponse, true);
        $pay = json_decode($item->payOrderResponse, true);
        $chk = json_decode($item->chkOrderResponse, true);

        return [
            'id' => $item->id,
            'retailerId' => $item->retailerId,
            'amount' => $item->amount,
            'referenceId_order' => $order['referenceId'] ?? 'N/A',
            'rrn' => $pay['data']['rrn'] ?? 'N/A',
            'status' => $chk['data']['status'] ?? $item->status,
            'referenceId_pay' => $pay['data']['referenceid'] ?? 'N/A',
            'created_at' => $item->created_at,
        ];
    });

    return view('user.upiDigi.history', [
        'withdrawals' => [], // If needed
        'transactions' => $transactions,
        'start_date' => $request->start_date,
        'end_date' => $request->end_date,
    ]);
}

public function checkOrderStatusIndu(Request $request)
{

   // return $request;die();
    try {
        $response = $this->service->checkOrderStatus($request->referenceId);
        $responseData = $response;

        \Log::info('Check Order Status Response:', $responseData);

        $utr = $responseData['data']['rrn'] ?? null;

      $referenceIdPay = $responseData['data']['referenceId'] ?? null;
//return $responseData['data']['status'] ;die();
if ($referenceIdPay) {
    // Find the matching record
    $record = DB::table('upigateways')
        // ->where('retailerId', session('username'))
        ->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(chkOrderResponse, '$.data.referenceId')) = ?", [$referenceIdPay])
        ->first();
//return $record;die();
    if ($record) {
        DB::table('upigateways')
            ->where('id', $record->id)
            ->update([
                'status' => $responseData['data']['status'] ?? 'unknown',
                'chkOrderResponse' => json_encode($responseData),
                'updated_at' => now(),
            ]);
    }
}

        // Check if UTR already exists
        $utrExists = DB::table('add_moneys')->where('utr', $utr)->exists();
        $openingBalance=DB::table('customer')
                ->where('phone', session('mobile'))
                ->value('balance');
        // If UTR doesn't exist, insert and increment balance
        if (!$utrExists && ($responseData['statusCode'] ?? 0) == 200 && ($responseData['status'] ?? false) === true && ($responseData['data']['status'] ?? '') === 'SUCCESS') {

            DB::table('add_moneys')->insert([
                'request_by' => session('user_name'),
                'phone' => session('mobile'),
                'id_code' => session('username'),
                'bank_id' => 0,
                'ifsc' => 0,
                'account_no' => '0',
                'amount' => $responseData['data']['amount'] ?? 0,
                'utr' => $utr,
                'date' => now(),
                'mode' => "UPI",
               'slip_images' => json_encode(['UPI_' . ($utr ?? now()->format('Ymd_His'))]),

                'remark' => "UPI",
                'status' => 1,
                'openingBalance'=>$openingBalance,
                'closingBalance' =>$openingBalance-$responseData['data']['amount'] ?? 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Increment balance
            DB::table('customer')
                ->where('phone', session('mobile'))
                ->increment('balance', $responseData['data']['amount'] ?? 0);

            // Update balance in session
            $balance = DB::table('customer')
                ->where('phone', session('mobile'))
                ->value('balance');
            session(['balance' => $balance]);

            return view('user.upiDigi.success', compact('response'));
        }
        elseif (!$utrExists && ($responseData['statusCode'] ?? 0) == 200 && ($responseData['status'] ?? false) === true && ($responseData['data']['status'] ?? '') === 'PROCESSING') {

            DB::table('add_moneys')->insert([
                'request_by' => session('user_name'),
                'phone' => session('mobile'),
                'id_code' => session('username'),
                'bank_id' => 0,
                'ifsc' => 0,
                'account_no' => '0',
                'amount' => $responseData['data']['amount'] ?? 0,
                'utr' => $utr,
                'date' => now(),
                'mode' => "UPI",
              'slip_images' => json_encode(['UPI_' . ($utr ?? now()->format('Ymd_His'))]),

                'remark' => "UPI",
                'status' => 0,
                 'openingBalance'=>$openingBalance,
                'closingBalance' =>$openingBalance,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Increment balance
          

            // Update balance in session
            $balance = DB::table('customer')
                ->where('phone', session('mobile'))
                ->value('balance');
            session(['balance' => $balance]);

            return view('user.upiDigi.success', compact('response'));
        }


        if ($utrExists) {
            return back()->with('error', '⚠️ This UTR has already been processed. Duplicate transactions are not allowed.');
        }

        return back()->with('error', '❌ UPI Transaction Failed. Please check Reference ID and try again.');

    } catch (\Exception $e) {
        \Log::error('UPI Order Check Failed:', ['error' => $e->getMessage()]);
        return back()->with('error', '⚠️ Something went wrong: ' . $e->getMessage());
    }
}


}
