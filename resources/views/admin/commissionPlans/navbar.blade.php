<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light p-3 m-2">
    <!-- <div class="container-fluid"> -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                {{-- <li class="nav-item">
                    <a class="nav-link" href="{{ route('outlet-login/aeps.form') }}">Log iN</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('commission-form')}}">Add Commission</a>
                </li>  --}}
                <li class="nav-item {{ request()->routeIs('commission-list') ? 'active' : '' }}">
                    <a class="nav-link" href="{{route('commission-list')}}"> Commission List </a>
                </li>
                <li class="nav-item {{ request()->routeIs('map-commission') ? 'active' : '' }}">
                    <a class="nav-link" href="{{route('map-commission')}}"> Map Commission List </a>
                </li>
                {{-- <li class="nav-item">
                    <a class="nav-link"  href="#">All Map Commission</a>
                </li> --}}
            </ul>
        </div>
    <!-- </div> -->
</nav>

<!-- Internal CSS -->
<style>
    .nav-item {
        transition: transform 0.3s ease; /* Subtle animation when hovering over the nav items */
    }

    .nav-item:hover {
        transform: translateY(-3px);
    }

    .nav-item.active .nav-link {
        /* background-color: #5CE1E6;  */
        background-color: #007bff; 
        padding: 8px 15px;
        color: white !important;
        border-radius: 5px;
        font-weight: bold;
    }

    .nav-item .nav-link {
        padding: 8px 15px; 
        font-size: 1rem;
        color: #000 !important;
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    .nav-item .nav-link:hover {
        /* background-color: #007bff; */
        color: white;
        border-radius: 5px;
    }

    .nav-link {
        transition: background-color 0.3s ease, color 0.3s ease;
    }
</style>
