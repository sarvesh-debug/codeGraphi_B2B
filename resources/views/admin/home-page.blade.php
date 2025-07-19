@extends('admin/include.layout')  
@php
    $distibutor=\App\Models\CustomerModel::where('role', 'distibuter')->count();
    $sd=\App\Models\CustomerModel::where('role', 'sd')->count();
    $retailer=\App\Models\CustomerModel::where('role', 'Retailer')->count();
    $userTotal=$retailer+$distibutor;
    $amtDistributor=\App\Models\CustomerModel::where('role', 'distibuter')->sum('balance');
    $amtSd=\App\Models\CustomerModel::where('role', 'sd')->sum('balance');
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
    $countDMT=0;
            // Fetch data from 'cash_withdrawals'
    $transactionsDMTInstantPay  = DB::table('transactions_dmt_instant_pay')->where('created_at',today())->get();
   
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
    $cashWithdrawals = DB::table('cash_withdrawals')->where('created_at',today())->get();
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
 //BBPS
    $bbpsvalueAll=0;
    $countbbpa=0;
            // Fetch data from 'cash_withdrawals'
    $transactionsBBPSInstantPay  = DB::table('utility_payments')->where('created_at',today())->get();
   
    foreach ($transactionsBBPSInstantPay  as $transaction)  {
        $responseData = json_decode($transaction->response_body, true);
                        $payableValue=0;

        if(!isset($responseData['respose']['data']['txnValue']) || !in_array($responseData['statuscode'], ['TXN', 'TUP']))
        {
            
            $payableValue = (float)($responseData['respose']['data']['txnValue'] ?? 0);
            $bbpsvalueAll += $payableValue;
            $countbbpa +=1;
          
        }
    }

    //payout
    $tpayout=DB::table('cgpayout')->where('status','CREDITED')->where('created_at',today())->sum('amount');

 

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
        color: white;
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
        color: rgb(15, 3, 3);
    }
    .fas
    {
        color: black;
        font-size: 20px;
    }
    

    /* Gradient Backgrounds */
    .gradient-1 { background: linear-gradient(135deg, #ff9a9e, #fad0c4); }
    .gradient-2 { background: linear-gradient(135deg, #a18cd1, #fbc2eb); }
    .gradient-3 { background: linear-gradient(135deg, #fad0c4, #ffd1ff); }
    .gradient-4 { background: linear-gradient(135deg, #ffecd2, #fcb69f); }
    .gradient-5 { background: linear-gradient(135deg, #a1c4fd, #c2e9fb); }
    .gradient-6 { background: linear-gradient(135deg, #d4fc79, #96e6a1); }
    .gradient-7 { background: linear-gradient(135deg, #84fab0, #8fd3f4); }
    .gradient-8 { background: linear-gradient(135deg, #ff9a9e, #fecfef); }
    .gradient-9 { background: linear-gradient(135deg, #fbc2eb, #a6c1ee); }
    .gradient-10 { background: linear-gradient(135deg, #fccb90, #d57eeb); }
    .gradient-11 { background: linear-gradient(135deg, #ff9a9e, #fecfef); }
    .gradient-12 { background: linear-gradient(135deg, #a1c4fd, #c2e9fb); }
</style>

<div class="container mt-4">
    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                {{-- <div class="col-md-6 col-lg-3 mb-4">
                    <div class="card gradient-1">
                        <div class="card-body text-center">
                            <a href="{{route('aepsReport')}}">
                                <i class="fas fa-fingerprint services-icon"></i>
                                <h5 class="card-title">AEPS</h5>
                                <p class="card-text">₹ {{$valueAll}} | {{$countAEPS}}</p>
                            </a>
                        </div>
                    </div>
                </div> --}}

                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="card gradient-1">
                        <div class="card-body">
                            <a href="{{ route('aepsReport') }}" class="d-flex align-items-center">
                                <i class="fas fa-fingerprint services-icon me-3 fa-2x"></i> <!-- icon on left -->
                                <div>
                                    <h5 class="card-title mb-1">AEPS</h5>
                                    <p class="card-text mb-0">₹ {{$valueAll}} | {{$countAEPS}}</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>


                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="card gradient-2">
                        <div class="card-body text-center">
                            <a href="{{route('dmt1Report')}}" class="d-flex align-items-center">
                                <i class="fas fa-exchange-alt services-icon"></i>
                                <div>
                                <h5 class="card-title mb-1">DMT</h5>
                                <p class="card-text mb-0">₹ {{$DMTvalueAll}} | {{$countDMT}}</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="card gradient-3">
                        <div class="card-body text-center">
                            <a href="{{route('bbpsReport')}}"  class="d-flex align-items-center">
                                <i class="fas fa-bolt services-icon"></i>
                                <div>
                                    <h5 class="card-title mb-1">BBPS</h5>
                                    <p class="card-text mb-0">₹ {{$bbpsvalueAll}} | {{$countbbpa}} </p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                 <div class="col-md-6 col-lg-3 mb-4">
                    <div class="card gradient-3">
                        <div class="card-body text-center">
                            <a href="{{route('payoutReport')}}"  class="d-flex align-items-center">
                                <i class="fas fa-wallet services-icon"></i>
                                <div>
                                    <h5 class="card-title mb-1">Payout</h5>
                                    <p class="card-text mb-0">₹ {{$tpayout}}</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3 mb-4">
                    <div class="card gradient-4">
                        <div class="card-body text-center">
                            <a href="{{route('dmt1Report')}}" class="d-flex align-items-center">
                                <i class="fas fa-wallet services-icon"></i>
                                <div>
                                    <h5 class="card-title mb-1">Total</h5>
                                    <p class="card-text mb-0">₹ {{$DMTvalueAll + $valueAll}} | {{$countAEPS + $countDMT}}</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <h4 class="text-center">Users 
        </h4>

<div class="col-md-6 col-lg-3 mb-4">
            <div class="card gradient-5">
                <div class="card-body text-center">
                    <a href="#" class="d-flex align-items-center">
                        <i class="fas fa-user-tie services-icon"></i>
                        <div>
                            <h5 class="card-title mb-1">S.Distributors</h5>
                            <p class="card-text mb-0">₹ {{$amtSd}} | {{$sd}}</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card gradient-5">
                <div class="card-body text-center">
                    <a href="#" class="d-flex align-items-center">
                        <i class="fas fa-user-tie services-icon"></i>
                        <div>
                            <h5 class="card-title mb-1">Distributors</h5>
                            <p class="card-text mb-0">₹ {{$amtDistributor}} | {{$distibutor}}</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card gradient-6">
                <div class="card-body text-center">
                    <a href="#" class="d-flex align-items-center">
                        <i class="fas fa-users services-icon"></i>
                        <div>
                            <h5 class="card-title mb-1">Retailers</h5>
                            <p class="card-text mb-0">₹ {{$amtRetailer}} | {{$retailer}}</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card gradient-8">
                <div class="card-body text-center">
                    <a href="#"  class="d-flex align-items-center">
                        <i class="fas fa-chart-bar services-icon"></i>
                        <div>
                            <h5 class="card-title mb-1">Total</h5>
                            <p class="card-text mb-0">₹ {{$userTotalAmt}} | {{$userTotal}}</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <h4 class="text-center">Today Payment Request</h4>

        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card gradient-9">
                <div class="card-body text-center">
                    <a href="#" class="d-flex align-items-center">
                        <i class="fas fa-check-circle services-icon"></i>
                        <div>
                            <h5 class="card-title mb-1">Accepted</h5>
                            <p class="card-text mb-0">₹ {{$acceptAmt}} | {{$acceptCnt}}</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card gradient-10">
                <div class="card-body text-center">
                    <a href="#" class="d-flex align-items-center">
                        <i class="fas fa-hourglass-half services-icon"></i>
                        <div>
                            <h5 class="card-title mb-1">Pending</h5>
                            <p class="card-text mb-0">₹ {{$pendingAmt}} | {{$pendingCnt}}</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card gradient-11">
                <div class="card-body text-center">
                    <a href="#" class="d-flex align-items-center">
                        <i class="fas fa-times-circle services-icon"></i>
                        <div>
                            <h5 class="card-title mb-1">Rejected</h5>
                            <p class="card-text mb-0">₹ {{$rejectAmt}} | {{$rejectCnt}}</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card gradient-12">
                <div class="card-body text-center">
                    <a href="#" class="d-flex align-items-center">
                        <i class="fas fa-money-check services-icon"></i>
                        <div>
                            <h5 class="card-title mb-1">Total</h5>
                            <p class="card-text mb-0">₹ {{$payAmtTotal}} | {{$payCntTotal}}</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

@endsection