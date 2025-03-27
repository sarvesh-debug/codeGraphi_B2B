@extends('admin/include.layout')

@section('content')
<div class="container-fluid px-4">
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
</div>


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
                    <th>Onboard By</th>
                    <th>Dis.Phone</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>KYC</th>
                    <th>Actions</th>
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
                    <td>{{ $customer->name }}

                        <button class="btn btn-success btn-sm rounded" data-bs-toggle="modal" data-bs-target="#mapModal{{ $customer->username}}">Map To</button>
                    </td>
                    @else
                    <td>{{ $customer->name }}</td>
                    @endif
                   
                    <td>{{ $customer->phone }}</td>
                    <td>
                        ₹{{ number_format($customer->balance, 2) }}
                        <button class="btn btn-success btn-sm rounded" data-bs-toggle="modal" data-bs-target="#transactionModal{{ $customer->username}}">➕</button>
                    </td>
                    {{-- <td>{{ $customer->owner }}</td> --}}
                    <td>{{ $customer->dis_name }}
                        
                    </td>
                    <td>{{ $customer->dis_phone }}</td>
                    <td>{{ $customer->role }}</td>
                    <td>
                        <form action="{{ route('user.active', $customer->id) }}" method="post" onsubmit="return confirmAction(event, '{{ $customer->status }}')">
                            @csrf 
                            @method('POST')
                            
                            @if ($customer->status === "active")
                                {{-- Active  --}}
                                {{-- <button type="submit" class="btn btn-danger btn-sm" title="Deactivate">Deactivate</button> --}}
                                <button type="submit" class="btn btn-success btn-sm" title="Activate">Activate</button>

                            @else
                                {{-- Deactive --}}
                                {{-- <button type="submit" class="btn btn-success btn-sm" title="Activate">Activate</button> --}}
                                <button type="submit" class="btn btn-danger btn-sm" title="Deactivate">Deactivate</button>

                            @endif
                        </form>
                        <script>
                            function confirmAction(event, status) {
                                let message = status === "active" 
                                    ? "Are you sure you want to deactivate this user?" 
                                    : "Are you sure you want to activate this user?";
                                
                                const confirmation = confirm(message);
                                if (!confirmation) {
                                    event.preventDefault(); // Prevent the form from submitting if user clicks "Cancel"
                                }
                                return confirmation; // Return true if confirmed, false otherwise
                            }
                        </script>
                        
                </td>
                    <td>
                            @if($customer->pin==0)
                            <p class="text-danger">Not Verified</p>
                            @else
                           <p class="text-success">Verified</p>
                            @endif

                    </td>
                    <td>
                        <form method="POST" action="{{ route('admin.loginAsCustomer', $customer->id) }}" target="_blank" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-info btn-sm">Log In</button>
                        </form>
                        <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#viewModal{{ $customer->id }}">View</button>
                        <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#serviceModal{{ $customer->id }}">Service</button>
                        {{-- <button class="btn btn-warning btn-sm">Active</button> --}}
                        <form action="{{ route('admin.users.edit',  $customer->id) }}" method="GET" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-sm">Edit</button>
                            
                        </form>
                        
                    </td>
                </tr>
                
<!-- Modal for Viewing Retailer Details -->
<div class="modal fade" id="viewModal{{ $customer->id }}" tabindex="-1" aria-labelledby="viewModalLabel{{ $customer->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewModalLabel{{ $customer->id }}">Details for {{ $customer->name }}</h5>
                <form action="{{ route('user.active', $customer->id) }}" method="post" onsubmit="return confirmAction(event, '{{ $customer->status }}')">
                    @csrf
                    @method('POST')
                    
                    @if ($customer->status === "active")
                    <p class="bg-success">Active</p>
                        {{-- <button type="submit" class="btn btn-danger btn-sm">Deactivate</button> --}}
                    @else
                    <p class="bg-danger">Deactive</p>

                        {{-- <button type="submit" class="btn btn-success btn-sm">Activate</button> --}}
                    @endif
                </form>
                
                <script>
                    function confirmAction(event, status) {
                        let message = status === "active" 
                            ? "Are you sure you want to deactivate this user?" 
                            : "Are you sure you want to activate this user?";
                        
                        const confirmation = confirm(message);
                        if (!confirmation) {
                            event.preventDefault(); // Prevent the form from submitting if user clicks "Cancel"
                        }
                        return confirmation; // Return true if confirmed, false otherwise
                    }
                </script>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="list-group">
                    <li class="list-group-item"><strong>Id No:</strong> {{ $customer->username }}</li>
                    <li class="list-group-item"><strong>Name:</strong> {{ $customer->name }}</li>
                    <li class="list-group-item"><strong>Email:</strong> {{ $customer->email }}</li>
                    <li class="list-group-item"><strong>Phone:</strong> {{ $customer->phone }}</li>
                    <li class="list-group-item"><strong>Username:</strong> {{ $customer->username }}</li>
                    <li class="list-group-item"><strong>Role:</strong> {{ $customer->role }}</li>
                    <li class="list-group-item"><strong>Balance:</strong> ₹{{ number_format($customer->balance, 2) }}</li>
                    <li class="list-group-item"><strong>Address:</strong> {{ $customer->address_aadhar }}</li>
                    <li class="list-group-item"><strong>City:</strong> {{ $customer->city }}</li>
                    <li class="list-group-item"><strong>State:</strong> {{ $customer->state }}</li>
                    <li class="list-group-item"><strong>Pincode:</strong> {{ $customer->pincode }}</li>
                    <li class="list-group-item"><strong>Aadhar No:</strong> {{ $customer->aadhar_no }}</li>
                    <li class="list-group-item"><strong>PAN No:</strong> {{ $customer->pan_no }}</li>
                    <li class="list-group-item"><strong>Account No:</strong> {{ $customer->account_no }}</li>
                    <li class="list-group-item"><strong>IFSC Code:</strong> {{ $customer->ifsc_code }}</li>
                    <li class="list-group-item"><strong>Bank Name:</strong> {{ $customer->bank_name }}</li>
                </ul>
                <h6>Uploaded Documents</h6>
                <ul class="list-group">
                    <li class="list-group-item">
                        <strong>Aadhaar Front:</strong>
                        @if($customer->aadhar_front)
                            <a href="{{$customer->aadhar_front}}" target="_blank">
                                <img src="{{$customer->aadhar_front}}" alt="Aadhaar Front" style="max-width: 150px; max-height: 150px;"/>
                            </a>
                        @else
                            Not Uploaded
                        @endif
                    </li>
                    <li class="list-group-item">
                        <strong>Aadhaar Back:</strong>
                        @if($customer->aadhar_back)
                            <a href="{{ $customer->aadhar_back}}" target="_blank">
                                <img src="{{$customer->aadhar_back}}" alt="Aadhaar Back" style="max-width: 150px; max-height: 150px;"/>
                            </a>
                        @else
                            Not Uploaded
                        @endif
                    </li>
                    <li class="list-group-item">
                        <strong>PAN Card:</strong>
                        @if($customer->pan_image)
                            <a href="{{$customer->pan_image}}" target="_blank">
                                <img src="{{$customer->pan_image}}" alt="PAN Card" style="max-width: 150px; max-height: 150px;"/>
                            </a>
                        @else
                            Not Uploaded
                        @endif
                    </li>
                    <li class="list-group-item">
                        <strong>Bank Document:</strong>
                        @if($customer->bank_document)
                            <a href="{{$customer->bank_document}}" target="_blank">
                                <img src="{{$customer->bank_document}}" alt="Bank Document" style="max-width: 150px; max-height: 150px;"/>
                            </a>
                        @else
                            Not Uploaded
                        @endif
                    </li>
                </ul>
               
            </div>
        </div>
    </div>
</div>
                <!-- Modal for Service Details -->
                <div class="modal fade" id="serviceModal{{ $customer->id }}" tabindex="-1" aria-labelledby="serviceModalLabel{{ $customer->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="serviceModalLabel{{ $customer->id }}">Services for {{ $customer->name }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form method="POST" action="{{ route('update.services', $customer->id) }}">
                                    @csrf
                                    @method('PATCH')
                                
                                    <div class="mb-3 d-flex align-items-center">
                                        <input type="checkbox" name="aeps" {{ $customer->aeps ? 'checked' : '' }} data-toggle="toggle" data-on="Enabled" data-off="Disabled">
                                        <label class="ms-2">AEPS</label>
                                    </div>
                                
                                    <div class="mb-3 d-flex align-items-center">
                                        <input type="checkbox" name="dmt" {{ $customer->dmt ? 'checked' : '' }} data-toggle="toggle" data-on="Enabled" data-off="Disabled">
                                        <label class="ms-2">DMT </label>
                                    </div>
                                        
                                    {{-- <div class="mb-3 d-flex align-items-center">
                                        <input type="checkbox" name="dmt2" {{ $customer->dmt2 ? 'checked' : '' }} data-toggle="toggle" data-on="Enabled" data-off="Disabled">
                                        <label class="ms-2">DMT S2</label>
                                    </div> --}}
                                
                                    <div class="mb-3 d-flex align-items-center">
                                        <input type="checkbox" name="payout" {{ $customer->payout ? 'checked' : '' }} data-toggle="toggle" data-on="Enabled" data-off="Disabled">
                                        <label class="ms-2">Payout</label>
                                    </div>
                                    
                                
                                    {{-- <div class="mb-3 d-flex align-items-center">
                                        <input type="checkbox" name="cc_bill_payment" {{ $customer->cc_bill_payment ? 'checked' : '' }} data-toggle="toggle" data-on="Enabled" data-off="Disabled">
                                        <label class="ms-2">Credit Card Bill Payment</label>
                                    </div>
                                
                                    <div class="mb-3 d-flex align-items-center">
                                        <input type="checkbox" name="pan" {{ $customer->pan ? 'checked' : '' }} data-toggle="toggle" data-on="Enabled" data-off="Disabled">
                                        <label class="ms-2">PAN Card</label>
                                    </div>
                                
                                    <div class="mb-3 d-flex align-items-center">
                                        <input type="checkbox" name="cc_links" {{ $customer->cc_links ? 'checked' : '' }} data-toggle="toggle" data-on="Enabled" data-off="Disabled">
                                        <label class="ms-2">Credit Card Links</label>
                                    </div> --}}
                                
                                    <button type="submit" class="btn btn-primary">Update Services</button>
                                </form>
                                
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal -->
<div class="modal fade" id="transactionModal{{ $customer->username }}" tabindex="-1" aria-labelledby="transactionModalLabel{{ $customer->username }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="transactionModalLabel{{ $customer->username }}">Transaction for {{ $customer->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {{-- {{ route('update.transaction', $customer->id) }} --}}
            <form action="{{route('admin.trans',$customer->username)}}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <input type="text" hidden name="currentBalance" value="{{$customer->balance}}">
                        <label for="amount" class="form-label">Amount</label>
                        <input type="number" class="form-control" id="amount" name="amount" required>
                    </div>
                    <div class="mb-3">
                        <label for="remark" class="form-label">Remark</label>
                        <input type="text" class="form-control" id="remark" name="remark" required>
                    </div>
                    <div class="mb-3">
                        <label for="transactionType" class="form-label">Transaction Type</label><br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="transaction_type" id="credit{{ $customer->id }}" value="Credit" required>
                            <label class="form-check-label" for="credit{{ $customer->id }}">Credit</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="transaction_type" id="debit{{ $customer->id }}" value="Debit" required>
                            <label class="form-check-label" for="debit{{ $customer->id }}">Debit</label>
                        </div>

                        

                    </div> 
                    <input type="text" hidden value="{{session('username')}}" name="sender">
                    <input type="text" hidden value="{{$customer->username}}" name="reciver">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Mapping Distributors --}}
   <!-- Modal -->
   <div class="modal fade" id="mapModal{{ $customer->username }}" tabindex="-1" aria-labelledby="mapModalLabel{{ $customer->username }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mapModalLabel{{ $customer->username }}">Mapping  {{ $customer->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {{-- {{ route('update.transaction', $customer->id) }} --}}
            <form action="{{route('admin.disMapp',$customer->username)}}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="id" class="form-label">Retailer ID</label>
                        <input type="text" class="form-control" id="id" name="id" value="{{$customer->username }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="distributorSelect">Select Distributor</label>
                        <select name="distributor" id="distributorSelect" class="form-select">
                            <option value="" disabled selected>-- Select Distributor --</option>
                            <option value="Admin" data-name="Admin">Admin</option>
                            @foreach($disList as $distributor)
                                <option value="{{ $distributor->phone }}" data-name="{{ $distributor->name }}">
                                    {{ $distributor->name }}({{$distributor->username}})
                                </option>
                            @endforeach
                        </select>
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
