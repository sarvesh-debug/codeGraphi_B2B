@extends('admin.include.layout')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-success text-white text-center">
            <h3  style="color:aliceblue; font-weight: bold;">{{ isset($otherService) ? 'Edit' : 'Add' }} Other Service</h3>
        </div>
        <div class="card-body">
            {{-- @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif --}}

            <form action="{{ isset($otherService) ? route('otherServices.update', $otherService->id) : route('otherServices.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @isset($otherService)
                    @method('PUT')
                @endisset

                <div class="form-group mb-3">
                    <label class="form-label">Logo</label>
                    <input type="file" name="logo_name" class="form-control">
                    @isset($otherService)
                        <img src="{{ asset('uploads/'.$otherService->logo_name) }}" width="50" height="50">
                    @endisset
                </div>

                <div class="form-group mb-3">
                    <label class="form-label">Service Name</label>
                    <input type="text" name="service" class="form-control" value="{{ $otherService->service ?? '' }}" required>
                </div>

                <div class="form-group mb-3">
                    <label class="form-label">Link</label>
                    <input type="url" name="service_link" class="form-control" value="{{ $otherService->service_link ?? '' }}" required>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-success">{{ isset($otherService) ? 'Update' : 'Submit' }}</button>
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
                    <h5 class="mt-2 text-dark">{{ session('success') }}</h5>
                @elseif(session('error'))
                    <img src="https://media.giphy.com/media/TqiwHbFBaZ4ti/giphy.gif" alt="Failed" width="80">
                    <h5 class="mt-2 text-danger">{{ session('error') }}</h5>
                @endif
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal" style="background: linear-gradient(to right, #0a22aa, #b62512); color: white; border: none;">Close</button>
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
