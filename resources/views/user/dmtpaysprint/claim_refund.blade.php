@extends('user/include.layout')

@section('content')
@include('user.beneficiary.navbar')

<div class="card col-md-6 mx-auto shadow-lg border-0">
    <div class="card-header bg-info text-white text-center py-3">
        <h4 class="mb-0">Transaction Status</h4>
    </div>
    <div class="card-body p-4">
        <form action="{{route('refund.OtpClaim')}}" method="POST">
            @csrf
            <!-- Hidden input for referenceid -->
            <input type="hidden" name="referenceid" value="{{ $referenceId }}">
            
            <!-- Hidden input for ackno -->
            <input type="hidden" name="ackno" value="{{ $ackno }}">

            <div class="form-group mb-3">
                <label for="otp" class="form-label">OTP:</label>
                <input type="text" class="form-control" name="otp" id="otp" required>
            </div>

            <button type="submit" class="btn btn-info w-100">Query Transaction</button>
        </form>
    </div>
</div>

@endsection
