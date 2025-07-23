@extends('user/include.layout')

@section('content')
<div class="container py-4">
    {{-- Print Button --}}
    <div class="d-flex justify-content-end mb-3">
        <button onclick="window.print()" class="btn btn-dark shadow-sm">
            🖨️ Print Receipt
        </button>
    </div>

    <div class="card shadow-lg rounded-4">
        <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
          
            <h4 class="mb-0">🟢 Transaction {{$msg}}</h4>
         
            
            <span class="badge bg-light text-dark">Txn ID: {{ $decryptedResponse['apiTxnId'] ?? $msg }}</span>
        </div>

        <div class="card-body">
            <h5 class="text-primary mb-3">🔎 Transaction Info</h5>
            <ul class="list-group mb-4">
                <!--<li class="list-group-item"><strong>Status Code:</strong> {{ $decryptedResponse['statuscode'] ?? ''}}</li>-->
                <!--<li class="list-group-item"><strong>Unique ID:</strong> {{ $decryptedResponse['uniqueId'] ?? '' }}</li>-->
                <li class="list-group-item"><strong>Message:</strong> {{ $decryptedResponse['message']  ?? ''}}</li>
                <!--<li class="list-group-item"><strong>Environment:</strong> {{ $decryptedResponse['environment']  ?? ''}}</li>-->
<li class="list-group-item">
    <strong>Timestamp:</strong> 
    {{ isset($decryptedResponse['timestamp']) ? \Carbon\Carbon::parse($decryptedResponse['timestamp'])->format('d M Y, h:i A') : 'N/A' }}
</li>
            </ul>

            <h5 class="text-primary mb-3">👤 Recipient Info</h5>
            <ul class="list-group mb-4">
                <li class="list-group-item"><strong>Name:</strong> {{ $decryptedResponse['data']['recipient_name'] ?? ''}}</li>
                <li class="list-group-item"><strong>Account No:</strong> {{ $decryptedResponse['data']['account']  ?? ''}}</li>
                <li class="list-group-item"><strong>IFSC:</strong> {{ $decryptedResponse['data']['ifsc_code']  ?? ''}}</li>
                <li class="list-group-item"><strong>Bank Ref:</strong> {{ $decryptedResponse['data']['bank_ref_num']  ?? ''}}</li>
                <li class="list-group-item"><strong>External Ref:</strong> {{ $decryptedResponse['data']['externalRef'] ?? ''}}</li>
            </ul>

            <h5 class="text-primary mb-3">💸 Deduction Info</h5>
            <ul class="list-group">
                <li class="list-group-item"><strong>Amount:</strong> ₹{{ $decryptedResponse['deduction']['amount'] ?? ''}}</li>
                <li class="list-group-item"><strong>Charges:</strong> ₹{{ $charges ?? 0 }}</li>
                <li class="list-group-item"><strong>Tax:</strong> ₹{{ $tds ?? 0 }}</li>
                <li class="list-group-item"><strong>Total Deduction:</strong> ₹{{ $total ?? 0 }}</li>
                <li class="list-group-item"><strong>Remaining Balance:</strong> ₹{{ $cl ?? 0}}</li>
            </ul>
        </div>

        <div class="card-footer text-end d-print-none">
            <a href="{{route('remProfile')}}" class="btn btn-outline-primary">Back</a>
        </div>
    </div>
</div>

{{-- Hide buttons when printing --}}
<style>
    @media print {
        .btn, .d-print-none {
            display: none !important;
        }
    }
</style>
@endsection
