@extends('admin/include.layout')
@section('content')
@include('admin.commissionPlans.navbar')
<div class="container-fluid px-4">
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="">Home</a></li>
        <li class="breadcrumb-item active">Edit Commission</li>
    </ol>

    <div class="card col-md-6 mx-auto shadow-lg border-0 mt-5">
        <div class="card-header bg-success text-white text-center py-3">
            <h4 class="mb-0">Edit Commission for <b>{{ $commission->service }}</b></h4>
        </div>
        <div class="card-body p-4">
            @if ($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('commission.update', $commission->id) }}" method="POST">
                @csrf
                @method('PUT')
             <!-- Select box for update -->
             <div class="form-group mb-3">
                <label for="packages" class="form-label">packages</label>
                <select name="packages" id="packages" class="form-control" required>
                    <option value="">-- Select a packages --</option>
                    <option value="Retailer" {{ old('packages', $commission->packages) == 'Retailer' ? 'selected' : '' }}>Retailer</option>
                    {{-- <option value="specialRetailer" {{ old('packages', $commission->packages) == 'specialRetailer' ? 'selected' : '' }}>Special Retailer</option> --}}
                    <option value="distibuter" {{ old('packages', $commission->packages) == 'distibuter' ? 'selected' : '' }}>Distibuter</option>
                    {{-- <option value="superDistibuter" {{ old('packages', $commission->packages) == 'superDistibuter' ? 'selected' : '' }}>superDistibuter</option> --}}
                </select>
            </div>
              <!-- Select box for service -->
<div class="form-group mb-3">
    <label for="service" class="form-label">Service</label>
    <select name="service" id="service" class="form-control" required>
        <option value="">-- Select a Service --</option>
        <option value="AEPS" {{ old('service', $commission->service) == 'AEPS' ? 'selected' : '' }}>AEPS</option>
        <option value="DMT" {{ old('service', $commission->service) == 'DMT' ? 'selected' : '' }}>Money Transfer</option>
        <option value="CC_Bill" {{ old('service', $commission->service) == 'CC_Bill' ? 'selected' : '' }}>Credit Card Bill Payment Charges</option>
        <option value="FundTransfer" {{ old('service', $commission->service) == 'FundTransfer' ? 'selected' : '' }}>Fund Transfer</option>
        <option value="BBPS" {{ old('service', $commission->service) == 'BBPS' ? 'selected' : '' }}>BBPS</option>
    </select>
</div>

<!-- Additional select box for DMT and Fund Transfer -->
<div class="form-group mb-3" id="sub-service-container" style="{{ old('service', $commission->service) == 'DMT' || old('service', $commission->service) == 'FundTransfer' ? 'display:block' : 'display:none' }}">
    <label for="sub_service" class="form-label">Select Mode</label>
    <select name="sub_service" id="sub_service" class="form-control">
        <option value="">-- Select Mode --</option>
        <option value="RTGS" {{ old('sub_service', $commission->sub_service) == 'RTGS' ? 'selected' : '' }}>RTGS</option>
        <option value="IMPS" {{ old('sub_service', $commission->sub_service) == 'IMPS' ? 'selected' : '' }}>IMPS</option>
        <option value="NEFT" {{ old('sub_service', $commission->sub_service) == 'NEFT' ? 'selected' : '' }}>NEFT</option>
    </select>
</div>

                <!-- From Amount -->
                <div class="form-group mb-3">
                    <label for="from_amount" class="form-label">From Amount</label>
                    <input type="text" name="from_amount" id="from_amount" class="form-control" value="{{ $commission->from_amount }}" required>
                </div>

                <!-- To Amount -->
                <div class="form-group mb-3">
                    <label for="to_amount" class="form-label">To Amount</label>
                    <input type="text" name="to_amount" id="to_amount" class="form-control" value="{{ $commission->to_amount }}" required>
                </div>

                <!-- Charge -->
                <div class="form-group mb-3">
                    <label for="charge" class="form-label">Charge</label>
                    <input type="text" name="charge" id="charge" class="form-control" value="{{ $commission->charge }}" required>
                </div>

                <!-- Commission -->
                <div class="form-group mb-3">
                    <label for="commission" class="form-label">Commission</label>
                    <input type="text" name="commission" id="commission" class="form-control" value="{{ $commission->commission }}" required>
                </div>

                <!-- TDS -->
                <div class="form-group mb-3">
                    <label for="tds" class="form-label">TDS</label>
                    <input type="text" name="tds" id="tds" class="form-control" value="{{ $commission->tds }}" required>
                </div>

                <!-- Charge In -->
                <div class="form-group mb-3">
                    <label for="charge_in" class="form-label">Charge In</label>
                    <select name="charge_in" id="charge_in" class="form-control" required>
                        <option value="Flat" {{ $commission->charge_in == 'Flat' ? 'selected' : '' }}>Flat</option>
                        <option value="Percentage" {{ $commission->charge_in == 'Percentage' ? 'selected' : '' }}>Percentage</option>
                    </select>
                </div>

                <!-- Commission In -->
                <div class="form-group mb-3">
                    <label for="commission_in" class="form-label">Commission In</label>
                    <select name="commission_in" id="commission_in" class="form-control" required>
                        <option value="Flat" {{ $commission->commission_in == 'Flat' ? 'selected' : '' }}>Flat</option>
                        <option value="Percentage" {{ $commission->commission_in == 'Percentage' ? 'selected' : '' }}>Percentage</option>
                    </select>
                </div>

                <!-- TDS In -->
                <div class="form-group mb-3">
                    <label for="tds_in" class="form-label">TDS In</label>
                    <select name="tds_in" id="tds_in" class="form-control" required>
                        <option value="Flat" {{ $commission->tds_in == 'Flat' ? 'selected' : '' }}>Flat</option>
                        <option value="Percentage" {{ $commission->tds_in == 'Percentage' ? 'selected' : '' }}>Percentage</option>
                    </select>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-success w-100">Update Commission</button>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('service').addEventListener('change', function() {
        var service = this.value;
        var subServiceContainer = document.getElementById('sub-service-container');
        
        if (service === 'DMT' || service === 'FundTransfer') {
            subServiceContainer.style.display = 'block'; // Show the sub-service select
        } else {
            subServiceContainer.style.display = 'none'; // Hide the sub-service select
        }
    });
</script>
@endsection
