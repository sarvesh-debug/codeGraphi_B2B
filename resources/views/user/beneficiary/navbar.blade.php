<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('remitter.query.form') }}">Sender Register</a>
                </li>
                
                {{-- <li class="nav-item">
                    <a class="nav-link" href="{{ route('register.form') }}">Register Beneficiary</a>
                </li> --}}
                {{-- <li class="nav-item">
                    <a class="nav-link" href="{{ route('delete.form') }}">Delete Beneficiary</a>
                </li> --}}
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('fetch.form') }}">Transfer Money</a>
                </li>
                {{-- <li class="nav-item">
                    <a class="nav-link" href="{{ route('fetch.beneid.form') }}">Fetch by Bene ID</a>
                </li> --}}
                {{-- <li class="nav-item">
                    <a class="nav-link" href="{{ route('transact.form') }}"> <b>Money Transfer </b></a>
                </li> --}}
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('transact.formStatus') }}">Transation Status</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('refunddmt.form') }}">Refund</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dmtps.history') }}">History</a>
            </li>
                
            </ul>
        </div>
    </div>
</nav>
