@extends('admin/include.layout')  
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
    }
</style>

@php
    $decoded = json_decode($response->response_data, true);
    $data = $decoded['data'] ?? [];
    $status = $decoded['status'] ?? 'Transaction Error';
    $statuscode = $decoded['statuscode'] ?? 'ERR';
    $timestamp = $decoded['timestamp'] ?? now();

    $txnValue = $data['txnValue'] ?? 0;
    $commissionAmount = $response->commission ?? 0;
    $chargesAmount = $response->charges ?? 0;
    $totalAmount = $txnValue + $chargesAmount;

    function numberToWords($number) {
        $words = [
            0 => '', 1 => 'One', 2 => 'Two', 3 => 'Three', 4 => 'Four', 5 => 'Five',
            6 => 'Six', 7 => 'Seven', 8 => 'Eight', 9 => 'Nine', 10 => 'Ten',
            11 => 'Eleven', 12 => 'Twelve', 13 => 'Thirteen', 14 => 'Fourteen',
            15 => 'Fifteen', 16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
            19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty', 40 => 'Forty',
            50 => 'Fifty', 60 => 'Sixty', 70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety'
        ];

        if ($number < 21) return $words[$number];
        elseif ($number < 100) return $words[10 * floor($number / 10)] . ' ' . $words[$number % 10];
        elseif ($number < 1000) return $words[floor($number / 100)] . ' Hundred ' . numberToWords($number % 100);
        elseif ($number < 100000) return numberToWords(floor($number / 1000)) . ' Thousand ' . numberToWords($number % 1000);
        return '';
    }

    $amountInWords = numberToWords((int)$txnValue);
@endphp

<div class="card col-md-8 mx-auto shadow-lg border-0 mt-5" id="transaction-slip">
    <div class="card-header text-center py-3 {{ $statuscode === 'TXN' ? 'bg-success text-white' : 'bg-danger text-white' }}">
        <h4 class="card-heading mb-0">{{ $status }}</h4>
    </div>

    <div class="card-body p-4">
        <div id="printableArea">
            <div class="text-center">
                <img src="{{ asset('assets/img/icons/codegraphi-logo.png') }}" width="20%" alt="Logo" class="print-logo">
            </div>
            <h5 class="text-center my-3">Transaction Receipt</h5>

            @if($statuscode === 'TXN')
                <h6><strong>Sender Details</strong></h6>
                <p><strong>Name:</strong> {{ session('user_name') }}</p>
                <p><strong>Mobile:</strong> {{ session('mobile') }}</p>
                <p><strong>Date:</strong> {{ date('d-m-Y', strtotime($timestamp)) }}</p>

                <h6 class="mt-4"><strong>Transaction Details</strong></h6>
                <p><strong>Transaction ID:</strong> {{ $data['txnReferenceId'] ?? 'N/A' }}</p>
                <p><strong>Transaction Status:</strong> {{ $status }}</p>

                <h6 class="mt-4"><strong>Transaction Summary</strong></h6>
                <table class="table table-bordered text-center">
                    <thead>
                        <tr>
                            <th>Beneficiary</th>
                            <th>Amount (INR)</th>
                            <th>Charges (INR)</th>
                            <th>Total Amount (INR)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $data['beneficiaryName'] ?? 'N/A' }}</td>
                            <td>{{ number_format($txnValue, 2) }}</td>
                            <td>{{ number_format($chargesAmount, 2) }}</td>
                            <td>{{ number_format($totalAmount, 2) }}</td>
                        </tr>
                    </tbody>
                </table>

                <p><strong>Total Amount in Words:</strong> {{ $amountInWords }} Rupees Only</p>

                <h6 class="mt-4"><strong>Bank Details</strong></h6>
                <p><strong>Account Number:</strong> {{ $data['beneficiaryAccount'] ?? 'N/A' }}</p>
                <p><strong>IFSC Code:</strong> {{ $data['beneficiaryIfsc'] ?? 'N/A' }}</p>
                <p><strong>Remittance Type:</strong> {{ $data['remittanceType'] ?? 'IMPS' }}</p>

                <p class="mt-3"><em>Transaction charges are inclusive of GST.</em></p>
                <p class="mt-1"><small>Min Rs. 10, Max 1% or Rs. 50 (for Rs. 5,000 transaction), whichever is lower (inclusive of applicable GST).</small></p>

                <p class="text-center mt-4"><em>Note: This is a computer-generated receipt and does not require any physical signature.</em></p>
            @else
                <div class="text-center">
                    <h5 class="text-danger">Error Details</h5>
                    <p><strong>Error Message:</strong> Transaction failed or data missing</p>
                </div>
            @endif
        </div>
    </div>

    <div class="card-footer text-center">
        <button onclick="printDiv('printableArea')" class="btn btn-primary shadow-sm">Print</button>
        <a href="{{ route('dmt1Report') }}" class="btn btn-success shadow-sm">Back</a>
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
