<!DOCTYPE html>  
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CodeGraphi - Create an Account</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5f5f5;
            color: #333333;
            font-family: 'Roboto', sans-serif;
        }
 .brand-logo {
            text-align: center;
            margin-bottom: 20px;
        }

        .brand-logo img {
            max-width: 100px;
        }

        .brand-name {
            font-size: 24px;
            font-weight: bold;
            color: #00bcd4;
            margin-top: 10px;
        }
        .form-container {
            max-width: 600px;
            width: 100%;
            background: #ffffff;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
            margin: 50px auto;
        }

        .form-title {
            font-size: 28px;
            font-weight: bold;
            color: #00bcd4;
            text-align: center;
            margin-bottom: 30px;
        }

        .btn-primary {
            background-color: #00bcd4;
            border: none;
            transition: background-color 0.3s;
        }

        .btn-primary:hover {
            background-color: #0097a7;
        }
    </style>
</head>
<body>
    <div class="form-container">
         <div class="brand-logo">
            <img src="{{ asset('assets/img/icons/codegraphi-logo.png') }}" alt="CodeGraphi Logo">
            <div class="brand-name">CodeGraphi</div>
            <div class="welcome-message">Welcome to CodeGraphi</div>
        </div>
        <!-- Form Title -->
        <h1 class="form-title">Registration OTP</h1>

        <!-- Registration Form -->
        <form action="{{ route('verfy-retailer') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Mobile Number -->
            <div class="mb-3">
                <label for="mobile" class="form-label">Mobile No (as per Aadhar Link)</label>
                <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Enter Mobile No" maxlength="10" required>
                @if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary w-100">Get OTP</button>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
     <script>
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const icon = field.nextElementSibling.querySelector('i');
            if (field.type === 'password') {
                field.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                field.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
    </script>
</body>
</html>
