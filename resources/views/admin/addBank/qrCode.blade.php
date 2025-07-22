@extends('admin/include.layout')

@section('content')
<div class="container mt-5 d-flex justify-content-center">
    <div class="card shadow-sm col-md-4">
        <div class="card-header text-white text-center" style="background: linear-gradient(135deg, #1f0353, #e20b21, #d36f79);">
        <h3 style="color: aliceblue; font-weight: bold;">Add QR Details</h3>
    </div>

        <div class="card-body">
            <form action="{{ route('bankdetails.storeQr') }}" enctype="multipart/form-data" method="POST" class="needs-validation" novalidate>
                @csrf

                <div class="form-group mb-3">
                    <label for="qrPic" class="form-label">Upload QR Code</label>
                    <input type="file" name="qrPic" id="qrPic" class="form-control" required>
                    <div class="invalid-feedback">Please choose a QR code image.</div>
                </div>

                {{-- <div class="text-center">
                    <button type="submit" class="btn btn-success">Submit</button>
                </div> --}}

                <div class="text-center">
                    <button type="submit" class="btn text-white w-100" style="background: linear-gradient(135deg, #3a1c71, #c91022, #c91022); border: none;">
                        Submit
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<!-- Modal Structure -->
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
