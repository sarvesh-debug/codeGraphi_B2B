@extends('user/include.layout')

@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-heading mb-0">Beneficiary Delete Verification</h5>
                </div>
                <div class="card-body text-center">
                    <div class="alert alert-success">
                        <strong>Beneficiary Deleted Successfully</strong>
                    </div>

                    <p class="text-muted">
                        Redirecting to <b>Remitter Profile</b> in <span id="countdown" class="fw-bold text-danger">5</span> seconds...
                    </p>

                    <a href="{{ route('dmt.remitter-profile') }}" class="btn btn-secondary mt-2">Go Back</a>
                </div>
            </div>
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
            document.getElementById('autoForm').submit();
        }
    }, 1000);
</script>

@endsection
