@extends('user/include.layout')
@section('content')
<div class="container-fluid px-4">
    @include('user.account-verification.navbar')
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('customer/dashboard') }}">Home</a></li>
        <li class="breadcrumb-item active">Bank List</li>
    </ol>

    @if($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    @if(!empty($responseData['data']))
        <div class="card-body table-scroll">
            <table id="datatablesSimple" class="table table-bordered">
                <thead>
                    <tr>
                        <th>Bank ID</th>
                        <th>Name</th>
                        <th>IFSC Global</th>
                        <th>IMPS Enabled</th>
                        <th>UPI Enabled</th>
                        <th>IMPS Penny Less</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Bank ID</th>
                        <th>Name</th>
                        <th>IFSC Global</th>
                        <th>IMPS Enabled</th>
                        <th>UPI Enabled</th>
                        <th>IMPS Penny Less</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($responseData['data'] as $bank)
                        <tr>
                            <td>{{ $bank['bankId'] }}</td>
                            <td>{{ $bank['name'] }}</td>
                            <td>{{ $bank['ifscGlobal'] }}</td>
                            <td>{{ $bank['impsEnabled'] ? 'Yes' : 'No' }}</td>
                            <td>{{ $bank['upiEnabled'] ? 'Yes' : 'No' }}</td>
                            <td>{{ $bank['impsPennyLess'] ? 'Yes' : 'No' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p>No banks found or an error occurred.</p>
    @endif
</div>
@endsection
