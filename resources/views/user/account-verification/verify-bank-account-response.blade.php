@extends('user/include.layout')

@section('content')

<!-- Include navbar -->
@include('user.account-verification.navbar')

<!-- Display response data -->
@if(isset($response))
<div class="card p-4 mt-4">
    <h4 class="text-center mb-4">Verification Details</h4>
    
    <div class="row mb-3">
        <div class="col-md-6">
            <div class="card shadow-sm border-left-success">
                <div class="card-body">
                    <h5 class="card-title">Status</h5>
                    <p class="card-text text-success font-weight-bold">
                        {{ $response['status'] ?? 'N/A' }}
                    </p>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card shadow-sm border-left-info">
                <div class="card-body">
                    <h5 class="card-title">Timestamp</h5>
                    <p class="card-text">{{ $response['timestamp'] ?? 'N/A' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Details -->
    <div class="card mt-3 shadow-sm">
        <div class="card-header bg-success text-white">
            <h5>Transaction Data</h5>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <th>External Reference</th>
                        <td>{{ $response['data']['externalRef'] ?? 'N/A' }}</td>
                    </tr>
                    <!--<tr>-->
                    <!--    <th>Pool Reference ID</th>-->
                    <!--    <td>{{ $response['data']['poolReferenceId'] ?? 'N/A' }}</td>-->
                    <!--</tr>-->
                    <tr>
                        <th>Transaction Value</th>
                        <td>{{ $response['data']['txnValue'] ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Transaction Reference ID</th>
                        <td>{{ $response['data']['txnReferenceId'] ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Payee Name</th>
                        <td>{{ $response['data']['payee']['name'] ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Payee Account</th>
                        <td>{{ $response['data']['payee']['account'] ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Payee IFSC</th>
                        <td>{{ $response['data']['payee']['ifsc'] ?? 'N/A' }}</td>
                    </tr>
                     <tr>
                        <th>Order Id</th>
                        <td>{{ $response['orderid'] ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>iPay UUID</th>
                        <td>{{ $response['ipay_uuid'] ?? 'N/A' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif

@endsection
