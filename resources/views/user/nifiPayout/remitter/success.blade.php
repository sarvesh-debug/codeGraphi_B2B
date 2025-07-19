@extends('user/include.layout')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="alert alert-success text-center fw-bold fs-5">
                ✅ Remitter registered successfully!
            </div>

            <div class="card shadow-lg border-0">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0"><i class="fas fa-user-check me-2"></i>Remitter Details</h4>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Name:</strong> {{ $data['name'] }}</li>
                        <li class="list-group-item"><strong>Mobile:</strong> {{ $data['mobile'] }}</li>
                        <li class="list-group-item"><strong>Remitter ID:</strong> {{ $data['remId'] }}</li>
                        <li class="list-group-item"><strong>Aadhaar Number:</strong> {{ $data['adhar_no'] }}</li>
                        <li class="list-group-item"><strong>PAN Number:</strong> {{ $data['panno'] }}</li>
                        <li class="list-group-item"><strong>Monthly Limit:</strong> ₹{{ number_format($data['monthly_limit']) }}</li>
                        <li class="list-group-item"><strong>Per Day Limit:</strong> ₹{{ number_format($data['perday_limit']) }}</li>
                        <li class="list-group-item"><strong>Pincode:</strong> {{ $data['pincode'] }}</li>
                        <li class="list-group-item"><strong>City:</strong> {{ $data['city'] }}</li>
                    </ul>

                    <div class="mt-4 text-center">
                        <a href="{{ route('remProfile') }}" class="btn btn-primary">Go to Dashboard</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
