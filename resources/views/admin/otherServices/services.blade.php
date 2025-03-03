@extends('admin/include.layout') 

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-success text-white text-center">
            <h3>Add Other Service</h3>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{route('store.showServices')}}" method="POST" class="needs-validation" novalidate enctype="multipart/form-data">
                @csrf

                <div class="form-group mb-3">
                    <label for="logo" class="form-label">Logo</label>
                    <input type="file" name="logo_name" id="logo_name" class="form-control" required>
                    <div class="invalid-feedback">Please choose the Logo.</div>
                </div>

                <div class="form-group mb-3">
                    <label for="helpline_no" class="form-label">Service Name</label>
                    <input type="text" name="service" id="helpline_no" class="form-control" placeholder="Enter Helpline No" required>
                    <div class="invalid-feedback">Please enter Service Name.</div>
                </div>

                <div class="form-group mb-3">
                    <label for="account_no" class="form-label">Link</label>
                    <input type="url" name="service_link" id="tsn_no" class="form-control" placeholder="Enter TSN number" required>
                    <div class="invalid-feedback">Please enter link.</div>
                </div>
                
               

                <div class="text-center">
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
