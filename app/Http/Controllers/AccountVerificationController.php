<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AccountVerificationController extends Controller
{

    public function accountform()
    {
        return view('user.account-verification.verify-bank-account');
    }

    public function upiform()
    {
        return view('user.account-verification.verify-upi');
    }
    public function getBanks()
    {
        $response = Http::withHeaders([
            // 'Accept' => 'application/json',
            // 'Content-Type' => 'application/json',
            // 'X-Ipay-Auth-Code' => env('INSTANTPAY_AUTH_CODE'),
            // 'X-Ipay-Client-Id' => env('INSTANTPAY_CLIENT_ID'),
            // 'X-Ipay-Client-Secret' => env('INSTANTPAY_CLIENT_SECRET'),
            // 'X-Ipay-Endpoint-Ip' => env('INSTANTPAY_ENDPOINT_IP'),

            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
            'X-Ipay-Auth-Code' => env('IPAY_AUTH_CODE'),
            'X-Ipay-Client-Id' => env('IPAY_CLIENT_ID'),
            'X-Ipay-Client-Secret' => env('IPAY_CLIENT_SECRET'),
            'X-Ipay-Endpoint-Ip' => env('IPAY_ENDPOINT_IP'),
          
        ])->get('https://api.instantpay.in/identity/verifyBankAccount/banks');

        if ($response->successful()) {
            $responseData = $response->json();
            return view('user.account-verification.list', compact('responseData'));
        } else {
            return view('user.account-verification.list')->withErrors('Failed to retrieve bank data.');
        }
        // if ($response->successful()) {
        //     return response()->json($response->json(), 200);
        // } else {
        //     return response()->json(['error' => 'Failed to verify bank account.'], $response->status());
        // }
    }



    // public function verifyBankAccount(Request $request)
    // {
    //     $response = Http::withHeaders([
    //         'X-Ipay-Auth-Code' => env('IPAY_AUTH_CODE'),
    //         'X-Ipay-Client-Id' => env('IPAY_CLIENT_ID'),
    //         'X-Ipay-Client-Secret' => env('IPAY_CLIENT_SECRET'),
    //         'X-Ipay-Endpoint-Ip' => env('IPAY_ENDPOINT_IP'),
    //         'Content-Type' => 'application/json',
    //     ])->post('https://api.instantpay.in/identity/verifyBankAccount', [
    //         "payee" => [
    //             "name" => $request->input('name'),
    //             "accountNumber" => $request->input('accountNumber'),
    //             "bankIfsc" => $request->input('bankIfsc')
    //         ],
    //         "beneBank" => $request->input('beneBank'),
    //         "externalRef" => uniqid(), // Auto-generate a unique transaction ID
    //         "consent" => "Y",
    //         "pennyDrop" => "YES",
    //         "latitude" => $request->input('latitude'),
    //         "longitude" => $request->input('longitude')
    //     ]);

    //     return $response->json();
    // }

    public function verifyBankAccount(Request $request)
    {
        $response = Http::withHeaders([
            'X-Ipay-Auth-Code' => env('IPAY_AUTH_CODE'),
            'X-Ipay-Client-Id' => env('IPAY_CLIENT_ID'),
            'X-Ipay-Client-Secret' => env('IPAY_CLIENT_SECRET'),
            'X-Ipay-Endpoint-Ip' => env('IPAY_ENDPOINT_IP'),
            'Content-Type' => 'application/json',
        ])->post('https://api.instantpay.in/identity/verifyBankAccount', [
            "payee" => [
                "name" => $request->input('name'),
                "accountNumber" => $request->input('accountNumber'),
                "bankIfsc" => $request->input('bankIfsc')
            ],
            "externalRef" => uniqid(), // Auto-generate a unique transaction ID
            "consent" => "Y",
            "pennyDrop" => "YES",
            "latitude" => $request->input('latitude'),
            "longitude" => $request->input('longitude')
        ]);

       // Pass response data to the view
       return view('user.account-verification.verify-bank-account-response', [
        'response' => $response->json()
    ]);
    }


    public function verifyUPI(Request $request)
    {
        $response = Http::withHeaders([
            'X-Ipay-Auth-Code' => env('IPAY_AUTH_CODE'),
            'X-Ipay-Client-Id' => env('IPAY_CLIENT_ID'),
            'X-Ipay-Client-Secret' => env('IPAY_CLIENT_SECRET'),
            'X-Ipay-Endpoint-Ip' => env('IPAY_ENDPOINT_IP'),
            'Content-Type' => 'application/json',
        ])->post('https://api.instantpay.in/identity/verifyBankAccount', [
            "payee" => [
                "accountNumber" => $request->input('accountNumber'),
                "bankIfsc" => " " // No need for bank IFSC for UPI verification
            ],
            "externalRef" => "PPT" . uniqid(), // Auto-generate a unique transaction ID
            "consent" => "Y",
            "isCached" => "0", // Not cached
            "latitude" => $request->input('latitude'),
            "longitude" => $request->input('longitude')
        ]);

        // return response()->json($response->json());
        return view('user.account-verification.upi-response', [
            'response' => $response->json()
        ]);
    }
}
