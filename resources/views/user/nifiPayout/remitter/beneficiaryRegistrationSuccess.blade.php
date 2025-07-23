@extends('user/include/layout')

@section('content')
<div class="container py-4">
    <div class="alert alert-success text-center fs-5 fw-bold">
        ✅ {{ $status }}
    </div>

    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            Beneficiary Details
        </div>
        <div class="card-body">
            <ul class="list-group">
                <li class="list-group-item"><strong>Beneficiary ID:</strong> {{ $beneId }}</li>
                <li class="list-group-item"><strong>Remitter Mobile:</strong> {{ $mobile }}</li>
                <li class="list-group-item"><strong>Beneficiary Name:</strong> {{ $name }}</li>
                <li class="list-group-item"><strong>Account Number:</strong> {{ $accno }}</li>
                <li class="list-group-item"><strong>IFSC:</strong> {{ $ifsc }}</li>
                <li class="list-group-item"><strong>Bank ID:</strong> {{ $bankId }}</li>
            </ul>

            <div class="mt-4 text-center">
                <form action="{{ route('remProfilePost') }}" method="POST">
                    @csrf
                    <input type="hidden" name="mobileNumber" value="{{ $mobile }}">
                    <button type="submit" class="btn btn-outline-primary">
                        <i class="bi bi-arrow-left-circle"></i> Back to Remitter Profile
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
