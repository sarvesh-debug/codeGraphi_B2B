@extends('user/include.layout')

@section('content')

<div class="controller mt-3 mx-3">
    <div class="row">
        <!-- Navigation Tabs -->
         <!-- Navigation Bar -->
    <nav class="bg-white navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Home</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                   
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('wallet.History')}}">History</a>
                    </li>
                
                </ul>
            </div>
        </div>
    </nav>
        </div>
   <!-- Check if there are any errors -->
   @if($errors->any())
   <div class="alert alert-danger">
       <ul>
           @foreach ($errors->all() as $error)
               <li>{{ $error }}</li>
           @endforeach
       </ul>
   </div>
@endif

  
        <!-- Form Section -->
        <div class="row change">
            <div class="col-11  col-lg-6 mx-auto">
                <div class="card shadow">
                    <div class="card-header bg-success text-white text-center py-4 px-5">
                        <h4 class="mb-0"><span class="text-success1">Wallet To Wallet</span> <span class="text-info1">Transfer</span></h4>
                    </div>
                    <h4 class="mb-0 p-2"><span class="text-success">Search User    </h4>
                    <div class="card-body">
                        <form action="{{route('wallet.transfer')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                             <!-- mobile Nmber -->
                             <div class="mb-3">
                                <label for="mobileNumber" class="form-label">Mobile Number</label>
                                <input type="number" class="form-control" id="mobileNumber" name="mobileNumber" 
                                    placeholder="Enter Mobile No.." maxlength="10" required
                                    inputmode="numeric" pattern="[0-9]{10}" 
                                    oninput="this.value = this.value.replace(/\D/g, '')" />
                                <small class="form-text text-muted">Enter a valid 10-digit mobile number.</small>
                            </div>
                            
                            <!-- Submit Button -->
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-success">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
