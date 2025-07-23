@extends('admin/include.layout')

@section('content')
<div class="container-fluid px-4">
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active">Ledger</li>
    </ol>

    <!-- Transaction Summary Section -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Total Transactions</h5>
                    <p class="card-text">₹ {{ $totalAmount ?? 0 }}</p>
                </div>
            </div>
        </div>
        @foreach ($individualTotals as $source => $amount)
        <div class="col-md-3 my-1">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">{{ ucwords(str_replace('_', ' ', $source)) }}</h5>
                    <p class="card-text">₹ {{ $amount }}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Search and Export Section -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('laser.statement') }}" method="GET" class="form-inline">
                <div class="row align-items-center">
                    <div class="col-md-3">
                        <input type="text" class="form-control" id="searchBox" placeholder="Search here...">
                    </div>
                    <div class="col-md-3 d-flex justify-content-end">
                        <button type="button" class="btn btn-success" id="exportExcel">Export Excel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Table with Fixed Header -->
    <div class="card-body p-0" style="overflow-x: auto;">
        <div style="max-height: 500px; overflow-y: auto;">
            <table id="ledgerTable" class="table table-hover table-striped table-bordered align-middle text-center shadow-sm rounded m-0">
                <thead class="table-success sticky-top" style="z-index: 1000;">
                    <tr>
                        <th>#</th>
                        <th>Date Time</th>
                        <th>Retailer ID</th>
                        <th>Retailer Name</th>
                        <th>TXN No</th>
                        <th>Services</th>
                        <th>Transaction Ref</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Opening Bal</th>
                        <th>Credit</th>
                        <th>TDS</th>
                        <th>Debit</th>
                        <th>Charges</th>
                        <th>Commission</th>
                        <th>Balance</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transactions as $index => $transaction)
                    <tr>
                        <td>{{ $loop->count - $loop->iteration + 1 }}</td>
                        <td>{{ $transaction['timestamp'] }}</td>
                        <td>{{ $transaction['username'] }}</td>
                        <td>{{ $transaction['name'] }}</td>
                        <td>{{ $transaction['trans_id'] }}</td>
                        <td>{{ $transaction['source'] }}</td>
                        <td>{{ $transaction['ext_ref'] }}</td>
                        <td>{{ $transaction['desc'] }}</td>
                        @php
                            $status = strtolower($transaction['status'] ?? 'unknown');
                            switch ($status) {
                                case 'success': $color = 'text-success'; break;
                                case 'pending': $color = 'text-warning'; break;
                                case 'failed':  $color = 'text-danger';  break;
                                default:        $color = 'text-muted';   break;
                            }
                        @endphp
                        <td class="{{ $color }}"><strong>{{ strtoupper($status) }}</strong></td>
                        <td>₹{{ $transaction['openingB'] }}</td>
                        <td class="text-success"><strong>₹{{ $transaction['credit'] }}</strong></td>
                        <td class="text-danger"><strong>₹{{ $transaction['tds'] }}</strong></td>
                        <td class="text-danger"><strong>₹{{ $transaction['debit'] }}</strong></td>
                        <td class="text-danger"><strong>₹{{ $transaction['charges'] }}</strong></td>
                        <td class="text-success"><strong>₹{{ $transaction['commission'] }}</strong></td>
                        <td><strong>₹{{ $transaction['clsoingB'] }}</strong></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="16" class="text-center text-muted">No transactions found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- SheetJS (xlsx) CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

<!-- Custom JavaScript -->
<script>
    // Export to Excel
    document.getElementById('exportExcel').addEventListener('click', function () {
        const table = document.getElementById('ledgerTable');
        const wb = XLSX.utils.table_to_book(table, { sheet: "Ledger" });
        XLSX.writeFile(wb, 'transactions.xlsx');
    });

    // Simple table search
    document.getElementById('searchBox').addEventListener('keyup', function () {
        const searchValue = this.value.toLowerCase();
        const rows = document.querySelectorAll('#ledgerTable tbody tr');

        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchValue) ? '' : 'none';
        });
    });
</script>

<!-- Optional Custom Styling -->
<style>
    thead.sticky-top th {
        background-color: #d1e7dd !important; /* Ensures header color remains during scroll */
        position: sticky;
        top: 0;
    }
</style>
@endsection
