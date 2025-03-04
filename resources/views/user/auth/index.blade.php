{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login | ZPay</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/icons/z-pay-fav.png') }}" />
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea, #764ba2);
        }
        .gradient-btn {
            background: linear-gradient(90deg, #ff7eb3, #ff758c);
            transition: background 0.3s ease;
        }
        .gradient-btn:hover {
            background: linear-gradient(90deg, #ff758c, #ff7eb3);
        }
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>
</head>
<body class="gradient-bg min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-lg">
        <div class="text-center mb-6">
            <img src="{{ asset('assets/img/icons/abhipaym.jpg') }}" class="w-20 h-20 rounded-full mx-auto mb-4" alt="ZPay Logo">
            <h1 class="text-4xl font-bold text-gray-800">
                <span class="text-red-500">Z</span><span class="text-gray-900">Pay</span>
            </h1>
            <p class="text-gray-600 font-semibold">Easy & Secure Financial Transactions</p>
        </div>

        @if($errors->any())
            <div class="bg-red-500 text-white p-4 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="paymentForm" action="{{ route('customer.loginF') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700">Phone <span class="text-red-500">*</span></label>
                <input type="text" id="phone" name="phone" required class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Your phone number">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password <span class="text-red-500">*</span></label>
                <input type="password" id="password" name="password" required class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter Username as Password">
            </div>

            <div class="flex justify-center">
                <button type="submit" class="gradient-btn text-white w-full py-3 rounded-md font-semibold">Log In</button>
            </div>

            <div class="text-center mt-3">
                <a href="{{ route('password.request') }}" class="text-blue-500 hover:underline">Forgot Password?</a>
            </div>
        </form>
    </div>
</body>
</html> --}}




<!DOCTYPE html>
<html lang="zxx">

<!-- Mirrored from storage.googleapis.com/theme-vessel-items/checking-sites/Zpay-2-html/HTML/main/login-13.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 02 Mar 2025 12:37:32 GMT -->
<head>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
            new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        '../../../../../../www.googletagmanager.com/gtm5445.html?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-TAGCODE');</script>
    <!-- End Google Tag Manager -->
    <title>Zpay Login </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <!-- External CSS libraries -->
    <link type="text/css" rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
    {{-- assets/css/bootstrap.min.css --}}
    <link type="text/css" rel="stylesheet" href="assets/fonts/font-awesome/css/font-awesome.min.css">
    <link type="text/css" rel="stylesheet" href="assets/fonts/flaticon/font/flaticon.css">

    <!-- Favicon icon -->
    <link rel="shortcut icon" href="assets/img/favicon.ico" type="image/x-icon" >

    <!-- Google fonts -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800%7CPoppins:400,500,700,800,900%7CRoboto:100,300,400,400i,500,700">
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@300;400;500;600;700;800;900&amp;display=swap" rel="stylesheet">

    <!-- Custom Stylesheet -->
    <link type="text/css" rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    <link rel="stylesheet" type="text/css" id="style_sheet" href="{{asset('assets/css/skins/default.css')}}">
    

    {{-- assets/css/skins/default.css --}}
    {{-- assets/css/style.css --}}

</head>
<body id="top">
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TAGCODE"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<div class="page_loader"></div>

<!-- Login 13 start -->
<div class="login-13">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 col-md-12 bg-img">
                <div class="bg-img-inner">
                    <div class="info">
                        <div class="center">
                            <h1>Welcome To Zpay</h1>
                        </div>
                        <p>We provide fintech services that enhance digital transactions, including AEPS for biometric banking, BBPS for bill payments, DTH recharge, and more. Our solutions ensure secure, fast, and convenient financial access for users.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 form-info">
                <div class="form-section">
                    <div class="form-section-innner">
                        <div class="logo clearfix">
                            <a href="{{route('customer.login')}}">
                                <img src="{{asset('assets/img/logos/zpay logo.png')}}"  alt="logo">
                                {{-- assets/img/logos/logo.png --}}
                            </a>
                        </div>
                        <h3>Sign Into Your Account</h3>
                        <div class="btn-section clearfix">
                            <a href="{{route('customer.login')}}" class="link-btn active btn-1 default-bg">Login</a>
                            <a href="{{route('/verfy-retailer.form')}}" class="link-btn btn-2 active-bg">Register</a>
                        </div>
                        <div class="login-inner-form">


                            @if($errors->any())
                            <div class="bg-red-500 text-white p-4 rounded mb-4">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif

                            <form action="{{ route('customer.loginF') }}" method="POST">
                                @csrf

                                {{-- type="text" id="phone" name="phone" required --}}
                                <div class="form-group form-box clearfix">
                                    <input name="phone" type="text" id="phone" required class="form-control" placeholder="Your phone number" aria-label="Your phone number">
                                    <i class="flaticon-mail-2"></i>
                                </div>
                                {{-- type="password" id="password" name="password" required --}}

                                <div class="form-group form-box clearfix" style="position: relative;">
                                    <input name="password" type="password" id="password" required class="form-control password-input" 
                                           autocomplete="off" placeholder="Password" aria-label="Password" 
                                           style="padding-right: 35px; width: 100%;">
                                           
                                    <svg class="toggle-password" 
                                         xmlns="http://www.w3.org/2000/svg" 
                                         viewBox="0 0 576 512" 
                                         width="18" height="18" 
                                         style="position: absolute; right: 16px; top: 50%; transform: translateY(-50%); cursor: pointer;">
                                        <path fill="currentColor" 
                                              d="M572.52 241.4C518.39 135.5 410.6 64 288 64S57.61 135.5 3.48 241.4a32.35 32.35 0 0 0 0 29.2C57.61 376.5 165.4 448 288 448s230.39-71.5 284.52-177.4a32.35 32.35 0 0 0 0-29.2zM288 400c-97 0-177.82-57.22-223.13-144C110.18 169.22 191 112 288 112s177.82 57.22 223.13 144C465.82 342.78 385 400 288 400zm0-272a112 112 0 1 0 112 112A112.14 112.14 0 0 0 288 128zm0 192a80 80 0 1 1 80-80A80.09 80.09 0 0 1 288 320z">
                                        </path>
                                    </svg>
                                </div>
                                
                                <script>
                                    document.querySelector(".toggle-password").addEventListener("click", function () {
                                        let passwordInput = document.querySelector(".password-input");
                                        passwordInput.type = passwordInput.type === "password" ? "text" : "password";
                                    });
                                </script>
                                
                                <div class="checkbox form-group clearfix">
                                    <div class="form-check float-start">
                                        <input class="form-check-input" type="checkbox" id="rememberme">
                                        <label class="form-check-label" for="rememberme">
                                            Remember me
                                        </label>
                                    </div>
                                    <a href="{{route('password.request')}}" class="link-light float-end forgot-password">Forgot password?</a>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-lg btn-theme">Login</button>
                                </div>
                            </form>
                        </div>
                        {{-- <ul class="social-list">
                            <li><a href="#" class="facebook-color"><i class="fa fa-facebook facebook-i"></i><span>Facebook</span></a></li>
                            <li><a href="#" class="twitter-color"><i class="fa fa-twitter twitter-i"></i><span>Twitter</span></a></li>
                            <li><a href="#" class="google-color"><i class="fa fa-google google-i"></i><span>Google</span></a></li>
                        </ul> --}}
                        <p class="none-2">Don't have an account? <a href="{{route('/verfy-retailer.form')}}" class="thembo"> Register here</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Login 13 end -->

<!-- External JS libraries -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<!-- Custom JS Script -->
</body>

<!-- Mirrored from storage.googleapis.com/theme-vessel-items/checking-sites/Zpay-2-html/HTML/main/login-13.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 02 Mar 2025 12:37:43 GMT -->
</html>