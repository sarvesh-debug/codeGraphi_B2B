@extends('admin/include.layout')

@section('content')
@include('admin.commissionPlans.navbar')
<div class="card col-md-6 mx-auto shadow-lg border-0 mt-5">
    <div class="card-header bg-success text-white text-center py-3">
        <h4 class="mb-0">Add Commission Plan</h4>
    </div>
    <div class="card-body p-4">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
{{-- {{route('commission-plan.store')}} --}}
        <form action="{{route('commission-store')}}" method="POST">
            @csrf
            <div class="form-group mb-3">
                <label for="packages" class="form-label">Packages</label>
                <select name="packages" id="packages" class="form-control" required>
                    <option value="">-- Select a Packages --</option>
                    <option value="Retailer">Retailer</option>
                    {{-- <option value="specialRetailer">Special Retailer</option> --}}
                    <option value="distibuter">Distibuter</option>
                    {{-- <option value="superDistibuter">Super Distibuter</option> --}}
                </select>
                @error('packages')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="service" class="form-label">Service</label>
                <select name="service" id="service" class="form-control" required>
                    <option value="">-- Select a Service --</option>
                    <option value="AEPS">AEPS</option>
                    <option value="DMT">Money Transfer</option>
                    <option value="CC_Bill">Credit Card Bill Payment Charges</option>
                    <option value="FundTransfer">Fund Transfer</option>
                    <option value="BBPS">BBPS</option>
                </select>
                @error('service')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            
            <!-- Additional select boxes for DMT and Fund Transfer -->
            <div class="form-group mb-3" id="sub-service-container" style="display: none;">
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
            <div class="form-group mb-3">
                <label for="from_amount" class="form-label">From Amount</label>
                <input type="text" name="from_amount" id="from_amount" class="form-control" placeholder="e.g., 0" step="0.01" required>
                @error('from_amount')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- To Amount -->
            <div class="form-group mb-3">
                <label for="to_amount" class="form-label">To Amount</label>
                <input type="text" name="to_amount" id="to_amount" class="form-control" placeholder="e.g., 1000" step="0.01" required>
                @error('to_amount')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Charge -->
            <div class="form-group mb-3">
                <label for="charge" class="form-label">Charge</label>
                <input type="text" name="charge" id="charge" class="form-control" placeholder="e.g., 50" step="0.01" required>
                @error('charge')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Commission -->
            <div class="form-group mb-3">
                <label for="commission" class="form-label">Commission</label>
                <input type="text" name="commission" id="commission" class="form-control" placeholder="e.g., 20" step="0.01" required>
                @error('commission')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- TDS -->
            <div class="form-group mb-3">
                <label for="tds" class="form-label">TDS</label>
                <input type="text" name="tds" id="tds" class="form-control" placeholder="e.g., 10" step="0.01" required>
                @error('tds')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Charge In -->
            <div class="form-group mb-3">
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

            <!-- Commission In -->
            <div class="form-group mb-3">
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

            <!-- TDS In -->
            <div class="form-group mb-3">
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

            <!-- Submit Button -->
            <button type="submit" class="btn btn-success w-100">Save Commission Plan</button>
        </form>
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
