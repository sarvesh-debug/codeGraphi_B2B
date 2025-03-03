@extends('user.include.layout') <!-- Adjust if you're using a different layout -->

@section('content')
    <div class="container">
        <h2>PAN Application Response</h2>

        <!-- Displaying the response data -->
        @if(!empty($data))
            <div class="card my-4">
                <div class="card-body">
                    <h5>Response Details</h5>
                    <ul class="list-group">
                        @foreach($data as $key => $value)
                            <li class="list-group-item">
                                <strong>{{ ucfirst(str_replace('_', ' ', $key)) }}:</strong> {{ $value }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @else
            <div class="alert alert-warning">
                No response data available.
            </div>
        @endif

        <a href="{{route('panCard')}}" class="btn btn-success">Back</a>
    </div>
@endsection
