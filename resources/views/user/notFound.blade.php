{{-- @extends('user/include.layout')

@section('content')
<div class="container d-flex flex-column justify-content-center align-items-center text-center min-vh-100">
    <img src="https://www.cloudways.com/blog/wp-content/uploads/fix-503-service-unavailable-error-in-wordpress.jpg" alt="Service Unavailable" class="img-fluid" style="max-width: 400px;">
    <h1 class="mt-4 text-danger fw-bold">Service Unavailable</h1>
    <p class="text-muted">We're currently performing some maintenance. Please check back later.</p>
    <a href="{{route('customer/dashboard')}}" class="btn btn-primary mt-3">Go Back to Home</a>
</div>
@endsection --}}


@extends('user/include.layout')

@section('content')
<style>
    body {
        background-color: #ffffff;
    }

    .coming-soon-container {
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center;
        padding: 30px;
    }

    .coming-soon-image {
        max-width: 400px;
        border-radius: 12px;
    }

    .coming-soon-title {
        font-size: 2.5rem;
        font-weight: 700;
        margin-top: 20px;
        color: #333;
    }

    .coming-soon-text {
        font-size: 1.1rem;
        color: #777;
    }

    .back-btn {
        margin-top: 25px;
        background: linear-gradient(90deg, #007cf0, #00dfd8);
        color: #fff;
        font-weight: 600;
        border: none;
        padding: 10px 25px;
        border-radius: 50px;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .back-btn:hover {
        opacity: 0.9;
        text-decoration: none;
        color: #fff;
    }
</style>

<div class="container coming-soon-container">
    <img src="https://img.freepik.com/free-vector/abstract-grunge-style-coming-soon-with-black-splatter_1017-26690.jpg" 
         alt="Coming Soon" 
         class="coming-soon-image">
    <p class="coming-soon-text">We’re working hard to bring this service to you. Please check back later!</p>

    <a href="{{ route('customer/dashboard') }}" class="btn back-btn p-2" style="background: linear-gradient(to right, #0a22aa, #b62512); color: white; border: none;">← Back to Dashboard</a>
</div>
@endsection
