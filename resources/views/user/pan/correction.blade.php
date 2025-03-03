<!-- resources/views/user/pan/correction.blade.php -->

@extends('user.include.layout')

@section('content')
@include('user.pan.navbar')

<div class="container my-5">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-warning text-white text-center">
            <h3 class="mb-0">Submit PAN Correction Request</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('pan.correction.submit') }}" method="POST">
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

                {{-- <div class="mb-4">
                    <label for="number" class="form-label fw-bold">Order Id <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-telephone"></i>
                        </span>
                        <input type="text" class="form-control" name="orderid" id="orderid" required placeholder="Enter your Order Id">
                    </div>
                    <small class="form-text text-muted">Required for verification purposes.</small>
                </div> --}}

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
                    <button type="submit" class="btn btn-warning px-4 py-2 text-white">Submit PAN Correction</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
