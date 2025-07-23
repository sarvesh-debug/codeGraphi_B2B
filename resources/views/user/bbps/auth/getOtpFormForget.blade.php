<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CodeGraphi OTP Verification</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            color: #fff;
        }
        .otp-container {
            background: #ffffff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            text-align: center;
            max-width: 400px;
            width: 100%;
            color: #333;
        }
        .otp-container img {
            max-width: 100px;
            margin-bottom: 20px;
            border-radius: 50%;
        }
        .otp-container h2 {
            margin-bottom: 15px;
            font-size: 24px;
            font-weight: bold;
            color: #444;
        }
        .otp-container p {
            font-size: 16px;
            color: #666;
            margin-bottom: 25px;
        }
        .otp-input input {
            width: 100%;
            height: 60px;
            font-size: 24px;
            text-align: center;
            border: 2px solid #ddd;
            border-radius: 10px;
            outline: none;
            transition: all 0.3s;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .otp-input input:focus {
            border-color: #6a11cb;
            box-shadow: 0 0 8px rgba(106, 17, 203, 0.5);
        }
        .btn {
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            color: #fff;
            border: none;
            padding: 12px 25px;
            border-radius: 25px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .btn:hover {
            background: linear-gradient(135deg, #2575fc, #6a11cb);
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
        }
        .resend-link {
            margin-top: 15px;
            font-size: 14px;
        }
        .resend-link a {
            color: #6a11cb;
            text-decoration: none;
            font-weight: bold;
        }
        .resend-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    {{-- {{ route('forgetPassworsAuth') }} --}}
    <div class="otp-container">
        <img src="{{ asset('assets/img/icons/favicon.png') }}" alt="code graphi logo">
        <h1>CodeGraphi</h1>
        <h2>OTP Forget Password</h2>
        <p>We have sent an OTP to your Contact No <strong>{{ $mobile }}</strong>. Please enter it below.</p>
        <form id="otpForm" action="{{ route('forgetPassworsAuth') }}" method="POST">
            @csrf
            <div class="otp-input">
                <input type="text" maxlength="6" name="otp" required>
                <input type="text"hidden name="mobile" value="{{$mobile}}">
            </div>
            <button type="submit" class="btn">Verify OTP</button>
        </form>
        <div class="resend-link">
            Didn't receive the OTP? <a href="#">Resend</a>
        </div>
    </div>
</body>
</html>
