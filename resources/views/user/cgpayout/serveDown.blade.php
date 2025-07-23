<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Server Downtime</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      height: 100vh;
      background: linear-gradient(-45deg, #232526, #414345, #232526, #414345);
      background-size: 400% 400%;
      animation: bg-animation 12s ease infinite;
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      color: #fff;
      text-align: center;
      padding: 20px;
    }

    @keyframes bg-animation {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    h1 {
      font-size: 3rem;
      margin-bottom: 20px;
    }

    p {
      font-size: 1.2rem;
      max-width: 600px;
      line-height: 1.6;
    }

    .icon {
      font-size: 5rem;
      margin-bottom: 20px;
    }

    @media (max-width: 600px) {
      h1 {
        font-size: 2rem;
      }

      .icon {
        font-size: 3rem;
      }

      p {
        font-size: 1rem;
      }
    }
  </style>
</head>
<body>

  <div class="icon">⚠️</div>
  <h1>Server Downtime</h1>
  <p>Our servers are currently unavailable due to maintenance or a temporary issue.<br/>We’re working hard to restore service. Please check back soon.</p>

</body>
</html>
