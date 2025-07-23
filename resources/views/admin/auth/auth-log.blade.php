{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | CodeGraphi</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/icons/CodeGraphi-fav.png') }}" />
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: linear-gradient(45deg, #ff6b6b, #556270);
            animation: gradientBG 6s infinite alternate;
        }
        @keyframes gradientBG {
            0% { background: linear-gradient(45deg, #ff6b6b, #556270); }
            100% { background: linear-gradient(45deg, #556270, #ff6b6b); }
        }
        .button {
            background: linear-gradient(90deg, #ff6600, #007bff);
            transition: background 0.3s ease;
        }
        .button:hover {
            background: linear-gradient(90deg, #007bff, #ff6600);
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen">
    <div class="bg-white p-6 rounded-lg shadow-2xl max-w-lg w-full">
        <img src="{{ asset('assets/img/icons/codegraphi-logo.png') }}" class="w-20 h-20 rounded-full mx-auto mb-4" alt="CodeGraphi Logo">
        @if($errors->any())
        <div class="bg-red-500 text-white p-4 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <form action="{{ route('login') }}" method="POST" class="space-y-6">
            @csrf
            <h1 class="text-center text-3xl font-bold text-gray-800">Admin Login</h1>
            <div>
                <label class="block text-sm font-medium">Email</label>
                <input type="email" name="email" class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-500" placeholder="Your Email" required>
            </div>
            <div>
                <label class="block text-sm font-medium">Password</label>
                <input type="password" name="password" class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-500" placeholder="Your Password" required>
            </div>
            <div class="text-center">
                <button type="submit" class="w-full button text-white py-3 rounded-md font-bold">Log In</button>
            </div>
            <div class="text-center mt-3">
                <a href="{{ route('admin.pass') }}" class="text-blue-500">Forgot Password?</a>
            </div>
        </form>
    </div>
</body>
</html> --}}







<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login | CodeGraphi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@300;400;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap + Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/font-awesome/css/font-awesome.min.css') }}">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/icons/CodeGraphi-fav.png') }}" />

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
            max-width: 950px;
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
        <h1>Welcome Admin</h1>
        <p>Access your CodeGraphi admin dashboard to manage users, services, and transactions.</p>
    </div>

    <!-- Right Panel (Form) -->
    <div class="login-right">
        <div class="logo">
            <img src="{{ asset('assets/img/icons/codegraphi-logo.png') }}" alt="CodeGraphi Logo" style="max-width: 200px;">
        </div>
        <h3>Admin Login</h3>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="form-group">
                <input name="email" type="email" class="form-control" placeholder="Email" required>
            </div>

            <div class="form-group" style="position: relative;">
                <input name="password" type="password" class="form-control password-input" placeholder="Password" required>
                <i class="fa fa-eye toggle-password" onclick="togglePassword(this)"></i>
            </div>

            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" id="rememberme">
                <label class="form-check-label" for="rememberme">Remember Me</label>
                <a href="{{ route('admin.pass') }}" class="float-end">Forgot Password?</a>
            </div>

            <button type="submit" class="btn btn-theme" style="background: linear-gradient(to right, #0a22aa, #b62512); color: white; border: none;">Login</button>
        </form>
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
