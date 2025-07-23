<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Temporarily Unavailable – Please Try Again</title>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600;800&display=swap" rel="stylesheet">

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #1f1c2c, #928dab);
      color: #fff;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
    }

    .error-container {
      background-color: rgba(255, 255, 255, 0.05);
      border: 1px solid rgba(255, 255, 255, 0.1);
      border-radius: 16px;
      padding: 40px;
      text-align: center;
      max-width: 600px;
      backdrop-filter: blur(10px);
      animation: fadeIn 1s ease-in-out;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.4);
    }

    .error-image {
      max-width: 250px;
      margin-bottom: 25px;
    }

    h1 {
      font-size: 36px;
      font-weight: 800;
      color: #ff4e50;
      margin-bottom: 15px;
      text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.5);
    }

    p {
      font-size: 18px;
      color: #e0e0e0;
      margin-bottom: 30px;
    }

    .btn {
      padding: 12px 30px;
      font-size: 16px;
      font-weight: 600;
      background: linear-gradient(135deg, #ff416c, #ff4b2b);
      color: #fff;
      border: none;
      border-radius: 30px;
      cursor: pointer;
      text-decoration: none;
      transition: all 0.3s ease;
    }

    .btn:hover {
      opacity: 0.9;
    }

    @keyframes fadeIn {
      0% { opacity: 0; transform: translateY(-20px); }
      100% { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 500px) {
      h1 { font-size: 26px; }
      p  { font-size: 16px; }
    }
  </style>
</head>
<body>

  <div class="error-container">
    <img src="https://cdn.dribbble.com/users/285475/screenshots/2083086/dribbble_1.gif" alt="500 Error" class="error-image">
   <h1>Hang Tight, We're Fixing It!</h1>
    <p>We're facing some technical issues.<br>Please hang tight while we fix it.</p>
    <button class="btn" onclick="history.back()">← Go Back</button>
  </div>

</body>
</html>
