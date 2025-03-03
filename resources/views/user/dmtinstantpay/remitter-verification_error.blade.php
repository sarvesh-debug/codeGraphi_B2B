@extends('user.include.layout')

@section('content')

<div class="container mt-5">
    <div class="card shadow p-4">
        <h4 class="text-center mb-4">Verification Response</h4>

        @if(isset($statuscode) && isset($status))
            <div class="table-responsive">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th>Status Code</th>
                            <td>{{ $statuscode }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>{{ $status }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-warning">
                No response received.
            </div>
        @endif

        @if(isset($error))
            <div class="alert alert-danger">
                {{ $error }}
            </div>
        @endif
    </div>
</div>

@endsection
