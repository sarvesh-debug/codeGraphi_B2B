<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - CodeGraphi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap & Icons -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/flaticon/font/flaticon.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Jost', sans-serif;
            margin: 0;
            background: linear-gradient(to right, #00b4db, #0083b0);
        }

        .register-container {
            max-width: 1100px;
            margin: 50px auto;
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            display: flex;
            flex-wrap: wrap;
        }

        .register-left {
            flex: 1;
            background: linear-gradient(to bottom right, #006666, #004c4c);
            color: white;
            padding: 60px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .register-left h1 {
            font-size: 36px;
            font-weight: 700;
        }

        .register-left p {
            margin-top: 15px;
            font-size: 16px;
            opacity: 0.9;
            max-width: 400px;
        }

        .register-right {
            flex: 1;
            padding: 50px 40px;
        }

        .logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo img {
            height: 60px;
        }

        .btn-section {
            display: flex;
            gap: 10px;
            margin-bottom: 25px;
        }

        .link-btn {
            flex: 1;
            padding: 10px;
            font-weight: 500;
            border: 1px solid #008080;
            border-radius: 8px;
            color: #008080;
            text-align: center;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .link-btn:hover,
        .active-bg {
            background-color: #008080;
            color: white !important;
        }

        .form-control {
            height: 48px;
            border-radius: 8px;
        }

        .form-control:focus {
            box-shadow: 0 0 0 0.2rem rgba(0, 128, 128, 0.25);
            border-color: #008080;
        }

        .btn-theme {
            background-color: #008080;
            color: white;
            padding: 12px;
            font-weight: 600;
            border-radius: 8px;
            transition: 0.3s;
            width: 100%;
        }

        .btn-theme:hover {
            background-color: #006666;
        }

        .none-2 {
            text-align: center;
            margin-top: 20px;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .register-container {
                flex-direction: column;
            }

            .register-left,
            .register-right {
                padding: 30px 20px;
            }

            .btn-section {
                flex-direction: column;
            }

            .link-btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>

<div class="register-container">
    <!-- Left Panel -->
    <div class="register-left">
        <h1>Welcome to CodeGraphi</h1>
        <p>Streamline your business with CodeGraphi. Access secure, seamless fintech services like BBPS, AEPS, DMT, and more.</p>
    </div>

    <!-- Right Panel -->
    <div class="register-right">
        <div class="logo">
            <a href="{{ route('/verfy-retailer.form') }}">
                <img src="{{ asset('assets/img/logos/codegraphi-logo.png') }}" alt="CodeGraphi Logo">
            </a>
        </div>

        <h3 class="text-center mb-4">Create An Account</h3>

        <div class="btn-section">
            <a href="{{ route('customer.login') }}" class="link-btn">Login</a>
            <a href="{{ route('/verfy-retailer.form') }}" class="link-btn active-bg">Register</a>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger p-2 mb-3">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.client.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group mb-3">
                <input name="mobile" type="text" class="form-control" placeholder="Mobile No" maxlength="10" required>
            </div>

            <div class="form-group mb-3">
                <input name="name" type="text" class="form-control" placeholder="Full Name" required>
            </div>

            <div class="form-group mb-3">
                <input name="shop_name" type="text" class="form-control" placeholder="Shop Name" required>
            </div>

            <div class="form-group mb-3">
                <input name="email" type="email" class="form-control" placeholder="Email ID" required>
            </div>

            <div class="form-group mb-3">
                <input name="password" type="password" class="form-control" placeholder="Password" required>
            </div>

            <div class="form-group mb-3">
                <input name="password_confirmation" type="password" class="form-control" placeholder="Confirm Password" required>
            </div>

            <div class="form-check mb-4">
                <input class="form-check-input" type="checkbox" id="terms" required>
                <label class="form-check-label" for="terms">I agree to the <a href="#" class="text-decoration-underline">terms of service</a></label>
            </div>

            <input type="hidden" name="balance" value="0">
            <input type="hidden" name="role" value="Retailer">

            <button type="submit" class="btn btn-theme" style="background: linear-gradient(to right, #0a22aa, #b62512); color: white; border: none;">Register</button>
        </form>

        <p class="none-2">Already a member? <a href="{{ route('customer.login') }}" class="text-decoration-underline">Login here</a></p>
    </div>
</div>

<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

</body>
</html>
