<!DOCTYPE html>
<html lang="zxx">
<head>
    <title>Forget Password - CodeGraphi</title>
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
            background: #0f2027;
            background: linear-gradient(to right, #2c5364, #203a43, #0f2027);
            color: #cfd8dc;
            padding: 60px 30px;
        }

        .form-section-innner {
            max-width: 400px;
            margin: auto;
        }

        .logo img {
            height: 60px;
            margin-bottom: 20px;
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
            color: #fff;
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
            padding-left: 15px;
        }

        .form-control::placeholder {
            color: #b0bec5;
        }

        .btn-theme {
            width: 100%;
            border-radius: 30px;
            padding: 12px 0;
            background-color: #64b5f6;
            color: white;
            font-weight: 600;
        }

        .btn-theme:hover {
            background-color: #42a5f5;
        }

        .text-red-500 {
            color: #f44336 !important;
        }

        p.none-2 {
            text-align: center;
            margin-top: 20px;
        }

        .thembo {
            color: #64b5f6;
            font-weight: 500;
            text-decoration: underline;
        }

        .bg-red-500 {
            background-color: #ef5350 !important;
        }
    </style>
</head>
<body>
<div class="login-13">
    <div class="container-fluid">
        <div class="row">
            <!-- Left Section -->
            <div class="col-lg-6 col-md-12 bg-img">
                <div>
                    <h1>Welcome to CodeGraphi</h1>
                    <p>CodeGraphi is a B2B fintech app streamlining business transactions with services like BBPS, AEPS, and DMT. It ensures secure, efficient, and seamless financial operations.</p>
                </div>
            </div>

            <!-- Right Section -->
            <div class="col-lg-6 col-md-12 form-info">
                <div class="form-section">
                    <div class="form-section-innner text-center">
                        <!-- Logo -->
                        <div class="logo">
                            <a href="{{ route('password.request') }}">
                                <img src="{{ asset('assets/img/logos/codegraphi-logo.png') }}" alt="CodeGraphi Logo">
                            </a>
                        </div>

                        <!-- Buttons -->
                        <div class="btn-section clearfix mb-4">
                            <a href="{{ route('customer.login') }}" class="link-btn btn-1">Login</a>
                            <a href="{{ route('/verfy-retailer.form') }}" class="link-btn btn-2">Register</a>
                        </div>

                        <!-- Heading -->
                        <h3 class="mb-4">Recover Your Password</h3>

                        <!-- Error Messages -->
                        @if($errors->any())
                            <div class="bg-red-500 text-white p-3 rounded mb-4 text-start">
                                <ul class="mb-0 ps-3">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Form Start -->
                        <form action="{{ route('password.email') }}" method="POST">
                            @csrf

                            <!-- Mobile Input -->
                            <div class="form-group form-box">
                                <input name="mobile" type="text" id="username" class="form-control" placeholder="Enter your Phone Number" required>
                                @error('mobile')
                                    <small class="text-red-500">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Email Input -->
                            <div class="form-group form-box">
                                <input name="email" type="email" id="email" class="form-control" placeholder="Enter your Email Id" required>
                                @error('email')
                                    <small class="text-red-500">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <div class="form-group">
                                <button type="submit" class="btn btn-theme">Send Reset Link</button>
                            </div>
                        </form>

                        <!-- Footer Link -->
                        <p class="none-2">Already a member? <a href="{{ route('customer.login') }}" class="thembo">Login here</a></p>
                    </div>
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
