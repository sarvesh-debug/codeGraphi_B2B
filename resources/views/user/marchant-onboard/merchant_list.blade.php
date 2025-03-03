{{-- <!-- resources/views/outlet/list.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Outlet List</title>
</head>
<body>
    <h1>Outlet List</h1>

    @if(!empty($responseData))
        <pre>{{ json_encode($responseData, JSON_PRETTY_PRINT) }}</pre>
    @else
        <p>No outlets found or an error occurred.</p>
    @endif
</body>
</html> --}}

@extends('admin/include.layout')

@section('content')
<div class="container-fluid px-4">
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>
        <li class="breadcrumb-item active">Outlet List</li>
    </ol>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card-body table-scroll">
        <table id="datatablesSimple" class="table table-bordered">
            <thead>
                <tr>
                    <th>Outlet ID</th>
                    <th>Name</th>
                    <th>Mobile</th>
                    <th>Email</th>
                    <th>PAN</th>
                    <th>Account No</th>
                    <th>KYC Status</th>
                    <th>Last Activity Date</th>
         
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Outlet ID</th>
                    <th>Name</th>
                    <th>Mobile</th>
                    <th>Email</th>
                    <th>PAN</th>
                    <th>Account No</th>
                    <th>KYC Status</th>
                    <th>Last Activity Date</th>
                 
                </tr>
            </tfoot>
            <tbody>
                @foreach ($responseData['data']['records'] as $outlet)
                    <tr>
                        <td>{{ $outlet['outletId'] }}</td>
                        <td>{{ $outlet['name'] }}</td>
                        <td>{{ $outlet['mobile'] }}</td>
                        <td>{{ $outlet['email'] }}</td>
                        <td>{{ $outlet['pan'] }}</td>
                        <td>
                            @if(!empty($outlet['bankAccounts']) && $outlet['bankAccounts'][0]['isPrimary'])
                                Account No: {{ $outlet['bankAccounts'][0]['accountNumber'] }} <br>
                                IFSC: {{ $outlet['bankAccounts'][0]['ifsc'] }}
                            @else
                                N/A
                            @endif
                        </td>
                        <td>{{ $outlet['KYCStatus'] ? 'Verified' : 'Pending' }}</td>
                        <td>{{ $outlet['lastActivityDt'] }}</td>
                       
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

