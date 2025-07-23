@extends('user/include.layout')
@section('content')

<style>
    body {
        background-color: #f8f9fa;
        font-family: Arial, sans-serif;
    }
    .card {
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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
    table {
        width: 100%;
        border-collapse: collapse;
    }
    th, td {
        padding: 10px;
        border: 1px solid #ddd;
        text-align: left;
    }
    th {
        background-color: #f4f4f4;
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
    @include('user.bbps.navbar')
    <h1 class="text-center text-primary mb-4">Electricity Payment Receipt</h1>

    @if (isset($responseData['statuscode']) && $responseData['statuscode'] === 'TXN')
        <div class="card col-md-8 mx-auto shadow-lg border-0" id="transaction-slip">
            <div class="card-header text-center py-3 bg-success text-white">
                <h4 class="mb-0">Payment Successful</h4>
            </div>
            <div class="card-body p-4" id="printableArea">
                <div class="text-center">
                    <img src="{{ asset('assets/img/icons/codegraphi-logo.png') }}" width="20%" alt="Logo" class="print-logo">
                </div>
                <h5 class="text-center my-3">Transaction Details</h5>
                <p><strong>Status Code:</strong> {{ $responseData['statuscode'] }}</p>
                <p><strong>Status:</strong> {{ $responseData['status'] }}</p>
                <p><strong>Transaction Value:</strong> {{ $responseData['data']['txnValue'] }}</p>
                <p><strong>Transaction Reference ID:</strong> {{ $responseData['data']['txnReferenceId'] }}</p>
                
                <h6 class="mt-4"><strong>Biller Details</strong></h6>
                <table class="table table-bordered text-center">
                    <tr><th>Name</th><td>{{ $responseData['data']['billerDetails']['name'] }}</td></tr>
                    <tr><th>Account</th><td>{{ $responseData['data']['billerDetails']['account'] }}</td></tr>
                </table>

                <h6 class="mt-4"><strong>Bill Details</strong></h6>
                <table class="table table-striped table-hover table-bordered">
                    <tr><th>Customer Name</th><td>{{ $responseData['data']['billDetails']['CustomerName'] ?? 'N/A' }}</td></tr>
                    <tr><th>Bill Number</th><td>{{ $responseData['data']['billDetails']['BillNumber'] ?? 'N/A' }}</td></tr>
                    <tr><th>Bill Period</th><td>{{ $responseData['data']['billDetails']['BillPeriod'] ?? 'N/A' }}</td></tr>
                    <tr><th>Bill Date</th><td>{{ $responseData['data']['billDetails']['BillDate'] ?? 'N/A' }}</td></tr>
                    <tr><th>Bill Due Date</th><td>{{ $responseData['data']['billDetails']['BillDueDate'] ?? 'N/A' }}</td></tr>
                    <tr><th>Bill Amount</th><td class="fw-bold text-primary">{{ $responseData['data']['billDetails']['BillAmount'] ?? 'N/A' }}</td></tr>
                    <tr><th>CR NO</th><td class="fw-bold text-success">{{ $responseData['data']['billDetails']['CustomerParamsDetails'] ?? 'N/A' }}</td></tr>
                </table>
            </div>
        </div>
        <button onclick="printDiv('printableArea')" class="btn btn-primary mt-3">Print</button>
    @else
        <div class="alert alert-danger text-center shadow-lg p-4 rounded">
            <h2 class="alert-heading fw-bold">Attention Please</h2>
            <p class="mb-0 text-dark">{{ $status ?? 'An unknown error occurred. Please try again.' }}</p>
        </div>
    @endif  
    
    <a href="{{ route('electricityBill') }}" class="btn btn-info mt-3">Back</a>
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
