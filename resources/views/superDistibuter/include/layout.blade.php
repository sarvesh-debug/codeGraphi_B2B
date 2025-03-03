
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
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <script>
      document.body.style.zoom = "80%";
  </script>
  
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <meta charset="utf-8" />
    {{-- <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" /> --}}
    <title>ZPay|| Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/icons/z-pay-fav.png') }}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet" />

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
            <a href="{{route('admin.dashboard')}}" class="app-brand-link">
              <span class="app-brand-text demo menu-text fw-bolder ms-2">
                <img src="{{ asset('assets/img/icons/z-pay-logo.png') }}" width="200px" height=""  alt="">
              </span>
            </a>
            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
              <i class="bx bx-chevron-left bx-sm align-middle"></i>
            </a>
          </div>
          <div class="menu-inner-shadow"></div>
          <ul class="menu-inner py-1">
            <li class="menu-item ">
              <a href="{{route('admin.dashboard')}}" class="menu-link">
                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAAAXNSR0IArs4c6QAAASFJREFUSEvt1b8uBUEUx/HPjUQ0KoUHkIigUUmEhIKotBqegAfwBqLnCeg0CqU/BZGoNEIUHkChEh3hbrKbjHHX7O51GzHlmXN+33NOfpNp6fFp9VhfHcAwLvKG5vBUpbmqgEFcYTIXvcUMXlKQKoB+nGI2ErvEAt5+gqQA2f0RVkpEDrGKjzJICrCLjcQa9rDZBLCF7dSO8/ssd6dTbtkEa9ivKF6kreMgrukEWMYx+moC3ttOW8JZWBcDpnI7DtQUL9Jf247L3shNEQgBI7jGUEPxouwZ03jMAiHgAaNdihfld5iIAfcY+yVApjUeA0Lt0oeTaOCbacps+jcB8bSdpuxqRf+ALwY8x3wQOcFiZNEqObX+5EZvMPXhNBINiz4Bp0ktGQo11VEAAAAASUVORK5CYII="/>
                <div data-i18n="Analytics">Home</div>
              </a>
            </li>
            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                  <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAAAXNSR0IArs4c6QAAAJBJREFUSEvtlE0OQDAUhD+nsBYWDiK2LuMQTiSxcA4r1m5BiIq/Iq1KmrTbduZ7b9KMh+HjGfbnd0AGFECsuFkD5EAp9McNesBXNBeyDghlgGG5UI3upD8aOYCL6PEDu4gsiGjqkeBxzvsHLRDJuigFKk1AAtRXAPHFNP1X+dxz27IzDvhq8p2Pau+/HsZ+wAifXyEZA1BA5wAAAABJRU5ErkJggg=="/>
                  <div data-i18n="Layouts">
                      Distibuter</div>
                </a>
  
                <ul class="menu-sub">
                  <li class="menu-item">
                    <a href="#" class="menu-link">
                      <div data-i18n="Without menu">Create Destibuter</div>
                    </a>
                  </li>
                  <li class="menu-item">
                    <a href="#" class="menu-link">
                      <div data-i18n="Without menu">Destibuter List</div>
                    </a>
                  </li>
                  
                
                 
                 
                </ul>
              </li>
            <!-- Example of submenu -->
            <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                  <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAAAXNSR0IArs4c6QAAAURJREFUSEvF1L8rRXEYx/HXTWaEwSiZLIpVRgulKBaLzWLwa7QopURS/gRZ5FcW/wAlGWQiIykMKKX8OKdc3c69557bOW6+2znn+3zen+fp85ycKp9clfVVCujFIjp+DF1gDsdJBisBjGKTIjOfGMRBOUgSoB43aIgRuUMb3uIgSYDQ4U7CGPpwlBYwjeUEwBRW0wIGsJ8A6MdhWkAdrtEUI3CPdrykBYR1I9gqIRCmaAi7WVKUr+3B0s8efOASszj5iz1I0ij7PSmmmcTD4nKAZswEm9oVzLkTjRHaI85xihU8lHITBxgLBNeDfIcpquQ8YRx70culAJPBr2GtEtUSd4axXfg+CmjFFWpSAl4RavyOKwrYwERK8XzZfGBwIf8QBdyiJSPgDN1xgHfUZgQ8F4Yj2sFXRvEi4/+6aH/STNU7+AYkwS0ZwQsJ3gAAAABJRU5ErkJggg=="/>
                  <div data-i18n="Layouts">
                      Retailers</div>
                </a>
  
                <ul class="menu-sub">
                  <!--<li class="menu-item">-->
                  <!--  <a href="{{route('admin/user-list-request')}}" class="menu-link">-->
                  <!--    <div data-i18n="Without menu">User Requests</div>-->
                  <!--  </a>-->
                  <!--</li>-->
                  <li class="menu-item">
                    <a href="{{route('admin/user-list')}}" class="menu-link">
                      <div data-i18n="Without navbar">All Members</div>
                    </a>
                  </li>
                  {{-- <li class="menu-item">
                    <a href="{{route('merchant-form')}}" class="menu-link">
                      <div data-i18n="Without navbar">Merchant Onboard</div>
                    </a> --}}
                  </li>
                  <li class="menu-item">
                    <a href="{{route('merchant-list')}}" class="menu-link">
                      <div data-i18n="Without navbar">Merchant Onboard List</div>
                    </a>
                  </li>

                  <!--<li class="menu-item">-->
                  <!--  <a href="{{route('admin/user-add')}}" class="menu-link">-->
                  <!--    <div data-i18n="Without navbar">Add Member</div>-->
                  <!--  </a>-->
                  </li>
                  {{-- <li class="menu-item">
                    <a href="#" class="menu-link">
                      <div data-i18n="Without navbar">Upgrate Role</div>
                    </a>
                  </li>
                  <li class="menu-item">
                    <a href="#" class="menu-link">
                      <div data-i18n="Without navbar">Change Owner</div>
                    </a>
                  </li> --}}
                 
                </ul>
              </li>
            

              {{-- <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                  <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAAAXNSR0IArs4c6QAAAudJREFUSEu11lmo1WUUBfCfgSEVGNmcJaGV2kiUlUUUgdoAGaRZEQhCVL5VWpBFYYUG9WhQYD5UWFAQFEE09yChFVY2pzaaNIGVFYr2LdlHjqfjwftwv5f7v+d8e1hrr73+Z4RhPiOGOb9BBU7GfFyJo7sa+QPP4V28hi8HNdmvwEEt4WO4dh/QbceDuB/b+t3vLXAA3sdJ+LaCX8XXXcEH43zchGntzv74EDOxobdIb4FHK3A9LsAmjMEsHIlf8RXewD84Cs/j3Bb3E86smN11uguMLz7/rYuf4g7cjQN7OvuhGnmRXXN8CLfjI0xtz3927ncXCI934XHciOvwVF0MbUl2DM7DhEr0XlfhZwvpk43SG/oVCOyLcAVewseIkm7DIz0IjqsZHYanMbuh/RtrcSgmY3NiuhF0Ep6I77EVv+Bw7KwCt2IFfqv/gzBI38QlOAef4fd+CD7BpEbLCfir0fRjFRmNyHFGS/ByS/hFCeBnjGuI11TX87B8kIoSnCSXVaJvWkCo6FAUtOH56tbtO0XnjiaM69tMwnsUdzwikr4qWlBqeLgUETrynICzSyFR0+pCem+j+D7sV9yfgv+h6J5BdB5aMqzTEQQvNEu4tBJE4+n41GYfH9Rc0nHmNbfR9QRWlbr6IsiHUUQsIot2Vs3gbUxpye/B4opc1lRyM5a2hbsTsZeoJk4Qkez2p95NPgTRdpYs0svCHNv0vQ6j2taeVioZ2+j4rjY7uxEaO83dgjjCrrM3s4uKIs0LEQTZ6CUN/iuNhukVm+Fmc+NDOfGmJH6mNTFnUIHOdysbkmuQ4YWyjbUTkXK03nsmFvI95jDofRATu6q2OFIN3wvbTizCA+W42fAsZMwwJ0Pfw1EHFbi8/CeyzJAvbpS93v6+VTtwRqnpc6T7vmdQgSPKgmMX8ZwMM5LMeyIbHM/JNsc2YulDLpAXSdQRmxhZEszwtyD20fk+b7I8D7nA3mKG9Pmw/6r4D/JUohlC4HcUAAAAAElFTkSuQmCC"/>
                  <div data-i18n="Layouts">
                      KYC</div>
                </a>
  
                <ul class="menu-sub">
                  <li class="menu-item">
                    <a href="{{(route('admin/kyc-form'))}}" class="menu-link">
                      <div data-i18n="Without menu">KYC Apply</div>
                    </a>
                  </li>
                  <li class="menu-item">
                    <a href="{{route('admin/kyc-list')}}" class="menu-link">
                      <div data-i18n="Without navbar">All KYC Members</div>
                    </a>
                  </li>
                 
                 
                 
                </ul>
              </li> --}}

            
              <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                  <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAAAXNSR0IArs4c6QAAAMNJREFUSEvtlU0KwjAQRl+vYcGFG+3Kc+jGG7kRpV248nwuBEU8hTLFlJQWksmPKDjLMPleZr5MUpA5isz6fBSwAWpgEVHVAzgBe6NhV3AFyghxe+sO2MqCDXgmEheZOzDJCei0NSZXwBFYeVbaamsAkj8DzqEAlwfmMK683gXSmPwH4Ort97fI5/ZNgYtPohkBzRwsgQOwDgW4PPDU7dIGk5wSMPrYSW+lxyli9LmWD6cB5hGE2/vDEZ02NCYHcX8f8AKtTiAZznncCgAAAABJRU5ErkJggg=="/>
                  <div data-i18n="Layouts">
                      Wallet</div>
                </a>
  
                <ul class="menu-sub">
                  <li class="menu-item">
                    <a href="{{route('admin/wallet/credit-debit')}}" class="menu-link">
                      <div data-i18n="Without menu">Wallet Credit & Debit</div>
                    </a>
                  </li>
                  <li class="menu-item">
                    <a href="{{route('admin/wallet/credit-lock')}}" class="menu-link">
                      <div data-i18n="Without navbar">Wallet Lock & Release</div>
                    </a>
                  </li>
                  <li class="menu-item">
                    <a href="{{route('admin/wallet/fund-request')}}" class="menu-link">
                      <div data-i18n="Without navbar">Fund Requests</div>
                    </a>
                  </li>
                 
                 
                </ul>
              </li>


              <li class="menu-item">
              <a href="{{route('commission-form')}}" class="menu-link">
               <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAAAXNSR0IArs4c6QAAAR1JREFUSEvt1btKBEEQheFvETUTczHwBcRUBC+BGAhmPoWBoKYarKGgRr6HKAYiKBiZ+gCCCBuLkYmXbRlh6O3ZadZdTLbD4lT93aemahoGfBoDrm8IqHW4bNEtlmsz8gR3WAnSMuArLzdb9VO7V8AHbrDWBfcnwC6O0cR+BSQbsFS8NPgazgU2MIlHTOcCgm4C51GzFzFWWPKMObziEutR8Wts4u03nhq0GTwlbhV8X8AD9nCU0EyhVY6nAON4TyTv4ATzuMdIQhNin3WA7ba/p1Fyyve4NyFlC2dVgKo5eMFswvcAGC16k+pz9ld00LbjsIvvVaOQDQgFroqhSvneF0D2figJO17Qz2UX1shqvIt6uWVtzvCP9v8WfQPMWC8Z5nK9/gAAAABJRU5ErkJggg=="/>
               <div data-i18n="Analytics">Commission Plans</div>
             </a>
            </li>
              <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                  <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAAAXNSR0IArs4c6QAAALRJREFUSEvd1kEKwjAQheG/dxEEvY5HaXeCVAQX7VF6nQqeRgm0oDXNmzQNSLNMJvNlhtC0IPMoMufHB5yAG7AX+AW4qgP6gB44qI3DegW0oVgf8DIkrwFXgRtBZCng9jVAqZAUwOWWSCogkTWAKfKVcylgvjgKGNctN2tEoyrYHmCpKKlF2wN8Fa3aov8HDF/unxDZopgHZ5r9ARw/J+eezDuwizz+EzgDnQIi84bDs/9VvAHHQzQZ5bZMoQAAAABJRU5ErkJggg=="/>
                  <div data-i18n="Layouts">
                      Reports</div>
                </a>
  
                <ul class="menu-sub">
                  <li class="menu-item">
                    <a href="{{route('admin/reports/aeps')}}" class="menu-link">
                      <div data-i18n="Without menu">AEPS Statement</div>
                    </a>
                  </li>
                  <li class="menu-item">
                    <a href="{{route('admin/reports/credit-card-bill-payment')}}" class="menu-link">
                      <div data-i18n="Without navbar">C C Bill Payment</div>
                    </a>
                  </li>
                  <li class="menu-item">
                    <a href="{{route('admin/reports/dmt-payment')}}" class="menu-link">
                      <div data-i18n="Without navbar">DMT</div>
                    </a>
                  </li>
                  {{-- <li class="menu-item">
                    <a href="{{route('admin/reports/dth-recharge')}}" class="menu-link">
                      <div data-i18n="Without navbar">DTH Recharge</div>
                    </a>
                  </li>
                  <li class="menu-item">
                    <a href="{{route('admin/reports/ledger')}}" class="menu-link">
                      <div data-i18n="Without navbar">Ledger</div>
                    </a>
                  </li>
                  <li class="menu-item">
                    <a href="{{route('admin/reports/mobile-recharge')}}" class="menu-link">
                      <div data-i18n="Without navbar">Mobile Recharge</div>
                    </a>
                  </li> --}}
                  <li class="menu-item">
                    <a href="{{route('admin/reports/fund-transfer')}}" class="menu-link">
                      <div data-i18n="Without navbar">Fund Transfer</div>
                    </a>
                  </li>
                  <li class="menu-item">
                    <a href="{{route('credit_card.history')}}" class="menu-link">
                      <div data-i18n="Without navbar">Credit Card Apply</div>
                    </a>
                  </li>
                  <li class="menu-item">
                    <a href="{{route('admin/reports/dmt-payment')}}" class="menu-link">
                      <div data-i18n="Without navbar">PayOut</div>
                    </a>
                  </li>
                  {{-- <li class="menu-item">
                    <a href="#" class="menu-link">
                      <div data-i18n="Without navbar">Wallet To Wallet</div>
                    </a>
                  </li> --}}
                 
                </ul>
              </li>
              {{-- <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                  <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAAAXNSR0IArs4c6QAAActJREFUSEu11curjlEUBvDfEREGCsllwEAxkpFyN/AnMECUci0jZSaXqTIgiTJAiL9BuWSAkVJKEiUSI+USBrxL71f77PY++yvn25O33rXW86z1rLX2HjPiMzZifMMSPMDGLJn72NJKcFiCPxWgZnzJYTrm4X0Puhn3KgSb8LC3LcJn/E59SwSPsAYXMRWHGjKc55/UB/EYGyYi2I2rLV0b9sC4PvBJK5iJV4hS/+d8wHJ8D5CU4ET342QFOYIO9BKEy9oukcudjAsq/oF1Oie4je2FgI9Y3Wkc3/QswXPMKcTcwK6cIKbnDI5kATtxs5Lpvr6S1Hyuk+cYfuYEA6cfmJFELCxkPzBHFe8S32+Y3RrTX5iWOC1G9KB0coJo7KwaQUh0FoczpHFjl9n24kr27wKOliS6g22VJq/qiD8VmvwMcwsxt7Aj70GM1fGKFCFRNDQ2dQrW4dIEYxrjfioniEV7i/kVkmF/x320tLRoATAZV8UeXBtkU7rsnvaLFZv6pnOMcsdNRlLK116KZd2k7ccTrG+Nacx9yPW6d1zZbfiLij4r8LK3xRX/ZZjruoQ1qQ9OiSAenHh40nMXW1udbz55LYCWfeQEfwGGhkoZUGgCkAAAAABJRU5ErkJggg=="/>
                  <div data-i18n="Layouts">
                      Settings</div>
                </a>
  
                <ul class="menu-sub">
                  <li class="menu-item">
                    <a href="#" class="menu-link">
                      <div data-i18n="Without menu">Main Setting</div>
                    </a>
                  </li>
                  <li class="menu-item">
                    <a href="#" class="menu-link">
                      <div data-i18n="Without navbar">Company Bank</div> 
                    </a>
                  </li>
                  <li class="menu-item">
                    <a href="#" class="menu-link">
                      <div data-i18n="Without navbar">Commission & Charges</div>
                    </a>
                  </li>
                  <li class="menu-item">
                    <a href="#" class="menu-link">
                      <div data-i18n="Without navbar">Manage Service</div>
                    </a>
                  </li>
                 
                </ul>
              </li> --}}

              {{-- <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                  <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAAAXNSR0IArs4c6QAAASVJREFUSEu11cEqRUEYwPHftRU7Ya8UCzv7+waSB5BSSlkhC4W6kdhRykb2NrL1FEJ5AUoW8gLcqXOVcY9z5jhndnNm5v+f75vvzLQ03FoN88WCBXQwWVH8hG1c9dbHggdMVYT3lj1iOk/w+U/4L24cQZ7gHVu4zgghlfsYytnQN7esYBGXEWwVp3UJRvAWwcbxXJdgFK8RbAwvdQmWcBHBVnBWlyAc8mZ2yAOYxwGG6xKkVm9yFTUq+MA5brqpuctMM5jDMgb72EtHEEqzjfucEGZx2+eHKy1Yw0lBfsLhH0ZzSgtSc194FzV+m4ZLLNT3RMWtF74Hedxd7ESDe91++P5nS3kyj7Ce0Y6xUQQP4ymCMD9IQisFryIos+kfc1IjSBZ8AVXgMxk/2d8tAAAAAElFTkSuQmCC"/>
                  <div data-i18n="Layouts">
                      Employee</div>
                </a>
  
                <ul class="menu-sub">
                  <li class="menu-item">
                    <a href="#" class="menu-link">
                      <div data-i18n="Without menu">Create Employee</div>
                    </a>
                  </li>
                  <li class="menu-item">
                    <a href="#" class="menu-link">
                      <div data-i18n="Without navbar">Manage Employee</div> 
                    </a>
                  </li>
                 
                 
                </ul>
              </li> --}}

              <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                  <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAAAXNSR0IArs4c6QAAAJBJREFUSEvtlE0OQDAUhD+nsBYWDiK2LuMQTiSxcA4r1m5BiIq/Iq1KmrTbduZ7b9KMh+HjGfbnd0AGFECsuFkD5EAp9McNesBXNBeyDghlgGG5UI3upD8aOYCL6PEDu4gsiGjqkeBxzvsHLRDJuigFKk1AAtRXAPHFNP1X+dxz27IzDvhq8p2Pau+/HsZ+wAifXyEZA1BA5wAAAABJRU5ErkJggg=="/>
                  <div data-i18n="Layouts">
                      Other Services</div>
                </a>
  
                <ul class="menu-sub">
                  <li class="menu-item">
                    <a href="#" class="menu-link">
                      <div data-i18n="Without menu">Create & Manage Service</div>
                    </a>
                  </li>
                
                 
                 
                </ul>
              </li>
              {{-- <li class="menu-item">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                  <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAAAXNSR0IArs4c6QAAAQlJREFUSEvt1b8uBFEcxfHPNiJq3oBeVGqN6BARr6AVelpCtvEMohB/opJ4BiHxGNQoMFem2Nydu/eOzXR72/n9zvfOOWcyPR2fXsf6JoCswymL5nCGtVrhHnt4zypGA02AGTxjPpp9xRK+2kCaADu4SIis47Z+9pMB/Wk3AQ5wnFjex+m4gE1cJQAbuBnXomm8YCESCrks42NcQNgPLerXLfquwr1DsCdu0agckhm0ueC/AFvYxUpEeqze7BzXbW4Qt+iktmKUxmHVvqNSyCBgG5eFi6t4yNR1KIOnqoKLhYAgHiDhpHIYAnxiqhDwhtmS2UGLcp9+rFf0LykaKrlpamYCyLrXuUW/h78lGZeAMYAAAAAASUVORK5CYII="/>
                  <div data-i18n="Layouts">
                      Invoice Details</div>
                </a>
  
                <ul class="menu-sub">
                  <li class="menu-item">
                    <a href="#" class="menu-link">
                      <div data-i18n="Without menu">Invoice Download</div>
                    </a>
                  </li>
                  <li class="menu-item">
                    <a href="#" class="menu-link">
                      <div data-i18n="Without navbar">Invoice Setting</div> 
                    </a>
                  </li>
                 
                </ul>
              </li> --}}


          </ul>
        </aside>
        <!-- /Menu -->

        <!-- Layout container -->
        <div class="layout-page">
          <!-- Navbar -->
          <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
              <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="bx bx-menu bx-sm"></i>
              </a>
            </div>
            <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
              <div class="navbar-nav align-items-center">
                <div class="nav-item d-flex align-items-center">
                  <i class="bx bx-search fs-4 lh-0"></i>
                  <input type="text" class="form-control border-0 shadow-none" placeholder="Search..." aria-label="Search..." />
                </div>
              </div>

              <ul class="navbar-nav flex-row align-items-center ms-auto">
                <!-- User -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                  <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                      <img src="{{ asset('assets/img/avatars/1.png') }}" alt class="w-px-40 h-auto rounded-circle" />
                    </div>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                      <a class="dropdown-item" href="#">
                        <div class="d-flex">
                          <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-online">
                              <img src="{{ asset('assets/img/avatars/1.png') }}" alt class="w-px-40 h-auto rounded-circle" />
                            </div>
                          </div>
                          <div class="flex-grow-1">
                            <span class="fw-semibold d-block">John Doe</span>
                            <small class="text-muted">Admin</small>
                          </div>
                        </div>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider"></div>
                    </li>
                    <li>
                      <a class="dropdown-item" href="#">
                        <i class="bx bx-user me-2"></i>
                        <span class="align-middle">My Profile</span>
                      </a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="#">
                        <i class="bx bx-cog me-2"></i>
                        <span class="align-middle">Settings</span>
                      </a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="{{route('admin.logout')}}">
                        <i class="bx bx-power-off me-2"></i>
                        <span class="align-middle">Log Out</span>
                      </a>
                    </li>
                  </ul>
                </li>
                <!--/ User -->
              </ul>
            </div>
          </nav>
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
    <!-- /Layout wrapper -->

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
    <script src="{{asset('assets/js/scripts.js')}}"></script>


  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>

  <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
  <script src="js/datatables-simple-demo.js"></script>
  </body>
</html>
