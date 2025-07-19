<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PIN Verification | CodeGraphi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="shortcut icon" href="img/fav.ico" type="image/x-icon">
    <style>
        /* Custom styles for the button */
        .button { background-color: #007BFF; } /* Phone Money branding */
        .button:hover { background-color: #0056b3; transition: 0.3s ease; }

        /* Responsive styles */
        @media (max-width: 768px) {
            .text-lg-md { font-size: 1rem; }
            .text-3xl-md { font-size: 1.5rem; }
        }

        /* Modal overlay */
        .modal-overlay {
            background-color: rgba(0, 0, 0, 0.5);
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Modal content */
        .modal-content {
            background-color: white;
            padding: 2rem;
            border-radius: 10px;
            width: 100%;
            max-width: 500px;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div id="pinModal" class="modal-overlay">
        <!-- PIN Form Section -->
        <div class="modal-content">
            <h1 class="text-center text-3xl font-bold">
                <span style="color: #FF6600">Enter</span> <span style="color: #007BFF">PIN</span>
            </h1>

            @if($errors->any())
                <div class="bg-red-500 text-white p-4 rounded mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form id="pinForm" class="space-y-8" action="{{ route('verify.pin') }}" method="POST">
                @csrf <!-- Include CSRF token for security -->

                <!-- PIN Input -->
                <div>
                    <label for="pin" class="block text-sm font-medium mb-1">Enter PIN <span class="text-red-500">*</span></label>
                    <input type="password" id="pin" name="pin" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Enter Your PIN" required>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-center">
                    <button type="submit" class="w-full md:w-auto button text-white px-6 py-3 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2 transition-colors duration-300">
                        Verify PIN
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
