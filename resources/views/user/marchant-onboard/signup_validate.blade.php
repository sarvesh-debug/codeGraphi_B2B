@extends('user.include.layout') 
@section('content')


<div class="card col-md-6 mx-auto shadow-lg border-0 my-2">
    <div class="card-header bg-primary text-white text-center py-3">
        
        <h4 class="mb-0 text-white">OTP Verification</h4>
        <span id="timer" style="font-size: 1.2em; font-weight: bold;">00:59</span> <!-- Timer display -->
    </div>

    <div class="card-body p-4">
        <form action="{{route('otp-verify')}}" method="POST">
            @csrf
           
            <div class="form-group mb-3">
                <label for="otp" class="form-label">Enter OTP</label>
                <input type="text" class="form-control" name="otp" id="otp" required>
            </div>

            <input type="hidden" class="form-control" name="otpReferenceID" id="otpReferenceID" value="{{ $otpReferenceID ?? '' }}" required>
            <input type="hidden" class="form-control" name="hash" id="hash" value="{{ $hash ?? '' }}" required>
            <p class="text-danger">{{$msg ?? ''}}</p>
            <button type="submit" class="btn btn-primary w-100" id="submitButton">Verify OTP</button>
            
        </form>
        <a href="{{route('show.mobilechng')}}" class="link-primary">Change Mobile No</a>
    </div>
    @if(isset($error))
    <script>
        alert("{{ $error }}");
    </script>
@endif
</div>

<script>
    // Countdown timer
    let timerElement = document.getElementById('timer');
    let submitButton = document.getElementById('submitButton');
    let seconds = 59;

    function updateTimer() {
        let minutes = Math.floor(seconds / 60);
        let remainingSeconds = seconds % 60;

        // Display in MM:SS format
        timerElement.textContent = `${minutes < 10 ? '0' : ''}${minutes}:${remainingSeconds < 10 ? '0' : ''}${remainingSeconds}`;

        if (seconds > 0) {
            seconds--;
            setTimeout(updateTimer, 1000); // Call updateTimer every 1 second
        } else {
            // Display timeout message
            timerElement.textContent = 'Timeout, please try again';
            // Disable the submit button to prevent form submission
            submitButton.disabled = true;
        }
    }

    updateTimer(); // Start the countdown
</script>

@endsection
