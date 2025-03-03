    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{(route('cash.withdrawal.form'))}}">Withdraw</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    {{-- <li class="nav-item">
                        <a class="nav-link" href="{{ route('outlet-login/aeps.form') }}">Log iN</a>
                    </li> --}}
                   
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="{{route('balance.enquiry-form')}}">Balance Enquiry</a>
                    </li>
                 
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('balance.statement')}}">Mini Statement</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('aeps.history')}}">History</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('outlet-log')}}">Outlet Status</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('customer/dashboard')}}">Exit</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>