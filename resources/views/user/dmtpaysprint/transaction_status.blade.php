@extends('user/include.layout')

@section('content')
@include('user.dmtpaysprint.navbar')

<div class="card col-md-6 mx-auto shadow-lg border-0">
    <div class="card-header bg-info text-white text-center py-3">
        <h4 class="mb-0">Transaction Status</h4>
    </div>
    <div class="card-body p-4">
        <form action="{{ route('1transact.performStaus') }}" method="POST">
            @csrf
            <div class="form-group mb-3">
                <label for="bene_id" class="form-label">Reference ID:</label>
                <input type="text" class="form-control" name="referenceid" id="referenceid" required>
            </div>
            <button type="submit" class="btn btn-info w-100">Transaction</button>
        </form>
    </div>
</div>
@endsection
