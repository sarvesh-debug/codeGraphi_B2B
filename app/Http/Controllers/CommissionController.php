<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomerModel;
use App\Models\Commission;
use Illuminate\Support\Facades\DB;
class CommissionController extends Controller
{
    public function showForm()
    {
        $customers = CustomerModel::where('pin', '!=', 0)->get();
        //return $customers;
    return view('admin.commissionPlans.addCommission', compact('customers'));
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'service' => 'required|string',
            'packages' => 'required|string',
            'sub_service' => 'nullable|string',
            'from_amount' => 'required|numeric|min:0',
            'to_amount' => 'required|numeric|gte:from_amount',
            'charge' => 'required|numeric|min:0',
            'commission' => 'required|numeric|min:0',
            'tds' => 'required|numeric|min:0',
            'charge_in' => 'required|string|in:Flat,Percentage',
            'commission_in' => 'required|string|in:Flat,Percentage',
            'tds_in' => 'required|string|in:Flat,Percentage',
            'packegesId' =>'required',
        ]);
// return $request;
// die();
        try {
            // Store data using the query builder
            $inserted = DB::table('commission_plan')->insert([
                'service' => $validatedData['service'],
                'packages' => $validatedData['packages'],
                'sub_service' => $validatedData['sub_service'] ?? null, // Only store sub_service if provided
                'from_amount' => $validatedData['from_amount'],
                'to_amount' => $validatedData['to_amount'],
                'charge' => $validatedData['charge'],
                'commission' => $validatedData['commission'],
                'tds' => $validatedData['tds'],
                'charge_in' => $validatedData['charge_in'],
                'commission_in' => $validatedData['commission_in'],
                'tds_in' => $validatedData['tds_in'],
                'packegesId' => $validatedData['packegesId'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Check if the insertion was successful
            if ($inserted) {
                return redirect()->back()->with('success', 'Commission plan added successfully!');
            } else {
                return redirect()->back()->with('error', 'Failed to add commission plan. Please try again.');
            }
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Error inserting commission plan: ' . $e->getMessage());

            return redirect()->back()->with('error', 'An unexpected error occurred. Please try again.');
        }
    }

//     public function store(Request $request)
//     {
//         // return $request;
//         // die();

//  // Validate the request data
//  $request->validate([
//     'service' => 'required|string',
//     'from_amount' => 'required|numeric|min:0',
//     'to_amount' => 'required|numeric|gte:from_amount',
//     'charge' => 'required|numeric|min:0',
//     'commission' => 'required|numeric|min:0',
//     'tds' => 'required|numeric|min:0',
//     'charge_in' => 'required|string|in:Flat,Percentage',
//     'commission_in' => 'required|string|in:Flat,Percentage',
//     'tds_in' => 'required|string|in:Flat,Percentage',
// ]);
// //   return $request;
// //         die();
// // Store the data in the database
// try {
//     DB::table('commission_plans')->insert([
//         'service' => $request->service,
//         'from_amount' => $request->from_amount,
//         'to_amount' => $request->to_amount,
//         'charge' => $request->charge,
//         'commission' => $request->commission,
//         'tds' => $request->tds,
//         'charge_in' => $request->charge_in,
//         'commission_in' => $request->commission_in,
//         'tds_in' => $request->tds_in,
//         'created_at' => now(),
//         'updated_at' => now(),
//     ]);


//     // Redirect with success message
//     return redirect()->back()->with('success', 'Commission plan added successfully!');
// } catch (\Exception $e) {
//     // Handle exceptions and redirect with error message
//     return redirect()->back()->with('error', 'Failed to add commission plan. Please try again.');
// }


//         // $validated = $request->validate([
//         //     'customer_id' => 'required|exists:customer,id',
//         //     'rtgs_commission' => 'required|numeric|min:0',
//         //     'imps_commission' => 'required|numeric|min:0',
//         //     'neft_commission' => 'required|numeric|min:0',
//         //     'aeps_commission' => 'required|numeric|min:0',
//         // ]);
    
//         // // Check if a commission already exists for the customer
//         // $existingCommission = Commission::where('customer_id', $validated['customer_id'])->first();
    
//         // if ($existingCommission) {
//         //     return redirect()->back()->withErrors([
//         //         'customer_id' => 'Commission already exists for this customer.',
//         //     ]);
//         // }
    
//         // // Save the commission
//         // Commission::create([
//         //     'customer_id' => $validated['customer_id'],
//         //     'rtgs_commission' => $validated['rtgs_commission'],
//         //     'imps_commission' => $validated['imps_commission'],
//         //     'neft_commission' => $validated['neft_commission'],
//         //     'aeps_commission' => $validated['aeps_commission'],
//         // ]);
    
//         // return redirect()->back()->with('success', 'Commission saved successfully!');
//     }

public function index($packageId)
{
    // If you're filtering commissions based on the package ID:
    // $commissions = DB::table('commission_plan')
    //                 ->where('packegesId', $packageId)
    //                 ->get();
//  
//$packageId = 6;
// $commissions = DB::table('commission_plan as cp')
//     ->join('commissionservices as cs', DB::raw('cp.service COLLATE utf8mb4_general_ci'), '=', DB::raw('cs.serviceName COLLATE utf8mb4_general_ci'))
//     ->where('cp.packegesId', $packageId)
//     ->select('cp.*', 'cs.serviceName', 'cs.CommCode')
//     ->get();


// dd($commissions);

$commissions = DB::select("
    SELECT 
        cp.*, 
        cs.serviceName, 
        cs.CommCode
    FROM 
        commission_plan AS cp
    JOIN 
        commissionservices AS cs 
        ON BINARY cp.service = BINARY cs.CommCode
    WHERE 
        cp.packegesId = ?
", [$packageId]);

 //return $commissions;die();

    return view('admin.commissionPlans.index', compact('commissions', 'packageId'));
}

public function indexRT($packageId)
{
    
    // If you're filtering commissions based on the package ID:
    // $commissions = DB::table('commission_plan')
    //                 ->where('packegesId', $packageId)
    //                 ->get();
    $commissions = DB::select("
    SELECT 
        cp.*, 
        cs.serviceName, 
        cs.CommCode
    FROM 
        commission_plan AS cp
    JOIN 
        commissionservices AS cs 
        ON BINARY cp.service = BINARY cs.CommCode
    WHERE 
        cp.packegesId = ?
", [$packageId]);

    return view('user.packages.createCommission', compact('commissions', 'packageId'));
}

public function edit($id)
{

     // Fetch commission plan using the query builder
     $commission = DB::table('commission_plan')->where('id', $id)->first();

   
     return view('admin.commissionPlans.edit', compact('commission'));
    
  
}

public function update(Request $request, $id){
    // return $request;
    // die();
    $validated = $request->validate([
        'service' => 'required|string',
        'packages' => 'required|string',
        'sub_service' => 'nullable|string',
        'from_amount' => 'required|numeric|min:0',
        'to_amount' => 'required|numeric|gte:from_amount',
        'charge' => 'required|numeric|min:0',
        'commission' => 'required|numeric|min:0',
        'tds' => 'required|numeric|min:0',
        'charge_in' => 'required|string|in:Flat,Percentage',
        'commission_in' => 'required|string|in:Flat,Percentage',
        'tds_in' => 'required|string|in:Flat,Percentage',
        'packegesId'=>'required',
    ]);

    // Use query builder to update the record in the database
    $updated = DB::table('commission_plan')->where('id', $id)->update([
        'service' => $validated['service'],
        'packages' => $validated['packages'],
        'sub_service' => $validated['sub_service'] ?? null, // Only update if sub_service is provided
        'from_amount' => $validated['from_amount'],
        'to_amount' => $validated['to_amount'],
        'charge' => $validated['charge'],
        'commission' => $validated['commission'],
        'tds' => $validated['tds'],
        'charge_in' => $validated['charge_in'],
        'commission_in' => $validated['commission_in'],
        'tds_in' => $validated['tds_in'],
        'packegesId' => $validated['packegesId'],
        'updated_at' => now(),
    ]);

    // Check if the update was successful
    if ($updated) {
       return redirect()->route('commission-list', ['packageId' => $validated['packegesId']])
                 ->with('success', 'Commission updated successfully!');

    } else {
       return redirect()->route('commission-list', ['packageId' => $validated['packegesId']])
                 ->with('error', 'Failed to update commission plan.');

    }

}


public function getAllCommission()
{

    $role=session('role');
    $packageId=session('packageId');
     $aeps = DB::table('commission_plan')->where('service', 'AEPS')->where('packages',$role)->get();
     $neft = DB::table('commission_plan')->where('service', 'DMT')->where('packages',$role)->get();
     $fund = DB::table('commission_plan')->where('service', 'FundTransfer')->where('packages',$role)->get();

$all = DB::select("
    SELECT 
        cp.*, 
        cs.serviceName, 
        cs.CommCode
    FROM 
        commission_plan AS cp
    JOIN 
        commissionservices AS cs 
        ON BINARY cp.service = BINARY cs.CommCode
    WHERE 
        cp.packegesId = ? 
        AND cp.packages = ?
", [$packageId, $role]);

    //  $all = DB::table('commission_plan')->where('packages',$role)->where('packegesId',session('packageId'))->get();
   
  // return $commissions;die();
     return view('user.commission-plan', compact('aeps','neft','fund','all'));
    
  
}


public function destroy($id)
{
    // Delete the record directly using the table name
    DB::table('commission_plan')->where('id', $id)->delete();

    return redirect()->route('commission-list')->with('success', 'Commission deleted successfully.');
}

public function addMapCommissionData(Request $request){
    // return $request;
    // die();
    // Validate the request data
    $validatedData = $request->validate([
        'service' =>'required',
        'from_rt_count' => 'required|numeric|min:0',
        'to_rt_count' => 'required|numeric|min:0',
        'charge_in' => 'required|string|in:Flat,Percentage',
        'charge' => 'required|numeric|min:0',
        'commission_in' => 'required|string|in:Flat,Percentage',
        'commission' => 'required|numeric|min:0',
        'tds_in' => 'required|string|in:Flat,Percentage',
        'tds' => 'required|numeric|min:0',
    ]);
    // return $validatedData;
    // die();
    try {
        // Store data using the query builder
        $inserted = DB::table('map_commission_plan')->insert([
            'service'=>$validatedData['service'],
            'from_rt_count' => $validatedData['from_rt_count'],
            'to_rt_count' => $validatedData['to_rt_count'],
            'charge_in' => $validatedData['charge_in'],
            'charge' => $validatedData['charge'],
            'commission_in' => $validatedData['commission_in'],
            'commission' => $validatedData['commission'],
            'tds_in' => $validatedData['tds_in'],
            'tds' => $validatedData['tds'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
   
        // Check if the insertion was successful
        if ($inserted) {
            return redirect()->back()->with('success', 'Map Commission plan added successfully!');
        } else {
            return redirect()->back()->with('error', 'Failed to add Map Commission Plan. Please try again.');
        }
    } catch (\Exception $e) {
        // Log the error for debugging
        \Log::error('Error inserting commission plan: ' . $e->getMessage());

        return redirect()->back()->with('error', 'An unexpected error occurred. Please try again.');
    }  
}

public function displayMapCommission(){
    $commissions = DB::table('map_commission_plan')->get();
    return view('admin.commissionPlans.mapCommission', compact('commissions'));
}

public function mapCommissionDestroy($id){
    DB::table('map_commission_plan')->where('id', $id)->delete();
    return redirect()->route('map-commission')->with('success', 'Commission deleted successfully.');
}

public function mapCommissionUpdate(Request $request, $id){
    $request->validate([
        'service' =>'required',
        'from_rt_count' => 'required|numeric',
        'to_rt_count' => 'required|numeric',
        'charge_in' => 'required',
        'charge' => 'required|numeric',
        'commission_in' => 'required',
        'commission' => 'required|numeric',
        'tds_in' => 'required',
        'tds' => 'required|numeric',
    ]);

    $updated = DB::table('map_commission_plan')->where('id', $id)->update([
        'service'=>$request->service,
        'from_rt_count' => $request->from_rt_count,
        'to_rt_count' => $request->to_rt_count,
        'charge_in' => $request->charge_in,
        'charge' => $request->charge,
        'commission_in' => $request->commission_in,
        'commission' => $request->commission,
        'tds_in' => $request->tds_in,
        'tds' => $request->tds,
    ]);

    if ($updated) {
        return redirect()->route('map-commission')->with('success', 'Map Commission updated successfully!');
    } else {
        return redirect()->route('map-commission')->with('error', 'Failed to update map commission plan.');
    }
}


}
