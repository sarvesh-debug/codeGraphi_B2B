@extends('user/include.layout')

@section('content')
<div class="alert alert-danger shadow-lg rounded p-4 text-center">
    <div class="mb-3">
        <i class="fas fa-exclamation-triangle fa-3x text-danger"></i>
    </div>
    <h2 class="alert-heading fw-bold">Attention Please</h2>
    <p class="mb-0 text-dark">
        Insufficient Wallet Balance
    </p>
</div>
<a href="{{route('dmt.remitter-profile')}}" class="btn btn-success">Back</a>
@endsection