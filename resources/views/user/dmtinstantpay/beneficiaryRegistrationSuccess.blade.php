{{-- <p><strong>Mobile Number:</strong> {{ $mobileNumber }}</p> --}}
@extends('user/include.layout')
@section('content')
<div class="card col-md-6 mx-auto shadow-lg border-0 mt-5">
    <div class="card-header py-3">
        <h4 class="card-heading">Register Beneficiary OTP</h4>
    </div>
    <div class="card-body p-4">
        <p>{{$status}}</p>
        <form action="{{route('beneficiaryRegistrationkyc')}}" method="POST">
            @csrf

           
                <input type="text" name="beneMobile" hidden id="mobile" value="{{ $mobile }}" class="form-control" placeholder="Enter mobile number" required>
            

            <div class="form-group mb-3">
                <label for="benename" class="form-label">OTP</label>
                <input type="text" name="otp" id="otp" class="form-control"  required>
            </div>
          
                <input type="text" name="beneficiaryId" hidden id="beneficiaryId" value="{{ $beneficiaryId }}" class="form-control" placeholder="Enter Mobile No" required>
            
                <input type="text" name="referenceKey" hidden id="referenceKey" value="{{ $referenceKey }}" class="form-control" placeholder="Enter account number" required>
          
              
            <button type="submit" class="btn btn-success w-100 py-2">Verify</button>
        </form>
    </div>
</div>

@endsection
