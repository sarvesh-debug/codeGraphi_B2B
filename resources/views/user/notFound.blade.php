@extends('user/include.layout')

@section('content')
<div class="container d-flex flex-column justify-content-center align-items-center text-center min-vh-100">
    <img src="https://www.cloudways.com/blog/wp-content/uploads/fix-503-service-unavailable-error-in-wordpress.jpg" alt="Service Unavailable" class="img-fluid" style="max-width: 400px;">
    <h1 class="mt-4 text-danger fw-bold">Service Unavailable</h1>
    <p class="text-muted">We're currently performing some maintenance. Please check back later.</p>
    <a href="{{route('customer/dashboard')}}" class="btn btn-primary mt-3">Go Back to Home</a>
</div>
@endsection
