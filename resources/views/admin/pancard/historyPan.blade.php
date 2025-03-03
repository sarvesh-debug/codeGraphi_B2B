@extends('admin/include.layout')

@section('content')
<div class="container-fluid px-4">

    
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('customer/dashboard') }}">Home</a></li>
        <li class="breadcrumb-item active">PAN Responses</li>
    </ol>
    <a  class="btn btn-success text-white"> Pan Card Balance ₹{{ number_format((float) $balance, 2) }}</a>
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if($responses->isNotEmpty())
        <div class="card-body table-scroll">
            <table id="datatablesSimple" class="table table-bordered">
                <thead>
                    <tr>
                        <th>SR</th>
                        <th>Order ID</th>
                        <th>Retailler Name</th>
                        <th>Retailler Id</th>
                        <th>Number</th>
                        <th>Mode</th>
                        <th>Apply</th>
                        <th>Balance</th>
                        <th>Status </th>
                        <th>Apply On</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>SR</th>

                        <th>Order ID</th>
                        <th>Retailler Name</th>
                        <th>Retailler Id</th>
                        <th>Number</th>
                        <th>Mode</th>
                        <th>Apply</th>
                        <th>Balance</th>
                        <th>Status</th>
                        <th>Apply On</th>
                        
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($responses as $response)
                    @php
            // Extract raw response body and remove HTML comments if necessary
            $cleanedResponse = preg_replace('/<!--.*?-->/', '', $response->response_body);

            // Decode the JSON content
            $responseBody = json_decode($cleanedResponse, true);

            // Get the 'status' value, default to 'N/A' if not found
            $status = $responseBody['status'] ?? 'SUCCESS';
        @endphp
                        <tr>
                            <td>{{ $loop->count - $loop->iteration + 1 }}</td>

                            <td>{{ $response->order_id }}</td>
                            <td>{{ $response->name }}</td>
                            <td>{{ $response->username }}</td>
                            <td>{{ $response->number }}</td>
                            <td>{{ $response->mode }}</td>
                            <td>{{ $response->apply_for }}</td>
                            <td>{{ $response->balance }}</td>
                            <td>{{ $status }}</td>
                            {{-- <td><pre>{{ json_encode(json_decode($response->response_body), JSON_PRETTY_PRINT) }}</pre></td> --}}
                            <td>{{ $response->created_at->format('d-m-Y H:i:s') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p>No Records found.</p>
    @endif
</div>
@endsection
