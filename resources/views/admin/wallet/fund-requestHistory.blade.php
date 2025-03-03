@extends('admin/include.layout')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h5>Fund Requests</h5>
            <ul class="nav nav-tabs card-header-tabs">
               
                <li class="nav-item">
                    <a class="nav-link" href="{{route('getFundRequests')}}">Pending</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('getFundRequests.History')}}">History</a>
                </li>
                {{-- <li class="nav-item">
                    <a class="nav-link" href="#">Rejected</a>
                </li> --}}
            </ul>
        </div>
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
        <div class="card-body">
            <form class="d-flex mb-4" action="{{ route('getFundRequests') }}" method="GET">
                <input type="date" class="form-control me-2" name="start_date" value="{{ request('start_date') }}">
                <input type="date" class="form-control me-2" name="end_date" value="{{ request('end_date') }}">
                <input type="text" class="form-control me-2" name="search" placeholder="Enter Search Value" value="{{ request('search') }}">
                <button class="btn btn-primary me-2" type="submit">Search</button>
                <button class="btn btn-success" onclick="exportToExcel()" type="button">Export</button>
            </form>
            

            <div class="card-body table-scroll">
                <table id="datatablesSimple" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>User Name</th>
                            <th>User Phone</th>
                            <th>ID</th>
                            <th>Company A/c No</th>
                            {{-- <th>IFSC</th> --}}
                            <th>Amount</th>
                            <th>Mode of Trans</th>
                            <th>UTR</th>
                            <th>Proof</th>
                            <th>Raise Date</th>
                            <th>Remark</th>
                           
                            
                            <th>Status</th>
                            <th>Action</th>

                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>User Name</th>
                            <th>User Phone</th>
                            <th>ID</th>
                            <th>Company A/c No</th>
                            {{-- <th>IFSC</th> --}}
                            <th>Amount</th>
                            <th>Mode of Trans</th>
                            <th>UTR</th>
                            <th>Proof</th>
                            <th>Raise Date</th>
                            <th>Remark</th>
                           
                            
                            <th>Status</th>
                           <th>Action</th>
                            
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($fundRequests as $request)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $request->request_by }}</td>
                            <td>{{ $request->phone }}</td>
                            <td>{{ $request->id_code }}</td>
                            <td>{{ $request->account_no }}</td>
                            {{-- <td>{{ $request->ifsc }}</td> --}}
                            {{-- <td>{{ $request->transaction_id }}</td> --}}
                            <td>{{ '₹' . number_format($request->amount, 2) }}</td>
                            <td>{{ $request->mode }}</td>
                            <td>{{ $request->utr }}</td>
                            <td><a href="#" data-bs-toggle="modal" data-bs-target="#proofModal{{ $request->id }}">View Proof</a></td>
                            <td>{{ \Carbon\Carbon::parse($request->created_at)->format('d-m-Y') }}</td>
                            <td>{{ $request->remark }}</td>
                            {{-- <td>{{ $request->admin_remark }}</td>
                            <td>{{ $request->employee }}</td> --}}
                            <td>
                                @if ($request->status == 0)
                                    <span class="badge bg-warning">Pending</span>
                                @elseif ($request->status == 1)
                                    <span class="badge bg-success">Done</span>
                                @elseif ($request->status == -1)
                                    <span class="badge bg-info">Reject</span>
                                @else
                                    <span class="badge bg-secondary">Unknown</span>
                                @endif
                            </td>
                            <td>
                                @if($request->status == 0)
                                    <!-- Approve Form -->
                                    <form action="{{ route('approveFund') }}" method="POST" style="display: inline;">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $request->id }}">
                                        <input type="hidden" name="id_code" value="{{ $request->id_code }}">
                                        <input type="hidden" name="phone" value="{{ $request->phone }}">
                                        <input type="hidden" name="amount" value="{{ $request->amount }}">
                                        <button type="submit" class="btn btn-info btn-sm">Approve</button>
                                    </form>
                            
                                    <!-- Reject Button -->
                                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#mapModal{{ $request->id }}">Reject</button>
                                @elseif($request->status == -1)
                                    <span class="btn btn-secondary btn-sm">Rejected</span>
                                @else
                                    <span class="btn btn-success btn-sm">Approved</span>
                                @endif
                            </td>
                            
                        </tr>

                        <!-- Proof Modal -->
                        <div class="modal fade" id="proofModal{{ $request->id }}" tabindex="-1" aria-labelledby="proofModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="proofModalLabel">Proof Images for Transaction {{ $request->id }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        @php
                                            $images = json_decode($request->slip_images);
                                        @endphp
                                        @foreach ($images as $image)
                                            <div class="mb-3">
                                                <img src="{{ $image }}" alt="Proof Image" class="img-fluid" />
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>


                        {{-- Mapping Distributors --}}
   <!-- Modal -->
   <div class="modal fade" id="mapModal{{ $request->id }}" tabindex="-1" aria-labelledby="mapModalLabel{{ $request->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mapModalLabel{{ $request->id}}">Reject  {{ $request->id}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {{-- {{ route('update.transaction', $customer->id) }} --}}
            <form action="{{route('rejectFund',$request->id)}}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="id" class="form-label">Fund ID</label>
                        <input type="text" class="form-control" id="id" name="id" value="{{$request->id }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="id" class="form-label">Remarks</label>
                        <input type="text" class="form-control" id="id" name="remark" required>
                    </div>
                                        
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    function exportToExcel() {
    // Get the table element
    let table = document.getElementById('fundRequestsTable');
    
    // Convert table to worksheet
    let workbook = XLSX.utils.table_to_book(table, { sheet: "Fund Requests" });

    // Generate and download the Excel file
    XLSX.writeFile(workbook, 'FundRequests.xlsx');
}

</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

@endsection
