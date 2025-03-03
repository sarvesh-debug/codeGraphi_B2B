<link rel="stylesheet" href="{{ asset('css/style.css') }}">
@extends('admin.include.layout')

@section('content')
@include('admin.commissionPlans.navbar')
@php
    $getCommission = DB::table('commissionservices')->where('status', 1)->get();
@endphp

<div class="container-fluid px-4">
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
        <li class="breadcrumb-item active">Commissions Plan</li>
    </ol>

    <div class="card-body p-1">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        {{-- {{route('commission-plan.store')}} --}}
        <form action="{{route('commission-store')}}" method="POST">
            @csrf
            <div class="row">
                <!-- Packages -->
                <div class="col-lg-2 col-md-3 col-sm-6 col-12 form-group mb-3">
                    <label class="form-label">Packages</label>
                    <select name="packages" id="packages" class="form-control" required>
                        <option  value="">--Select Packages--</option>
                        <option value="Retailer">Retailer</option>
                        {{-- <option value="specialRetailer">Special Retailer</option> --}}
                        <option value="distibuter">Distibuter</option>
                        {{-- <option value="superDistibuter">Super Distibuter</option> --}}
                    </select>
                    @error('packages')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Services -->
                <div class="col-lg-2 col-md-3 col-sm-6 col-12 form-group mb-3">
                    <label for="service" class="form-label">Service</label>
                    <select name="service" id="service" class="form-control" required>
                        <option value="">-- Select a Service --</option>
                        @foreach ($getCommission as $item)
                        <option value="{{$item->CommCode}}">{{$item->serviceName}}</option>
                        @endforeach
                        
                        {{-- <option value="AEPS">AEPS</option>
                        <option value="DMT">Money Transfer</option>
                        <option value="CC_Bill">Credit Card Bill Payment Charges</option>
                        <option value="FundTransfer">Fund Transfer</option>
                        <option value="BBPS">BBPS</option> --}}
                    </select>
                    @error('service')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                
                <!-- Additional select boxes for DMT and Fund Transfer -->
                <div class="col-lg-2 col-md-3 col-sm-6 col-12 form-group mb-3" id="sub-service-container" style="display: none;">
                    <label for="sub_service" class="form-label">Select Mode</label>
                    <select name="sub_service" id="sub_service" name="sub_service" class="form-control">
                        <option value="">-- Select Mode --</option>
                        <option value="RTGS">RTGS</option>
                        <option value="IMPS">IMPS</option>
                        <option value="NEFT">NEFT</option>
                    </select>
                    @error('sub_service')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- From Amount -->
                <div class="col-lg-2 col-md-3 col-sm-6 col-12 form-group mb-3">
                    <label for="from_amount" class="form-label">From Amount</label>
                    <input type="text" name="from_amount" id="from_amount" class="form-control" placeholder="e.g., 0" step="0.01" required>
                    @error('from_amount')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- To Amount -->
                <div class="col-lg-2 col-md-3 col-sm-6 col-12 form-group mb-3">
                    <label for="to_amount" class="form-label">To Amount</label>
                    <input type="text" name="to_amount" id="to_amount" class="form-control" placeholder="e.g., 1000" step="0.01" required>
                    @error('to_amount')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                
                <!-- Charge -->
                <div class="col-lg-2 col-md-3 col-sm-6 col-12 form-group mb-3">
                    <label for="charge_in" class="form-label">Charge In</label>
                    <select name="charge_in" id="charge_in" class="form-control" required>
                        <option value="">-- Select --</option>
                        <option value="Flat">Flat</option>
                        <option value="Percentage">Percentage</option>
                    </select>
                    @error('charge_in')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-lg-2 col-md-3 col-sm-6 col-12 form-group mb-3">
                    <label for="charge" class="form-label">Charge</label>
                    <input type="text" name="charge" id="charge" class="form-control" placeholder="e.g., 50" step="0.01" required>
                    @error('charge')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Commission -->
                <div class="col-lg-2 col-md-3 col-sm-6 col-12  form-group mb-3">
                    <label for="commission_in" class="form-label">Commission In</label>
                    <select name="commission_in" id="commission_in" class="form-control" required>
                        <option value="">-- Select --</option>
                        <option value="Flat">Flat</option>
                        <option value="Percentage">Percentage</option>
                    </select>
                    @error('commission_in')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-lg-2 col-md-3 col-sm-6 col-12 form-group mb-3">
                    <label for="commission" class="form-label">Commission</label>
                    <input type="text" name="commission" id="commission" class="form-control" placeholder="e.g., 20" step="0.01" required>
                    @error('commission')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                
                <!-- TDS -->
                <div class="col-lg-2 col-md-3 col-sm-6 col-12 form-group mb-3">
                    <label for="tds_in" class="form-label">TDS In</label>
                    <select name="tds_in" id="tds_in" class="form-control" required>
                        <option value="">-- Select --</option>
                        <option value="Flat">Flat</option>
                        <option value="Percentage">Percentage</option>
                    </select>
                    @error('tds_in')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-lg-2 col-md-3 col-sm-6 col-12 form-group mb-3">
                    <label for="tds" class="form-label">TDS</label>
                    <input type="text" name="tds" id="tds" class="form-control" placeholder="e.g., 10" step="0.01" required>
                    @error('tds')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="col-lg-2 col-md-3 col-sm-6 col-12 form-group mt-4 mb-3 d-flex text-center justify-content-end">
                    <button type="submit" class="btn btn-success w-auto me-2"> Submit </button>
                    <button type="reset" class="btn btn-secondary w-auto" onclick="resetForm()">Reset</button>
                </div>
            </div>
        </form>
    </div>

    @if ($commissions->isNotEmpty())
        <div class="card">
            <div class="card-body p-3 table-scroll">
                <table id="datatablesSimple" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Sl No.</th>
                            <th>Packages</th>
                            <th>Service</th>
                            <th>Sub Service</th>
                            <th>From Amount</th>
                            <th>To Amount</th>
                            <th>Charge</th>
                            <th>Commission</th>
                            <th>TDS</th>
                            <th>Charge In</th>
                            <th>Commission In</th>
                            <th>TDS In</th>
                            <th>Action</th>
                            <!-- <th>Delete</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($commissions as $commission)
                            <tr>
                                <td>{{ $loop->iteration }}</td> 
                                <td style="text-transform:capitalize">{{ $commission->packages }}</td>
                                <td>{{ $commission->service }}</td>
                                <td>{{ $commission->sub_service }}</td>
                                <td>{{ number_format($commission->from_amount, 2) }}</td>
                                <td>{{ number_format($commission->to_amount, 2) }}</td>
                                <td>{{ number_format($commission->charge, 2) }}</td>
                                <td>{{ number_format($commission->commission, 2) }}</td>
                                <td>{{ number_format($commission->tds, 2) }}</td>
                                <td>{{ $commission->charge_in }}</td>
                                <td>{{ $commission->commission_in }}</td>
                                <td>{{ $commission->tds_in }}</td>
                                <td>
                                    <!-- <a href="{{ route('commission.edit', $commission->id) }}" class="btn btn-warning btn-sm">Edit</a> -->
                                    <button class="btn btn-warning btn-sm" onclick="editCommission({{ json_encode($commission) }})">Edit</button>
                                      <form action="{{ route('commission.destroy', $commission->id) }}" method="POST" onsubmit="return confirmDelete();" style="display: inline-block;">
                                          @csrf
                                          @method('DELETE')
                                          <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                      </form>
                                    </td>
                                <!-- <td></td> -->
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <p class="text-muted">No commissions found.</p>
    @endif
</div>

<script>
    function confirmDelete() {
        return confirm('Are you sure you want to delete this Commission?');
    }
</script>

<script>
    document.getElementById('service').addEventListener('change', function() {
        var service = this.value;
        var subServiceContainer = document.getElementById('sub-service-container');
        var subServiceSelect = document.getElementById('sub_service');
        
        if (service === 'DMT' || service === 'FundTransfer') {
            subServiceContainer.style.display = 'block'; // Show the sub-service select
            subServiceSelect.setAttribute('required', 'required'); // Add required when visible
        } else {
            subServiceContainer.style.display = 'none'; // Hide the sub-service select
            subServiceSelect.removeAttribute('required'); // Remove required when hidden
        }
    });
</script>

<script>
    function editCommission(data) {
        window.scrollTo(0, 0); // Scroll to the top of the page

        document.getElementById("packages").value = data.packages;
        document.getElementById("service").value = data.service;
        document.getElementById("sub_service").value = data.sub_service;
        document.getElementById("from_amount").value = data.from_amount;
        document.getElementById("to_amount").value = data.to_amount;
        document.getElementById("charge_in").value = data.charge_in;
        document.getElementById("charge").value = data.charge;
        document.getElementById("commission_in").value = data.commission_in;
        document.getElementById("commission").value = data.commission;
        document.getElementById("tds_in").value = data.tds_in;
        document.getElementById("tds").value = data.tds;

        // Trigger the change event for the service dropdown
        document.getElementById("service").dispatchEvent(new Event('change'));

        // Set the form action dynamically for updating the commission
        let form = document.querySelector("form");
        form.action = `/commission/commissionUpdate/${data.id}`;
        form.method = "POST";

        // Add a hidden input for method spoofing since Laravel does not support PUT directly in forms
        let methodField = document.createElement("input");
        methodField.type = "hidden";
        methodField.name = "_method";
        methodField.value = "PUT";
        form.appendChild(methodField);
    }

    function resetForm() {
        location.reload(); // Reloads the page to reset everything
    }
</script>


@endsection
