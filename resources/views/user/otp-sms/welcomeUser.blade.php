<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to ZPay</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .welcome-card {
            margin-top: 50px;
            padding: 30px;
            background: #ffffff;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        .logo {
            width: 120px;
            margin-bottom: 20px;
        }
        h1 {
            color: #007bff;
            font-weight: 600;
        }
        p {
            font-size: 1.1rem;
            color: #333;
        }
        .redirect-info {
            color: #28a745;
            font-weight: bold;
        }
        footer {
            margin-top: 20px;
            font-size: 0.9rem;
            color: #666;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="d-flex justify-content-center">
            <div class="col-md-8 text-center welcome-card">
                <!-- Logo Section -->
                <img src="{{ asset('assets/img/icons/abhipaym.jpg') }}" style="border-radius: 50%;" alt="ZPay Logo" class="logo">

                <!-- Welcome Content -->
                <h1>Welcome to Z Pay!</h1>
                <p>Dear <b>{{$username}}</b>,</p>
                <p>Your RT number is <span class="redirect-info">{{ $rt_number }}</span>.</p>
                <p class="mt-3">You will be redirected shortly...</p>

                <!-- Redirect Information -->
                <div class="spinner-border text-primary mt-3" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
        </div>
        <footer>
            &copy; 2024 zpaypvtltd.com All rights reserved.
        </footer>
    </div>

    <!-- Redirect Script -->
    <script>
        setTimeout(function() {
            window.location.href = "https://zpaypvtltd.com";
        }, 5000); // Redirect after 5 seconds
    </script>
</body>
</html>
