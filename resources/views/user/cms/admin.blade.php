@extends('user/include.layout')

@section('content')
<div class="container py-4">

    <!-- Title -->
    <div class="text-center mb-4">
        <h2 class="fw-bold text-primary">📋 CMS Transactions Dashboard</h2>
        <p class="text-muted">Start new CMS or view all transactions with filter/export options</p>
    </div>

    <!-- START CMS CARD -->
    <div class="card shadow-lg rounded-4 mb-4 border-0">
        <div class="card-header bg-gradient bg-success text-white fw-bold rounded-top">
            🚀 Start CMS Transaction
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('cms.start.submit') }}" id="cmsForm">
                @csrf
                <input type="hidden" name="latitude" id="latitude">
                <input type="hidden" name="longitude" id="longitude">

                <button type="submit" class="btn btn-lg btn-success w-100">
                    🔄 Start CMS Process
                </button>
            </form>

            @if(session('response'))
                <div class="alert alert-info mt-3">
                    <h5 class="fw-semibold">API Response:</h5>
                    <pre class="bg-light p-3 rounded">{{ json_encode(session('response'), JSON_PRETTY_PRINT) }}</pre>
                </div>
            @endif
        </div>
    </div>

    <!-- FILTER + EXPORT -->
    <div class="card shadow rounded-4 mb-4 border-0">
        <div class="card-header bg-primary text-white fw-bold rounded-top">
            🔍 Filter & Export
        </div>
        <div class="card-body">
            <form class="row g-3" method="GET" action="{{ route('cms.admin.transactions') }}">
                <div class="col-md-4">
                    <input type="text" name="refid" class="form-control" placeholder="🔎 Search by Ref ID" value="{{ request('refid') }}">
                </div>
                <div class="col-md-4">
                    <select name="event" class="form-select">
                        <option value="">📂 All Events</option>
                        <option value="CMS_BALANCE_INQUIRY" {{ request('event') == 'CMS_BALANCE_INQUIRY' ? 'selected' : '' }}>CMS_BALANCE_INQUIRY</option>
                        <option value="CMS_BALANCE_DEBIT" {{ request('event') == 'CMS_BALANCE_DEBIT' ? 'selected' : '' }}>CMS_BALANCE_DEBIT</option>
                        <option value="CMS_LOW_BALANCE_INQUIRY" {{ request('event') == 'CMS_LOW_BALANCE_INQUIRY' ? 'selected' : '' }}>CMS_LOW_BALANCE_INQUIRY</option>
                        <option value="CMS_POSTING" {{ request('event') == 'CMS_POSTING' ? 'selected' : '' }}>CMS_POSTING</option>
                    </select>
                </div>
                <div class="col-md-4 d-flex gap-2">
                    <button class="btn btn-outline-primary">🔍 Search</button>
                    {{-- <a href="{{ route('cms.export.excel') }}" class="btn btn-outline-success">📊 Export Excel</a>
                    <a href="{{ route('cms.export.pdf') }}" class="btn btn-outline-danger">📄 Export PDF</a> --}}
                </div>
            </form>
        </div>
    </div>

    <!-- TRANSACTIONS TABLE -->
    <div class="card shadow-sm rounded-4 border-0">
        <div class="card-header bg-secondary text-white fw-bold">
            📑 All CMS Transactions
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th>Ref ID</th>
                        <th>Event</th>
                        <th>Amount</th>
                        <th>Biller</th>
                        <th>Mobile</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $tx)
                        <tr>
                            <td>{{ $tx->refid }}</td>
                            <td><span class="badge bg-info">{{ $tx->event }}</span></td>
                            <td>₹{{ $tx->amount }}</td>
                            <td>{{ $tx->biller_name }}</td>
                            <td>{{ $tx->mobile_no }}</td>
                            <td>
                                @if($tx->status == '1' || $tx->status == 'SUCCESS')
                                    <span class="badge bg-success">Success</span>
                                @elseif($tx->status == '0' || $tx->status == 'REFUNDED')
                                    <span class="badge bg-warning text-dark">Refunded</span>
                                @else
                                    <span class="badge bg-secondary">Pending</span>
                                @endif
                            </td>
                            <td>{{ \Carbon\Carbon::parse($tx->datetime)->format('d M Y, h:i A') }}</td>
                         <td>
    <form method="POST" action="{{ route('cms.status.submit') }}">
        @csrf
        <input type="hidden" name="refid" value="{{ $tx->refid }}">
        <button type="submit" class="btn btn-sm btn-outline-info">Check Status</button>
    </form>

    @if(session('status_response_' . $tx->refid))
        <div class="mt-2 text-start">
            <pre class="bg-light p-2 rounded small">{{ json_encode(session('status_response_' . $tx->refid), JSON_PRETTY_PRINT) }}</pre>
        </div>
    @endif
</td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-muted">No transactions found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-3">
                {{ $transactions->links() }}
            </div>
        </div>
    </div>

</div>

<!-- Geolocation Script -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                document.getElementById("latitude").value = position.coords.latitude;
                document.getElementById("longitude").value = position.coords.longitude;
            }, function (error) {
                alert("📍 Location permission denied or not available.");
            });
        } else {
            alert("🌐 Geolocation is not supported by this browser.");
        }
    });
</script>
@endsection
