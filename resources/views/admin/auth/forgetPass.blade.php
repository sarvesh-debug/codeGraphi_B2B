<!DOCTYPE html>
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
                <span style="color: #0f0f0f">Z </span><span style="color: #01060c">Pay</span>
            </h1>
            <p class="text-gray-600 text-lg font-semibold mt-2">Simplifying Your Financial Transactions</p>
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
            <form action="{{ route('password.email1') }}" method="POST">
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
</html>
