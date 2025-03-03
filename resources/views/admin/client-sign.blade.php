<!DOCTYPE html>  
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Z Pay - Create an Account</title>
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
            <img src="{{ asset('assets/img/icons/abhipaym.jpg') }}" alt="Z Pay Logo">
            <div class="brand-name">Z Pay</div>
            <div class="welcome-message">Welcome to ZPay</div>
        </div>
        <!-- Form Title -->
        <h1 class="form-title">User Registration Form</h1>
        @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    
        <!-- Registration Form -->
        <form action="{{ route('admin.client.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="mobile" class="form-label">Mobile No (as per Aadhar Link)</label>
                <input type="text" class="form-control" value=""  name="mobile" placeholder="Enter Mobile No" maxlength="10" required>
            </div>
            <!-- Name -->
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" required>
            </div>

            <!-- Shop Name -->
            <div class="mb-3">
                <label for="shop_name" class="form-label">Shop Name</label>
                <input type="text" class="form-control" id="shop_name" name="shop_name" placeholder="Enter Shop Name" required>
            </div>

            <!-- Mobile Number -->
           

            <!-- Email ID -->
            <div class="mb-3">
                <label for="email" class="form-label">Email ID</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email ID" required>
            </div>

            <!-- Address (As per Aadhar) -->
            {{-- <div class="mb-3">
                <label for="address" class="form-label">Address (As per Aadhar)</label>
                <input type="text" class="form-control" id="address" name="address" placeholder="Full Address" required>
                <div class="row mt-2">
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="city" placeholder="City" required>
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="state" placeholder="State" required>
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="pincode" placeholder="PIN Code" required>
                    </div>
                </div>
            </div> --}}

            <!-- Aadhar Number & Upload -->
            {{-- <div class="mb-3">
                <label for="aadhar" class="form-label">Aadhar No</label>
                <input type="text" class="form-control" id="aadhar" name="aadhar" placeholder="Enter Aadhar No" maxlength="12" required>
                <label class="form-label mt-2">Upload Aadhar Front & Back</label>
                <input type="file" class="form-control mb-2" name="aadhar_front" accept="image/*" required>
                <input type="file" class="form-control" name="aadhar_back" accept="image/*" required>
            </div> --}}

            <!-- PAN Number & Upload -->
            {{-- <div class="mb-3">
                <label for="pan" class="form-label">PAN No</label>
                <input type="text" class="form-control" id="pan" name="pan" placeholder="Enter PAN No" maxlength="10" required>
                <label class="form-label mt-2">Upload PAN Image</label>
                <input type="file" class="form-control" name="pan_image" accept="image/*" required>
            </div> --}}

            <!-- Bank Details -->
            {{-- <div class="mb-3">
                <label for="account_no" class="form-label">Bank Account Details</label>
                <input type="text" class="form-control mb-2" name="account_no" placeholder="Account Number" required>
                <input type="text" class="form-control mb-2" name="ifsc" placeholder="IFSC Code" required>
                <input type="text" class="form-control mb-2" name="bank_name" placeholder="Bank Name" required>
                <label class="form-label mt-2">Upload Passbook / Cheque / Bank Statement</label>
                <input type="file" class="form-control" name="bank_image" accept="image/*" required>
            </div> --}}

            <!-- Password -->
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" required>
            </div>

            <!-- Confirm Password -->
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" required>
            </div>
  <!-- Balance -->
                    
          <input type="number" hidden class="form-control" value="0" id="balance" name="balance" placeholder="Enter Balance" required>
          <input type="text" hidden class="form-control" value="Retailer" id="balance" name="role" placeholder="Enter Balance" required>
            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary w-100">Submit</button>
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
