<!-- resources/views/user/pan/status.blade.php -->

@extends('user.include.layout')

@section('content')
@include('user.pan.navbar')

<div class="container my-5">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-info text-white text-center">
            <h3 class="mb-0">Check PAN Card Status</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('pan.status.submit') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="orderid" class="form-label fw-bold">Order ID <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-hash"></i>
                        </span>
                        <input type="text" class="form-control" name="orderid" id="orderid" required placeholder="Enter your unique Order ID">
                    </div>
                    <small class="form-text text-muted">The Order ID is required to track your PAN status.</small>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-info px-4 py-2 text-white">Check Status</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
