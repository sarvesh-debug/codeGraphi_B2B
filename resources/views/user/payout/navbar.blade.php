    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="">Payout</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('payout.form')}}">Bank Account
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('payout.card')}}">Credit Cards
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('payoutBank.list')}}">Bank List
                        </a>
                    </li>
                   
                  
                </ul>
            </div>
        </div>
    </nav>