@extends('user/include.layout')

@section('content')
<div class="container-fluid px-4">

    <ol class="breadcrumb mb-4 mt-3">
        <li class="breadcrumb-item"><a href="{{ route('customer/dashboard') }}">Home</a></li>
        <li class="breadcrumb-item active">Transactions DMT2</li>
    </ol>

    @if($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3>Transaction List</h3>
            <form method="GET" action="{{ route('dmtps.history') }}" class="row g-3">
                <div class="col-md-4 col-12">
                    <label for="start_date" class="form-label">Start Date</label>
                    <input type="date" name="start_date" id="start_date" class="form-control" value="{{ request('start_date') }}">
                </div>
                <div class="col-md-4 col-12">
                    <label for="end_date" class="form-label">End Date</label>
                    <input type="date" name="end_date" id="end_date" class="form-control" value="{{ request('end_date') }}">
                </div>
                <div class="col-md-4 col-12 d-flex align-items-end ">
                    <button type="submit" class="btn btn-primary w-100 p-2">Filter</button>
                </div>
            </form>
            <div class="mt-3 text-end">
                <button id="exportBtn" class="btn btn-success">Export to Excel</button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="transactionTable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Mobile</th>
                            <th>Reference ID</th>
                            <th>Ackno</th>
                            <th>Status</th>
                            <th>Amount</th>
                            <th>Opening</th>
                            <th>Closing</th>
                            <th>UTR</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $transaction)
                        @php
                        $responseData = json_decode($transaction->response_data, true);
                        @endphp
                            <tr>
                                <td>{{ $transaction->id }}</td>
                                <td>{{ $transaction->mobile }}</td>
                                <td>{{ $transaction->referenceid }}</td>
                                <td>{{ $responseData['ackno'] ?? 'N/A' }}</td>
                                <td>{{ $responseData['status'] ? 'Success' : 'Failed' }}</td>
                                <td>{{ $responseData['txn_amount'] ?? 'N/A' }}</td>
                                <td>₹{{ number_format($transaction->opening_balance, 2) }}</td>
                                <td>₹{{ number_format($transaction->closing_balance, 2) }}</td>
                                <td>{{ $responseData['utr'] ?? 'N/A' }}</td>
                                <td>{{ $transaction->created_at }}</td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#responseModal{{ $transaction->id }}">
                                        View Response
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/xlsx/dist/xlsx.full.min.js"></script>
<script>
    document.getElementById('exportBtn').addEventListener('click', function () {
        // Get the table
        let table = document.getElementById('transactionTable');
        let workbook = XLSX.utils.table_to_book(table, { sheet: "Sheet1" });
        
        // Export to Excel
        XLSX.writeFile(workbook, 'TransactionData.xlsx');
    });
</script>
@endsection
