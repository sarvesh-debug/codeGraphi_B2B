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
        <form action="{{ route('remitterRegistrationVerifyCG') }}" method="POST">
            @csrf
           
            <div class="form-group mb-3">
                <label for="benename" class="form-label">OTP</label>
                <input type="text" class="form-control" name="otp" required>
            </div>
            
    
         
            <button type="submit" class="btn btn-success w-100">Register</button>
        </form>

    </div>
</div>


@endsection

