<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset | ZPay</title>
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
    <div class="container mx-auto flex flex-col items-center justify-center min-h-screen px-6">
        <!-- Centered Brand Section -->
        <div class="flex flex-col items-center text-center mb-8">
            <!-- Logo -->
            <img src="{{ asset('assets/img/icons/abhipaym.jpg') }}" style="border-radius: 50%;" alt="ZPay Logo" class="w-20 h-20 mb-4">
            <h1 class="text-blue-600 text-4xl md:text-6xl font-bold">
                <span style="color: #ff0800">Z</span><span style="color: #0d0d0e">Pay</span>
            </h1>
            <p class="text-gray-600 text-lg font-semibold mt-2">Easy & Secure Financial Transactions</p>
        </div>

        <!-- Password Reset Form Section -->
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-lg">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Reset Your Password</h2>

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

            <!-- Password Reset Form -->
            <form action="{{ route('password.update') }}" method="POST">
                @csrf
                <!-- Hidden Token -->
                <input type="hidden" name="mobile" value="{{ $mobile }}">

                <!-- New Password -->
                <div class="mb-4">
                    <label for="password" class="block text-gray-700 font-medium">New Password</label>
                    <input type="password" id="password" name="password" required class="mt-1 p-3 border rounded w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('password')
                        <small class="text-red-500">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Confirm New Password -->
                <div class="mb-6">
                    <label for="password_confirmation" class="block text-gray-700 font-medium">Confirm New Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required class="mt-1 p-3 border rounded w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('password_confirmation')
                        <small class="text-red-500">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit" class="button text-white font-bold py-3 rounded w-full">Reset Password</button>
            </form>
        </div>
    </div>
</body>
</html>
