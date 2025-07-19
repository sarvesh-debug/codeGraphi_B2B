@extends('user/include.layout')

@section('content')
<div class="container-fluid lg:px-4 px-6 mb-5">
    {{-- @include('user.dmtinstantpay.navbar') --}}
    <ol class="breadcrumb mb-4 m-4">
        <li class="breadcrumb-item"><a href="{{ route('customer/dashboard') }}">Home</a></li>
        <li class="breadcrumb-item active">Recharge</li>
    </ol>

    @if($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    <!-- Existing Filter Form -->
    <form method="GET" action="{{ route('bbpsAll.history') }}" class="row mb-4 m-2">
        <div class="col-md-6 col-lg-5">
            <label for="start_date">Start Date</label>
            <input type="datetime-local" id="start_date" name="start_date" 
                   value="{{ request('start_date') }}" 
                   class="form-control">
        </div>
        <div class="col-md-6 col-lg-5">
            <label for="end_date">End Date</label>
            <input type="datetime-local" id="end_date" name="end_date" 
                   value="{{ request('end_date') }}" 
                   class="form-control">
        </div>
        <div class="col-12 col-lg-2 d-flex align-items-end">
            <button type="submit" class="btn btn-primary w-100 p-1.5 lg:mt-0 mt-2">Filter</button>
        </div>
    </form>

    <div class="card m-2 mb-5">
        <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-center">
            <h3 class="card-heading mb-3 mb-md-0 text-center text-md-start">
                @if ($method=='C00')
                PrePaid Mobile
                @elseif($method=='C01')
                PostPaid Mobile
                @elseif($method=='C02')
                LandLine
                @elseif($method=='C03')
                DTH 
                @elseif($method=='C04')
                Electricity
                @elseif($method=='C05')
                Broadband
                @elseif($method=='C06')
                Cable TV
                @elseif($method=='C07')
                Gas (PNG)
                @elseif($method=='C08')
                Water
                @elseif($method=='C09')
                Education Fee
                @elseif($method=='C10')
                FASTag Recharge
                @elseif($method=='C11')
                Insurance
                @elseif($method=='C12')

                @elseif($method=='C13')
                Loan EMI
                @elseif($method=='C14')
                Gas
                @elseif($method=='C15')
                Credit Card
                @elseif($method=='C16')
                @elseif($method=='C17')

                @endif
               History</h3>
            <button id="exportTransactions" class="btn btn-download"> <i class="fa-solid fa-download"></i> Download</button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="transactionsTable" class="table table-bordered">
                    <thead>
                        <tr>

                            <th>ID</th>
                            <th class="whitespace-nowrap">Created At</th>
                            <th>Mobile</th>
                            <th>RRN</th>
                            {{-- <th>Outlet ID</th> --}}
                            <th>Status</th>
                           
                            <th>Charges</th>
                            <th>Commission</th>
                            <th>TDS</th>
                            <th>Opening</th>
                            <th>Amount</th>
                            <th>Closing</th>
                          
                            {{-- <th>Actions</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $transaction)
                            <tr>
                               
                                <td>{{ $loop->iteration }}</td> 
                                <td class="whitespace-nowrap">{{ $transaction->created_at }}</td>
                                <td>{{ optional(json_decode($transaction->response_body))->data->billerDetails->account ?? 'N/A' }}</td>

                                <td>{{ json_decode($transaction->response_body, true)['data']['txnReferenceId'] ?? 'N/A' }}</td>
                                {{-- <td>{{ $transaction->customer_outlet_id }}</td> --}}

                                @php
                                $decoded = json_decode($transaction->response_body, true);
                                $status = trim($decoded['statuscode'] ?? $decoded['statuscode   '] ?? '');
                            @endphp
                            
                            <td>
                                @if($status === 'TXN' || $status === 'TUP')
                                    <span style="color: green; font-weight: bold;">Success</span>
                                @else
                                    <span style="color: red; font-weight: bold;">Failed</span>
                                @endif
                            </td>
                            

                              
                                <td>₹{{ number_format($transaction->charges, 2) }}</td>
                                <td>₹{{ number_format($transaction->commission, 2) }}</td>
                                <td>₹{{ number_format($transaction->tds, 2) }}</td>
                                <td>₹{{ number_format($transaction->opening_balance, 2) }}</td>
                                <td>₹{{ json_decode($transaction->response_body, true)['data']['txnValue'] ?? 'N/A' }}</td>
                                <td>₹{{ number_format($transaction->closing_balance, 2) }}</td>
                               
                            </tr>
                            <!-- Modal Code -->
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script>
    document.getElementById('exportTransactions').addEventListener('click', function () {
        let table = document.getElementById('transactionsTable');
        let workbook = XLSX.utils.table_to_book(table, { sheet: "Sheet1" });
        XLSX.writeFile(workbook, 'Transactions.xlsx');
    });
</script>
@endsection
