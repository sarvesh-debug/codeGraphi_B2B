@extends('admin/include.layout')  

@section('content') 
<div class="container-fluid px-4">
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
        <li class="breadcrumb-item active">User Preview</li>
    </ol>

    <div class="card">
        <div class="card-header bg-success text-white text-center py-3">
            <h4 class="mb-0">User Details</h4>
        </div>
        <div class="card-body">
            <div class="mt-4">
                <h5>Status: 
                    @if ($user->done == 1)
                        <span class="text-success blinking">Verified</span>
                    @else
                        <span class="text-danger blinking">Not Verified</span>
                    @endif
                </h5>
            </div>
            <h5>Name: {{ $user->name }}</h5>
            <h5>Username: {{ $user->username }}</h5>
            <h5>Aadhaar Number: {{ $user->aadhaar }}</h5>
            <h5>PAN: {{ $user->pan }}</h5>
            <h5>City: {{ $user->city }}</h5>
            <h5>State: {{ $user->state }}</h5>
            <h5>Pincode: {{ $user->pincode }}</h5>
            <h5>Outlet Name: {{ $user->outlet_name }}</h5>

            <div class="image-section mt-3">
                @if($user->aadhaar_front)
                    <div>
                        <h3>Aadhaar Front</h3>
                        <img src="{{ asset('storage/' . $user->aadhaar_front) }}" alt="Aadhaar Front" style="max-width: 100%; max-height: 200px;">
                    </div>
                @endif
                
                @if($user->aadhaar_back)
                    <div>
                        <h3>Aadhaar Back</h3>
                        <img src="{{ asset('storage/' . $user->aadhaar_back) }}" alt="Aadhaar Back" style="max-width: 100%; max-height: 200px;">
                    </div>
                @endif
                
                @if($user->pan_card)
                    <div>
                        <h3>Pan Card</h3>
                        <img src="{{ asset('storage/' . $user->pan_card) }}" alt="Pan Card" style="max-width: 100%; max-height: 200px;">
                    </div>
                @endif
            </div>

           

            
          <!-- resources/views/admin/kyc/preview-kyc.blade.php -->

<form action="{{ route('admin.kyc.update', $user->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="status">Status:</label>
        <select name="status" id="status" class="form-control" required>
            <option value="">Select Status</option>
            <option value="ok">Verified</option>
            <option value="not_ok">Not Verified</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Update KYC Status</button>
</form>
        </div>
    </div>
</div>

<style>
    .blinking {
        animation: blink-animation 1s steps(5, start) infinite;
    }

    @keyframes blink-animation {
        to {
            visibility: hidden;
        }
    }
</style>
@endsection
