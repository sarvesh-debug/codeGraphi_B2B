@extends('user/include.layout')

@section('content')
<div class="container-fluid px-4">
    @include('user.cgpayout.navbar')
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('customer/dashboard') }}">Home</a></li>
        <li class="breadcrumb-item active">Payout History</li>
    </ol>

    @if($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="mb-5">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="text-xs sm:text-sm md:text-3xl lg:text-3xl">Payout History</h3>
            <button id="exportExcel" class="btn btn-success">Export to Excel</button>
        </div>
        <div class="card-body ">
            {{-- <!-- Date Filter Form -->
            <form method="GET" action="{{ route('aeps.history') }}" class="row mb-4">
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
            </form> --}}

            <!-- Table Container -->
            <div class="table-container">
                <div class="table-responsive" style="overflow-x: auto;">
                    <table id="datatablesSimple" class="table table-bordered min-w-full text-sm">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-2 py-2">ID</th>
                                <th class="px-2 py-2">Amount</th>
                                <th class="px-2 py-2">AccountNo</th>
                                {{-- <th class="px-2 py-2">IFSC</th> --}}
                                <th class="px-2 py-2">Ref</th>
                                <th class="px-2 py-2">Status</th>
                                <th class="px-2 py-2">Charges</th>
                                <th class="px-2 py-2">TDS</th>
                                <th class="px-2 py-2">Opening</th>
                                <th class="px-2 py-2">Closing</th>
                                <th class="px-2 py-2">Created At</th>
                                {{-- <th class="px-2 py-2">Actions</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($payOutHistory as $payout)
                                @php
                                $data = json_decode($payout->response, true);
                                @endphp
                                <tr class="border-b">
                                    <td class="px-2 py-2">{{ $payout->id }}</td>
                                    <td class="px-2 py-2">{{ $payout->amount }}</td>
                                    <td class="px-2 py-2">{{ json_decode($payout->response)->accountNo ?? ''}}</td>
                                    {{-- <td class="px-2 py-2">{{ json_decode($payout->response)->ifsc ?? ''}}</td> --}}
                                    <td class="px-2 py-2">{{ json_decode($payout->response)->rrn ?? ''}}</td>
                                    <td class="px-2 py-2">{{ $payout->status}}</td>
                                    <td class="px-2 py-2">₹{{ number_format($payout->charges, 2) }}</td>
                                    <td class="px-2 py-2">₹{{ number_format($payout->tds, 2) }}</td>
                                    <td class="px-2 py-2">₹{{ number_format($payout->openingBal, 2) }}</td>
                                    <td class="px-2 py-2">₹{{ number_format($payout->closingBal, 2) }}</td>
                                    <td class="px-2 py-2">{{ $payout->created_at }}</td>
                                    {{-- <td class="px-2 py-2">
                                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#responseModal{{ $withdrawal->id }}">
                                            Download
                                        </button>
                                    </td> --}}
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="text-center">No payout found for the selected date range.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- End Table Container -->
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
        XLSX.utils.book_append_sheet(workbook, worksheet, "payout"); // Append sheet

        // Save the file
        XLSX.writeFile(workbook, "payout.xlsx");
    });
</script>

@endsection
