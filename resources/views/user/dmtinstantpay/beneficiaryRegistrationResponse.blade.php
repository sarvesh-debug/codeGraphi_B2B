@extends('user/include.layout')

@section('content')
<div class="container mt-5">
    <div class="text-center">
        <h1 class="text-primary fw-bold">Beneficiary Registration Response</h1>
       
        <p class="text-muted">You will be redirected to the <b>Remitter Profile</b> page in <span id="countdown" class="fw-bold text-danger">5</span> seconds...</p>
    </div>
    <div class="card shadow-lg mt-4">
        <div class="card-header">
            <h3 class="card-heading mb-0">Response Details</h3>
        </div>
        <div class="card-body">
            {{-- <h5 class="text-secondary">Response Data:</h5> --}}
             <h3  class="text-success">{{$response['status']}}</h3> 
            
<!--            <pre class="p-3 bg-light rounded text-dark" style="font-size: 1rem; overflow-x: auto;">-->
{{-- <!--{{ json_encode($response, JSON_PRETTY_PRINT) }}--> --}}
<!--            </pre>-->
        </div>
    </div>
</div>

<script>
    // Countdown and Redirect Logic
    let countdownElement = document.getElementById('countdown');
    let timeLeft = 5; // seconds
    const redirectUrl = "{{ route('dmt.remitter-profile') }}";

    const countdown = setInterval(() => {
        timeLeft -= 1;
        countdownElement.textContent = timeLeft;
        if (timeLeft <= 0) {
            clearInterval(countdown);
            window.location.href = redirectUrl;
        }
    }, 1000);
</script>
@endsection
