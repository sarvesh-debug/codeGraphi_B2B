@extends('user/include.layout')

@section('content')

<div class="container py-4">
  
    <div class="row justify-content-center mt-3">
        @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

        <!-- Remitter Profile Section -->
        <div class="col-md-6 mt-3">
            <div class="card shadow-lg border-0">
                <div class="card-header py-3" style="background: linear-gradient(to right, #0a22aa, #b62512); color: white; border: none;">
                    <h4 class="card-heading mb-0"><i class="fas fa-user-circle me-2"></i>Remitter Profile</h4>
                </div>
                <div class="card-body p-4">
                    <form action="{{route('remProfilePost')}}" method="POST">
                        @csrf
                       <div class="form-group mb-3">
                          <input type="text" class="form-control" id="mobile" name="mobileNumber"
       placeholder="Enter mobile number" required maxlength="10"
       pattern="[6-9]\d{9}"
       title="Enter valid 10-digit Indian mobile number starting with 6-9"
       oninput="this.value = this.value.replace(/\D/g, '').slice(0, 10)" />

                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-success py-2 px-4" style="background: linear-gradient(to right, #0a22aa, #b62512); color: white; border: none;">
                                <i class="me-2"></i>Submit
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        <!-- Latest Transactions Section -->
       
@endsection
