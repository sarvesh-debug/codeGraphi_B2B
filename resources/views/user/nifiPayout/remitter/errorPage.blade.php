@extends('user/include.layout')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center text-center">
        <div class="col-md-8">
            <div class="alert alert-danger shadow-lg">
                <h3 class="fw-bold"><i class="fas fa-exclamation-triangle me-2"></i>Oops! Something went wrong</h3>
                <p class="fs-5 mt-3">{{ $message ?? 'An unexpected error occurred. Please try again.' }}</p>
                
                @if(isset($back))
                    <a href="{{ route('remProfile') }}" class="btn btn-outline-secondary mt-3">Go Back</a>
                @else
                    <a href="{{ route('remProfile') }}" class="btn btn-danger mt-3">Go to Dashboard</a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
