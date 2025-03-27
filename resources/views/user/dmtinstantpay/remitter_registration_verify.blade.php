@extends('user/include.layout')
@section('content')
<div class="card col-md-6 mx-auto shadow-lg border-0">
    <div class="alert alert-danger">
        <strong>{{ $status }}</strong>
    </div>
    <div class="card-header py-3">
        <h4 class="card-heading mb-0">Remitter Registration Verify</h4>
    </div>
    <div class="card-body p-4">
        <form action="{{ route('remitterRegistrationVerify') }}" method="POST">
            @csrf
            <div class="form-group mb-3">
                <label for="mobile" class="form-label"></label>
                <input type="text" class="form-control" value="{{$mobileNumber}}" hidden readonly name="mobileNumber" required>
            </div>
            <div class="form-group mb-3">
                <label for="benename" class="form-label">OTP</label>
                <input type="text" class="form-control" name="otp" required>
            </div>
            
                <input type="text" class="form-control" value="{{ $data['referenceKey'] ?? 'N/A' }}" readonly hidden name="referenceKey" required>
         
            <button type="submit" class="btn btn-success w-100">Register</button>
        </form>
        <p><strong>Validity:</strong> {{ $data['validity'] ?? 'N/A' }}</p>
    </div>
</div>


@endsection


{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Remitter Registration Response</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Response</h2>
        <div class="card">
            <div class="card-body">
                <h5>Status: <span class="badge bg-success">{{ $status }}</span></h5>
                <hr>
                <h6>Data:</h6>
                <ul>
                    @if($data)
                        @foreach($data as $key => $value)
                            <li><strong>{{ ucfirst($key) }}:</strong> {{ $value }}</li>
                        @endforeach
                    @else
                        <li>No data available.</li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</body>
</html> --}}
