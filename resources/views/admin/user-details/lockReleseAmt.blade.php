@extends('admin/include.layout')

@section('content')
{{-- <div class="container-fluid px-4">
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>
        <li class="breadcrumb-item active">All User</li>
    </ol>
    <div class="btn-group" role="group" aria-label="User Filters">
    <a href="{{ route('admin/user-list', ['role' => 'Retailer']) }}" class="btn btn-primary">
        <i class="fas fa-store"></i> Retailers 
        <span class="badge bg-light text-dark">{{ $totalRetailers }}</span>
    </a>
    <a href="{{ route('admin/user-list', ['role' => 'distibuter']) }}" class="btn btn-secondary">
        <i class="fas fa-truck"></i> Distributors 
        <span class="badge bg-light text-dark">{{ $totalDistributors }}</span>
    </a>
    <a href="{{ route('admin/user-list') }}" class="btn btn-info">
        <i class="fas fa-users"></i> All 
        <span class="badge bg-light text-dark">{{ $total }}</span>
    </a>
    <a href="{{ route('admin/user-list', ['status' => 'deactive']) }}" class="btn btn-danger">
        <i class="fas fa-user-slash"></i> Deactive 
        <span class="badge bg-light text-dark">{{ $totalDeactive }}</span>
    </a>
    <a href="{{ route('admin/user-list', ['status' => 'active']) }}" class="btn btn-success">
        <i class="fas fa-user-check"></i> Active 
        <span class="badge bg-light text-dark">{{ $totalActive }}</span>
    </a>
</div> --}}


    <button type="button" class="btn btn-success w-100 m-2" onclick="downloadExcel()">
       
        Export
    </button>
    {{-- @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif --}}

    <div class="card-body table-scroll">
        <table id="datatablesSimple" class="table table-bordered">
            <thead>
                <tr>
                    <th>SR</th>
                    <th>OnBoard Date</th>
                    <th>User Id</th>
                    <th>OutLet Id</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Balance</th>
                    <th>Lock</th>
                    
                </tr>
            </thead>
            {{-- <tfoot>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>RT Id</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Outlet</th>
                    <th>Shop</th>
                    <th>Onboard By</th>
                    <th>Dis.Phone</th>
                    <th>Balance</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </tfoot> --}}
            <tbody class="table-striped">
                @foreach ($customers as $customer)
                
                <tr>
                    <td>{{ $loop->count - $loop->iteration + 1 }}</td>

                    <td>{{ $customer->created_at }}</td>
                    <td>{{ $customer->username }}</td>
                    <td>{{ $customer->pin }}</td>
                    @if ($customer->role=="Retailer")
                    <td>{{ $customer->name }}</td>
                    @else
                    <td>{{ $customer->name }}</td>
                    @endif
                   
                    <td>{{ $customer->phone }}</td>
                    <td>
                        ₹{{ number_format($customer->balance, 2) }}
                        <button class="btn btn-success btn-sm rounded" data-bs-toggle="modal" data-bs-target="#transactionModal{{ $customer->username}}">➕</button>
                    </td>
                    {{-- <td>{{ $customer->owner }}</td> --}}
                  
                   <td> ₹{{ number_format($customer->LockBalance, 2) }}</td>
                    
                </tr>
                

                <div class="modal fade" id="transactionModal{{ $customer->username }}" tabindex="-1" aria-labelledby="transactionModalLabel{{ $customer->username }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="transactionModalLabel{{ $customer->username }}">Amount Lock/Realese for {{ $customer->name }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            {{-- {{ route('update.transaction', $customer->id) }} --}}
                            <form action="{{route('lock.release',$customer->username)}}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <input type="text" hidden name="currentBalance" value="{{$customer->balance}}">
                                        <label for="amount" class="form-label">Amount</label>
                                        <input type="number" class="form-control" id="amount" name="amount" required>
                                    </div>
                                    {{-- <div class="mb-3">
                                        <label for="remark" class="form-label">Remark</label>
                                        <input type="text" class="form-control" id="remark" name="remark" required>
                                    </div> --}}
                                    <div class="mb-3">
                                        <label for="transactionType" class="form-label">Transaction Type</label><br>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="transaction_type" id="release{{ $customer->id }}" value="Credit" required>
                                            <label class="form-check-label" for="credit{{ $customer->id }}">Release</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="transaction_type" id="debit{{ $customer->id }}" value="Debit" required>
                                            <label class="form-check-label" for="lock{{ $customer->id }}">Lock</label>
                                        </div>
                
                                        
                
                                    </div> 
                                    <input type="text" hidden value="{{session('username')}}" name="sender">
                                    <input type="text" hidden value="{{$customer->username}}" name="receiver">
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
        XLSX.utils.book_append_sheet(workbook, worksheet, "Retailer List");

        // Export the workbook as an Excel file
        XLSX.writeFile(workbook, "Retailer_List.xlsx");
    }
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
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
