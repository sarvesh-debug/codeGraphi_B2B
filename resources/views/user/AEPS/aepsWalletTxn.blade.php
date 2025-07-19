@extends('user/include.layout')

@section('content') 


<div class="container mt-5">
    <div class="col-md-6 mx-auto bg-white shadow rounded p-4 border">
        <h2 class="text-center fw-bold mb-4 text-dark">Transfer AEPS Wallet to Main Wallet</h2>

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{route('wallet.tsfr')}}" method="POST" onsubmit="return confirmTransfer()">
            @csrf

            <!-- Amount Field -->
            <div class="mb-3">
                <label for="amount" class="form-label">Amount <span class="text-danger">*</span></label>
                <input type="number" name="amount" id="amount" class="form-control" required>
            </div>

            <!-- Remarks Field -->
            <div class="mb-3">
                <label for="remarks" class="form-label">Remarks (optional)</label>
                <input type="text" name="remarks" id="remarks" class="form-control">
            </div>
 <!-- Important Note -->
        <div class="alert alert-warning">
            <strong>Note:</strong> Once you transfer your AEPS Wallet balance to the Main Wallet, you <strong>cannot</strong> transfer it back to the AEPS Wallet.
        </div>
            <!-- Submit Button -->
            <div class="d-grid">
                <button type="submit" class="btn btn-primary fw-semibold">
                    🚀 Transfer Now
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Confirmation Script --}}
<script>
    function confirmTransfer() {
        return confirm("Are you sure you want to transfer the amount from AEPS Wallet to Main Wallet?");
    }
</script>

@endsection
