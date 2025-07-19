@extends('user/include.layout')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 50vh; padding-top: 20px;">
    <div class="col-11 col-md-6">
        <div class="card shadow-lg border-0 rounded-lg">
            <div class="card-header">
                <h3 class="card-heading mb-0"> New Member</h3>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                
                <form action="{{ route('user.reg') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-1">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" required>
                        @error('name')<small class="text-danger">{{ $message }}</small>@enderror
                    </div>
                    
                    <div class="mb-1">
                        <label for="owner" class="form-label">Shop Name</label>
                        <input type="text" class="form-control" id="owner" name="owner" placeholder="Enter Shop Name" required>
                        @error('owner')<small class="text-danger">{{ $message }}</small>@enderror
                    </div>
                    
                    <div class="mb-1">
                        <label for="phone" class="form-label">Mobile No (as per Aadhar Link)</label>
                        <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter Mobile Number" maxlength="10" required>
                        @error('phone')<small class="text-danger">{{ $message }}</small>@enderror
                    </div>
                    
                    <div class="mb-1">
                        <label for="email" class="form-label">Email Id</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" required>
                        @error('email')<small class="text-danger">{{ $message }}</small>@enderror
                    </div>
                    
                    <div class="mb-1">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" required>
                        @error('password')<small class="text-danger">{{ $message }}</small>@enderror
                    </div>
                    
                    <div class="mb-1">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" required>
                        @error('password_confirmation')<small class="text-danger">{{ $message }}</small>@enderror
                    </div>
                    
                   <!--<p>{{session('role')}}-->
                   <!--        </p>-->
                    <input type="text" hidden name="dis_no" value="{{session('mobile')}}">
                    <input type="text" hidden name="dis_name" value="{{session('user_name')}}">
                    <div class="mb-2">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-control" id="role" name="role" required>
                           
                            <option value="Retailer">Retailer</option>
                           @if (session('role')=='rm')
                            <option value="sd">Super Distributor</option>
                           <option value="distibuter">Distributor</option>
                           @endif
                            @if (session('role')=='sd')
                           
                           <option value="distibuter">Distributor</option>
                           @endif
                        </select>
                        @error('role')<small class="text-danger">{{ $message }}</small>@enderror
                    </div>
                    
                    <div class="btn-container">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
