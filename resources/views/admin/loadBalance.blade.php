@extends('admin/include.layout')

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
        {{-- @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif --}}
        <h3 class="text-center mb-4">Load Balance</h3>
        <form action="{{ route('adminBalanceAdd') }}" method="POST">
            @csrf
        
    
            <div class="mb-3">
                <label for="confirm-password" class="form-label">Add Balance</label>
                <input type="number" class="form-control" id="confirm-password" name="balance" placeholder="Amount" required>
            </div>
            
            {{-- <button type="submit" class="btn btn-block w-100">Add Balance</button> --}}
            <button type="submit" class="btn gradient-btn btn-block w-100 text-white fw-semibold py-2">
                Add Balance
            </button>

        </form>
    </div>

</div>

<style>
    .gradient-btn {
    background: linear-gradient(135deg, #ff0000, #1e3c72);
    border: none;
    border-radius: 6px;
    transition: background 0.3s ease, transform 0.2s ease;
}

.gradient-btn:hover {
    background: linear-gradient(135deg, #1e3c72, #ff0000);
    transform: scale(1.03);
}

</style>

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
            {{-- <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div> --}}

            <div class="modal-footer justify-content-center">
                <button type="button" class="btn gradient-btn btn-sm text-white fw-semibold px-4 py-2" data-bs-dismiss="modal">
                    Close
                </button>
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
    });

    (function () {
        'use strict';
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
    })();
</script>

@endsection
