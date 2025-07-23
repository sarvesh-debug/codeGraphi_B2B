@extends('user/include.layout')

@section('content')
<div class="controller mt-3 mx-3">
    <div class="row">
        <!-- Navigation Bar -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Home</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{ route('dispalyQr1') }}">Scan QR</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>

    <!-- Success Message -->
    @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="row change mb-5">
        <div class="col-lg-6 mx-auto">
            <div class="shadow">
                <div class="card-header bg-success text-white text-center py-3">
                    <h4 class="mb-0"><span class="text-success1">Add</span> <span class="text-info1">Money</span></h4>
                </div>
                <div class="card-body mb-5">
                    <form action="{{ route('add.slip') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Bank Account -->
<div class="mb-3">
    <label for="bankSelect" class="form-label">Select Bank Account</label>
    <select class="form-select" id="bankSelect" name="bank" required>
        <option value="" selected disabled>Select a Bank</option>
        @foreach ($bankDetails as $bank)
            <option value="{{ $bank->id }}"
                data-ifsc="{{ $bank->ifsc }}"
                data-account-no="{{ $bank->account_no }}"
                data-charges="{{ $bank->charges }}"
                data-tds="{{ $bank->tds }}"
                data-transaction-type="{{ $bank->transaction_type }}">
                {{ $bank->bank_name }}
            </option>
        @endforeach
    </select>
</div>

<!-- IFSC Code -->
<div class="mb-3" id="ifscField" style="display: none;">
    <label for="ifscInput" class="form-label">IFSC Code</label>
    <input type="text" class="form-control" id="ifscInput" name="ifsc" readonly />
</div>

<!-- Account Number -->
<div class="mb-3" id="accountNoField" style="display: none;">
    <label for="accountNoInput" class="form-label">Account Number</label>
    <input type="text" class="form-control" id="accountNoInput" name="account_no" readonly />
</div>

<!-- Charges -->
<div class="mb-3" id="chargesField" style="display: none;">
    <label for="chargesInput" class="form-label">Charges %(₹)</label>
    <input type="text" class="form-control" id="chargesInput" name="charges" readonly />
    
    <!-- Transaction Type Display -->
    <p id="txnTypeText" class="text-muted mt-1" style="display: none;">
        Transaction Type: <span id="txnTypeValue"></span>
    </p>
</div>

<!-- TDS -->
<div class="mb-3" id="tdsField" style="display: none;">
    <label for="tdsInput" class="form-label">TDS %(₹)</label>
    <input type="text" class="form-control" id="tdsInput" name="tds" readonly />
</div>

                        <!-- Amount -->
                        <div class="mb-3">
                            <label for="amountInput" class="form-label">Amount</label>
                            <input type="number" class="form-control" id="amountInput" name="amount" placeholder="Enter the amount" required />
                        </div>

                        <!-- UTR/Transaction ID -->
                        <div class="mb-3">
                            <label for="utrInput" class="form-label">Transaction Id/UTR</label>
                            <input type="text" class="form-control" id="utrInput" name="utr" placeholder="Enter Transaction ID/UTR" required />
                        </div>

                        <!-- Date -->
                        <div class="mb-3">
                            <label for="dateInput" class="form-label">Date</label>
                            <input type="date" class="form-control" id="dateInput" name="date" required />
                        </div>

                        <!-- Mode of Transaction -->
                        <div class="mb-3">
                            <label for="modeSelect" class="form-label">Mode of Transaction</label>
                            <select class="form-select" id="modeSelect" name="mode" required>
                                <option value="" selected disabled>Select Mode</option>
                                <option value="IMPS">IMPS</option>
                                <option value="NEFT">NEFT</option>
                                <option value="RTGS">RTGS</option>
                                <option value="UPI">UPI</option>
                                <option value="CASH">Cash Deposit</option>
                            </select>
                        </div>

                        <!-- Slip Image Upload -->
                        <div class="mb-3">
                            <label for="slipImage" class="form-label">Slip Images (You can select multiple files)</label>
                            <input type="file" class="form-control" id="slipImage" name="slip_image[]" multiple accept="image/*" required />
                            <small class="form-text text-muted">Upload up to 10 files.</small>
                        </div>

                        <!-- Remark -->
                        <div class="mb-3">
                            <label for="remarkInput" class="form-label">Remark</label>
                            <input type="text" class="form-control" id="remarkInput" name="remark" placeholder="Any remarks (optional)" />
                        </div>

                        <!-- Hidden Fields -->
                        <input type="hidden" name="rt_id" value="{{ session('username') }}">
                        <input type="hidden" name="rt_name" value="{{ session('user_name') }}">
                        <input type="hidden" name="rt_mobile" value="{{ session('mobile') }}">

                        <!-- Submit Button -->
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript to autofill IFSC, Account No, Charges, TDS -->
<script>
document.getElementById('bankSelect').addEventListener('change', function () {
    const selectedOption = this.options[this.selectedIndex];

    const ifsc = selectedOption.getAttribute('data-ifsc');
    const accountNo = selectedOption.getAttribute('data-account-no');
    const charges = selectedOption.getAttribute('data-charges');
    const tds = selectedOption.getAttribute('data-tds');
    const txnType = selectedOption.getAttribute('data-transaction-type');

    // Show IFSC
    if (ifsc) {
        document.getElementById('ifscField').style.display = 'block';
        document.getElementById('ifscInput').value = ifsc;
    } else {
        document.getElementById('ifscField').style.display = 'none';
        document.getElementById('ifscInput').value = '';
    }

    // Show Account No
    if (accountNo) {
        document.getElementById('accountNoField').style.display = 'block';
        document.getElementById('accountNoInput').value = accountNo;
    } else {
        document.getElementById('accountNoField').style.display = 'none';
        document.getElementById('accountNoInput').value = '';
    }

    // Show Charges
    if (charges) {
        document.getElementById('chargesField').style.display = 'block';
        document.getElementById('chargesInput').value = charges;
    } else {
        document.getElementById('chargesField').style.display = 'none';
        document.getElementById('chargesInput').value = '';
    }

    // Show TDS
    if (tds) {
        document.getElementById('tdsField').style.display = 'block';
        document.getElementById('tdsInput').value = tds;
    } else {
        document.getElementById('tdsField').style.display = 'none';
        document.getElementById('tdsInput').value = '';
    }

    // Show Transaction Type
    if (txnType) {
        document.getElementById('txnTypeText').style.display = 'block';
        document.getElementById('txnTypeValue').textContent = txnType;
    } else {
        document.getElementById('txnTypeText').style.display = 'none';
        document.getElementById('txnTypeValue').textContent = '';
    }
});
</script>

@endsection
