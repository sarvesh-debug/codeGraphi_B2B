<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invalid OTP</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            border-radius: 8px;
        }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-danger text-white text-center py-3">
                    <h4 class="mb-0">Invalid OTP</h4>
                </div>
                <div class="card-body text-center p-4">
                    <p class="text-muted mb-4">
                        The OTP you entered is invalid. Please try again.
                    </p>
                    <a href="https://CodeGraphi.com/" class="btn btn-secondary w-100 mb-3">
                        Go Back to Login
                    </a>
                    {{-- <a href="/otp/resend" class="btn btn-success w-100">
                        Request New OTP
                    </a> --}}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
