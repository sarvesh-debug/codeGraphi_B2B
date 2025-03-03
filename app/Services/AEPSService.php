<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class AEPSService
{
    protected $baseUrl;
    protected $apiKey;
    protected $apiSecret;
    protected $agentId;
    protected $client;

    public function __construct()
    {
        $this->baseUrl = env('INSTANTPAY_AEPS_BASE_URL');
        $this->apiKey = env('INSTANTPAY_AEPS_KEY');
        $this->apiSecret = env('INSTANTPAY_AEPS_SECRET');
        $this->agentId = env('INSTANTPAY_AEPS_AGENT_ID');
        $this->client = new Client();
    }

    /**
     * Make a POST request to InstantPay AEPS API
     */
    protected function post($endpoint, $data)
    {
        $headers = [
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type' => 'application/json',
        ];

        try {
            $response = $this->client->post($this->baseUrl . $endpoint, [
                'headers' => $headers,
                'json' => array_merge($data, [
                    'agent_id' => $this->agentId,
                    'api_secret' => $this->apiSecret,
                ])
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            Log::error("AEPS API Error: " . $e->getMessage());
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    /**
     * Example: Balance Inquiry API
     */
    public function balanceInquiry($aadhaarNumber, $bankIIN)
    {
        $data = [
            'aadhaar_number' => $aadhaarNumber,
            'bank_iin' => $bankIIN,
        ];

        return $this->post('balance-inquiry', $data);
    }

    /**
     * Example: Cash Withdrawal API
     */
    public function cashWithdrawal($aadhaarNumber, $amount, $bankIIN)
    {
        $data = [
            'aadhaar_number' => $aadhaarNumber,
            'amount' => $amount,
            'bank_iin' => $bankIIN,
        ];

        return $this->post('cash-withdrawal', $data);
    }
}
