@extends('user/include.layout')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-success text-white text-center">
            <h3>QR Code </h3>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @elseif(session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Display a single QR Image -->
            <div class="row justify-content-center">
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm text-center">
                        <!-- Display QR image -->
                        <img src="{{ $qrDetail->qr_pic }}" class="card-img-top" alt="QR Code Image" style="object-fit: contain; max-width: 100%; height: auto;">
                        <div class="card-body">
                            <!-- Link to view QR -->
                            <a href="{{ asset($qrDetail->qr_pic) }}" class="btn btn-info" target="_blank">View QR</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .card-img-top {
        max-height: 250px;
        object-fit: contain;
        margin: 0 auto;
    }
    .card-body {
        background-color: #f8f9fa;
    }
    .card-body p {
        font-size: 14px;
        font-weight: 600;
        color: #333;
    }
    .btn-info {
        margin-top: 10px;
    }
</style>
@endpush
