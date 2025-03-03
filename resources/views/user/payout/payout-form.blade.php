@extends('user/include.layout')

@section('content')
@include('user.payout.navbar')
<div class="controller mt-3 mx-5">
    <div class="row">
        <div id="kt_app_content" class="app-content flex-column-fluid my-3">
            <div id="kt_app_content_container" class="app-container container-fluid">
                <div class="card col-md-6 mx-auto shadow-lg border-0">
                    <div class="card-header bg-info text-white text-center py-3">
                        <h4 class="mb-0">Payout <span class="text-dark">  Bank</span></h4>
                    </div>

                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('payout.create') }}">
                            @csrf

                            <!-- Payer Details -->
                            <h5 class="mb-3">Payer Details</h5>
                            <div class="form-group mb-3">
                                <label for="payerBankProfileId" class="form-label">Bank Profile ID</label>
                                <input type="text" class="form-control" id="payerBankProfileId" name="payer[bankProfileId]" placeholder="Enter Bank Profile ID" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="payerAccountNumber" class="form-label">Account Number</label>
                                <input type="text" class="form-control" id="payerAccountNumber" name="payer[accountNumber]" placeholder="Enter Account Number" required>
                            </div>

                            <!-- Payee Details -->
                            <h5 class="mb-3">Payee Details</h5>
                            <div class="form-group mb-3">
                                <label for="payeeName" class="form-label">Name</label>
                                <input type="text" class="form-control" id="payeeName" name="payee[name]" placeholder="Enter Account Holder Name" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="payeeAccountNumber" class="form-label">Account Number</label>
                                <input type="text" class="form-control" id="payeeAccountNumber" name="payee[accountNumber]" placeholder="Enter Account Number" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="payeeBankIfsc" class="form-label">Bank IFSC</label>
                                <input type="text" class="form-control" id="payeeBankIfsc" name="payee[bankIfsc]" placeholder="Enter IFSC Code" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="payeeListId" class="form-label">Payee List ID (Optional)</label>
                                <input type="text" class="form-control" id="payeeListId" name="payee[payeeListId]" placeholder="Enter Payee List ID">
                            </div>

                            <!-- Transaction Details -->
                            <h5 class="mb-3">Transaction Details</h5>
                            <div class="form-group mb-3">
                                <label for="transferMode" class="form-label">Transfer Mode</label>
                                <select class="form-control" id="transferMode" name="transferMode" required>
                                    <option value="" disabled selected>Select Transfer Mode</option>
                                    <option value="IMPS">IMPS</option>
                                    <option value="NEFT">NEFT</option>
                                    <option value="RTGS">RTGS</option>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="transferAmount" class="form-label">Transfer Amount</label>
                                <input type="text" class="form-control" id="transferAmount" name="transferAmount" placeholder="Enter Amount" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="remarks" class="form-label">Remarks</label>
                                <input type="text" class="form-control" id="remarks" name="remarks" placeholder="Enter Remarks">
                            </div>
                            <div class="form-group mb-3">
                                <label for="purpose" class="form-label">Purpose (Optional)</label>
                                <select class="form-control" id="purpose" name="purpose">
                                    <option value="" disabled selected>Select Purpose</option>
                                    <option value="SALARY">SALARY</option>
                                    <option value="REIMBURSEMENT">REIMBURSEMENT</option>
                                    <option value="BONUS">BONUS</option>
                                    <option value="INCENTIVE">INCENTIVE</option>
                                    <option value="CUSTOMER_REFUND">CUSTOMER_REFUND</option>
                                    <option value="OTHERS">OTHERS</option>
                                </select>
                            </div>

                            <!-- Location Details -->
                            <h5 class="mb-3">Location Details</h5>
                            <div class="form-group mb-3">
                                <label for="latitude" class="form-label">Latitude</label>
                                <input type="text" class="form-control" id="latitude" name="latitude" placeholder="Enter Latitude" required readonly>
                            </div>
                            <div class="form-group mb-3">
                                <label for="longitude" class="form-label">Longitude</label>
                                <input type="text" class="form-control" id="longitude" name="longitude" placeholder="Enter Longitude" required readonly>
                            </div>

                            <!-- Submit Button -->
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary"><i class="bi bi-link-45deg"></i> Create Payout Link</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                document.getElementById('latitude').value = position.coords.latitude;
                document.getElementById('longitude').value = position.coords.longitude;
            }, function (error) {
                alert('Unable to retrieve your location. Please ensure location services are enabled.');
            });
        } else {
            alert('Geolocation is not supported by your browser.');
        }
    });
</script>

@endsection
