@extends('user/include.layout')

@section('content')
<div class="container-fluid lg:px-4 px-6 mb-5">
    @include('user.dmtinstantpay.navbar')
    <ol class="breadcrumb mb-4 m-4">
        <li class="breadcrumb-item"><a href="{{ route('customer/dashboard') }}">Home</a></li>
        <li class="breadcrumb-item active">Transactions</li>
    </ol>

    @if($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    <!-- Existing Filter Form -->
    <form method="GET" action="{{ route('transaction.history') }}" class="row mb-4 m-2">
        <div class="col-md-6 col-lg-5">
            <label for="start_date">Start Date</label>
            <input type="datetime-local" id="start_date" name="start_date" 
                   value="{{ request('start_date') }}" 
                   class="form-control">
        </div>
        <div class="col-md-6 col-lg-5">
            <label for="end_date">End Date</label>
            <input type="datetime-local" id="end_date" name="end_date" 
                   value="{{ request('end_date') }}" 
                   class="form-control">
        </div>
        <div class="col-12 col-lg-2 d-flex align-items-end">
            <button type="submit" class="btn btn-primary w-100 p-1.5 lg:mt-0 mt-2" style="background: linear-gradient(to right, #0a22aa, #b62512); color: white; border: none;">Filter</button>
        </div>
    </form>

    <div class="card m-2 mb-5">
        <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-center" style="background: linear-gradient(to right, #0a22aa, #b62512); color: white; border: none;">
            <h3 class="card-heading mb-3 mb-md-0 text-center text-md-start">Transaction List</h3>
            <button style="background: linear-gradient(to right, #0a22aa, #0a22aa); color: white; border: none;" id="exportTransactions" class="btn btn-download"> <i class="fa-solid fa-download"></i> Download</button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="transactionsTable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Mobile</th>
                            <th>RRN</th>
                           
                            <th>A/c Holder</th>
                            <th>Account No</th>
                            <th>IFCS</th>
                            <th>Status</th>
                            <th>Amount</th>
                            <th>Charges</th>
                            <th>Commission</th>
                            <th>TDS</th>
                            <th>Opening</th>
                            <th>Closing</th>
                            <th class="whitespace-nowrap">Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $transaction)
                            <tr>
                                <td>{{ $loop->iteration }}</td> 
                                <td>{{ $transaction->second_no }}</td>
                                <td>{{ json_decode($transaction->response_data, true)['data']['txnReferenceId'] ?? 'N/A' }}</td>
                                <td>{{ json_decode($transaction->response_data, true)['data']['beneficiaryName']  ?? 'N/A' }}</td>
                                <td>{{ json_decode($transaction->response_data, true)['data']['beneficiaryAccount'] ?? 'N/A' }}</td>
                                <td>{{ json_decode($transaction->response_data, true)['data']['beneficiaryIfsc'] ?? 'N/A' }}</td>
                                
                                {{-- <td>{{ $transaction->customer_outlet_id }}</td> --}}
                                <td>{{ json_decode($transaction->response_data, true)['status'] ?? ''}}</td>
                                <td>{{ json_decode($transaction->response_data, true)['data']['txnValue'] ?? 'N/A' }}</td>
                                <td>₹{{ number_format($transaction->charges, 2) }}</td>
                                <td>₹{{ number_format($transaction->commission, 2) }}</td>
                                <td>₹{{ number_format($transaction->tds, 2) }}</td>
                                <td>₹{{ number_format($transaction->opening_balance, 2) }}</td>

                                @php
                                    $commission = $transaction->commission ?? 0;
                                    $tds = $transaction->tds ?? 0;
                                    $adjustedCommission = $commission - $tds;
                                    $finalClosingBalance = $transaction->closing_balance + $adjustedCommission;
                                @endphp
                                <td>₹{{ number_format($finalClosingBalance, 2) }}</td>

                                <td class="whitespace-nowrap">{{ $transaction->created_at }}</td>
                                <td>
                                <a href="{{ route('DuplicateRcpt', ['id' => $transaction->id]) }}" class="btn btn-primary">
                                    Print
                                </a>
                                </td>
                            </tr>
                            <!-- Modal Code -->
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script>
    document.getElementById('exportTransactions').addEventListener('click', function () {
        let table = document.getElementById('transactionsTable');
        let workbook = XLSX.utils.table_to_book(table, { sheet: "Sheet1" });
        XLSX.writeFile(workbook, 'Transactions.xlsx');
    });
</script>
@endsection
