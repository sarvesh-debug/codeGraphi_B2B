<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DigifintelService
{
    protected $baseUrl;
    protected $email;
    protected $password;
    protected $userKey;
    protected $ip;

    public function __construct()
    {
        $this->baseUrl = config('services.digifintel.base_url');
        $this->email = config('services.digifintel.email');
        $this->password = config('services.digifintel.password');
        $this->userKey = config('services.digifintel.userkey');
        $this->ip = request()->ip();
    }

    public function getAccessToken()
    {
       //return $this->baseUrl;die;
        $response = Http::asForm()->post("https://api.digifintel.com/api/login", [
            'email' => $this->email,
            'password' => $this->password,
        ]);
       //return $response;die();
        if ($response->successful()) {
            return $response->json('token');
        }

        // throw new \Exception('Unable to authenticate');
    }

    private function generateChecksum($amount, $referenceId, $timestamp, $email)
    {
        $raw = $amount . $referenceId . $this->userKey . $timestamp . $email;
        return hash('sha512', $raw);
    }
 private function generateChecksumVPA( $referenceId, $timestamp, $email)
    {
        $raw = $referenceId . $this->userKey . $timestamp . $email;
        return hash('sha512', $raw);
    }
    // Step 1: Generate Token - Done in getAccessToken()

    // Step 2: Create Order
    public function createOrder($amount, $customerEmail, $customerPhone)
    {
       //return $this->userKey;die();
        //dd($amount,$customerEmail,$customerPhone);
        $referenceId = 'REF' . time();
        $timestamp = now()->format('d-m-Y H:i:s');
        $checksum = $this->generateChecksum($amount, $referenceId, $timestamp, $this->email);

        $payload = [
            'referenceId' => $referenceId,
            'amount' => $amount,
            'customerEmail' => $customerEmail,
            'customerPhone' => $customerPhone,
            'terminalType' => 'WEB',
            'expiryTime' => 5,
            'timestamp' => $timestamp,
            'checksum' => $checksum,
        ];
//dd($payload);
 //dd($this->baseUrl.'/pg/upiintent/create/order',$this->getHeaders(),$payload);
        $response = Http::withHeaders($this->getHeaders())
            ->post("{$this->baseUrl}api/pg/upiintent/create/order", $payload);
            
           // dd($this->baseUrl.'/pg/upiintent/create/order',$this->getHeaders(),$payload,$response);
//dd($response);
     return [
    'referenceId' => $referenceId,
    'response' => $response->json(),
];
    }

    // Step 3: Pay Order
    public function payOrder($amount, $referenceId, $payerVpa, $payerName, $remarks)
    {


       // dd($amount,$referenceId,$payerName,$payerVpa,$remarks);
        $timestamp = now()->format('d-m-Y H:i:s');
        $checksumVPA = $this->generateChecksumVPA( $referenceId, $timestamp, $this->email);
        $checksum = $this->generateChecksum($amount, $referenceId, $timestamp, $this->email);

        // $payload = [
        //     'amount' => $amount,
        //     'referenceId' => $referenceId,
        //     'timestamp' => $timestamp,
        //     'payerVpa' => $payerVpa,
        //     'payerName' => $payerName,
        //     'remarks' => $remarks,
        //     'checksum' => $checksum,
        // ];
        $payload = [
            'referenceId' => $referenceId,
            'timestamp' => $timestamp,
            'payerVpa' => $payerVpa,
            'checksum' => $checksumVPA,
        ];

        $responseVPA = Http::withHeaders($this->getHeaders())
            ->post("{$this->baseUrl}api/pg/verify-vpa", $payload);
        $data=$responseVPA->json();
            $payerNameVPA=$data['name'] ?? $payerName;

              $payload = [
            'amount' => $amount,
            'referenceId' => $referenceId,
            'timestamp' => $timestamp,
            'payerVpa' => $payerVpa,
            'payerName' => $payerNameVPA,
            'remarks' => $remarks,
            'checksum' => $checksum,
        ];
        $response = Http::withHeaders($this->getHeaders())
            ->post("{$this->baseUrl}api/pg/upiintent/payorder", $payload);
    //dd($this->baseUrl.'/pg/upiintent/payorder',$this->getHeaders(),$payload,$response);
        return $response->json();
    }

    // Step 4: Check Order Status
    public function checkOrderStatus($referenceId)
    {
        $timestamp = now()->format('d-m-Y H:i:s');
        $checksum = $this->generateChecksum('0.00', $referenceId, $timestamp, $this->email);

        $payload = [
            'referenceId' => $referenceId,
            'timestamp' => $timestamp,
            'checksum' => $checksum,
        ];

        $response = Http::withHeaders($this->getHeaders())
            ->post("{$this->baseUrl}api/pg/upiintent/check-order-status", $payload);

        return $response->json();
    }

    // Step 5: Payment UPI Intent
    public function payIntent($amount, $referenceId, $payerName, $remarks)
    {
        $timestamp = now()->format('d-m-Y H:i:s');
        $checksum = $this->generateChecksum($amount, $referenceId, $timestamp, $this->email);

        $payload = [
            'amount' => $amount,
            'referenceId' => $referenceId,
            'timestamp' => $timestamp,
            'payerName' => $payerName,
            'remarks' => $remarks,
            'checksum' => $checksum,
        ];

        $response = Http::withHeaders($this->getHeaders())
            ->post("{$this->baseUrl}api/pg/upiintent/pay-intent", $payload);

        return $response->json();
    }

    // Step 6: Check UPI Intent Status
    public function checkIntentStatus($referenceId)
    {
        $timestamp = now()->format('d-m-Y H:i:s');
        $checksum = $this->generateChecksum('0.00', $referenceId, $timestamp, $this->email);

        $payload = [
            'referenceId' => $referenceId,
            'timestamp' => $timestamp,
            'checksum' => $checksum,
        ];

        $response = Http::withHeaders($this->getHeaders())
            ->post("{$this->baseUrl}api/pg/upiintent/check-intent-status", $payload);

        return $response->json();
    }

    private function getHeaders()
    {
        return [
            'Authorization' => 'Bearer ' . $this->getAccessToken(),
            'userkey' => $this->userKey,
            'HTTP_X_FORWARDED_FOR' => $this->ip,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }
}
