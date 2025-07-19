@extends('admin.include.layout')

@section('content')

<div class="container-fluid px-4">
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
        <li class="breadcrumb-item active">Contacts</li>
    </ol>
<a href="{{route('admin.showServices')}}" class="btn btn-sm btn-success">Add Service</a>
    {{-- @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif --}}

    @if ($services->isNotEmpty())
        <div class="card">
            <div class="card-body table-scroll">
                <table id="datatablesSimple" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Logo</th>
                            <th>Service</th>
                            <th>Link</th>
                            <th>Created At</th>
                            {{-- <th>Updated At</th> --}}
                            <th>Status</th>
                            {{-- <th>Delete</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($services as $service)
                    <tr>
                        <td></td>
                        <td><img src="{{ $service->logo_name }}" width="50" height="50"></td>
                        <td>{{ $service->service }}</td>
                        <td><a href="{{ $service->service_link }}" target="_blank">{{ $service->service_link }}</a></td>
                        <td>{{ \Carbon\Carbon::parse($service->created_at)->format('d M Y, H:i') }}</td>
                        {{-- <td>{{ \Carbon\Carbon::parse($service->updated_at)->format('d M Y, H:i') }}</td> --}}
                        {{-- <td>
                            <a href="{{ route('otherServices.edit', $service->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            
                        </td> --}}
                        <td>
                            <form action="{{ route('otherServices.toggleStatus', $service->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn {{ $service->status ? 'btn-success' : 'btn-danger' }} btn-sm" onclick="return confirm('Are you sure?')">
                                    {{ $service->status ? 'Active' : 'Inactive' }}
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <p class="text-muted">No contacts found.</p>
    @endif

    <script>
        function confirmDelete() {
            return confirm('Are you sure you want to delete this contact?');
        }
    </script>
</div>

<!-- Modal Structure -->
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

{{-- {{ route('contact.edit', $data->id) }}
{{ route('contact.destroy', $data->id) }} --}}
