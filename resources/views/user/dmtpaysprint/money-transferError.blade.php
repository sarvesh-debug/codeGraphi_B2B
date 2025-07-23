@extends('user/include.layout')

@section('content')
@include('user.dmtpaysprint.navbar')

<div class="container text-center mt-5">
    <div class="card shadow-lg p-4" style="border-radius: 10px; background-color: #f8d7da;">
        <h1 class="text-danger mb-3" style="font-size: 2.5rem;">
            <i class="fa fa-times-circle"></i> Transaction Failed
        </h1>
        <p class="text-dark" style="font-size: 1.2rem;">{{ $error }}</p>
        <a href="{{ route('1fetch.form') }}" class="btn btn-primary btn-lg mt-4">
            <i class="fa fa-redo"></i> Try Again
        </a>
        <p class="mt-3 text-muted">Redirecting automatically in 5 seconds...</p>
    </div>
</div>

<script>
    setTimeout(function() {
        window.location.href = "{{ route('1fetch.form') }}"; // Redirect to the 'fetch.form' route
    }, 5000); // 5000ms = 5 seconds
</script>

@endsection
