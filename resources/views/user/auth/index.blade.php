<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login | CodeGraphi</title>
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

        .login-wrapper {
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            max-width: 1000px;
            width: 100%;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            display: flex;
            flex-direction: row;
        }

        .login-left {
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

        .login-left h1 {
            font-size: 36px;
            margin-bottom: 20px;
        }

        .login-left p {
            font-size: 15px;
            max-width: 350px;
        }

        .login-right {
            flex: 1;
            padding: 50px 40px;
        }

        .login-right .logo {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-right h3 {
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

        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6c757d;
        }

        @media (max-width: 768px) {
            .login-wrapper {
                flex-direction: column;
            }

            .login-left {
                display: none;
            }

            .login-right {
                padding: 40px 20px;
            }
        }
    </style>
</head>
<body>

<div class="login-wrapper">
    <!-- Left Panel -->
    <div class="login-left">
        <h1>Welcome to CodeGraphi</h1>
        <p>Secure fintech login portal for services like BBPS, AEPS, and DMT with seamless business transaction experience.</p>
    </div>

    <!-- Right Panel (Form) -->
    <div class="login-right">
        <div class="logo mb-4">
            <a href="{{ route('customer.login') }}">
                <img src="{{ asset('assets/img/logos/codegraphi-logo.png') }}" alt="CodeGraphi Logo" style="max-width: 250px;">
            </a>
        </div>
        <h3>Sign In to Your Account</h3>

        <div class="d-flex justify-content-center gap-2 mb-4">
            <a href="{{ route('customer.login') }}" class="btn btn-sm btn-outline-primary">Login</a>
            <a href="{{ route('/verfy-retailer.form') }}" class="btn btn-sm btn-outline-secondary">Register</a>
        </div>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('customer.loginF') }}" method="POST">
            @csrf
            <div class="form-group">
                <input name="phone" type="text" required class="form-control" placeholder="Phone Number">
            </div>

            <div class="form-group" style="position: relative;">
                <input name="password" type="password" class="form-control password-input" placeholder="Password" required autocomplete="off">
                <i class="fa fa-eye toggle-password" onclick="togglePassword(this)"></i>
            </div>

            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" id="rememberme">
                <label class="form-check-label" for="rememberme">Remember Me</label>
                <a href="{{ route('password.request') }}" class="float-end">Forgot Password?</a>
            </div>

            <button type="submit" class="btn btn-theme">Login</button>
        </form>

        <div class="form-footer mt-4">
            Don't have an account?
            <a href="{{ route('/verfy-retailer.form') }}">Register here</a>
        </div>
    </div>
</div>

<script>
    function togglePassword(icon) {
        const input = document.querySelector('.password-input');
        const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
        input.setAttribute('type', type);
        icon.classList.toggle('fa-eye-slash');
    }
</script>

<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
