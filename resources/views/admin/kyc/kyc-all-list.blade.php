@extends('admin/include.layout') 

@section('content') 
<div class="container-fluid px-4">
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
        <li class="breadcrumb-item active">All User</li>
    </ol>
    
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <div class="card-body table-scroll">
        <table id="datatablesSimple" class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Aadhar</th>
                    <th>PAN</th>
                    <th>City</th>
                    <th>State</th>
                    <th>Status</th>
                    <th>Outlet Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Aadhar</th>
                    <th>PAN</th>
                    <th>City</th>
                    <th>State</th>
                    <th>Status</th>
                    <th>Outlet Name</th>
                    <th>Actions</th>
                </tr>
            </tfoot>
            <tbody> 
                @foreach($users as $user)
                <tr>
                    <td>{{ $loop->iteration }}</td> 
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->aadhaar }}</td>
                    <td>{{ $user->pan }}</td>
                    <td>{{ $user->city }}</td>
                    <td>{{ $user->state }}</td>
                    <td>
                        @if ($user->done == 1)
                            <span class="text-success blinking">Verified</span>
                        @else
                            <span class="text-danger blinking">Not Verified</span>
                        @endif
                    </td>
                    <td>{{ $user->outlet_name }}</td>
                    <td>
                        <a href="{{ route('admin/kyc.details', $user->id) }}" class="btn btn-primary btn-sm">Preview</a>
                        {{-- <button class="btn btn-danger btn-sm">Delete</button> --}}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<style>
    .blinking {
        animation: blink-animation 1s steps(5, start) infinite;
    }

    @keyframes blink-animation {
        to {
            visibility: hidden;
        }
    }
</style>
@endsection
