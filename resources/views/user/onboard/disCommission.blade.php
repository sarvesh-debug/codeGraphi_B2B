@extends('user/include.layout')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
 
@section('content')
<div class="container-fluid ">
    <div class="container mt-3">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>
        <li class="breadcrumb-item active">All User</li>
    </ol>
    <!-- <button type="button" class="btn btn-success w-100" onclick="downloadExcel()">
        <img src="https://freeiconshop.com/wp-content/uploads/edd/download-flat.png" 
             alt="Download Icon" 
             style="width: 16px; height: 16px; margin-right: 5px;"> --}}
        Export
    </button> -->
    <div class="row">
        <div class="col d-flex justify-content-end me-2">
            <button type="button" class="btn btn-download" onclick="downloadExcel()"> 
                <i class="fa-solid fa-download"></i> Download
            </button>
        </div>
    </div>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    </div>

    <div class="card-body table-scroll">
        <table id="datatablesSimple" class="table table-bordered">
            <thead>
                <tr>
                    <th>Sr</th>
                    <th>Date Time</th>
                    <th>Services</th>
                    <th>RT Phone</th>
                    <th>Opening Bal</th>
                    <th>Commission</th>
                    <th>Closing Bal</th>
                </tr>
            </thead>
            <tfoot>
               
            </tfoot>
            <tbody>
                @foreach ($customers as $customer)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{ $customer->created_at }}</td>
                    <td>{{ $customer->services }}</td>
                    <td>{{ $customer->retailer_no }}</td>
                    <td>{{ $customer->opening_balance }}</td>
                    <td>{{ $customer->commission }}</td>
                    <td>{{ $customer->closing_balance }}</td>
                    
                    
                </tr>


                                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    function downloadExcel() {
        // Get table data
        const table = document.getElementById('datatablesSimple');
        const rows = Array.from(table.rows).map(row => 
            Array.from(row.cells).map(cell => cell.innerText)
        );

        // Create a new workbook and worksheet
        const workbook = XLSX.utils.book_new();
        const worksheet = XLSX.utils.aoa_to_sheet(rows);

        // Add the worksheet to the workbook
        XLSX.utils.book_append_sheet(workbook, worksheet, "Retailer List");

        // Export the workbook as an Excel file
        XLSX.writeFile(workbook, "commissionlist.xlsx");
    }
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>


@endsection
