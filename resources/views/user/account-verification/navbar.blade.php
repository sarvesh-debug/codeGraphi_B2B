<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Merchant Onboarding</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('verify.bank.account') }}">Bank List</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('account-form') }}">Verify Bank Account</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('upiform')}}">Verify UPI Handle (VPA)</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
