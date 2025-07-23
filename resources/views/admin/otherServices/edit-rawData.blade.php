@extends('admin/include.layout') 


@section('content')
<div class="container mt-5">
    <div class="card shadow-sm">
       <div class="card-header text-white text-center" style="background: linear-gradient(135deg, #3a1c71, #d4192c, #3a1c71);">
            <h3 style="color: aliceblue; font-weight: bold;">Update Latest News and Emergency Update</h3>
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
                <div class="form-group mb-3">
                    <label for="helpline_no" class="form-label">HelpLine No</label>
                    <input type="text" name="helpline_no" id="helpline_no" value="{{$getData->helpline_no}}" class="form-control" placeholder="Enter Helpline No" required>
                    <div class="invalid-feedback">Please enter the HelpLine No.</div>
                </div>

                <div class="form-group mb-3">
                    <label for="account_no" class="form-label">TSN No</label>
                    <input type="text" name="tsn_no" id="tsn_no" class="form-control" value="{{$getData->tsn_no}}" placeholder="Enter TSN number" required>
                    <div class="invalid-feedback">Please enter the TSN number.</div>
                </div>
                {{-- <div class="text-center">
                    <button type="submit" class="btn btn-success">Submit</button>
                </div> --}}
               <div class="text-center">
            <button type="submit" class="btn text-white py-2 px-4 w-40 gradient-btn">
                    Submit
                </button>
            </div>

    <style>
        .gradient-btn {
            background: linear-gradient(135deg, #ff0000, #1e3c72);
            border: none;
            border-radius: 6px;
            transition: background 0.3s ease, transform 0.2s ease;
        }

        .gradient-btn:hover {
            background: linear-gradient(135deg, #1e3c72, #ff0000);
            transform: scale(1.03);
        }
    </style>


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
