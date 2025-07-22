@extends('admin.include.layout')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">All Employees</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- <a href="{{ route('employees.create') }}" class="btn btn-primary mb-3">+ Add New Employee</a> --}}
    <a href="{{ route('employees.create') }}"
        class="btn text-white mb-3 px-4 py-2"
        style="background: linear-gradient(135deg, #3a1c71, #d3182b); border: none; transition: 0.3s ease;">
        + Add New Employee
    </a>

      <form method="GET" action="{{ route('employees.index') }}" class="row mb-4">
    <div class="col-md-4">
        <input type="text" name="search" class="form-control" placeholder="Search by name or email" value="{{ request('search') }}">
    </div>
    <div class="col-md-2">
        {{-- <button class="btn btn-info">Search</button> --}}
        <button class="btn text-white" style="background: linear-gradient(135deg, #3a1c71, #d3182b, #d3182b); border: none;">
            Search
        </button>

        {{-- <a href="{{ route('employees.index') }}" class="btn btn-secondary">Reset</a> --}}
    </div>
</form>

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle text-center">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Username</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($employees as $key => $employee)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $employee->username }}</td>
                    <td>{{ $employee->name }}</td>
                    <td>{{ $employee->email }}</td>
                    <td>{{ $employee->phone }}</td>
                    <td><span class="badge bg-success">{{ $employee->role }}</span></td>
                    <td>
                        <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-sm btn-warning" style="background: linear-gradient(to right, #0a22aa, #b62512); color: white; border: none;">Edit</a>

                        <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this employee?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                    <tr><td colspan="7">No employees found.</td></tr>
                @endforelse
            </tbody>
        </table>
       <div class="d-flex justify-content-between align-items-center mt-4">
    <div>
        Showing {{ $employees->firstItem() }} to {{ $employees->lastItem() }} of {{ $employees->total() }} results
    </div>
    <div>
        {{ $employees->appends(request()->query())->links() }}
    </div>
</div>

    </div>
</div>
@endsection
