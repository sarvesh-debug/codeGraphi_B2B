<!DOCTYPE html>
<html lang="zxx">

<!-- Mirrored from storage.googleapis.com/theme-vessel-items/checking-sites/logdy-2-html/HTML/main/register-13.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 02 Mar 2025 12:38:30 GMT -->
<head>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
            new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        '../../../../../../www.googletagmanager.com/gtm5445.html?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-TAGCODE');</script>
    <!-- End Google Tag Manager -->
    <title>Zpay Register</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <!-- External CSS libraries -->
    <link type="text/css" rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="assets/fonts/font-awesome/css/font-awesome.min.css">
    <link type="text/css" rel="stylesheet" href="assets/fonts/flaticon/font/flaticon.css">

    <!-- Favicon icon -->
    <link rel="shortcut icon" href="assets/img/favicon.ico" type="image/x-icon" >

    <!-- Google fonts -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800%7CPoppins:400,500,700,800,900%7CRoboto:100,300,400,400i,500,700">
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@300;400;500;600;700;800;900&amp;display=swap" rel="stylesheet">

    <!-- Custom Stylesheet -->
    <link type="text/css" rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" type="text/css" id="style_sheet" href="assets/css/skins/default.css">

</head>
<body id="top">
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TAGCODE"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<div class="page_loader"></div>

<!-- Login 13 start -->
<div class="login-13">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 col-md-12 bg-img ">
                <div class="bg-img-inner">
                    <div class="info">
                        <div class="center">
                            <h1>Welcome To Zpay</h1>
                        </div>
                        <p>Z Pay is a B2B fintech app streamlining business transactions with services like BBPS, AEPS, and DMT. It ensures secure, efficient, and seamless financial operations with advanced features and integrations.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 form-info">
                <div class="form-section">
                    <div class="form-section-innner">
                        <div class="logo clearfix">
                            <a href="{{route('/verfy-retailer.form')}}">
                                <img src="{{asset('assets/img/logos/zpay logo.png')}}" alt="logo">
                            </a>
                        </div>
                        <h3>Create An Cccount</h3>
                        <div class="btn-section clearfix">
                            <a href="{{route('customer.login')}}" class="link-btn active btn-1 active-bg">Login</a>
                            <a href="{{route('/verfy-retailer.form')}}" class="link-btn btn-2 default-bg">Register</a>
                        </div>
                        <div class="login-inner-form">


                            <form action="{{ route('admin.client.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                
                               {{-- mobile --}}
                                <div class="form-group form-box">
                                    <input name="mobile" type="text" class="form-control" placeholder="Enter Mobile No" maxlength="10" required aria-label="Enter Mobile No">
                                    <i class="flaticon-user"></i>
                                </div>

                                {{-- Name --}}
                                <div class="form-group form-box">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" required aria-label="Enter Name">
                                    <i class="flaticon-mail-2"></i>
                                </div>

                                <!-- Shop Name -->
                                <div class="form-group form-box">
                                    <input type="text" class="form-control" id="shop_name" name="shop_name" placeholder="Enter Shop Name" required aria-label="Enter Shop Name">
                                    <i class="flaticon-mail-2"></i>
                                </div>

                                  <!-- Email ID -->
                                 <div class="form-group form-box">
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email ID" required required aria-label="Enter Email ID">
                                    <i class="flaticon-mail-2"></i>
                                </div>

                                <!-- Password -->
                                <div class="form-group form-box clearfix">
                                    <input type="password" class="form-control"  autocomplete="off" id="password" name="password" placeholder="Enter Password" required aria-label="Enter Password">
                                    <i class="flaticon-password"></i>
                                </div>

                                <!-- Confirm Password -->
                                <div class="form-group form-box clearfix">
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" required aria-label="Confirm Password">
                                    <i class="flaticon-password"></i>
                                </div>


                                  <!-- Shop Name2 -->
                                  {{-- <div class="form-group form-box">
                                    <input type="text" class="form-control" id="shop_name" name="shop_name" placeholder="Enter Shop Name" required aria-label="Enter Shop Name">
                                    <i class="flaticon-mail-2"></i>
                                </div> --}}

                                 <!-- Balance -->


                                <div class="form-group checkbox clearfix">
                                    <div class="clearfix float-start">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="rememberme">
                                            <label class="form-check-label" for="rememberme">
                                                I agree to the terms of service
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-lg btn-theme">Register</button>
                                </div>

                                <input type="number" hidden class="form-control" value="0" id="balance" name="balance" placeholder="Enter Balance" required>
                                <input type="text" hidden class="form-control" value="Retailer" id="balance" name="role" placeholder="Enter Balance" required>

                            </form>
                        </div>
                        {{-- <ul class="social-list">
                            <li><a href="#" class="facebook-color"><i class="fa fa-facebook facebook-i"></i><span>Facebook</span></a></li>
                            <li><a href="#" class="twitter-color"><i class="fa fa-twitter twitter-i"></i><span>Twitter</span></a></li>
                            <li><a href="#" class="google-color"><i class="fa fa-google google-i"></i><span>Google</span></a></li>
                        </ul> --}}
                        <p class="none-2">Already a member?<a href="{{route('customer.login')}}" class="thembo">Login here</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Login 13 end -->

<!-- External JS libraries -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>

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

<!-- Custom JS Script -->
</body>

<!-- Mirrored from storage.googleapis.com/theme-vessel-items/checking-sites/logdy-2-html/HTML/main/register-13.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 02 Mar 2025 12:38:30 GMT -->
</html>