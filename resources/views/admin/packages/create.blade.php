@extends('admin/include.layout') 

@section('content')
<div class="container mt-5">
    <div class="card shadow rounded">
        <div class="card-header bg-primary text-white" style="background: linear-gradient(to right, #0a22aa, #b62512); color: white; border: none;">
            <h4 class="mb-0" style="color: white;">Create New Package</h4>
        </div>
        <div class="card-body">
            {{-- Display validation errors --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Show flash messages --}}
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            {{-- Form start --}}
            <form action="{{ route('packages.store') }}" method="POST">
                @csrf

                {{-- Package Name --}}
                <div class="mb-3">
                    <label for="packageName" class="form-label">Package Name</label>
                    <input type="text" name="packageName" id="packageName"
                        class="form-control @error('packageName') is-invalid @enderror"
                        value="{{ old('packageName') }}" placeholder="Enter package name" required>
                    @error('packageName')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Status --}}
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <div class="form-check">
                        <input type="radio" name="status" id="status_active" value="1"
                               class="form-check-input" {{ old('status', '1') == '1' ? 'checked' : '' }}>
                        <label for="status_active" class="form-check-label">Active</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" name="status" id="status_inactive" value="0"
                               class="form-check-input" {{ old('status') == '0' ? 'checked' : '' }}>
                        <label for="status_inactive" class="form-check-label">Inactive</label>
                    </div>
                    @error('status')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Created By (display only) --}}
                <div class="mb-3">
                    <label class="form-label">Created By</label>
                    <input type="text"name="created_by"  class="form-control" value="{{ Auth::user()->name }}">
                </div>

                {{-- Hidden field to store user_id (optional) --}}
                <input type="hidden" name="creater_id" value="{{ Auth::id() }}">

                {{-- Submit --}}
                <div class="text-end">
                    <button type="submit" class="btn btn-success" style="background: linear-gradient(to right, #0a22aa, #b62512); color: white; border: none;">Create Package</button>
                    <a href="{{ route('packages.index') }}" class="btn btn-secondary">Back</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
