@extends('user.include.layout')

@section('content')
<div class="container-fluid px-4">
    <!-- Breadcrumb -->
    <ol class="breadcrumb mb-4 bg-light p-3 rounded shadow-sm">
        <li class="breadcrumb-item"><a href="{{ route('customer/dashboard') }}">🏠 Home</a></li>
        <li class="breadcrumb-item active">💸 Send Money</li>
    </ol>

    <!-- Alert Messages -->
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('alert'))
        <script>
            alert("{{ session('alert') }}");
            window.location.href = "{{ route('remProfile') }}";
        </script>
    @endif

    <!-- Form Wrapper with top margin -->
    <div class="d-flex justify-content-center mt-5">
        <div class="card shadow-lg border-0 w-100" style="max-width: 500px;">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="bi bi-send-fill me-2"></i>Send Money</h5>
            </div>

            <div class="card-body">
                <form action="{{ route('generateTransactionOtpDmt1') }}" method="POST" class="needs-validation" novalidate>
                    @csrf

                    <!-- Amount Field -->
                    <div class="form-group mb-3">
                        <label for="amount" class="form-label">💰 Amount</label>
                        <input type="number" name="amount" id="amount" min="100" class="form-control form-control-lg" placeholder="Enter amount (min ₹100)" required>
                    </div>

                    <!-- Hidden Fields -->
                    <input type="hidden" name="mobile" value="{{ $mobile }}">
                    <input type="hidden" name="beneName" value="{{ $beneName }}">
                    <input type="hidden" name="account" value="{{ $account }}">
                    <input type="hidden" name="ifsc" value="{{ $ifsc }}">
                    <input type="hidden" name="email" value="{{ $email }}">
                   

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-success btn-lg w-100 mt-3">
                        <i class="bi bi-lightning-charge-fill me-2"></i>Send Money
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
