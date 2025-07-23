@extends('user/include.layout')

@section('content')
@include('user.AEPS.navbar')
<style>
    /* Loader overlay styles */
    /* #loadingOverlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%; */
    /* height: 100%;
    background: rgba(0, 0, 0, 0.5);  /* Dark background with some opacity */
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;  /* Ensure it's above all other content */
    color: white;
}

.loader {
    border: 8px solid #f3f3f3;  /* Light gray background */
    border-top: 8px solid #3498db;  /* Blue color for the spinning part */
    border-radius: 50%;
    width: 50px;
    height: 50px;
    animation: spin 1s linear infinite;
} */

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}


    /* Prevent interactions while loader is active */
    body.loading {
        overflow: hidden;
    }

    body.loading * {
        pointer-events: none;
    }
    </style>

<div class="card col-md-6 col-11 mx-auto shadow-lg border-0 loading mt-5 ">
    <div id="loadingOverlay">
        <div class="loader"></div>
    </div>
    <div class="card-header" style="background: linear-gradient(to right, #0a22aa, #b62512); color: white; border: none;">
        <h4 class="card-heading mb-0">Daily Login Form</h4>
    </div>
    <div class="card-body p-4">
        <form action="{{route('outlet-login/aeps.store')}}" method="POST">
            @csrf
            
            <!-- Type -->
            <div class="form-group mb-3">
                <label for="type" class="form-label">Type</label>
                <input type="text" class="form-control" name="type" id="type" value="DAILY_LOGIN" readonly required>
            </div>
            <div class="form-group mb-3">
            <label for="encryptedAadhaar" class="form-label">Aadhaar</label>
            <input type="text" class="form-control" value="{{ session('adhar_no') }}" name="aadhaar" id="encryptedAadhaar"
            </div>

            
            <!-- Latitude -->
            
                <input type="text" class="form-control"hidden name="latitude" id="latitude" readonly required>
          
            
            <!-- Longitude -->
           
                
                <input type="text" class="form-control"  hidden name="longitude" id="longitude" readonly required>
                <input id="txtBiometricData"   name="biometricData" class="form-control m-1" rows="1" readonly placeholder="Biometric Data will appear here">
            
           
<!-- Device Dropdown -->
<div class="text-center mb-3">
  <select id="deviceSelector" class="form-select w-auto d-inline" onchange="toggleDeviceButtons()">
    <option value="">Select Device</option>
    <option value="mantra">Mantra</option>
    <option value="morpho">Morpho</option>
  </select>
</div>

<!-- Buttons -->
<div class="d-flex justify-content-center gap-2"> 
  <!-- Mantra Buttons -->
  <button onclick="discoverAvdm();" type="button" id="mantraBtn" class="btn btn-info d-none">Search RD</button>
  <button onclick="CaptureAvdm()" type="button" id="mtrCaptureBtn" class="btn btn-danger d-none">Capture</button>

  <!-- Morpho Buttons -->
  <button type="button" class="btn d-none" id="btn1" onclick="RDService()">Morpho</button>
  <button type="button" class="btn d-none btn-danger" id="btn3" onclick="Capture()">Mor Capture</button>
</div>

<!-- Submit -->
<button type="submit" id="" class="btn btn-primary mt-3" style="background: linear-gradient(to right, #0a22aa, #b62512); color: white; border: none;">Submit</button>

        </form>
    </div>
</div>
@include('user.AEPS.device');
@endsection
