



@extends('admin/include.layout')

@section('content')

<style>
    .sticky-header {
        position: sticky;
        top: 0;
        z-index: 1020;
        background-color: white;
        padding: 10px 0;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    
    .table-responsive {
        max-height: calc(100vh - 250px);
        overflow: auto;
    }
    
    .table-wrapper {
        min-width: 1000px;
    }
    
    .filter-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
        padding: 10px 0;
    }
    
    .filter-buttons .btn {
        flex: 1 1 auto;
        min-width: 120px;
        white-space: nowrap;
        padding: 8px 5px;
        font-size: 0.85rem;
    }
    
    #datatablesSimple th {
        white-space: nowrap;
        position: sticky;
        top: 0;
        background: #f8f9fa;
        z-index: 10;
    }
    
    #datatablesSimple td {
        vertical-align: middle;
    }
    
    #datatablesSimple tr th:first-child,
    #datatablesSimple tr td:first-child {
        position: sticky;
        left: 0;
        background: white;
        z-index: 5;
    }
    
    @media (max-width: 768px) {
        .filter-buttons .btn {
            min-width: 100px;
            font-size: 0.75rem;
            padding: 5px 3px;
        }
        
        .container-fluid {
            padding-left: 10px;
            padding-right: 10px;
        }
    }
    
    .action-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
    }
    
    .action-buttons .btn {
        flex: 1 1 auto;
        min-width: 60px;
        font-size: 0.8rem;
        padding: 5px;
    }
</style>

<div class="container-fluid px-3">
    <ol class="breadcrumb mb-3">
        <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>
        <li class="breadcrumb-item active">All User</li>
    </ol>

    <div class="sticky-header">
        <div class="filter-buttons">
            <a href="{{ route('admin/user-list') }}" class="btn text-white" style="background: #ff4b2b;">
                <i class="fas fa-users"></i> All 
                <span class="badge bg-light text-dark">{{ $total }}</span>
            </a>
            <a href="{{ route('admin/user-list', ['role' => 'Retailer']) }}" class="btn text-white" style="background: #ff416c;">
                <i class="fas fa-store"></i> Retailers 
                <span class="badge bg-light text-dark">{{ $totalRetailers }}</span>
            </a>
            <a href="{{ route('admin/user-list', ['role' => 'distibuter']) }}" class="btn text-white" style="background: #f9484a;">
                <i class="fas fa-truck"></i> Distributors 
                <span class="badge bg-light text-dark">{{ $totalDistributors }}</span>
            </a>
            <a href="{{ route('admin/user-list', ['role' => 'sd']) }}" class="btn text-white" style="background: #1e3c72;">
                <i class="fas fa-truck"></i> Super Distributors 
                <span class="badge bg-light text-dark">{{ $totalSd }}</span>
            </a>
            <a href="{{ route('admin/user-list', ['role' => 'rm']) }}" class="btn text-white" style="background: #2a5298;">
                <i class="fas fa-truck"></i> Relationship Manager
                <span class="badge bg-light text-dark">{{ $totalRm }}</span>
            </a>
            <a href="{{ route('admin/user-list', ['status' => 'deactive']) }}" class="btn text-white" style="background: #6e0f0f;">
                <i class="fas fa-user-slash"></i> Deactive 
                <span class="badge bg-light text-dark">{{ $totalDeactive }}</span>
            </a>
            <a href="{{ route('admin/user-list', ['status' => 'active']) }}" class="btn text-white" style="background: #28a745;">
                <i class="fas fa-user-check"></i> Active 
                <span class="badge bg-light text-dark">{{ $totalActive }}</span>
            </a>
        </div>

        <a class="btn w-100 mb-2 text-white" href="{{ route('ddfile') }}" style="background: linear-gradient(135deg, #3a1c71, #b81a2a, #b81a2a); font-weight: 600;">
            Export
        </a>
    </div>

    <div class="table-responsive">
        <div class="table-wrapper">
            <table id="datatablesSimple" class="table table-bordered table-hover">
                <thead class="thead-light">
                    <tr>
                        <th>SR</th>
                        <th>OnBoard Date</th>
                        <th>Package Apply</th>
                        <th>User Id</th>
                        <th>OutLet Id</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Balance</th>
                        <th>Onboard By</th>
                        <th>Dis.Phone</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>AEPS KYC</th>
                        <th>User KYC</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($customers as $customer)
                    <tr>
                        <td>{{ $loop->count - $loop->iteration + 1 }}</td>
                        <td>{{ $customer->created_at }}</td>
                        <td>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#editPackageModal{{ Str::slug($customer->username) }}">
                                {{ $packages->where('id', $customer->packageId)->first()->packageName ?? 'Select Package' }}
                            </a>
                        </td>
                        <td>{{ $customer->username }}</td>
                        <td>{{ $customer->pin }}</td>
                        @if ($customer->role!="rm")
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
                        <td>{{ $customer->dis_name }}</td>
                        <td>{{ $customer->dis_phone }}</td>
                        <td>
                            @if (trim(strtolower($customer->role)) === 'distibuter')
                                Distributor
                            @elseif(trim(strtolower($customer->role)) === 'rm')
                            Relationship Manager
                            @elseif(trim(strtolower($customer->role)) === 'sd')
                            Super Distributor
                                @else
                                Retailer
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('user.active', $customer->id) }}" method="post" onsubmit="return confirmAction(event, '{{ $customer->status }}')">
                                @csrf 
                                @method('POST')
                                
                                @if ($customer->status === "active")
                                    <button type="submit" class="btn btn-success btn-sm">Activate</button>
                                @else
                                    <button type="submit" class="btn btn-danger btn-sm">Deactivate</button>
                                @endif
                            </form>
                        </td>
                        <td>
                            @if($customer->pin==0)
                            <p class="text-danger">Not Verified</p>
                            @else
                            <p class="text-success">Verified</p>
                            @endif
                        </td>
                        <td>
                            @if($customer->fkyc==1)
                                <p class="text-success">Verified</p>
                            @elseif($customer->fkyc==0)
                            <p class="text-danger">Not Apply</p>
                            @elseif($customer->fkyc==1)
                            <p class="text-warning">Pending</p>
                            @elseif($customer->fkyc==-1)
                            <p class="text-danger">Reject</p>
                            @else
                            <p class="text-danger">Not Verified</p>
                            @endif
                        </td>
                        <td>
                            <div class="action-buttons">
                                <form method="POST" action="{{ route('admin.loginAsCustomer', $customer->id) }}" target="_blank">
                                    @csrf
                                    <button type="submit" class="btn btn-info btn-sm">Log In</button>
                                </form>
                                <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#viewModal{{ $customer->id }}" style="background: linear-gradient(to right, #0a22aa, #b62512); color: white; border: none;">View</button>
                                <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#serviceModal{{ $customer->id }}" style="background: linear-gradient(to right, #0a22aa, #b62512); color: white; border: none;">Service</button>
                                <form action="{{ route('admin.users.edit',  $customer->id) }}" method="GET">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-sm">Edit</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Transaction Modal -->
@foreach ($customers as $customer)
<div class="modal fade" id="transactionModal{{ $customer->username }}" tabindex="-1" aria-labelledby="transactionModalLabel{{ $customer->username }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="transactionModalLabel{{ $customer->username }}">Transaction for {{ $customer->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('admin.trans',$customer->username)}}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <input type="hidden" name="currentBalance" value="{{$customer->balance}}">
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
                    <input type="hidden" value="{{session('username')}}" name="sender">
                    <input type="hidden" value="{{$customer->username}}" name="reciver">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" style="background: linear-gradient(to right, #0a22aa, #b62512); color: white; border: none;">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<!-- View Modal -->
@foreach ($customers as $customer)
<div class="modal fade" id="viewModal{{ $customer->id }}" tabindex="-1" aria-labelledby="viewModalLabel{{ $customer->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewModalLabel{{ $customer->id }}">Details for {{ $customer->name }}</h5>
                <form action="{{ route('user.active', $customer->id) }}" method="post" onsubmit="return confirmAction(event, '{{ $customer->status }}')">
                    @csrf
                    @method('POST')
                    
                    @if ($customer->status === "active")
                    <span class="badge bg-success ms-2">Active</span>
                    @else
                    <span class="badge bg-danger ms-2">Deactive</span>
                    @endif
                </form>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <ul class="list-group">
                            <li class="list-group-item"><strong>Id No:</strong> {{ $customer->username }}</li>
                            <li class="list-group-item"><strong>Name:</strong> {{ $customer->name }}</li>
                            <li class="list-group-item"><strong>Email:</strong> {{ $customer->email }}</li>
                            <li class="list-group-item"><strong>Phone:</strong> {{ $customer->phone }}</li>
                            <li class="list-group-item"><strong>Username:</strong> {{ $customer->username }}</li>
                            <li class="list-group-item"><strong>Role:</strong> 
                                @if (trim(strtolower($customer->role)) === 'distibuter')
                                    Distributor
                                @elseif(trim(strtolower($customer->role)) === 'rm')
                                Relationship Manager
                                @elseif(trim(strtolower($customer->role)) === 'sd')
                                Super Distributor
                                @else
                                Retailer
                                @endif
                            </li>
                            <li class="list-group-item"><strong>Balance:</strong> ₹{{ number_format($customer->balance, 2) }}</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="list-group">
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
                    </div>
                </div>
                
                <h6 class="mt-3">Uploaded Documents</h6>
                @if ($customer->role !== 'Retailer')
                <div class="mb-3">
                    <form action="{{ route('user.kyc.verify', $customer->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Verify this user?')">Verify KYC</button>
                    </form>
                    <button class="btn btn-danger btn-sm" onclick="openRejectModal({{ $customer->id }})">Reject KYC</button>
                </div>
                @endif
                
                @if ($customer->role === 'Retailer')
                <div class="mb-3">
                    @if ($customer->fkyc === -1)
                    <form action="{{ route('user.rekyc', $customer->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Apply Re-KYC for this user?')">Apply Re-KYC</button>
                    </form>
                    @else
                    <form action="{{ route('user.fullkyc', $customer->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Complete full KYC for this user?')" style="background: linear-gradient(to right, #0a22aa, #b62512); color: white; border: none;">Continue for FULL KYC</button>
                    </form>
                    @endif
                    <button class="btn btn-danger btn-sm" onclick="openRejectModal({{ $customer->id }})">Reject KYC</button>
                </div>
                @endif
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="card mb-3">
                            <div class="card-header">Aadhaar Front</div>
                            <div class="card-body text-center">
                                @if($customer->aadhar_front)
                                    <a href="{{$customer->aadhar_front}}" target="_blank">
                                        <img src="{{$customer->aadhar_front}}" alt="Aadhaar Front" class="img-fluid" style="max-height: 200px;"/>
                                    </a>
                                @else
                                    <p class="text-muted">Not Uploaded</p>
                                @endif
                            </div>
                        </div>
                        
                        <div class="card mb-3">
                            <div class="card-header">PAN Card</div>
                            <div class="card-body text-center">
                                @if($customer->pan_image)
                                    <a href="{{$customer->pan_image}}" target="_blank">
                                        <img src="{{$customer->pan_image}}" alt="PAN Card" class="img-fluid" style="max-height: 200px;"/>
                                    </a>
                                @else
                                    <p class="text-muted">Not Uploaded</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="card mb-3">
                            <div class="card-header">Aadhaar Back</div>
                            <div class="card-body text-center">
                                @if($customer->aadhar_back)
                                    <a href="{{ $customer->aadhar_back}}" target="_blank">
                                        <img src="{{$customer->aadhar_back}}" alt="Aadhaar Back" class="img-fluid" style="max-height: 200px;"/>
                                    </a>
                                @else
                                    <p class="text-muted">Not Uploaded</p>
                                @endif
                            </div>
                        </div>
                        
                        <div class="card mb-3">
                            <div class="card-header">KYC Picture</div>
                            <div class="card-body text-center">
                                @if($customer->selfie_data)
                                    <a href="{{$customer->selfie_data}}" target="_blank">
                                        <img src="{{ asset($customer->selfie_data) }}" alt="KYC Picture" class="img-fluid" style="max-height: 200px;"/>
                                    </a>
                                @else
                                    <p class="text-muted">Not Uploaded</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endforeach

<!-- Service Modal -->
@foreach ($customers as $customer)
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
                
                    <div class="mb-3 form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="aeps" id="aeps{{ $customer->id }}" {{ $customer->aeps ? 'checked' : '' }}>
                        <label class="form-check-label" for="aeps{{ $customer->id }}">AEPS</label>
                    </div>
                
                    <div class="mb-3 form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="dmt" id="dmt{{ $customer->id }}" {{ $customer->dmt ? 'checked' : '' }}>
                        <label class="form-check-label" for="dmt{{ $customer->id }}">DMT</label>
                    </div>
                
                    <div class="mb-3 form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="payout" id="payout{{ $customer->id }}" {{ $customer->payout ? 'checked' : '' }}>
                        <label class="form-check-label" for="payout{{ $customer->id }}">Payout</label>
                    </div>
                    
                    <div class="mb-3 form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="mprecharge" id="mprecharge{{ $customer->id }}" {{ $customer->mprecharge ? 'checked' : '' }}>
                        <label class="form-check-label" for="mprecharge{{ $customer->id }}">Mobile Recharge</label>
                    </div>
                
                    <button type="submit" class="btn btn-primary">Update Services</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

<!-- Package Modal -->
@foreach ($customers as $customer)
<div class="modal fade" id="editPackageModal{{ Str::slug($customer->username) }}" tabindex="-1" aria-labelledby="editPackageLabel{{ Str::slug($customer->username) }}" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('customer.updatePackagead', $customer->id) }}">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPackageLabel{{ Str::slug($customer->username) }}">Select Package</h5>
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

<!-- Map Modal -->
@foreach ($customers as $customer)
<div class="modal fade" id="mapModal{{ $customer->username }}" tabindex="-1" aria-labelledby="mapModalLabel{{ $customer->username }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mapModalLabel{{ $customer->username }}">Mapping {{ $customer->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('admin.disMapp',$customer->username)}}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="id" class="form-label">Retailer ID</label>
                        <input type="text" class="form-control" id="id" name="id" value="{{$customer->username }}" readonly>
                    </div>
                    <div class="mb-3">
                        @if ($customer->role=="sd")
                         <label for="distributorSelect">Select RM</label>
                        <select name="distributor" id="distributorSelect" class="form-select">
                            <option value="" disabled selected>-- Select RM --</option>
                            <option value="Admin" data-name="Admin">Admin</option>
                            @foreach($rmList as $rm)
                                <option value="{{ $rm->phone }}" data-name="{{ $rm->name }}">
                                    {{ $rm->name }}({{$rm->username}})
                                </option>
                            @endforeach
                        </select>
                        @elseif($customer->role=="distibuter")
                         <label for="distributorSelect">Select SD</label>
                        <select name="distributor" id="distributorSelect" class="form-select">
                            <option value="" disabled selected>-- Select Super Distributor --</option>
                            <option value="Admin" data-name="Admin">Admin</option>
                            @foreach($sdList as $sd)
                                <option value="{{ $sd->phone }}" data-name="{{ $sd->name }}">
                                    {{ $sd->name }}({{$sd->username}})
                                </option>
                            @endforeach
                        </select>
                        @else
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
                        @endif
                    </div>                
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" style="background: linear-gradient(to right, #0a22aa, #b62512); color: white; border: none;">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<!-- Status Modal -->
<div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content text-center">
            <div class="modal-body">
                @if(session('success'))
                    <img src="https://cdn-icons-png.flaticon.com/512/5610/5610944.png" alt="Success" width="80">
                    <h5 class="mt-2 text-dark">{{ session('success') }}</h5>
                @elseif(session('error'))
                    <img src="https://media.giphy.com/media/TqiwHbFBaZ4ti/giphy.gif" alt="Failed" width="80">
                    <h5 class="mt-2 text-danger">{{ session('error') }}</h5>
                @endif
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal" style="background: linear-gradient(to right, #0a22aa, #b62512); color: white; border: none;">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal (Hidden by default) -->
<div id="rejectModal" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reject KYC</h5>
                <button type="button" class="btn-close" onclick="closeRejectModal()"></button>
            </div>
            <form id="rejectForm" action="{{ $customer->role === 'Retailer' ? route('user.rejectRetailedKyc') : route('user.kyc.reject') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="customer_id" id="reject_customer_id">
                    <div class="mb-3">
                        <label for="kycRemark" class="form-label">Reason for rejection:</label>
                        <textarea name="kycRemark" class="form-control" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeRejectModal()">Cancel</button>
                    <button type="submit" class="btn btn-danger">Submit</button>
                </div>
            </form>
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

    function confirmAction(event, status) {
        let message = status === "active" 
            ? "Are you sure you want to deactivate this user?" 
            : "Are you sure you want to activate this user?";
        
        const confirmation = confirm(message);
        if (!confirmation) {
            event.preventDefault();
        }
        return confirmation;
    }
    
    function openRejectModal(customerId) {
        document.getElementById('reject_customer_id').value = customerId;
        var modal = new bootstrap.Modal(document.getElementById('rejectModal'));
        modal.show();
    }
    
    function closeRejectModal() {
        var modal = bootstrap.Modal.getInstance(document.getElementById('rejectModal'));
        modal.hide();
    }
    
    function downloadExcel() {
        const table = document.getElementById('datatablesSimple');
        const rows = Array.from(table.rows).map(row => 
            Array.from(row.cells).map(cell => cell.innerText)
        );

        const workbook = XLSX.utils.book_new();
        const worksheet = XLSX.utils.aoa_to_sheet(rows);
        XLSX.utils.book_append_sheet(workbook, worksheet, "User List");
        XLSX.writeFile(workbook, "User_List.xlsx");
    }
</script>

@endsection



