@extends('user/include.layout')

@section('content')
<div class="container mt-5">
    <div class="text-center">
        <h1 class="text-primary fw-bold">Beneficiary Registration Response</h1>
        <p class="text-muted">
            You will be redirected to the <b>Remitter Profile</b> page in 
            <span id="countdown" class="fw-bold text-danger">5</span> seconds...
        </p>
    </div>
    
    <div class="card shadow-lg mt-4">
        <div class="card-header">
            <h3 class="card-heading mb-0">Response Details</h3>
        </div>
        <div class="card-body">
            <h3 class="text-success">{{ $response['status'] }}</h3>
        </div>
    </div>
</div>

{{-- Hidden Auto-Submit Form --}}
<form id="autoForm" action="{{ route('dmt.remitter-profile_chk') }}" method="POST" style="display: none;">
    @csrf
    <input type="hidden" name="mobileNumber" value="{{ $remitterMobileNumber }}">
</form>

<script>
    let countdownElement = document.getElementById('countdown');
    let timeLeft = 5;

    const countdown = setInterval(() => {
        timeLeft -= 1;
        countdownElement.textContent = timeLeft;
        if (timeLeft <= 0) {
            clearInterval(countdown);
            document.getElementById('autoForm').submit(); // auto-submit the hidden form
        }
    }, 1000);
</script>
@endsection
