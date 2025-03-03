@extends('user/include.layout')
@section('content')
@include('user.bbps.navbar')

    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
    </style>

    <h1>Transaction Details</h1>
    <p><strong>Status Code:</strong> {{ $responseData['statuscode'] }}</p>
    <p><strong>Status:</strong> {{ $responseData['status'] }}</p>
    {{-- <p><strong>External Reference:</strong> {{ $responseData['data']['externalRef'] }}</p>
    <p><strong>Pool Reference ID:</strong> {{ $responseData['data']['poolReferenceId'] }}</p> --}}
    <p><strong>Transaction Value:</strong> {{ $responseData['data']['txnValue'] }}</p>
    <p><strong>Transaction Reference ID:</strong> {{ $responseData['data']['txnReferenceId'] }}</p>

    {{-- <h3>Pool Details</h3>
    <table>
        <tr>
            <th>Account</th>
            <td>{{ $responseData['data']['pool']['account'] }}</td>
        </tr>
        <tr>
            <th>Opening Balance</th>
            <td>{{ $responseData['data']['pool']['openingBal'] }}</td>
        </tr>
        <tr>
            <th>Mode</th>
            <td>{{ $responseData['data']['pool']['mode'] }}</td>
        </tr>
        <tr>
            <th>Amount</th>
            <td>{{ $responseData['data']['pool']['amount'] }}</td>
        </tr>
        <tr>
            <th>Closing Balance</th>
            <td>{{ $responseData['data']['pool']['closingBal'] }}</td>
        </tr>
    </table> --}}

    <h3>Biller Details</h3>
    <table>
        <tr>
            <th>Name</th>
            <td>{{ $responseData['data']['billerDetails']['name'] }}</td>
        </tr>
        <tr>
            <th>Account</th>
            <td>{{ $responseData['data']['billerDetails']['account'] }}</td>
        </tr>
    </table>

    <h3>Bill Details</h3>
    <table>
        <tr>
            <th>Customer Name</th>
            <td>{{ $responseData['data']['billDetails']['CustomerName'] ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Bill Number</th>
            <td>{{ $responseData['data']['billDetails']['BillNumber'] ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Bill Period</th>
            <td>{{ $responseData['data']['billDetails']['BillPeriod'] ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Bill Date</th>
            <td>{{ $responseData['data']['billDetails']['BillDate'] ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Bill Due Date</th>
            <td>{{ $responseData['data']['billDetails']['BillDueDate'] ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Bill Amount</th>
            <td>{{ $responseData['data']['billDetails']['BillAmount'] ?? 'N/A' }}</td>
        </tr>
    </table>

    {{-- <p><strong>Timestamp:</strong> {{ $responseData['timestamp'] }}</p>
    <p><strong>Environment:</strong> {{ $responseData['environment'] }}</p>
    <p><strong>Order ID:</strong> {{ $responseData['orderid'] ?? 'N/A' }}</p> --}}
    @endsection
