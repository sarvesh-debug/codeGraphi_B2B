<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class accountStatementController extends Controller
{
    public function fetchStatement(Request $request)
    {
        $validated = $request->validate([
            'accountNumber' => 'required',
            'txnDateFrom' => 'required|date',
            'txnDateTo' => 'required|date',
        ]);

        $apiUrl = 'https://api.instantpay.in/reports/statement';
        $headers = [
            'X-Ipay-Auth-Code' => env('IPAY_AUTH_CODE'),
            'X-Ipay-Client-Id' => env('IPAY_CLIENT_ID'),
            'X-Ipay-Client-Secret' => env('IPAY_CLIENT_SECRET'),
            'X-Ipay-Endpoint-Ip' => env('IPAY_ENDPOINT_IP'),
            'Content-Type' => 'application/json',
        ];

        $payload = [
            'bankProfileId' => 0, // Fixed value
            'accountNumber' => $validated['accountNumber'],
            'externalRef' => Str::uuid()->toString(), // Auto-generate unique reference
            'pagination' => [
                'pageNumber' => 1,
                'recordsPerPage' => 20,
            ],
            'filters' => [
                'txnDateFrom' => $validated['txnDateFrom'],
                'txnDateTo' => $validated['txnDateTo'],
            ],
        ];

        $response = Http::withHeaders($headers)->post($apiUrl, $payload);
        $responseData = $response->json();

        return view('user.bank-statement.bank-account', compact('responseData'));
    }



    public function fetchStatementWallet(Request $request)
    {
        $validated = $request->validate([
            'accountNumber' => 'required|string',
            'txnDateFrom' => 'required|date',
            'txnDateTo' => 'required|date',
        ]);

        $apiUrl = 'https://api.instantpay.in/reports/statement';
        $headers = [
            'X-Ipay-Auth-Code' => env('IPAY_AUTH_CODE'),
            'X-Ipay-Client-Id' => env('IPAY_CLIENT_ID'),
            'X-Ipay-Client-Secret' => env('IPAY_CLIENT_SECRET'),
            'X-Ipay-Endpoint-Ip' => env('IPAY_ENDPOINT_IP'),
            'Content-Type' => 'application/json',
        ];

        $payload = [
            'bankProfileId' => "0",
            'accountNumber' => $validated['accountNumber'],
            'pagination' => [
                'pageNumber' => 1,
                'recordsPerPage' => 20,
            ],
            'filters' => [
                'txnDateFrom' => $validated['txnDateFrom'],
                'txnDateTo' => $validated['txnDateTo'],
            ],
        ];

        $response = Http::withHeaders($headers)->post($apiUrl, $payload);

        if ($response->successful()) {
            $responseData = $response->json();
            return view('user.bank-statement.business-wallet', compact('responseData'));
        } else {
            return back()->withErrors(['error' => 'Failed to fetch transaction data.']);
        }


        //$response = Http::withHeaders($headers)->post($apiUrl, $payload);

        //         // Return the API response as JSON
              //  return response()->json($response->json(), $response->status());
        
    }

    public function fetchOrderedStatement(Request $request)
    {
        $validated = $request->validate([
            'accountNumber' => 'required|string',
            'txnDateFrom' => 'required|date',
            'txnDateTo' => 'required|date',
        ]);

        $apiUrl = 'https://api.instantpay.in/reports/statement';
        $headers = [
            'X-Ipay-Auth-Code' => env('IPAY_AUTH_CODE'),
            'X-Ipay-Client-Id' => env('IPAY_CLIENT_ID'),
            'X-Ipay-Client-Secret' => env('IPAY_CLIENT_SECRET'),
            'X-Ipay-Endpoint-Ip' => env('IPAY_ENDPOINT_IP'),
            'Content-Type' => 'application/json',
        ];

        $payload = [
            'bankProfileId' => "0",
            'accountNumber' => $validated['accountNumber'],
            'pagination' => [
                'pageNumber' => 1,
                'recordsPerPage' => 20,
            ],
            'filters' => [
                'txnDateFrom' => $validated['txnDateFrom'],
                'txnDateTo' => $validated['txnDateTo'],
            ],
            'isOrder' => true,
        ];

        $response = Http::withHeaders($headers)->post($apiUrl, $payload);

        if ($response->successful()) {
            $responseData = $response->json();
            return view('user.bank-statement.collect-orders', compact('responseData'));
        } else {
            return back()->withErrors(['error' => 'Failed to fetch ordered transaction data.']);
        }
    }



    
}



// <?php

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Http;
// use Illuminate\Support\Str;

// class accountStatementController extends Controller
// {
//     public function fetchStatement(Request $request)
//     {
//         $validated = $request->validate([
//             'accountNumber' => 'required',
//             'txnDateFrom' => 'required|date',
//             'txnDateTo' => 'required|date',
//         ]);

//         $apiUrl = 'https://api.instantpay.in/reports/statement';
//         $headers = [
//             'X-Ipay-Auth-Code' => env('IPAY_AUTH_CODE'),
//             'X-Ipay-Client-Id' => env('IPAY_CLIENT_ID'),
//             'X-Ipay-Client-Secret' => env('IPAY_CLIENT_SECRET'),
//             'X-Ipay-Endpoint-Ip' => env('IPAY_ENDPOINT_IP'),
//             'Content-Type' => 'application/json',
//         ];

//         $payload = [
//             'bankProfileId' => 0, // Fixed value
//             'accountNumber' => $validated['accountNumber'],
//             'externalRef' => Str::uuid()->toString(), // Auto-generate unique reference
//             'pagination' => [
//                 'pageNumber' => 1,
//                 'recordsPerPage' => 20,
//             ],
//             'filters' => [
//                 'txnDateFrom' => $validated['txnDateFrom'],
//                 'txnDateTo' => $validated['txnDateTo'],
//             ],
//         ];

//         $response = Http::withHeaders($headers)->post($apiUrl, $payload);

//         // Return the API response as JSON
//         return response()->json($response->json(), $response->status());
//     }
// }
