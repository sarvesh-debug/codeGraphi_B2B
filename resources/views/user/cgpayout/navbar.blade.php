<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light p-3 m-2">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item {{ request()->routeIs('cusercg.verifyForm') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('usercg.verifyForm') }}">PayOut</a>
            </li>
            <li class="nav-item {{ request()->routeIs('payout.history') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('payout.history') }}">History</a>
            </li>
                   </ul>
    </div>
</nav>
