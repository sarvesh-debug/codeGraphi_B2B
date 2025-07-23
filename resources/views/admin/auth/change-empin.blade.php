@extends('admin.include.layout')

@section('content')
<div class="container mt-5">
    <div class="card col-md-6 offset-md-3">
        <div class="card-header bg-primary text-white" style="background: linear-gradient(to right, #0a22aa, #b62512); color: white; border: none;">
            <h5 class="mb-0 text-white">Change Employee PIN</h5>
        </div>
        <div class="card-body">

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @elseif(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form action="{{ route('empin.update') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="current_empin" class="form-label">Current Empin</label>
                    <input type="password" name="current_empin" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="new_empin" class="form-label">New Empin</label>
                    <input type="text" name="new_empin" class="form-control" maxlength="4" required>
                </div>

                <div class="mb-3">
                    <label for="confirm_empin" class="form-label">Confirm New Empin</label>
                    <input type="text" name="confirm_empin" class="form-control" maxlength="4" required>
                </div>

                <button type="submit" class="btn btn-success" style="background: linear-gradient(to right, #0a22aa, #b62512); color: white; border: none;">Update Empin</button>
            </form>
        </div>
    </div>
</div>

</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
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
