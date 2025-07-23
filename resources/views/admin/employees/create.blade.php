@extends('admin.include.layout')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Add New Employee</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('employees.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Name <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control" placeholder="Full Name" required>
        </div>

        <div class="mb-3">
            <label>Email <span class="text-danger">*</span></label>
            <input type="email" name="email" class="form-control" placeholder="example@mail.com" required>
        </div>

        <div class="mb-3">
            <label>Phone <span class="text-danger">*</span></label>
            <input type="text" name="phone" class="form-control" placeholder="Mobile Number" required>
        </div>

        <div class="mb-3">
            <label>Password <span class="text-danger">*</span></label>
            <input type="password" name="password" class="form-control" placeholder="Create a password" required>
        </div>
        <div class="mb-3">
            <label>Confirm Password <span class="text-danger">*</span></label>
            <input type="password" name="password_confirmation" class="form-control" placeholder="Re-enter password" required>
        </div>
        <button type="submit" class="btn btn-success" style="background: linear-gradient(to right, #0a22aa, #b62512); color: white; border: none;">Create Employee</button>
        <a href="{{ route('employees.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
