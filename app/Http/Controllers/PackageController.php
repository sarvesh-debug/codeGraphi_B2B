<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PackageController extends Controller
{

      public function index()
    {
        
        $packages = DB::table('packages')->get();
        return view('admin.packages.index', compact('packages'));
    }
   public function create()
    {
        return view('admin.packages.create');
    }

   public function store(Request $request)
{
    // Validate input
    $validated = $request->validate([
        'packageName' => 'required|string|max:255',
        'status' => 'required|boolean',
        'created_by' => 'required',
        'creater_id' => 'required',
    ]);

    // Try to insert data into the database
    try {
        $inserted = DB::table('packages')->insert([
            'packageName' => $validated['packageName'],
            'status' => $validated['status'],
            'created_by' => $validated['created_by'],
            'creater_id' => $validated['creater_id'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        if ($inserted) {
            return redirect()->route('packages.index')->with('success', 'Package created successfully.');
        } else {
            return back()->withInput()->with('error', 'Failed to create package. Please try again.');
        }
    } catch (\Exception $e) {
        // Log the error for debugging (optional)
        \Log::error('Package Insert Error: ' . $e->getMessage());

        return back()->withInput()->with('error', 'Something went wrong. Please try again.');
    }
}

public function edit($id)
{
try {
$package = DB::table('packages')->where('id', $id)->first();
 if (!$package) {
            return redirect()->route('packages.index')->with('error', 'Package not found.');
        }

        return view('admin.packages.edit', compact('package'));
    } catch (\Exception $e) {
        return redirect()->route('packages.index')->with('error', 'An error occurred while loading the package.');
    }
}

public function update(Request $request, $id)
{
    $request->validate([
        'packageName' => 'required|string|max:255',
        'status' => 'required|in:0,1',
        'created_by' => 'required',
        'creater_id' => 'required',
    ]);

    try {
        $affected = DB::table('packages')
            ->where('id', $id)
            ->update([
                'packageName' => $request->input('packageName'),
                'status' => $request->input('status'),
                'created_by' => $request->input('created_by'),
                'creater_id' => $request->input('creater_id'),
                'updated_at' => now()
            ]);

        if ($affected === 0) {
            return redirect()->back()->with('warning', 'No changes made or package not found.');
        }

        return redirect()->route('packages.index')->with('success', 'Package updated successfully.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Failed to update package. Error: ' . $e->getMessage());
    }
}



//RT
  public function indexRT()
    {
        //return "Helo";die();
        $id=session('username');
        
        $packages = DB::table('packages')->where('creater_id',$id)->get();
        return view('user.packages.index', compact('packages'));
    }
   public function createRT()
    {
        return view('user.packages.add');
    }

   public function storeRT(Request $request)
{
    // Validate input
    $validated = $request->validate([
        'packageName' => 'required|string|max:255',
        'status' => 'required|boolean',
        'created_by' => 'required',
        'creater_id' => 'required',
    ]);

    // Try to insert data into the database
    try {
        $inserted = DB::table('packages')->insert([
            'packageName' => $validated['packageName'],
            'status' => $validated['status'],
            'created_by' => $validated['created_by'],
            'creater_id' => $validated['creater_id'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        if ($inserted) {
            return redirect()->route('packages.indexRT')->with('success', 'Package created successfully.');
        } else {
            return back()->withInput()->with('error', 'Failed to create package. Please try again.');
        }
    } catch (\Exception $e) {
        // Log the error for debugging (optional)
        \Log::error('Package Insert Error: ' . $e->getMessage());

        return back()->withInput()->with('error', 'Something went wrong. Please try again.'.$e);
    }
}

public function editRT($id)
{
try {
$package = DB::table('packages')->where('id', $id)->first();
 if (!$package) {
            return redirect()->route('packages.indexRT')->with('error', 'Package not found.');
        }

        return view('admin.packages.edit', compact('package'));
    } catch (\Exception $e) {
        return redirect()->route('packages.indexRT')->with('error', 'An error occurred while loading the package.');
    }
}

public function updateRT(Request $request, $id)
{
    $request->validate([
        'packageName' => 'required|string|max:255',
        'status' => 'required|in:0,1',
        'created_by' => 'required',
        'creater_id' => 'required',
    ]);

    try {
        $affected = DB::table('packages')
            ->where('id', $id)
            ->update([
                'packageName' => $request->input('packageName'),
                'status' => $request->input('status'),
                'created_by' => $request->input('created_by'),
                'creater_id' => $request->input('creater_id'),
                'updated_at' => now()
            ]);

        if ($affected === 0) {
            return redirect()->back()->with('warning', 'No changes made or package not found.');
        }

        return redirect()->route('packages.indexRT')->with('success', 'Package updated successfully.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Failed to update package. Error: ' . $e->getMessage());
    }
}


}
