<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;


class transtionStatusController extends Controller
{
    public function showform()
    {
        return view('user.transaction_status.index');
    }


    public function txnStatus(Request $request)
{
    $transactionDate = $request->input('transactionDate', '2021-11-29'); // Default if no date is provided
    $externalRef = 'REF' . Str::random(10); // Generate a unique reference ID
    $source = 'ORDER';

    // Make the API request
    $response = Http::withHeaders([
        'X-Ipay-Auth-Code'    => env('IPAY_AUTH_CODE'),
        'X-Ipay-Client-Id'    => env('IPAY_CLIENT_ID'),
        'X-Ipay-Client-Secret' => env('IPAY_CLIENT_SECRET'),
        'X-Ipay-Endpoint-Ip'  => env('IPAY_ENDPOINT_IP'),
        'Content-Type'        => 'application/json'
    ])->post('https://api.instantpay.in/reports/txnStatus', [
        'transactionDate' => $transactionDate,
        'externalRef'     => $externalRef,
        'source'          => $source,
    ]);

    // Check if request was successful and return response
    if ($response->successful()) {
        return view('user.transaction_status.index', [
            'responseData' => $response->json(),
            'externalRef' => $externalRef // Pass the generated reference to the view
        ]);
    } else {
        return back()->withErrors('Failed to retrieve transaction status');
    }
}
}
