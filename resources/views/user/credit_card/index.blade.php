@extends('user/include.layout')
@section('content')
@include('user.credit_card.navbar')
@php
    $customer = session('customer');
    $outlet=session('outlet');
@endphp
<div class="card col-md-6 mx-auto shadow-lg border-0">
    <div class="card-header bg-success text-white text-center py-3">
        <h4 class="mb-0">Apply for Credit Card</h4>
    </div>
    <div class="card-body p-4">
        <form action="{{ route('credit_card.store') }}" method="POST">
            @csrf
            <div class="form-group mb-3">
                <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group mb-3">
                <label for="phone" class="form-label">Phone Number <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="phone" name="phone" required>
            </div>
            <div class="form-group mb-3">
                <label for="pincode" class="form-label">Pincode</label>
                <input type="text" class="form-control" id="pincode" name="pincode">
            </div>
            <div class="form-group mb-3">
                <label for="pan_no" class="form-label">PAN Number <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="pan_no" name="pan_no" required>
            </div>
            <div class="form-group mb-3">
                <label for="bank" class="form-label">Select Bank <span class="text-danger">*</span></label>
                <select class="form-control" id="bank" name="bank" required>
                   
                    <option value="HSBC_Visa">HSBC Visa Platinum Card</option>
                    <option value="HSBC_Cashback">HSBC Cashback Card</option>
                    <option value="AU_Bank">AU Bank</option>
                    <option value="AU_Swipeup">AU Swipeup</option>
                    <option value="HDFC">HDFC Bank</option>
                    <option value="IDFC">IDFC First Bank</option>
                    <option value="ICICI">ICICI Bank</option>
                    <option value="SBI">SBI Card (Apply via App)</option>
                    <option value="Jupiter">Jupiter Money</option>
                    <option value="HDFC_Tata">HDFC Tata Neu</option>
                    <option value="YES_POP">Yes POP Card</option>
                    <option value="IndusInd">IndusInd Bank</option>
                    <option value="Axis">Axis Bank</option>
                    
                    
                    
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="retailer_name" class="form-label">Retailer Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" value="{{ $customer->name }}" id="retailer_name" name="retailer_name" required readonly>
            </div>
            <div class="form-group mb-3">
                <label for="retailer_username" class="form-label">Retailer Username <span class="text-danger">*</span></label>
                <input type="text" class="form-control" value="{{ $customer->username }}" id="retailer_username" name="retailer_username" required readonly>
            </div>
            <button type="submit" class="btn btn-primary w-100">Submit Application</button>
        </form>
    </div>
</div>
@if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session('success') }}',
            confirmButtonText: 'OK'
        });
    </script>
@endif
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@endsection
