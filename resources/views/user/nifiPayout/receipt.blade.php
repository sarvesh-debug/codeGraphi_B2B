@extends('user/include.layout')
@section('content')

@php
    $data = $response['data'] ?? [];
    $deduction = $response['deduction'] ?? [];
    $txnValue = $transaction->amount ?? 0;
    $chargesAmount = $transaction->charges ?? 0;
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

<style>
    @media print {
        .btn, .back-btn {
            display: none !important;
        }
    }
</style>

<div class="container mt-5">
    <div class="card shadow-lg border-0">
        <div class="card-header text-white {{ $transaction->status === 'success' ? 'bg-success' : 'bg-danger' }}">
            <h4 class="mb-0 text-center">{{ ucfirst($transaction->status) }} Receipt</h4>
        </div>

        <div class="card-body p-4" id="printableArea">
            <div class="text-center mb-4">
                <img src="{{ asset('assets/img/icons/codegraphi-logo.png') }}" width="150px" alt="CodeGraphi">
                <h5 class="mt-2">Transaction Receipt</h5>
            </div>

            <p><strong>Retailer ID:</strong> {{ $transaction->rtId }}</p>
            <p><strong>Name:</strong> {{ $transaction->name }}</p>
            <p><strong>Mobile:</strong> {{ $transaction->mobile }}</p>
            <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($transaction->created_at)->format('d M Y, h:i A') }}</p>

            <hr>

            <h6><strong>Transaction Summary</strong></h6>
            <p><strong>Order ID:</strong> {{ $data['externalRef'] ?? 'N/A' }}</p>
            <p><strong>Bank Ref No:</strong> {{ $data['bank_ref_num'] ?? 'N/A' }}</p>
            <p><strong>Pay ID:</strong> {{ $response['apiTxnId'] ?? 'N/A' }}</p>
            <p><strong>Account No:</strong> {{ $data['account'] ?? 'N/A' }}</p>
            <p><strong>IFSC:</strong> {{ $data['ifsc'] ?? 'N/A' }}</p>

            <table class="table table-bordered text-center mt-3">
                <thead>
                    <tr>
                        <th>Amount</th>
                        <th>Charges</th>
                        <th>TDS</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>₹{{ number_format($txnValue, 2) }}</td>
                        <td>₹{{ number_format($chargesAmount, 2) }}</td>
                        <td>₹{{ number_format($transaction->tds, 2) }}</td>
                        <td>₹{{ number_format($totalAmount, 2) }}</td>
                    </tr>
                </tbody>
            </table>

            <p><strong>Amount in Words:</strong> {{ $amountInWords }} Rupees Only</p>

            <div class="text-center mt-4">
                <em>This is a system-generated receipt and does not require a signature.</em>
            </div>
        </div>

        <div class="card-footer text-center">
            <button onclick="printDiv('printableArea')" class="btn btn-primary">Print</button>
            <a href="{{ route('historyUPI') }}" class="btn btn-secondary back-btn">Back</a>
        </div>
    </div>
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
