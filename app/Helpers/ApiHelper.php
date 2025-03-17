<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class ApiHelper
{
    public static function getBalance($email)
    {
        $apiUrl = env('API_URL') . '/customer/wallet';
        $response = Http::get($apiUrl, ['email' => $email]);

        if ($response->successful()) {
            return $response->json() ?? 0;
        }

        return null; // Return null if API call fails
    }

    public static function increaseBalance($email, $amount, $service)
    {
        $apiUrl = env('API_URL') . '/customer/increase-balance';

        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post($apiUrl, [
                'email' => $email,
                'amount' => $amount,
                'service' => $service,
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            return [
                'error' => true,
                'message' => 'API request failed',
                'status' => $response->status(),
            ];
        } catch (\Exception $e) {
            return [
                'error' => true,
                'message' => 'Exception: ' . $e->getMessage(),
            ];
        }
    }

    public static function decreaseBalance($email, $amount, $service)
    {
        
        $apiUrl = env('API_URL') . '/customer/decrease-balance';

        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])->post($apiUrl, [
                'email' => $email,
                'amount' => $amount,
                'service' => $service,
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            return [
                'error' => true,
                'message' => 'API request failed',
                'status' => $response->status(),
            ];
        } catch (\Exception $e) {
            return [
                'error' => true,
                'message' => 'Exception: ' . $e->getMessage(),
            ];
        }
    }



}
