@extends('user/include.layout')

@section('content')
<div class="container">
    <h2>Edit Package</h2>

    {{-- Show validation errors --}}
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

    <form action="{{ route('packages.update', $package->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Package Name --}}
        <div class="mb-3">
            <label for="packageName" class="form-label">Package Name</label>
            <input type="text" name="packageName" class="form-control"
                   value="{{ old('packageName', $package->packageName) }}" required>
        </div>

        {{-- Status --}}
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" class="form-control">
                <option value="1" {{ $package->status == 1 ? 'selected' : '' }}>Active</option>
                <option value="0" {{ $package->status == 0 ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        {{-- Created By (read-only) --}}
        <div class="mb-3">
            <label for="created_by" class="form-label">Created By</label>
            <input type="text" class="form-control" 
                   value="{{ $package->created_by ?? 'N/A' }}" readonly name="created_by">
        </div>
         <input type="hidden" name="creater_id" value="{{ $package->creater_id ?? 'N/A' }}">

        <button type="submit" class="btn btn-primary">Update Package</button>
        <a href="{{ route('packages.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
