@extends('user.include.layout')

@section('content')
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header bg-success text-info">
                <h3 class="mb-0">Merchant Onboarding</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('user.outlet.signup') }}">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="mobile">Mobile</label>
                        <input type="text" name="mobile" class="form-control" id="mobile" required placeholder="Enter mobile number">
                    </div>
                    <div class="form-group mb-3">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control" id="email" required placeholder="Enter email address">
                    </div>
                    <div class="form-group mb-3">
                        <label for="aadhaar">Aadhaar</label>
                        <input type="text" name="aadhaar" class="form-control" id="aadhaar" required placeholder="Enter Aadhaar number">
                    </div>
                    <div class="form-group mb-3">
                        <label for="pan">PAN</label>
                        <input type="text" name="pan" class="form-control" id="pan" required placeholder="Enter PAN number">
                    </div>
                    <div class="form-group mb-3">
                        <label for="bankAccountNo">Bank Account Number</label>
                        <input type="text" name="bankAccountNo" class="form-control" id="bankAccountNo" required placeholder="Enter bank account number">
                    </div>
                    <div class="form-group mb-3">
                        <label for="bankIfsc">Bank IFSC</label>
                        <input type="text" name="bankIfsc" class="form-control" id="bankIfsc" required placeholder="Enter bank IFSC code">
                    </div>
              
                        <input hidden type="text" name="latitude" class="form-control" id="latitude" readonly required placeholder="Detecting latitude...">
                 
                 
                        <input hidden type="text" name="longitude" class="form-control" id="longitude" readonly required placeholder="Detecting longitude...">
              
                    <div class="form-group mb-3">
                        <label for="consent">Consent</label>
                        <select name="consent" id="consent" class="form-control" required>
                            <option value="Y">Yes</option>
                            <option value="N">No</option>
                        </select>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <small class="text-muted align-self-center">Location will be auto-detected</small>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Automatically detect location on page load
        document.addEventListener("DOMContentLoaded", function() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition, showError);
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        });

        function showPosition(position) {
            document.getElementById("latitude").value = position.coords.latitude;
            document.getElementById("longitude").value = position.coords.longitude;
        }

        function showError(error) {
            switch(error.code) {
                case error.PERMISSION_DENIED:
                    alert("User denied the request for Geolocation.");
                    break;
                case error.POSITION_UNAVAILABLE:
                    alert("Location information is unavailable.");
                    break;
                case error.TIMEOUT:
                    alert("The request to get user location timed out.");
                    break;
                case error.UNKNOWN_ERROR:
                    alert("An unknown error occurred.");
                    break;
            }
        }
    </script>
@endsection
