@extends('user/include.layout')

@section('content')
<div class="container-fluid px-4">
    @include('user.beneficiary.navbar')
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('customer/dashboard') }}">Home</a></li>
        <li class="breadcrumb-item active">All Credit Card Applications</li>
    </ol>

    @if($applications->isNotEmpty())
        <div class="card-body table-scroll">
            <table id="datatablesSimpleAll" class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Pincode</th>
                        <th>PAN Number</th>
                        <th>Bank</th>
                        <th>Retailer Name</th>
                        <th>Retailer Username</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Pincode</th>
                        <th>PAN Number</th>
                        <th>Bank</th>
                        <th>Retailer Name</th>
                        <th>Retailer Username</th>
                        <th>Created At</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach($applications as $application)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $application->name }}</td>
                            <td>{{ $application->phone }}</td>
                            <td>{{ $application->pincode ?? 'N/A' }}</td>
                            <td>{{ $application->pan_no }}</td>
                            <td>{{ $application->bank }}</td>
                            <td>{{ $application->retailer_name }}</td>
                            <td>{{ $application->retailer_username }}</td>
                            <td>{{ $application->created_at->format('d-m-Y H:i:s') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p>No credit card applications found.</p>
    @endif
</div>
@endsection
{{--@extends('user/include.layout')

@section('content')
 <div class="container-fluid px-4">
    @include('user.beneficiary.navbar')
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('customer/dashboard') }}">Home</a></li>
        <li class="breadcrumb-item active">All Credit Card Applications</li>
    </ol>

    @if($applications->isNotEmpty())
        <div class="card-body table-scroll">
            <table id="datatablesSimpleAll" class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Pincode</th>
                        <th>PAN Number</th>
                        <th>Bank</th>
                        <th>Retailer Name</th>
                        <th>Retailer Username</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Pincode</th>
                        <th>PAN Number</th>
                        <th>Bank</th>
                        <th>Retailer Name</th>
                        <th>Retailer Username</th>
                        <th>Created At</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach($applications as $application)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $application->name }}</td>
                            <td>{{ $application->phone }}</td>
                            <td>{{ $application->pincode ?? 'N/A' }}</td>
                            <td>{{ $application->pan_no }}</td>
                            <td>{{ $application->bank }}</td>
                            <td>{{ $application->retailer_name }}</td>
                            <td>{{ $application->retailer_username }}</td>
                            <td>{{ $application->created_at->format('d-m-Y H:i:s') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p>No credit card applications found.</p>
    @endif
</div>
@endsection --}}
