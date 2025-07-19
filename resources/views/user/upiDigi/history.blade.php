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
        <h3 class="text-xs sm:text-sm md:text-3xl lg:text-3xl">UPI Transaction History</h3>
    </div>
    <div class="card-body">
        <!-- Date Filter Form -->
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
            <table class="table table-bordered min-w-full text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th>ID</th>
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
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $txn['retailerId'] }}</td>
                            <td>{{ $txn['referenceId_order'] }}</td>
                            <td>₹{{ number_format($txn['amount'], 2) }}</td>
                            <td>{{ $txn['rrn'] }}</td>
                            <td>{{ ucfirst($txn['status']) }}</td>
                            <td>{{ $txn['referenceId_pay'] }}</td>
                            <td>{{ $txn['created_at'] }}</td>
                            <td>
                                <form action="{{route('digifintel.statusindu')}}" method="post">
                                @csrf
                                        <input type="hidden" value="{{ $txn['referenceId_pay'] }}" name="referenceId">
                                        <button class="btn btn-sm btn-success">Check</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">No UPI transactions found for selected range.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
<script>
    document.getElementById("exportExcel").addEventListener("click", function () {
        let table = document.getElementById("datatablesSimple"); // Get table
        let workbook = XLSX.utils.book_new(); // Create a new Excel workbook
        let worksheet = XLSX.utils.table_to_sheet(table); // Convert table to worksheet
        XLSX.utils.book_append_sheet(workbook, worksheet, "Withdrawals"); // Append sheet

        // Save the file
        XLSX.writeFile(workbook, "withdrawals.xlsx");
    });
</script>

@endsection
