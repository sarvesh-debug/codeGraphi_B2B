@extends('admin.include.layout')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Edit Employee - {{ $employee->username }}</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('employees.update', $employee->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="{{ $employee->name }}" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ $employee->email }}" required>
        </div>

        <div class="mb-3">
            <label>Phone</label>
            <input type="text" name="phone" class="form-control" value="{{ $employee->phone }}" required>
        </div>

        <div class="mb-3">
            <label>New Password <small>(Leave blank to keep current)</small></label>
            <input type="password" name="password" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary py-2 px-4" style="background: linear-gradient(to right, #0a22aa, #b62512); color: white; border: none;">Update</button>
        <a href="{{ route('employees.index') }}" class="btn btn-secondary py-2 px-4">Back</a>
    </form>
</div>
@endsection
