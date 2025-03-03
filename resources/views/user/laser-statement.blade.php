@extends('user/include.layout')

@section('content')
<div class="container-fluid px-4">
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active">Ledger Statement</li>
    </ol>

    <!-- Transaction Summary Section -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Total Transactions</h5>
                    <p class="card-text">₹ {{ $totalAmount ?? 0 }}</p>
                </div>
            </div>  
        </div>
        @foreach ($individualTotals as $source => $amount)
        <div class="col-md-3 my-1">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">{{ ucwords(str_replace('_', ' ', $source)) }}</h5>
                    <p class="card-text">₹ {{ $amount }}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Search and Filter Section -->
    {{-- <div class="card mb-4">
        <div class="card-body">
            <form action="{{route('laser.statement')}}" method="GET" class="form-inline">
                <div class="row align-items-center">
                    <div class="col-md-3">
                        <label for="start-date">From</label>
                        <input type="date" id="start-date" class="form-control" name="start_date" value="{{ request('start_date', date('Y-m-d')) }}">
                    </div>
                    <div class="col-md-3">
                        <label for="end-date">To</label>
                        <input type="date" id="end-date" class="form-control" name="end_date" value="{{ request('end_date', date('Y-m-d')) }}">
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control" name="search_value" placeholder="Enter Search Value" value="{{ request('search_value') }}">
                    </div>
                    <div class="col-md-1">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-success">Export</button>
                    </div>
                </div>
            </form>
        </div>
    </div> --}}

    <!-- Data Table Section -->
    <div class="card-body table-scroll">
        <table id="datatablesSimple" class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date Time</th>
                    <th>Transation Ref</th>
                    <th>Services</th>
                    <th>Description</th>
                    <th>TXN No</th>
                    <th>Status</th>
                    <th>Opening Bal</th>
                    {{-- <th>Commission</th> --}}
                    {{-- <th>Charges</th>
                    <th>Tds</th> --}}
                     {{-- <th>Type</th> --}}
                     <th>Credit</th>
                     <th>Debit</th>
                     <th>Balance</th>
                  
                    {{-- <th>Action</th> --}}
                </tr>
            </thead>
            <tbody>
                @forelse ($transactions as $index => $transaction)
                <tr>
                    <td>{{ $loop->count - $loop->iteration + 1 }}</td>
                    <td>{{ $transaction['timestamp'] }}</td>
                   
                    <td>{{$transaction['ext_ref']}}</td>
                    <td>{{ $transaction['source'] }}</td>
                    {{-- <td>₹ {{ $transaction['payableValue'] }}</td> --}}
                    <td>{{ $transaction['desc'] }}</td>
                   
                    <td>{{ $transaction['trans_id'] }}</td>
                    <td style="color: {{ $transaction['status'] === 'Success' ? 'green' : 'red' }};">
                        {{ $transaction['status'] }}
                    </td>
                    <td>₹{{$transaction['openingB']}}</td>
                    {{-- <td style="color:green">₹{{$transaction['commission']}}</td> --}}
                    {{-- <td style="color:red">₹{{$transaction['charges']}}</td>
                    <td style="color:red">₹{{$transaction['tds']}}</td> --}}
                    {{-- <td>{{ $transaction['type'] }}</td> --}}
                    <td style="color:green">₹{{ $transaction['credit'] }}</td>
                    <td style="color:red">₹{{ $transaction['debit'] }}</td>
                    <td>₹{{ $transaction['clsoingB'] }}</td>
                    {{-- <td>
                        <button class="btn btn-info btn-sm">View</button>
                    </td> --}}
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">No transactions found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
