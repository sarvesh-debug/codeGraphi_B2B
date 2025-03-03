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
        <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>
        <li class="breadcrumb-item active">AePS Statement</li>
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
            <form method="GET" action="{{route('aepsReport')}}" class="row align-items-end">
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
                        <img src="https://freeiconshop.com/wp-content/uploads/edd/download-flat.png" 
                             alt="Download Icon" 
                             style="width: 16px; height: 16px; margin-right: 5px;">
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
                    <th>Mobile</th>
                    <th>Reference</th>
                    <th>Bank Name</th>
                    <th>Amount</th>
                    <th>Commissions</th>
                    <th>Status</th>
                    <th>Opening</th>
                    <th>Closing</th>
                    <th>Type</th>
                    <th>Account No</th>
                   
                    <th>Date & Time</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- Dummy Data -->
                @foreach($allData as $transaction)
                @php
                $data = json_decode($transaction->response_data, true);
                @endphp
                <tr>
                    <td>{{ $transaction->id }}</td>
                    <td>{{ $transaction->mobile }}</td>
                    <td>{{ $data['data']['ipayId'] ?? "0" }}</td>
                    <td>{{ $data['data']['bankName'] ?? "N/A" }}</td>
                    <td>{{ $data['data']['transactionValue'] ?? "0" }}</td>
                    <td>{{ $transaction->commissions }}</td>

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
                    <td>{{ $transaction->opening_balance }}</td>
                    <td>{{ $transaction->closing_balance }}</td>
                    <td>{{ $data['data']['transactionMode'] ?? "N/A" }}</td>
                    <td>{{ $data['data']['accountNumber'] ?? "N/A" }}</td>
                    <td>{{ $transaction->created_at }}</td>
                    <td>
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#responseModal{{ $transaction->id }}">
                            View Response
                        </button>
                    </td>
                  
                   
                </tr>
<!-- Modal Structure -->
<!-- Modal Structure -->
<div class="modal fade" id="responseModal{{ $transaction->id }}" tabindex="-1" aria-labelledby="responseModalLabel{{ $transaction->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="responseModalLabel{{ $transaction->id }}">Transaction Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @php
                    $responseData = json_decode($transaction->response_data, true);
                @endphp
                
                <!-- Transaction Overview -->
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title"><i class="bi bi-bank"></i> Bank Name: {{ $responseData['data']['bankName'] ?? "N/A" }}</h5>
                        <p><strong>Reference ID:</strong> {{ $responseData['data']['ipayId'] ?? "N/A" }}</p>
                        <p><strong>Transaction Amount:</strong> ₹{{ $responseData['data']['transactionValue'] ?? "0" }}</p>
                        <p><strong>Status:</strong> 
                            @if($responseData['status'] == "Transaction Successful")
                                <span class="badge bg-success">Success</span>
                            @else
                                <span class="badge bg-danger">Failed</span>
                            @endif
                        </p>
                    </div>
                </div>

                <!-- JSON Response in Styled Box -->
                {{-- <div class="bg-dark text-light p-3 rounded" style="max-height: 300px; overflow-y: auto;">
                    <pre id="responseData{{ $transaction->id }}" class="text-white">{{ json_encode($responseData, JSON_PRETTY_PRINT) }}</pre>
                </div> --}}
            </div>
            <div class="modal-footer">
                {{-- <button class="btn btn-primary" onclick="copyResponse({{ $transaction->id }})" data-bs-toggle="tooltip" data-bs-placement="top" title="Copy to Clipboard">
                    <i class="bi bi-clipboard"></i> Copy
                </button>
                <button class="btn btn-secondary" onclick="downloadResponse({{ $transaction->id }})">
                    <i class="bi bi-download"></i> Download JSON
                </button> --}}
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
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
        XLSX.utils.book_append_sheet(workbook, worksheet, "AePS Transactions");

        // Export the workbook as an Excel file
        XLSX.writeFile(workbook, "AePS_Transactions.xlsx");
    }
</script>
<script>
function copyResponse(transactionId) {
    let text = document.getElementById("responseData" + transactionId).innerText;
    navigator.clipboard.writeText(text).then(() => {
        let button = document.querySelector(`button[onclick="copyResponse(${transactionId})"]`);
        button.setAttribute("title", "Copied!");
        button.classList.add("btn-success");
        setTimeout(() => {
            button.setAttribute("title", "Copy to Clipboard");
            button.classList.remove("btn-success");
        }, 2000);
    }).catch(err => console.error("Failed to copy:", err));
}

function downloadResponse(transactionId) {
    let text = document.getElementById("responseData" + transactionId).innerText;
    let blob = new Blob([text], { type: "application/json" });
    let a = document.createElement("a");
    a.href = URL.createObjectURL(blob);
    a.download = `Transaction_${transactionId}.json`;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
}

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

@endsection
