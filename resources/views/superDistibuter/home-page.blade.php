@extends('superDistibuter/include.layout') 
@section('custom-css')
<style>
    /* Services Icon Styling */
    .services-icon {
        width: 40%;
        transition: transform 0.3s ease-in-out;
    }
    .services-icon:hover {
        transform: scale(1.1);
    }

    /* Card Styling */
    .card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: box-shadow 0.3s ease-in-out, transform 0.3s ease-in-out;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 15px rgba(0, 0, 0, 0.2);
    }

    .card-body {
        padding: 1.5rem;
    }

    /* Card Title */
    .card-title {
        font-size: 1.1rem;
        margin-top: 0.75rem;
        font-weight: bold;
        text-transform: uppercase;
    }

    /* Card Text */
    .card-text {
        font-size: 0.9rem;
        color: #555;
    }

    /* 3-Card Row for Larger Screens */
    @media(min-width: 768px) {
        .card-group .card {
            margin-bottom: 1.5rem;
        }
        .card-group .col-lg-4 {
            padding-left: 10px;
            padding-right: 10px;
        }
    }

    /* Graph and Stats Section */
    .canava-graph {
        width: 100%;
        height: auto;
    }

    .statistics p {
        font-size: 1rem;
        font-weight: 500;
    }
</style>
@endsection

@section('content')
<div class="container mt-4">
    <div class="row">
        <h1>Welcome to Distibuter Page</h1>
        <!-- Left Section for Service Cards -->
        <div class="col-md-6 col-lg-9">
            <div class="row card-group">
                <!-- First Card Row -->
                <div class="col-lg-4 mb-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <a href="{{route('admin/reports/aeps')}}">
                                <img class="services-icon" src="{{ asset('assets/img/icons/aeps.png') }}" alt="AEPS">
                                <h5 class="card-title">AEPS</h5>
                                <p class="card-text">Today Volume: 0</p>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- <div class="col-lg-4 mb-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <a href="{{route('admin/reports/credit-card-bill-payment')}}">
                                <img class="services-icon" src="{{ asset('assets/img/icons/bbps.png') }}" alt="BBPS">
                                <h5 class="card-title">BBPS</h5>
                                <p class="card-text">Today Volume: 0</p>
                            </a>
                        </div>
                    </div>
                </div> --}}

                <div class="col-lg-4 mb-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <a href="{{route('admin/reports/dmt-payment')}}">
                                <img class="services-icon" src="{{ asset('assets/img/icons/personal_loan.png') }}" alt="DMT">
                                <h5 class="card-title">DMT</h5>
                                <p class="card-text">Today Volume: 0</p>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Second Card Row -->
                {{-- <div class="col-lg-4 mb-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <a href="{{route('admin/reports/mobile-recharge')}}">
                                <img class="services-icon" src="{{ asset('assets/img/icons/mobile_recharge.png') }}" alt="Recharge">
                                <h5 class="card-title">Recharge</h5>
                                <p class="card-text">Today Volume: 0</p>
                            </a>
                        </div>
                    </div>
                </div> --}}

                {{-- <div class="col-lg-4 mb-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <a href="{{route('admin/user-list')}} ">
                                <img class="services-icon" src="{{ asset('assets/img/icons/user_management.png') }}" alt="User Management">
                                <h5 class="card-title">User Management</h5>
                                <p class="card-text">Today Volume: 0</p>
                            </a>
                        </div>
                    </div>
                </div> --}}

                <div class="col-lg-4 mb-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <a href="{{route('admin/reports/wallet-transfer')}}">
                                <img class="services-icon" src="{{ asset('assets/img/icons/wallet_to_wallet.png') }}" alt="Wallet Enquiry">
                                <h5 class="card-title">Wallet Enquiry</h5>
                                <p class="card-text">Today Volume: 0</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Section for Transaction Chart and Stats -->
        <div class="col-md-6 col-lg-3">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Transaction Chart</h5>
                    <canvas id="transactionChart" class="canava-graph"></canvas>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Statistics</h5>
                    <p>Total Destibuter: 100</p>
                    <p>Total Retailer: 100</p>
                    <p>Total Wallet Amount: 25,293.89</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('transactionChart').getContext('2d');
    const transactionData = {
        labels: ['AEPS', 'Payout', 'DMT', 'CC Link','CC Bill Payments','Wallet Enquiry'],
        datasets: [{
            label: 'Transaction Distribution',
            data: [10, 9.9, 25.6, 73.8, 32.0],
            backgroundColor: ['#ff6384', '#36a2eb', '#ffcd56','#4bcb073', '#4bc072', '#9575cd']
        }]
    };
    const transactionChart = new Chart(ctx, {
        type: 'doughnut',
        data: transactionData
    });
</script>
@endsection
