<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Exception;

class AepsPayoutController extends Controller
{
    public function index()
    {
        return view('user.AEPS.sattlementPage');
    }
public function submit(Request $request)
{
    $CGAPI      = env('CGAPIww', "1234567");
    $phone      = session('mobile');
    $userid     = session('username');
    $accountNo  = session('accountNo');
    $ifsc       = session('ifsc');
    $name       = session('bankName');
    $mode       = "IMPS";
    $purpose    = "OTHERS";
    $remark     = $request->remark ?? "CodeGraphi";
    $amount     = $request->amount;

    // Validate
    if (!$phone || !$userid || !$accountNo || !$ifsc || !$name || !$amount) {
        return response()->json(['status' => false, 'message' => 'Missing session or input data.'], 400);
    }

    $aepsWallet = DB::table('customer')
        ->where('phone', $phone)
        ->where('username', $userid)
        ->value('aepsWallet');

    if ($aepsWallet === null) {
       // return response()->json(['status' => false, 'message' => 'Customer not found.'], 404);
       return back()->with('error', 'Customer not found.');

    }

    $availableBalance = $aepsWallet - 50;

    if ($availableBalance < $amount) {
       // return response()->json(['status' => false, 'message' => 'Insufficient AEPS balance.'], 400);
       return back()->with('error', 'Insufficient AEPS balance.');

    }

    // Charges calculation
    $charges = 0;
    $tds = 0;

    if ($amount >= 100 && $amount < 1000) {
        $charges = 3;
        $tds = $charges * 0.02;
    } elseif ($amount >= 1000 && $amount < 25000) {
        $charges = 5;
        $tds = $charges * 0.10;
    } elseif ($amount >= 25000 && $amount < 200000) {
        $charges = 8;
        $tds = $charges * 0.10;
    }

    $deductAmount = $amount + $charges + $tds;
    $externalRef = 'TXN' . date('Y') . substr(round(microtime(true) * 1000), -6);

    try {
        DB::beginTransaction();

        // Insert transaction
        DB::table('aepssatlemet')->insert([
            'userId'        => $userid,
            'phone'         => $phone,
            'amount'        => $amount,
            'remark'        => $remark,
            'charges'       => $charges,
            'tds'           => $tds,
            'externalRef'  => $externalRef,
            'responseBody'  => json_encode([]), // ✅ use empty JSON object
    'requestBody'   => json_encode([]), // ✅ use empty JSON object
            'status'        => "PENDING",
            'opBalance'     => 0,
            'cpBalance'     => 0,
            'created_at'    => now(),
            'updated_at'    => now(),
        ]);

        // Prepare payload
        $payload = [
            "payer" => [
                "bankProfileId" => "0",
                "accountNumber" => "9310207621"
            ],
            "payee" => [
                "name"          => $name,
                "accountNumber" => $accountNo,
                "bankIfsc"      => $ifsc,
            ],
            "transferMode"   => $mode,
            "transferAmount" => $amount,
            "externalRef"    => $externalRef,
            "latitude"       => $request->latitude,
            "longitude"      => $request->longitude,
            "remarks"        => $remark,
            "purpose"        => $purpose,
            "otp"            => "",
            "otpReference"   => "",
            "CGAPI"          => $CGAPI
        ];

        $response = Http::withHeaders([
            'Accept'       => 'application/json',
            'Content-Type' => 'application/json',
        ])->post('http://127.0.0.1:8081/api/cgap/payout/initiate', $payload);

        DB::table('aepssatlemet')
            ->where('externalRef', $externalRef)
            ->update([
                'responseBody' => json_encode($response->json()),
                'requestBody'  => json_encode($payload)
            ]);

        DB::commit();

        return response()->json([
            'status'  => true,
            'message' => 'Payout Initiated',
            'ref'     => $externalRef,
            'data'    => $response->json()
        ]);

    } catch (Exception $e) {
        DB::rollBack();

        return response()->json([
            'status'  => false,
            'message' => 'Something went wrong during payout.',
            'error'   => $e->getMessage()
        ], 500);
     }
}
}
