{{-- In any Blade view --}}
@php
    $customer = session('customer');
    $outlet=session('outlet');
    $role=session('role');
@endphp

<!DOCTYPE html>
<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../assets/"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Dashboard - Analytics</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/codegraphi_favcon.jpeg') }}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
	  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
      .nav-item span {
        margin-right: 150px; /* Adjust the value as needed */
        font-size: 16px
    }
    
    
    
    
    @media (max-width: 600px) {
      .nav-item span {
        /* margin-right: 1px; Adjust the value as needed */
        margin-left: 1px;
        font-size: 2px;
    }
    .add_fund{
      font-size: 3px;
      display: flex;
    
      /* font-size: large; */
      font-weight:300;
      /* background-color: rgb(33, 150, 39); */
      /* padding: 4px; */
      color: rgb(32, 170, 55);
      border-radius: 2px;
    }
    .bal{
      font-size:3px;
      font-weight:300;
      /* background-color: rgb(33, 150, 39); */
      /* padding: 4px; */
      color: rgb(0, 0, 0);
      /* border-radius: 5px; */
      /* margin-right: 2px; */
    }
    
    .role{
      font-size:3px;
      /* font-weight:200; */
      color: black;
      /* margin-right: 1px; */
    }
    .rup{
      font-size:small;
      font-weight:300;
      color: black;
      margin-right: 2px;
    }
    
    .bx {
      vertical-align: middle;
      /* font-size: 1.15rem; */
      font-size: 5px;
      /* line-height: 1; */
    }
    .verify{
      font-size: small;
      margin-left: 1px;
    }
    
    
    }
    
    
    
    
    @media (max-width: 876px) {
     .layout-navbar.navbar-detached {
     width: calc(100% - (1.625rem * 2));
     margin: 0.75rem auto 0;
     border-radius: 0.375rem;
     padding: 0 0.5rem;
     }
      
      .nav-item span {
        margin-right: 10px; /* Adjust the value as needed */
        font-size: 8px
    }
    .add_fund{
      font-size: small;
    
      /* font-size: large; */
      font-weight:300;
      /* background-color: rgb(33, 150, 39); */
      padding: 4px;
      /* color: rgb(13, 141, 35); */
      border-radius: 5px;
    }
    .bal{
      font-size:small;
      font-weight:300;
      /* background-color: rgb(33, 150, 39); */
      /* padding: 4px; */
      color: rgb(0, 0, 0);
      /* border-radius: 5px; */
      /* margin-right: 2px; */
    }
    .icon{
      font-size:small;
      font-weight:300;
      color: black;
      /* margin-right: 2px; */
    }
    .role{
      font-size:small;
      font-weight:300;
      color: black;
      /* margin-right: 2px; */
    }
    .rup{
      font-size:small;
      font-weight:300;
      color: black;
      margin-left: 2px;
    }
    
    }
    
    
    
    
    
    @media (min-width: 876px) {
     .layout-navbar.navbar-detached {
     width: calc(100% - (1.625rem * 2));
     margin: 0.75rem auto 0;
     border-radius: 0.375rem;
     padding: 0 1.7rem;
    }
    .add_fund{
      font-size: large;
      font-weight:500;
      background-color: rgb(53, 184, 60);
      padding: 5px;
      padding-left: 8px;
      padding-right: 8px;
      color: white;
      border-radius: 8px;
      margin-right: 5px;
    }

    .add_fund:hover{
  font-weight:500;
  background-color: rgb(53, 184, 60);
  padding: 6px;
  padding-left: 8px;
  padding-right: 8px;
  color: rgb(255, 255, 255);
  border-radius: 8px;
  margin-right: 5px;
  }

    .bal{
      font-size: large;
      font-weight:600;
      /* background-color: rgb(33, 150, 39); */
      /* padding: 4px; */
      color: rgb(0, 0, 0);
      /* border-radius: 5px; */
      margin-right: 5px;
    }
    .icon{
      font-size:xx-large;
      font-weight:bold;
      color: black;
      margin-right: 5px;
    }
    .role{
      font-size:large;
      font-weight:bold;
      color: black;
      margin-left: 20px;
    }
    .rup{
      font-size:large;
      font-weight:bold;
      color: black;
      margin-right: 5px;
    }
    .verify{
      font-size: large;
      margin-left: 10rem;
    }
    }
    
    
    
    
    .menu-link
    {
      font-weight: bold;
      color: black !important;
    }


</style>
    <!-- Add Custom CSS -->
    @yield('custom-css')

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css') }}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/theme-default.css') }}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}" />

    <!-- Helpers -->
    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>

    <!-- Config -->
    <script src="{{ asset('assets/js/config.js') }}"></script>
  </head>

  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
     <!-- Menu -->
     <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
      <div class="app-brand demo">
        <a href="{{route('customer/dashboard')}}" class="app-brand-link">
          <span class="app-brand-text demo menu-text fw-bolder ms-2">
            <img src="{{ asset('assets/img/icons/codegraphi-logo.png') }}" width="200px" height=""  alt="CodeGraphi  logo">
          </span>
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
          <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
      </div>
      <div class="menu-inner-shadow"></div>
      <ul class="menu-inner py-1">
        
        <li class="menu-item">
          <a href="{{route('customer/dashboard')}}" class="menu-link d-flex align-items-center gap-2">
              <i class="fa-solid fa-house fs-4 fs-md-2 fs-lg-1"></i>
              <div data-i18n="Analytics">Home</div>
          </a>
      </li>
      
      
      

       
<!-- Example of submenu -->
@if(!$customer->pin > 0 && $role==="Retailer")
<li class="menu-item">
<a href="javascript:void(0);" class="menu-link menu-toggle">
<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAAAXNSR0IArs4c6QAAAudJREFUSEu11lmo1WUUBfCfgSEVGNmcJaGV2kiUlUUUgdoAGaRZEQhCVL5VWpBFYYUG9WhQYD5UWFAQFEE09yChFVY2pzaaNIGVFYr2LdlHjqfjwftwv5f7v+d8e1hrr73+Z4RhPiOGOb9BBU7GfFyJo7sa+QPP4V28hi8HNdmvwEEt4WO4dh/QbceDuB/b+t3vLXAA3sdJ+LaCX8XXXcEH43zchGntzv74EDOxobdIb4FHK3A9LsAmjMEsHIlf8RXewD84Cs/j3Bb3E86smN11uguMLz7/rYuf4g7cjQN7OvuhGnmRXXN8CLfjI0xtz3927ncXCI934XHciOvwVF0MbUl2DM7DhEr0XlfhZwvpk43SG/oVCOyLcAVewseIkm7DIz0IjqsZHYanMbuh/RtrcSgmY3NiuhF0Ep6I77EVv+Bw7KwCt2IFfqv/gzBI38QlOAef4fd+CD7BpEbLCfir0fRjFRmNyHFGS/ByS/hFCeBnjGuI11TX87B8kIoSnCSXVaJvWkCo6FAUtOH56tbtO0XnjiaM69tMwnsUdzwikr4qWlBqeLgUETrynICzSyFR0+pCem+j+D7sV9yfgv+h6J5BdB5aMqzTEQQvNEu4tBJE4+n41GYfH9Rc0nHmNbfR9QRWlbr6IsiHUUQsIot2Vs3gbUxpye/B4opc1lRyM5a2hbsTsZeoJk4Qkez2p95NPgTRdpYs0svCHNv0vQ6j2taeVioZ2+j4rjY7uxEaO83dgjjCrrM3s4uKIs0LEQTZ6CUN/iuNhukVm+Fmc+NDOfGmJH6mNTFnUIHOdysbkmuQ4YWyjbUTkXK03nsmFvI95jDofRATu6q2OFIN3wvbTizCA+W42fAsZMwwJ0Pfw1EHFbi8/CeyzJAvbpS93v6+VTtwRqnpc6T7vmdQgSPKgmMX8ZwMM5LMeyIbHM/JNsc2YulDLpAXSdQRmxhZEszwtyD20fk+b7I8D7nA3mKG9Pmw/6r4D/JUohlC4HcUAAAAAElFTkSuQmCC"/>
<div data-i18n="Layouts">KYC</div>
</a>
<ul class="menu-sub">

@if ($customer->fkyc === 1)
<li class="menu-item">
    <a href="{{ route('user/kyc-form') }}" class="menu-link">
        <div data-i18n="Without menu">Apply KYC</div>
    </a>
</li>
@endif




<li class="menu-item">
  <a href="{{ route('kyc.details') }}" class="menu-link">
      <div data-i18n="Without navbar">KYC Details</div>
  </a>
</li>

</ul>
</li>
@endif
@if($role==="distibuter" || $role=="rm" || $role=='sd')
<li class="menu-item">
  <a href="javascript:void(0);" class="menu-link menu-toggle d-flex align-items-center gap-1">
    <i class="fa-solid fa-user-plus fs-4 fs-md-2 fs-lg-1"></i>
    <div data-i18n="Layouts">OnBoard</div>
</a>

<ul class="menu-sub">

<li class="menu-item">
    <a href="{{route('add-new')}}" class="menu-link">
        <div data-i18n="Without menu">Onboard Member</div>
    </a>
</li>


<li class="menu-item">
  <a href="{{route('list.new')}}" class="menu-link">
      <div data-i18n="Without navbar">Member List</div>
  </a>
</li>


<li class="menu-item">
<a href="{{route('disCommission.list')}}" class="menu-link">
    <div data-i18n="Without navbar">Commission</div>
</a>
</li>
   @if (trim(strtolower($role)) !== 'rm')
<li class="menu-item">
<a href="{{route('packages.indexRT')}}" class="menu-link">
    <div data-i18n="Without navbar">Set Commission</div>
</a>
</li>
@endif
</ul>
</li>
@endif
        <!-- More menu items -->
        {{-- <li class="menu-item">
          <a href="{{route('/user/wallet/index')}}" class="menu-link d-flex align-items-center gap-2">
              <i class="fa-solid fa-wallet fs-5 fs-md-2 fs-lg-1"></i>
              <div data-i18n="Analytics">CodeGraphi  Collect</div>
          </a>
      </li> --}}
      
       

        <li class="menu-header small text-uppercase">
          <span class="menu-header-text">Banking</span>
        </li>
        {{-- @if(!$customer->pin <= 0) --}}
<!-- Example of submenu -->

@if (session('role')=='Retailer')
@if($customer->pin > 0)
        @if($customer->aeps == 1)
        <li class="menu-item">
          <a href="{{route('checkOutletLoginStatus')}}" class="menu-link d-flex align-items-center gap-2">
              <i class="fa-solid fa-fingerprint fs-5 fs-md-2 fs-lg-1"></i>
              <div data-i18n="Analytics">AePS</div>
          </a>
      </li>
       {{-- <li class="menu-item">
          <a href="{{route('aeps.sattlementForm')}}" class="menu-link d-flex align-items-center gap-2">
              <i class="fa-solid fa-fingerprint fs-5 fs-md-2 fs-lg-1"></i>
              <div data-i18n="Analytics">AePS Sattlement</div>
          </a>
      </li> --}}
       <li class="menu-item">
          <a href="{{route('walletTxnForm')}}" class="menu-link d-flex align-items-center gap-2">
              <i class="fa-solid fa-fingerprint fs-5 fs-md-2 fs-lg-1"></i>
              <div data-i18n="Analytics">AePS Wallet Transfer</div>
          </a>
      </li>
      
@else
<li class="menu-item">
  <a href="" class="menu-link d-flex align-items-center gap-2">
      <i class="fa-solid fa-fingerprint fs-5 fs-md-2 fs-lg-1"></i>
      <div data-i18n="Analytics">AePS</div>
  </a>
</li>

@endif

@if($customer->dmt == 1 && $customer->balance >0 && $customer->status ==="active" && $customer->pin >0)
<li class="menu-item">
  <a href="{{route('dmt.remitter-profile')}}" class="menu-link d-flex align-items-center gap-2">
      <i class="fa-solid fa-right-left fs-5 fs-md-2 fs-lg-1"></i>
      <div data-i18n="Analytics">DMT</div>
  </a>
</li>

<li class="menu-item">
  <a href="{{route('1fetch.form')}}" class="menu-link d-flex align-items-center gap-2">
      <i class="fa-solid fa-right-left fs-5 fs-md-2 fs-lg-1"></i>
      <div data-i18n="Analytics">DMT S1</div>
  </a>
</li>

@else
<li class="menu-item">
  <a href="" class="menu-link d-flex align-items-center gap-2">
      <i class="fa-solid fa-right-left fs-5 fs-md-2 fs-lg-1"></i>
      <div data-i18n="Analytics">DMT</div>
  </a>
</li>

@endif
@if($customer->cc_bill_payment == 1 && $customer->balance >0 && $customer->status ==="active" && $customer->pin >0)
<li class="menu-item">
<a href="{{route('getcategory')}}" class="menu-link  gap-2">
{{-- <img src="https://cdn-icons-png.flaticon.com/128/1981/1981861.png" alt="Bill Payments Icon" style="width: 20px; height: 20px; margin-right: 10px;"> --}}
<i class="fa-solid fa-credit-card fs-5 fs-md-2 fs-lg-1"></i>
<div data-i18n="Analytics">Bill Payments</div>
</a>
</li>
@else
<li class="menu-item">
<a href="{{route('remProfile')}}" class="menu-link  gap-2">
<i class="fa-solid fa-credit-card fs-5 fs-md-2 fs-lg-1"></i>
<div data-i18n="Analytics">Payment1</div>
</a>
</li>
@endif

@else
<li class="menu-item">
<a href="#" class="menu-link">
<img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQuEPF5Nys2Qd4cyU9zxWKOG39KyH0iF59lJw&s" alt="AePS Icon" style="width: 20px; height: 20px; margin-right: 10px;">
<div data-i18n="Analytics">AePS</div>
</a>
</li>

<li class="menu-item">
<a href="#" class="menu-link">
<img src="https://cdn-icons-png.flaticon.com/128/846/846980.png" alt="DMT Icon" style="width: 20px; height: 20px; margin-right: 10px;">
<div data-i18n="Analytics">DMT</div>
</a>
</li>

<li class="menu-item">
<a href="#" class="menu-link">
<img src="https://cdn-icons-png.flaticon.com/128/1981/1981861.png" alt="Bill Payments Icon" style="width: 20px; height: 20px; margin-right: 10px;">
<div data-i18n="Analytics">Bill Payments</div>
</a>
</li>
@endif

</li>

<li class="menu-item">
    <a href="{{ route('cms.admin.transactions') }}" class="menu-link gap-2 align-items-center">
        <img src="https://cdn-icons-png.flaticon.com/512/3135/3135706.png" alt="CMS Icon" width="24" height="24">
        <div data-i18n="Analytics">CMS</div>
    </a>
</li>

<li class="menu-item">
    <a href="{{ route('leads.index') }}" class="menu-link gap-2 align-items-center">
        <img src="https://cdn-icons-png.flaticon.com/512/3050/3050525.png" alt="Credit Card Icon" width="24" height="24">
        <div data-i18n="Analytics">Credit Card Apply</div>
    </a>
</li>


      @endif
      <li class="menu-item">
        <a href="{{route('commission.get')}}" class="menu-link gap-1">
          {{-- <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAAAXNSR0IArs4c6QAAAR1JREFUSEvt1btKBEEQheFvETUTczHwBcRUBC+BGAhmPoWBoKYarKGgRr6HKAYiKBiZ+gCCCBuLkYmXbRlh6O3ZadZdTLbD4lT93aemahoGfBoDrm8IqHW4bNEtlmsz8gR3WAnSMuArLzdb9VO7V8AHbrDWBfcnwC6O0cR+BSQbsFS8NPgazgU2MIlHTOcCgm4C51GzFzFWWPKMObziEutR8Wts4u03nhq0GTwlbhV8X8AD9nCU0EyhVY6nAON4TyTv4ATzuMdIQhNin3WA7ba/p1Fyyve4NyFlC2dVgKo5eMFswvcAGC16k+pz9ld00LbjsIvvVaOQDQgFroqhSvneF0D2figJO17Qz2UX1shqvIt6uWVtzvCP9v8WfQPMWC8Z5nK9/gAAAABJRU5ErkJggg=="/> --}}
          <i class="fa-solid fa-hand-holding-dollar  fs-4 fs-md-2 fs-lg-1"></i>
          <div data-i18n="Analytics">Commission Plans</div>
        </a>
      </li> 
      <li class="menu-item">
        <a href="{{route('/user/fund-transfer/bank-account')}}" class="menu-link d-flex align-items-center gap-2">
            <i class="fas fa-money-bill-transfer fs-5 fs-md-2 fs-lg-1"></i>
            <div data-i18n="Analytics">Fund</div>
        </a>
    </li>
     <li class="menu-item">
        <a href="{{route('historyUPI')}}" class="menu-link d-flex align-items-center gap-2">
            <i class="fas fa-money-bill-transfer fs-5 fs-md-2 fs-lg-1"></i>
            <div data-i18n="Analytics">Fund History</div>
        </a>
    </li>
     @if($role==="Retailer")
    <li class="menu-header small text-uppercase">
        <span class="menu-header-text">BBPS</span>
    </li>

    @if($customer->dmt == 1 && $customer->balance > 0 && $customer->status === "active" && $customer->pin > 0)
        <li class="menu-item">
            <a href="{{ route('mobileRecharge') }}" class="menu-link d-flex align-items-center gap-2">
                <i class="fas fa-mobile-alt fs-5"></i>
                <div data-i18n="Analytics">Mobile Recharge</div>
            </a>
        </li>

        <li class="menu-item">
            <a href="{{ route('mobileBill') }}" class="menu-link d-flex align-items-center gap-2">
                <i class="fas fa-file-invoice fs-5"></i>
                <div data-i18n="Analytics">Post Paid</div>
            </a>
        </li>

        <li class="menu-item">
            <a href="{{ route('electricityBill') }}" class="menu-link d-flex align-items-center gap-2">
                <i class="fas fa-bolt fs-5"></i>
                <div data-i18n="Analytics">Electricity</div>
            </a>
        </li>

        <li class="menu-item">
            <a href="{{ route('gasRecharge') }}" class="menu-link d-flex align-items-center gap-2">
                <i class="fas fa-gas-pump fs-5"></i>
                <div data-i18n="Analytics">Gas Bill</div>
            </a>
        </li>

        <li class="menu-item">
            <a href="{{ route('creditCardRecharge') }}" class="menu-link d-flex align-items-center gap-2">
                <i class="fas fa-credit-card fs-5"></i>
                <div data-i18n="Analytics">Credit Card</div>
            </a>
        </li>

        <li class="menu-item">
            <a href="{{ route('dthRecharge') }}" class="menu-link d-flex align-items-center gap-2">
                <i class="fas fa-satellite-dish fs-5"></i>
                <div data-i18n="Analytics">DTH</div>
            </a>
        </li>

        <li class="menu-item">
            <a href="{{ route('insuranceRecharge') }}" class="menu-link d-flex align-items-center gap-2">
                <i class="fas fa-shield-alt fs-5"></i>
                <div data-i18n="Analytics">Insurance</div>
            </a>
        </li>

        <li class="menu-item">
            <a href="{{ route('getBroadbandISP') }}" class="menu-link d-flex align-items-center gap-2">
                <i class="fas fa-wifi fs-5"></i>
                <div data-i18n="Analytics">Broadband</div>
            </a>
        </li>

        <li class="menu-item">
            <a href="{{ route('waterBill') }}" class="menu-link d-flex align-items-center gap-2">
                <i class="fas fa-tint fs-5"></i>
                <div data-i18n="Analytics">Water</div>
            </a>
        </li>

        <li class="menu-item">
            <a href="{{ route('landlineBill') }}" class="menu-link d-flex align-items-center gap-2">
                <i class="fas fa-phone fs-5"></i>
                <div data-i18n="Analytics">LandLine</div>
            </a>
        </li>

        <li class="menu-item">
            <a href="{{ route('fastTagRecharge') }}" class="menu-link d-flex align-items-center gap-2">
                <i class="fas fa-road fs-5"></i>
                <div data-i18n="Analytics">Fast Tag</div>
            </a>
        </li>
    @endif
@endif


      <li class="menu-header small text-uppercase">
        <span class="menu-header-text">Report</span>
      </li>
      @if($role==="Retailer")
      <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle gap-2">
          {{-- <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAAAXNSR0IArs4c6QAAAMhJREFUSEvt1DEOAUEUxvGfRK0kkWi4gFs4iUolUZA4gwM4CIlb0OioFFoXIJssZjc2YseqTDeT+d7/vfe9mZqKV63i+H4KSGBzjNAqUdkeE6xCbVjBAuMSgUPJAb0iwBlNDLApAbqmmkzbw839QuWAEslnJBkvXlVwQSOS8vDiFSB2dDNe/AGJVfnx/HqL/oCPX8TXPchnUAg4oY0+th/n/RQUApYYRgQOpUd0k4PwJdcxSyGdCNAOU6zzgIiYxdLYj+1tUpUDbgOALxmvJD5dAAAAAElFTkSuQmCC"/> --}}
          <i class="fa-solid fa-clipboard-list fs-4 fs-md-2 fs-lg-1"></i>
          <div data-i18n="Layouts">Report</div>
        </a>
        

        <ul class="menu-sub">
          <li class="menu-item">
            <a href="{{route('transaction.history')}}" class="menu-link">
              <div data-i18n="Without menu">DMT</div>
            </a>
          </li>
          
          <li class="menu-item">
            <a href="{{route('aeps.history')}}" class="menu-link">
              <div data-i18n="Without navbar">Aeps</div>
            </a>
          </li>
            {{-- <li class="menu-item">
            <a href="{{route('wallet.aepsTxn')}}" class="menu-link">
              <div data-i18n="Without navbar">Aeps To Wallet</div>
            </a>
          </li> --}}
          <li class="menu-item">
            <a href="{{route('nifiReport')}}" class="menu-link">
              <div data-i18n="Without navbar">Payment1</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="{{ route('bbpsAll.history', ['payment_remarks' => 'C00']) }}" class="menu-link">
  
              <div data-i18n="Without navbar">Recharge</div>
            </a>
          </li>
           <li class="menu-item">
            <a href="{{ route('bbpsAll.history', ['payment_remarks' => 'C01']) }}" class="menu-link">
  
              <div data-i18n="Without navbar">PostRecharge</div>
            </a>
          </li>
           <li class="menu-item">
            <a href="{{ route('bbpsAll.history', ['payment_remarks' => 'C02']) }}" class="menu-link">
  
              <div data-i18n="Without navbar"> LandLine</div>
            </a>
          </li>
           <li class="menu-item">
            <a href="{{ route('bbpsAll.history', ['payment_remarks' => 'C03']) }}" class="menu-link">
  
              <div data-i18n="Without navbar">DTH</div>
            </a>
          </li>
           <li class="menu-item">
            <a href="{{ route('bbpsAll.history', ['payment_remarks' => 'C04']) }}" class="menu-link">
  
              <div data-i18n="Without navbar">Electricity</div>
            </a>
          </li>
           <li class="menu-item">
            <a href="{{ route('bbpsAll.history', ['payment_remarks' => 'C05']) }}" class="menu-link">
  
              <div data-i18n="Without navbar">Broadband</div>
            </a>
          </li>
           <li class="menu-item"> 
            <a href="{{ route('bbpsAll.history', ['payment_remarks' => 'C14']) }}" class="menu-link">
  
              <div data-i18n="Without navbar">Gas</div>
            </a>
          </li>
           <li class="menu-item"> 
            <a href="{{ route('bbpsAll.history', ['payment_remarks' => 'C08']) }}" class="menu-link">
  
              <div data-i18n="Without navbar"> Water</div>
            </a>
          </li>
           <li class="menu-item"> 
            <a href="{{ route('bbpsAll.history', ['payment_remarks' => 'C10']) }}" class="menu-link">
  
              <div data-i18n="Without navbar">FASTag Recharge</div>
            </a>
          </li>
           <li class="menu-item"> 
            <a href="{{ route('bbpsAll.history', ['payment_remarks' => 'C11']) }}" class="menu-link">
  
              <div data-i18n="Without navbar">Insurance</div>
            </a>
          </li>
<li class="menu-item"> 
            <a href="{{ route('bbpsAll.history', ['payment_remarks' => 'C15']) }}" class="menu-link">
  
              <div data-i18n="Without navbar">Credit Card</div>
            </a>
          </li>
          {{-- <li class="menu-item">
            <a href="{{route('laser.statement')}}" class="menu-link">
              <div data-i18n="Without navbar">Ledger</div>
            </a>
          </li> --}}
        </ul>
    
      </li>
          @endif
    
      <li class="menu-item">
        <a href="{{route('laser.statement')}}" class="menu-link gap-2">
          <i class="fa-solid fa-landmark fs-5 fs-md-2 fs-lg-1"></i>
          <div data-i18n="Analytics">All transaction</div>
        </a>
      </li> 
    
      
      <li class="menu-header small text-uppercase">
        <span class="menu-header-text">Support</span>
      </li>

      <li class="menu-item">
        <a href="{{route('get.profile')}}" class="menu-link gap-2">
    <i class="fa-solid fa-user fs-3 fs-md-2 fs-lg-1"></i>
          <div data-i18n="Analytics">Profile</div>
        </a>
      </li>
      <li class="menu-item">
        <a href="#" class="menu-link gap-2">
          <i class="fa-solid fa-headset"></i>
          <div data-i18n="Analytics">Support Ticket</div>
        </a>
      </li>
      </ul>
    </aside>
    <!-- /Menu -->

        <!-- Layout container -->
        <div class="layout-page">
        <!-- Navbar -->
        

        
<!-- Navbar -->
<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center fixed-top" id="layout-navbar">

  <div class="layout-menu-toggle navbar-nav align-items-xl-center me-1 d-xl-none">
    <a class="nav-item nav-link px-0" href="javascript:void(0)">
        <i class="bx bx-menu bx-sm"></i>
    </a>
</div>



  <div class="navbar-nav-right d-flex align-items-center" id="">
 

    
      <div class="d-flex justify-content-between align-items-center">

          <div class="d-flex align-items-center gap-2">
              <i class="bx bx-fingerprint bx-sm text-primary"></i>
              <span class="fw-bold text-dark">AePS₹</span>
              <span class="fw-bold text-dark" id="aepsWallet"></span>
              <script>
    setInterval(() => {
        fetch("{{ url('/get-aepsWallet') }}")
            .then(res => {
                console.log('Response status:', res.status);
                return res.json();
            })
            .then(data => {
                console.log('Fetched Balance:', data.aepsWallet);
                document.getElementById('aepsWallet').textContent = '₹' + data.aepsWallet;
            })
            .catch(error => {
                console.error('Error fetching balance:', error);
            });
    }, 500);
</script>


   
          </div>

       
    
          <div class="d-flex align-items-center gap-2"  style="margin-left: 50px" >
              <i class="bx bx-wallet bx-sm text-primary"></i>
              <span class="fw-bold text-dark">₹</span>
              <span class="fw-bold text-dark">{{ session('balance')+session('lockBalance') }}</span>
          </div>
    <!-- Add Fund Button -->
     <div class=" rounded "  style="margin-left: 15px">
       @if (trim(strtolower($role)) !== 'rm')
      <a href="{{route('/user/fund-transfer/bank-account')}}" class="add_fund whitespace-nowrap fw-bold fa fa-plus"></a>
       @endif
    </div>
          <!-- Account Section (Visible on Desktop) -->
          {{-- <div class="d-none d-md-flex flex-column flex-md-row ms-3">
              <span class="role btn d-inline-flex align-items-center px-3 lg:py-1 py-0 rounded-pill">
                  <span class="fw-bold">Account: </span>&nbsp;
              </span>
              <span class="d-block text-md-start text-center lg:mt-1 mt-0 mt-md-0">
                  @if (trim(strtolower($role)) === 'distibuter')
                      Distributor
                  @elseif(trim(strtolower($role)) === 'rm')
                  Relationship Manager
                   @elseif(trim(strtolower($role)) === 'sd')
                    Super Distributor
                      @else
                      Retailer
                  @endif
              </span>
          </div> --}}
      </div>
  
      <ul class="navbar-nav flex-row align-items-center float-end ms-auto gap-1">
        <span class="fw-bold d-none d-md-inline">Welcome, {{ $customer->name }} </span>
        <span class="fw-bold small d-inline d-md-none">Welcome, {{ $customer->name }} </span>
        
          <li class="nav-item navbar-dropdown dropdown-user dropdown">
              <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                  <div class="avatar">
                      <div class="position-relative d-inline-block">
                          <img src="{{ asset('assets/img/avatars/1.png') }}" alt="User Avatar" class="h-auto rounded-circle" />
                          @if (!$customer->pin > 0)
                              <i class="fa fa-times-circle text-white bg-danger position-absolute bottom-0 start-100 translate-middle-x"
                                  style="font-size: 1.3rem; padding: 1px; border-radius: 50%;"></i>
                          @else
                              <i class="fa fa-check-circle text-white bg-success position-absolute bottom-0 start-100 translate-middle-x"
                                  style="font-size: 1.3rem; padding: 1px; border-radius: 50%;"></i>
                          @endif
                      </div>
                  </div>
              </a>
              <ul class="dropdown-menu dropdown-menu-end">
                  <li>
                      <a class="dropdown-item" href="#">
                          <div class="d-flex">
                              <div class="flex-shrink-0 me-3">
                                  <div class="avatar avatar-online">
                                      <img src="{{ asset('assets/img/avatars/1.png') }}" alt="User Avatar" class="w-px-40 h-auto rounded-circle" />
                                  </div>
                              </div>
                              <div class="flex-grow-1">
                                  <span class="fw-semibold d-block">{{ $customer->name }}</span>
                                  <small class="text-muted" style="text-transform: capitalize">
                                    @if (trim(strtolower($role)) === 'distibuter')
                                        Distributor
                                    @else
                                        Retailer
                                    @endif
                                  </small>
                              </div>
                          </div>
                      </a>
                  </li>
                  {{-- <li><div class="dropdown-divider"></div></li> --}}

                  {{-- <!-- Account Section (Visible in Mobile Dropdown) -->
                  <li class="d-flex d-md-none">
                      <a class="dropdown-item" href="javascript:void(0);">
                          <div class="d-flex flex-row flex-md-row">
                              <span class="role btn d-inline-flex align-items-center px-3 lg:py-1 py-0 rounded-pill">
                                  <span class="fw-bold">Account: </span>&nbsp;
                              </span>
                              <span class="d-block text-md-start text-center lg:mt-1 mt-0 mt-md-0">
                                  @if (trim(strtolower($role)) === 'distributor')
                                      Distributor
                                  @else
                                      Retailer
                                  @endif
                              </span>
                          </div>
                      </a>
                  </li> --}}
                  <li><div class="dropdown-divider"></div></li>
                  <li>
                      <a class="dropdown-item" href="{{ route('get.profile') }}">
                          <i class="bx bx-power-off me-2"></i>
                          <span class="align-middle">Profile</span>
                      </a>
                  </li>
                  
                  <li>
                    <a class="dropdown-item" href="{{ route('remitter.certificate') }}">
                        <i class="bx bx-file me-2"></i>
                        <span class="align-middle">Certificate</span>
                    </a>
                </li>
                 <li>
                    <a class="dropdown-item" href="{{ route('change.ProfilePassword') }}">
                        <i class="bx bx-power-off me-2"></i>
                        <span class="align-middle">Change Password</span>
                    </a>
                   
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('coustomer.logout') }}">
                        <i class="bx bx-power-off me-2"></i>
                        <span class="align-middle">Logout</span>
                    </a>
                   
                </li>
              </ul>
          </li>
      </ul>
  </div>
</nav>
<!-- /Navbar -->

<style>
@media (max-width: 768px) { /* Target mobile screens */
    .layout-navbar {
        position: fixed !important;
        top: 0;
        left: 0;
        width: 100%;
        z-index: 1050;
        background-color: #fff; /* Ensure visibility */
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    }

    body {
        padding-top: 56px; /* Adjust based on navbar height */
        
    }
}

 body {
    padding-top: 80px;
  }

  #layout-navbar {
  z-index: 1050;
  position: fixed;
  top: 0;
  left: 250px; /* sidebar width */
  right: 0;
  width: calc(100% - 250px); /* subtract sidebar width */
}


</style> 
<script>
  window.addEventListener('DOMContentLoaded', () => {
    const navbar = document.getElementById('layout-navbar');
    const height = navbar.offsetHeight;
    document.body.style.paddingTop = height + 'px';
  });
</script>


<!-- /Navbar -->

 <!-- Main Content -->
      <main>
       @yield('content')
      </main>

       </div>
      <!-- /Layout page -->
      </div>

      <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- Modal -->
<div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="profileModalLabel" style="text-transform: capitalize">{{ $customer->role }} Profile</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Profile content -->
        <div class="text-center">
          <img src="{{ asset('assets/img/avatars/1.png') }}" alt="User Avatar" class="rounded-circle mb-3" width="100">
          <h5><b>Name:</b>{{ $customer->name }}</h5>
          <h5><b>ID:</b>{{ $customer->username }}</h5>
          <h6 class=""style="text-transform: capitalize">{{ $customer->role }}</h6>
          {{-- <p><b>Balance:</b>{{ session('balance') }}</p> --}}
          <p><b>Email:</b>{{ $customer->email }}</p>
          <p><b>Phone:</b>{{ $customer->phone }}</p>
          <p><b>Shop Name:</b>{{ $customer->owner }}</p>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="mpinModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title">Enter MPIN</h5>
          </div>
          <form id="mpinForm">
              <div class="modal-body text-center mb-2">
                  <p>Please enter your MPIN to continue.</p>
                  <div class="d-flex justify-content-center">
                      <input type="password" class="otp-input mx-2" maxlength="1" id="mpin1" required>
                      <input type="password" class="otp-input mx-2" maxlength="1" id="mpin2" required>
                      <input type="password" class="otp-input mx-2" maxlength="1" id="mpin3" required>
                      <input type="password" class="otp-input mx-2" maxlength="1" id="mpin4" required>
                  </div>
                  <div class="text-danger mt-2" id="mpinError" style="display:none;">Incorrect MPIN</div>
              </div>
          </form>
      </div>
  </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap JS -->
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> -->

<style>
    .otp-input {
        width: 45px;
        height: 50px;
        font-size: 24px;
        font-weight: bold;
        text-align: center;
        border: 3px solid #007bff;
        border-radius: 8px;
        outline: none;
        transition: all 0.2s ease-in-out;
    }

    .otp-input:focus {
        border-color: #ff5722;
        box-shadow: 0 0 8px rgba(255, 87, 34, 0.5);
    }
</style>

<script>
    $(document).ready(function () {
        let storedMpin = "{{ session('mpin') }}"; // Fetch MPIN from Laravel session
        let inactivityTime = 10 * 60 * 1000; // 10 minutes timeout
        let timeout;
        
        // Auto-focus and move to next field
        $(".otp-input").on("input", function () {
            if ($(this).val().length === 1) {
                $(this).next('.otp-input').focus();
            }
            checkAndSubmit();
        });

        // Move back on backspace
        $(".otp-input").on("keydown", function (e) {
            if (e.key === "Backspace" && $(this).val().length === 0) {
                $(this).prev('.otp-input').focus();
            }
        });

        // Auto-submit when 4 digits are entered
        function checkAndSubmit() {
            let enteredMpin = $('#mpin1').val() + $('#mpin2').val() + $('#mpin3').val() + $('#mpin4').val();
            if (enteredMpin.length === 4) {
                validateMpin(enteredMpin);
            }
        }

        function validateMpin(enteredMpin) {
            if (enteredMpin !== storedMpin) {
                $('#mpinError').text("Incorrect MPIN").show();
                $('.otp-input').val(''); // Clear input fields
                $('#mpin1').focus(); // Focus back on first input
            } else {
                $('#mpinError').hide();
                $('#mpinModal').modal('hide'); // Hide modal on correct MPIN
                sessionStorage.setItem("mpinLocked", "false"); // Unlock
                resetTimer(); // Restart inactivity timer
            }
        }

        // Lock the page if inactive
        function lockPage() {
            sessionStorage.setItem("mpinLocked", "true");
            $('#mpinModal').modal('show');
        }

        // Reset inactivity timer
        function resetTimer() {
            clearTimeout(timeout);
            timeout = setTimeout(lockPage, inactivityTime);
        }

        // Detect user activity to reset timer
        $(document).on("mousemove keypress click", function () {
            if (sessionStorage.getItem("mpinLocked") !== "true") {
                resetTimer();
            }
        });

        // Lock page if it was locked before
        if (sessionStorage.getItem("mpinLocked") === "true") {
            lockPage();
        } else {
            resetTimer();
        }
    });
</script>

<!-- Only include this script in production environment -->
{{-- @if (app()->environment('production')) --}}

    <!-- Script to disable right-click and certain keyboard shortcuts -->
    <script>
        // Disable right-click context menu
        document.addEventListener('contextmenu', function (e) {
            e.preventDefault(); // Prevent default right-click menu
        });

        // Disable specific key combinations used to open DevTools
        document.addEventListener('keydown', function (e) {
            // Block F12 key (usually opens Developer Tools)
            if (e.keyCode === 123) {
                e.preventDefault();
            }

            // Block Ctrl+Shift+I, Ctrl+Shift+J, Ctrl+Shift+C (Inspect, Console, etc.)
            if (e.ctrlKey && e.shiftKey && (e.key === 'I' || e.key === 'J' || e.key === 'C')) {
                e.preventDefault();
            }

            // Block Ctrl+U (View Page Source)
            if (e.ctrlKey && e.key === 'u') {
                e.preventDefault();
            }
        });
    </script>

{{-- @endif --}}


    <!-- /Layout wrapper -->
{{-- pin --}}

    <!-- Core JS -->
    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>

    <!-- Vendors JS -->
    <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>

    <!-- Main JS -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <!-- Page JS -->
    <script src="{{ asset('assets/js/dashboards-analytics.js') }}"></script>

    <!-- GitHub buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script src="{{asset('assets/js/datatables-simple-demo.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
  
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>


    @extends('user.navigationBar')

  </body>
</html>


