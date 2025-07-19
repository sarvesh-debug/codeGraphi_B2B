@extends('user/include.layout')
@section('content')
@include('user.dmtpaysprint.navbar')
    <div class="container mt-5">
        <h2>Beneficiary Registration</h2>

        {{-- Display Error Message if Registration Fails --}}
        @if (isset($error))
            <div class="alert alert-danger">
                {{ $error }}
            </div>
        
        {{-- Display Success Message and Beneficiary Data if Registration is Successful --}}
        @elseif (isset($data) && $data['status'] === true)
            <div class="alert alert-success">
                {{ $data['message'] }}
            </div>
            
            <h4>Beneficiary Details</h4>
            <table class="table table-bordered mt-3">
                <tr>
                    <th>Beneficiary ID</th>
                    <td>{{ $data['data']['bene_id'] }}</td>
                </tr>
                <tr>
                    <th>Bank ID</th>
                    <td>{{ $data['data']['bankid'] }}</td>
                </tr>
                <tr>
                    <th>Bank Name</th>
                    <td>{{ $data['data']['bankname'] }}</td>
                </tr>
                <tr>
                    <th>Name</th>
                    <td>{{ $data['data']['name'] }}</td>
                </tr>
                <tr>
                    <th>Account Number</th>
                    <td>{{ $data['data']['accno'] }}</td>
                </tr>
                <tr>
                    <th>IFSC Code</th>
                    <td>{{ $data['data']['ifsc'] }}</td>
                </tr>
                <tr>
                    <th>Verified</th>
                    <td>{{ $data['data']['verified'] }}</td>
                </tr>
                <tr>
                    <th>Bank Type</th>
                    <td>{{ $data['data']['banktype'] }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>{{ $data['data']['status'] }}</td>
                </tr>
                {{-- <tr>
                    <th>Bank3</th>
                    <td>{{ $data['data']['bank3'] ? 'Yes' : 'No' }}</td>
                </tr> --}}
            </table>
        
        {{-- Display a Warning if No Data is Available --}}
        @else
            <div class="alert alert-warning">
                No beneficiary information available.
            </div>
        @endif
    </div>
    @endsection
