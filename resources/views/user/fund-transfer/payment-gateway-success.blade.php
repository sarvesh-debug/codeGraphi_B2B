@extends('user.include.layout'){{-- Assuming you're extending a layout file --}}

@section('content')
<div class="container p-5">
    <div class="row">
        <div class="col-md-8 mb-2">
            <h2>Response</h2>
            <p>Payment Gateway - Test Response</p>

            {{-- Blade Syntax for Displaying the Transaction Status --}}
            @if(isset($txn_data))
                <div class="alert alert-success">
                    Transaction Status: {{ $txn_data['status'] }}
                </div>

                {{-- Table to Display Transaction Data --}}
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Key</th>
                            <th>Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($txn_data as $key => $value)
                            <tr>
                                <td>{{ $key }}</td>
                                <td>{{ $value }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="alert alert-danger">No transaction data found.</div>
            @endif
        </div>
    </div>
</div>
@endsection
