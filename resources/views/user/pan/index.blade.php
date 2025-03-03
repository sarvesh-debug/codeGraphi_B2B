
<!-- resources/views/user/pan/new.blade.php -->

@extends('user.include.layout')
@section('content')

@include('user.pan.navbar')

<div class="container my-5">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-success text-white text-center">
            <h3 class="mb-0">Submit New PAN Card Request</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('pan.new.submit') }}" method="POST" target="_blank">
                @csrf
                <div class="mb-4">
                    <label for="number" class="form-label fw-bold">Mobile Number <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-telephone"></i>
                        </span>
                        <input type="text" class="form-control" name="number" id="number" required placeholder="Enter your 10-digit mobile number" pattern="\d{10}">
                    </div>
                    <small class="form-text text-muted">Required for verification purposes.</small>
                </div>

                <div class="mb-4">
                    <label for="mode" class="form-label fw-bold">Mode <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-pencil-square"></i>
                        </span>
                        <select class="form-select" name="mode" id="mode" required>
                            <option value="EKYC">EKYC (PAN without signature)</option>
                            <option value="ESIGN">ESIGN (PAN with signature and photo)</option>
                        </select>
                    </div>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-success px-4 py-2">Submit New PAN</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

{{-- @extends('user.include.layout')

@section('content')


<div class="container">
    <h2>NSDL PAN Card API Form</h2>
    <form action="{{ route('pan.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="api_type" class="form-label">API Type</label>
            <select class="form-select" id="api_type" name="api_type" required>
                <option value="new">New PAN Card</option>
                <option value="correction">PAN Card Correction</option>
                <option value="status">Check Status</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="orderid" class="form-label">Order ID</label>
            <input type="text" class="form-control" id="orderid" name="orderid" required>
        </div>

        <div class="mb-3" id="numberSection">
            <label for="number" class="form-label">Mobile Number</label>
            <input type="text" class="form-control" id="number" name="number" pattern="\d{10}" placeholder="10-digit mobile number">
        </div>

        <div class="mb-3" id="modeSection">
            <label for="mode" class="form-label">Mode</label>
            <select class="form-select" id="mode" name="mode">
                <option value="EKYC">EKYC (PAN without signature)</option>
                <option value="ESIGN">ESIGN (PAN with signature and photo)</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const apiType = document.getElementById('api_type');
        const numberSection = document.getElementById('numberSection');
        const modeSection = document.getElementById('modeSection');

        apiType.addEventListener('change', function() {
            if (apiType.value === 'status') {
                numberSection.style.display = 'none';
                modeSection.style.display = 'none';
            } else {
                numberSection.style.display = 'block';
                modeSection.style.display = 'block';
            }
        });
    });
</script>

@endsection --}}
