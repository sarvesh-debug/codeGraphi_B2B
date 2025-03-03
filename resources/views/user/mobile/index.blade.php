@extends('user/include.layout')

@section('content')

<div class="controller mt-3 mx-5">
    <div class="row">
        <!-- Navigation Tabs -->
         <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="/user">Home</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Refund</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Pandding Status</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">History</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/user">Exit</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
        </div>

        <!-- Welcome Marquee -->
        <marquee width="100%" direction="left" class="h5">
            Welcome To <span class="text-success1">Graphi</span><span class="text-info1">Graphi</span> Solutions 🙂
        </marquee>

        <!-- Form Section -->
        <div class="row change">
            <div class="col-lg-6 mx-auto">
                <div class="card shadow">
                    <div class="card-header bg-success text-white text-center py-3">
                        <h4 class="mb-0"><span class="text-success1">Mobile</span> <span class="text-info1">Recharge</span></h4>
                    </div>

                    <div class="card-body">
                        <form action="" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                             <!-- mobile Nmber -->
                             <div class="mb-3">
                                <label for="remarkInput" class="form-label">Mobile Number</label>
                                <input type="text" class="form-control" id="MibileNumber" name="mobileNumber" placeholder="9876543210" />
                            </div>

                            <!-- Mode of Transaction -->
                            <div class="mb-3">
                                <label for="modeSelect" class="form-label">Select Operator</label>
                                <select class="form-select" id="modeSelect" name="mode" required>
                                    <option value="" selected disabled>Select Operator</option>
                                    <option value="Jio">Jio</option>
                                    <option value="BSNL">BSNL</option>
                                    <option value="VI">VI</option>
                                    <option value="AIRTEL">AIRTEL</option>
                                
                                </select>
                            </div>
                            <!-- Amount -->
                            <div class="mb-3">
                                <label for="amountInput" class="form-label">Amount</label>
                                <input type="number" class="form-control" id="amountInput" name="amount" placeholder="Enter the amount" required />
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
