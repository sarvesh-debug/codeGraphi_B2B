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
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/icons/z-pay-fav.png') }}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
	  <link rel="stylesheet" href="{{ asset('css/style.css') }}">

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
            <img src="{{ asset('assets/img/icons/z-pay-logo.png') }}" width="200px" height=""  alt="z pay logo">
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
@if(!$customer->pin > 0)
<li class="menu-item">
<a href="javascript:void(0);" class="menu-link menu-toggle">
<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAAAXNSR0IArs4c6QAAAudJREFUSEu11lmo1WUUBfCfgSEVGNmcJaGV2kiUlUUUgdoAGaRZEQhCVL5VWpBFYYUG9WhQYD5UWFAQFEE09yChFVY2pzaaNIGVFYr2LdlHjqfjwftwv5f7v+d8e1hrr73+Z4RhPiOGOb9BBU7GfFyJo7sa+QPP4V28hi8HNdmvwEEt4WO4dh/QbceDuB/b+t3vLXAA3sdJ+LaCX8XXXcEH43zchGntzv74EDOxobdIb4FHK3A9LsAmjMEsHIlf8RXewD84Cs/j3Bb3E86smN11uguMLz7/rYuf4g7cjQN7OvuhGnmRXXN8CLfjI0xtz3927ncXCI934XHciOvwVF0MbUl2DM7DhEr0XlfhZwvpk43SG/oVCOyLcAVewseIkm7DIz0IjqsZHYanMbuh/RtrcSgmY3NiuhF0Ep6I77EVv+Bw7KwCt2IFfqv/gzBI38QlOAef4fd+CD7BpEbLCfir0fRjFRmNyHFGS/ByS/hFCeBnjGuI11TX87B8kIoSnCSXVaJvWkCo6FAUtOH56tbtO0XnjiaM69tMwnsUdzwikr4qWlBqeLgUETrynICzSyFR0+pCem+j+D7sV9yfgv+h6J5BdB5aMqzTEQQvNEu4tBJE4+n41GYfH9Rc0nHmNbfR9QRWlbr6IsiHUUQsIot2Vs3gbUxpye/B4opc1lRyM5a2hbsTsZeoJk4Qkez2p95NPgTRdpYs0svCHNv0vQ6j2taeVioZ2+j4rjY7uxEaO83dgjjCrrM3s4uKIs0LEQTZ6CUN/iuNhukVm+Fmc+NDOfGmJH6mNTFnUIHOdysbkmuQ4YWyjbUTkXK03nsmFvI95jDofRATu6q2OFIN3wvbTizCA+W42fAsZMwwJ0Pfw1EHFbi8/CeyzJAvbpS93v6+VTtwRqnpc6T7vmdQgSPKgmMX8ZwMM5LMeyIbHM/JNsc2YulDLpAXSdQRmxhZEszwtyD20fk+b7I8D7nA3mKG9Pmw/6r4D/JUohlC4HcUAAAAAElFTkSuQmCC"/>
<div data-i18n="Layouts">KYC</div>
</a>
<ul class="menu-sub">

<li class="menu-item">
    <a href="{{ route('user/kyc-form') }}" class="menu-link">
        <div data-i18n="Without menu">Apply KYC</div>
    </a>
</li>




<li class="menu-item">
  <a href="{{ route('kyc.details') }}" class="menu-link">
      <div data-i18n="Without navbar">KYC Details</div>
  </a>
</li>

</ul>
</li>
@endif
@if($role==="distibuter")
<li class="menu-item">
  <a href="javascript:void(0);" class="menu-link menu-toggle d-flex align-items-center gap-1">
    <i class="fa-solid fa-user-plus fs-4 fs-md-2 fs-lg-1"></i>
    <div data-i18n="Layouts">OnBoard</div>
</a>

<ul class="menu-sub">

{{-- <li class="menu-item">
    <a href="{{route('add-new')}}" class="menu-link">
        <div data-i18n="Without menu">Onboard Retailer</div>
    </a>
</li> --}}


<li class="menu-item">
  <a href="{{route('list.new')}}" class="menu-link">
      <div data-i18n="Without navbar">Retailer List</div>
  </a>
</li>


<li class="menu-item">
<a href="{{route('disCommission.list')}}" class="menu-link">
    <div data-i18n="Without navbar">Commission</div>
</a>
</li>

</ul>
</li>
@endif
        <!-- More menu items -->
        <li class="menu-item">
          <a href="{{route('/user/wallet/index')}}" class="menu-link d-flex align-items-center gap-2">
              <i class="fa-solid fa-wallet fs-5 fs-md-2 fs-lg-1"></i>
              <div data-i18n="Analytics">ZPay Collect</div>
          </a>
      </li>
      
       

        <li class="menu-header small text-uppercase">
          <span class="menu-header-text">Services</span>
        </li>
        {{-- @if(!$customer->pin <= 0) --}}
<!-- Example of submenu -->
@if($customer->pin > 0)
        @if($customer->aeps == 1)
        <li class="menu-item">
          <a href="{{route('cash.withdrawal.form')}}" class="menu-link d-flex align-items-center gap-2">
              <i class="fa-solid fa-fingerprint fs-5 fs-md-2 fs-lg-1"></i>
              <div data-i18n="Analytics">AePS</div>
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
<a href="" class="menu-link  gap-2">
{{-- <img src="https://cdn-icons-png.flaticon.com/128/1981/1981861.png" alt="Bill Payments Icon" style="width: 20px; height: 20px; margin-right: 10px;"> --}}
<i class="fa-solid fa-credit-card fs-5 fs-md-2 fs-lg-1"></i>
<div data-i18n="Analytics">Bill Payments</div>
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
{{-- @endif --}}


        {{-- <li class="menu-item">
          <a href="javascript:void(0);" class="menu-link menu-toggle">
            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAAAXNSR0IArs4c6QAAAPJJREFUSEvt1TFOAkEYhuGHmADHsNGCcA8bCgsPYUNLTKSDBENL4x1sbTyHsZLCY6ANZslANsvCzGbExMRJptn993tn3n93p+XEo3XifE0A51iEBQ3xkbK4FEAHd2F2Q+gKD2F+HgPFAFd4RLH6ulHs4hYvhyCHAFsdgxQNeEattiqg0DHCGO1K+BPucYYZriv3vzDFHDttZUBMxwWWIbSP1xRtZcA6ouMS76Gmh7dI/Sa7CaCsaIKbnwYk9ntX1ngH2YAioNyHrb6ca3u/ipywumf/AZu+H+vV7yqKfcnZr+nfBzRVkFQfO9GSQnKOzGzAN0gjOhlouyZoAAAAAElFTkSuQmCC"/>
            <div data-i18n="Layouts">All services</div>
          </a>
          <ul class="menu-sub">
            <li class="menu-item">
              <a href="{{route('cash.withdrawal.form')}}" class="menu-link">
                <div data-i18n="Without menu">AePS</div>
              </a>
            </li>
            <li class="menu-item">
              <a href="{{route('dmt.remitter-profile')}}" class="menu-link">
                <div data-i18n="Without navbar">DMT-1</div>
              </a>
            </li>
            </li>
             <li class="menu-item">
              <a href="{{route('getcategory')}}" class="menu-link">
                <div data-i18n="Without navbar">Bill Payments</div>
              </a>
            </li>
            </li>
             <li class="menu-item">
              <a href="{{route('panCard')}}" class="menu-link">
                <div data-i18n="Without navbar">Pan</div>
              </a>
            </li>
            </li>
             <li class="menu-item">
              <a href="{{route('credit_card.create')}}" class="menu-link">
                <div data-i18n="Without navbar">Credit Card</div>
              </a>
            </li>
            </li>
             <li class="menu-item">
              <a href="{{route('process-payment-gateway')}}" class="menu-link">
                <div data-i18n="Without navbar">Loans</div>
              </a>
            </li>
            </li>
             <li class="menu-item">
              <a href="{{route('account-form')}}" class="menu-link">
                <div data-i18n="Without navbar">Bank Verification</div>
              </a>
            </li>
          </ul>
        </li> --}}
<!-- Example of submenu -->
   
        {{-- <li class="menu-item">
          <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons bx bx-angular "></i>
            <div data-i18n="Layouts">
                AEPS</div>
          </a>

          <ul class="menu-sub">
            <li class="menu-item">
              <a href="/admin/AEPS/balance-enquiry" class="menu-link">
                <div data-i18n="Without menu">Balance Enquary</div>
              </a>
            </li>
            <li class="menu-item">
              <a href="/admin/AEPS/cash-withdrawal" class="menu-link">
                <div data-i18n="Without navbar">Withdrawl</div>
              </a>
            </li>
            <li class="menu-item">
              <a href="/admin/AEPS/mini-statement" class="menu-link">
                <div data-i18n="Without navbar">Mini Statement</div>
              </a>
            </li>
           
          </ul>
        </li>
        
        <li class="menu-item">
          <a href="index.html" class="menu-link">
            <i class="menu-icon tf-icons bx bx-wallet"></i>
            <div data-i18n="Analytics">BBPS</div>
          </a>
        </li>
     
       <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle">
          <i class="menu-icon tf-icons bx bx-angular "></i>
          <div data-i18n="Layouts">
              Recharge</div>
        </a>

        <ul class="menu-sub">
          <li class="menu-item">
            <a href="layouts-without-menu.html" class="menu-link">
              <div data-i18n="Without menu">Mobile Recharge</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="layouts-without-navbar.html" class="menu-link">
              <div data-i18n="Without navbar">DTH Recharge</div>
            </a>
          </li>
         
        </ul>
      </li>
    
      <li class="menu-item">
        <a href="index.html" class="menu-link">
          <i class="menu-icon tf-icons bx bx-wallet"></i>
          <div data-i18n="Analytics">Money Transfer</div>
        </a>
      </li>
      <li class="menu-item">
        <a href="index.html" class="menu-link">
          <i class="menu-icon tf-icons bx bx-wallet"></i>
          <div data-i18n="Analytics">Insurance</div>
        </a>
      </li>
      <li class="menu-item">
        <a href="/admin/account-opening" class="menu-link">
          <i class="menu-icon tf-icons bx bx-wallet"></i>
          <div data-i18n="Analytics">Bank Account Opening</div>
        </a>
      </li> --}}
      {{-- <li class="menu-item">
        <a href="{{route('generate-url')}}" class="menu-link">
          <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAAAXNSR0IArs4c6QAAAOhJREFUSEvt1LFKA0EUheFvyzS+gCCIhWmFYBU7e8ljWMfGKq2pLawCeQrrFGlsLESwCwo+QQrbmIFZWJdF2Z0NxJBpppiZ/8w9c+dkNjyyDfPtlsAV7tBNtO0NN3gMnKJFnzhMhOfHFzgpC6ziauq7/OAUYXuB3P/ttCi07j16mGCKB/QxxzVeYwmNKnha9/V5BARo+C9hzkcQuUgR+EInAg6wrPgveUc2quAZZxE6wLDtCi4xijbNokCrb1AnQRpZ1IrAB47qkH7Z+47jctiFuB7jNFHkBbdVcZ3IrT6eGs1/Xur/C3wDvQs0GWSqx0IAAAAASUVORK5CYII="/>
          <div data-i18n="Analytics">CMS</div>
        </a>
      </li> --}}
      <li class="menu-item">
        <a href="{{route('commission.get')}}" class="menu-link gap-1">
          {{-- <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAAAXNSR0IArs4c6QAAAR1JREFUSEvt1btKBEEQheFvETUTczHwBcRUBC+BGAhmPoWBoKYarKGgRr6HKAYiKBiZ+gCCCBuLkYmXbRlh6O3ZadZdTLbD4lT93aemahoGfBoDrm8IqHW4bNEtlmsz8gR3WAnSMuArLzdb9VO7V8AHbrDWBfcnwC6O0cR+BSQbsFS8NPgazgU2MIlHTOcCgm4C51GzFzFWWPKMObziEutR8Wts4u03nhq0GTwlbhV8X8AD9nCU0EyhVY6nAON4TyTv4ATzuMdIQhNin3WA7ba/p1Fyyve4NyFlC2dVgKo5eMFswvcAGC16k+pz9ld00LbjsIvvVaOQDQgFroqhSvneF0D2figJO17Qz2UX1shqvIt6uWVtzvCP9v8WfQPMWC8Z5nK9/gAAAABJRU5ErkJggg=="/> --}}
          <i class="fa-solid fa-hand-holding-dollar  fs-4 fs-md-2 fs-lg-1"></i>
          <div data-i18n="Analytics">Commission Plans</div>
        </a>
      </li> 
     
      <li class="menu-header small text-uppercase">
        <span class="menu-header-text">Report</span>
      </li>
      <li class="menu-item">
        <a href="javascript:void(0);" class="menu-link menu-toggle gap-2">
          {{-- <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAAAXNSR0IArs4c6QAAAMhJREFUSEvt1DEOAUEUxvGfRK0kkWi4gFs4iUolUZA4gwM4CIlb0OioFFoXIJssZjc2YseqTDeT+d7/vfe9mZqKV63i+H4KSGBzjNAqUdkeE6xCbVjBAuMSgUPJAb0iwBlNDLApAbqmmkzbw839QuWAEslnJBkvXlVwQSOS8vDiFSB2dDNe/AGJVfnx/HqL/oCPX8TXPchnUAg4oY0+th/n/RQUApYYRgQOpUd0k4PwJdcxSyGdCNAOU6zzgIiYxdLYj+1tUpUDbgOALxmvJD5dAAAAAElFTkSuQmCC"/> --}}
          <i class="fa-solid fa-clipboard-list fs-4 fs-md-2 fs-lg-1"></i>
          <div data-i18n="Layouts">Report</div>
        </a>
        <ul class="menu-sub">
          <li class="menu-item">
            <a href="{{route('transaction.history')}}" class="menu-link">
              <div data-i18n="Without menu">DMT S1</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="{{route('dmtps.history')}}" class="menu-link">
              <div data-i18n="Without navbar">DMT S2</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="{{route('aeps.history')}}" class="menu-link">
              <div data-i18n="Without navbar">Aeps</div>
            </a>
          </li>
          {{-- <li class="menu-item">
            <a href="{{route('laser.statement')}}" class="menu-link">
              <div data-i18n="Without navbar">Ledger</div>
            </a>
          </li> --}}
        </ul>
      </li>
      {{-- <li class="menu-item">
        <a href="{{route('statement/account-stmt')}}" class="menu-link">
          <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAAAXNSR0IArs4c6QAAATVJREFUSEu11b8rR1EYx/HXt5gMymKjRIrB32CwkhhtRgazjEosFgZ/gE0M/gZ/gIFSSmxKMku4R/dbt+v+OPdyz3KG89zP+3k+z7nP6el49TrWVwVYxS6mGyZxhx2che+qADeYaSjeD7/FbB3gq0T8FRfp2TJGSuJ+kq+qoAjwnIjPIexhjeI63fOcVoBjbOaUjrBRUEUrwDlW2gL6lvRtK7LoHVN4SiEDuMd4TAUxgKDzicvEqhcsYCy2ybGA2Jv7qwd1gHB+ggM8pJQJbGP9rxaFu7+YWHJVkv58attQ5rxRBWtJc09rvNnCYVvAYDJfPmoAw3hrC4htbDau1qJ/H3b5WxTG9R4mG6ZfOq7zgIa6xeHZado54LHit6+qpvLZzR4uYb/FExkN+BfPC1+dTpRT0W88zz4ZLvda9wAAAABJRU5ErkJggg=="/>
          <div data-i18n="Analytics">Account Statement</div>
        </a>
      </li> --}}
      
      {{-- <li class="menu-item">
        <a href="{{route('statement/wallet-transfer-report')}}" class="menu-link">
          <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAAAXNSR0IArs4c6QAAAMhJREFUSEvt1DEOAUEUxvGfRK0kkWi4gFs4iUolUZA4gwM4CIlb0OioFFoXIJssZjc2YseqTDeT+d7/vfe9mZqKV63i+H4KSGBzjNAqUdkeE6xCbVjBAuMSgUPJAb0iwBlNDLApAbqmmkzbw839QuWAEslnJBkvXlVwQSOS8vDiFSB2dDNe/AGJVfnx/HqL/oCPX8TXPchnUAg4oY0+th/n/RQUApYYRgQOpUd0k4PwJdcxSyGdCNAOU6zzgIiYxdLYj+1tUpUDbgOALxmvJD5dAAAAAElFTkSuQmCC"/>
          <div data-i18n="Analytics">Wallet Report</div>
        </a>
      </li>
      <li class="menu-item">
        <a href="{{route('statement/fund-report')}}" class="menu-link">
          <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAAAXNSR0IArs4c6QAAAOhJREFUSEvt1LFKA0EUheFvyzS+gCCIhWmFYBU7e8ljWMfGKq2pLawCeQrrFGlsLESwCwo+QQrbmIFZWJdF2Z0NxJBpppiZ/8w9c+dkNjyyDfPtlsAV7tBNtO0NN3gMnKJFnzhMhOfHFzgpC6ziauq7/OAUYXuB3P/ttCi07j16mGCKB/QxxzVeYwmNKnha9/V5BARo+C9hzkcQuUgR+EInAg6wrPgveUc2quAZZxE6wLDtCi4xijbNokCrb1AnQRpZ1IrAB47qkH7Z+47jctiFuB7jNFHkBbdVcZ3IrT6eGs1/Xur/C3wDvQs0GWSqx0IAAAAASUVORK5CYII="/>
          <div data-i18n="Analytics">Collect Orders</div>
        </a>
      </li> --}}
      {{-- <li class="menu-item">
        <a href="{{route('transaction.history')}}" class="menu-link">
          <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAAAXNSR0IArs4c6QAAAMhJREFUSEvt1DEOAUEUxvGfRK0kkWi4gFs4iUolUZA4gwM4CIlb0OioFFoXIJssZjc2YseqTDeT+d7/vfe9mZqKV63i+H4KSGBzjNAqUdkeE6xCbVjBAuMSgUPJAb0iwBlNDLApAbqmmkzbw839QuWAEslnJBkvXlVwQSOS8vDiFSB2dDNe/AGJVfnx/HqL/oCPX8TXPchnUAg4oY0+th/n/RQUApYYRgQOpUd0k4PwJdcxSyGdCNAOU6zzgIiYxdLYj+1tUpUDbgOALxmvJD5dAAAAAElFTkSuQmCC"/>
          <div data-i18n="Analytics">DMT S1 Report</div>
        </a>
      </li>
      <li class="menu-item">
        <a href="{{route('dmtps.history')}}" class="menu-link">
          <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAAAXNSR0IArs4c6QAAAOhJREFUSEvt1LFKA0EUheFvyzS+gCCIhWmFYBU7e8ljWMfGKq2pLawCeQrrFGlsLESwCwo+QQrbmIFZWJdF2Z0NxJBpppiZ/8w9c+dkNjyyDfPtlsAV7tBNtO0NN3gMnKJFnzhMhOfHFzgpC6ziauq7/OAUYXuB3P/ttCi07j16mGCKB/QxxzVeYwmNKnha9/V5BARo+C9hzkcQuUgR+EInAg6wrPgveUc2quAZZxE6wLDtCi4xijbNokCrb1AnQRpZ1IrAB47qkH7Z+47jctiFuB7jNFHkBbdVcZ3IrT6eGs1/Xur/C3wDvQs0GWSqx0IAAAAASUVORK5CYII="/>
          <div data-i18n="Analytics">DMT S2 Repost</div>
        </a>
      </li>

      <li class="menu-item">
        <a href="{{route('aeps.history')}}" class="menu-link">
          <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAAAXNSR0IArs4c6QAAAudJREFUSEu11lmo1WUUBfCfgSEVGNmcJaGV2kiUlUUUgdoAGaRZEQhCVL5VWpBFYYUG9WhQYD5UWFAQFEE09yChFVY2pzaaNIGVFYr2LdlHjqfjwftwv5f7v+d8e1hrr73+Z4RhPiOGOb9BBU7GfFyJo7sa+QPP4V28hi8HNdmvwEEt4WO4dh/QbceDuB/b+t3vLXAA3sdJ+LaCX8XXXcEH43zchGntzv74EDOxobdIb4FHK3A9LsAmjMEsHIlf8RXewD84Cs/j3Bb3E86smN11uguMLz7/rYuf4g7cjQN7OvuhGnmRXXN8CLfjI0xtz3927ncXCI934XHciOvwVF0MbUl2DM7DhEr0XlfhZwvpk43SG/oVCOyLcAVewseIkm7DIz0IjqsZHYanMbuh/RtrcSgmY3NiuhF0Ep6I77EVv+Bw7KwCt2IFfqv/gzBI38QlOAef4fd+CD7BpEbLCfir0fRjFRmNyHFGS/ByS/hFCeBnjGuI11TX87B8kIoSnCSXVaJvWkCo6FAUtOH56tbtO0XnjiaM69tMwnsUdzwikr4qWlBqeLgUETrynICzSyFR0+pCem+j+D7sV9yfgv+h6J5BdB5aMqzTEQQvNEu4tBJE4+n41GYfH9Rc0nHmNbfR9QRWlbr6IsiHUUQsIot2Vs3gbUxpye/B4opc1lRyM5a2hbsTsZeoJk4Qkez2p95NPgTRdpYs0svCHNv0vQ6j2taeVioZ2+j4rjY7uxEaO83dgjjCrrM3s4uKIs0LEQTZ6CUN/iuNhukVm+Fmc+NDOfGmJH6mNTFnUIHOdysbkmuQ4YWyjbUTkXK03nsmFvI95jDofRATu6q2OFIN3wvbTizCA+W42fAsZMwwJ0Pfw1EHFbi8/CeyzJAvbpS93v6+VTtwRqnpc6T7vmdQgSPKgmMX8ZwMM5LMeyIbHM/JNsc2YulDLpAXSdQRmxhZEszwtyD20fk+b7I8D7nA3mKG9Pmw/6r4D/JUohlC4HcUAAAAAElFTkSuQmCC"/>
          <div data-i18n="Analytics">Aeps Statement</div>
        </a>
      </li> --}}
      {{-- <li class="menu-item">
        <a href="{{route('statement/fund-transfer-report')}}" class="menu-link">
          <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAAAXNSR0IArs4c6QAAAPJJREFUSEvt1TFOAkEYhuGHmADHsNGCcA8bCgsPYUNLTKSDBENL4x1sbTyHsZLCY6ANZslANsvCzGbExMRJptn993tn3n93p+XEo3XifE0A51iEBQ3xkbK4FEAHd2F2Q+gKD2F+HgPFAFd4RLH6ulHs4hYvhyCHAFsdgxQNeEattiqg0DHCGO1K+BPucYYZriv3vzDFHDttZUBMxwWWIbSP1xRtZcA6ouMS76Gmh7dI/Sa7CaCsaIKbnwYk9ntX1ngH2YAioNyHrb6ca3u/ipywumf/AZu+H+vV7yqKfcnZr+nfBzRVkFQfO9GSQnKOzGzAN0gjOhlouyZoAAAAAElFTkSuQmCC"/>
          <div data-i18n="Analytics">Fund Transfer Report</div>
        </a>
      </li>
      <li class="menu-item">
        <a href="{{route('statement/money-transfer-report')}}" class="menu-link">
          <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAAAXNSR0IArs4c6QAAANdJREFUSEvt1DFqAkEUANDnHQJiK4jYBmyCIZ7CC9h5AO+RIm3AkwRBLGzSRhBrBe+gDEjYJLs7OutWZur5/83/f2Yaal6NmvO7b2CKGfZlbU5t0QRv2OAZuyIkFWhiiTa2eCqqJBUIBw7IHN0ypAoQkAcsypA84FjhbXziMRt/a+ALvRhQoYC/oVVnED1MHvCBYTSyeMOPnHnACv06gewjWmOAQypYNIObIWVD/o28xD62vCpjt6h1/g46GOP92lbFgJAvICO8Xps87L8ESMn7HfMPRNt3AmGoIBm8JKweAAAAAElFTkSuQmCC"/>
          <div data-i18n="Analytics">Money Transfer Report</div>
        </a>
      </li> --}}
      <li class="menu-item">
        <a href="{{route('laser.statement')}}" class="menu-link gap-2">
          <i class="fa-solid fa-landmark fs-5 fs-md-2 fs-lg-1"></i>
          <div data-i18n="Analytics">All transaction</div>
        </a>
      </li> 
      {{-- <li class="menu-item">
        <a href="#" class="menu-link">
          <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAAAXNSR0IArs4c6QAAAPJJREFUSEvt1TFOAkEYhuGHmADHsNGCcA8bCgsPYUNLTKSDBENL4x1sbTyHsZLCY6ANZslANsvCzGbExMRJptn993tn3n93p+XEo3XifE0A51iEBQ3xkbK4FEAHd2F2Q+gKD2F+HgPFAFd4RLH6ulHs4hYvhyCHAFsdgxQNeEattiqg0DHCGO1K+BPucYYZriv3vzDFHDttZUBMxwWWIbSP1xRtZcA6ouMS76Gmh7dI/Sa7CaCsaIKbnwYk9ntX1ngH2YAioNyHrb6ca3u/ipywumf/AZu+H+vV7yqKfcnZr+nfBzRVkFQfO9GSQnKOzGzAN0gjOhlouyZoAAAAAElFTkSuQmCC"/>
          <div data-i18n="Analytics">Fund Transfer Report</div>
        </a>
      </li> --}}
      {{-- <li class="menu-item">
        <a href="#" class="menu-link">
          <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAAAXNSR0IArs4c6QAAANdJREFUSEvt1DFqAkEUANDnHQJiK4jYBmyCIZ7CC9h5AO+RIm3AkwRBLGzSRhBrBe+gDEjYJLs7OutWZur5/83/f2Yaal6NmvO7b2CKGfZlbU5t0QRv2OAZuyIkFWhiiTa2eCqqJBUIBw7IHN0ypAoQkAcsypA84FjhbXziMRt/a+ALvRhQoYC/oVVnED1MHvCBYTSyeMOPnHnACv06gewjWmOAQypYNIObIWVD/o28xD62vCpjt6h1/g46GOP92lbFgJAvICO8Xps87L8ESMn7HfMPRNt3AmGoIBm8JKweAAAAAElFTkSuQmCC"/>
          <div data-i18n="Analytics">Money Transfer Report</div>
        </a>
      </li> --}}
      
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
<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center fixed-top mt-0 mt-lg-3" id="layout-navbar">


  <div class="layout-menu-toggle navbar-nav align-items-xl-center me-1 d-xl-none">
    <a class="nav-item nav-link px-0" href="javascript:void(0)">
        <i class="bx bx-menu bx-sm"></i>
    </a>
</div>



  <div class="navbar-nav-right d-flex align-items-center" id="navbar-collaps">
 

     <!-- Add Fund Button -->
     <div class=" rounded ">
      <a href="{{route('/user/fund-transfer/bank-account')}}" class="add_fund whitespace-nowrap fw-bold fa fa-plus">
       
      </a>
    </div>
    
      <div class="d-flex justify-content-between align-items-center">
          <div class="d-flex align-items-center gap-2">
              <i class="bx bx-wallet bx-sm text-primary"></i>
              <span class="fw-bold text-dark">₹</span>
              <span class="fw-bold text-dark">{{ session('balance') }}</span>
          </div>

          <!-- Account Section (Visible on Desktop) -->
          <div class="d-none d-md-flex flex-column flex-md-row ms-3">
              <span class="role btn d-inline-flex align-items-center px-3 lg:py-1 py-0 rounded-pill">
                  <span class="fw-bold">Account: </span>&nbsp;
              </span>
              <span class="d-block text-md-start text-center lg:mt-1 mt-0 mt-md-0">
                  @if (trim(strtolower($role)) === 'distibuter')
                      Distributor
                  @else
                      Retailer
                  @endif
              </span>
          </div>
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
                      <a class="dropdown-item" href="{{ route('coustomer.logout') }}">
                          <i class="bx bx-power-off me-2"></i>
                          <span class="align-middle">Log Out</span>
                      </a>
                  </li>
                  <li>
                      <a class="dropdown-item" href="{{ route('remitter.certificate') }}">
                          <i class="bx bx-file me-2"></i>
                          <span class="align-middle">Certificate</span>
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

</style> 


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
          <p><b>Balance:</b>{{ session('balance') }}</p>
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


