@extends('user/include.layout')

@section('content')  
<div class="container mt-4">
    @include('user.AEPS.navbar')
    <h1 class="text-center text-primary mb-4">Balance Statement</h1>

    {{-- Check for successful transaction --}}
    @if (isset($response['statuscode']) && $response['statuscode'] === 'TXN')
    <div id="printableArea">
        <img src="{{ asset('assets/img/icons/z-pay-logo.png') }}" width="20%" alt="" class="print-logo">
        <div class="card border-success mb-4">
            <div class="card-body">
                <h2 class="card-title text-success">Status: {{ $response['status'] }}</h2>
                <p class="card-text"><strong>Timestamp:</strong> {{ $response['timestamp'] }}</p>
                <p class="card-text"><strong>Order ID:</strong> {{ $response['orderid'] ?? 'N/A' }}</p>
            </div>
        </div>

        <div class="card border-info mb-4">
            <div class="card-body">
                <h3 class="card-title text-info">Bank Details</h3>
                <table class="table table-bordered">
                    <tr>
                        <th>Bank Name</th>
                        <td>{{ $response['data']['bankName'] }}</td>
                    </tr>
                    <tr>
                        <th>Account Number</th>
                        <td>{{ $response['data']['accountNumber'] }}</td>
                    </tr>
                    <tr>
                        <th>Bank Account Balance</th>
                        <td class="fw-bold text-primary">{{ $response['data']['bankAccountBalance'] }}</td>
                    </tr>
                 
                </table>
            </div>
        </div>

        {{-- Display mini statement --}}
        @if (!empty($response['data']['miniStatement']))
            <div class="card border-secondary">
                <div class="card-body">
                    <h3 class="card-title text-secondary">Mini Statement</h3>
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>Date</th>
                                <th>Type</th>
                                <th>Amount</th>
                                <th>Narration</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($response['data']['miniStatement'] as $statement)
                                <tr>
                                    <td>{{ $statement['date'] }}</td>
                                    <td>{{ $statement['txnType'] }}</td>
                                    <td>{{ $statement['amount'] }}</td>
                                    <td>{{ $statement['narration'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="alert alert-info mt-4">
                No mini statement available.
            </div>
        @endif
    </div>
    {{-- For error or any other status --}}
    <button onclick="printDiv('printableArea')" class="btn btn-primary mt-3">Print</button>
    @else
    <div class="alert alert-danger shadow-lg rounded p-4 text-center">
        <div class="mb-3">
            <i class="fas fa-exclamation-triangle fa-3x text-danger"></i>
        </div>
        <h2 class="alert-heading fw-bold">Attention Please</h2>
        <p class="mb-0 text-dark">
            {{ $response['status'] ?? 'An unknown error occurred.' }}
        </p>
    </div>
    
    @endif
    <a href="{{ route('balance.statement') }}" class="btn btn-success">Back</a>
</div>

<script>
    function printDiv(divId) {
        var printContents = document.getElementById(divId).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>

<!-- Auto-redirect script -->

@endsection
