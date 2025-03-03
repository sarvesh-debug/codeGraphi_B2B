@extends('user/include.layout')

@section('content') 
@include('user.AEPS.navbar') 
<div class="container mt-4">
    <h1 class="text-center text-primary mb-4">Balance Enquiry</h1>

    {{-- Check for successful transaction --}}
    @if (isset($response['statuscode']) && $response['statuscode'] === 'TXN')
        <div class="card border-success mb-4">
            <div class="card-body">
                <h2 class="card-title text-success">Status: {{ $response['status'] }}</h2>
                <p class="card-text"><strong>Timestamp:</strong> {{ $response['timestamp'] }}</p>
                <p class="card-text"><strong>Order ID:</strong> {{ $response['orderid'] ?? 'N/A' }}</p>
            </div>
        </div>

        <div class="card border-info mb-4">
            <div class="card-body">
                <h3 class="card-title text-info">Bank Details</h3>
                <table class="table table-bordered">
                    <tr>
                        <th>Bank Name</th>
                        <td>{{ $response['data']['bankName'] }}</td>
                    </tr>
                    <tr>
                        <th>Account Number</th>
                        <td>{{ $response['data']['accountNumber'] }}</td>
                    </tr>
                    <tr>
                        <th>Bank Account Balance</th>
                        <td class="fw-bold text-primary">{{ $response['data']['bankAccountBalance'] }}</td>
                    </tr>
                    
                </table>
            </div>
            
        </div>

    @else
    <div class="alert alert-danger shadow-lg rounded p-4 text-center">
        <div class="mb-3">
            <i class="fas fa-exclamation-triangle fa-3x text-danger"></i>
        </div>
        <h2 class="alert-heading fw-bold">Attention Please</h2>
        <p class="mb-0 text-dark">
            {{ $response['status'] ?? 'An unknown error occurred.' }}
        </p>
    </div>
    
    @endif 
    
    <a href="{{ route('balance.enquiry-form') }}" class="btn btn-success">Back</a>
    
</div>

<!-- Auto-redirect script -->

@endsection
