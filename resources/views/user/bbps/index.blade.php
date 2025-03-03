@extends('user/include.layout')
@section('content')

<div class="controller mt-3 mx-5">
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
                        <a class="nav-link" href="#">Transaction History</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/user">Exit</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="row">
        <!-- Welcome Marquee -->
        <br>
        <marquee width="100%" direction="left" class="h5 bg-light py-2 rounded">
            Welcome To <span class="text-success1">Code</span><span class="text-info1">Graphi</span> Solutions 🙂
        </marquee>

        <!-- Content Section -->
        <div id="kt_app_content" class="app-content flex-column-fluid mt-5">
            <div class="row gy-5 gx-xl-10">
                
                {{-- <!-- B2B Card -->
                <div class="col-sm-6 col-xl-3 mb-xl-10">
                    <div class="card shadow h-lg-100">
                        <div class="card-body d-flex justify-content-between align-items-center flex-column text-center">
                            <div class="m-0">
                                <img src="https://codegraphi.in/wp-content/uploads/2024/09/codegraphi-logo.png" alt="B2B Icon" class="img-fluid" style="width: 80px;">
                            </div>
                            <div class="d-flex flex-column my-4">
                                <span class="fw-semibold fs-2x text-gray-800 lh-1 ls-n2">B2B</span>
                            </div>
                            <span class="badge badge-light-success fs-base">
                                <button class="btn btn-outline-success" disabled>View More</button>
                            </span>
                        </div>
                    </div>
                </div> --}}

                <!-- Broadband Postpaid Card -->
                <div class="col-sm-6 col-xl-3 mb-xl-10">
                    <div class="card shadow h-lg-100">
                        <div class="card-body d-flex justify-content-between align-items-center flex-column text-center">
                            <div class="m-0">
                                <img src="https://images.weserv.nl/?url=http://Files.mobilepefintech.com/router.png" alt="Broadband Postpaid" class="img-fluid" style="width: 80px;">
                            </div>
                            <div class="d-flex flex-column my-4">
                                <span class="fw-semibold fs-2x text-gray-800 lh-1 ls-n2">Broadband Postpaid</span>
                            </div>
                            <span class="badge badge-light-success fs-base">
                                <button class="btn btn-outline-success" disabled>View More</button>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Cable TV Card -->
                <div class="col-sm-6 col-xl-3 mb-xl-10">
                    <div class="card shadow h-lg-100">
                        <div class="card-body d-flex justify-content-between align-items-center flex-column text-center">
                            <div class="m-0">
                                <img src="https://images.weserv.nl/?url=http://Files.mobilepefintech.com/tv.png" alt="Cable TV" class="img-fluid" style="width: 80px;">
                            </div>
                            <div class="d-flex flex-column my-4">
                                <span class="fw-semibold fs-2x text-gray-800 lh-1 ls-n2">Cable TV</span>
                            </div>
                            <span class="badge badge-light-success fs-base">
                                <button class="btn btn-outline-success" disabled>View More</button>
                            </span>
                        </div>
                    </div>
                </div>

    <!-- Clubs and Associations Card -->
    <div class="col-sm-6 col-xl-3 mb-xl-10">
        <div class="card shadow h-lg-100">
            <div class="card-body d-flex justify-content-between align-items-center flex-column text-center">
                <div class="m-0">
                    <img src="https://images.weserv.nl/?url=http://Files.mobilepefintech.com/club.png" alt="Clubs and Associations" class="img-fluid" style="width: 80px;">
                </div>
                <div class="d-flex flex-column my-4">
                    <span class="fw-semibold fs-2x text-gray-800 lh-1 ls-n2">Clubs and Associations</span>
                </div>
                <span class="badge badge-light-success fs-base">
                    <button class="btn btn-outline-success" disabled>View More</button>
                </span>
            </div>
        </div>
    </div>

    <!-- Credit Card Card -->
    <div class="col-sm-6 col-xl-3 mb-xl-10">
        <div class="card shadow h-lg-100">
            <div class="card-body d-flex justify-content-between align-items-center flex-column text-center">
                <div class="m-0">
                    <img src="https://images.weserv.nl/?url=http://Files.mobilepefintech.com/creditcard.png" alt="Credit Card" class="img-fluid" style="width: 80px;">
                </div>
                <div class="d-flex flex-column my-4">
                    <span class="fw-semibold fs-2x text-gray-800 lh-1 ls-n2">Credit Card</span>
                </div>
                <span class="badge badge-light-success fs-base">
                    <button class="btn btn-outline-success" disabled>View More</button>
                </span>
            </div>
        </div>
    </div>

    <!-- DTH Card -->
    <div class="col-sm-6 col-xl-3 mb-xl-10">
        <div class="card shadow h-lg-100">
            <div class="card-body d-flex justify-content-between align-items-center flex-column text-center">
                <div class="m-0">
                    <img src="https://images.weserv.nl/?url=http://Files.mobilepefintech.com/dth.png" alt="DTH" class="img-fluid" style="width: 80px;">
                </div>
                <div class="d-flex flex-column my-4">
                    <span class="fw-semibold fs-2x text-gray-800 lh-1 ls-n2">DTH</span>
                </div>
                <span class="badge badge-light-success fs-base">
                    <button class="btn btn-outline-success" disabled>View More</button>
                </span>
            </div>
        </div>
    </div>

    <!-- Education Fees Card -->
    <div class="col-sm-6 col-xl-3 mb-xl-10">
        <div class="card shadow h-lg-100">
            <div class="card-body d-flex justify-content-between align-items-center flex-column text-center">
                <div class="m-0">
                    <img src="https://images.weserv.nl/?url=http://Files.mobilepefintech.com/education.png" alt="Education Fees" class="img-fluid" style="width: 80px;">
                </div>
                <div class="d-flex flex-column my-4">
                    <span class="fw-semibold fs-2x text-gray-800 lh-1 ls-n2">Education Fees</span>
                </div>
                <span class="badge badge-light-success fs-base">
                    <button class="btn btn-outline-success" disabled>View More</button>
                </span>
            </div>
        </div>
    </div>

    <!-- Electricity Card -->
    <div class="col-sm-6 col-xl-3 mb-xl-10">
        <div class="card shadow h-lg-100">
            <div class="card-body d-flex justify-content-between align-items-center flex-column text-center">
                <div class="m-0">
                    <img src="https://images.weserv.nl/?url=http://Files.mobilepefintech.com/bulb.png" alt="Electricity" class="img-fluid" style="width: 80px;">
                </div>
                <div class="d-flex flex-column my-4">
                    <span class="fw-semibold fs-2x text-gray-800 lh-1 ls-n2">Electricity</span>
                </div>
                <span class="badge badge-light-success fs-base">
                    <button class="btn btn-outline-success" disabled>View More</button>
                </span>
            </div>
        </div>
    </div>

    <!-- FASTag Card -->
    <div class="col-sm-6 col-xl-3 mb-xl-10">
        <div class="card shadow h-lg-100">
            <div class="card-body d-flex justify-content-between align-items-center flex-column text-center">
                <div class="m-0">
                    <img src="https://images.weserv.nl/?url=http://Files.mobilepefintech.com/fastTag.png" alt="FASTag" class="img-fluid" style="width: 80px;">
                </div>
                <div class="d-flex flex-column my-4">
                    <span class="fw-semibold fs-2x text-gray-800 lh-1 ls-n2">FASTag</span>
                </div>
                <span class="badge badge-light-success fs-base">
                    <button class="btn btn-outline-success" disabled>View More</button>
                </span>
            </div>
        </div>
    </div>

    <!-- Gas Card -->
    <div class="col-sm-6 col-xl-3 mb-xl-10">
        <div class="card shadow h-lg-100">
            <div class="card-body d-flex justify-content-between align-items-center flex-column text-center">
                <div class="m-0">
                    <img src="https://images.weserv.nl/?url=http://Files.mobilepefintech.com/gas.png" alt="Gas" class="img-fluid" style="width: 80px;">
                </div>
                <div class="d-flex flex-column my-4">
                    <span class="fw-semibold fs-2x text-gray-800 lh-1 ls-n2">Gas</span>
                </div>
                <span class="badge badge-light-success fs-base">
                    <button class="btn btn-outline-success" disabled>View More</button>
                </span>
            </div>
        </div>
    </div>

    <!-- General Insurance Card -->
    <div class="col-sm-6 col-xl-3 mb-xl-10">
        <div class="card shadow h-lg-100">
            <div class="card-body d-flex justify-content-between align-items-center flex-column text-center">
                <div class="m-0">
                    <img src="https://images.weserv.nl/?url=http://Files.mobilepefintech.com/generalins.png" alt="General Insurance" class="img-fluid" style="width: 80px;">
                </div>
                <div class="d-flex flex-column my-4">
                    <span class="fw-semibold fs-2x text-gray-800 lh-1 ls-n2">General Insurance</span>
                </div>
                <span class="badge badge-light-success fs-base">
                    <button class="btn btn-outline-success" disabled>View More</button>
                </span>
            </div>
        </div>
    </div>

            </div>
        </div>
    </div>
</div>

@endsection
