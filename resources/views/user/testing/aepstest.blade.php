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
    @media screen {
        .print-logo {
            display: none;
        }
    }
    @media print {
        body {
            background-color: white;
        }
        .print-logo {
            display: block !important;
            margin-bottom: 15px;
        }
        .card {
            box-shadow: none !important;
            border: 2px solid #000;
        }
        .btn {
            display: none;
        }
    }
</style>
<div class="card col-md-8 mx-auto shadow-lg border-0 mt-5" id="transaction-slip">
    <div class="card-header text-center py-3 bg-success text-white">
        <h4 class="mb-0">Transaction Successful</h4>
    </div>
    <div class="card-body p-4">
        <div id="printableArea">
            <div class="text-center">
                <img src="{{ asset('assets/img/icons/z-pay-logo.png') }}" width="20%" alt="" class="print-logo">
            </div>
            <h5 class="text-center my-3">Transaction Details</h5>
            <p><strong>UTR :</strong> TXN123456789</p>
            <p><strong>Transaction Value:</strong> ₹10,000</p>
            <p><strong>External Reference:</strong> EXT987654321</p>
            <p><strong>Beneficiary Account:</strong> 123456789012</p>
            <p><strong>Beneficiary IFSC:</strong> ABCD0123456</p>
            <p><strong>Beneficiary Name:</strong> John Doe</p>
            <p class="mt-4"><strong>Timestamp:</strong> 2024-01-31 14:30:00</p>
        </div>
    </div>
    <div class="card-footer text-center">
        <button onclick="printDiv('printableArea')" class="btn btn-primary shadow-sm">Print</button>
        <a href="{{route('dmt.remitter-profile')}}" class="btn btn-success shadow-sm">Back</a>
    </div>
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

@endsection
