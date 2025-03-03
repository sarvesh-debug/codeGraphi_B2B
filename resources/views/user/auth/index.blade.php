<!DOCTYPE html>
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
</html>
