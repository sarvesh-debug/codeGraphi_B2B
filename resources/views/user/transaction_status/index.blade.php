@extends('user.include.layout')

@section('content')
<div class="container-fluid px-4">
  
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('customer/dashboard') }}">Home</a></li>
        <li class="breadcrumb-item active">Transaction Status</li>
    </ol>

    @if($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    <!-- Date Selection Form with External Reference -->
    <div class="card mb-4">
        <div class="card-header">
            <h3>Check Transaction Status </h3>
        </div>
        <div class="card-body">
            <form action="{{ route('transaction.status') }}" method="post">
                @csrf
                <div class="mb-3">
                    <label for="transactionDate" class="form-label">Select Date</label>
                    <input type="date" id="transactionDate" name="transactionDate" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="externalRef" class="form-label">Transaction ID</label>
                    <input type="text" id="externalRef" name="externalRef" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Check Status</button>
            </form>
        </div>
    </div>

    <!-- Transaction Status Table -->
    @if(!empty($responseData))
        <div class="card">
            <div class="card-header">
                <h3>Transaction Details</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Status Code</th>
                            <th>Transaction Status Code</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $responseData['statuscode'] }}</td>
                            <td>{{ $responseData['data']['transactionStatusCode'] }}</td>
                            <td>
                                @if ($responseData['statuscode'] === 'TXN')
                                    @if ($responseData['data']['transactionStatusCode'] === 'TXN')
                                        Transaction is Successful
                                    @elseif ($responseData['data']['transactionStatusCode'] === 'TUP')
                                        Still Transaction is under process. No Action Required.
                                    @else
                                        Transaction is Failed
                                    @endif
                                @else
                                    No Action Required
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>

                <h4>Additional Transaction Details</h4>
                <table class="table table-bordered">
                    <tr>
                        <th>Transaction Date Time</th>
                        <td>{{ $responseData['data']['transactionDateTime'] }}</td>
                    </tr>
                    <tr>
                        <th>Transaction Amount</th>
                        <td>{{ $responseData['data']['transactionAmount'] }}</td>
                    </tr>
                    <tr>
                        <th>Transaction Reference ID</th>
                        <td>{{ $responseData['data']['transactionReferenceId'] }}</td>
                    </tr>
                </table>

                <h4>Order Details</h4>
                <table class="table table-bordered">
                    <tr>
                        <th>Reference ID</th>
                        <td>{{ $responseData['data']['order']['referenceId'] }}</td>
                    </tr>
                    <tr>
                        <th>External Reference</th>
                        <td>{{ $responseData['data']['order']['externalRef'] }}</td>
                    </tr>
                    <tr>
                        <th>Service Provider</th>
                        <td>{{ $responseData['data']['order']['spName'] }}</td>
                    </tr>
                    <tr>
                        <th>Account</th>
                        <td>{{ $responseData['data']['order']['account'] }}</td>
                    </tr>
                    <tr>
                        <th>Bank</th>
                        <td>{{ $responseData['data']['order']['optional3'] }}</td>
                    </tr>
                </table>
            </div>
        </div>
    @else
        <p>No transaction data found or an error occurred.</p>
    @endif
</div>
@endsection











{{-- @extends('user.include.layout')

@section('content')
<div class="container-fluid px-4">
    @include('user.account-verification.navbar')
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>
        <li class="breadcrumb-item active">Transaction Status</li>
    </ol>

    @if($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('transaction.status') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="transactionDate" class="form-label">Transaction Date</label>
            <input type="date" id="transactionDate" name="transactionDate" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="externalRef" class="form-label">Transaction ID (External Reference)</label>
            <input type="text" id="externalRef" name="externalRef" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Check Transaction Status</button>
    </form>

    @if(!empty($responseData))
        <div class="card-body">
            <h4>Transaction Status</h4>
            <pre>{{ json_encode($responseData, JSON_PRETTY_PRINT) }}</pre>
        </div>
    @endif
</div>
@endsection --}}
