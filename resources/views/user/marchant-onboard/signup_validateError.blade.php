@extends('user.include.layout')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-danger text-white">
                    <h4>{{ $error['status'] ?? 'Unknown error' }}</h4>
                </div>
                <div class="card-body">
                    <p><strong>Status Code:</strong> {{ $error['statuscode'] ?? 'Unknown' }}</p>
                    <p><strong>Status Message:</strong> {{ $error['status'] ?? 'Unknown error' }}</p>
                    <p><strong>Timestamp:</strong> {{ $error['timestamp'] ?? 'N/A' }}</p>
                    {{-- <p><strong>Environment:</strong> {{ $error['environment'] ?? 'N/A' }}</p> --}}
                    <p><strong>UUID:</strong> {{ $error['ipay_uuid'] ?? 'N/A' }}</p>
                </div>
                <div class="card-footer">
                    <a href="{{ url()->previous() }}" class="btn btn-primary">Go Back</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
