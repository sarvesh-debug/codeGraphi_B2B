@extends('user/include.layout')
@section('content')
@include('user.beneficiary.navbar')

<!-- Display API response after form submission -->
@if(isset($responseData))
    <div class="mt-4">
        <h5 class="text-center text-success">{{ $responseData['message'] ?? 'No message' }}</h5>
        <ul class="list-group mt-3">
            <li class="list-group-item"><strong>Status:</strong> {{ $responseData['status'] ? 'Success' : 'Failed' }}</li>
            @if(isset($responseData['data']))
                <!-- Display each response data item -->
                @foreach($responseData['data'] as $key => $value)
                    <li class="list-group-item"><strong>{{ ucfirst($key) }}:</strong> {{ $value }}</li>
                @endforeach
            @endif
        </ul>
    </div>
@endif

<!-- JavaScript for auto-redirect after 5 seconds -->
<script>
    setTimeout(function() {
        window.location.href = "{{ route('fetch.form') }}"; // Redirect to the 'fetch.form' route
    }, 2000); // 5000ms = 5 seconds
</script>
@endsection

