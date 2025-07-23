@extends('user/include.layout')
@section('content')

<div class="container py-4 d-flex justify-content-center">
    <div class="col-lg-6 col-md-8 col-sm-12">
        <h2 class="text-center mb-4">🔐 UPI Intent API Integration</h2>

        @if(session('response'))
            <div class="alert alert-info">
                <strong>API Response:</strong>
                <pre class="bg-light p-2 rounded">{{ json_encode(session('response'), JSON_PRETTY_PRINT) }}</pre>
            </div>
        @endif

        {{-- Step 1: Create Order --}}
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">Step 1: Create Order</div>
            <div class="card-body">
                <form method="POST" action="{{ route('digifintel.create') }}">
                    @csrf
                    <input class="form-control mb-3" name="amount" placeholder="Amount (e.g. 1.00)" required>
                    <input class="form-control mb-3" name="email" placeholder="Customer Email" required>
                    <input class="form-control mb-3" name="phone" placeholder="Customer Phone" required>
                    <button class="btn btn-primary w-100">Create Order</button>
                </form>
            </div>
        </div>

        {{-- Step 2: Pay Order --}}
        <div class="card mb-4">
            <div class="card-header bg-success text-white">Step 2: Pay Order</div>
            <div class="card-body">
                <form method="POST" action="{{ route('digifintel.payorder') }}">
                    @csrf
                    <input class="form-control mb-3" name="amount" placeholder="Amount" required>
                    <input class="form-control mb-3" name="referenceId" placeholder="Reference ID from Create Order" required>
                    <input class="form-control mb-3" name="payerVpa" placeholder="Payer VPA (e.g. name@bank)" required>
                    <input class="form-control mb-3" name="payerName" placeholder="Payer Name" required>
                    <input class="form-control mb-3" name="remarks" placeholder="Remarks" required>
                    <button class="btn btn-success w-100">Pay Order</button>
                </form>
            </div>
        </div>

        {{-- Step 3: Check Order Status --}}
        <div class="card mb-4">
            <div class="card-header bg-warning text-dark">Step 3: Check Order Status</div>
            <div class="card-body">
                <form method="POST" action="{{ route('digifintel.status') }}">
                    @csrf
                    <input class="form-control mb-3" name="referenceId" placeholder="Reference ID" required>
                    <button class="btn btn-warning w-100">Check Order Status</button>
                </form>
            </div>
        </div>

        {{-- Optional: UPI Intent Payment --}}
        <div class="accordion" id="optionalApis">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOptional">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOptional" aria-expanded="false">
                        Optional: UPI Intent & VPA Tools
                    </button>
                </h2>
                <div id="collapseOptional" class="accordion-collapse collapse" data-bs-parent="#optionalApis">
                    <div class="accordion-body">

                        {{-- Pay UPI Intent --}}
                        <div class="mb-3">
                            <form method="POST" action="{{ route('digifintel.payintent') }}">
                                @csrf
                                <input class="form-control mb-2" name="amount" placeholder="Amount" required>
                                <input class="form-control mb-2" name="referenceId" placeholder="Reference ID" required>
                                <input class="form-control mb-2" name="payerName" placeholder="Payer Name" required>
                                <input class="form-control mb-2" name="remarks" placeholder="Remarks" required>
                                <button class="btn btn-info w-100">Pay UPI Intent</button>
                            </form>
                        </div>

                        {{-- Check Intent Status --}}
                        <div class="mb-3">
                            <form method="POST" action="{{ route('digifintel.intentstatus') }}">
                                @csrf
                                <input class="form-control mb-2" name="referenceId" placeholder="Reference ID" required>
                                <button class="btn btn-dark w-100">Check Intent Status</button>
                            </form>
                        </div>

                        {{-- Verify VPA --}}
                        <div class="mb-3">
                            <form method="POST" action="{{ route('digifintel.verifyvpa') }}">
                                @csrf
                                <input class="form-control mb-2" name="referenceId" placeholder="Reference ID" required>
                                <input class="form-control mb-2" name="vpa" placeholder="VPA ID to verify" required>
                                <button class="btn btn-secondary w-100">Verify VPA</button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection
