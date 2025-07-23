@extends('user/include.layout')

@section('content')
<div class="container py-4">
    <h2>Start CMS</h2>

    <form method="POST" action="{{ route('cms.start.submit') }}" id="cmsForm">
        @csrf
        <input type="hidden" name="latitude" id="latitude">
        <input type="hidden" name="longitude" id="longitude">
        <button type="submit" class="btn btn-success">Start CMS</button>
    </form>

    @if(session('response'))
        <div class="alert alert-info mt-3">
            <pre>{{ json_encode(session('response'), JSON_PRETTY_PRINT) }}</pre>
        </div>
    @endif
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                document.getElementById("latitude").value = position.coords.latitude;
                document.getElementById("longitude").value = position.coords.longitude;
            }, function (error) {
                alert("Geolocation permission denied or unavailable.");
            });
        } else {
            alert("Geolocation is not supported by this browser.");
        }
    });
</script>
@endsection