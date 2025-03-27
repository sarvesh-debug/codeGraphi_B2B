@extends('user/include.layout')

@section('content')

<div class="controller mt-3">
    <div class="container">
        <!-- Navigation Tabs -->
         <!-- Navigation Bar -->
         <nav class="navbar navbar-expand-lg navbar-light bg-light p-2">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('/user/wallet/index')}}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('wallet.History')}}">History</a>
                    </li>
                </ul>
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
                            <!-- Mobile Number -->
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

        <!-- Second Card with Table -->
        <div class="col-md-8 col-12">
            <div class="card shadow">
                <div class="card-header">
                    <h3 class="card-heading mb-0">Transaction History</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="fw-bold">
                            <tr>
                                <th>ID3</th>
                                <th>Sender ID</th>
                                <th>Receiver ID</th>
                                <th>Amount</th>
                                <th>Opening Balance</th>
                                <th>Closing Balance</th>
                                <th>Remark</th>
                                <th>Transfer ID</th>
                                <th>Date Time</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>2024-03-04</td>
                                    <td>$100</td>
                                    <td class="text-success">Completed</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>2024-03-03</td>
                                    <td>$50</td>
                                    <td class="text-danger">Failed</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>2024-03-02</td>
                                    <td>$200</td>
                                    <td class="text-warning">Pending</td>
                                </tr>
                                <!-- More rows dynamically -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
