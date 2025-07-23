<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;

use App\Models\CMSTransaction;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CMSTransactionExport;
use PDF;

class CMSGUIController extends Controller
{
    public function showForm()
    {
        return view('user.cms.form');
    }

    public function submitStart(Request $request)
{
    $refid = 'CMS' . rand(10000000, 99999999);
    $CGAPI = env('cgapi');

    $data = [
        'CGAPI'     => $CGAPI,
        'refid'     => $refid,
        'latitude'  => $request->latitude,
        'longitude' => $request->longitude,
    ];
//return $data;die();
$url=env('API_URL').'/cms/start';
    $response = Http::post($url, $data);
    $json = $response->json();

    CMSTransaction::updateOrCreate(
        ['refid' => $refid],
        array_merge($data, ['status' => 'started', 'event' => 'CMS_STARTED','retailer_id'=>session('username')])
    );

    if (!empty($json['redirectionUrl']) && $json['status'] === true) {
        return redirect()->away($json['redirectionUrl']);
    }

    return back()->with('response', $json);
}

    public function submitStatus(Request $request)
    {
        $url=env('API_URL').'/cms/status';   
        $response = Http::post($url, [
            'refid' => $request->refid
        ]);

        return $response;die();
        return back()->with('response', $response->json());
    }

    public function handleCallback(Request $request)
    {
        $event = $request->event;
        $param = $request->param;

        $data = [
            'event' => $event,
            'amount' => $param['amount'] ?? null,
            'biller_id' => $param['biller_id'] ?? null,
            'biller_name' => $param['biller_name'] ?? null,
            'mobile_no' => $param['mobile_no'] ?? null,
            'commission' => $param['commission'] ?? null,
            'utr' => $param['utr'] ?? null,
            'ackno' => $param['ackno'] ?? null,
            'unique_id' => $param['unique_id'] ?? null,
            'status' => $param['status'] ?? null,
            'errormsg' => $param['errormsg'] ?? null,
            'datetime' => $param['datetime'] ?? now(),
        ];

        CMSTransaction::updateOrCreate(
            ['refid' => $param['refid']],
            $data
        );

        return response()->json(['status' => true, 'message' => 'Callback handled']);
    }

    public function adminTransactions(Request $request)
    {
        $query = CMSTransaction::query();

        if ($request->refid) {
            $query->where('refid', 'like', "%{$request->refid}%");
        }

        if ($request->event) {
            $query->where('event', $request->event);
        }

        $transactions = $query->latest()->paginate(20);

        return view('user.cms.admin', compact('transactions'));
    }

    public function exportExcel()
    {
        return Excel::download(new CMSTransactionExport, 'cms_transactions.xlsx');
    }

    public function exportPDF()
    {
        $transactions = CMSTransaction::all();
        $pdf = PDF::loadView('cms.pdf', compact('transactions'));
        return $pdf->download('cms_transactions.pdf');
    }
}
