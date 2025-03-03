@extends('user/include.layout')

@section('content')
@include('user.remitter.navbar')

<style>
    body {
        background-color: #f7f9fc;
    }
    .main-card {
        max-width: 600px;
        margin: 20px auto;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .main-card .card-header {
        background-color: #007bff;
        color: white;
        text-align: center;
        font-weight: bold;
    }
    .main-card .card-body {
        font-size: 14px;
    }
    .detail-row {
        display: flex;
        justify-content: space-between;
        padding: 8px 0;
        border-bottom: 1px solid #f1f1f1;
    }
    .detail-row:last-child {
        border-bottom: none;
    }
    .detail-label {
        font-weight: bold;
        color: #555;
    }
    .alert-info {
        margin-bottom: 20px;
    }
    .text-success1 {
        color: green;
        font-weight: bold;
    }
    .text-danger1 {
        color: red;
        font-weight: bold;
    }
</style>

<div class="container mt-5">
    <h2 class="text-center mb-4">Remitter Details</h2>

    @if (isset($error))
        <div class="alert alert-danger">
            {{ $error }}
        </div>
    @elseif (isset($data) && !empty($data))
        <div class="card main-card">
            <div class="card-header">Remitter Registration Successful</div>
            <div class="card-body">
                <div class="alert alert-info text-center">
                    <strong>Registration Success:</strong> The remitter registration was completed successfully!
                </div>

                <!-- Display Remitter Data -->
                <div class="detail-row">
                    <div class="detail-label">Mobile Number</div>
                    <div>{{ $data['mobile'] ?? 'Not Available' }}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Limit</div>
                    <div>{{ $data['limit'] ?? 'Not Available' }}</div>
                </div>
                {{-- <div class="detail-row">
                    <div class="detail-label">KYC ID</div>
                    <div>{{ $data['kyc_id'] ?? 'Not Available' }}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">State Response</div>
                    <div>{{ $data['stateresp'] ?? 'Not Available' }}</div>
                </div> --}}

                <!-- Optionally display other available fields -->
                @if (isset($data['other_field']))
                    <div class="detail-row">
                        <div class="detail-label">Other Field</div>
                        <div>{{ $data['other_field'] ?? 'Not Available' }}</div>
                    </div>
                @endif
            </div>
        </div>
    @else
        <div class="alert alert-warning text-center">
            No Remitter details found or registration failed.
        </div>
    @endif
</div>
@endsection
