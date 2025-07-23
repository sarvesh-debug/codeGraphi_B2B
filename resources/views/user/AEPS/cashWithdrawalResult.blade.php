@extends('user/include.layout')
@section('content')

<style>
    body {
        background-color: #f8f9fa;
    }
    .card {
        border-radius: 15px;
    }
    .card-header {
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
        font-size: 1.5rem;
        font-weight: bold;
    }
    .card-body p {
        font-size: 1.1rem;
        margin-bottom: 8px;
    }
    .btn {
        border-radius: 20px;
        padding: 10px 20px;
        font-size: 1rem;
    }
    @media print {
        body {
            background-color: white;
        }
        .btn {
            display: none;
        }
        .print-logo {
            display: block !important;
        }
    }
</style>

<div class="container mt-4">
    @include('user.AEPS.navbar')
    <h1 class="text-center text-primary mb-4">Cash Withdrawal Statement</h1>

    @if (isset($responseData['statuscode']) && $responseData['statuscode'] === 'TXN')
        <div class="card col-md-8 mx-auto shadow-lg border-0" id="transaction-slip">
            <div class="card-header text-center py-3 bg-success text-white">
                <h4 class="mb-0">Transaction Successful</h4>
            </div>

            <div class="card-body p-4" id="printableArea">
                <div class="text-center">
                    <img src="{{ asset('assets/img/icons/codegraphi-logo.png') }}" width="20%" alt="Logo" class="print-logo">
                </div>
                <h5 class="text-center my-3">AEPS Withdrawal Receipt</h5>
                <h6><strong>Retailler Details</strong></h6>
            <p><strong>Name:</strong> {{ session('user_name') }}
            <strong>Mobile:</strong> {{ session('mobile') }}</p>
                <h6><strong>Status:</strong> {{ $responseData['status'] }}</h6>
                <p><strong>Timestamp:</strong> {{ $responseData['timestamp'] }}
                <strong>Order ID:</strong> {{ $responseData['orderid'] }}</p>
                
                <h6 class="mt-4"><strong>Bank Details</strong></h6>
                <table class="table table-bordered text-center">
                    <tbody>
                        <tr><th>Bank Name</th><td>{{ $responseData['data']['bankName'] }}</td></tr>
                        <tr><th>Account Number</th><td>{{ $responseData['data']['accountNumber'] }}</td></tr>
                        <tr><th>Transaction Amount</th><td class="fw-bold text-primary">{{ $responseData['data']['transactionValue'] }}</td></tr>
                        <tr><th>Bank Account Balance</th><td class="text-primary">{{ $responseData['data']['bankAccountBalance'] }}</td></tr>
                        {{-- <tr><th>Transaction Mode</th><td>{{ $responseData['data']['transactionMode'] }}</td></tr> --}}
                    </tbody>
                </table>
                
                @if (!empty($responseData['data']['miniStatement']))
                    <h6 class="mt-4"><strong>Mini Statement</strong></h6>
                    <table class="table table-striped table-hover table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>Date</th>
                                <th>Type</th>
                                <th>Amount</th>
                                <th>Narration</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($responseData['data']['miniStatement'] as $statement)
                                <tr>
                                    <td>{{ $statement['date'] }}</td>
                                    <td>{{ $statement['txnType'] }}</td>
                                    <td>{{ $statement['amount'] }}</td>
                                    <td>{{ $statement['narration'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
        <button onclick="printDiv('printableArea')" class="btn btn-primary mt-3">Print</button>
    @else
        <div class="alert alert-danger text-center shadow-lg p-4 rounded">
            <h2 class="alert-heading fw-bold">Attention Please</h2>
            <p class="mb-0 text-dark">{{ $status ?? 'An unknown error occurred. Please try again.' }}</p>
        </div>
    @endif  
    
    <a href="{{ route('cash.withdrawal.form') }}" class="btn btn-info mt-3">Back</a>
</div>

<script>
    function printDiv(divId) {
        var printContents = document.getElementById(divId).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
        location.reload();
    }
</script>
@endsection
