@extends('admin/include.layout')

@section('content')
<style>
    @keyframes blink {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.5;
        }
    }

    span[style*="background-color: green"] {
        font-weight: bold;
        padding: 5px 10px;
        border-radius: 5px;
    }
</style>
<div class="container-fluid px-4">
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
        <li class="breadcrumb-item active">DMT Statement</li>
    </ol>

    <!-- Transaction Summary Section -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Today Transactions</h5>
                    <p class="card-text">₹ {{$todayTotal ?? 'N/A'}}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Today Success</h5>
                    <p class="card-text">₹ {{$todaySuccessCount ?? 'N/A'}}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Monthly Transaction</h5>
                    <p class="card-text">₹ {{$monthlyTotal ?? 'N/A'}}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Monthly Success</h5>
                    <p class="card-text">₹ {{$monthlySuccessCount ?? 'N/A'}}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{route('dmt1Report')}}" class="row align-items-end">
                <div class="col-md-5">
                    <label for="start_date">Start Date & Time</label>
                    <input type="datetime-local" id="start_date" name="start_date" 
                           value="{{ request('start_date') ? \Carbon\Carbon::parse(request('start_date'))->format('Y-m-d\TH:i') : '' }}" 
                           class="form-control">
                </div>
                <div class="col-md-5">
                    <label for="end_date">End Date & Time</label>
                    <input type="datetime-local" id="end_date" name="end_date" 
                           value="{{ request('end_date') ? \Carbon\Carbon::parse(request('end_date'))->format('Y-m-d\TH:i') : '' }}" 
                           class="form-control">
                </div>
                <div class="col-md-2 d-flex">
                    <!-- Filter Button -->
                    <button type="submit" class="btn btn-primary me-2 w-100">Filter</button>
                    <!-- Export Button -->
                    <button type="button" class="btn btn-success w-100" onclick="downloadExcel()">
                        Export
                    </button>
                </div>
            </form>
            
        </div>
    </div>


    <!-- Data Table Section -->
    <div class="card-body table-scroll">
        <table id="datatablesSimple" class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Remitter id</th>
                    <th>Remitter Name</th>
                    <th>Bene No</th>
                    <th>A/c Holder</th>
                    <th>RRN Id</th>
                    <th>Account No</th>
                    <th>IFCS</th>
                    <th>Status</th>
                    <th>Amount</th>
                    <th>Charges</th>
                    <th>Commission</th>
                    <th>Tds</th>
                    <th>Opening</th>
                    <th>Closing</th>
                   
                    <th>Types</th>
                    {{-- <th>Sender</th> --}}
                    {{-- <th>Phone</th>
                    
                    <th>Charges</th>
                    <th>COmmission</th>
                    <th>TDS</th>
                    <th>GST</th>
                   
                    <th>Status</th>
                    <th>UTR</th>
                    <th>Message</th> --}}
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($allData as $transaction)
                @php
                $data = json_decode($transaction->response_data, true);
                @endphp
                <tr>
                    <td>{{ $transaction->id }}</td>
                    <td>{{ $transaction->username }}</td>
                    <td>{{ $transaction->name }}</td>
                    <td>
                        {{ $data['data']['pool']['account'] ?? "Na" }}
                        {{-- @if(strlen($transaction->reference_key) > 15)
                            {{ substr($transaction->reference_key, 0, 15) }}...
                            <a href="#" onclick="alert('{{ $transaction->reference_key }}')">more</a>
                        @else
                            {{ $transaction->reference_key }}
                        @endif --}}
                    </td>
                    <td>{{ $data['data']['beneficiaryName'] ?? "Na" }}</td>
                    <td>
                        {{ $data['data']['txnReferenceId'] ?? "Na" }}
                        {{-- @php
                            $externalRef = $data['data']['externalRef'] ?? "N/A";
                        @endphp
                        @if(strlen($externalRef) > 10)
                            {{ substr($externalRef, 0, 10) }}...
                            <a href="#" onclick="alert('{{ $externalRef }}')">more</a>
                        @else
                            {{ $externalRef }}
                        @endif --}}
                    </td>
                    <td>{{ $data['data']['beneficiaryAccount'] ?? "Na" }}</td>
                    <td>{{ $data['data']['beneficiaryIfsc'] ?? "Na" }}</td>
                    <td>
                        @php
                            $responseData = json_decode($transaction->response_data);
                            $status = $responseData->status ?? 'Failed';
                        @endphp
                        @if($status === 'Transaction Successful')
                            <span style="background-color: green; color: white; animation: blink 1s infinite;">
                                Success
                            </span>
                        @else
                            <span style="color: red;">
                                Failed
                            </span>
                        @endif
                    </td>
                    <td>{{ $data['data']['txnValue'] ?? "0" }}</td>
                    <td>{{ $transaction->charges ?? 0}}</td>
                    <td>{{ $transaction->commission ?? 0 }}</td>
                    <td>{{ $transaction->tds ?? 0}}</td>
                    <td>{{ $transaction->opening_balance ?? 0 }}</td>
                     @php
                                    $commission = $transaction->commission ?? 0;
                                    $tds = $transaction->tds ?? 0;
                                    $adjustedCommission = $commission - $tds;
                                    $finalClosingBalance = $transaction->closing_balance + $adjustedCommission;
                                @endphp
                                <td>₹{{ number_format($finalClosingBalance, 2) }}</td>
                    
                    <td>{{ $transaction->reference_key ?? "0" }}</td>
                  
                   
                    {{-- <td>{{ $data['data']['accountNumber'] ?? "N/A" }}</td> --}}
                    <td>{{ $transaction->created_at }}</td>
                    {{-- <td>
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#responseModal{{ $transaction->id }}">
                            View Response
                        </button> --}}
                    </td>
                  
                   <td>
  <a href="{{ route('DuplicateRcptAd', ['id' => $transaction->id]) }}" class="btn btn-primary">
    Print
  </a>
</td>
                </tr>

                <!-- Modal Structure -->
<div class="modal fade" id="responseModal{{ $transaction->id }}" tabindex="-1" aria-labelledby="responseModalLabel{{ $transaction->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="responseModalLabel{{ $transaction->id }}">Transaction Response</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <pre id="responseData{{ $transaction->id }}">{{ json_encode(json_decode($transaction->response_data), JSON_PRETTY_PRINT) }}</pre>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" onclick="copyResponse({{ $transaction->id }})">Copy</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    function copyResponse(transactionId) {
        let text = document.getElementById("responseData" + transactionId).innerText;
        navigator.clipboard.writeText(text).then(() => {
            alert("Response copied to clipboard!");
        }).catch(err => {
            console.error("Failed to copy:", err);
        });
    }
</script>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<script>
    function downloadExcel() {
        // Get table data
        const table = document.getElementById('datatablesSimple');
        const rows = Array.from(table.rows).map(row => 
            Array.from(row.cells).map(cell => cell.innerText)
        );

        // Create a new workbook and worksheet
        const workbook = XLSX.utils.book_new();
        const worksheet = XLSX.utils.aoa_to_sheet(rows);

        // Add the worksheet to the workbook
        XLSX.utils.book_append_sheet(workbook, worksheet, "DMT1 Transactions");

        // Export the workbook as an Excel file
        XLSX.writeFile(workbook, "dmt1.xlsx");
    }
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
@endsection
