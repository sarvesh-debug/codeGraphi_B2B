<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
class prePaidRechargeController extends Controller
{
    public function getISP()
    {
        // return "hello";
        // die();
        // Make the API call
        $customerOutletId = intval(session('outlet'));
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        //])->post('http://127.0.0.1:8000/api/v1/prepaid/mobileRecharge', [
         ])->post(env('liveUrl').'v1/prepaid/mobileRecharge', [

            'outlet' =>$customerOutletId
        ]);
    return $response;
    die();
        if ($response->successful()) {
            $responseData = $response->json();
            return $responseData;
        } else {
            // Return an error message if the API call fails
            return response()->json(['error' => 'Failed to retrieve  data.'], 500);
        }
    }
}
