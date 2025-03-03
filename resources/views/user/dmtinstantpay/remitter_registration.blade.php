@extends('user/include.layout')
@section('content')
<div class="card col-md-6 mx-auto shadow-lg border-0">
    <div class="alert alert-danger">
        <strong>{{ $responseData['status'] }}</strong>
    </div>
    <div class="card-header bg-success text-white text-center py-3">
        <h4 class="mb-0">Remitter Register</h4>
    </div>
    <div class="card-body p-4">
        <form action="{{ route('remitterRegistration') }}" method="POST">
            @csrf
            <div class="form-group mb-3">
                <label for="mobile" class="form-label"></label>
                <input type="text" class="form-control" value="{{$mobileNumber}}" hidden readonly name="mobileNumber" required>
            </div>
            <div class="form-group mb-3">
                <label for="benename" class="form-label">Aadhar No</label>
                <input type="text" class="form-control" name="aadhaarNumber" required>
            </div>
            
                <input type="text" class="form-control" value="{{ $responseData['data']['referenceKey'] }}" readonly hidden name="referenceKey" required>
         
            <button type="submit" class="btn btn-success w-100">Register</button>
        </form>
        <p><strong>Validity:</strong> {{ $responseData['data']['validity'] }}</p>
    </div>
</div>


@endsection


