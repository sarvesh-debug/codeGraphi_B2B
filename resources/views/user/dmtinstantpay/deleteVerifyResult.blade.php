@extends('user/include.layout')

@section('content')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5>Beneficiary Delete Verification</h5>
                </div>
                <div class="card-body">
                    @if(isset($response))
                        <div class="alert alert-info">
                            Beneficiary Delete Successfully
                        </div>
                    @else
                        <div class="alert alert-warning">
                            <strong>Beneficiary Delete Successfully</strong>
                        </div>
                    @endif
                    
                    <a href="{{route('dmt.remitter-profile')}}" class="btn btn-secondary">Go Back</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
