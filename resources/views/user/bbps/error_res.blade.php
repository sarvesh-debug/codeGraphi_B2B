@extends('user/include.layout')

@section('content')
@include('user.bbps.navbar')

<div class="container mt-5">
    <div class="d-flex justify-content-center align-items-center">
        <div class="card shadow-lg text-center p-4" style="max-width: 400px;">
            <div class="card-body">
                <h4 class="text-danger mb-3"><i class="fas fa-exclamation-circle"></i> Insufficient Balance</h4>
                <p class="text-secondary">
                    Your balance is not sufficient to proceed with the transaction. Please recharge your account and try again.
                </p>
                <a href="{{ route('getcategory') }}" class="btn btn-primary mt-3">Back</a>
            </div>
        </div>
    </div>
</div>
@endsection
