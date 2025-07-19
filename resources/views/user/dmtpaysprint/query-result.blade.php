@extends('user/include.layout')
@section('content')
@include('user.beneficiary.navbar')
    <div class="container mt-5">
        <h2>Transaction Query Result</h2>

        @if (isset($error))
            <div class="alert alert-danger">{{ $error }}</div>
        @elseif (isset($queryData) && $queryData['status'])
            <div class="alert alert-success">
                {{ $queryData['message'] }}
            </div>

            <table class="table table-bordered mt-3">
                <tbody>
                    <tr>
                        <th>ACK Number</th>
                        <td>{{ $queryData['ackno'] }}</td>
                    </tr>
                    <tr>
                        <tr>
                            <th>referenceid</th>
                            <td>{{ $queryData['referenceid'] }}</td>
                        </tr>
                        <th>UTR</th>
                        <td>{{ $queryData['utr'] }}</td>
                    </tr>
                    <tr>
                        <th>Transaction Status</th>
                        <td>
                            @switch($queryData['txn_status'])
                                @case(1)
                                    Transactions successfully.
                                    @break
                                @case(3)
                                    Validations Error.
                                    @break
                                @case(4)
                                    Unable to process query remitter request.
                                    @break
                                @case(5)
                                    Invalid JWT token.
                                    @break
                                @case(6)
                                    Authentication failed.
                                    @break
                                @default
                                    Unknown status.
                            @endswitch
                        </td>
                    </tr>
                    

                    <tr>
                        <th>Message</th>
                        <td>{{ $queryData['message'] }}</td>
                    </tr>
                    
                  
                    <tr>
                        <th>Customer Charge</th>
                        <td>{{ $queryData['customercharge'] }}</td>
                    </tr>
                    <tr>
                        <th>GST</th>
                        <td>{{ $queryData['gst'] }}</td>
                    </tr>
                    <tr>
                        <th>TDS</th>
                        <td>{{ $queryData['tds'] }}</td>
                    </tr>
                    <tr>
                        <th>Net Commission</th>
                        <td>{{ $queryData['netcommission'] }}</td>
                    </tr>
                  
                    <tr>
                        <th>Account Number</th>
                        <td>{{ $queryData['account'] }}</td>
                    </tr>
                  
                  
                    <tr>
                        <th>Balance</th>
                        <td>{{ $queryData['amount'] }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>{{ $queryData['status'] }}</td>
                    </tr>
                </tbody>
            </table>
        @else
            <div class="alert alert-warning">No transaction details available.</div>
        @endif
    </div>
    @endsection
