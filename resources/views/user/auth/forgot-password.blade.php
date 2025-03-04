{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login | ZPay</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/icons/z-pay-fav.png') }}" />
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .button { background-color: #007BFF; }
        .button:hover { background-color: #0056b3; transition: 0.3s ease; }
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
    </style>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto flex flex-col items-center justify-center min-h-screen px-4">
        <!-- Centered Brand Section -->
        <div class="flex flex-col items-center text-center mb-8">
            <!-- Centered Logo -->
            <img src="{{ asset('assets/img/icons/abhipaym.jpg') }}" style="border-radius: 50%;" alt="ZPay Logo" class="w-20 h-20 mb-4">
        <h1 class="text-blue-600 text-4xl md:text-6xl font-bold">
                <span style="color: #FF6600">Z</span><span style="color: #111111">Pay</span>
            </h1>
            <p class="text-gray-600 text-lg font-semibold mt-2">Easy & Secure Financial Transactions</p>
        </div>

        <!-- Forgot Password Form Section -->
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-lg">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Forgot Your Password?</h2>
            
            <!-- Error Messages -->
            @if($errors->any())
                <div class="bg-red-500 text-white p-4 rounded mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Forgot Password Form -->
            <form action="{{ route('password.email') }}" method="POST">
                @csrf
                <!-- Username Input -->
                <div class="mb-4">
                    <label for="username" class="block text-gray-700 font-medium">Mobile No</label>
                    <input type="text" class="mt-1 p-3 border rounded w-full focus:outline-none focus:ring-2 focus:ring-blue-500" id="username" name="mobile" required>
                    @error('mobile')
                        <small class="text-red-500">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Email Input -->
                <div class="mb-6">
                    <label for="email" class="block text-gray-700 font-medium">Email Address</label>
                    <input type="email" class="mt-1 p-3 border rounded w-full focus:outline-none focus:ring-2 focus:ring-blue-500" id="email" name="email" required>
                    @error('email')
                        <small class="text-red-500">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit" class="button text-white font-bold py-3 rounded w-full">Send Reset Link</button>
            </form>
        </div>
    </div>
</body>
</html> --}}



<!DOCTYPE html>
<html lang="zxx">

<!-- Mirrored from storage.googleapis.com/theme-vessel-items/checking-sites/logdy-2-html/HTML/main/forgot-password-13.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 02 Mar 2025 12:38:30 GMT -->
<head>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
            new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        '../../../../../../www.googletagmanager.com/gtm5445.html?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-TAGCODE');</script>
    <!-- End Google Tag Manager -->
    <title>Forget Password </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <!-- External CSS libraries -->
    <link type="text/css" rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="assets/fonts/font-awesome/css/font-awesome.min.css">
    <link type="text/css" rel="stylesheet" href="assets/fonts/flaticon/font/flaticon.css">

    <!-- Favicon icon -->
    <link rel="shortcut icon" href="assets/img/favicon.ico" type="image/x-icon" >

    <!-- Google fonts -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800%7CPoppins:400,500,700,800,900%7CRoboto:100,300,400,400i,500,700">
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@300;400;500;600;700;800;900&amp;display=swap" rel="stylesheet">

    <!-- Custom Stylesheet -->
    <link type="text/css" rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" type="text/css" id="style_sheet" href="assets/css/skins/default.css">

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
                        <p>Z Pay is a B2B fintech app streamlining business transactions with services like BBPS, AEPS, and DMT. It ensures secure, efficient, and seamless financial operations with advanced features and integrations.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 form-info">
                <div class="form-section">
                    <div class="form-section-innner">
                        <div class="logo clearfix">
                            <a href="{{route('password.request')}}">
                                <img src="{{asset('assets/img/logos/zpay logo.png')}}" alt="logo">
                            </a>
                        </div>
                        <div class="btn-section clearfix">
                            <a href="{{route('customer.login')}}" class="link-btn active btn-1 default-bg">Login</a>
                            <a href="{{route('/verfy-retailer.form')}}" class="link-btn btn-2 default-bg">Register</a>
                        </div>
                        <h3>Recover Your Password</h3>
                        <div class="login-inner-form">

                             <!-- Error Messages -->
            @if($errors->any())
                <div class="bg-red-500 text-white p-4 rounded mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
                         
                            <form action="{{ route('password.email') }}" method="POST">
                                @csrf


                                <!-- Username Input -->
                                <div class="form-group form-box">
                                    <input name="mobile" type="text" id="username" required class="form-control" placeholder="Enter your Phone Number" aria-label="Enter your Phone Number">
                                    <i class="flaticon-mail-2"></i>
                                    @error('mobile')
                                    <small class="text-red-500">{{ $message }}</small>
                                @enderror
                                </div>

                                <!-- Email Input -->
                                <div class="form-group form-box">
                                    <input  type="email"  id="email" name="email" required class="form-control" placeholder="Enter your Email Id" aria-label="Enter your Email Id">
                                    <i class="flaticon-mail-2"></i>
                                    @error('email')
                                     <small class="text-red-500">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Submit Button -->
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-lg btn-theme">Send Reset Link</button>
                                </div>
                            </form>
                        </div>
                        {{-- <ul class="social-list">
                            <li><a href="#" class="facebook-color"><i class="fa fa-facebook facebook-i"></i><span>Facebook</span></a></li>
                            <li><a href="#" class="twitter-color"><i class="fa fa-twitter twitter-i"></i><span>Twitter</span></a></li>
                            <li><a href="#" class="google-color"><i class="fa fa-google google-i"></i><span>Google</span></a></li>
                        </ul> --}}
                        <p class="none-2">Already a member?<a href="login-13.html" class="thembo">Login here</a></p>
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

<!-- Mirrored from storage.googleapis.com/theme-vessel-items/checking-sites/logdy-2-html/HTML/main/forgot-password-13.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 02 Mar 2025 12:38:30 GMT -->
</html>