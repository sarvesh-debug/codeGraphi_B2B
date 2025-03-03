@extends('user.include.layout') 
@section('content')

<div class="card col-md-6 mx-auto shadow-lg border-0 my-2">
    <div class="card-header bg-primary text-white text-center py-3">
        <h4 class="mb-0 text-white">OTP Verification for Mobile Number Change</h4>
    </div>

    <div class="card-body p-4">
        <form action="{{ route('otp-mobile') }}" method="POST">
            @csrf
            
            <!-- OTP for Existing Mobile Number -->
            <div class="form-group mb-3">
                <label for="otpExisting" class="form-label">OTP for Existing Mobile Number</label>
                <input type="text" class="form-control" name="existingMobileNumberOTP" id="otpExisting" placeholder="Enter OTP:{{$existingMobileNumber}}" required>
            </div>

            <!-- OTP for New Mobile Number -->
            <div class="form-group mb-3">
                <label for="otpNew" class="form-label">OTP for New Mobile Number</label>
                <input type="text" class="form-control" name="newMobileNumberOTP" id="otpNew" placeholder="Enter OTP : {{$newMobileNumber}}" required>
            </div>

            <input type="text" hidden value="{{$existingMobileNumber}} " name="existingMobileNumber">
            <input type="text"  hidden value="{{$newMobileNumber}} " name="newMobileNumber">
            <!-- Submit Button -->
            <p class="text-danger">{{$error ?? ''}}</p>
            <button type="submit" class="btn btn-primary w-100" id="submitButton">Verify and Change Mobile Number</button>
        </form>
        
        <!-- Change Mobile Link -->
        <a href="{{ route('show.mobilechng') }}" class="link-primary">Change Mobile No</a>
    </div>

    @if(isset($error))
    <script>
        alert("{{ $error }}");
    </script>
    @endif
</div>

@endsection
