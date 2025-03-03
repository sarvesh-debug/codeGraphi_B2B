<link rel="stylesheet" href="{{ asset('css/style.css') }}">
@extends('admin/include.layout')

@section('content')
@include('admin.commissionPlans.navbar')
@php
    $getCommission = DB::table('commissionservices')->where('status', 1)->get();
@endphp
<div class="container-fluid px-4">
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
        <li class="breadcrumb-item active">Map Commissions Plan</li>
    </ol>

    <div class="card-body p-1">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <form action="{{route('addMapCommissionData')}}" method="POST">
            @csrf
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

            <div class="row">
                <!-- From & To -->
                <div class="col-lg-2 col-md-3 col-sm-6 col-12 form-group mb-3">
                        <label class="form-label">From RT Count</label>
                        <input type="number" name="from_rt_count" id="from_rt_count" class="form-control" placeholder="e.g., 0" min=0 step="1" required>
                        @error('from_rt_count')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                </div>
                <div class="col-lg-2 col-md-3 col-sm-6 col-12 form-group mb-3">
                    <label for="to_rt_count" class="form-label">To RT Count</label>
                    <input type="number" name="to_rt_count" id="to_rt_count" class="form-control" placeholder="e.g., 0" min=0 step="0.1" required>
                    @error('to_rt_count')
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
                    <input type="text" name="charge" id="charge" class="form-control" placeholder="e.g., 50" min=0 step="0.01" required>
                    @error('charge')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Commission -->
                <div class="col-lg-2 col-md-3 col-sm-6 col-12 form-group mb-3">
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
                    <input type="number" name="commission" id="commission" class="form-control" placeholder="e.g., 20" min=0 step="0.01" required>
                    @error('commission')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- TDS-->
                <div class="col-lg-2 col-md-3 col-sm-6 col-12  form-group mb-3">
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
                    <input type="number" name="tds" id="tds" class="form-control" placeholder="e.g., 10" min=0 step="0.01" required>
                    @error('tds')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                
                <!-- Submit Button -->
                <div class="col-lg-2 col-md-3 col-sm-6 col-12 form-group mt-4 mb-3 d-flex text-center justify-content-end">
                    <button type="submit" class="btn btn-success w-auto me-2">Submit</button>
                    <button type="reset" class="btn btn-secondary w-auto" onclick="resetForm()">Reset</button>
                </div>
            </div>
        </form>
    </div>
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
    <div class="card-body p-1">
        @if ($commissions->isNotEmpty())
            <div class="card">
                <div class="card-body table-scroll">
                    <table id="datatablesSimple" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Sl No.</th>
                                <th>Serices</th>
                                <th>From RT</th>
                                <th>To RT</th>
                                <th>Charge In</th>
                                <th>Charge</th>
                                <th>Commission In</th>
                                <th>Commission</th>
                                <th>TDS In</th>
                                <th>TDS</th>
                                <th>Actions</th>
                                <!-- <th>Delete</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($commissions as $commission)
                                <tr>
                                    <td>{{ $loop->iteration }}</td> 
                                    <td>{{ $commission->service }}</td>

                                    <td>{{ number_format($commission->from_rt_count) }}</td>
                                    <td>{{ number_format($commission->to_rt_count) }}</td>
                                    <td>{{ $commission->charge_in }}</td>
                                    <td>{{ number_format($commission->charge, 2) }}</td>
                                    <td>{{ $commission->commission_in }}</td>
                                    <td>{{ number_format($commission->commission, 2) }}</td>
                                    <td>{{ $commission->tds_in }}</td>
                                    <td>{{ number_format($commission->tds, 2) }}</td>
                                    <td>
                                        <!-- <a href="{{ route('commission.edit', $commission->id) }}" class="btn btn-warning btn-sm">Edit</a> -->
                                        <button class="btn btn-warning btn-sm" onclick="editCommission({{ json_encode($commission) }})">Edit</button>
                                        <form action="{{ route('commission.mapCommissionDestroy', $commission->id) }}" method="POST" onsubmit="return confirmDelete();" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </td>
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
</div>


<script>
    function confirmDelete() {
        return confirm('Are you sure you want to delete this Commission?');
    }
</script>

<script>
    function editCommission(data) {
        window.scrollTo(0, 0); // Scroll to the top of the page
        document.getElementById("service").value = data.service;
        document.getElementById("sub_service").value = data.sub_service;
        document.getElementById("from_rt_count").value = data.from_rt_count;
        document.getElementById("to_rt_count").value = data.to_rt_count;
        document.getElementById("charge_in").value = data.charge_in;
        document.getElementById("charge").value = data.charge;
        document.getElementById("commission_in").value = data.commission_in;
        document.getElementById("commission").value = data.commission;
        document.getElementById("tds_in").value = data.tds_in;
        document.getElementById("tds").value = data.tds;

        // Set the form action dynamically for updating the commission
        let form = document.querySelector("form");
        form.action = `/commission/update/${data.id}`;
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