@extends('user/include.layout')
{{-- In any Blade view --}}
@php
    $customer = session('customer');
@endphp

@section('content')

<div class="controller mt-3 mx-5">
    <div class="row">
        <!-- Content Section -->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <!-- Content container -->
            <div id="kt_app_content_container" class="app-container container-fluid">
                <div class="card col-md-6 mx-auto shadow-lg border-0">
                    <!-- Card Header -->
                    <div class="card-header bg-success text-white text-center py-3">
                        <h4 class="mb-0">Apply For KYC</h4>
                    </div>

                    <!-- Card Body -->
                    <div class="card-body p-4">
                        <!-- Display success message -->
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- KYC Form -->
                        <form action="{{ route('user/kyc.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- Mobile Field -->
                            <div class="form-group mb-3">
                                <label for="mobile" class="form-label">Mobile</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                                    <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Enter Mobile" value="{{ $remitterData->phone}}"  required>
                                </div>
                            </div>

                            <!-- Email Field -->
                            <div class="form-group mb-3">
                                <label for="email" class="form-label">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" value="{{ $remitterData->email}}"  required>
                                </div>
                            </div>

                            <!-- Bank Account Number -->
                            <div class="form-group mb-3">
                                <label for="bankAccountNo" class="form-label">Bank Account Number</label>
                                <input type="text" name="bankAccountNo" class="form-control" id="bankAccountNo" value="{{ $remitterData->account_no}}" placeholder="Enter bank account number" required>
                            </div>

                            <!-- Bank IFSC -->
                            <div class="form-group mb-3">
                                <label for="bankIfsc" class="form-label">Bank IFSC</label>
                                <input type="text" name="bankIfsc" class="form-control" id="bankIfsc" value="{{ $remitterData->ifsc_code}}"  placeholder="Enter bank IFSC code" required>
                            </div>

                            <!-- Aadhaar Number -->
                            <div class="form-group mb-3">
                                <label for="aadhaar" class="form-label">Aadhaar Number</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-credit-card"></i></span>
                                    <input type="text" class="form-control numeric-input" id="aadhaar" value="{{ $remitterData->aadhar_no}}"  name="aadhaar" placeholder="Enter Aadhaar Number" maxlength="12"required />
                                </div>
                                <small class="form-text text-muted">Enter a valid 12-digit Aadhaar number.</small>
                            </div>

                            <!-- PAN Field -->
                            <div class="form-group mb-3">
                                <label for="pan" class="form-label">PAN</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-card-heading"></i></span>
                                    <input type="text" class="form-control" id="pan" name="pan" placeholder="Enter PAN"  value="{{ $remitterData->pan_no}}"  required>
                                </div>
                            </div>

                            <!-- Hidden Latitude and Longitude -->
                            <input type="hidden" name="latitude" id="latitude" readonly required>
                            <input type="hidden" name="longitude" id="longitude" readonly required>

                            <!-- Consent Field -->
                            <div class="form-group mb-3">
                                <label for="consent" class="form-label">Consent</label>
                                <select name="consent" id="consent" class="form-control" required>
                                    <option value="Y">Yes</option>
                                    <option value="N">No</option>
                                </select>
                            </div>

                            <!-- Submit Button -->
                            <div class="text-center">
                                <button type="submit" class="btn btn-success px-4">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Geolocation Script -->
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
