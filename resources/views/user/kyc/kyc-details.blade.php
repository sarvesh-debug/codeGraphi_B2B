@extends('user/include.layout')

@section('content')

<div class="controller mt-3 mx-5">
    <div class="row">
        <!-- Welcome Marquee -->
        <br>
        <marquee width="100%" direction="left" class="h5">
            Welcome To <span class="text-success1">Graphi</span><span class="text-info1">Graphi</span> Solutions 🙂
        </marquee>

        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-fluid">
                <div class="card col-md-8 mx-auto shadow-lg border-0">
                    <div class="card-header bg-success text-white text-center py-3">
                        <h4 class="mb-0">KYC Details</h4>
                    </div>

                    <div class="card-body p-4">
                        <!-- Display KYC Details -->
                        <h5>Name: {{ $kycDetails['name'] }}</h5>
                        <h5>Username: {{ $kycDetails['username'] }}</h5>
                        <h5>Aadhaar Number: {{ $kycDetails['aadhaar'] }}</h5>
                        <h5>City: {{ $kycDetails['city'] }}</h5>
                        <h5>State: {{ $kycDetails['state'] }}</h5>
                        <h5>Pincode: {{ $kycDetails['pincode'] }}</h5>
                        <h5>Outlet Name: {{ $kycDetails['outlet_name'] }}</h5>

                        <div class="row">
                            @if($kycDetails->aadhaar_front)
                            <div class="col-md-4">
                                <h5>Aadhaar Front</h5>
                                <img src="{{ asset('storage/' . $kycDetails->aadhaar_front) }}" alt="Aadhaar Front" style="width: 100%; max-width: 300px;">
                            </div>
                            @endif
                        
                            @if($kycDetails->aadhaar_back)
                            <div class="col-md-4">
                                <h5>Aadhaar Back</h5>
                                <img src="{{ asset('storage/' . $kycDetails->aadhaar_back) }}" alt="Aadhaar Back" style="width: 100%; max-width: 300px;">
                            </div>
                            @endif
                        
                            @if($kycDetails->pan_card)
                            <div class="col-md-4">
                                <h5>Pan Card</h5>
                                <img src="{{ asset('storage/' . $kycDetails->pan_card) }}" alt="Pan Card" style="width: 100%; max-width: 300px;">
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
