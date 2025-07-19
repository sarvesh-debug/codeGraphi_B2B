@extends('user/include.layout')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-danger text-white">
                    <h5 class="card-heading">Error in OTP Deletion</h5>
                </div>
                <div class="card-body">
                    <h3 class="text-danger">Error Details</h3>
                    @if(isset($response) && $response !== null)
                        <div class="alert alert-danger">
                            <strong>Status:</strong> {{ $response['status'] }}
                            <br><strong>Message:</strong> {{ $response['statuscode'] }}
                            <br><strong>Details:</strong> {{ $response['actcode'] }}
                            @if(isset($response['data']) && empty($response['data']))
                                <p>No further details available.</p>
                            @endif
                        </div>
                    @else
                        <div class="alert alert-danger">
                            <strong>Error:</strong> {{ $error ?? 'An unknown error occurred.' }}
                        </div>
                    @endif

                    <a href="{{ url()->previous() }}" class="btn btn-secondary">Go Back</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection