<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light p-3 m-2">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item {{ request()->routeIs('cash.withdrawal.form') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('cash.withdrawal.form') }}">Withdraw</a>
            </li>
            {{-- <li class="nav-item {{ request()->routeIs('aepsCashDeposit.form') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('aepsCashDeposit.form') }}">Deposit</a>
            </li> --}}
            <li class="nav-item {{ request()->routeIs('balance.enquiry-form') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('balance.enquiry-form') }}">Balance Enquiry</a>
            </li>

            <li class="nav-item {{ request()->routeIs('balance.statement') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('balance.statement') }}">Mini Statement</a>
            </li>

            <li class="nav-item {{ request()->routeIs('aeps.history') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('aeps.history') }}">History</a>
            </li>

            {{-- <li class="nav-item {{ request()->routeIs('outlet-log') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('outlet-log') }}">Outlet Status</a>
            </li> --}}

            <li class="nav-item {{ request()->routeIs('customer/dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('customer/dashboard') }}">Exit</a>
            </li>
        </ul>
    </div>
</nav>
