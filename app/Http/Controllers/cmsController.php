<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class cmsController extends Controller
{
    public function generateUrl()
{
    // Define the API URL
    $url = 'https://sit.paysprint.in/service-api/api/v1/service/airtelcms/V2/airtel/index';

    $headers = [
        'Token' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJQQVlTUFJJTlQiLCJ0aW1lc3RhbXAiOjE2MTAwMjYzMzgsInBhcnRuZXJJZCI6IlBTMDAxIiwicHJvZHVjdCI6IldBTExFVCIsInJlcWlkIjoxNjEwMDI2MzM4fQ.buzD40O8X_41RmJ0PCYbBYx3IBlsmNb9iVmrVH9Ix64',
        'accept' => 'application/json',
        'content-type' => 'application/json',
    ];

    // Data to send
    $payload = [
        'refid' => 'string',
        'latitude' => 'string',
        'longitude' => 'string',
    ];

    // Make POST request
    $response = Http::withHeaders($headers)->post($url, $payload);

    // Handle the response
    if ($response->successful()) {
        return response()->json($response->json(), 200); // Success response
    } else {
        return response()->json(['error' => 'Request failed', 'details' => $response->body()], $response->status());
    }
}





public function checkCmsStatus()
{
    // API URL
    $url = 'https://sit.paysprint.in/service-api/api/v1/service/airtelcms/airtel/status';

    // Headers
    $headers = [
        'Token' => 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiJVRk13TURFNE9EWTNOREptWmpBNE1XTXlNV014WkRKaFpEQTBPVFF5WXpObE5qUTROelV5TVE9PSIsIm5hbWUiOiJQUzAwMTg4NiIsImlhdCI6MTczNjIyOTQ3MX0.WcboNmqdyk4D194AUE9AMzIoXOyG3sGew-YymvBpaQw',
        'accept' => 'application/json',
        'content-type' => 'application/json',
    ];

    // Data to send
    $payload = [
        'refid' => 'string',
    ];

    // Make POST request
    $response = Http::withHeaders($headers)->post($url, $payload);

    // Handle the response
    if ($response->successful()) {
        return response()->json($response->json(), 200); // Success response
    } else {
        return response()->json(['error' => 'Request failed', 'details' => $response->body()], $response->status());
    }
}
}
