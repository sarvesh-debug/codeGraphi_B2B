@extends('admin/include.layout')

@section('content')
<div class="container-fluid px-4">
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active">Wallet Transaction History</li>
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
                    <th>Sender ID</th>
                    <th>Receiver ID</th>
                    <th>Amount</th>
                    <th>Opening Balance</th>
                    <th>Closing Balance</th>
                 
                    <th>Remark</th>
                    <th>Transfer ID</th>
                    <th>Date Time</th>
                  
                </tr>
            </thead>
            <tfoot>
                
            </tfoot>
            <tbody>
                @foreach ($responseData as $transaction)
                    <tr>
                        <td>{{ $loop->count - $loop->iteration + 1 }}</td>
                        <td>{{ $transaction->sender_id }}</td>
                        <td>{{ $transaction->receiver_id }}</td>
                        <td>{{ $transaction->amount }}</td>
                        <td>{{ $transaction->opening_balance }}</td>
                        <td>{{ $transaction->closing_balance }}</td>
                        <td>{{ $transaction->charges }}</td>
                       
                        <td>{{ $transaction->transfer_id }}</td>
                        <td>{{ $transaction->created_at }}</td>
                        
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
