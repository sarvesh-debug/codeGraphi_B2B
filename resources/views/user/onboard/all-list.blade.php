@extends('user/include.layout')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
 
@section('content')
<div class="container-fluid px-4">
    <ol class="breadcrumb mb-4 mt-3">
        <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>
        <li class="breadcrumb-item active">All User</li>
    </ol>
    <!-- <button type="button" class="card-header text-end" onclick="downloadExcel()">
        <img src="https://freeiconshop.com/wp-content/uploads/edd/download-flat.png" 
             alt="Icon" 
             style="width: 16px; height: 16px; margin-right: 5px;">
        Export
    </button> -->

    <div class="row">
        <div class="col d-flex justify-content-end me-2">
            <button type="button" class="btn btn-download" onclick="downloadExcel()"> 
                <i class="fa-solid fa-download"></i> Download
            </button>
        </div>
    </div>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card-body table-scroll">
        <table id="datatablesSimple" class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>RT Id</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Outlet Id</th>
                    <th>Owner</th>
                    <th>Balance</th>
                    <th>Role</th>
                    <th>Package Apply</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>RT Id</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Outlet</th>
                    <th>Shop</th>
                    <th>Balance</th>
                    <th>Role</th>
                    <th>Package Apply</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach ($customers as $customer)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->username }}</td>
                    <td>{{ $customer->email }}</td>
                    <td>{{ $customer->phone }}</td>
                    <td>{{ $customer->pin }}</td>
                    <td>{{ $customer->owner }}</td>
                    <td>
    ₹{{ number_format($customer->balance, 2) }}
    <button class="btn btn-add btn-sm rounded" data-bs-toggle="modal" data-bs-target="#transactionModal{{ $customer->id }}"><i class="fa-solid fa-plus"></i></button>
</td>
                    <td>
                        @if (trim(strtolower($customer->role)) === 'distibuter')
                        Distributor
                    {{-- @elseif(trim(strtolower($customer->role)) === 'rm')
                    Relationship Manager --}}
                        @else
                        Retailer
                    @endif
                    </td>
                  <td>
    <a href="#" data-bs-toggle="modal" data-bs-target="#editPackageModal{{ $customer->id }}">
        {{ $packages->where('id', $customer->packageId)->first()->packageName ?? 'Select Package' }}
    </a>
</td>

                    <td>  <form action="{{ route('user.active', $customer->id) }}" method="post" onsubmit="return confirmAction(event, '{{ $customer->status }}')">
                        @csrf 
                        @method('POST')
                        
                        @if ($customer->status === "active")
                            Active 
                        @else
                            Deactive
                        @endif
                    </form>
                    
                    <script>
                        function confirmAction(event, status) {
                            alert(status);
                            let message = status === "active" 
                                ? "Are you sure you want to deactivate this user?" 
                                : "Are you sure you want to activate this user?";
                            
                            const confirmation = confirm(message);
                            if (!confirmation) {
                                event.preventDefault(); // Prevent the form from submitting if user clicks "Cancel"
                            }
                            return confirmation; // Return true if confirmed, false otherwise
                        }
                    </script></td>
                 
                    <td>
                       
                        <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#viewModal{{ $customer->id }}">View</button>
                        {{-- <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#serviceModal{{ $customer->id }}">Service</button> --}}
                        
                        
                    </td>
                </tr>

<!-- Modal for Viewing Retailer Details -->
<div class="modal fade" id="viewModal{{ $customer->id }}" tabindex="-1" aria-labelledby="viewModalLabel{{ $customer->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewModalLabel{{ $customer->id }}">Details for {{ $customer->name }}</h5>
                 {{-- <form action="{{ route('user.active', $customer->id) }}" method="post" onsubmit="return confirmAction(event, '{{ $customer->status }}')">
                            @csrf
                            @method('POST')
                            
                            
                        @if ($customer->status === "active")
                        <button type="submit" class="btn btn-success btn-sm">Activate</button>

                        @else
                        <button type="submit" class="btn btn-danger btn-sm">Deactivate</button>

                        @endif
                        </form>
                        
                        <script>
                            function confirmAction(event, status) {
                                let message = status === "deactive" 
                                    ? "Are you sure you want to deactivate this user?" 
                                    : "Are you sure you want to activate this user?";
                                
                                const confirmation = confirm(message);
                                if (!confirmation) {
                                    event.preventDefault(); // Prevent the form from submitting if user clicks "Cancel"
                                }
                                return confirmation; // Return true if confirmed, false otherwise
                            }
                        </script> --}}
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
                            <a href="{{$customer->aadhar_front }}" target="_blank">
                                <img src="{{ $customer->aadhar_front }}" alt="Aadhaar Front" style="max-width: 150px; max-height: 150px;"/>
                            </a>
                        @else
                            Not Uploaded
                        @endif
                    </li>
                    <li class="list-group-item">
                        <strong>Aadhaar Back:</strong>
                        @if($customer->aadhar_back)
                            <a href="{{$customer->aadhar_back}}" target="_blank">
                                <img src="{{ $customer->aadhar_back}}" alt="Aadhaar Back" style="max-width: 150px; max-height: 150px;"/>
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
                                <img src="{{ $customer->bank_document}}" alt="Bank Document" style="max-width: 150px; max-height: 150px;"/>
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
                                <form method="POST" action="{{ route('update.servicesD', $customer->id) }}">
                                    @csrf
                                    @method('PATCH')
                                
                                    <div class="mb-3 d-flex align-items-center">
                                        <input type="checkbox" name="aeps" {{ $customer->aeps ? 'checked' : '' }} data-toggle="toggle" data-on="Enabled" data-off="Disabled">
                                        <label class="ms-2">AEPS</label>
                                    </div>
                                
                                    <div class="mb-3 d-flex align-items-center">
                                        <input type="checkbox" name="dmt" {{ $customer->dmt ? 'checked' : '' }} data-toggle="toggle" data-on="Enabled" data-off="Disabled">
                                        <label class="ms-2">DMT S1</label>
                                    </div>
                                        
                                    <div class="mb-3 d-flex align-items-center">
                                        <input type="checkbox" name="dmt2" {{ $customer->dmt2 ? 'checked' : '' }} data-toggle="toggle" data-on="Enabled" data-off="Disabled">
                                        <label class="ms-2">DMT S2</label>
                                    </div>
                                
                                    <div class="mb-3 d-flex align-items-center">
                                        <input type="checkbox" name="payout" {{ $customer->payout ? 'checked' : '' }} data-toggle="toggle" data-on="Enabled" data-off="Disabled">
                                        <label class="ms-2">Payout</label>
                                    </div>
                                    
                                
                                    <div class="mb-3 d-flex align-items-center">
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
                                    </div>
                                
                                    <button type="submit" class="btn btn-primary">Update Services</button>
                                </form>
                                
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal -->
<div class="modal fade" id="transactionModal{{ $customer->id }}" tabindex="-1" aria-labelledby="transactionModalLabel{{ $customer->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="transactionModalLabel{{ $customer->id }}">Transaction for {{ $customer->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            {{-- {{ route('update.transaction', $customer->id) }} --}}
            <form action="{{route('dis.trans',$customer->id)}}" method="POST">
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
<!-- Modal -->
<div class="modal fade" id="editPackageModal{{ $customer->id }}" tabindex="-1" aria-labelledby="editPackageLabel{{ $customer->id }}" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="{{ route('customer.updatePackage', $customer->id) }}">
        @csrf
        @method('PUT')
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPackageLabel{{ $customer->id }}">Select Package</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <label for="packageId" class="form-label">Package</label>
                    <select name="packageId" class="form-select" required>
                        <option value="">-- Select Package --</option>
                        @foreach($packages as $package)
                            <option value="{{ $package->id }}" {{ $customer->packageId == $package->id ? 'selected' : '' }}>
                                {{ $package->packageName }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Update Package</button>
            </div>
        </div>
    </form>
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


@endsection
