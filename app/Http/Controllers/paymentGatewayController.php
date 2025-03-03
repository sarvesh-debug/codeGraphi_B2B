<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class paymentGatewayController extends Controller
{
    public function index()
    {
        return view('user/fund-transfer.payment-gateway');
    }
    public function processPayment(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'txnAmount' => 'required|numeric',
            'customerName' => 'required|string|max:255',
            'customerMobile' => 'required|string|max:10',
            'customerEmail' => 'required|email',
        ]);

        $key = config('api.payment_gateway_key'); // Your Api Token https://merchant.upigateway.com/user/api_credentials
        $post_data = [
            'key' => $key,
            'client_txn_id' => (string) rand(100000, 999999), // you can use this field to store order id;
            'amount' => $request->input('txnAmount'),
            'p_info' => 'product_name',
            'customer_name' => $request->input('customerName'),
            'customer_email' => $request->input('customerEmail'),
            'customer_mobile' => $request->input('customerMobile'),
            'redirect_url' => route('payment.redirect'),
            'udf1' => 'extradata',
            'udf2' => 'extradata',
            'udf3' => 'extradata'
        ];

        $response = Http::post('https://api.ekqr.in/api/create_order', $post_data);

        $result = $response->json();

        if ($result['status'] == true) {
            return redirect($result['data']['payment_url']);
        }

        return back()->withErrors(['msg' => $result['msg']]);
    }

    public function paymentRedirect(Request $request)
    {
        // Handle the redirection after payment
        $client_txn_id = $request->input('client_txn_id');
        $txn_id = $request->input('txn_id');
        
        // Process transaction result
        return view('user/fund-transfer.payment-gateway-success', compact('client_txn_id', 'txn_id'));
    }

    public function checkOrderStatus(Request $request)
{
    $txn_data = null;
    $echo = "";

    if ($request->has('client_txn_id')) {
        $key = config('api.payment_gateway_key'); // Your API Token
        $post_data = new \stdClass();
        $post_data->key = $key;
        $post_data->client_txn_id = $request->input('client_txn_id');
        $post_data->txn_date = date("d-m-Y");

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://api.ekqr.in/api/check_order_status',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($post_data),
            CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
        ]);
        $response = curl_exec($curl);
        curl_close($curl);

        $result = json_decode($response, true);

        if ($result['status'] == true) {
            $txn_data = $result['data'];
        }
    }

    return view('user/fund-transfer.payment-gateway-success', compact('txn_data'));
}

}
