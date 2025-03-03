@extends('user.include.layout')

@section('content')
<div class="container">
    <h1 class="mt-4">Fetch Transaction Statement</h1>
    <form action="{{ route('transactions.fetch') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="accountNumber" class="form-label">Account Number</label>
            <input type="text" class="form-control" id="accountNumber" name="accountNumber" required>
        </div>
        <div class="mb-3">
            <label for="txnDateFrom" class="form-label">Transaction Date From</label>
            <input type="date" class="form-control" id="txnDateFrom" name="txnDateFrom" required>
        </div>
        <div class="mb-3">
            <label for="txnDateTo" class="form-label">Transaction Date To</label>
            <input type="date" class="form-control" id="txnDateTo" name="txnDateTo" required>
        </div>
        <button type="submit" class="btn btn-primary">Fetch Statement</button>
    </form>
</div>
@endsection
