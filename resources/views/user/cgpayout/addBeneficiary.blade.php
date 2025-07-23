@extends('user/include.layout')

@section('content')

<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Register Beneficiary</h4>
            <a href="javascript:history.back()" class="btn btn-light btn-sm">← Back</a>
            {{-- Or use a route: <a href="{{ route('your.route.name') }}" class="btn btn-light btn-sm">← Back</a> --}}
        </div>

        @if (session('success'))
            <div class="alert alert-success mx-3 mt-3">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger mx-3 mt-3">
                {{ session('error') }}
            </div>
        @endif

        <div class="card-body">
            <form action="{{ route('add.beneStore') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="benename" class="form-label">Beneficiary Name</label>
                    <input type="text" name="benename" id="benename" value="{{ old('benename') }}" class="form-control" placeholder="Enter beneficiary name">
                    @error('benename')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="beneMobile" class="form-label">Beneficiary Mobile No</label>
                    <input type="text" name="beneMobile" id="beneMobile" value="{{ old('beneMobile') }}" class="form-control" placeholder="Enter Mobile No">
                    @error('beneMobile')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="accno" class="form-label">Account Number</label>
                    <input type="text" name="accno" id="accno" value="{{ old('accno') }}" class="form-control" placeholder="Enter account number">
                    @error('accno')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="bankname" class="form-label">Bank Name</label>
                    <input type="text" name="bankname" id="bankname" value="{{ old('bankname') }}" class="form-control" placeholder="Enter bank name">
                    @error('bankname')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="ifsc" class="form-label">IFSC Code</label>
                    <input type="text" name="ifsc" id="ifsc" value="{{ old('ifsc') }}" class="form-control text-uppercase" placeholder="Enter IFSC Code" oninput="this.value = this.value.toUpperCase();">
                    @error('ifsc')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Hidden Latitude and Longitude -->
                <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude') }}" readonly>
                <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude') }}" readonly>

                <div class="text-center">
                    <button type="submit" class="btn btn-success px-4">
                        Register Beneficiary
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Fetch Geolocation
    window.onload = function () {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                document.getElementById('latitude').value = position.coords.latitude;
                document.getElementById('longitude').value = position.coords.longitude;
            }, function (error) {
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
