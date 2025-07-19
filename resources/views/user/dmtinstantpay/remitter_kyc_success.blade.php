@extends('user/include.layout')
@section('content')
<div class="container mt-5">
    <h1 class="text-center text-success">Transaction Successful</h1>
    <div class="alert alert-success">
        <strong>Status:</strong> {{ $response['status']  ?? ''}}<br>
        <strong>Status Code:</strong> {{ $response['statuscode'] ?? '' }}<br>
        <strong>Order ID:</strong> {{ $response['orderid']  ?? ''}}<br>
        <strong>Timestamp:</strong> {{ $response['timestamp'] ?? '' }}<br>
        <strong>Environment:</strong> {{ $response['environment']  ?? ''}}
    </div>
    {{-- <h3>Pool Details</h3>
    <ul class="list-group">
        <li class="list-group-item"><strong>Account:</strong> {{ $response['data']['pool']['account'] }}</li>
        <li class="list-group-item"><strong>Opening Balance:</strong> {{ $response['data']['pool']['openingBal'] }}</li>
        <li class="list-group-item"><strong>Transaction Mode:</strong> {{ $response['data']['pool']['mode'] }}</li>
        <li class="list-group-item"><strong>Transaction Amount:</strong> {{ $response['data']['pool']['amount'] }}</li>
        <li class="list-group-item"><strong>Closing Balance:</strong> {{ $response['data']['pool']['closingBal'] }}</li>
    </ul>
    <div class="mt-4">
        <a href="{{ route('user.dmtinstantpay.remitter_kyc_page') }}" class="btn btn-primary">Back to KYC Page</a>
    </div> --}}
</div>
 <script>
    // Redirect to 'user' route after 5 seconds
    setTimeout(() => {
        window.location.href = "{{ route('dmt.remitter-profile') }}";
    }, 5000);
 </script>
@endsection
