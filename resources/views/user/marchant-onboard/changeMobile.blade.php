@extends('user.include.layout') 
@section('content')

<div class="card col-md-6 mx-auto shadow-lg border-0 my-2">
    <div class="card-header bg-primary text-white text-center py-3">
        <h4 class="mb-0 text-white">Mobile Change Initiate</h4>
    </div>

    <div class="card-body p-4">
        <form action="{{route('otp-verify.mobile')}}" method="POST">
            @csrf
            
            <div class="form-group mb-3">
                <label for="existingMobileNumber" class="form-label">Existing Mobile Number</label>
                <input type="text" class="form-control" name="existingMobileNumber" id="existingMobileNumber" required>
            </div>

            <div class="form-group mb-3">
                <label for="newMobileNumber" class="form-label">New Mobile Number</label>
                <input type="text" class="form-control" name="newMobileNumber" id="newMobileNumber" required>
            </div>
             
            <button type="submit" class="btn btn-primary w-100" id="submitButton">Get OTP</button>
        </form>
      
    </div>
    
    @if(isset($error))
    <script>
        alert("{{ $error }}");
    </script>
    @endif
</div>


@endsection
