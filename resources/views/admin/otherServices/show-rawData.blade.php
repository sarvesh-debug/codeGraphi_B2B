@extends('admin.include.layout')

@section('content')

<div class="container-fluid px-4">
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
        <li class="breadcrumb-item active">Contacts</li>
    </ol>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($rawData->isNotEmpty())
        <div class="card">
            <div class="card-body table-scroll">
                <table id="datatablesSimple" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Logo</th>
                            <th>Helpline No</th>
                            <th>TSN No</th>
                            <th>Banners</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rawData as $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <img src="{{ asset($data->logo) }}" alt="Logo" style="height: 50px; width: auto;">
                                </td>
                                <td>{{ $data->helpline_no }}</td>
                                <td>{{ $data->tsn_no }}</td>
                                <td>
                                    @php
                                        $banners = json_decode($data->banners, true);
                                    @endphp
                                    @foreach ($banners as $banner)
                                        <img src="{{ asset($banner) }}" alt="Banner" style="height: 50px; width: auto; margin-right: 5px;">
                                    @endforeach
                                </td>
                                <td>{{ \Carbon\Carbon::parse($data->created_at)->format('d M Y, H:i') }}</td>
                                <td>{{ \Carbon\Carbon::parse($data->updated_at)->format('d M Y, H:i') }}</td>
                                <td>
                                    <a href="" class="btn btn-warning btn-sm">Edit</a>
                                </td>
                                <td>
                                    <form action="" method="POST" onsubmit="return confirmDelete();" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
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
@endsection

{{-- {{ route('contact.edit', $data->id) }}
{{ route('contact.destroy', $data->id) }} --}}
