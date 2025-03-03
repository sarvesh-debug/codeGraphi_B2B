@extends('user/include.layout')

@section('content')
    <div class="card col-md-6 mx-auto shadow-lg border-0 mt-5">
        <div class="card-header bg-danger text-white text-center py-3">
            <h4 class="mb-0">Failed</h4>
        </div>
        <div class="card-body p-4">
            <p><strong>Error:</strong> {{ $error }}</p>
            {{-- <a href="{{ route('beneficiaryRegistrationForm') }}" class="btn btn-danger">Try Again</a> --}}
        </div>
    </div>
@endsection
