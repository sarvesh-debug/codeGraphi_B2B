@extends('user/include.layout')

@section('content')

<div class="container py-5 d-flex justify-content-center">
    <div class="col-lg-6 col-md-8 col-sm-12">
        
        <div id="screenshot-area" class="card shadow-lg border-success">
            <div class="card-header bg-success text-white text-center">
                <h4 class="mb-0">✅ Transaction Successful</h4>
            </div>
            <div class="card-body">

                <div class="alert alert-success text-center">
                    <strong>Transaction Completed Successfully</strong>
                </div>

                <ul class="list-group">
                    <li class="list-group-item">
                        <strong>Reference ID:</strong>
                        <span class="float-end">{{ $response['data']['referenceId'] ?? 'N/A' }}</span>
                    </li>
                    <li class="list-group-item">
                        <strong>Amount:</strong>
                        <span class="float-end">₹{{ $response['data']['amount'] ?? 'N/A' }}</span>
                    </li>
                    <li class="list-group-item">
                        <strong>Status:</strong>
                        <span class="float-end text-success fw-bold">{{ $response['data']['status'] ?? 'N/A' }}</span>
                    </li>
                    <li class="list-group-item">
                        <strong>RRN (Bank Ref No):</strong>
                        <span class="float-end">{{ $response['data']['rrn'] ?? 'N/A' }}</span>
                    </li>
                    <li class="list-group-item">
                        <strong>Message:</strong>
                        <span class="float-end">{{ $response['data']['message'] ?? 'N/A' }}</span>
                    </li>
                </ul>

                <div class="mt-4 text-center">
                    <a href="{{ route('diform') }}" class="btn btn-outline-success">🔄 Make Another Transaction</a>
                </div>
            </div>
        </div>

         --}}

    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
    function captureScreenshot() {
        const element = document.getElementById('screenshot-area');
        html2canvas(element).then(canvas => {
            const link = document.createElement('a');
            link.download = 'upi-receipt.png';
            link.href = canvas.toDataURL('image/png');
            link.click();
        });
    }
</script>
@endpush
