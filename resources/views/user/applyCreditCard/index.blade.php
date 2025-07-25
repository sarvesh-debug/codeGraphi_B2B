@extends('user/include.layout')

@section('content')
<div class="container-fluid px-4">
   
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('customer/dashboard') }}">Home</a></li>
        <li class="breadcrumb-item active">Credit Card Apply Links</li>
    </ol>

    <!-- Generate Lead Button -->
    {{-- <form method="POST" action="{{ url('/generate-lead') }}" class="mb-3">
        @csrf
        <button type="submit" class="btn  gradient-btn">Apply New </button>
    </form> --}}

    <form method="POST" action="{{ url('/generate-lead') }}" class="mb-3">
        @csrf
        <button type="submit" class="btn gradient-btn text-white fw-bold px-4 py-2">
            Apply New
        </button>
    </form>

    <style>
        .gradient-btn {
        background: linear-gradient(135deg, #ff0000, #1e3c72);
        border: none;
        border-radius: 8px;
        transition: background 0.4s ease, transform 0.2s ease;
    }

    .gradient-btn:hover {
        background: linear-gradient(135deg, #1e3c72, #ff0000);
        transform: scale(1.03);
    }

    </style>

    <!-- Error Display -->
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <!-- Lead Links Table -->
    @if(isset($leads) && $leads->isNotEmpty())
        <div class="card">
            <div class="card-header bg-success text-white" style="background: linear-gradient(to right, #0a22aa, #b62512); color: white; border: none;">Generated Links</div>
            <div class="card-body table-scroll">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Ref ID</th>
                            <th>Request ID</th>
                            <th>Link</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($leads as $index => $lead)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $lead->refid }}</td>
                                <td>{{ $lead->request_id }}</td>
                                <td><a href="{{ $lead->link }}" target="_blank">Open Link</a></td>
                                <td>{{ $lead->created_at->format('d-m-Y H:i:s') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination -->
                
            </div>
        </div>
    @else
        <p>No lead links found yet. Click "Generate New Lead" to create one.</p>
    @endif
</div>
@endsection
