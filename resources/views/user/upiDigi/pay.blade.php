@extends('user/include.layout')
@section('content')

<div class="container py-4 d-flex justify-content-center">
    <div class="col-lg-6 col-md-8 col-sm-12">
        <h2 class="text-center mb-4">💸 Pay UPI Order</h2>

      
            <div class="alert alert-info">
              
                <pre class="bg-light p-2 rounded">{{$message}}</pre>
            </div>
     

        <div class="card mb-4">
            <div class="card-header bg-success text-white">Pay Order</div>
            <div class="card-body">
                <form method="POST" action="{{ route('digifintel.payorder') }}">
                    @csrf
                    <input class="form-control mb-3" name="amount" value="{{$amount}}" placeholder="Amount" required>
                    <input class="form-control mb-3" name="referenceId" value="{{$referenceId}}" placeholder="Reference ID from Create Order" required>
                    <input class="form-control mb-3" name="payerVpa" placeholder="Payer VPA (e.g. name@bank)" required>
                    <input class="form-control mb-3" name="payerName"  placeholder="Payer Name" required>
                    <input class="form-control mb-3" name="remarks" placeholder="Remarks" required>
                    <button class="btn btn-success w-100">Pay Order</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
