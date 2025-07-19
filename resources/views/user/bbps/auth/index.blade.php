<!DOCTYPE html>
<html lang="zxx">
<head>
    <title>CodeGraphi Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">

    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Jost:wght@300;400;500;600;700&display=swap">
    <!-- Bootstrap & Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/flaticon/font/flaticon.css') }}">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/skins/default.css') }}">

    <style>
        body {
            font-family: 'Jost', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #1e3c72, #2a5298);
        }

        .login-13 .bg-img {
            background: linear-gradient(135deg, #88898a, #203a43, #2c5364);
            color: #e0e0e0;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 50px;
            text-align: center;
        }

        .login-13 .bg-img h1 {
            font-size: 32px;
            font-weight: 700;
        }

        .login-13 .bg-img p {
            font-size: 15px;
            margin-top: 15px;
            max-width: 400px;
            margin: 15px auto 0;
        }

        .form-info {
            background: linear-gradient(135deg, #88898a, #203a43, #2c5364);
            color: #cfd8dc;
            padding: 50px 30px;
        }

        .form-section-innner {
            max-width: 400px;
            margin: auto;
        }

        .link-btn {
            display: inline-block;
            width: 48%;
            padding: 10px;
            margin: 10px 1%;
            font-weight: 500;
            border-radius: 30px;
            text-align: center;
            border: 2px solid #64b5f6;
            transition: all 0.3s ease-in-out;
        }

        .btn-1 {
            background-color: #64b5f6;
            color: #f3cece;
        }

        .btn-1:hover {
            background-color: #42a5f5;
        }

        .btn-2 {
            background-color: transparent;
            color: #64b5f6;
        }

        .btn-2:hover {
            background-color: #0d2538;
        }

        .form-box {
            margin-bottom: 20px;
        }

        .form-control {
            background-color: #1e2d3b;
            color: #fff;
            border: 1px solid #607d8b;
            border-radius: 10px;
            height: 50px;
            padding: 12px 15px;
        }

        .form-control::placeholder {
            color: #90a4ae;
        }

        .form-control:focus {
            border-color: #64b5f6;
            box-shadow: 0 0 0 0.2rem rgba(100, 181, 246, 0.25);
        }

        .btn-theme {
            background-color: #64b5f6;
            color: #726b6b;
            border: none;
            border-radius: 25px;
            padding: 12px 30px;
            font-size: 16px;
        }

        .btn-theme:hover {
            background-color: #42a5f5;
        }

        .forgot-password, .thembo {
            color: #90caf9;
        }

        .forgot-password:hover, .thembo:hover {
            text-decoration: underline;
        }

        .toggle-password {
            color: #cfd8dc;
        }

        .checkbox label {
            color: #cfd8dc;
        }
        

        /* Responsive order change */
        @media (max-width: 768px) {
            .form-info {
                order: -1;
            }

            .bg-img {
                display: none;
            }
        }
    </style>
</head>
<body id="top">

<div class="login-13">
    <div class="container-fluid">
        <div class="row d-flex flex-wrap">
            <!-- Login Form Section - Show First on Mobile -->
            <div class="col-lg-6 col-md-12 form-info">
                <div class="form-section">
                    <div class="form-section-innner">
                        <div class="logo mb-4 text-center">
                            <a href="{{ route('customer.login') }}">
                                <img src="{{ asset('assets/img/logos/codegraphi-logo.png') }}" alt="logo" style="max-width: 350px;">
                            </a>
                        </div>
                        <h3 class="text-center">Sign Into Your Account</h3>
                        <div class="btn-section clearfix text-center">
                            <a href="{{ route('customer.login') }}" class="link-btn btn-1">Login</a>
                            <a href="{{ route('/verfy-retailer.form') }}" class="link-btn btn-2">Register</a>
                        </div>

                        @if($errors->any())
                            <div class="bg-danger text-white p-3 rounded mb-3">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('customer.loginF') }}" method="POST">
                            @csrf
                            <div class="form-group form-box">
                                <input name="phone" type="text" id="phone" required class="form-control" placeholder="Your phone number">
                            </div>

                            <div class="form-group form-box" style="position: relative;">
                                <input name="password" type="password" id="password" required class="form-control password-input" placeholder="Password" autocomplete="off" style="padding-right: 35px;">
                                <svg class="toggle-password" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" width="18" height="18" style="position: absolute; right: 16px; top: 50%; transform: translateY(-50%); cursor: pointer;">
                                    <path fill="currentColor" d="M572.52 241.4C518.39 135.5 410.6 64 288 64S57.61 135.5 3.48 241.4a32.35 32.35 0 0 0 0 29.2C57.61 376.5 165.4 448 288 448s230.39-71.5 284.52-177.4a32.35 32.35 0 0 0 0-29.2zM288 400c-97 0-177.82-57.22-223.13-144C110.18 169.22 191 112 288 112s177.82 57.22 223.13 144C465.82 342.78 385 400 288 400zm0-272a112 112 0 1 0 112 112A112.14 112.14 0 0 0 288 128zm0 192a80 80 0 1 1 80-80A80.09 80.09 0 0 1 288 320z"></path>
                                </svg>
                            </div>

                            <script>
                                document.querySelector(".toggle-password").addEventListener("click", function () {
                                    let input = document.querySelector(".password-input");
                                    input.type = input.type === "password" ? "text" : "password";
                                });
                            </script>

                            <div class="checkbox form-group clearfix">
                                <div class="form-check float-start">
                                    <input class="form-check-input" type="checkbox" id="rememberme">
                                    <label class="form-check-label" for="rememberme">Remember me</label>
                                </div>
                                <a href="{{ route('password.request') }}" class="forgot-password float-end">Forgot password?</a>
                            </div>

                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-theme">Login</button>
                            </div>
                        </form>

                        <p class="mt-4 text-center">Don't have an account? <a href="{{ route('/verfy-retailer.form') }}" class="thembo">Register here</a></p>
                    </div>
                </div>
            </div>

            <!-- Welcome Section -->
            <div class="col-lg-6 col-md-12 bg-img d-none d-lg-flex">
                <div class="info">
                    <div class="center">
                        <h1>Welcome To CodeGraphi</h1>
                    </div>
                    <p>CodeGraphi is a B2B fintech app streamlining business transactions with services like BBPS, AEPS, and DMT. It ensures secure, efficient, and seamless financial operations with advanced features and integrations.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
