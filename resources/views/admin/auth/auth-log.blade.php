<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Z Pay</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/icons/z-pay-fav.png') }}" />
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
        <img src="{{ asset('assets/img/icons/abhipaym.jpg') }}" class="w-20 h-20 rounded-full mx-auto mb-4" alt="ZPay Logo">
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
</html>
