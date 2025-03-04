@extends('user/include.layout')

@section('content')


<div class="container-fluid px-4 mt-3">
    <nav class="navbar navbar-expand-lg navbar-light bg-light p-3 m-2">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('/user/wallet/index')}}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('wallet.History')}}">History</a>
                </li>
            </ul>
        </div>
    </nav>


    <!-- <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active">Wallet Transaction History</li>
    </ol> -->

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card-body">
        <!-- Search Bar and Entries Per Page -->
        <div class="d-flex justify-content-between mb-3">
            <div>
                <label>Show 
                    <select id="entriesPerPage" class="form-select d-inline-block w-auto">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select> 
                entries</label>
            </div>
            <div>
                <input type="text" id="searchBox" class="form-control" placeholder="Search...">
            </div>
        </div>
        
        <div class="table-responsive"> <!-- Added table-responsive class -->
            <table 
             class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID3</th>
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
                            <td>{{ $transaction->id }}</td>
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
</div>
@endsection
