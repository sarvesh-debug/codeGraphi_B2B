@extends('user/include.layout')
@section('content')
@include('user.remitter.navbar')
    <div class="container mt-5">
        <h2>Register Sender</h2>

        {{-- Success Message --}}
        @if (isset($response['status']) && $response['status'] === true)
            <div class="alert alert-success">
                {{ $response['message'] }}
            </div>
        
        {{-- Error Message --}}
        @elseif (isset($error))
            <div class="alert alert-danger">
                {{ $error }}
            </div>
        @else
            <div class="alert alert-warning">
                Registration failed. Please try again.
            </div>
        @endif

    </div>
    @endsection

