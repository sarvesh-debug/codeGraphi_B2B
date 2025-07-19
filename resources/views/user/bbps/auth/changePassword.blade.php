@extends('user/include.layout')

@section('content')

@php
    $customer = session('customer');
    $outlet = session('outlet');
    $role = session('role');
@endphp

<style>
    body, html {
        height: 100%;
        margin: 0;
    }
    .center-container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        background-color: #f9f9f9;
    }
    .change-password-card {
        width: 100%;
        max-width: 400px;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        background-color: #fff;
    }
    .btn {
        background-color: #4caf50;
        color: #fff;
    }
    .btn:hover {
        background-color: #45a049;
        color: #fff;
    }
</style>

<div class="center-container">
   
    <div class="change-password-card">
        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
        <h3 class="text-center mb-4">Change Password</h3>
        <form action="{{ route('password.updateProfile') }}" method="POST">
            @csrf
            <input type="hidden" name="mobile" value="{{ $customer->phone }}">
            <input type="hidden" name="email" value="{{ $customer->email }}">
            
            {{-- <div class="mb-3">
                <label for="current-password" class="form-label">Current Password</label>
                <input type="password" class="form-control" id="current-password" name="current_password" placeholder="Enter current password" required>
            </div> --}}
            
            <div class="mb-3">
                <label for="new-password" class="form-label">New Password</label>
                <input type="password" class="form-control" id="new-password" name="password" placeholder="Enter new password" required>
            </div>
            
            <div class="mb-3">
                <label for="confirm-password" class="form-label">Confirm New Password</label>
                <input type="password" class="form-control" id="confirm-password" name="password_confirmation" placeholder="Confirm new password" required>
            </div>
            
            <button type="submit" class="btn btn-block w-100">Update Password</button>
        </form>
    </div>
</div>

@endsection
