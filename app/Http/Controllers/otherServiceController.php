<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Contact;
use App\Models\OtherService;

class otherServiceController extends Controller
{
    public function showForm()
    {
        $getData=Contact::first();
        
        return view('admin.otherServices.edit-rawData',compact('getData'));
    }
    public function edit()
    {
        return view('admin.otherServices.add-rawData');
    }

    public function store(Request $request)
    {
       
        $request->validate([
            'logo_name' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'helpline_no' => 'required|string|max:15',
            'tsn_no' => 'required|string|max:15',
            'banners' => 'required|array|min:4',
            'banners.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        // return $request;
        // die();
        // Store the logo image on AWS S3
        if ($request->hasFile('logo_name')) {
            $logoPath = $request->file('logo_name')->store('logos', 's3');
            // Make the file publicly accessible if needed
            Storage::disk('s3')->setVisibility($logoPath, 'public');
        
            // Get the public URL of the logo
            $logoUrl = Storage::disk('s3')->url($logoPath);
        }
        
        // Store the banner images on AWS S3 and retrieve their public URLs
        $bannerUrls = [];
        if ($request->hasFile('banners')) {
            foreach ($request->file('banners') as $banner) {
                $bannerPath = $banner->store('banners', 's3');
                // Make the file publicly accessible if needed
                Storage::disk('s3')->setVisibility($bannerPath, 'public');
        
                // Get the public URL of the banner
                $bannerUrls[] = Storage::disk('s3')->url($bannerPath);
            }
        }

        // Store the new contact details in the database
        Contact::create([
            'logo' => $logoUrl,
            'helpline_no' => $request->helpline_no,
            'tsn_no' => $request->tsn_no,
            'banners' => json_encode($bannerUrls),
        ]);

        return redirect()->back()->with('success', 'Contact details stored successfully!');
    }


    public function update(Request $request)
    {
        // Validate input data
        $request->validate([
            'lst_news' => 'nullable|string',
            'emr_news' => 'nullable|string',
        ]);
    
        // Fetch the first contact record (assuming there is only one)
        $contact = Contact::first();
    
        // If no record exists, create a new one
        if (!$contact) {
            $contact = new Contact();
        }
    
        // Update fields
        $contact->latest_news = $request->lst_news;
        $contact->emergency_update = $request->emr_news;
    
        // Save the record
        $contact->save();
    
        // Redirect with a success message
        return redirect()->back()->with('success', 'Data updated successfully!');
    }

    public function showIndex()
    {
        $rawData=Contact::get();
       // return $rawData;

        return view('admin.otherServices.show-rawData',compact('rawData'));
    }

    public function showServices()
    {
        return view('admin.otherServices.services');
    }

    public function showServicesStore(Request $request)
    {
        // return $request;
        // die();
        $request->validate([
            'logo_name' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'service' => 'required|string|max:255',
            'service_link' => 'required|url'
        ]);

        $logoPath = $request->file('logo_name')->store('services', 's3');

        // Get the file URL
        $logoUrl = Storage::disk('s3')->url($logoPath);

        OtherService::create([
           'logo_name' => $logoUrl,
            'service' => $request->service,
            'service_link' => $request->service_link
        ]);

        return redirect()->route('otherServices.index')->with('success', 'Service added successfully.'); 
    }
    public function index()
    {
        $services = OtherService::all();
        return view('admin.otherServices.servicesList', compact('services'));
    }

    public function Servicesedit($id)
    {
        
        $otherService = OtherService::where('id', $id)->first(); 
        
        return view('admin.otherServices.Servicesedit', compact('otherService'));
    }

    public function Servicesupdate(Request $request, OtherService $otherService)
    {
        $request->validate([
            'service' => 'required|string|max:255',
            'service_link' => 'required|url'
        ]);

        if ($request->hasFile('logo_name')) {
            $request->validate([
                'logo_name' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
            ]);

            $logoName = time().'.'.$request->logo_name->extension();
            $request->logo_name->move(public_path('uploads'), $logoName);
            $otherService->update(['logo_name' => $logoName]);
        }

        $otherService->update([
            'service' => $request->service,
            'service_link' => $request->service_link
        ]);

        return redirect()->route('otherServices.index')->with('success', 'Service updated successfully.');
    }

    public function toggleStatus($id)
    {
        $service = OtherService::findOrFail($id);
        $service->status = !$service->status; // Toggle between 1 and 0
        $service->save();

        return redirect()->back()->with('success', 'Service status updated successfully!');
    }
}
