@extends('admin/include.layout') 

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-success text-white text-center">
            <h3  style="color:aliceblue; font-weight: bold;">Update Latest News and Emergency Update</h3>
        </div>
        <div class="card-body">
            {{-- @if(session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif --}}

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
<div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content text-center">
            <div class="modal-body">
                @if(session('success'))
                    <img src="https://cdn-icons-png.flaticon.com/512/5610/5610944.png" alt="Success" width="80">
                    <h5 class="mt-2 text-success">{{ session('success') }}</h5>
                @elseif(session('error'))
                    <img src="https://media.giphy.com/media/TqiwHbFBaZ4ti/giphy.gif" alt="Failed" width="80">
                    <h5 class="mt-2 text-danger">{{ session('error') }}</h5>
                @endif
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        @if(session('success') || session('error'))
            var modal = new bootstrap.Modal(document.getElementById('statusModal'));
            modal.show();
        @endif
    });

    (function () {
        'use strict';
        const forms = document.querySelectorAll('.needs-validation');
        Array.from(forms).forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    })();
</script>

@endsection
