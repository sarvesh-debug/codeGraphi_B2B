@extends('admin/include.layout')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 50vh; padding-top: 20px;">
    <div class="col-md-6">
        <div class="card shadow-lg border-0 rounded-lg">
            {{-- <div class="card-header bg-dark text-white text-center">
                <h3 class="mb-0" style="color:aliceblue; font-weight: bold;" >New Member</h3>
            </div> --}}

            <div class="card-header brand-logo-gradient ">
                <h3 class="mb-0 text-white">New Member</h3>
            </div>

            <style>
                .brand-logo-gradient {
                    background: linear-gradient(135deg, #e60000, #000066); /* red to blue */
                    color: white;
                    text-align: center;
                    padding: 10px 15px;
                    border-top-left-radius: 10px;
                    border-top-right-radius: 10px;
                }

                .brand-logo-gradient:hover {
                    background: linear-gradient(135deg, #e60000, #000066); /* red to blue */
                    color: white;
                    text-align: center;
                    padding: 10px 15px;
                    border-top-left-radius: 10px;
                    border-top-right-radius: 10px;
                }
            </style>

            <div class="card-body">
                {{-- @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif --}}
                
                <form action="{{ route('user.reg') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" required>
                        @error('name')<small class="text-danger">{{ $message }}</small>@enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="owner" class="form-label">Shop Name</label>
                        <input type="text" class="form-control" id="owner" name="owner" placeholder="Enter Shop Name" required>
                        @error('owner')<small class="text-danger">{{ $message }}</small>@enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="phone" class="form-label">Mobile No (as per Aadhar Link)</label>
                        <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter Mobile Number" maxlength="10" required>
                        @error('phone')<small class="text-danger">{{ $message }}</small>@enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Id</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" required>
                        @error('email')<small class="text-danger">{{ $message }}</small>@enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" required>
                        @error('password')<small class="text-danger">{{ $message }}</small>@enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" required>
                        @error('password_confirmation')<small class="text-danger">{{ $message }}</small>@enderror
                    </div>
                    
                    <input type="hidden" name="pin" value="0">
                    <input type="hidden" name="balance" value="0">
                    
                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-control" id="role" name="role" required>
                            <option value="">Select Role</option>
                            <option value="Retailer">Retailer</option>
                            <option value="distibuter">Distributor</option>
                            <option value="sd">Super Distributor</option>
                            <option value="rm">Relationship Manager</option>
                        </select>
                        @error('role')<small class="text-danger">{{ $message }}</small>@enderror
                    </div>
                    
                    <div class="text-center">
                        <button type="submit" class="btn brand-logo-gradient p-2 w-100">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal Structure -->
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
                <button type="button" class="btn btn-secondary btn-sm gradient-btn py-2 px-4" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
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
