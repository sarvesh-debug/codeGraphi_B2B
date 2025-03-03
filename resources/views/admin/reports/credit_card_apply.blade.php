@extends('admin/include.layout')

@section('content')
<div class="container-fluid px-4">
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active">All Credit Card Applications</li>
    </ol>

    <div class="mb-3">
        <a href="javascript:void(0)" class="btn btn-success" onclick="exportTableToExcel('datatablesSimpleAll', 'credit_card_applications.xlsx')">Export to Excel</a>
    </div>

    @if($applications->isNotEmpty())
        <div class="card-body table-scroll">
            <table id="datatablesSimpleAll" class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Pincode</th>
                        <th>PAN Number</th>
                        <th>Bank</th>
                        <th>Retailer Name</th>
                        <th>Retailer Username</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($applications as $application)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $application->name }}</td>
                            <td>{{ $application->phone }}</td>
                            <td>{{ $application->pincode ?? 'N/A' }}</td>
                            <td>{{ $application->pan_no }}</td>
                            <td>{{ $application->bank }}</td>
                            <td>{{ $application->retailer_name }}</td>
                            <td>{{ $application->retailer_username }}</td>
                            <td>{{ $application->created_at->format('d-m-Y H:i:s') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p>No credit card applications found.</p>
    @endif
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script>
    function exportTableToExcel(tableID, filename = 'export.xlsx') {
        let table = document.getElementById(tableID);
        let workbook = XLSX.utils.table_to_book(table, { sheet: "Sheet1" });
        XLSX.writeFile(workbook, filename);
    }
</script>
@endsection
