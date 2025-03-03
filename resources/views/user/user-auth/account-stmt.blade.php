@extends('user.include.layout')

@section('content')
<div class="container-fluid px-4">
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>
        <li class="breadcrumb-item active">Bank Statement</li>
    </ol>

    @if($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-header">
            <h3>Fetch Bank Statement</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('bank.statement') }}" method="post">
                @csrf
                <div class="mb-3">
                    <label for="accountNumber" class="form-label">Account Number</label>
                    <input type="text" id="accountNumber" name="accountNumber" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="txnDateFrom" class="form-label">Transaction Date From</label>
                    <input type="date" id="txnDateFrom" name="txnDateFrom" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="txnDateTo" class="form-label">Transaction Date To</label>
                    <input type="date" id="txnDateTo" name="txnDateTo" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Fetch Statement</button>
            </form>
        </div>
    </div>

    @if(!empty($responseData))
        <div class="card">
            <div class="card-header">
                <h3>Transaction Details</h3>
            </div>
            <div class="card-body">
                <pre>{{ json_encode($responseData, JSON_PRETTY_PRINT) }}</pre>
            </div>
        </div>
    @endif
</div>
@endsection
