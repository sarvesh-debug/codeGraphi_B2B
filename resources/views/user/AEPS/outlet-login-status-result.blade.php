@extends('user/include.layout')

@section('content')
<div class="controller mt-3 mx-4">
    <div class="row">
        @include('user.AEPS.navbar')
        <div class="col-12 col-md-10 col-lg-8 mx-auto">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h1 class="h5 m-0">Outlet Login Status Result</h1>
                </div>
                <div class="card-body">
                    @if(isset($data))
                        @if($data['statuscode'] == 'SNA')
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-triangle"></i> <strong>Error:</strong> {{ $data['status'] }}
                            </div>
                        @elseif($data['statuscode'] == 'RPI')
                            <div class="alert alert-warning">
                                <i class="fas fa-info-circle"></i> <strong>Info:</strong> {{ $data['status'] }}
                            </div>
                        @else
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle"></i> <strong>Success:</strong> Data Retrieved
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Key</th>
                                        <th>Value</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><strong>Status Code</strong></td>
                                        <td>{{ $data['statuscode'] }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Timestamp</strong></td>
                                        <td>{{ $data['timestamp'] }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Status</strong></td>
                                        <td>{{ $data['status'] }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>IPAY UUID</strong></td>
                                        <td>{{ $data['ipay_uuid'] }}</td>
                                    </tr>
                                    {{-- <tr>
                                        <td><strong>Environment</strong></td>
                                        <td>{{ $data['environment'] }}</td>
                                    </tr> --}}
                                    <tr>
                                        <td><strong>Aadhaar Last Four</strong></td>
                                        <td>{{ $data['data']['aadhaarLastFour'] ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Is Bio Login Required</strong></td>
                                        <td>{{ $data['data']['isTxnBioLoginRequired'] ? 'Yes' : 'No' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-warning">
                            <p>No data available</p>
                        </div>
                    @endif
                </div>
                <div class="card-footer text-right">
                    <a href="{{ url('/outlet-login-status') }}" class="btn btn-secondary">Back to form</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
