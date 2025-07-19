@extends('admin/include.layout')

@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">

<div class="container-fluid">
    <h4 class="mb-4">📄 TDS Report</h4>

    {{-- Filter Form --}}
    <div class="card p-3 mb-4 shadow-sm">
        <form method="GET" action="{{ route('admin.reports.tds') }}">
            <div class="row g-3 align-items-end">
                <div class="col-md-2">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control" value="{{ request('username') }}" placeholder="Enter username">
                </div>
                <div class="col-md-2">
                    <label>PAN No</label>
                    <input type="text" name="pan_no" class="form-control" value="{{ request('pan_no') }}" placeholder="Enter PAN No">
                </div>
                {{-- <div class="col-md-2">
                    <label>Start Date</label>
                    <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                </div>
                <div class="col-md-2">
                    <label>End Date</label>
                    <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                </div> --}}
                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100">🔍 Filter</button>
                    <a href="{{ route('admin.reports.tds') }}" class="btn btn-secondary w-100">Reset</a>
                    <a href="{{ route('admin.reports.tds.export', request()->query()) }}" class="btn btn-success w-100">⬇ Export to Excel</a>
                </div>
            </div>
        </form>
    </div>

    {{-- Total TDS --}}
    <div class="mb-3">
        <h5><strong>Total TDS:</strong> ₹{{ number_format($totalTds, 2) }}</h5>
    </div>

    {{-- TDS Table --}}
    <div class="table-responsive">
        <table class="table table-bordered table-striped" id="tdsTable">
            <thead class="table-info">
                <tr>
                    <th>Sr. No.</th>
                    <th>RetailerId</th>
                    <th>Name</th>
                    <th>Service</th>
                    <th>PAN No</th>
                    <th>TDS (₹)</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $index => $txn)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $txn['username'] }}</td>
                        <td>{{ $txn['name'] }}</td>
                        <td>{{ $txn['service'] }}</td>
                        <td>{{ $txn['pan_no'] }}</td>
                        <td>{{ number_format($txn['tds'], 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-danger">No TDS records found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
{{-- DataTables JS --}}
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

<script>
    $(document).ready(function () {
        $('#tdsTable').DataTable({
            dom: 'Bfrtip',
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print'],
            pageLength: 10,
            language: {
                search: "🔍 Search:",
                lengthMenu: "Show _MENU_ records per page",
                zeroRecords: "No matching records found",
                info: "Showing _START_ to _END_ of _TOTAL_ entries",
                infoEmpty: "No entries",
                infoFiltered: "(filtered from _MAX_ total entries)"
            }
        });
    });
</script>
@endsection