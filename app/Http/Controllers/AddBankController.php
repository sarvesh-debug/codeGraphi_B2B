<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AddBank;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
class AddBankController extends Controller
{
    public function showForm()
    {
        return view('admin.addBank.add');
    }
public function dispalyQr()
{
    // $qrDetail = DB::table('qr_details')
    //         ->first();
    $qrDetail = DB::table('qr_details')
    ->orderBy('id', 'desc') // or orderBy('created_at', 'desc') if you have a timestamp
    ->first();

        // Check if the QR code exists in the database
        if (!$qrDetail) {
            return redirect()->route('qr.details')->with('error', 'QR code not found.');
        }

        // return $qrDetail;
        // die();
        // Return the view with the QR details
        return view('user.fund-transfer.qr', compact('qrDetail'));
    //return view('user.fund-transfer.qr');

}
    public function showFormQr()
    {
        return view('admin.addBank.qrCode');
    }
    public function store(Request $request)
    {
        
        $request->validate([
            'bank_name' => 'required|string',
            'ifsc' => 'required|string',
            'account_no' => 'required|string',
        ]);
// return $request;
// die();
DB::table('add_bank')->insert([
    'bank_name' => $request->bank_name,
    'ifsc' => $request->ifsc,
    'account_no' => $request->account_no,
    'created_at' => now(), // Include timestamps if your table uses them
    'updated_at' => now(),
]);


        return redirect()->route('bankdetails.form')->with('success', 'Bank details added successfully!');
    }

    public function edit($id)
    {
        // Fetch the record from the database
        $bankDetail = DB::table('add_bank')->where('id', $id)->first();

        // Pass the record to the view
        return view('admin.addBank.edit', compact('bankDetail'));
    }

    // Handle the update request
    public function update(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'bank_name' => 'required|string|max:255',
            'ifsc' => 'required|string|max:20',
            'account_no' => 'required|string|max:20',
        ]);

        // Update the record in the database
        DB::table('add_bank')->where('id', $id)->update([
            'bank_name' => $request->bank_name,
            'ifsc' => $request->ifsc,
            'account_no' => $request->account_no,
            'updated_at' => now(),
        ]);

        // Redirect back with a success message
        return redirect()->route('bankdetails.edit', $id)->with('success', 'Details updated successfully!');
    }
    public function getBankDetails()
{
    // Fetch all bank details from the 'add_Bank' table
    $bankDetails = \DB::table('add_Bank')->get(['id', 'bank_name', 'ifsc', 'account_no']);
    return view('user.fund-transfer.bank-account',compact('bankDetails'));
}


public function storeQr(Request $request)
    {
        // return $request;
        // die();
        // Validate the request
       // Validate the request
       $request->validate([
        'qrPic' => 'required|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    // Handle file upload to S3
    if ($request->hasFile('qrPic')) {
        $file = $request->file('qrPic');
        $path = $file->store('qr_codes', 's3'); // Upload to S3 bucket in 'qr_codes' folder

        // Make the file publicly accessible
        Storage::disk('s3')->setVisibility($path, 'public');

        // Get the public URL of the uploaded file
        $qrUrl = Storage::disk('s3')->url($path);

        // Insert into the database using DB facade
        DB::table('qr_details')->insert([
            'qr_pic' => $qrUrl,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'QR Code uploaded successfully to AWS S3.');
    }

    return redirect()->back()->with('error', 'QR Code upload failed. Please try again.');
}



}
