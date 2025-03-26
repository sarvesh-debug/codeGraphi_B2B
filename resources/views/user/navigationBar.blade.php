<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<!-- Bottom Navigation Bar -->
<nav class="navbar fixed-bottom navbar-light bg-white border-top d-md-none" class="mt-5">
    <div class="container d-flex justify-content-around">
        <a href="{{route('customer/dashboard')}}" class="text-gray text-center">
            <i class="fa-solid fa-house fs-4"></i>
            <div class="small">Home</div>
        </a>
        <a href="{{route('customer/dashboard')}}" class="text-gray text-center">
            <i class="fa-solid fa-th fs-4"></i>
            <div class="small">Services</div>
        </a>
        <a href="{{route('/user/fund-transfer/bank-account')}}" class="text-gray text-center">
            <i class="fa-solid fa-wallet fs-4"></i>
            <div class="small">Wallet</div>
        </a>
        <a href="#" class="text-gray text-center">
            <i class="fa-solid fa-headset fs-4"></i>
            <div class="small">Help</div>
        </a>
    </div>
</nav>


{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<!-- Bottom Navigation Bar -->
<nav class="navbar fixed-bottom navbar-light bg-white border-top d-md-none mt-7">
    <div class="container d-flex justify-content-around">
        <a href="{{route('customer/dashboard')}}" class="text-gray text-center">
            <i class="fa-solid fa-house fs-4"></i>
            <div class="small">Home</div>
        </a>
        <a href="{{route('customer/dashboard')}}" class="text-gray text-center">
            <i class="fa-solid fa-th fs-4"></i>
            <div class="small">Services</div>
        </a>
        <a href="{{route('/user/fund-transfer/bank-account')}}" class="text-gray text-center">
            <i class="fa-solid fa-wallet fs-4"></i>
            <div class="small">Wallet</div>
        </a>
        <a href="#" class="text-gray text-center">
            <i class="fa-solid fa-headset fs-4"></i>
            <div class="small">Help</div>
        </a>
    </div>
</nav> --}}



{{-- <!-- Include FontAwesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<!-- Bottom Navigation Bar -->
<nav class="navbar fixed-bottom navbar-light bg-white border-top d-md-none mt-5">
    <div class="container d-flex justify-content-around">
        <a href="{{route('customer/dashboard')}}" class="text-gray text-center">
            <i class="fa-solid fa-house fs-4"></i>
            <div class="small">Home</div>
        </a>
        <a href="{{route('customer/dashboard')}}" class="text-gray text-center">
            <i class="fa-solid fa-th fs-4"></i>
            <div class="small">Services</div>
        </a>
        <a href="{{route('/user/fund-transfer/bank-account')}}" class="text-gray text-center">
            <i class="fa-solid fa-wallet fs-4"></i>
            <div class="small">Wallet</div>
        </a>
        <a href="#" class="text-gray text-center" id="helpBtn">
            <i class="fa-solid fa-headset fs-4"></i>
            <div class="small">Help</div>
        </a>
    </div>
</nav>

<!-- Help Text (Initially Hidden) -->
<div id="helpText" class="text-center mt-2 d-none">
    <p class="text-muted">How can we help you?</p>
</div>

<!-- JavaScript for Show/Hide Text -->
<script>
    document.getElementById("helpBtn").addEventListener("click", function(event) {
        event.preventDefault(); // Prevent default anchor behavior
        let helpText = document.getElementById("helpText");
        helpText.classList.remove("d-none"); // Show text
    });
</script> --}}
