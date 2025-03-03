@extends('user.include.layout')

@section('content')

<div class="controller mt-3 mx-5">
    <div class="row">
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
                            <a class="nav-link active" aria-current="page" href="#">Topup History</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Bank Details</a>
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
    {{-- <marquee width="100%" direction="left" class="h5">
        Welcome To <span class="text-success1">Graphi</span><span class="text-info1">Graphi</span> Solutions 🙂
    </marquee> --}}

    <!-- Form Section -->
    <div class="row change">
        <div class="col-lg-6 mx-auto">
            <div class="card shadow">
                <div class="card-header bg-success text-white text-center py-3">
                    <h4 class="mb-0"><span class="text-success1">Payment</span> <span class="text-info1">Getway</span></h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('process.payment') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <!-- Amount -->
                        <div class="mb-3">
                            <label for="amountInput" class="form-label">Amount</label>
                            <input type="text" class="form-control" id="amountInput" name="txnAmount" placeholder="Enter Amount To Pay" required />
                        </div>

                        <!-- Name -->
                        <div class="mb-3">
                            <label for="nameInput" class="form-label">Name</label>
                            <input type="text" class="form-control" id="nameInput" name="customerName" placeholder="Enter Customer Name" required />
                        </div>

                        <!-- Mobile -->
                        <div class="mb-3">
                            <label for="mobileInput" class="form-label">Mobile</label>
                            <input type="text" class="form-control" id="mobileInput" name="customerMobile" placeholder="Enter Customer Mobile" maxlength="10" required />
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="emailInput" class="form-label">Email</label>
                            <input type="email" class="form-control" id="emailInput" name="customerEmail" placeholder="Enter Customer Email" required />
                        </div>

                        <!-- Submit Button -->
                        <div class="d-flex justify-content-end">
                            <input type="submit" name="payment" value="Payment" class="btn btn-success">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
