@extends('admin.include.layout')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-success text-white text-center">
            <h3>{{ isset($otherService) ? 'Edit' : 'Add' }} Other Service</h3>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ isset($otherService) ? route('otherServices.update', $otherService->id) : route('otherServices.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @isset($otherService)
                    @method('PUT')
                @endisset

                <div class="form-group mb-3">
                    <label class="form-label">Logo</label>
                    <input type="file" name="logo_name" class="form-control">
                    @isset($otherService)
                        <img src="{{ asset('uploads/'.$otherService->logo_name) }}" width="50" height="50">
                    @endisset
                </div>

                <div class="form-group mb-3">
                    <label class="form-label">Service Name</label>
                    <input type="text" name="service" class="form-control" value="{{ $otherService->service ?? '' }}" required>
                </div>

                <div class="form-group mb-3">
                    <label class="form-label">Link</label>
                    <input type="url" name="service_link" class="form-control" value="{{ $otherService->service_link ?? '' }}" required>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-success">{{ isset($otherService) ? 'Update' : 'Submit' }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
