<?php

namespace App\Http\Controllers;
use App\Models\addMoney;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class addMoneyController extends Controller
{
    public function storeSlip(Request $request)
    {
       // return $request; die();

$tds = $request->tds;
$charges = $request->charges;
$amount = $request->amount;

// Calculate charge amount
$chargeAmount = ($amount * $charges) / 100;

// Calculate TDS on the charge
$tdsAmount = ($chargeAmount * $tds) / 100;

// Total = Charge + TDS
$totalAmount = $amount-($chargeAmount + $tdsAmount);


//dd($tds,$charges,$amount,$chargeAmount,$tdsAmount,$totalAmount);die();
        // Validate the incoming request data
        // $request->validate([
        //     'bank' => 'required',
        //     'ifsc' => 'required|string',
        //     'account_no' => 'required|string',
        //     'amount' => 'required|numeric|min:1',
        //     'utr' => 'required|string|unique:transactions,utr',
        //     'date' => 'required|date',
        //     'mode' => 'required|string|in:IMPS,NEFT,RTGS,UPI,CASH',
        //     'slip_image.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        //     'remark' => 'nullable|string',
        // ]);
    
        // Store images to AWS S3
        $imagePaths = [];
        if ($request->hasFile('slip_image')) {
            foreach ($request->file('slip_image') as $file) {
                $path = $file->store('transactions/slips', 's3'); // Store on S3
                $imagePaths[] = Storage::disk('s3')->url($path); // Get the full URL
            }
        }
    
        // Insert data into the transactions table using DB facade
        DB::table('add_moneys')->insert([
            'request_by' => $request->input('rt_name'),
            'phone' => $request->input('rt_mobile'),
            'id_code' => $request->input('rt_id'),
            'bank_id' => $request->input('bank'),
            'ifsc' => $request->input('ifsc'),
            'account_no' => $request->input('account_no'),
            'totalAmount' => $request->input('amount'),
            'amount' => $totalAmount,
            'tds' => $tdsAmount,
            'charges' => $chargeAmount,
            'utr' => $request->input('utr'),
            'date' => $request->input('date'),
            'mode' => $request->input('mode'),
            'slip_images' => json_encode($imagePaths), // Store images as JSON
            'remark' => $request->input('remark'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    
        return redirect()->back()->with('success', 'Transaction added successfully!');
    }

    public function getFundRequests(Request $request)
{
    // Start the query
    $query = DB::table('add_moneys')->where('status',0);

    // Apply date filters if provided
    if ($request->start_date) {
        $query->whereDate('created_at', '>=', $request->start_date);
    }
    if ($request->end_date) {
        $query->whereDate('created_at', '<=', $request->end_date);
    }

    // Apply search filter if provided
    if ($request->search) {
        $query->where('column_name', 'like', '%' . $request->search . '%'); // Replace 'column_name' with the column you want to search
    }

    // Fetch results ordered by created_at in descending order
    $fundRequests = $query->orderBy('created_at', 'desc')->get();

    // Return view with filtered results
    return view('admin.wallet.fund-request', compact('fundRequests'));
}

public function getFundRequestsHistory(Request $request)
{
    // Start the query
    $query = DB::table('add_moneys')->whereIn('status', [1, -1]);


    // Apply date filters if provided
    if ($request->start_date) {
        $query->whereDate('created_at', '>=', $request->start_date);
    }
    if ($request->end_date) {
        $query->whereDate('created_at', '<=', $request->end_date);
    }

    // Apply search filter if provided
    if ($request->search) {
        $query->where('column_name', 'like', '%' . $request->search . '%'); // Replace 'column_name' with the column you want to search
    }

    // Fetch results ordered by created_at in descending order
    $fundRequests = $query->orderBy('created_at', 'desc')->get();

    // Return view with filtered results
    return view('admin.wallet.fund-requestHistory', compact('fundRequests'));
}
    
}
