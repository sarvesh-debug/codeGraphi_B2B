@extends('user/include.layout')

@section('custom-css')
<style>
    .service-icon
    {
        width: 100%;
    }
    .service-text
    {
        text-align: center;
        font-size: 15px
    }
    .card-img {
        display: flex;
        justify-content: center;  /* Center horizontally */
        align-items: center;      /* Center vertically */
    }

    /* Responsive behavior on mobile screens */
    @media (max-width: 600px) {
        .service-icon {
            width: 50%;
        }
    }
</style>
@php
$customer = session('customer');
$role=session('role');
//$latest_new=selsect (latest_news) from  contacts where id =1;
@endphp
@php
    $customer = session('customer');
    $role = session('role');
    $latest_new = \App\Models\Contact::where('id', 1)->value('latest_news');
    $emr = \App\Models\Contact::where('id', 1)->value('emergency_update');
@endphp

@php
// Fetch only active services inside Blade
$services = \App\Models\OtherService::where('status', 1)->get();
@endphp
@endsection
@section('content')


<div class="container-xxl flex-grow-1 container-p-y justify-content-center align-items-center">
    <div class="row">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
            <marquee class="text-dark">
                {{ $emr}}
            </marquee>
            <div class="d-flex align-items-end row">
                <div class="col-sm-7">
                <div class="card-body">
                    
                    @if($role==="distibuter")
                                
                                <h5 class="card-title text-primary"><b>Welcome Distributor</b></h5>

                            @endif
                    <?php
                    // Set the time zone to India
                    date_default_timezone_set('Asia/Kolkata');
                
                    // Get the current hour in 24-hour format
                    $currentHour = date('H');
                
                    // Initialize the greeting variable
                    $greeting = '';
                
                    // Determine the greeting based on the current hour
                    if ($currentHour < 12) {
                        $greeting = 'Good Morning';
                    } elseif ($currentHour < 17) {
                        $greeting = 'Good Afternoon';
                    } else {
                        $greeting = 'Good Evening';
                    }
                
                    // Display the greeting
                    //  echo $greeting;
                ?>
                
                    <h5 class="card-title text-primary">{{ $greeting }} ! {{$customer->name }}!  🎉</h5>
                    <p class="mb-4">
                    Wallet <span class="fw-bold"> ₹{{session('balance') }}</span> 
                    </p>
                    {{-- <span class="me-3 mb-2 mb-md-0"><b>RT Code:</b> {{$customer->username}}</span> --}}
                    <span class="align-middle me-3 mb-2 mb-md-0"><b>HelpLine No:</b>+91-9522327969</span>
                    <span class="align-middle me-3 mb-2 mb-md-0"><b>e-Mail:</b>info@zpaypvtltd.com</span>

                </div>
                </div>
                <div class="col-sm-5 text-center text-sm-left">
                <div class="card-body pb-0 px-0 px-md-4">
                    <img
                    src="../assets/img/illustrations/man-with-laptop.gif"
                    height="140"
                    alt="View Badge User"
                    data-app-dark-img="illustrations/man-with-laptop-dark.png"
                    data-app-light-img="illustrations/man-with-laptop-light.png"
                    />
                </div>
                </div>
            </div>
            
            </div>
            <div class="card mt-2">
            <p class="h3 m-1 text-center"><span class="text-success1">Latest</span> <span class="text-info1">News</span></p>
            <marquee class="text-dark h5" style="color:black">
                {{$latest_new}}
            </marquee>
            
        </div>
        </div>
    </div>
    <div class="container">
      <div class="row">
          <p class="h2 text-success1">Services</p>
          <p class="h5 text-info1">Look A glance towards services</p>
     {{-- card start --}}

          {{-- First Card --}}
          <div class="col-lg-2 col-md-3 col-6 b-4">
            <div class="card">
                <div class="card-body">
                    @if ($customer->aeps == 1 && $customer->status ==="active" && $customer->pin >0)
                        <a href="{{ route('cash.withdrawal.form') }}">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="card-img">
                                    <img src="{{ asset('assets/img/icons/AEPS.png') }}" class="service-icon" />
                                </div>
                            </div>
                            <h3 class="card-title mb-2 service-text">AEPS</h3>
                        </a>
                    @else
                        <a href="javascript:void(0);" onclick="showAlert('{{ $customer->name }}',{{$customer->pin}},{{$customer->status}});">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="card-img">
                                    <img src="{{ asset('assets/img/icons/AEPS.png') }}" class="service-icon" />
                                </div>
                            </div>
                            <h3 class="card-title mb-2 service-text">AEPS</h3>
                        </a>
                    @endif
                </div>
            </div>
        </div>
         {{-- First Card --}}
         <div class="col-lg-2 col-md-3 col-6 b-4">
            <div class="card">
                <div class="card-body">
                    @if ($customer->aeps == 1 && $customer->status ==="active" && $customer->pin >0)
                        <a href="{{ route('getISP') }}">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="card-img">
                                    <img src="{{ asset('assets/img/icons/mobile_recharge.png') }}" class="service-icon" />
                                </div>
                            </div>
                            <h3 class="card-title mb-2 service-text">Mobile Recharge</h3>
                        </a>
                    @else
                        <a href="javascript:void(0);" onclick="showAlert('{{ $customer->name }}',{{$customer->pin}},{{$customer->status}});">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="card-img">
                                    <img src="{{ asset('assets/img/icons/mobile_recharge.png') }}" class="service-icon" />
                                </div>
                            </div>
                            <h3 class="card-title mb-2 service-text">Mobile Recharge</h3>
                        </a>
                    @endif
                </div>
            </div>
        </div>
        {{-- Second Card --}}
        <div class="col-lg-2 col-md-3 col-6 mb-4">
            <div class="card">
                <div class="card-body">
                    @if ($customer->dmt == 1 && $customer->balance >0 && $customer->status ==="active" && $customer->pin >0)
                        <a href="{{route('dmt.remitter-profile')}}">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="card-img">
                                    <img src="{{asset('assets/img/icons/money_transfer.png')}}" class="service-icon" />
                                </div>
                            </div>
                            <h3 class="card-title mb-2 service-text">D M T </h3>
                        </a>
                    @else
                        <a href="javascript:void(0);" onclick="showAlert('{{ $customer->name }}',{{ $customer->balance }},{{$customer->pin}});">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="card-img">
                                    <img src="{{asset('assets/img/icons/money_transfer.png')}}" class="service-icon" />
                                </div>
                            </div>
                            <h3 class="card-title mb-2 service-text">D M T </h3>
                        </a>
                    @endif
                </div>
            </div>
        </div>

           <div class="col-lg-2 col-md-3 col-6 mb-4">
            <div class="card">

                <div class="card-body">
                    @if ($customer->payout == 1 && $customer->balance >0 && $customer->status ==="active" && $customer->pin >0)
                        <!-- If AEPS is active, open the cash withdrawal form -->
                        <a href="">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="">
                                    <img src="{{asset('assets/img/icons/pay_out.png')}}" class="service-icon" />
                                </div>
                            </div>
                            <h3 class="card-title mb-2 service-text">PayOut</h3>
                        </a>
                    @else
                        <!-- If AEPS is inactive, show an alert -->
                        <a href="javascript:void(0);" onclick="showAlert('{{ $customer->name }}',{{ $customer->balance }},{{$customer->pin}});">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="">
                                    <img src="{{asset('assets/img/icons/pay_out.png')}}" class="service-icon" />
                                </div>
                            </div>
                            <h3 class="card-title mb-2 service-text">PayOut</h3>
                        </a>
                    @endif
                </div>
            </div>
        </div>
         <!-- card-->
         <div class="col-lg-2 col-md-3 col-6 mb-4">
            <div class="card">
                <div class="card-body">
                    @if ($customer->cc_bill_payment == 1 && $customer->balance >0 && $customer->status ==="active" && $customer->pin >0)
                        <!-- If AEPS is active, open the cash withdrawal form -->
                        <a href="{{route('getcategory')}}">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="card-img">
                                    <img src="{{asset('assets/img/icons/bill_payment.png')}}" class="service-icon" />
                                </div>
                            </div>
                            <h3 class="card-title mb-2 service-text">Bill Payment</h3>
                        </a>
                    @else
                        <!-- If AEPS is inactive, show an alert -->
                        <a href="javascript:void(0);" onclick="showAlert('{{ $customer->name }}',{{ $customer->balance }},{{$customer->pin}});">
                            <div class="card-title d-flex align-items-start justify-content-between">
                                <div class="card-img">
                                    <img src="{{asset('assets/img/icons/bill_payment.png')}}" class="service-icon" />
                                </div>
                            </div>
                            <h3 class="card-title mb-2 service-text">Bill Payment</h3>
                        </a>
                    @endif
                </div>
            </div>
        </div>

        
            @foreach($services as $service)
            <div class="col-lg-2 col-md-3 col-6 b-4">
                    <div class="card">
                        <div class="card-body">
                                <a href="{{ $service->service_link }}" target="_blank">
                                    <div class="card-title d-flex align-items-start justify-content-between">
                                        <div class="card-img">
                                            <img src="{{ $service->logo_name }}" class="service-icon" />
                                        </div>
                                    </div>
                                    <h3 class="card-title mb-2 service-text">{{ $service->service }}</h3>
                                </a>
                        
                        </div>
                    </div>
                </div>
            @endforeach
       
        <script>
            function showAlert(name, balance, status, pin) {
                if (balance <= 0) {
                    alert('Insufficient Wallet Balance');
                } 
                else if (pin == 0) {
                    alert(`Dear ${name}, please complete your Full-KYC.`);
                } else if (status === "deactive") {
                    alert(`Dear ${name}, your account is deactivated. Please contact the distributor.`);
                } else {
                    alert(`Dear ${name}, your services are deactivated. Please contact the distributor.`);
                }
            }
        </script> 
        <div class="col-lg-12 col-md-12 order-1 my-4"> 
            <div class="card">
                <div class="card-body text-center">
                    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                        </div>
                        <div class="carousel-inner custom-carousel-height">
                            <div class="carousel-item active">
                                <img src="{{asset('assets/img/backgrounds/banner3.png')}}" class="d-block w-100" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="{{asset('assets/img/backgrounds/banner3.png')}}" class="d-block w-100" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src="{{asset('assets/img/backgrounds/banner3.png')}}" class="d-block w-100" alt="...">
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>     
<!-- KYC Modal -->
<div class="modal fade" id="kycModal" tabindex="-1" aria-labelledby="kycModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="kycModalLabel">KYC Required</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Please complete your KYC to continue using our services.</p>
                 <!-- Address (As per Aadhar) -->
                 <form action="{{route('admin.client.storekyc')}}" method="post" enctype="multipart/form-data">
                    @csrf
            <div class="mb-3">
                <label for="address" class="form-label">Address (As per Aadhar)</label>
                <input type="text" class="form-control" id="address" name="address" placeholder="Full Address" required>
                <div class="row mt-2">
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="city" placeholder="City" required>
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="state" placeholder="State" required>
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="pincode" placeholder="PIN Code" required>
                    </div>
                </div>
            </div>
            

            <!-- Aadhar Number & Upload -->
            <div class="mb-3">
                <label for="aadhar" class="form-label">Aadhar No</label>
                <input type="text" class="form-control" id="aadhar" name="aadhar" placeholder="Enter Aadhar No" maxlength="12" required>
                <label class="form-label mt-2">Upload Aadhar Front & Back</label>
                <input type="file" class="form-control mb-2" name="aadhar_front" accept="image/*" required>
                <input type="file" class="form-control" name="aadhar_back" accept="image/*" required>
            </div>

            <!-- PAN Number & Upload -->
            <div class="mb-3">
                <label for="pan" class="form-label">PAN No</label>
                <input type="text" class="form-control" id="pan" name="pan" placeholder="Enter PAN No" maxlength="10" required>
                <label class="form-label mt-2">Upload PAN Image</label>
                <input type="file" class="form-control" name="pan_image" accept="image/*" required>
            </div>

            <!-- Bank Details -->
            <div class="mb-3">
                <label for="account_no" class="form-label">Bank Account Details</label>
                <input type="text" class="form-control mb-2" name="account_no" placeholder="Account Number" required>
                <input type="text" class="form-control mb-2" name="ifsc" placeholder="IFSC Code" required>
                <input type="text" class="form-control mb-2" name="bank_name" placeholder="Bank Name" required>
                <label class="form-label mt-2">Upload Passbook / Cheque / Bank Statement</label>
                <input type="file" class="form-control" name="bank_image" accept="image/*" required>
            </div>
            <button class="btn btn-success">Submit Kyc Data</button>
        </form>
            </div>
        </div>
    </div>
</div>

         <style>

.custom-carousel-height {
    height: 200px;
}

.custom-carousel-height .carousel-item img {
    height: 100%;
    object-fit: cover; /* This makes sure the image scales and covers the entire height */
}

</style>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        var status = {{ $customer->pin }}; // Default to 1 if not set
        if (status ==0) {
            $('#kycModal').modal('show'); // Show modal if pin == 0
        }
    });
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

@endsection
