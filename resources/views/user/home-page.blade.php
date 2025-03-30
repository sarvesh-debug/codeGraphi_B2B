@extends('user/include.layout')
@php
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

$mobile = Session::get('mobile', '');

$mobile=session('mobile');
$walletAmt=DB::table('add_moneys')->where('phone',$mobile) ->whereDate('created_at', Carbon::today())->sum('amount');
$commissionAmt=DB::table('getcommission')->where('retailermobile',$mobile) ->whereDate('created_at', Carbon::today())->sum('commission');

$DMTvalueAll=0;
    $countDMT=0;
            // Fetch data from 'cash_withdrawals'
    $transactionsDMTInstantPay  = DB::table('transactions_dmt_instant_pay')->where('remitter_mobile_number',$mobile) ->whereDate('created_at', Carbon::today())->get();
   
    foreach ($transactionsDMTInstantPay  as $transaction)  {
        $responseData = json_decode($transaction->response_data, true);
                        $payableValue=0;

        if(isset($responseData['statuscode']) && $responseData['statuscode'] == 'TXN')
        {
            $payableValue = (float)($responseData['data']['txnValue'] ?? 0);
            $DMTvalueAll += $payableValue;
            $countDMT +=1;
          
        }
    }

    $valueAll=0;
    $countAEPS=0;
            // Fetch data from 'cash_withdrawals'
    $cashWithdrawals = DB::table('cash_withdrawals')->where('mobile',$mobile	) ->whereDate('created_at', Carbon::today())->get();
    foreach ($cashWithdrawals as $withdrawal) {
        $responseData = json_decode($withdrawal->response_data, true);
        $payableValue=0;

        if(isset($responseData['statuscode']) && $responseData['statuscode'] == 'TXN')
        {
            $payableValue = (float)($responseData['data']['transactionValue'] ?? 0);
            $valueAll += $payableValue;
            $countAEPS +=1;
        }
}

$total_trans=$valueAll+$DMTvalueAll;


@endphp
@section('custom-css')
<style>
    .service-icon
    {
        width: 100%;
    }
    /* .service-text
    {
        text-align: center;
        font-size: 15px
    } */
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
	

	.news-ticker {
        overflow: hidden;
        white-space: nowrap;
        display: flex;
        align-items: center;
    }

	.gradient-aeps {
        background: linear-gradient(45deg, #ff416c, #ff4b2b);
    }

    .gradient-dmt {
        background: linear-gradient(45deg, #36d1dc, #5b86e5);
    }

    .gradient-recharge {
        background: linear-gradient(45deg, #ff9a9e, #fad0c4);
    }

    .gradient-bill {
        background: linear-gradient(45deg, #a18cd1, #fbc2eb);
    }

    .gradient-payout {
        /* background: linear-gradient(45deg, #f6d365, #fda085); */
		background: linear-gradient(135deg, #ff7e5f, #feb47b); /* Adjust gradient as per your theme */
    	color: white;
    }

    .service-text {
        font-size: 1rem;
        font-weight: 600;
		text-align: center;
    }

	.service-textm {
        font-size: 0.7rem;
        font-weight: 400;
		text-align: center;
    }


	.fixed-card {
		height: 130px; /* Set a uniform height */
		display: flex;
		flex-direction: column;
		justify-content: center;
		align-items: center;
		text-align: center;
		border-radius: 10px; /* Optional: Adds smooth rounded corners */
	}

	.card-body {
		/* display: flex; */
		flex-direction: column;
		justify-content: center;
		align-items: center;
	}

	/* Responsive Design */
	@media (max-width: 992px) { /* Tablets and below */
		.fixed-card {
			height: 120px;
		}
	}

	@media (max-width: 768px) { /* Mobile screens */
		.col-lg-2 {
			flex: 0 0 48%; /* Adjust width to fit two cards per row */
			max-width: 48%;
		}
		.fixed-card {
			height: 120px;
		}
	}

	@media (max-width: 576px) { /* Small mobile screens */
		.col-lg-2 {
			flex: 0 0 100%; /* Full width for small devices */
			max-width: 100%;
		}
		.fixed-card {
			height: 115px;
		}
	}

	.dynamic-service-card {
		width: 100%;
		height: 130px; /* Fixed height */
		display: flex;
		align-items: center;
		justify-content: center;
		text-align: center;
		border-radius: 8px;
		overflow: hidden;
		/* background: linear-gradient(135deg, #ff7eb3, #ff758c); */
	}

	.dynamic-service-card .card-body {
		padding: 10px;
		display: flex;
		flex-direction: column;
		align-items: center;
		justify-content: center;
	}

	.dynamic-service-card .card-img {
		width: 60px; /* Fixed width */
		height: 60px; /* Fixed height */
		display: flex;
		align-items: center;
		justify-content: center;
	}

	.dynamic-service-card .card-img img {
		max-width: 100%;
		max-height: 100%;
		object-fit: contain; /* Ensures the image is not stretched */
	}

	/* Responsive Styles */
	@media (max-width: 1200px) {
		.dynamic-service-card {
			height: 130px;
		}
		
		.dynamic-service-card .card-img {
			width: 55px;
			height: 55px;
		}

		.dynamic-service-card .service-text {
			font-size: 13px;
		}
	}

	@media (max-width: 992px) {
		.dynamic-service-card {
			height: 120px;
		}

		.dynamic-service-card .card-img {
			width: 50px;
			height: 50px;
		}
	}

	@media (max-width: 768px) {
		.dynamic-service-card {
			height: 120px;
		}

		.dynamic-service-card .card-img {
			width: 45px;
			height: 45px;
		}
	}

	@media (max-width: 576px) {
		.dynamic-service-card {
			height: 110px;
		}

		.dynamic-service-card .card-img {
			width: 40px;
			height: 40px;
		}
	}

	/* Gradient Colors for Each BBPS Service */
	.gradient-insurance {
		background: linear-gradient(135deg, #ff758c, #ff7eb3);
		color: white;
	}

	.gradient-postpaid {
		background: linear-gradient(135deg, #56ccf2, #2f80ed);
		color: white;
	}

	.gradient-credit {
		background: linear-gradient(135deg, #a18cd1, #fbc2eb);
		color: white;
	}

	.gradient-electricity {
		background: linear-gradient(135deg, #ff9a8b, #ff6a88);
		color: white;
	}

	.gradient-water {
		background: linear-gradient(135deg, #56ab2f, #a8e063);
		color: white;
	}

	.gradient-gas {
		background: linear-gradient(135deg, #ff9966, #ff5e62);
		color: white;
	}

	.fixed-card:hover {
		transform: scale(1.05);
	}

    .dynamic-service-card:hover {
        transform: scale(1.05);
	}

</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

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
        <div class="col-lg-12 mb-lg-4 mb-3 order-0">
            <!-- <div class="card">
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
            
            </div> -->
            <!-- <div class="card mt-1">
            <p class="h3 m-1 text-start"><span class="text-success1">Latest</span> <span class="text-info1">News</span></p>
            <marquee class="text-dark h5" style="color:black">
                {{$latest_new}}
            </marquee>
            
        </div> -->
		<div class="card p-1 shadow-sm border-0 d-none d-md-block">
			<p class="h4 m-1 text-start"></p>
			<div class="news-ticker">
				<marquee class="text-dark h5">
					<span class="text-danger fw-bold">Notification :</span> {{$latest_new}}
				</marquee>
			</div>
		</div>
		
    </div>
    <!-- <div class="container"> -->

		<style>
			/* Hide mobile view on larger screens */
			.mobile-view {
				display: none;
			}
			
			/* Hide web view on mobile screens */
			@media (max-width: 768px) {
				.web-view {
					display: none;
				}
				.mobile-view {
					display: block;
				}
			}
			</style>
			
			<!-- Web View (Visible on larger screens) -->
			<div class="web-view">
				<div class="row mb-3">
					<div class="col-lg-3 col-md-4 col-6 mb-4">
						<div class="card gradient-credit fixed-card">
							<div class="card-body">
								<a href="#">
									<h3 class="card-title mb-2 service-text">Today Transactions</h3>
									{{-- <h3 class="card-title mb-2 service-text">₹ {{$total_trans}}</h3> --}}
									<h3 class="card-title mb-2 service-text">₹ 0.00</h3>
								</a>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-4 col-6 mb-4">
						<div class="card gradient-electricity fixed-card">
							<div class="card-body">
								<a href="#">
									<h3 class="card-title mb-2 service-text">Today Payout</h3>
									<h3 class="card-title mb-2 service-text">₹ 0.00</h3>
								</a>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-4 col-6 mb-4">
						<div class="card gradient-dmt fixed-card">
							<div class="card-body">
								<a href="#">
									<h3 class="card-title mb-2 service-text">Wallet TopUp</h3>
									{{-- <h3 class="card-title mb-2 service-text">₹ {{$walletAmt}}</h3> --}}
									<h3 class="card-title mb-2 service-text">₹ 0.00</h3>
								</a>
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-4 col-6 mb-4">
						<div class="card gradient-water fixed-card">
							<div class="card-body">
								<a href="#">
									<h3 class="card-title mb-2 service-text">Today Earning</h3>
									{{-- <h3 class="card-title mb-2 service-text">₹ {{$commissionAmt}}</h3> --}}
									<h3 class="card-title mb-2 service-text">₹ 0.00</h3>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
			

<!-- Mobile View (Visible on smaller screens) -->
<style>
	/* Reduce overall card size */
	.mobile-view .card {
		padding: 2px; /* Reduce card padding */
		font-size: 12px;
		height: auto; /* Auto height based on content */
		padding-left: 2px;
		padding-right: 2px;
		width: 60%; /* Reduce card width */
		margin: 0 auto; /* Center the card */
	}

	/* Reduce padding inside the card body */
	.mobile-view .card-body {
		padding: 10px; /* Minimize padding */
		margin: 5px;
	}

	/* Reduce heading and text size */
	.mobile-view .card-title {
		font-size: 10px;
		margin-bottom: 2px; /* Reduce spacing */
	}

	.mobile-view p {
		font-size: 12px;
		margin-bottom: 0; /* Remove extra margin */
	}

	/* Adjust width on smaller screens */
	@media (max-width: 576px) { 
		.mobile-view .card {
			width: 85%; /* Even smaller width on extra small screens */
		}
	}
</style>

<!-- Mobile View (Visible on smaller screens) -->
<div class="mobile-view">
	<div class="row">
		<div class="col-6 mb-2">
			<div class="card gradient-credit fixed-card">
				<div class="card-body text-center">
					<a href="#">
						<h6 class="card-title service-text">Today Transactions</h6>
						<p class="small">₹ {{$total_trans}}</p>
						<!-- <p class="small">₹ 0.00</p> -->
					</a>
				</div>
			</div>
		</div>
		<div class="col-6 mb-2">
			<div class="card gradient-electricity fixed-card">
				<div class="card-body text-center">
					<a href="#">
						<h6 class="card-title service-text">Today Payout</h6>
						<p class="small">₹ 0.00</p>
					</a>
				</div>
			</div>
		</div>
		<div class="col-6 mb-2">
			<div class="card gradient-dmt fixed-card">
				<div class="card-body text-center">
					<a href="#">
						<h6 class="card-title service-text">Wallet TopUp</h6>
						<p class="small">₹ {{$walletAmt}}</p> 
						<!-- <p class="small">₹ 0.00</p> -->
					</a>
				</div>
			</div>
		</div>
		<div class="col-6 mb-2">
			<div class="card gradient-water fixed-card">
				<div class="card-body text-center">
					<a href="#">
						<h6 class="card-title service-text">Today Earning</h6>
						<p class="small">₹ {{$commissionAmt}}</p>
						<!-- <p class="small">₹ 0.00</p> -->
					</a>
				</div>
			</div>
		</div>
	</div>
</div>

	
	
	
<script>
	document.addEventListener("DOMContentLoaded", function () {
		function handleResponsiveView() {
			if (window.innerWidth <= 768) {
				document.getElementById("web-view").style.display = "none";
				document.getElementById("mobile-view").style.display = "block";
			} else {
				document.getElementById("web-view").style.display = "block";
				document.getElementById("mobile-view").style.display = "none";
			}
		}
	
		handleResponsiveView(); // Initial check
		window.addEventListener("resize", handleResponsiveView); // Check on resize
	});
</script>	


<style>
	@media (max-width: 767px) {
  .col-3 {
    flex: 0 0 25%;
    max-width: 25%;
  }
}

</style>



<div id="web-view">
    <!-- Web view code (current desktop layout) -->

	<div class="row">
		<!-- <p class="h4 text-success1">Services</p>
		<p class="h5 text-info1">Look A glance towards services</p> -->
		   {{-- card start --}}
		<div class="col-lg-2 col-md-3 col-6 mb-4">
		  <div class="card gradient-aepss fixed-card">
			  <div class="card-body">
				  @if ($customer->aeps == 1 && $customer->status ==="active" && $customer->pin >0)
					  <a href="{{ route('cash.withdrawal.form') }}">
						  <!-- <div class="card-title d-flex align-items-start justify-content-between">
							  <div class="card-img">
								  <img src="{{ asset('assets/img/icons/AEPS.png') }}" class="service-icon" />
							  </div>
						  </div> -->
						  <div class="card-title d-flex align-items-center justify-content-center">
							  <i class="fas fa-fingerprint fa-3x"></i>
						  </div>
						  <h3 class="card-title mb-2 service-text">AEPS</h3>
					  </a>
				  @else
					  <a href="javascript:void(0);" onclick="showAlert('{{ $customer->name }}',{{$customer->pin}},{{$customer->status}});">
						  <!-- <div class="card-title d-flex align-items-start justify-content-between">
							  <div class="card-img">
								  <img src="{{ asset('assets/img/icons/AEPS.png') }}" class="service-icon" />
							  </div>
						  </div> -->
						  <div class="card-title d-flex align-items-center justify-content-center">
							  <i class="fas fa-fingerprint fa-3x"></i>
						  </div>
						  <h3 class="card-title mb-2 service-text">AEPS</h3>
					  </a>
				  @endif
			  </div>
		  </div>
	  </div>
	  <!-- Aahar pay -->
	  <div class="col-lg-2 col-md-3 col-6 mb-4">
		  <div class="card gradient-insurancee fixed-card">
			  <div class="card-body">
				  <a href="#">
					  <div class="card-title d-flex align-items-center justify-content-center">
						  <i class="fas fa-id-card fa-3x"></i>
					  </div>
					  <h3 class="card-title mb-2 service-text">Aadhar Pay</h3>
				  </a>
			  </div>
		  </div>
	  </div>
	  <!-- mATM -->
	  <div class="col-lg-2 col-md-3 col-6 mb-4">
		  <div class="card gradient-insurancee fixed-card">
			  <div class="card-body">
				  <a href="#">
					  <div class="card-title d-flex align-items-center justify-content-center">
						  <i class="fas fa-credit-card fa-3x"></i>
					  </div>
					  <h3 class="card-title mb-2 service-text">mATM</h3>
				  </a>
			  </div>
		  </div>
	  </div>
	  <!-- POS -->
	  <div class="col-lg-2 col-md-3 col-6 mb-4">
		  <div class="card gradient-insurancee fixed-card">
			  <div class="card-body">
				  <a href="#">
					  <div class="card-title d-flex align-items-center justify-content-center">
						  <i class="fas fa-calculator fa-3x"></i>
					  </div>
					  <h3 class="card-title mb-2 service-text">POS</h3>
				  </a>
			  </div>
		  </div>
	  </div>
	   <div class="col-lg-2 col-md-3 col-6 b-4">
		  <div class="card  gradient-rechargee fixed-card">
			  <div class="card-body">
				  @if ($customer->aeps == 1 && $customer->status ==="active" && $customer->pin >0)
					  <a href="{{ route('getISP') }}">
						  <!-- <div class="card-title d-flex align-items-start justify-content-between">
							  <div class="card-img">
								  <img src="{{ asset('assets/img/icons/mobile_recharge.png') }}" class="service-icon" />
							  </div>
						  </div> -->
							<div class="card-title d-flex align-items-center justify-content-center">
							  <i class="fas fa-mobile-alt fa-3x"></i>
						  </div>
						  <h3 class="card-title mb-2 service-text">Mobile Recharge</h3>
					  </a>
				  @else
					  <a href="javascript:void(0);" onclick="showAlert('{{ $customer->name }}',{{$customer->pin}},{{$customer->status}});">
						  <!-- <div class="card-title d-flex align-items-start justify-content-between">
							  <div class="card-img">
								  <img src="{{ asset('assets/img/icons/mobile_recharge.png') }}" class="service-icon" />
							  </div>
						  </div> -->
							<div class="card-title d-flex align-items-center justify-content-center">
							  <i class="fas fa-mobile-alt fa-3x"></i>
						  </div>
						  <h3 class="card-title mb-2 service-text">Mobile Recharge</h3>
					  </a>
				  @endif
			  </div>
		  </div>
	  </div>


	   <!-- Nepal Money -->
		<div class="col-lg-2 col-md-3 col-3 mb-4">
			<div class="card gradient-insurancee fixed-card">
				<div class="card-body">
					<a href="{{route('pageNotFound')}}">
						<div class="card-title d-flex align-items-center justify-content-center">
                            <i class="fa-solid fa-coins fa-3x"></i>
						</div>
						<h3 class="card-title mb-2 mt-2 service-text">Nepal Money</h3>
					</a>
				</div>
			</div>
		</div>

		<!-- Insurance -->
		<div class="col-lg-2 col-md-3 col-3 mb-4">
			<div class="card gradient-insurancee fixed-card">
				<div class="card-body">
					<a href="{{route('pageNotFound')}}">
						<div class="card-title d-flex align-items-center justify-content-center">
							<i class="fas fa-shield-alt fa-3x"></i>
						</div>
						<h3 class="card-title mb-2 mt-2 service-text">Insurance</h3>
					</a>
				</div>
			</div>
		</div>

		<!-- Loan -->
		<div class="col-lg-2 col-md-3 col-3 mb-4">
			<div class="card gradient-insurancee fixed-card">
				<div class="card-body">
					<a href="{{route('pageNotFound')}}">
						<div class="card-title d-flex align-items-center justify-content-center">
                            <i class="fa-solid fa-sack-dollar fa-3x"></i>
						</div>
						<h3 class="card-title mb-2 mt-2 service-text">Loan</h3>
					</a>
				</div>
			</div>
		</div>

		<!-- Pan -->
		<div class="col-lg-2 col-md-3 col-3 mb-4">
			<div class="card gradient-insurancee fixed-card">
				<div class="card-body">
					<a href="{{route('pageNotFound')}}">
						<div class="card-title d-flex align-items-center justify-content-center">
                            <i class="fa-solid fa-id-card fa-3x"></i>
						</div>
						<h3 class="card-title mb-2 mt-2 service-text">PAN Card</h3>
					</a>
				</div>
			</div>
		</div>

		<!-- Postpaid -->
		<div class="col-lg-2 col-md-3 col-3 mb-4">
			<div class="card gradient-postpaidd fixed-card">
				<div class="card-body">
					<a href="{{route('pageNotFound')}}">
						<div class="card-title d-flex align-items-center justify-content-center">
							<!-- <i class="fas fa-phone-alt fa-3x"></i> -->
                            <i class="fa-solid fa-mobile-button fa-3x"></i>
						</div>
						<h3 class="card-title mb-2 mt-2 service-text">Postpaid</h3>
					</a>
				</div>
			</div>
		</div>

		<!-- Credit Card -->
		<div class="col-lg-2 col-md-3 col-3 mb-4">
			<div class="card gradient-creditt fixed-card">
				<div class="card-body">
					<a href="{{route('pageNotFound')}}">
						<div class="card-title d-flex align-items-center justify-content-center">
							<i class="fas fa-credit-card fa-3x"></i>
						</div>
						<h3 class="card-title mb-2 mt-2 service-text">Credit Card</h3>
					</a>
				</div>
			</div>
		</div>

		<!-- Electricity Bill -->
		<div class="col-lg-2 col-md-3 col-3 mb-4">
			<div class="card gradient-electricityy fixed-card">
				<div class="card-body">
					<a href="{{route('pageNotFound')}}">
						<div class="card-title d-flex align-items-center justify-content-center">
							<i class="fas fa-bolt fa-3x"></i>
						</div>
						<h3 class="card-title mb-2 mt-2 service-text">Electricity</h3>
					</a>
				</div>
			</div>
		</div>
		

		<!-- Water Bill -->
		<div class="col-lg-2 col-md-3 col-3 mb-4">
			<div class="card gradient-waterr fixed-card">
				<div class="card-body">
					<a href="{{route('pageNotFound')}}">
						<div class="card-title d-flex align-items-center justify-content-center">
							<i class="fas fa-tint fa-3x"></i>
						</div>
						<h3 class="card-title mb-2 mt-2 service-text">Water Bill</h3>
					</a>
				</div>
			</div>
		</div>

		<!-- Gas Bill -->
		<div class="col-lg-2 col-md-3 col-3 mb-4">
			<div class="card gradient-gass fixed-card">
				<div class="card-body">
					<a href="{{route('pageNotFound')}}">
						<div class="card-title d-flex align-items-center justify-content-center">
                            <i class="fa-solid fa-bottle-droplet fa-3x"></i>
						</div>
						<h3 class="card-title mb-2 mt-2 service-text">Gas Bill</h3>
					</a>
				</div>
			</div>
		</div>



	  <div class="col-lg-2 col-md-3 col-6 mb-4">
		  <div class="card gradient-dmtt fixed-card">
			  <div class="card-body">
				  @if ($customer->dmt == 1 && $customer->balance >0 && $customer->status ==="active" && $customer->pin >0)
					  <a href="{{route('dmt.remitter-profile')}}">
						  <!-- <div class="card-title d-flex align-items-start justify-content-between">
							  <div class="card-img">
								  <img src="{{asset('assets/img/icons/money_transfer.png')}}" class="service-icon" />
							  </div>
						  </div> -->
						  <div class="card-title d-flex align-items-center justify-content-center">
							  <i class="fas fa-exchange-alt fa-3x"></i>
						  </div>
						  <h3 class="card-title mb-2 service-text">D M T </h3>
					  </a>
				  @else
					  <a href="javascript:void(0);" onclick="showAlert('{{ $customer->name }}',{{ $customer->balance }},{{$customer->pin}});">
						  <!-- <div class="card-title d-flex align-items-start justify-content-between">
							  <div class="card-img">
								  <img src="{{asset('assets/img/icons/money_transfer.png')}}" class="service-icon" />
							  </div>
						  </div> -->
						  <div class="card-title d-flex align-items-center justify-content-center">
							  <i class="fas fa-exchange-alt fa-3x"></i>
						  </div>
						  <h3 class="card-title mb-2 service-text">D M T </h3>
					  </a>
				  @endif
			  </div>
		  </div>
	  </div>

		 <div class="col-lg-2 col-md-3 col-6 mb-4">
		  <div class="card gradient-payoutt fixed-card">
			  <div class="card-body">
				  @if ($customer->payout == 1 && $customer->balance >0 && $customer->status ==="active" && $customer->pin >0)
					  <!-- If AEPS is active, open the cash withdrawal form -->
					  <a href="">
						  <!-- <div class="card-title d-flex align-items-start justify-content-between">
							  <div class="">
								  <img src="{{asset('assets/img/icons/pay_out.png')}}" class="service-icon" />
							  </div>
						  </div> -->
						   <div class="card-title d-flex align-items-center justify-content-center">
							   <i class="fas fa-wallet fa-3x"></i>
						  </div>
						  <h3 class="card-title mb-2 service-text">PayOut</h3>
					  </a>
				  @else
					  <!-- If AEPS is inactive, show an alert -->
					  <a href="javascript:void(0);" onclick="showAlert('{{ $customer->name }}',{{ $customer->balance }},{{$customer->pin}});">
						  <!-- <div class="card-title d-flex align-items-start justify-content-between">
							  <div class="">
								  <img src="{{asset('assets/img/icons/pay_out.png')}}" class="service-icon" />
							  </div>
						  </div> -->
						   <div class="card-title d-flex align-items-center justify-content-center">
							  <i class="fas fa-shield-alt fa-3x"></i>
						  </div>
						  <h3 class="card-title mb-2 service-text">PayOut</h3>
					  </a>
				  @endif
			  </div>
		  </div>
	  </div>



	   <!-- card-->
	   <div class="col-lg-2 col-md-3 col-6 mb-4">
		  <div class="card gradient-billl fixed-card">
			  <div class="card-body">
				  @if ($customer->cc_bill_payment == 1 && $customer->balance >0 && $customer->status ==="active" && $customer->pin >0)
					  <!-- If AEPS is active, open the cash withdrawal form -->
					  <a href="{{route('getcategory')}}">
						  <!-- <div class="card-title d-flex align-items-start justify-content-between">
							  <div class="card-img">
								  <img src="{{asset('assets/img/icons/bill_payment.png')}}" class="service-icon" />
							  </div>
						  </div> -->
						  <div class="card-title d-flex align-items-center justify-content-center">
							  <i class="fas fa-file-invoice-dollar fa-3x"></i>
						  </div>
						  <h3 class="card-title mb-2 service-text">Bill Payment</h3>
					  </a>
				  @else
					  <!-- If AEPS is inactive, show an alert -->
					  <a href="javascript:void(0);" onclick="showAlert('{{ $customer->name }}',{{ $customer->balance }},{{$customer->pin}});">
						  <!-- <div class="card-title d-flex align-items-start justify-content-between">
							  <div class="card-img">
								  <img src="{{asset('assets/img/icons/bill_payment.png')}}" class="service-icon" />
							  </div>
						  </div> -->
						  <div class="card-title d-flex align-items-center justify-content-center">
							  <i class="fas fa-file-invoice-dollar fa-3x"></i>
						  </div>
						  <h3 class="card-title mb-2 service-text">Bill Payment</h3>
					  </a>
				  @endif
			  </div>
		  </div>
	  </div>

	  
  
	  @foreach($services as $service)
		  <div class="col-lg-2 col-md-3 col-6 mb-4">
			  <div class="card dynamic-service-card">
				  <div class="card-body">
					  <a href="{{ $service->service_link }}" target="_blank">
						  <div class="card-title d-flex align-items-start justify-content-center">
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
	  
		  <!-- @foreach($services as $service)
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
		  @endforeach -->
	 
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
	  <!-- <div class="col-lg-12 col-md-12 order-1 my-4"> 
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
	  </div>      -->
  </div> 

</div>


 



{{-- Mobile view --}}
<div id="mobile-view" style="display: none;">

	{{-- <h5 class="d-block d-md-none ">Bill & Recharge</h5> --}}

    <!-- Second Service Section -->
    <div class="row g-0.2 bg-white m-2 py-3 rounded service-container">
        <!-- AEPS Service -->
       
		<div class="col-3 ">

			<div class=" ">
				<div class="card-body">
					@if ($customer->aeps == 1 && $customer->status ==="active" && $customer->pin >0)
						<a href="{{ route('cash.withdrawal.form') }}">
							<!-- <div class="card-title d-flex align-items-start justify-content-between">
								<div class="card-img">
									<img src="{{ asset('assets/img/icons/AEPS.png') }}" class="service-icon" />
								</div>
							</div> -->
							<div class="card-title d-flex align-items-center justify-content-center">
								<i class="fas fa-fingerprint fa-2xl mb-1"></i>
							</div>
							<h3 class="card-title mb-2  service-textm">AEPS</h3>
						</a>
					@else
						<a href="javascript:void(0);" onclick="showAlert('{{ $customer->name }}',{{$customer->pin}},{{$customer->status}});">
							<!-- <div class="card-title d-flex align-items-start justify-content-between">
								<div class="card-img">
									<img src="{{ asset('assets/img/icons/AEPS.png') }}" class="service-icon" />
								</div>
							</div> -->
							<div class="card-title d-flex align-items-center justify-content-center">
								<i class="fas fa-fingerprint fa-2xl mb-1"></i>
							</div>
							<h3 class="card-title mb-2 service-textm">AEPS</h3>
						</a>
					@endif
				</div>
			</div>
		</div>


		{{-- dmt --}}
		<div class="col-lg-2 col-md-3 col-3 ">
			<div class=" ">
				<div class="card-body">
					@if ($customer->dmt == 1 && $customer->balance >0 && $customer->status ==="active" && $customer->pin >0)
						<a href="{{route('dmt.remitter-profile')}}">
							<!-- <div class="card-title d-flex align-items-start justify-content-between">
								<div class="card-img">
									<img src="{{asset('assets/img/icons/money_transfer.png')}}" class="service-icon" />
								</div>
							</div> -->
							<div class="card-title d-flex align-items-center justify-content-center">
								<i class="fas fa-exchange-alt fa-2xl mb-1"></i>
							</div>
							<h3 class="card-title mb-2 service-textm">DMT </h3>
						</a>
					@else
						<a href="javascript:void(0);" onclick="showAlert('{{ $customer->name }}',{{ $customer->balance }},{{$customer->pin}});">
							<!-- <div class="card-title d-flex align-items-start justify-content-between">
								<div class="card-img">
									<img src="{{asset('assets/img/icons/money_transfer.png')}}" class="service-icon" />
								</div>
							</div> -->
							<div class="card-title d-flex align-items-center justify-content-center">
								<i class="fas fa-exchange-alt fa-2xl mb-1"></i>
							</div>
							<h3 class="card-title mb-2 service-textm">DMT </h3>
						</a>
					@endif
				</div>
			</div>
		</div>



		<!-- mATM -->
		<div class="col-lg-2 col-md-3 col-3 ">
			<div class=" ">
				<div class="card-body">
					<a href="#">
						<div class="card-title d-flex align-items-center justify-content-center">
							<i class="fas fa-credit-card fa-2xl mb-1"></i>
						</div>
						<h3 class="card-title mb-2 mt-2 service-textm">mATM</h3>
					</a>
				</div>
			</div>
		</div>
  
  
  
		<!-- POS -->
		<div class=" col-3 ">
			<div class=" ">
				<div class="card-body">
					<a href="#">
						<div class="card-title d-flex align-items-center justify-content-center">
							<i class="fas fa-calculator fa-2xl mb-1"></i>
						</div>
						<h3 class="card-title mb-2 service-textm">POS</h3>
					</a>
				</div>
			</div>
		</div>
		
			<!-- Pan -->
	<div class="col-lg-2 col-md-3 col-3">
		<div class=" ">
			<div class="card-body">
				<a href="#">
					<div class="card-title d-flex align-items-center justify-content-center">
						<i class="fa-solid fa-id-card fa-2xl mb-1"></i>
					</div>
					<h3 class="card-title mb-2 mt-2 service-textm">PAN Card</h3>
				</a>
			</div>
		</div>
	</div>
  
	  <!-- Nepal Money -->
	  <div class=" col-3">
		  <div class=" ">
			  <div class="card-body">
				  <a href="#">
					  <div class="card-title d-flex align-items-center justify-content-center">
						  <i class="fa-solid fa-coins fa-2xl mb-1"></i>
					  </div>
					  <h3 class="card-title mb-2 service-textm">Nepal Money</h3>
				  </a>
			  </div>
		  </div>
	  </div>


	   <!-- Aahar pay -->
	   <div class="col-md-3 col-3 ">
		<div class=" ">
			<div class="card-body">
				<a href="#">
					<div class="card-title d-flex align-items-center justify-content-center">
						<i class="fas fa-id-card fa-2xl mb-1"></i>
					</div>
					<h3 class="card-title mb-2 mt-2 service-textm">Aadhar Pay</h3>
				</a>
			</div>
		</div>
	</div>

  
			<!-- Credit Card -->
	<div class="col-lg-2 col-md-3 col-3">
		<div class=" ">
			<div class="card-body">
				<a href="#">
					<div class="card-title d-flex align-items-center justify-content-center">
						<i class="fas fa-credit-card fa-2xl mb-1"></i>
					</div>
					<h3 class="card-title mb-2 mt-2 service-textm">Credit Card</h3>
				</a>
			</div>
		</div>
	</div>
		  

		<!-- Postpaid -->
	<div class="col-3 service-card hidden-service"  style="display: none;">
		<div class=" ">
			<div class="card-body">
				<a href="#">
					<div class="card-title d-flex align-items-center justify-content-center">
						<!-- <i class="fas fa-phone-alt fa-3x"></i> -->
						<i class="fa-solid fa-mobile-button fa-2xl mb-1"></i>
					</div>
					<h3 class="card-title mb-2 mt-2 service-textm">Postpaid</h3>
				</a>
			</div>
		</div>
	</div>



	<div class="col-3 service-card hidden-service" style="display: none;">
		<div class=" ">
			<div class="card-body">
				@if ($customer->payout == 1 && $customer->balance >0 && $customer->status ==="active" && $customer->pin >0)
					<!-- If AEPS is active, open the cash withdrawal form -->
					<a href="">
						<!-- <div class="card-title d-flex align-items-start justify-content-between">
							<div class="">
								<img src="{{asset('assets/img/icons/pay_out.png')}}" class="service-icon" />
							</div>
						</div> -->
						 <div class="card-title d-flex align-items-center justify-content-center">
							 <i class="fas fa-wallet fa-2xl mb-1"></i>
						</div>
						<h3 class="card-title mb-2 service-textm">PayOut</h3>
					</a>
				@else
					<!-- If AEPS is inactive, show an alert -->
					<a href="javascript:void(0);" onclick="showAlert('{{ $customer->name }}',{{ $customer->balance }},{{$customer->pin}});">
						<!-- <div class="card-title d-flex align-items-start justify-content-between">
							<div class="">
								<img src="{{asset('assets/img/icons/pay_out.png')}}" class="service-icon" />
							</div>
						</div> -->
						 <div class="card-title d-flex align-items-center justify-content-center">
							<i class="fas fa-shield-alt fa-2xl mb-1"></i>
						</div>
						<h3 class="card-title mb-2 service-textm">PayOut</h3>
					</a>
				@endif
			</div>
		</div>
	</div>


        <!-- More / Less Button -->
        <div class="col-12 text-center mt-3">
            <button class="btn btn-primary toggle-btn" onclick="toggleServices(this)">More</button>
        </div>
    </div>



	
	<h5 class="d-block d-md-none ">Bill & Recharge</h5>

	 <!-- Third Service Section -->
	 <div class="row g-0.2 bg-white m-2 py-3 rounded service-container">
        <!-- AEPS Service -->
		<div class="col-3 ">
			<div class=" ">
				<div class="card-body">
					@if ($customer->aeps == 1 && $customer->status ==="active" && $customer->pin >0)
						<a href="{{ route('getISP') }}">
							<!-- <div class="card-title d-flex align-items-start justify-content-between">
								<div class="card-img">
									<img src="{{ asset('assets/img/icons/mobile_recharge.png') }}" class="service-icon" />
								</div>
							</div> -->
							  <div class="card-title d-flex align-items-center justify-content-center">
								<i class="fas fa-mobile-alt fa-2xl mb-1"></i>
							</div>
							<h3 class="card-title  service-textm">Mobile Recharge</h3>
						</a>
					@else
						<a href="javascript:void(0);" onclick="showAlert('{{ $customer->name }}',{{$customer->pin}},{{$customer->status}});">
							<!-- <div class="card-title d-flex align-items-start justify-content-between">
								<div class="card-img">
									<img src="{{ asset('assets/img/icons/mobile_recharge.png') }}" class="service-icon" />
								</div>
							</div> -->
							  <div class="card-title d-flex align-items-center justify-content-center">
								<i class="fas fa-mobile-alt fa-2xl mb-1"></i>
							</div>
							<h3 class="card-title  service-textm">Mobile Recharge</h3>
						</a>
					@endif
				</div>
			</div>
		</div>


			<!-- Electricity Bill -->
	<div class="col-lg-2 col-md-3 col-3 ">
		<div class=" ">
			<div class="card-body">
				<a href="#">
					<div class="card-title d-flex align-items-center justify-content-center">
						<i class="fas fa-bolt fa-2xl mb-1"></i>
					</div>
					<h3 class="card-title mb-2 mt-2 service-textm">Electricity Bill</h3>
				</a>
			</div>
		</div>
	</div>


	<!-- Water Bill -->
	<div class="col-lg-2 col-md-3 col-3">
		<div class=" ">
			<div class="card-body">
				<a href="#">
					<div class="card-title d-flex align-items-center justify-content-center">
						<i class="fas fa-tint fa-2xl mb-1"></i>
					</div>
					<h3 class="card-title mb-2 mt-2 service-textm">Water Bill</h3>
				</a>
			</div>
		</div>
	</div>



	 <!-- card-->
	 <div class="col-lg-2 col-md-3 col-3 ">
		<div class=" ">
			<div class="card-body">
				@if ($customer->cc_bill_payment == 1 && $customer->balance >0 && $customer->status ==="active" && $customer->pin >0)
					<!-- If AEPS is active, open the cash withdrawal form -->
					<a href="{{route('getcategory')}}">
						<!-- <div class="card-title d-flex align-items-start justify-content-between">
							<div class="card-img">
								<img src="{{asset('assets/img/icons/bill_payment.png')}}" class="service-icon" />
							</div>
						</div> -->
						<div class="card-title d-flex align-items-center justify-content-center">
							<i class="fas fa-file-invoice-dollar fa-2xl mb-1"></i>
						</div>
						<h3 class="card-title mb-2 mt-2 service-textm">Bill Payment</h3>
					</a>
				@else
					<!-- If AEPS is inactive, show an alert -->
					<a href="javascript:void(0);" onclick="showAlert('{{ $customer->name }}',{{ $customer->balance }},{{$customer->pin}});">
						<!-- <div class="card-title d-flex align-items-start justify-content-between">
							<div class="card-img">
								<img src="{{asset('assets/img/icons/bill_payment.png')}}" class="service-icon" />
							</div>
						</div> -->
						<div class="card-title d-flex align-items-center justify-content-center">
							<i class="fas fa-file-invoice-dollar fa-2xl mb-1"></i>
						</div>
						<h3 class="card-title mb-2 service-textm">Bill Payment</h3>
					</a>
				@endif
			</div>
		</div>
	</div>


        <!-- More services -->
        <div class="col-3 service-card hidden-service" style="display: none;">
            <div class="card-body">
                <a href="#">
                    <div class="card-title d-flex align-items-center justify-content-center">
                        <i class="fas fa-tint fa-2xl mb-1"></i>
                    </div>
                    <h3 class="card-title mb-2 mt-2 service-textm">Water Bill</h3>
                </a>
            </div>
        </div>

		<!-- Gas Bill -->
	<div class="col-3 service-card hidden-service" style="display: none;">
		<div class=" ">
			<div class="card-body">
				<a href="#">
					<div class="card-title d-flex align-items-center justify-content-center">
						<i class="fa-solid fa-bottle-droplet fa-2xl mb-1"></i>
					</div>
					<h3 class="card-title mb-2 mt-2 service-textm">Gas Bill</h3>
				</a>
			</div>
		</div>
	</div>


        <!-- More / Less Button -->
        <div class="col-12 text-center mt-2">
            <button class="btn btn-primary toggle-btn" onclick="toggleServices(this)">More</button>
        </div>
    </div>


	<h5 class="d-block d-md-none ">Other Services</h5>

	 <!-- fourth Service Section -->
	 <div class="row g-0.2 bg-white m-2 py-3 rounded service-container">
		<!-- Insurance -->
	<div class="col-lg-2 col-md-3 col-3">
		<div class=" ">
			<div class="card-body">
				<a href="#">
					<div class="card-title d-flex align-items-center justify-content-center">
						<i class="fas fa-shield-alt fa-2xl mb-1"></i>
					</div>
					<h3 class="card-title mb-2 mt-2 service-textm">Insurance</h3>
				</a>
			</div>
		</div>
	</div>

	<!-- Loan -->
	<div class="col-lg-2 col-md-3 col-3 ">
		<div class=" ">
			<div class="card-body">
				<a href="#">
					<div class="card-title d-flex align-items-center justify-content-center">
						<i class="fa-solid fa-sack-dollar fa-2xl mb-1"></i>
					</div>
					<h3 class="card-title mb-2 mt-2 service-textm">Loan</h3>
				</a>
			</div>
		</div>
	</div>


		<!-- Postpaid -->
	<div class="col-lg-2 col-md-3 col-3">
		<div class=" ">
			<div class="card-body">
				<a href="#">
					<div class="card-title d-flex align-items-center justify-content-center">
						<!-- <i class="fas fa-phone-alt fa-3x"></i> -->
						<i class="fa-solid fa-mobile-button fa-2xl mb-1"></i>
					</div>
					<h3 class="card-title mb-2 mt-2 service-textm">Postpaid</h3>
				</a>
			</div>
		</div>
	</div>


	 <!-- POS -->
	 <div class=" col-3 ">
		<div class=" ">
			<div class="card-body">
				<a href="#">
					<div class="card-title d-flex align-items-center justify-content-center">
						<i class="fas fa-calculator fa-2xl mb-1"></i>
					</div>
					<h3 class="card-title mb-2 service-textm">POS</h3>
				</a>
			</div>
		</div>
	</div>


        <!-- More services -->
       
		@foreach($services as $service)
		<div class=" col-3 service-card hidden-service "   style="display: none;">
			<div class=" ">
				<div class="">
					<a href="{{ $service->service_link }}" target="_blank">
						<div class="card-title d-flex align-items-start justify-content-center">
							<div class="card-img">
								{{-- <img src="{{ $service->logo_name }}" class="service-icon" /> --}}
								<img src="{{ $service->logo_name }}" class="service-icon" style="width: 40px; height: 40px;" />

							</div>
						</div>
						<h3 class="card-title mb-2 mt-3 service-textm">{{ $service->service }}</h3>
					</a>
				</div>
			</div>
		</div>
	@endforeach
	
		<!-- @foreach($services as $service)
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
		@endforeach -->


        <!-- More / Less Button -->
        <div class="col-12 text-center mt-2">
            <button class="btn btn-primary toggle-btn" onclick="toggleServices(this)">More</button>
        </div>
    </div>



</div>






<script>
    (function() {
        function toggleServices(button) {
            let section = button.closest('.service-container'); // Find the closest section
            let hiddenCards = section.querySelectorAll('.hidden-service'); // Select hidden services inside this section

            if (hiddenCards.length === 0) return; // Prevent errors if no hidden services exist

            let isHidden = hiddenCards[0].style.display === "none"; // Check the first hidden element's state

            hiddenCards.forEach(card => card.style.display = isHidden ? "block" : "none"); // Toggle visibility
            button.textContent = isHidden ? "Less" : "More"; // Toggle button text
        }

        function showAlert(name, balance, pin, status) {
            if (balance <= 0) {
                alert('Insufficient Wallet Balance');
            } else if (pin == 0) {
                alert(`Dear ${name}, please complete your Full-KYC.`);
            } else if (status === "deactive") {
                alert(`Dear ${name}, your account is deactivated. Please contact the distributor.`);
            } else {
                alert(`Dear ${name}, your services are deactivated. Please contact the distributor.`);
            }
        }

        // Expose function to global scope
        window.showAlert = showAlert;
        window.toggleServices = toggleServices;
    })();
</script>



</div>



<!-- Carousel (Visible Only on Mobile) -->
<div id="mobileCarousel" class="carousel slide d-md-none mb-5 mt-2 rounded" data-bs-ride="carousel" style="max-width: 95%; margin: auto;">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="{{asset('assets/img/carousel_5.jpg')}}" class="d-block w-100 rounded-3" alt="Slide 1" style="height: 160px; object-fit: cover;">
        </div>
        <div class="carousel-item">
            <img src="{{asset('assets/img/carousel_2.jpg')}}" class="d-block w-100 rounded-3" alt="Slide 2" style="height: 160px; object-fit: cover;">
        </div>
        <div class="carousel-item">
            <img src="{{asset('assets/img/carousel_3.jpg')}}" class="d-block w-100 rounded-3" alt="Slide 3" style="height: 160px; object-fit: cover;">
        </div>
    </div>
    <a class="carousel-control-prev" href="#mobileCarousel" role="button" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    </a>
    <a class="carousel-control-next" href="#mobileCarousel" role="button" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
    </a>
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




{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"> --}}

{{-- <!-- Bottom Navigation Bar -->
<nav class="navbar fixed-bottom navbar-light bg-white border-top d-md-none">
    <div class="container d-flex justify-content-around">
        <a href="#" class="text-gray text-center">
            <i class="fa-solid fa-house fs-4"></i>
            <div class="small">Home</div>
        </a>
        <a href="#" class="text-gray text-center">
            <i class="fa-solid fa-th fs-4"></i>
            <div class="small">Services</div>
        </a>
        <a href="#" class="text-gray text-center">
            <i class="fa-solid fa-wallet fs-4"></i>
            <div class="small">Wallet</div>
        </a>
        <a href="#" class="text-gray text-center">
            <i class="fa-solid fa-user-circle fs-4"></i>
            <div class="small">Profile</div>
        </a>
    </div>
</nav> --}}

@endsection
