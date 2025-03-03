<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #ff7eb3, #ff758c);
            color: #fff;
            font-family: 'Arial', sans-serif;
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .error-container {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
            padding: 60px 40px;
            color: #333;
            width: 100%;
            max-width: 700px; /* Adjusted for larger screens */
            animation: fadeIn 1.2s ease-in-out;
        }

        .error-container i {
            font-size: 80px;
            color: #dc3545;
            margin-bottom: 20px;
            animation: bounce 1.5s infinite;
        }

        .error-container h1 {
            font-size: 3rem;
            margin-bottom: 10px;
            color: #dc3545;
        }

        .error-container p {
            font-size: 1.2rem;
            margin-bottom: 20px;
        }

        .btn-custom {
            background: #dc3545;
            color: #fff;
            border-radius: 50px;
            padding: 12px 30px;
            text-decoration: none;
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }

        .btn-custom:hover {
            background: #c82333;
            color: #fff;
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(-20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-15px);
            }
            60% {
                transform: translateY(-10px);
            }
        }
    </style>
</head>
<body>
    <div class="error-container">
        <i class="fas fa-exclamation-triangle"></i>
        <h1>Oops!</h1>
        <h3>Something went wrong while processing your request.</h3>
        <div class="alert alert-danger">
            <ul>
                @foreach ($messages as $message)
                    <li>{{ $message }}</li>
                @endforeach
            </ul>
        </div>>
        {{-- <p><strong>Error Message:</strong> {{ $message }}</p> --}}
        <a href="https://ZPay.com/" class="btn btn-custom">
            <i class="fas fa-arrow-left"></i> Go Back
        </a>
    </div>
</body>
</html>
