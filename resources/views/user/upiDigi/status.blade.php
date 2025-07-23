@extends('user/include.layout')
@section('content')

<div class="container py-4 d-flex justify-content-center">
    <div class="col-lg-6 col-md-8 col-sm-12">
        <h2 class="text-center mb-4">📦 Check UPI Order Status</h2>

       
            <div class="alert alert-info">
              
                <pre class="bg-light p-2 rounded">{{$message}}</pre>
            </div>

        <div class="card mb-4">
            <div class="card-header bg-warning text-dark">Check Order Status</div>
            <div class="card-body">
                <form method="POST" action="{{ route('digifintel.status') }}">
                    @csrf
                    <input class="form-control mb-3" value="{{$referenceId}}" name="referenceId" placeholder="Reference ID" required>
                    <button class="btn btn-warning w-100">Check Order Status</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
