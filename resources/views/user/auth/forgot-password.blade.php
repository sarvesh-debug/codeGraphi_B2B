<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forget Password | CodeGraphi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@300;400;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/font-awesome/css/font-awesome.min.css') }}">

    <style>
        body {
            font-family: 'Jost', sans-serif;
            background: linear-gradient(to right, #1e3c72, #2a5298);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }

        .forgot-wrapper {
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            max-width: 1000px;
            width: 100%;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            display: flex;
            flex-direction: row;
        }

        .left-section {
            background: linear-gradient(135deg, #203a43, #2c5364);
            color: #fff;
            flex: 1;
            padding: 60px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .left-section h1 {
            font-size: 34px;
            margin-bottom: 20px;
        }

        .left-section p {
            font-size: 15px;
            max-width: 350px;
        }

        .right-section {
            flex: 1;
            padding: 50px 40px;
        }

        .right-section .logo {
            text-align: center;
            margin-bottom: 30px;
        }

        .right-section h3 {
            text-align: center;
            margin-bottom: 25px;
            font-weight: 600;
        }

        .form-control {
            height: 48px;
            border-radius: 8px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .btn-theme {
            background-color: #1e3c72;
            border: none;
            color: #fff;
            padding: 12px;
            width: 100%;
            border-radius: 8px;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }

        .btn-theme:hover {
            background-color: #16315d;
        }

        .form-footer {
            margin-top: 20px;
            text-align: center;
            font-size: 14px;
        }

        .form-footer a {
            color: #1e3c72;
            font-weight: 500;
        }

        .btn-section {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 25px;
        }

        .btn-outline-custom {
            padding: 8px 16px;
            font-weight: 500;
            border-radius: 6px;
        }

        @media (max-width: 768px) {
            .forgot-wrapper {
                flex-direction: column;
            }

            .left-section {
                display: none;
            }

            .right-section {
                padding: 40px 20px;
            }
        }

        .text-danger {
            font-size: 13px;
            text-align: left;
        }
    </style>
</head>
<body>

<div class="forgot-wrapper">
    <!-- Left Side -->
    <div class="left-section">
        <h1>Welcome to CodeGraphi</h1>
        <p>Reset your password to securely access our financial tools like BBPS, AEPS, DMT and more.</p>
    </div>

    <!-- Right Side (Form) -->
    <div class="right-section">
        <div class="logo mb-4">
            <a href="{{ route('password.request') }}">
                <img src="{{ asset('assets/img/logos/codegraphi-logo.png') }}" alt="CodeGraphi Logo" style="max-width: 250px;">
            </a>
        </div>

        <!-- Buttons -->
        <div class="btn-section">
            <a href="{{ route('customer.login') }}" class="btn btn-sm btn-outline-primary btn-outline-custom">Login</a>
            <a href="{{ route('/verfy-retailer.form') }}" class="btn btn-sm btn-outline-secondary btn-outline-custom">Register</a>
        </div>

        <h3>Recover Your Password</h3>

        <!-- Error Display -->
        @if($errors->any())
            <div class="alert alert-danger text-start">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form -->
        <form action="{{ route('password.email') }}" method="POST">
            @csrf

            <div class="form-group">
                <input name="mobile" type="text" class="form-control" placeholder="Enter your Phone Number" required>
                @error('mobile')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <input name="email" type="email" class="form-control" placeholder="Enter your Email ID" required>
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-theme">Send Reset Link</button>
            </div>
        </form>

        <!-- Footer -->
        <div class="form-footer">
            Already a member?
            <a href="{{ route('customer.login') }}">Login here</a>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
