
@extends('user/include.layout')
@section('content')
<div class="container mt-5">
    <h1 class="text-center text-danger">Transaction Failed</h1>
    <div class="alert alert-danger">
        <strong>Status Code:</strong> {{ $statuscode }}<br>
        <strong>Status:</strong> {{ $status }}<br>
        @if(isset($error))
            <strong>Error:</strong> {{ $error }}
        @endif
    </div>
    {{-- <div class="mt-4">
        <a href="{{ route('user.dmtinstantpay.remitter_kyc_page') }}" class="btn btn-primary">Back to KYC Page</a>
    </div> --}}
</div>
// <script>
//     // Redirect to 'user' route after 5 seconds
//     setTimeout(() => {
//         window.location.href = "{{ route('dmt.remitter-profile') }}";
//     }, 5000);
// </script>
@endsection
