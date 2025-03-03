@extends('user/include.layout')

@section('content')
@include('user.payout.navbar')
<div class="controller mt-3 mx-5">
    <div class="row">
        <div id="kt_app_content" class="app-content flex-column-fluid my-3">
            <div id="kt_app_content_container" class="app-container container-fluid">
                <div class="card col-md-6 mx-auto shadow-lg border-0">
                    <div class="card-header bg-info text-white text-center py-3">
                        <h4 class="mb-0">Payout <span class="text-dark">Credit Card</span></h4>
                    </div>

                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('create.card') }}">
                            @csrf

                            <!-- Payer Details -->
                            <h5 class="mb-3">Payer Details</h5>
                            <div class="form-group mb-3">
                                <label for="payerBankProfileId" class="form-label">Bank Profile ID</label>
                                <input type="text" class="form-control" id="payerBankProfileId" name="payer[bankProfileId]" value="0" readonly required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="payerName" class="form-label">Sender Name</label>
                                <input type="text" class="form-control" id="payerName" name="payer[name]" placeholder="Enter Sender Name" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="payerAccountNumber" class="form-label">Sender Account Number</label>
                                <input type="text" class="form-control" id="payerAccountNumber" name="payer[accountNumber]" placeholder="Enter Account Number" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="payerPaymentMode" class="form-label">Payment Mode</label>
                                <select class="form-control" id="payerPaymentMode" name="payer[paymentMode]" required>
                                    <option value="" disabled selected>Select Payment Mode</option>
                                    <option value="PAY_CARD">Debit Card</option>
                                    <option value="NETBANKING">Net Banking</option>
                                    <option value="UPI">UPI</option>
                                </select>
                            </div>
                            <div class="form-group mb-3" id="cardDetails" style="display: none;">
                                <label for="payerCardNumber" class="form-label">Card Number</label>
                                <input type="text" class="form-control" id="payerCardNumber" name="payer[cardNumber]" placeholder="Enter Card Number">
                                <label for="payerCardExpiry" class="form-label mt-3">Card Expiry</label>
                                <div class="d-flex gap-2">
                                    <input type="text" class="form-control" name="payer[cardExpiry][month]" placeholder="MM">
                                    <input type="text" class="form-control" name="payer[cardExpiry][year]" placeholder="YY">
                                </div>
                                <label for="payerCardSecurityCode" class="form-label mt-3">Card CVV</label>
                                <input type="text" class="form-control" id="payerCardSecurityCode" name="payer[cardSecurityCode]" placeholder="Enter CVV">
                            </div>
                            <div class="form-group mb-3" id="referenceDetails" style="display: none;">
                                <label for="payerReferenceNumber" class="form-label">Reference Number</label>
                                <input type="text" class="form-control" id="payerReferenceNumber" name="payer[referenceNumber]" placeholder="Enter UPI Reference Number">
                            </div>

                            <!-- Payee Details -->
                            <h5 class="mb-3">Payee Details</h5>
                            <div class="form-group mb-3">
                                <label for="payeeName" class="form-label">Payee Name</label>
                                <input type="text" class="form-control" id="payeeName" name="payeeName" placeholder="Enter Account Holder Name" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="payeeAccountNumber" class="form-label">Payee Account Number</label>
                                <input type="text" class="form-control" id="payeeAccountNumber" name="payeeAccountNumber" placeholder="Enter Account Number" required>
                            </div>

                            <!-- Transaction Details -->
                            <h5 class="mb-3">Transaction Details</h5>
                            <div class="form-group mb-3">
                                <label for="transferMode" class="form-label">Transfer Mode</label>
                                <select class="form-control" id="transferMode" name="transferMode" required>
                                    <option value="CREDITCARD">Credit Card</option>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="transferAmount" class="form-label">Transfer Amount</label>
                                <input type="text" class="form-control" id="transferAmount" name="transferAmount" placeholder="Enter Amount" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="externalRef" class="form-label">External Reference</label>
                                <input type="text" class="form-control" id="externalRef" name="externalRef" placeholder="Enter Unique Transaction ID" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="remarks" class="form-label">Remarks</label>
                                <input type="text" class="form-control" id="remarks" name="remarks" placeholder="Enter Remarks">
                            </div>
                            <div class="form-group mb-3">
                                <label for="alertEmail" class="form-label">Alert Email</label>
                                <input type="email" class="form-control" id="alertEmail" name="alertEmail" placeholder="Enter Email (Optional)">
                            </div>

                            <!-- Location Details -->
                            <h5 class="mb-3">Location Details</h5>
                            <div class="form-group mb-3">
                                <label for="latitude" class="form-label">Latitude</label>
                                <input type="text" class="form-control" id="latitude" name="latitude" required readonly>
                            </div>
                            <div class="form-group mb-3">
                                <label for="longitude" class="form-label">Longitude</label>
                                <input type="text" class="form-control" id="longitude" name="longitude" required readonly>
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
        const paymentModeSelect = document.getElementById('payerPaymentMode');
        const cardDetails = document.getElementById('cardDetails');
        const referenceDetails = document.getElementById('referenceDetails');

        paymentModeSelect.addEventListener('change', function () {
            if (this.value === 'PAY_CARD') {
                cardDetails.style.display = 'block';
                referenceDetails.style.display = 'none';
            } else if (this.value === 'UPI') {
                cardDetails.style.display = 'none';
                referenceDetails.style.display = 'block';
            } else {
                cardDetails.style.display = 'none';
                referenceDetails.style.display = 'none';
            }
        });

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                document.getElementById('latitude').value = position.coords.latitude;
                document.getElementById('longitude').value = position.coords.longitude;
            }, function () {
                alert('Unable to retrieve your location. Ensure location services are enabled.');
            });
        } else {
            alert('Geolocation is not supported by your browser.');
        }
    });
</script>

@endsection
