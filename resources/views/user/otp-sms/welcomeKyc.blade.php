@extends('user/include.layout')

@section('content')
<style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .welcome-card {
            margin-top: 50px;
            padding: 30px;
            background: #ffffff;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        .logo {
            width: 120px;
            margin-bottom: 20px;
        }
        h1 {
            color: #007bff;
            font-weight: 600;
        }
        p {
            font-size: 1.1rem;
            color: #333;
        }
        .redirect-info {
            color: #28a745;
            font-weight: bold;
        }
        footer {
            margin-top: 20px;
            font-size: 0.9rem;
            color: #666;
            text-align: center;
        }
    </style>

    <div class="container">
        <div class="d-flex justify-content-center">
            <div class="col-md-8 text-center welcome-card">
                <!-- Logo Section -->
                <img src="{{ asset('assets/img/icons/codegraphi-logo.png') }}" style="border-radius: 50%;" alt="CodeGraphi Logo" class="logo">

                <!-- Welcome Content -->
                <h1>Welcome to CodeGraphi!</h1>
                <h2>Full KYC !</h2>
                <p>Dear <b>{{$username}}</b>,</p>
                <p>Your RT number is <span class="redirect-info">{{ $rt_number }}</span>.</p>
                <p>Please wait team is reviewing, after review will show the data</p>
            


            @if (session('role')=='Retailer')
             <!-- Redirect Information -->
                <!-- <div class="" role="status">
                    <span class="">Click For Full Kyc</span>
                    <a href="{{ route('user/kyc-form') }}" class="btn btn-success">Click </a>
                </div> -->
            @endif
                <!-- Redirect Information -->
                <!-- <div class="">
                    <span class="">Click For Full Kyc</span>
                    <a href="{{ route('customer/dashboard') }}" class="btn btn-success">Back </a>
                </div> -->
            </div>
        </div>
        <footer>
            &copy; 2025 CodeGraphi.com All rights reserved.
        </footer>
    </div>

    <!-- Redirect Script -->
   
    @endsection
