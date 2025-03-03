@extends('user/include.layout')

@section('content')
@include('user.payout.navbar')
<div class="container my-5">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white text-center">
            <h4>API Response</h4>
        </div>
        <div class="card-body">
            <!-- Status Section -->
            <div class="mb-4">
                <h5 class="text-info">Status</h5>
                <ul class="list-group">
                    <li class="list-group-item"><strong>Status Code:</strong> {{ $response['statuscode'] }}</li>
                    <li class="list-group-item"><strong>Transaction Status:</strong> {{ $response['status'] }}</li>
                    <li class="list-group-item"><strong>Timestamp:</strong> {{ $response['timestamp'] }}</li>
                    <li class="list-group-item"><strong>Environment:</strong> {{ $response['environment'] }}</li>
                </ul>
            </div>

            <!-- Transaction Details -->
            <div class="mb-4">
                <h5 class="text-info">Transaction Details</h5>
                <ul class="list-group">
                    <li class="list-group-item"><strong>External Reference:</strong> {{ $response['data']['externalRef'] }}</li>
                    <li class="list-group-item"><strong>Transaction Value:</strong> ₹{{ $response['data']['txnValue'] }}</li>
                    <li class="list-group-item"><strong>Transaction Reference ID:</strong> {{ $response['data']['txnReferenceId'] }}</li>
                </ul>
            </div>

            <!-- Pool Details -->
            <div class="mb-4">
                <h5 class="text-info">Pool Details</h5>
                <ul class="list-group">
                    <li class="list-group-item"><strong>Account:</strong> {{ $response['data']['pool']['account'] }}</li>
                    <li class="list-group-item"><strong>Opening Balance:</strong> ₹{{ $response['data']['pool']['openingBal'] }}</li>
                    <li class="list-group-item"><strong>Mode:</strong> {{ $response['data']['pool']['mode'] }}</li>
                    <li class="list-group-item"><strong>Amount:</strong> ₹{{ $response['data']['pool']['amount'] }}</li>
                    <li class="list-group-item"><strong>Closing Balance:</strong> ₹{{ $response['data']['pool']['closingBal'] }}</li>
                </ul>
            </div>

            <!-- Payer Details -->
            <div class="mb-4">
                <h5 class="text-info">Payer Details</h5>
                <ul class="list-group">
                    <li class="list-group-item"><strong>Account:</strong> {{ $response['data']['payer']['account'] }}</li>
                    <li class="list-group-item"><strong>Name:</strong> {{ $response['data']['payer']['name'] }}</li>
                </ul>
            </div>

            <!-- Payee Details -->
            <div class="mb-4">
                <h5 class="text-info">Payee Details</h5>
                <ul class="list-group">
                    <li class="list-group-item"><strong>Account:</strong> {{ $response['data']['payee']['account'] }}</li>
                    <li class="list-group-item"><strong>Name:</strong> {{ $response['data']['payee']['name'] }}</li>
                </ul>
            </div>

            <!-- Miscellaneous -->
            <div>
                <h5 class="text-info">Miscellaneous</h5>
                <ul class="list-group">
                    <li class="list-group-item"><strong>Order ID:</strong> {{ $response['orderid'] }}</li>
                    <li class="list-group-item"><strong>Unique UUID:</strong> {{ $response['ipay_uuid'] }}</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
