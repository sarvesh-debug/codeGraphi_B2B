@extends('admin/include.layout')

@php
use Illuminate\Support\Facades\DB;

$distibutor = \App\Models\CustomerModel::where('role', 'distibuter')->count();
$sd = \App\Models\CustomerModel::where('role', 'sd')->count();
$retailer = \App\Models\CustomerModel::where('role', 'Retailer')->count();
$userTotal = $retailer + $distibutor;

$amtDistributor = \App\Models\CustomerModel::where('role', 'distibuter')->sum('balance');
$amtSd = \App\Models\CustomerModel::where('role', 'sd')->sum('balance');
$amtRetailer = \App\Models\CustomerModel::where('role', 'Retailer')->sum('balance');
$userTotalAmt = $amtDistributor + $amtRetailer;

$acceptAmt = DB::table('add_moneys')->where('status', 1)->where('date', today())->sum('amount');
$rejectAmt = DB::table('add_moneys')->where('status', -1)->where('date', today())->sum('amount');
$pendingAmt = DB::table('add_moneys')->where('status', 0)->where('date', today())->sum('amount');

$acceptCnt = DB::table('add_moneys')->where('status', 1)->where('date', today())->count('amount');
$rejectCnt = DB::table('add_moneys')->where('status', -1)->where('date', today())->count('amount');
$pendingCnt = DB::table('add_moneys')->where('status', 0)->where('date', today())->count('amount');

$DMTvalueAll = 0;
$countDMT = 0;
$transactionsDMT = DB::table('transactions_dmt_instant_pay')->whereDate('created_at', today())->get();
foreach ($transactionsDMT as $transaction) {
    $responseData = json_decode($transaction->response_data, true);
    if (($responseData['statuscode'] ?? '') === 'TXN') {
        $DMTvalueAll += (float)($responseData['data']['txnValue'] ?? 0);
        $countDMT++;
    }
}

$valueAll = 0;
$countAEPS = 0;
$cashWithdrawals = DB::table('cash_withdrawals')->whereDate('created_at', today())->get();
foreach ($cashWithdrawals as $withdrawal) {
    $responseData = json_decode($withdrawal->response_data, true);
    if (($responseData['statuscode'] ?? '') === 'TXN') {
        $valueAll += (float)($responseData['data']['transactionValue'] ?? 0);
        $countAEPS++;
    }
}

$bbpsvalueAll = 0;
$countbbpa = 0;
$bbpsTransactions = DB::table('utility_payments')->whereDate('created_at', today())->get();
foreach ($bbpsTransactions as $transaction) {
    $responseData = json_decode($transaction->response_body, true);
    if (isset($responseData['statuscode']) && in_array($responseData['statuscode'], ['TXN', 'TUP'])) {
        $bbpsvalueAll += (float)($responseData['respose']['data']['txnValue'] ?? 0);
        $countbbpa++;
    }
}

$tpayout = DB::table('cgpayout')->where('status', 'CREDITED')->whereDate('created_at', today())->sum('amount');
@endphp

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<style>
    .kpi-card {
        border-radius: 10px;
        padding: 20px;
        color: white;
        box-shadow: 0 0 12px rgba(0,0,0,0.1);
        text-align: center;
    }
    .kpi-title {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 10px;
        text-transform: uppercase;
    }
    .kpi-value {
        font-size: 24px;
        font-weight: bold;
    }
    .card-chart {
        padding: 25px;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.05);
    }
</style>

<div class="container mt-4">

    {{-- 🔹 KPI Summary --}}
    <div class="row mb-4">
        <div class="col-md-3"><div class="kpi-card bg-primary"><div class="kpi-title">AEPS</div><div class="kpi-value">₹ {{ $valueAll }}</div></div></div>
        <div class="col-md-3"><div class="kpi-card bg-success"><div class="kpi-title">DMT</div><div class="kpi-value">₹ {{ $DMTvalueAll }}</div></div></div>
        <div class="col-md-3"><div class="kpi-card bg-warning"><div class="kpi-title">BBPS</div><div class="kpi-value">₹ {{ $bbpsvalueAll }}</div></div></div>
        <div class="col-md-3"><div class="kpi-card bg-danger"><div class="kpi-title">Payout</div><div class="kpi-value">₹ {{ $tpayout }}</div></div></div>
    </div>

    {{-- 🔹 Summary Tables --}}
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card-chart">
                <h5 class="mb-3">User Wallet Balances</h5>
                <table class="table table-sm table-striped">
                    <thead><tr><th>Role</th><th>Amount (₹)</th></tr></thead>
                    <tbody>
                        <tr><td>Distributors</td><td>{{ $amtDistributor }}</td></tr>
                        <tr><td>Super Distributors</td><td>{{ $amtSd }}</td></tr>
                        <tr><td>Retailers</td><td>{{ $amtRetailer }}</td></tr>
                        <tr class="table-light"><th>Total</th><th>{{ $userTotalAmt }}</th></tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card-chart">
                <h5 class="mb-3">Payment Request Summary</h5>
                <table class="table table-sm table-bordered">
                    <thead><tr><th>Status</th><th>Amount</th><th>Count</th></tr></thead>
                    <tbody>
                        <tr><td>Accepted</td><td>₹ {{ $acceptAmt }}</td><td>{{ $acceptCnt }}</td></tr>
                        <tr><td>Pending</td><td>₹ {{ $pendingAmt }}</td><td>{{ $pendingCnt }}</td></tr>
                        <tr><td>Rejected</td><td>₹ {{ $rejectAmt }}</td><td>{{ $rejectCnt }}</td></tr>
                        <tr class="table-primary"><th>Total</th><th>₹ {{ $acceptAmt + $pendingAmt + $rejectAmt }}</th><th>{{ $acceptCnt + $pendingCnt + $rejectCnt }}</th></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- 🔹 User Summary Table --}}
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card-chart">
                <h5 class="mb-3">User Summary by Role, Status & KYC</h5>

                @php
                    $roles = ['Retailer', 'distibuter', 'sd','rm'];
                    $roleLabels = [
                        'Retailer' => 'Retailers',
                        'distibuter' => 'Distributors',
                        'sd' => 'Super Distributors',
                        'rm' => 'Relationship Managers'
                    ];
                @endphp

                <table class="table table-bordered table-sm">
                    <thead>
                        <tr>
                            <th>Role</th>
                            <th>Total Users</th>
                            <th>Active</th>
                            <th>Deactive</th>
                            <th data-bs-toggle="tooltip" title="Users whose PIN is greater than 0">KYC Completed</th>
                            <th data-bs-toggle="tooltip" title="Users whose PIN is 0 or not set">KYC Pending</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($roles as $role)
                            @php
                                $users = \App\Models\CustomerModel::where('role', $role);
                                $total = $users->count();
                                $active = $users->where('status', 'active')->count();
                        
                                $kycCompleted = $users->where('pin', '!=', 0)->count();
                                $kycPending = $total - $kycCompleted;
                                $kycPercent = $total > 0 ? round(($kycCompleted / $total) * 100) : 0;
                            @endphp
                            <tr>
                                <td>{{ $roleLabels[$role] }}</td>
                                <td>{{ $total }}</td>
                                <td>{{ $active }}</td>
                                <td>{{ $total-$active }}</td>
                                <td>
                                    {{ $kycCompleted }}
                                    <div class="progress" style="height: 6px;">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $kycPercent }}%;"></div>
                                    </div>
                                </td>
                                <td>{{ $kycPending }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- 🔹 Charts --}}
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card-chart">
                <h5 class="mb-3">Transaction Overview</h5>
                <canvas id="serviceChart"></canvas>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card-chart">
                <h5 class="mb-3">KYC Completion Chart</h5>
                <canvas id="kycPieChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
    // Tooltip activation
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    tooltipTriggerList.map(function (el) {
        return new bootstrap.Tooltip(el)
    })

    // Bar chart
    new Chart(document.getElementById('serviceChart'), {
        type: 'bar',
        data: {
            labels: ['AEPS', 'DMT', 'BBPS', 'Payout'],
            datasets: [{
                label: 'Transaction ₹',
                data: [{{ $valueAll }}, {{ $DMTvalueAll }}, {{ $bbpsvalueAll }}, {{ $tpayout }}],
                backgroundColor: ['#007bff', '#28a745', '#ffc107', '#dc3545']
            }]
        },
        options: {
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });

    // KYC Pie chart
    new Chart(document.getElementById('kycPieChart'), {
        type: 'pie',
        data: {
            labels: ['Retailers', 'Distributors', 'Super Distributors'],
            datasets: [{
                data: [
                    {{ \App\Models\CustomerModel::where('role', 'Retailer')->where('pin', '>', 0)->count() }},
                    {{ \App\Models\CustomerModel::where('role', 'distibuter')->where('pin', '>', 0)->count() }},
                    {{ \App\Models\CustomerModel::where('role', 'sd')->where('pin', '>', 0)->count() }}
                ],
                backgroundColor: ['#17a2b8', '#ffc107', '#28a745']
            }]
        }
    });
</script>
@endsection
