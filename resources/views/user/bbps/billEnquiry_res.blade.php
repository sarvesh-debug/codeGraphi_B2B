@extends('user/include.layout')
@section('content')
@include('user.bbps.navbar')

    {{-- <h1>API Response</h1> --}}
    <h3>Status: {{ $responseData['status'] }}</h3>
    <h3>Transaction Amount: {{ $responseData['data']['BillAmount'] ?? 'N/A' }}</h3>
    <h3>Customer Name: {{ $responseData['data']['CustomerName'] ?? 'N/A' }}</h3>
    <h3>Bill Number: {{ $responseData['data']['BillNumber'] ?? 'N/A' }}</h3>
    <h3>Bill Due Date: {{ $responseData['data']['BillDueDate'] ?? 'N/A' }}</h3>

    <h4>Customer Parameter Details:</h4>
    <ul>
        @if(isset($responseData['data']['CustomerParamsDetails']))
            @foreach($responseData['data']['CustomerParamsDetails'] as $param)
                <li>{{ $param['Name'] }}: {{ $param['Value'] }}</li>
            @endforeach
        @else
            <li>No details available</li>
        @endif
    </ul>

    <h4>Other Info:</h4>
    <p>Enquiry Reference ID: {{ $responseData['data']['enquiryReferenceId'] ?? 'N/A' }}</p>
    <p>Timestamp: {{ $responseData['timestamp'] }}</p>
    {{-- <p>Environment: {{ $responseData['environment'] }}</p> --}}
    @endsection
