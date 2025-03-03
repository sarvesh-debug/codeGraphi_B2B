@extends('admin/include.layout')  
@php
    $distibutor=\App\Models\CustomerModel::where('role', 'distibuter')->count();
    $retailer=\App\Models\CustomerModel::where('role', 'Retailer')->count();
    $userTotal=$retailer+$distibutor;
    $amtDistributor=\App\Models\CustomerModel::where('role', 'distibuter')->sum('balance');
    $amtRetailer=\App\Models\CustomerModel::where('role', 'Retailer')->sum('balance');
    $userTotalAmt=$amtDistributor+$amtRetailer;
    //PaymentRequest
    use Illuminate\Support\Facades\DB;

$acceptAmt = DB::table('add_moneys')->where('status', 1)->where('date',today())->sum('amount');
$rejectAmt = DB::table('add_moneys')->where('status', -1)->where('date',today())->sum('amount');
$pendingAmt = DB::table('add_moneys')->where('status', 0)->where('date',today())->sum('amount');
$acceptCnt = DB::table('add_moneys')->where('status', 1)->where('date',today())->count('amount');
$rejectCnt = DB::table('add_moneys')->where('status', -1)->where('date',today())->count('amount');
$pendingCnt = DB::table('add_moneys')->where('status', 0)->where('date',today())->count('amount');

$payCntTotal=$acceptCnt+$pendingCnt+$rejectCnt;
$payAmtTotal=$acceptAmt+$pendingAmt+$rejectAmt;


    $DMTvalueAll=0;
            // Fetch data from 'cash_withdrawals'
    $transactionsDMTInstantPay  = DB::table('transactions_dmt_instant_pay')->get();
   
    foreach ($transactionsDMTInstantPay  as $transaction)  {
        $responseData = json_decode($transaction->response_data, true);
                        $payableValue=0;

        if(isset($responseData['statuscode']) && $responseData['statuscode'] == 'TXN')
        {
            $payableValue = (float)($responseData['data']['txnValue'] ?? 0);
            $DMTvalueAll += $payableValue;
          
        }
    }

    $valueAll=0;
            // Fetch data from 'cash_withdrawals'
    $cashWithdrawals = DB::table('cash_withdrawals')->get();
    foreach ($cashWithdrawals as $withdrawal) {
        $responseData = json_decode($withdrawal->response_data, true);
        $payableValue=0;

        if(isset($responseData['statuscode']) && $responseData['statuscode'] == 'TXN')
        {
            $payableValue = (float)($responseData['data']['transactionValue'] ?? 0);
            $valueAll += $payableValue;
        }
}
 

@endphp
@section('content')
<style>
    /* Services Icon Styling */
    .services-icon {
        width: 40%;
        transition: transform 0.3s ease-in-out;
    }
    .services-icon:hover {
        transform: scale(1.1);
    }

    /* Card Styling */
    .card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: box-shadow 0.3s ease-in-out, transform 0.3s ease-in-out;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 15px rgba(0, 0, 0, 0.2);
    }

    .card-body {
        padding: 1.5rem;
    }

    /* Card Title */
    .card-title {
        font-size: 1.1rem;
        margin-top: 0.75rem;
        font-weight: bold;
        text-transform: uppercase;
    }

    /* Card Text */
    .card-text {
        font-size: 0.9rem;
        color: #555;
    }
</style>

<div class="container mt-4">
    <div class="row">
        <!-- Left Section for Service Cards -->
        <div class="col-lg-12">
            <div class="row">
                <h2>Wallet Amount ₹ {{session('adminBalance')}}</h2>
                <!-- First Card Row -->
                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <a href="{{route('aepsReport')}}">
                                <img class="services-icon" src="{{ asset('assets/img/icons/AEPS.png') }}" alt="AEPS">
                                <h5 class="card-title">AEPS</h5>
                                <p class="card-text">₹ {{$valueAll}}</p>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <a href="{{route('dmt1Report')}}">
                                <img class="services-icon" src="{{ asset('assets/img/icons/personal_loan.png') }}" alt="DMT">
                                <h5 class="card-title">DMT</h5>
                                <p class="card-text">₹ {{$DMTvalueAll}}</p>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <a href="{{route('dmt1Report')}}">
                                <img class="services-icon" src="{{ asset('assets/img/icons/wallet_to_wallet.png') }}" alt="Wallet Enquiry">
                                <h5 class="card-title">Wallet Enquiry</h5>
                                <p class="card-text">₹</p>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <a href="{{route('dmt1Report')}}">
                                <img class="services-icon" src="{{ asset('assets/img/icons/mobile_recharge.png') }}" alt="Wallet Enquiry">
                                <h5 class="card-title">BBPS</h5>
                                <p class="card-text">₹</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <h4 class="text-center">Users</h4>
         <!-- First Card Row -->
         <div class="col-md-6 col-lg-3 mb-4">
            <div class="card">
                <div class="card-body text-center">
                    <a href="#">
                        <h5 class="card-title">Distributors</h5>
                        <p class="card-text">₹ {{$amtDistributor}} | {{$distibutor}}</p>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card">
                <div class="card-body text-center">
                    <a href="#">
                        <h5 class="card-title">Retailers</h5>
                        <p class="card-text">₹ {{$amtRetailer}} | {{$retailer}}</p>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card">
                <div class="card-body text-center">
                    <a href="#">
                        <h5 class="card-title">Users</h5>
                        <p class="card-text">₹ 0 | 0</p>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card">
                <div class="card-body text-center">
                    <a href="#">
                     
                        <h5 class="card-title">Total</h5>
                        <p class="card-text">₹ {{$userTotalAmt}} | {{$userTotal}}</p>
                    </a>
                </div>
            </div>
        </div>

        <h4 class="text-center">Today Payment Request</h4>
            <!-- First Card Row -->
            <div class="col-md-6 col-lg-3 mb-4">
            <div class="card">
                <div class="card-body text-center">
                    <a href="#">
                        
                        <h5 class="card-title">Accepted</h5>
                        <p class="card-text">₹ {{$acceptAmt}} | {{$acceptCnt}}</p>
                    </a>
                </div>
            </div>
            </div>

            <div class="col-md-6 col-lg-3 mb-4">
            <div class="card">
                <div class="card-body text-center">
                    <a href="#">
                        
                        <h5 class="card-title">Panding</h5>
                        <p class="card-text">₹ {{$pendingAmt}} | {{$pendingCnt}} </p>
                    </a>
                </div>
            </div>
            </div>

            <div class="col-md-6 col-lg-3 mb-4">
            <div class="card">
                <div class="card-body text-center text-danger">
                    <a href="#">
                        
                        <h5 class="card-title text-danger">Rejected</h5>
                        <p class="card-text">₹ {{$rejectAmt}} | {{$rejectCnt}} </p>
                    </a>
                </div>
            </div>
            </div>

            <div class="col-md-6 col-lg-3 mb-4">
            <div class="card">
                <div class="card-body text-center">
                    <a href="#">
                        
                        <h5 class="card-title">Total</h5>
                        <p class="card-text">₹ {{$payAmtTotal}} | {{$payCntTotal}} </p>
                    </a>
                </div>
            </div>
        </div>
    </div>
    </div>

        </div>
        
        </div>
    </div>
</div>

@endsection
