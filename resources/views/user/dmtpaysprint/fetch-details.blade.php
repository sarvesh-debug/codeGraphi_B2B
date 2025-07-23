@extends('user/include.layout')

@section('content')
<div class="container-fluid px-4">
    @include('user.dmtpaysprint.navbar')
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('customer/dashboard') }}">Home</a></li>
        <li class="breadcrumb-item active">All Beneficiaries</li>
    </ol>
<div> 
    <a href="{{ route('1register.form', ['mobile' => $mobile]) }}" class="btn btn-success">Add Beneficiary</a>


</div>
    @if(!empty($beneficiaries))
        <div class="card-body table-scroll">
            <table id="datatablesSimpleAll" class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Bene ID</th>
                        <th>Bank Name</th>
                        <th>Name</th>
                        <th>Account Number</th>
                        <th>IFSC</th>
                        <th>Verified</th>
                        <th>Bank Type</th>
                        <th>Send</th>
                        <th>delete</th>
                        
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Bene ID</th>
                        <th>Bank Name</th>
                        <th>Name</th>
                        <th>Account Number</th>
                        <th>IFSC</th>
                        <th>Verified</th>
                        <th>Bank Type</th>
                        <th>Send</th>
                        <th>delete</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach($beneficiaries as $beneficiary)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $beneficiary['bene_id'] }}</td>
                            <td>{{ $beneficiary['bankname'] }}</td>
                            <td>{{ $beneficiary['name'] }}</td>
                            <td>{{ $beneficiary['accno'] }}</td>
                            <td>{{ $beneficiary['ifsc'] }}</td>
                            <td>{{ $beneficiary['verified'] == '1' ? 'Yes' : 'No' }}</td>
                            <td>{{ $beneficiary['banktype'] }}</td>
                            <td>
                                <a href="{{ route('1send.otp', ['mobile' => $mobile, 'bene_id' => $beneficiary['bene_id']]) }}" class="btn btn-success">Send</a>
                            </td>
                            
                            <td> <a href="{{ route('1delete.form', ['mobile' => $mobile, 'bene_id' => $beneficiary['bene_id']]) }}" class="btn btn-danger">Delete</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p>No beneficiaries found.</p>
    @endif
</div>
@endsection
