@extends('user/include.layout')
@section('content')

<div class="container py-4 d-flex justify-content-center">
    <div class="col-lg-6 col-md-8 col-sm-12">
        <h2 class="text-center mb-4">🧾 Create UPI Order</h2>

        @if(session('error'))
            <div class="alert alert-info">
                <strong>Messahe:</strong>
                <pre class="bg-light p-2 rounded">{{ session('error') }}</pre>
            </div>
        @endif

        <div class="card mb-4">
            <div class="card-header bg-primary text-white">Create Order</div>
            <div class="card-body">
                <form method="POST" action="{{ route('digifintel.create') }}">
                    @csrf
                    <input class="form-control mb-3 my-2" name="amount" placeholder="Amount (e.g. 1.00)" required>
                    <input class="form-control mb-3"  name="email" value="{{session('email')}}" placeholder="Customer Email" required>
                    <input class="form-control mb-3"  name="phone" value="{{session('mobile')}}" placeholder="Customer Phone" required>
                    <button class="btn btn-primary w-100">Create Order</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
