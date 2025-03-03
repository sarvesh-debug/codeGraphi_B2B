@extends('user/include.layout')
@section('content')

 <!-- Display Error Message -->
 @if(isset($error))
 <div class="alert alert-danger mt-3">
     {{ $error }}
 </div>
@endif
<div class="card col-md-6 mx-auto shadow-lg border-0">
    <div class="card-header bg-danger text-white text-center py-3">
        <h4 class="mb-0">Beneficiary Delete OTP</h4>
    </div>
    <div class="card-body p-4">
        <p>{{$status}}</p>
        <form action="{{route('dmt.deleteOtp')}}" method="POST">
            @csrf
            <div class="form-group mb-3">
                <label for="bene_id" class="form-label">OTP</label>
                <input type="text" class="form-control" id="otp" name="otp" required>
            </div>
          <input type="text" hidden value="{{$beneficiaryId}}" name="beneficiaryId">
          <input type="text" hidden value="{{$referenceKey}}" name="referenceKey">
          <input type="text" hidden value="{{$mobile}}" name="mobile">
            <button type="submit" class="btn btn-danger w-100">Submit</button>
        </form>
    </div>
</div>


@endsection