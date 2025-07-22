@extends('admin/include.layout')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-success text-white text-center">
            <h3 style="color:aliceblue; font-weight: bold;">Add Bank Details</h3>
        </div>
        <div class="card-body">

            <form action="{{ url('/bankdetails/store') }}" method="POST" class="needs-validation" novalidate>
                @csrf

                <div class="form-group mb-3">
                    <label for="bank_name" class="form-label">Bank Name</label>
                    <input type="text" name="bank_name" id="bank_name" class="form-control" placeholder="Enter bank name" required>
                    <div class="invalid-feedback">Please enter the bank name.</div>
                </div>

                <div class="form-group mb-3">
                    <label for="ifsc" class="form-label">IFSC</label>
                    <input type="text" name="ifsc" id="ifsc" class="form-control" placeholder="Enter IFSC code" required>
                    <div class="invalid-feedback">Please enter the IFSC code.</div>
                </div>

                <div class="form-group mb-3">
                    <label for="account_no" class="form-label">Account Number</label>
                    <input type="text" name="account_no" id="account_no" class="form-control" placeholder="Enter account number" required>
                    <div class="invalid-feedback">Please enter the account number.</div>
                </div>

                <div class="form-group mb-3">
                    <label for="transaction_type" class="form-label">Transaction Type</label>
                    <select name="transaction_type" id="transaction_type" class="form-select" required>
                        <option value="" disabled selected>Select transaction type</option>
                        <option value="IMPS">IMPS</option>
                        <option value="Cash Deposit">Cash Deposit</option>
                        <option value="NEFT">NEFT</option>
                        <option value="RTGS">RTGS</option>
                        <option value="UPI">UPI</option>
                    </select>
                    <div class="invalid-feedback">Please select a transaction type.</div>
                </div>

                <div class="form-group mb-3">
                    <label for="charges" class="form-label">Charges (₹)</label>
                    <input type="number" step="0.01" name="charges" id="charges" class="form-control" placeholder="Enter charges amount" required>
                    <div class="invalid-feedback">Please enter the charges.</div>
                </div>

                <div class="form-group mb-3">
                    <label for="tds" class="form-label">TDS (₹)</label>
                    <input type="number" step="0.01" name="tds" id="tds" class="form-control" placeholder="Enter TDS amount" required>
                    <div class="invalid-feedback">Please enter the TDS.</div>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content text-center">
            <div class="modal-body">
                @if(session('success'))
                    <img src="https://cdn-icons-png.flaticon.com/512/5610/5610944.png" alt="Success" width="80">
                    <h5 class="mt-2 text-dark">{{ session('success') }}</h5>
                @elseif(session('error'))
                    <img src="https://media.giphy.com/media/TqiwHbFBaZ4ti/giphy.gif" alt="Failed" width="80">
                    <h5 class="mt-2 text-danger">{{ session('error') }}</h5>
                @endif
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal" style="background: linear-gradient(to right, #0a22aa, #b62512); color: white; border: none;">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        @if(session('success') || session('error'))
            var modal = new bootstrap.Modal(document.getElementById('statusModal'));
            modal.show();
        @endif

        const forms = document.querySelectorAll('.needs-validation');
        Array.from(forms).forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    });
</script>
@endsection
