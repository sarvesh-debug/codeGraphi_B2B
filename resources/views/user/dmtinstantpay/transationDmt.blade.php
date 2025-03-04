@extends('user/include.layout')
@section('content')
@include('user.dmtinstantpay.navbar')

<div class="card col-md-6 mx-auto shadow-lg border-0">
    <div class="card-header bg-success text-white text-center py-3">
        @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
        <h4 class="mb-0">Send Money</h4>
    </div>
    <div class="card-body p-4">
        <form id="remitterProfileForm" action="{{route('dmt.transaction')}}" method="POST">
            @csrf
           
                <input type="text" hidden class="form-control" value="{{ $mobile }}" id="mobile" name="mobileNumber" readonly>
   

         
                <input type="text" hidden class="form-control" value="{{ $referenceKey }}" id="referenceKey" name="referenceKey" readonly>
            

            <div class="form-group mb-3">
                <label for="account" class="form-label">Account Number</label>
                <input type="text" class="form-control" value="{{ $account }}" id="account" name="account" readonly>
            </div>

            <div class="form-group mb-3">
                <label for="ifsc" class="form-label">IFSC Code</label>
                <input type="text" class="form-control" value="{{ $ifsc }}" id="ifsc" name="ifsc" readonly>
            </div>

            <div class="form-group mb-3">
                <label for="amount" class="form-label">Amount</label>
                <input type="text" class="form-control" value="{{ $amount }}" id="amount" name="amount" readonly>
            </div>

            <!-- Latitude and Longitude Fields -->
            <input type="hidden" id="latitude" name="latitude">
            <input type="hidden" id="longitude" name="longitude">
            <div class="form-group mb-3">
                <label for="mobile" class="form-label">OTP</label>
                <input type="text" class="form-control" id="otp" name="otp" required>
            </div>
            <div class="form-group mb-3">
                <label for="transferMode" class="form-label">Transfer Mode</label>
                <select class="form-control" id="transferMode" name="transferMode" required>
                    <option value="">Select Transfer Mode</option>
                    <option value="IMPS">IMPS</option>
                    <option value="NEFT">NEFT</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success w-100">Submit</button>
        </form>
    </div>
</div>

<!-- Add Geolocation Script -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const latitudeField = document.getElementById('latitude');
        const longitudeField = document.getElementById('longitude');

        // Check if Geolocation API is available
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function (position) {
                    // Successfully got location
                    latitudeField.value = position.coords.latitude;
                    longitudeField.value = position.coords.longitude;
                },
                function (error) {
                    console.error("Geolocation error: ", error.message);
                    alert("Could not retrieve your location. Please enable location services.");
                }
            );
        } else {
            alert("Geolocation is not supported by your browser.");
        }
    });
</script>
@endsection






{{-- @extends('user/include.layout')
@section('content')
@include('user.dmtinstantpay.navbar')

<div class="card col-md-6 mx-auto shadow-lg border-0">
    <div class="card-header py-3">
        <h4 class="card-heading mb-0">Remitter Profile</h4>
    </div>
    <div class="card-body p-4">
        <form id="remitterProfileForm" action="{{route('dmt.transaction')}}" method="POST">
            @csrf
            <div class="form-group mb-3">
                <label for="mobile" class="form-label">Mobile No</label>
                <input type="text" class="form-control" value="{{ $mobile }}" id="mobile" name="mobileNumber" required>
            </div>
            <div class="form-group mb-3">
                <label for="benename" class="form-label">OTP</label>
                <input type="text" class="form-control" name="otp" required>
            </div>
            <input type="hidden" value="{{ $referenceKey }}" name="referenceKey">
            <input type="hidden" value="{{ $account }}" name="account">
            <input type="hidden" value="{{ $ifsc }}" name="ifsc">
            <input type="hidden" value="{{ $amount }}" name="amount">

            <!-- Latitude and Longitude Hidden Fields -->
            <input type="hidden" id="latitude" name="latitude">
            <input type="hidden" id="longitude" name="longitude">

            <div class="form-group mb-3">
                <label for="transferMode" class="form-label">Transfer Mode</label>
                <select class="form-control" id="transferMode" name="transferMode" required>
                    <option value="">Select Transfer Mode</option>
                    <option value="IMPS">IMPS</option>
                    <option value="NEFT">NEFT</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success w-100" id="submitBtn">Submit</button>
        </form>
    </div>
</div>

<!-- Add Geolocation Script -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const latitudeField = document.getElementById('latitude');
        const longitudeField = document.getElementById('longitude');
        const submitButton = document.getElementById('submitBtn');

        // Check if Geolocation API is available
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function (position) {
                    // Successfully got location
                    latitudeField.value = position.coords.latitude;
                    longitudeField.value = position.coords.longitude;
                },
                function (error) {
                    console.error("Geolocation error: ", error.message);
                    alert("Could not retrieve your location. Please enable location services.");
                }
            );
        } else {
            alert("Geolocation is not supported by your browser.");
        }
    });
</script>
@endsection --}}
