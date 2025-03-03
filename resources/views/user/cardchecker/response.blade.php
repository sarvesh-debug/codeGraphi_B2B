@extends('user/include.layout')

@section('content')
<style>
    .result-box {
        margin: 20px;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .error-box {
        background-color: #f8d7da;
        border-color: #f5c6cb;
        color: #721c24;
    }
    .insufficient-box, .duplicate-box {
        background-color: #fff3cd;
        border-color: #ffeeba;
        color: #856404;
    }
    .success-box {
        background-color: #d4edda;
        border-color: #c3e6cb;
        color: #155724;
    }
    .data-section {
        margin-bottom: 15px;
    }
</style>

<div class="container">
    <h1 class="mt-5">Bin Checker Result</h1>
    
    @if(isset($result['statuscode']) && $result['statuscode'] == 'SNA')
        <!-- Error Case -->
        <div class="result-box error-box">
            <h4>Error: {{ $result['status'] }}</h4>
            <div class="data-section">
                <strong>Status Code:</strong> {{ $result['statuscode'] }}<br>
                {{-- <strong>Timestamp:</strong> {{ $result['timestamp'] }}<br>
                <strong>IPay UUID:</strong> {{ $result['ipay_uuid'] }}<br>
                <strong>Environment:</strong> {{ $result['environment'] }}<br> --}}
            </div>
        </div>
    
    @elseif(isset($result['statuscode']) && $result['statuscode'] == 'IAB')
        <!-- Insufficient Wallet Balance Case -->
        <div class="result-box insufficient-box">
            <h4>Insufficient Wallet Balance</h4>
            <div class="data-section">
                <strong>Status Code:</strong> {{ $result['statuscode'] }}<br>
                {{-- <strong>Timestamp:</strong> {{ $result['timestamp'] }}<br>
                <strong>IPay UUID:</strong> {{ $result['ipay_uuid'] }}<br>
                <strong>Environment:</strong> {{ $result['environment'] }}<br> --}}
            </div>
        </div>
    
    @elseif(isset($result['statuscode']) && $result['statuscode'] == 'DTX')
        <!-- Duplicate Transaction Case -->
        <div class="result-box duplicate-box">
            <h4>Duplicate Transaction Detected</h4>
            <div class="data-section">
                <strong>Status Code:</strong> {{ $result['statuscode'] }}<br>
                {{-- <strong>Record ID:</strong> {{ $result['data']['recordId'] ?? 'N/A' }}<br>
                <strong>Timestamp:</strong> {{ $result['timestamp'] }}<br>
                <strong>IPay UUID:</strong> {{ $result['ipay_uuid'] }}<br>
                <strong>Environment:</strong> {{ $result['environment'] }}<br> --}}
            </div>
        </div>
    
    @elseif(isset($result['statuscode']) && $result['statuscode'] == 'TXN')
        <!-- Success Case -->
        <div class="result-box success-box">

            
            <h5>Bin Details</h5>
            <div class="data-section">
                <strong>BIN:</strong> {{ $result['data']['binDetails']['bin'] }}<br>
                <strong>Card Network:</strong> {{ $result['data']['binDetails']['cardNetwork'] }}<br>
                <strong>Card Type:</strong> {{ $result['data']['binDetails']['cardType'] }}<br>
                <strong>Issuer Bank:</strong> {{ $result['data']['binDetails']['issuerBank'] ?: 'Not Available' }}<br>
                <strong>Card Transfer:</strong> {{ $result['data']['binDetails']['cardTransfer'] }}<br>
            </div>
        </div>
            {{-- <h4>Transaction Successful</h4>
            <div class="data-section">
                <strong>Status Code:</strong> {{ $result['statuscode'] }}<br>
                <strong>Timestamp:</strong> {{ $result['timestamp'] }}<br>
                <strong>IPay UUID:</strong> {{ $result['ipay_uuid'] }}<br>
                <strong>Order ID:</strong> {{ $result['orderid'] }}<br>
                
            </div>

            <h5>Pool Details</h5>
            <div class="data-section">
                <strong>Account:</strong> {{ $result['data']['pool']['account'] }}<br>
                <strong>Opening Balance:</strong> {{ $result['data']['pool']['openingBal'] }}<br>
                <strong>Mode:</strong> {{ $result['data']['pool']['mode'] }}<br>
                <strong>Amount:</strong> {{ $result['data']['pool']['amount'] }}<br>
                <strong>Closing Balance:</strong> {{ $result['data']['pool']['closingBal'] }}<br>
            </div> --}}

    
    @else
        <!-- Default Error Message -->
        <div class="alert alert-danger">
            <strong>Error:</strong> Unable to fetch data. Please try again later.
        </div>
    @endif

    <a href="{{ route('binChecker.form') }}" class="btn btn-primary mt-3">Check Another BIN</a>
</div>
    @endsection
