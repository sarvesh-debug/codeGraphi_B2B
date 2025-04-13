@extends('user/include.layout')
@section('content')
@include('user.cgpayout.navbar')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow rounded">
                <div class="card-header bg-primary text-white text-center">
                    <h4>Payout Login</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('usercg.verify') }}" method="POST">
                        @csrf

                        
                            <input 
                                type="hidden" 
                                class="form-control" 
                                id="email" 
                                name="Business_Email" 
                                value="{{ env('Business_Email') }}" 
                                readonly
                            >
                            <input 
                            type="hidden" 
                            class="form-control" 
                            id="email" 
                            name="Business_Id" 
                            value="{{ env('Business_Id') }}" 
                            readonly
                        >
                    
                        <div class="form-group mb-3">
                            <label for="phone">Phone</label>
                            <input 
                                type="text" 
                                class="form-control" 
                                id="phone" 
                                name="phone" 
                                value="{{ session('mobile') }}" 
                                readonly
                            >
                        </div>
                        <div class="form-group mb-3">
                            <label for="phone">RT ID</label>
                            <input 
                                type="text" 
                                class="form-control" 
                                id="username" 
                                name="username" 
                                value="{{ session('username') }}" 
                                readonly
                            >
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-success w-100">Proceed to Payout</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
