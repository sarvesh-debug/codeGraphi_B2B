@extends('user/include.layout')

@section('content')
<div class="container">
    <h1 class="mt-4">Ordered Transaction Statement</h1>

    @if (!empty($responseData['data']['records']))
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Status</th>
                    <th>Date & Time</th>
                    <th>Order ID</th>
                    <th>Client Order ID</th>
                    <th>Transaction ID</th>
                    <th>Product Name</th>
                    <th>Charged Value</th>
                    <th>Order Value</th>
                    <th>Closing Balance</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($responseData['data']['records'] as $record)
                    <tr>
                        <td>{{ $record['status'] }}</td>
                        <td>{{ $record['txnDateTime'] }}</td>
                        <td>{{ $record['ipayOrderId'] }}</td>
                        <td>{{ $record['clientOrderId'] }}</td>
                        <td>{{ $record['transactionId'] }}</td>
                        <td>{{ $record['productName'] }}</td>
                        <td>{{ $record['txnChargedValue'] }}</td>
                        <td>{{ $record['orderValue'] }}</td>
                        <td>{{ $record['closingBalance'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No ordered transaction records found.</p>
    @endif
</div>
@endsection
