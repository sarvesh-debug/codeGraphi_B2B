@extends('user.include.layout')
@section('content')

    <style>
        .result-card {
            max-width: 600px;
            margin: auto;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .result-header {
            font-size: 1.5rem;
            font-weight: bold;
            padding: 1rem;
            border-bottom: 1px solid #e0e0e0;
        }
        .result-row {
            display: flex;
            justify-content: space-between;
            padding: 0.75rem 1rem;
            border-bottom: 1px solid #e0e0e0;
        }
        .result-row:last-child {
            border-bottom: none;
        }
        .result-row-title {
            font-weight: bold;
            color: #555;
        }
        .result-footer {
            font-size: 0.9rem;
            color: #888;
            padding: 1rem;
            background-color: #f9f9f9;
            text-align: center;
            border-top: 1px solid #e0e0e0;
        }
        .profile-pic {
            max-width: 80px;
            border-radius: 50%;
        }
    </style>

    <div class="container mt-5">
        <div class="card result-card text-center">
            <div class="result-header bg-primary text-white">
               Validation Result
            </div>
            <div class="card-body">
                @if ($data['status'] === 'Transaction Successful')
                    <h5 class="text-success">{{ $data['status'] }}</h5>

                    <div class="result-row">
                        <div class="result-row-title">Outlet ID</div>
                        <div>{{ $data['data']['outletId'] }}</div>
                    </div>
                    <div class="result-row">
                        <div class="result-row-title">Name</div>
                        <div>{{ $data['data']['name'] }}</div>
                    </div>
                    <div class="result-row">
                        <div class="result-row-title">Date of Birth</div>
                        <div>{{ $data['data']['dateOfBirth'] }}</div>
                    </div>
                    <div class="result-row">
                        <div class="result-row-title">Gender</div>
                        <div>{{ $data['data']['gender'] }}</div>
                    </div>
                    <div class="result-row">
                        <div class="result-row-title">Pincode</div>
                        <div>{{ $data['data']['pincode'] }}</div>
                    </div>
                    <div class="result-row">
                        <div class="result-row-title">State</div>
                        <div>{{ $data['data']['state'] }}</div>
                    </div>
                    <div class="result-row">
                        <div class="result-row-title">District Name</div>
                        <div>{{ $data['data']['districtName'] }}</div>
                    </div>
                    <div class="result-row">
                        <div class="result-row-title">Address</div>
                        <div>{{ $data['data']['address'] }}</div>
                    </div>
                    <div class="result-row">
                        <div class="result-row-title">Profile Picture</div>
                        <div><img src="{{ $data['data']['profilePic'] }}" alt="Profile Picture" class="profile-pic"></div>
                    </div>
                    <div class="result-row">
                        <div class="result-row-title">IPAY UUID</div>
                        <div>{{ $data['ipay_uuid'] }}</div>
                    </div>
                    <div class="result-row">
                        <div class="result-row-title">Order ID</div>
                        <div>{{ $data['orderid'] }}</div>
                    </div>

                @elseif ($data['status'] === 'Invalid OTP Please retry with a valid OTP')
                    <h5 class="text-danger">{{ $data['status'] }}</h5>
                    <p class="mt-4">Please try again with a valid OTP.</p>
                @else
                    <h5 class="text-warning">Unexpected Status</h5>
                    <p>{{ $data['status'] }}</p>
                @endif
            </div>
            <div class="result-footer">
                Thank you for using our service!
            </div>
        </div>
    </div>

    @endsection
