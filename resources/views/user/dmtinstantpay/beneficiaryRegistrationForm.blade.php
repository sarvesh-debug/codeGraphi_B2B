{{-- <p><strong>Mobile Number:</strong> {{ $mobileNumber }}</p> --}}
@extends('user/include.layout')
@section('content')
<div class="card col-md-6 mx-auto shadow-lg border-0 mt-5">
    <div class="card-header">
        <h4 class="card-heading mb-0">Register Beneficiary</h4>
    </div>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <div class="card-body p-4">
        <form action="{{ route('beneficiaryRegistration') }}" method="POST">
            @csrf
            <input type="text" name="mobile" hidden id="mobile" value="{{ $mobileNumber }}" class="form-control" placeholder="Enter mobile number" required>

            <div class="form-group mb-2">
                <label for="benename" class="form-label">Beneficiary Name</label>
                <input type="text" name="benename" id="benename" class="form-control" placeholder="Enter beneficiary name" required>
            </div>
            <div class="form-group mb-2">
                <label for="beneMobile" class="form-label">Beneficiary Mobile No</label>
                <input type="text" name="beneMobile" id="beneMobile" class="form-control" placeholder="Enter Mobile No" required>
            </div>
            <div class="form-group mb-2">
                <label for="accno" class="form-label">Account Number</label>
                <input type="text" name="accno" id="accno" class="form-control" placeholder="Enter account number" required>
            </div>
            <div class="form-group mb-2">
                <label for="bank">Select Bank</label>
                <select class="form-control" id="bank" name="bankId">
                    <option value="">Select Bank</option>
                    @foreach ($responseData['data'] as $bank)
                        <option value="{{ $bank['bankId'] }}" data-ifsc="{{ $bank['ifscGlobal'] }}">
                            {{ $bank['name'] }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mb-2">
                <label for="ifsc">IFSC Code</label>
                <input type="text" class="form-control" id="ifsc" name="ifsc"  />
            </div>
            
           
                <input type="text" hidden name="latitude" id="latitude" class="form-control" placeholder="Fetching..." readonly required>
        
                <input type="text" hidden name="longitude" id="longitude" class="form-control" placeholder="Fetching..." readonly required> 
           
            <div class="text-center">
                <button type="submit" class="btn btn-success  py-2">Register Beneficiary</button>
            </div>
        </form>
    </div>
</div>

<!-- Include Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<!-- Include Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    // JavaScript to auto-fill the IFSC code when a bank is selected
    document.getElementById('bank').addEventListener('change', function() {
        const selectedBank = this.options[this.selectedIndex];
        const ifsc = selectedBank.getAttribute('data-ifsc');
        document.getElementById('ifsc').value = ifsc; // Set the IFSC code
    });

    // JavaScript to fetch Latitude and Longitude
    window.onload = function() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                document.getElementById('latitude').value = position.coords.latitude;
                document.getElementById('longitude').value = position.coords.longitude;
            }, function(error) {
                console.error('Error getting location:', error.message);
                document.getElementById('latitude').value = 'Unavailable';
                document.getElementById('longitude').value = 'Unavailable';
            });
        } else {
            alert('Geolocation is not supported by this browser.');
            document.getElementById('latitude').value = 'Not Supported';
            document.getElementById('longitude').value = 'Not Supported';
        }
    };
</script>
@endsection
