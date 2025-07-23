@extends('user/include.layout')
@section('content')


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
        <form id="remitterProfileForm" action="{{route('transactionDmt1')}}" method="POST">
            @csrf
           
                <input type="text" hidden class="form-control" value="{{ session('mobile5') }}" id="mobile" name="mobileNumber" readonly>
   

         
            

            <div class="form-group mb-3">
                <label for="account" class="form-label">Account Number</label>
                <input type="text" class="form-control" value=" {{ session('account5')  }}" id="account" name="account" readonly>
            </div>
            <div class="form-group mb-3">
                <label for="account" class="form-label">Beneficiary Name</label>
                <input type="text" class="form-control" value="{{ session('name5') }}" id="account" name="beneName" readonly>
            </div>

            <div class="form-group mb-3">
                <label for="ifsc" class="form-label">IFSC Code</label>
                <input type="text" class="form-control" value=" {{ session('ifsc5') }}" id="ifsc" name="ifsc" readonly>
            </div>

            <div class="form-group mb-3">
                <label for="amount" class="form-label">Amount</label>
                <input type="text" class="form-control" value=" {{ session('amount5') }}"  id="amount" name="amount" readonly>
            </div>
            <input type="hidden" value="{{session('email')}}" name="email">
            <!-- Latitude and Longitude Fields -->
           <input type="hidden" name="p11" id="locationField">
            <div class="form-group mb-3">
                <label for="mobile" class="form-label">OTP <sup class="text-danger">{{$status}}</sup> </label>
                <input type="text" class="form-control" id="otp" name="otp" required>
            </div>
            <div class="form-group mb-3">
                <label for="transferMode" class="form-label">Transfer Mode</label>
                <select class="form-control" id="transferMode" name="transferMode" required>
                    <option value="">Select Transfer Mode</option>
                    <option value="IMPS" selected>IMPS</option>
                
                </select>
            </div>

            <button type="submit" class="btn btn-success w-100">Submit</button>
        </form>
    </div>
</div>
<!-- Loading Overlay -->
<div id="loadingOverlay" style="display: none; position: fixed; top: 0; left: 0; height: 100%; width: 100%; background: rgba(255,255,255,0.7); z-index: 9999; backdrop-filter: blur(4px);">
    <div class="d-flex justify-content-center align-items-center h-100">
        <div class="spinner-border text-success" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
</div>


<!-- Add Geolocation Script -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('remitterProfileForm');
        const submitBtn = form.querySelector('button[type="submit"]');
        const overlay = document.getElementById('loadingOverlay');

        form.addEventListener('submit', function (e) {
            // Disable submit button
            submitBtn.disabled = true;
            submitBtn.innerHTML = 'Processing...';

            // Show overlay
            overlay.style.display = 'block';
        });

        // Geolocation Code
        const latitudeField = document.getElementById('latitude');
        const longitudeField = document.getElementById('longitude');

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function (position) {
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
<script>
    window.onload = function () {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                document.getElementById('locationField').value =
                    position.coords.latitude + "," + position.coords.longitude;
            });
        } else {
            alert("Geolocation is not supported by this browser.");
        }
    };
</script>
@endsection




