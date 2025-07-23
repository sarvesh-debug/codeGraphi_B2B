@extends('user/include.layout')

@section('content')
@include('user.dmtpaysprint.navbar')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-success text-white text-center py-3">
                    <h4 class="mb-0"><span class="text-success1">Transaction</span> <span class="text-info1">Form</span></h4>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('1transact.otp') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Mobile Number -->
                        
                                <input type="text" hidden class="form-control" id="mobile" readonly value="{{ $mobile }}" name="mobile" placeholder="Enter Mobile Number" maxlength="10" required />
                        

                        <!-- Beneficiary ID -->
                        <div class="form-group mb-3">
                            <label for="bene_id" class="form-label">Beneficiary ID</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <input type="text" class="form-control" readonly value="{{ $bene_id }}" id="bene_id" name="bene_id" placeholder="Enter Beneficiary ID" required />
                            </div>
                        </div>

                        <!-- Transaction Type -->
                        <div class="form-group mb-3">
                            <label for="txntype" class="form-label">Transaction Type</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-arrow-left-right"></i></span>
                                <select class="form-control" id="txntype" name="txntype" required>
                                    <option value="" disabled selected>Select Transaction Type</option>
                                    <option value="IMPS">IMPS</option>
                                    <option value="NEFT">NEFT</option>
                                    <option value="RTGS">RTGS</option>
                                </select>
                            </div>
                        </div>

                        <!-- Amount -->
                        <div class="form-group mb-3">
                            <label for="amount" class="form-label">Amount</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-currency-rupee"></i></span>
                                <input type="number" class="form-control" id="amount" name="amount" placeholder="Enter Amount" min="100" required />
                            </div>
                            <small class="form-text text-muted">Amount must be 100 or more.</small>
                        </div>
                        
                            <!-- Hidden Location Fields -->
                            <input type="hidden" name="latitude" id="latitude">
                            <input type="hidden" name="longitude" id="longitude">

                        <!-- Submit and Reset Buttons -->
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-success w-45"><i class="bi bi-check-circle"></i> Submit</button>
                            <button type="reset" class="btn btn-warning w-45"><i class="bi bi-x-circle"></i> Reset</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    window.onload = function () {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    document.getElementById("latitude").value = position.coords.latitude;
                    document.getElementById("longitude").value = position.coords.longitude;
                },
                function(error) {
                    console.error("Geolocation error:", error.message);
                    alert("Location access denied or unavailable.");
                }
            );
        } else {
            alert("Geolocation is not supported by this browser.");
        }
    };
</script>


@endsection
