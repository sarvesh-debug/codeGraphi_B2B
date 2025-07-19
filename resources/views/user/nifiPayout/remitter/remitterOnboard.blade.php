@extends('user/include.layout')
@section('content')
<div class="card col-md-6 mx-auto shadow-lg border-0">
    <div class="alert alert-danger">
        <strong>{{$msg}}</strong>
    </div>
    <div class="card-header py-3">
        <h4 class="card-heading mb-0">Remitter Register</h4>
    </div>
    <div class="card-body p-4">
       <form action="{{ route('remitterRegistrationCG') }}" method="POST">
    @csrf

    <!-- Mobile (Read-only) -->
    <div class="form-group mb-3">
        <label class="form-label">Mobile</label>
        <input type="text" class="form-control" value="{{ $mobile }}" readonly name="mobileNumber" required>
    </div>

   

   

    <!-- PAN -->
    <div class="form-group mb-3">
        <label class="form-label">PAN No</label>
       <input type="text" class="form-control" name="panno" required
    pattern="^[A-Z]{5}[0-9]{4}[A-Z]{1}$"
    title="Enter a valid 10-character PAN number (e.g., ABCDE1234F)"
    style="text-transform: uppercase;"
    oninput="this.value = this.value.toUpperCase()">

    </div>


    <!-- Submit -->
    <button type="submit" class="btn btn-success w-100">Register</button>
</form>

    </div>
</div>


@endsection


