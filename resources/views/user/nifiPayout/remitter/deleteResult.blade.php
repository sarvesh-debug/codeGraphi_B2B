@extends('user.include.layout')

@section('content')
<div class="container py-4">
    {{-- Alert Box --}}
    @if($status === 'success')
        <div class="alert alert-success text-center fw-bold fs-5">
            {{ $message }}
        </div>
    @else
        <div class="alert alert-danger text-center fw-bold fs-5">
            {{ $message }}
        </div>
    @endif

    {{-- Back to Remitter Profile Form --}}
    <div class="card mt-4 shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Remitter Options</h5>
        </div>
        <div class="card-body text-center">
            <form action="{{ route('remProfilePost') }}" method="POST">
                @csrf
                <input type="hidden" name="mobileNumber" value="{{ $mobile }}">
                <button type="submit" class="btn btn-outline-primary">
                    🔁 Back to Remitter Profile
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
