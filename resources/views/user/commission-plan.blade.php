@extends('user/include.layout')

@section('content')
<style>
    .card .card-header .card-title, .card .card-header .card-title .card-label {
        font-weight: 600 !important;
        font-size: 1.2rem !important;
        color: #006f37 !important;
    }
    .card .card-header {
        background-color: #DFFFEA !important;
    }
    table th {
        font-weight: 600 !important;
        color: #006f37 !important;
        font-size: 1.1rem !important;
    }
</style>

<div class="row">
    <div class="col-lg-12">
        <div class="card    m-3">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1 text-center h2">
                    <span class="text-success1">Commission</span> <span class="text-info1">& Charges</span>
                </h4>
            </div>
            {{-- start --}}
            <div class="card my-1">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">AePS Cash Withdrawal Commission</h4>
                </div>
                <div class="card-body">
                    <div class="live-preview">
                        <div class="row gy-4">
                            <div class="table-responsive">
                                <table class="table table-responsive-md">
                                    <thead>
                                        <tr>
                                            <th>Sl no.</th>
                                            <th>From Amount</th>
                                            <th>To Amount</th>
                                            
                                            <th>Commission</th>
                                          
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($aeps as $index => $commission)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $commission->from_amount }}</td>
                                                <td>{{ $commission->to_amount }}</td>
                                               
                                                <td>{{ $commission->commission }}</td>
                                               
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- endcard --}}
            <div class="card my-1">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Money Transfer Commission</h4>
                </div>
                <div class="card-body">
                    <div class="live-preview">
                        <div class="row gy-4">
                            <div class="table-responsive">
                                <table class="table table-responsive-md">
                                    <thead>
                                        <tr>
                                            <th>Sl no.</th>
                                            <th>Service</th>
                                            <th>From Amount</th>
                                            <th>To Amount</th>
                                            <th>Charge</th>
                                           
                                            <th>TDS</th>
                                            <th>Charge In</th>
                                            
                                            <th>TDS In</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($neft as $index => $commission)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $commission->sub_service}}</td>
                                                <td>{{ $commission->from_amount }}</td>
                                                <td>{{ $commission->to_amount }}</td>
                                                <td>{{ $commission->charge }}</td>
                                               
                                                <td>{{ $commission->tds }}</td>
                                                <td>{{ $commission->charge_in }}</td>
                                                
                                                <td>{{ $commission->tds_in }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- end card --}}
               {{-- startcard --}}
               <div class="card my-1">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Fund Transfer</h4>
                </div>
                <div class="card-body">
                    <div class="live-preview">
                        <div class="row gy-4">
                            <div class="table-responsive">
                                <table class="table table-responsive-md">
                                    <thead>
                                        <tr>
                                            <th>Sl no.</th>
                                            <th>Service</th>
                                            <th>From Amount</th>
                                            <th>To Amount</th>
                                            <th>Charge</th>
                                            <th>Commission</th>
                                            <th>TDS</th>
                                            <th>Charge In</th>
                                            <th>Commission In</th>
                                            <th>TDS In</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($fund as $index => $commission)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $commission->sub_service}}</td>
                                                <td>{{ $commission->from_amount }}</td>
                                                <td>{{ $commission->to_amount }}</td>
                                                <td>{{ $commission->charge }}</td>
                                                <td>{{ $commission->commission }}</td>
                                                <td>{{ $commission->tds }}</td>
                                                <td>{{ $commission->charge_in }}</td>
                                                <td>{{ $commission->commission_in }}</td>
                                                <td>{{ $commission->tds_in }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- end card --}}
        </div>
    </div>
</div>
@endsection
