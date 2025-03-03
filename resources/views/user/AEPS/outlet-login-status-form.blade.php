@extends('user/include.layout')
@section('content')

<div class="controller mt-3 mx-3">
    <div class="row">
        @include('user.AEPS.navbar')
        <div class="col-12 col-md-8 col-lg-6 mx-auto">
            
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h1 class="h5 m-0">Check Outlet Login Status</h1>
                </div>
                <div class="card-body">
                    <form action="{{ url('/outlet-login-status') }}" method="POST">
                        @csrf
                        <p class="mb-4">Click the button below to check the outlet login status.</p>
                        <button type="submit" class="btn btn-primary">Check Status</button>
                    </form>
                </div>
                <div class="card-footer">
                    <a href="{{ route('outlet-login/aeps.form') }}" class="btn btn-info">LogIn</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
