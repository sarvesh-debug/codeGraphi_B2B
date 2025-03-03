<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
class BinCheckerController extends Controller
{
    public function index()
    {
        // Show the form
        return view('user.cardchecker.index');
    }

    public function checkBin(Request $request)
    {
        // Validate the input
        $request->validate([
            'binNumber' => 'required|string',
            'latitude' => 'required|string',
            'longitude' => 'required|string',
        ]);

        // Generate a unique external reference
        $externalRef = uniqid( true);

        // Prepare the data
        $data = [
            "binNumber" => $request->input('binNumber'),
            "latitude" => $request->input('latitude'),
            "longitude" => $request->input('longitude'),
            "externalRef" => $externalRef,
        ];
        $customerOutletId = intval(session('outlet')); // 'pin' holds the customer's name
        // Set up the Guzzle client
        $client = new Client();
        $response = $client->post('https://api.instantpay.in/identity/binChecker', [
            'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',

                'X-Ipay-Auth-Code' => env('IPAY_AUTH_CODE'),
                'X-Ipay-Client-Id' => env('IPAY_CLIENT_ID'),
                'X-Ipay-Client-Secret' => env('IPAY_CLIENT_SECRET'),
                'X-Ipay-Endpoint-Ip' => env('IPAY_ENDPOINT_IP'),
                'X-Ipay-Outlet-Id' => $customerOutletId, // Use Outlet ID from env or another source if needed
            ],
            'json' => $data,
        ]);

        $responseBody = json_decode($response->getBody(), true);

        // Return the result to a view
        //return response()->json($data);
        return view('user.cardchecker.response', ['result' => $responseBody]);
    }
}
