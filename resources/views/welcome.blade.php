<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
    body {
        background: linear-gradient(45deg, #00111F, #00498D);
        color: #fff;
        font-family: 'Poppins', sans-serif;
        margin: 0;
        padding: 0;
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .wrapper {
        text-align: center;
        animation: fadeIn 1500ms ease-in-out;
    }

    h1 {
        font-size: 60px;
        font-weight: 700;
        margin-bottom: 0;
        text-shadow: 0 0 15px rgba(79, 235, 254, 0.8);
        letter-spacing: 2px;
    }

    .dot {
        color: #4FEBFE;
        text-shadow: 0 0 10px rgba(79, 235, 254, 0.6);
        animation: pulse 1s infinite alternate;
    }

    @keyframes pulse {
        from { transform: scale(1); opacity: 0.8; }
        to { transform: scale(1.2); opacity: 1; }
    }

    p {
        font-size: 18px;
        font-weight: 300;
        letter-spacing: 1px;
        margin: 20px 0;
    }

    .icons {
        margin-top: 20px;
    }

    .icons a {
        text-decoration: none;
        margin: 0 10px;
    }

    .icons i {
        color: #fff;
        background: #00498D;
        height: 50px;
        width: 50px;
        line-height: 50px;
        font-size: 24px;
        border-radius: 50%;
        border: 2px solid #4FEBFE;
        transition: all 0.4s ease;
    }

    .icons i:hover {
        background-color: #4FEBFE;
        color: #00498D;
        transform: rotate(360deg) scale(1.3);
        box-shadow: 0 0 20px rgba(79, 235, 254, 0.8);
    }
</style>

<div class="wrapper">
    <h1>Coming Soon<span class="dot">...</span></h1>
    <p>CodeGraphi Technology | B2B FinTech Solutions</p>
    <div class="icons">
        <a href="#"><i class="fa fa-instagram"></i></a>
        <a href="#"><i class="fa fa-youtube-play"></i></a>
        <a href="#"><i class="fa fa-linkedin"></i></a>
    </div>
</div>
