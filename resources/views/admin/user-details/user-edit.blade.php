@extends('admin/include.layout')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Edit User</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Edit User</li>
    </ol>

    {{-- @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif --}}

    <div class="card">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Edit User Form
        </div>
        <div class="card-body">
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Name -->
                <div class="form-group mb-3">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
                    @error('name')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Shop Name -->
                <div class="form-group mb-3">
                    <label for="owner">Shop Name</label>
                    <input type="text" class="form-control" id="owner" name="owner" value="{{ $user->owner }}" required>
                    @error('owner')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Mobile No -->
                <div class="form-group mb-3">
                    <label for="phone">Mobile No (as per Aadhar Link)</label>
                    <input type="text" class="form-control" id="phone" name="phone" value="{{ $user->phone }}" maxlength="10" required>
                    @error('phone')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Email -->
                <div class="form-group mb-3">
                    <label for="email">Email Id</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
                    @error('email')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Address -->
                <div class="form-group mb-3">
                    <label for="address">Address (As per Aadhar)</label>
                    <textarea class="form-control" id="address" name="address" required>{{ $user->address_aadhar }}</textarea>
                    @error('address')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- City -->
                <div class="form-group mb-3">
                    <label for="city">City</label>
                    <input type="text" class="form-control" id="city" name="city" value="{{ $user->city }}" required>
                    @error('city')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- State -->
                <div class="form-group mb-3">
                    <label for="state">State</label>
                    <input type="text" class="form-control" id="state" name="state" value="{{ $user->state }}" required>
                    @error('state')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Pin -->
                <div class="form-group mb-3">
                    <label for="pin">Pin</label>
                    <input type="text" class="form-control" id="pin" name="pincode" value="{{ $user->pincode }}" maxlength="6" required>
                    @error('pin')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Aadhar No -->
                <div class="form-group mb-3">
                    <label for="aadhar_no">Aadhar No</label>
                    <input type="text" class="form-control" id="aadhar_no" name="aadhar_no" value="{{ $user->aadhar_no }}" required>
                    @error('aadhar_no')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Aadhar Front -->
                <div class="form-group mb-3">
                    <label for="aadhar_front">Aadhar Front Page Upload</label>
                    <input type="file" class="form-control" id="aadhar_front" name="aadhar_front">
                    <small class="text-muted">Previous Image: 
                        @if($user->aadhar_front)
                            <a href="{{$user->aadhar_front }}" target="_blank">View Image</a>
                        @else
                            Not Uploaded
                        @endif
                    </small>
                    @error('aadhar_front')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Aadhar Back -->
                <div class="form-group mb-3">
                    <label for="aadhar_back">Aadhar Back Page Upload</label>
                    <input type="file" class="form-control" id="aadhar_back" name="aadhar_back">
                    <small class="text-muted">Previous Image: 
                        @if($user->aadhar_back)
                            <a href="{{$user->aadhar_back}}" target="_blank">View Image</a>
                        @else
                            Not Uploaded
                        @endif
                    </small>
                    @error('aadhar_back')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- PAN No -->
                <div class="form-group mb-3">
                    <label for="pan_no">Pan No</label>
                    <input type="text" class="form-control" id="pan_no" name="pan_no" value="{{ $user->pan_no }}" required>
                    @error('pan_no')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Pan Image -->
                <div class="form-group mb-3">
                    <label for="pan_image">Pan Image Upload</label>
                    <input type="file" class="form-control" id="pan_image" name="pan_image">
                    <small class="text-muted">Previous Image: 
                        @if($user->pan_image)
                            <a href="{{$user->pan_image }}" target="_blank">View Image</a>
                        @else
                            Not Uploaded
                        @endif
                    </small>
                    @error('pan_image')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Bank Details -->
                <div class="form-group mb-3">
                    <label for="account_no">Account No</label>
                    <input type="text" class="form-control" id="account_no" name="account_no" value="{{ $user->account_no }}" required>
                    @error('account_no')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="ifsc_code">IFSC Code</label>
                    <input type="text" class="form-control" id="ifsc_code" name="ifsc_code" value="{{ $user->ifsc_code }}" required>
                    @error('ifsc_code')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="bank_name">Bank Name</label>
                    <input type="text" class="form-control" id="bank_name" name="bank_name" value="{{ $user->bank_name }}" required>
                    @error('bank_name')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label for="bank_document">Bank Document Upload</label>
                    <input type="file" class="form-control" id="bank_document" name="bank_document">
                    <small class="text-muted">Previous Document: 
                        @if($user->bank_document)
                            <a href="{{ $user->bank_document }}" target="_blank">View Document</a>
                        @else
                            Not Uploaded
                        @endif
                    </small>
                    @error('bank_document')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <label for="pin">OutLet</label>
                    <input type="text" class="form-control" id="pin" name="pin" value="{{ $user->pin }}" maxlength="6" required>
                    @error('pin')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Owner -->
                

                <!-- Balance -->
                <div class="form-group mb-3">
                    <label for="balance">Balance</label>
                    <input type="number" readonly class="form-control" id="balance" name="balance" value="{{ $user->balance }}" required>
                    @error('balance')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Role -->
                @if ( $user->role == 'distibuter')
                    
                <div class="form-group mb-3">
                    <label for="role">Role</label>
                   
                    <select class="form-control" id="role" name="role" required>
                        {{-- <option value="User" {{ $user->role == 'User' ? 'selected' : '' }}>User</option> --}}
                        {{-- <option value="Retailer" {{ $user->role == 'Retailer' ? 'selected' : '' }}>Retailer</option> --}}
                        <option value="distibuter" {{ $user->role == 'distibuter' ? 'selected' : '' }}>Distributor</option>
                    </select>
                    @error('role')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div> 
                @elseif($user->role == 'sd')
                    <div class="form-group mb-3">
                    <label for="role">Role</label>
                   
                    <select class="form-control" id="role" name="role" required>
                        {{-- <option value="User" {{ $user->role == 'User' ? 'selected' : '' }}>User</option> --}}
                        {{-- <option value="Retailer" {{ $user->role == 'Retailer' ? 'selected' : '' }}>Retailer</option> --}}
                        <option value="sd" {{ $user->role == 'sd' ? 'selected' : '' }}>Super Distributor</option>
                    </select>
                    @error('role')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div> 
                @else
                <div class="form-group mb-3">
                    <label for="role">Role</label>
                   
                    <select class="form-control" id="role" name="role" required>
                        {{-- <option value="User" {{ $user->role == 'User' ? 'selected' : '' }}>User</option> --}}
                        <option value="Retailer" {{ $user->role == 'Retailer' ? 'selected' : '' }}>Retailer</option>
                        <option value="distibuter" {{ $user->role == 'distibuter' ? 'selected' : '' }}>Distributor</option>
                    </select>
                    @error('role')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                @endif
              

                <!-- Submit -->
                <div class="form-group mb-3">
                    <button type="submit" class="btn btn-primary">Update User</button>
                </div>
            </form>
        </div>
    </div>
</div>

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
