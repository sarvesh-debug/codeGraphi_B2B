@extends('user/include.layout')

@section('content')
@include('user.AEPS.navbar')
    <!-- Auto-Redirect Meta Tag -->
    <div class="container">
        <h2>Outlet Login Result</h2>
        
        @if ($type === 'error')
            <div class="alert alert-danger">
                <strong>Error:</strong> {{ $message }} <p> <b> Please Connect Your Admin </b></p>
            </div>
        @elseif ($type === 'success')
            <div class="alert alert-success">
                <strong>Success:</strong> {{ $message }}
            </div>
        @else
            <div class="alert alert-warning">
                <strong>Notice:</strong> {{ $message }}
            </div>
        @endif
    
        {{-- @if (!empty($pool))
        <h4>Pool Details</h4>
        <ul>
            <li><strong>Opening Balance:</strong> {{ $pool['openingBalance'] }}</li>
            <li><strong>Closing Balance:</strong> {{ $pool['closingBalance'] }}</li>
            <li><strong>Transaction Value:</strong> {{ $pool['transactionValue'] }}</li>
            <li><strong>Payable Value:</strong> {{ $pool['payableValue'] }}</li>
        </ul>
    @else
        <p>No pool data available.</p>
    @endif --}}
    
    @if (!empty($data))
        <h4>Transaction Data</h4>
        <ul>
           
        </ul>
    @else
        <p>No transaction data available.</p>
    @endif
        
        {{-- <h4>Full API Response</h4>
        <pre>{{ json_encode($responseData, JSON_PRETTY_PRINT) }}</pre> --}}
    </div>
@endsection
