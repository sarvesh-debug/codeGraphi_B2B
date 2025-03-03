@extends('user/include.layout')

@section('content')
@include('user.payout.navbar')
    <style>
        @media print {
            .no-print {
                display: none;
            }
        }
        body {
            font-family: Arial, sans-serif;
        }
    </style>

    <div class="container my-4">
        <div class="text-center mb-4">
            <h3>API Response</h3>
            <p class="text-muted">Transaction Details</p>
        </div>

        <div class="card">
            <div class="card-body">
                <!-- Status Section -->
                <h5 class="mb-3">Status</h5>
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th>Status Code</th>
                            <td>{{ $response['statuscode'] }}</td>
                        </tr>
                        <tr>
                            <th>Transaction Status</th>
                            <td>{{ $response['status'] }}</td>
                        </tr>
                        <tr>
                            <th>Timestamp</th>
                            <td>{{ $response['timestamp'] }}</td>
                        </tr>
                        <tr>
                            <th>Environment</th>
                            <td>{{ $response['environment'] }}</td>
                        </tr>
                    </tbody>
                </table>

                <!-- Transaction Details -->
                <h5 class="mt-4 mb-3">Transaction Details</h5>
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th>External Reference</th>
                            <td>{{ $response['data']['externalRef'] }}</td>
                        </tr>
                        <tr>
                            <th>Transaction Value</th>
                            <td>₹{{ $response['data']['txnValue'] }}</td>
                        </tr>
                        <tr>
                            <th>Transaction Reference ID</th>
                            <td>{{ $response['data']['txnReferenceId'] }}</td>
                        </tr>
                        <tr>
                            <th>Order ID</th>
                            <td>{{ $response['orderid'] }}</td>
                        </tr>
                    </tbody>
                </table>

                <!-- Pool Details -->
                <h5 class="mt-4 mb-3">Pool Details</h5>
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th>Account</th>
                            <td>{{ $response['data']['pool']['account'] }}</td>
                        </tr>
                        <tr>
                            <th>Opening Balance</th>
                            <td>₹{{ $response['data']['pool']['openingBal'] }}</td>
                        </tr>
                        <tr>
                            <th>Mode</th>
                            <td>{{ $response['data']['pool']['mode'] }}</td>
                        </tr>
                        <tr>
                            <th>Amount</th>
                            <td>₹{{ $response['data']['pool']['amount'] }}</td>
                        </tr>
                        <tr>
                            <th>Closing Balance</th>
                            <td>₹{{ $response['data']['pool']['closingBal'] }}</td>
                        </tr>
                    </tbody>
                </table>

                <!-- Payer Details -->
                <h5 class="mt-4 mb-3">Payer Details</h5>
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th>Account</th>
                            <td>{{ $response['data']['payer']['account'] }}</td>
                        </tr>
                        <tr>
                            <th>Name</th>
                            <td>{{ $response['data']['payer']['name'] }}</td>
                        </tr>
                    </tbody>
                </table>

                <!-- Payee Details -->
                <h5 class="mt-4 mb-3">Payee Details</h5>
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th>Account</th>
                            <td>{{ $response['data']['payee']['account'] }}</td>
                        </tr>
                        <tr>
                            <th>Name</th>
                            <td>{{ $response['data']['payee']['name'] }}</td>
                        </tr>
                    </tbody>
                </table>

                <!-- Unique Information -->
                <h5 class="mt-4 mb-3">Unique Information</h5>
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th>Unique UUID</th>
                            <td>{{ $response['ipay_uuid'] }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Print Button -->
        <div class="text-center mt-4 no-print">
            <button class="btn btn-primary" onclick="window.print()">Print</button>
        </div>
    </div>
    @endsection
