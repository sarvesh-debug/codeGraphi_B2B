@extends('admin/include.layout') 

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-success text-white text-center">
            <h3>Update Latest News and Emergency Update</h3>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('otherServices.update') }}" method="POST" class="needs-validation" novalidate enctype="multipart/form-data">
                @csrf
            
                <div class="form-group mb-3">
                    <label for="latest_news" class="form-label">Latest News</label>
                    <textarea class="form-control" name="lst_news" id="latest_news" cols="10" rows="5">{{ $getData->latest_news ?? '' }}</textarea>
                    <div class="invalid-feedback">Please enter the latest news.</div>
                </div>
            
                <div class="form-group mb-3">
                    <label for="emergency_update" class="form-label">Emergency Update</label>
                    <textarea class="form-control" name="emr_news" id="emergency_update" cols="10" rows="5">{{ $getData->emergency_update ?? '' }}</textarea>
                    <div class="invalid-feedback">Please enter an emergency update.</div>
                </div>
            
                <div class="text-center">
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </form>
            
        </div>
    </div>
</div>

@endsection
