@extends('user/include.layout')
@section('content')
@include('user.dmtpaysprint.navbar')

<div class="card col-md-6 mx-auto shadow-lg border-0">
    <div class="card-header bg-danger text-white text-center py-3">
        <h4 class="mb-0">Delete Beneficiary</h4>
    </div>
    <div class="card-body p-4">
        <form action="{{ route('1delete.beneficiary') }}" method="POST">
            @csrf
            <span>Are You Sure Delete Beneficiary</span>
                <input type="text" hidden  class="form-control" value="{{$mobile}}" id="mobile" name="mobile" required>
           
                <input type="text"  hidden class="form-control" value="{{$bene_id}}" id="bene_id" name="bene_id" required>
           
            <button type="submit" class="btn btn-danger w-100">Delete</button>
        </form>
    </div>
</div>


@endsection