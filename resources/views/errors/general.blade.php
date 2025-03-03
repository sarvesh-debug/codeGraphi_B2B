<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Something Went Wrong</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, #fcdce1, #696768);
            color: #ffffff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            overflow: hidden;
        }
        .container {
            text-align: center;
            background: rgba(255, 255, 255, 0.2);
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
            max-width: 500px;
        }
        h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
            animation: pulse 2s infinite;
        }
        p {
            font-size: 1.25rem;
            margin-bottom: 2rem;
        }
        .btn {
            display: inline-block;
            background-color: #ffffff;
            color: #e0b32f;
            padding: 0.75rem 1.5rem;
            text-decoration: none;
            font-size: 1rem;
            border-radius: 5px;
            transition: background 0.3s ease, transform 0.2s ease;
        }
        .btn:hover {
            background-color: #ffe5ec;
            transform: scale(1.05);
        }
        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.1);
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>😢 Oops! Something went wrong.</h1>
        <p>We’re working to fix this issue. Please try again later.</p>
       
    </div>
</body>
</html>
