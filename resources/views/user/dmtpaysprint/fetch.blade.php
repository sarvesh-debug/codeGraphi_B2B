@extends('user/include.layout') 

@section('content')
@include('user.dmtpaysprint.navbar')

<div class="container">
    <div class="row justify-content-center">
        <!-- Remitter Profile Section -->
        
<div class="card col-md-6 mx-auto shadow-lg border-0">
    <div class="card-header bg-success text-white text-center py-3">
        <h4 class="mb-0">Transaction</h4>
    </div>
    <div class="card-body p-4">
        <form action="{{ route('1fetch.beneficiary') }}" method="POST">
            @csrf
         <div class="form-group mb-3">
            <label for="mobile" class="form-label">Mobile Number</label>
            <input type="text" class="form-control" name="mobile" maxlength="10" required
             oninput="this.value = this.value.replace(/\D/g, '').slice(0,10)" />
         </div>

            {{-- <div class="form-group mb-3">
                <label for="benename" class="form-label">Beneficiary Name</label>
                <input type="text" class="form-control" name="benename" required>
            </div> --}}
            <button type="submit" class="btn btn-success w-100">Fetch</button>
        </form>
    </div>
</div>

        <!-- Latest Transactions Section -->
        <div class="col-md-6">
            <div class="card shadow-lg border-0 h-100">
                <div class="card-header bg-gradient-success text-white text-center py-3">
                    <h5 class="mb-0"><i class="fas fa-receipt me-2"></i>Latest Transactions</h5>
                </div>
                <div class="card-body p-4">
                 @if(!empty($latestTransactions) && count($latestTransactions) > 0)

                        @foreach($latestTransactions as $transaction)
                            <div class="transaction-item d-flex justify-content-between align-items-center py-3 border-bottom position-relative">
                                <div class="transaction-details">
                                    <strong class="text-primary">₹{{ $transaction['amount'] ?? 'N/A' }}</strong>
                                    <div class="small text-muted">{{ $transaction['date'] ?? 'N/A' }}</div>
                                </div>
                                <span 
                                    class="badge bg-{{ $transaction['status'] === 'success' ? 'success' : ($transaction['status'] === 'pending' ? 'warning' : 'danger') }} px-3 py-2">
                                    {{ ucfirst($transaction['status']) }}
                                </span>
                                <div class="transaction-icon position-absolute end-0 top-50 translate-middle-y me-3">
                                    <i class="fas fa-{{ $transaction['status'] === 'success' ? 'check-circle' : ($transaction['status'] === 'pending' ? 'hourglass-half' : 'times-circle') }} text-{{ $transaction['status'] === 'success' ? 'success' : ($transaction['status'] === 'pending' ? 'warning' : 'danger') }} fa-lg"></i>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="text-center text-muted mb-0">
                            <i class="fas fa-exclamation-circle me-2"></i>No recent transactions available.
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
