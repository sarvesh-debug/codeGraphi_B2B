@extends('user.include.layout')

@section('content')
<div class="container-fluid px-4">
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('customer/dashboard') }}">Home</a></li>
        <li class="breadcrumb-item active">Send Money</li>
    </ol>
    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
{{-- @if (session('alert'))
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        {{ session('alert') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif --}}
@if (session('alert'))
    <script>
        alert("{{ session('alert') }}");
        window.location.href = "{{ route('dmt.remitter-profile') }}";
    </script>
@endif


    <div class="card mt-4">
        <div class="card-header">
            <h5 class="card-heading">Send Money</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('generateTransactionOtp') }}" method="POST">
                @csrf
                <div class="form-group mb-3">
                    <label for="amount" class="form-label">Amount</label>
                    <input type="number" name="amount" id="amount" min="100" class="form-control" placeholder="Enter amount" required>
                </div>

               
                    <input type="text"hidden name="mobile" id="mobile" class="form-control" value="{{ $mobile }}" readonly>
            

                
                    <input type="text"hidden name="account" id="account" class="form-control" value="{{ $account }}" readonly>
                
                    <input type="text"hidden name="ifsc" id="ifsc" class="form-control" value="{{ $ifsc }}" readonly>
                
                    <input type="text"hidden name="referenceKey" id="referenceKey" class="form-control" value="{{ $referenceKey }}" readonly>
          

                <button type="submit" class="btn btn-success w-100">Send Money</button>
            </form>
        </div>
    </div>
</div>
@endsection
