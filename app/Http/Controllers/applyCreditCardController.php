<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\LeadLink;
class applyCreditCardController extends Controller
{
    public function generateLead()
{
   // return "Hello";die();
    $refid = 'REF' . strtoupper(uniqid());
    $cgapi = env('cgapi');
    $merchantCode = 'A002';
    $url=env('API_URL').'/lead/generate';
    //return $url;die();
    $response = Http::withHeaders([
        'Accept' => 'application/json',
        'Content-Type' => 'application/json',
    ])->post($url, [
        'refid' => $refid,
        'CGAPI' => $cgapi,
        'merchantcode' => $merchantCode,
    ]);

    $res = $response->json();
//return $res;die();
    if (
        isset($res['response']['status']) &&
        $res['response']['status'] === 201 &&
        isset($res['response']['body']['status']) &&
        $res['response']['body']['status'] === true
    ) {
        $link = $res['response']['body']['data']['link'];
        $requestId = $res['response']['body']['data']['request_id'];

        // Save to DB
        LeadLink::create([
            'refid' => $refid,
            'request_id' => $requestId,
            'link' => $link,
            'retailer_id'=>session('username'),
            'mobile' =>session('mobile'),
            'name'=>session('user_name')
        ]);

        // Redirect user to the external link
        return redirect()->away($link);
    }

    return back()->with('error', 'Failed to generate lead link.');
}

public function viewLeads()
{
    $leads = LeadLink::orderBy('created_at', 'desc')->where('retailer_id',session('username'))->get(); // with pagination
  $applications=$leads;
    return view('user.applyCreditCard.index', compact('leads'));
}
}
