@extends('user/include.layout')
@section('content')
@include('user.bbps.navbar')

<style>
    body {
        font-family: Arial, sans-serif;
        line-height: 1.6;
    }
    form {
        margin-top: 20px;
    }
    .form-group {
        margin-bottom: 15px;
    }
    .form-group label {
        display: block;
        font-weight: bold;
        margin-bottom: 5px;
    }
    .form-group input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }
    .form-group input:disabled {
        background-color: #f4f4f4;
    }
    .form-group textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }
    button {
        padding: 10px 15px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }
    button:hover {
        background-color: #0056b3;
    }
</style>

<h1>Transaction Details Form</h1>

<form action="{{route('bbps.validate')}}" method="POST">
    @csrf
    <div class="form-group">
        <label for="statuscode">Status Code</label>
        <input type="text" id="statuscode" name="statuscode" value="{{ $responseData['statuscode'] ?? 'N/A' }}" disabled>
    </div>
    
    <div class="form-group">
        <label for="status">Status</label>
        <input type="text" id="status" name="status" value="{{ $responseData['status'] ?? 'N/A' }}" disabled>
    </div>
    
    <div class="form-group">
        <label for="enquiryReferenceId">Enquiry Reference ID</label>
        <input type="text" id="enquiryReferenceId" name="enquiryReferenceId" value="{{ $responseData['data']['enquiryReferenceId'] ?? 'N/A' }}">
    </div>
    
    <div class="form-group">
        <label for="customerName">Customer Name</label>
        <input type="text" id="customerName" name="customerName" value="{{ $responseData['data']['CustomerName'] ?? 'N/A' }}">
    </div>
    
    <div class="form-group">
        <label for="billNumber">Bill Number</label>
        <input type="text" id="billNumber" name="billNumber" value="{{ $responseData['data']['BillNumber'] ?? 'N/A' }}">
    </div>
    
    <div class="form-group">
        <label for="billPeriod">Bill Period</label>
        <input type="text" id="billPeriod" name="billPeriod" value="{{ $responseData['data']['BillPeriod'] ?? 'N/A' }}">
    </div>
    
    <div class="form-group">
        <label for="billDate">Bill Date</label>
        <input type="text" id="billDate" name="billDate" value="{{ $responseData['data']['BillDate'] ?? 'N/A' }}">
    </div>
    
    <div class="form-group">
        <label for="billDueDate">Bill Due Date</label>
        <input type="text" id="billDueDate" name="billDueDate" value="{{ $responseData['data']['BillDueDate'] ?? 'N/A' }}">
    </div>
    
    <div class="form-group">
        <label for="billAmount">Bill Amount</label>
        <input type="text" id="billAmount" name="billAmount" value="{{ $responseData['data']['BillAmount'] ?? 'N/A' }}">
    </div>
    
    <h3>Customer Parameters</h3>
    @if(!empty($responseData['data']['CustomerParamsDetails']))
        @foreach($responseData['data']['CustomerParamsDetails'] as $index => $param)
            <div class="form-group">
                <label for="paramName_{{ $index }}">Parameter Name</label>
                <input type="text" id="paramName_{{ $index }}" name="customerParams[{{ $index }}][Name]" value="{{ $param['Name'] ?? 'N/A' }}" disabled>
            </div>
            <div class="form-group">
                <label for="paramValue_{{ $index }}">Parameter Value</label>
                <input type="text" id="paramValue_{{ $index }}" name="customerParams[{{ $index }}][Value]" value="{{ $param['Value'] ?? 'N/A' }}">
            </div>
        @endforeach
    @else
        <p>No Customer Parameters Available</p>
    @endif
    
    <h3>Additional Details</h3>
    @if(!empty($responseData['data']['AdditionalDetails']))
        @foreach($responseData['data']['AdditionalDetails'] as $index => $detail)
            <div class="form-group">
                <label for="additionalName_{{ $index }}">Detail Name</label>
                <input type="text" id="additionalName_{{ $index }}" name="additionalDetails[{{ $index }}][Name]" value="{{ $detail['Name'] ?? 'N/A' }}" disabled>
            </div>
            <div class="form-group">
                <label for="additionalValue_{{ $index }}">Detail Value</label>
                <input type="text" id="additionalValue_{{ $index }}" name="additionalDetails[{{ $index }}][Value]" value="{{ $detail['Value'] ?? 'N/A' }}">
            </div>
        @endforeach
    @else
        <p>No Additional Details Available</p>
    @endif
    <input type="text" hidden name="billerId" value="{{$billerId}}">
    <input type="text" hidden name="initChannel" value="{{$initChannel}}">
    <input type="text" hidden name="macAddress" value="{{$macAddress}}">
    <input type="text" hidden name="ipAddress" value="{{$ipAddress}}">
    <input type="text" hidden name="latitude" id="latitude">
    <input type="text" hidden name="longitude" id="longitude">
    <button type="submit">Proseed</button>
</form>

<script>
    // Geolocation API to auto-detect latitude and longitude
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            document.getElementById('latitude').value = position.coords.latitude;
            document.getElementById('longitude').value = position.coords.longitude;
        }, function(error) {
            console.error("Geolocation error:", error);
        });
    } else {
        console.error("Geolocation is not supported by this browser.");
    }
</script>
@endsection
