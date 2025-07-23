<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password | CodeGraphi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/icons/CodeGraphi-fav.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .btn-blue {
            @apply bg-blue-600 hover:bg-blue-700 transition-all duration-300 text-white font-semibold py-3 rounded w-full;
        }
    </style>
</head>
<body class="bg-gradient-to-r from-blue-800 to-blue-600 min-h-screen flex items-center justify-center px-4 py-10">

    <div class="w-full max-w-xl bg-white rounded-lg shadow-lg p-8">

        <!-- Brand Section -->
        <div class="text-center mb-8">
            <img src="{{ asset('assets/img/icons/codegraphi-logo.png') }}" alt="CodeGraphi Logo" class="mx-auto w-20 h-20 rounded-full mb-3">
            <h1 class="text-4xl font-bold">
                <span class="text-red-600">Code</span><span class="text-gray-900">Graphi</span>
            </h1>
            <p class="text-gray-600 mt-1">Easy & Secure Financial Transactions</p>
        </div>

        <!-- Heading -->
        <h2 class="text-center text-2xl font-semibold text-gray-800 mb-6">Reset Your Password</h2>

        <!-- Error Messages -->
        @if($errors->any())
            <div class="bg-red-500 text-white p-4 rounded mb-5">
                <ul class="list-disc pl-4">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Reset Form -->
        <form action="{{ route('password.update') }}" method="POST" class="space-y-5">
            @csrf

            <!-- Hidden Mobile Field -->
            <input type="hidden" name="mobile" value="{{ $mobile }}">

            <!-- New Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
                <input
                    type="password"
                    name="password"
                    id="password"
                    required
                    class="mt-1 w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                @error('password')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                <input
                    type="password"
                    name="password_confirmation"
                    id="password_confirmation"
                    required
                    class="mt-1 w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                @error('password_confirmation')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit" class="btn-blue">Reset Password</button>
            </div>
        </form>

        <!-- Footer Links -->
        <div class="text-center mt-6 text-sm text-gray-600">
            Remembered your password?
            <a href="{{ route('customer.login') }}" class="text-blue-300 hover:underline">Login here</a>
        </div>
    </div>

</body>
</html>
