@extends('user/include.layout')

@section('content')
<div class="container-fluid px-4">
    @if($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="mb-5 mt-5">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="text-xs sm:text-sm md:text-3xl lg:text-3xl">Payout Transaction History</h3>
        </div>

        <div class="card-body">
            <!-- Date Filter Form (optional, doesn't filter in current controller) -->
            <form method="GET" action="{{ route('historyUPI') }}" class="row mb-4">
                <div class="col-md-5">
                    <label for="start_date">Start Date & Time</label>
                    <input type="datetime-local" id="start_date" name="start_date"
                        value="{{ request('start_date') ? \Carbon\Carbon::parse(request('start_date'))->format('Y-m-d\TH:i') : '' }}"
                        class="form-control">
                </div>
                <div class="col-md-5">
                    <label for="end_date">End Date & Time</label>
                    <input type="datetime-local" id="end_date" name="end_date"
                        value="{{ request('end_date') ? \Carbon\Carbon::parse(request('end_date'))->format('Y-m-d\TH:i') : '' }}"
                        class="form-control">
                </div>
                <div class="col-md-2 mt-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </form>

            <div class="table-responsive" style="overflow-x: auto;">
                <table class="table table-bordered min-w-full text-sm" id="datatablesSimple">
                    <thead class="bg-gray-100">
                        <tr>
                            <th>#</th>
                            <th>Retailer ID</th>
                            <th>Order ID</th>
                            <th>Amount</th>
                            <th>RRN</th>
                            <th>Status</th>
                            <th>Pay ID</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $txn)
                            @php
                                $response = json_decode($txn->responseBody, true);
                            @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $txn->rtId }}</td>
                                <td>{{ $response['data']['externalRef'] ?? '-' }}</td>
                                <td>₹{{ number_format($txn->amount, 2) }}</td>
                                <td>{{ $response['data']['bank_ref_num'] ?? '-' }}</td>
                                <td>{{ ucfirst($txn->status) }}</td>
                                <td>{{ $response['apiTxnId'] ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($txn->created_at)->format('d M Y, h:i A') }}</td>
                                <td>
                                <a href="{{ route('nifi.print', $txn->id) }}" class="btn btn-sm btn-primary">Print</a>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">No payout transactions found for selected range.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                <button class="btn btn-secondary" id="exportExcel">Export to Excel</button>
            </div>
        </div>
    </div>
</div>

<!-- Excel Export Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
<script>
    document.getElementById("exportExcel").addEventListener("click", function () {
        let table = document.getElementById("datatablesSimple");
        let workbook = XLSX.utils.book_new();
        let worksheet = XLSX.utils.table_to_sheet(table);
        XLSX.utils.book_append_sheet(workbook, worksheet, "Withdrawals");
        XLSX.writeFile(workbook, "withdrawals.xlsx");
    });
</script>
@endsection
