@extends('admin/include.layout')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-success text-white text-center">
            <h3>Add Bank Details</h3>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('bankdetails.update', $bankDetail->id) }}" method="POST" class="needs-validation" novalidate>
                @csrf

                <div class="form-group mb-3">
                    <label for="bank_name" class="form-label">Bank Name</label>
                    <input type="text" name="bank_name" id="bank_name" class="form-control" value="{{ $bankDetail->bank_name }}" placeholder="Enter bank name" required>
                    <div class="invalid-feedback">Please enter the bank name.</div>
                </div>

                <div class="form-group mb-3">
                    <label for="ifsc" class="form-label">IFSC</label>
                    <input type="text" name="ifsc" id="ifsc" class="form-control" value="{{ $bankDetail->ifsc }}" placeholder="Enter IFSC code" required>
                    <div class="invalid-feedback">Please enter the IFSC code.</div>
                </div>

                <div class="form-group mb-3">
                    <label for="account_no" class="form-label">Account Number</label>
                    <input type="text" name="account_no" id="account_no" class="form-control" value="{{ $bankDetail->account_no }}" placeholder="Enter account number" required>
                    <div class="invalid-feedback">Please enter the account number.</div>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-success">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Example JavaScript for disabling form submissions if there are invalid fields
    (function () {
        'use strict'

        const forms = document.querySelectorAll('.needs-validation')

        Array.from(forms).forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }

                form.classList.add('was-validated')
            }, false)
        })
    })()
</script>
@endsection