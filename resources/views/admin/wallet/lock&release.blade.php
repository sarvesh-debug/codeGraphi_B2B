@extends('admin/include.layout')

@section('content') 
<div class="container-fluid px-4">
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>
        <li class="breadcrumb-item active">Wallet Credit & Debit</li>
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
                    <th>ID</th>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Wallet</th>
                    <th>Lock Amount</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Wallet</th>
                    <th>Lock Amount</th>
                    <th>Actions</th>
                </tr>
            </tfoot>
            <tbody>
               
                                <!-- Dummy Data -->
                @for ($i = 1; $i <= 50; $i++)
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{ 'Name'.$i }}</td>
                    <td>{{ 'username'.$i }}</td>
                    <td>{{ 'email'.$i.'@example.com' }}</td>
                    <td>{{ '+91 '.rand(7000000000, 9999999999) }}</td>
                  
                    <td>{{ '₹'.rand(1000, 50000) }}</td>
                    <td>{{ '₹'.rand(1000, 2000) }}</td>
               
                    <td>
                        <button class="btn btn-success btn-sm">Release</button>
                        <button class="btn btn-info btn-sm">Lock</button>
                        
                    </td>
                </tr>
                @endfor
                           
            </tbody>
        </table>
    </div>
</div>
    
@endsection