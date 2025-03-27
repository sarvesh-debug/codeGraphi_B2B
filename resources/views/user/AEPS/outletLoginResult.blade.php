@extends('user/include.layout')

@section('content')
@include('user.AEPS.navbar')
    <!-- Auto-Redirect Meta Tag -->
    <div class="container">
        <h2>Outlet Login Result</h2>
        
        @if ($type === 'error')
            <div class="alert alert-danger">
                <strong>Error:</strong> {{ $message }} <p> <b> Please Connect Your Admin </b></p>
            </div>
        @elseif ($type === 'success')
            <div class="alert alert-success">
                <strong>Success:</strong> {{ $message }}
            </div>
        @else
            <div class="alert alert-warning">
                <strong>Notice:</strong> {{ $message }}
            </div>
        @endif
    
    </div>
@endsection
