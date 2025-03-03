@extends('user.include.layout')
@section('content')
<div class="container-fluid px-4">
    @include('user.account-verification.navbar')
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('customer/dashboard') }}">Home</a></li>
        <li class="breadcrumb-item active">Transaction Records</li>
    </ol>

    @if($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    @if(!empty($responseData['data']['records']))
        <div class="card-body table-scroll">
            <table id="datatablesSimple" class="table table-bordered">
                <thead>
                    <tr>
                        <th>Status</th>
                        <th>Transaction Date & Time</th>
                        <th>iPay Order ID</th>
                        <th>Client Order ID</th>
                        <th>Transaction ID</th>
                        <th>Product Name</th>
                        <th>Transaction Mode</th>
                        <th>Charged Value</th>
                        <th>Order Value</th>
                        <th>Convenience Fee</th>
                        <th>Cashback</th>
                        <th>Closing Balance</th>
                        <th>Narration</th>
                        <th>Response Message</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Status</th>
                        <th>Transaction Date & Time</th>
                        <th>iPay Order ID</th>
                        <th>Client Order ID</th>
                        <th>Transaction ID</th>
                        <th>Product Name</th>
                        <th>Transaction Mode</th>
                        <th>Charged Value</th>
                        <th>Order Value</th>
                        <th>Convenience Fee</th>
                        <th>Cashback</th>
                        <th>Closing Balance</th>
                        <th>Narration</th>
                        <th>Response Message</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($responseData['data']['records'] as $record)
                        <tr>
                            <td>{{ $record['status'] }}</td>
                            <td>{{ $record['txnDateTime'] }}</td>
                            <td>{{ $record['ipayOrderId'] }}</td>
                            <td>{{ $record['clientOrderId'] }}</td>
                            <td>{{ $record['transactionId'] }}</td>
                            <td>{{ $record['productName'] }}</td>
                            <td>{{ $record['txnMode'] }}</td>
                            <td>{{ $record['txnChargedValue'] }}</td>
                            <td>{{ $record['orderValue'] }}</td>
                            <td>{{ $record['convenienceFee'] }}</td>
                            <td>{{ $record['txnCashback'] }}</td>
                            <td>{{ $record['closingBalance'] }}</td>
                            <td>{{ $record['narrationValue0'] }}</td>
                            <td>{{ $record['responseMsg'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p>No transaction records found or an error occurred.</p>
    @endif
</div>
@endsection
