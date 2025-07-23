@extends('user/include.layout')
@section('content')

<div class="container mt-5">
    <div class="card shadow-lg rounded-4 border-0">
        <div class="card-body p-5">
            <h3 class="mb-4 text-center fw-bold text-primary">
                💸 IMPS Payout
            </h3>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('nifiimps.payout') }}" method="POST">
                @csrf

                {{-- Hidden Fields --}}
                <input type="hidden" name="p1" value="{{ $getDetails->account_no }}">
                <input type="hidden" name="p2" value="{{ $getDetails->ifsc_code }}">
                <input type="hidden" name="p5" value="{{ $getDetails->name }}">
                <input type="hidden" name="p6" value="{{ $getDetails->phone }}">
                <input type="hidden" name="p7" value="{{ $getDetails->email }}">
                <input type="hidden" name="p8" value="{{ $getDetails->name }}">
                <input type="hidden" name="p9" value="Payout">
                <input type="hidden" name="p11" id="locationField">

                {{-- Transaction ID --}}
                <input type="hidden" name="p3" value="TXN{{ now()->format('YmdHis') }}{{ rand(100,999) }}">

                {{-- Visible Field --}}
                <div class="mb-4">
                    <label class="form-label fs-6 fw-semibold">💰 Enter Amount</label>
                    <input type="number" name="p4" class="form-control form-control-lg" placeholder="Enter amount" required>
                </div>
                <div class="md-4">
                <label class="form-label">Account Type (p10)</label>
                <select name="p10" class="form-select" required>
                    <option value="1">Saving</option>
                    <option value="2">Current</option>
                </select>
            </div>
                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-primary btn-lg shadow-sm rounded-pill">
                        🚀 Send IMPS Payout
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Auto Latitude/Longitude Script --}}
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
