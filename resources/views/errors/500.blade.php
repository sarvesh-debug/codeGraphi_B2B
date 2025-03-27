<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 - Server Error</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
            color: #333;
            text-align: center;
            padding: 50px;
        }
        .error-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 40px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
            animation: fadeIn 1s ease-in-out;
        }
        .error-image {
            width: 100%;
            max-width: 300px;
            margin-bottom: 20px;
        }
        h1 {
            font-size: 28px;
            margin: 20px 0;
            color: #dc3545;
        }
        p {
            font-size: 18px;
            color: #666;
        }
        .btn {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 25px;
            font-size: 16px;
            font-weight: 600;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            transition: 0.3s ease-in-out;
        }
        .btn:hover {
            background-color: #0056b3;
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

    <div class="error-container">
        <img src="https://i.imgur.com/qIufhof.png" alt="500 Error" class="error-image">  
        <h1>Oops! Something went wrong.</h1>
        <p>We're facing some technical issues. Sorry for the inconvenience! We're working to resolve the issue as soon as possible.</p>
     
    </div>

</body>
</html>
