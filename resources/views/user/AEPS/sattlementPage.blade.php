@extends('user/include.layout')

@section('content')

<div class="container mt-5">
    <div class="col-md-6 mx-auto bg-white shadow rounded p-4 border">
        <h2 class="text-center fw-bold mb-4 text-dark">AEPS Settlement Form</h2>

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{route('aeps.sattlement')}}" method="POST" onsubmit="return confirmTransfer()">
            @csrf

            <!-- Amount Field -->
            <div class="mb-3">
                <label for="amount" class="form-label">Settlement Amount <span class="text-danger">*</span></label>
                <input type="number" name="amount" id="amount" class="form-control" required>
            </div>

            <!-- Remarks Field -->
            <div class="mb-3">
                <label for="remarks" class="form-label">Remarks (optional)</label>
                <input type="text" name="remarks" id="remarks" class="form-control">
            </div>

         
                <input type="text" name="latitude" hidden id="latitude" class="form-control" readonly required>
            
            
                <input type="text" name="longitude" hidden id="longitude" class="form-control" readonly required>
           
            <!-- Important Note -->
            <div class="alert alert-warning">
                <strong>Note:</strong> Once you settle your AEPS Wallet balance, this transaction is <strong>non-reversible</strong>.
            </div>

            <!-- Submit Button -->
            <div class="d-grid">
                <button type="submit" class="btn btn-success fw-semibold">
                    💼 Settle Now
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Confirmation & Location Script --}}
<script>
    function confirmTransfer() {
        return confirm("Are you sure you want to settle the AEPS Wallet amount?");
    }

    // Auto-get latitude and longitude
    window.onload = function () {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function (position) {
                    document.getElementById('latitude').value = position.coords.latitude;
                    document.getElementById('longitude').value = position.coords.longitude;
                },
                function (error) {
                    alert("Unable to retrieve location. Please allow location access.");
                }
            );
        } else {
            alert("Geolocation is not supported by this browser.");
        }
    };
</script>

@endsection
