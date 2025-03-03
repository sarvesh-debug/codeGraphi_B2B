@extends('user.include.layout') 
@section('content')
<style>
       .container {
            max-width: 600px;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }
        h2 {
            font-size: 1.8rem;
            color: #343a40;
            text-align: center;
            margin-bottom: 20px;
        }
        .alert {
            font-size: 1.1rem;
            text-align: center;
        }
        .list-group-item {
            font-size: 0.95rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .list-group-item strong {
            color: #495057;
        }
        .profile-pic {
            display: flex;
            justify-content: center;
            margin-top: 10px;
        }
        .profile-pic img {
            border-radius: 50%;
            border: 2px solid #17a2b8;
        }
</style>
<div class="container mt-5">
    <h2><i class="fas fa-shield-alt text-primary"></i> OTP Validation Result</h2>

    <div class="alert alert-{{ $status == 'success' ? 'success' : 'danger' }}">
        <strong><i class="fas fa-info-circle"></i> Status:</strong> {{ $message }}
    </div>

    @if($status == 'success')
        <h4 class="text-center text-secondary"><i class="fas fa-user-circle"></i> User Details</h4>
        <ul class="list-group list-group-flush mt-3">
            <li class="list-group-item"><strong>Outlet ID:</strong> <span>{{ $data['data']['outletId'] ?? 'N/A' }}</span></li>
            <li class="list-group-item"><strong>Name:</strong> <span>{{ $data['data']['name'] ?? 'N/A' }}</span></li>
            <li class="list-group-item"><strong>Date of Birth:</strong> <span>{{ $data['data']['dateOfBirth'] ?? 'N/A' }}</span></li>
            <li class="list-group-item"><strong>Gender:</strong> <span>{{ $data['data']['gender'] ?? 'N/A' }}</span></li>
            <li class="list-group-item"><strong>Pincode:</strong> <span>{{ $data['data']['pincode'] ?? 'N/A' }}</span></li>
            <li class="list-group-item"><strong>State:</strong> <span>{{ $data['data']['state'] ?? 'N/A' }}</span></li>
            <li class="list-group-item"><strong>District Name:</strong> <span>{{ $data['data']['districtName'] ?? 'N/A' }}</span></li>
            <li class="list-group-item"><strong>Address:</strong> <span>{{ $data['data']['address'] ?? 'N/A' }}</span></li>
            @if(isset($data['data']['profilePic']))
                <li class="list-group-item text-center profile-pic">
                    <strong>Profile Picture:</strong><br>
                    <img src="data:image/jpeg;base64,{{ $data['data']['profilePic'] }}" alt="Profile Pic" width="100">
                </li>
            @endif
        </ul>
    @else
        <p class="text-center text-danger mt-3"><i class="fas fa-exclamation-triangle"></i> Error in OTP validation. Please try again.</p>
    @endif
</div>
@endsection
