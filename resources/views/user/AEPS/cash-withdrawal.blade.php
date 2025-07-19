@extends('user/include.layout')
@section('content')
<style>
    /* Loader overlay styles */
   

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

    .card-header {
        font-size: 1.25rem;
        font-weight: bold;
    }
    .transaction-card-body {
        max-height: 400px;
        overflow-y: auto; /* Scrollable if the content exceeds height */
    }
    .transaction-item {
        transition: background-color 0.2s ease-in-out;
    }
    .transaction-item:hover {
        background-color: #f8f9fa;
    }

    /* Prevent interactions while loader is active */
    body.loading {
        overflow: hidden;
    }

    body.loading * {
        pointer-events: none;
    }
</style>
<div class="controller mt-3 mx-3 mb-5 loading">
   <div id="loadingOverlay">
    <div class="loader"></div>
</div>

    @include('user.AEPS.navbar')
<div class="container mt-3 ">
    <div class="row justify-content-center">
        <!-- <div id="kt_app_content" class="app-content flex-column-fluid mt-4 col-md-9"> -->
            {{-- <div id="kt_app_content_container" class="app-container container-fluid"> --}}
                <!-- <div class="card  col-lg-6 col-md-8 col-12 gap-3"> -->
                <div class="card col-lg-6 col-md-8 col-12 mb-3">
                    <div class="card-header">
                        <h4 class="mb-0"><span class="card-heading"> AEPS Cash Withdrawal </h4>
                    </div>

                    <div class="card-body p-4">
                        <form id="aeps-balance-enquiry-form" action="{{ route('cashWithdrawal') }}" method="post">
                            @csrf

                            <!-- Aadhaar Number Field -->
                            {{-- <div class="form-group mb-3">
                                <label for="aadhaar" class="form-label">Aadhaar Number</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="number" class="form-control numeric-input" id="aadhaar" name="aadhaarNumber" 
                                        placeholder="Enter Aadhaar Number" maxlength="12" required 
                                        inputmode="numeric" pattern="[0-9]{12}" oninput="this.value = this.value.replace(/\D/g, '')" />
                                </div>
                                <small class="form-text text-muted">Enter a valid 12-digit Aadhaar number.</small>
                            </div> --}}

                            <div class="form-group mb-3">
                                <label for="aadhaar" class="form-label">Aadhaar Number</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text" class="form-control" id="aadhaar" name="aadhaarNumber"
                                        placeholder="XXXX XXXX XXXX" maxlength="14" required
                                        inputmode="numeric"
                                        oninput="formatAadhaar(this)" />
                                </div>
                                <small class="form-text text-muted">Enter a valid 12-digit Aadhaar number.</small>
                            </div>
  <script>
                            function formatAadhaar(input) {
                                let digits = input.value.replace(/\D/g, '').substring(0, 12);
                                let formatted = digits.replace(/(.{4})/g, '$1').trim();
                                input.value = formatted;
                            }
                            </script>


                            
                           
                            <!-- Bank IIN (Institution Identification Number) Field -->
                        @php
    $banks = DB::table('aepsbanks')->get();
@endphp

<style>
    .custom-dropdown {
        position: relative;
        width: 100%;
    }
    .dropdown-display {
        border: 1px solid #ccc;
        padding: 10px;
        cursor: pointer;
        background-color: white;
        border-radius: 4px;
    }
    .dropdown-list {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background-color: white;
        border: 1px solid #ccc;
        max-height: 200px;
        overflow-y: auto;
        z-index: 999;
        display: none;
        border-radius: 0 0 4px 4px;
    }
    .dropdown-list input {
        width: 100%;
        padding: 8px;
        border: none;
        border-bottom: 1px solid #ddd;
        outline: none;
    }
    .dropdown-item {
        padding: 10px;
        cursor: pointer;
    }
    .dropdown-item:hover {
        background-color: #f0f0f0;
    }
</style>

<div class="form-group">
    <label for="bankDropdown">Select Bank</label>
    <div class="custom-dropdown" id="bankDropdown">
        <div class="dropdown-display" onclick="toggleDropdown()">-- Select a Bank --</div>
        <div class="dropdown-list" id="dropdownList">
            <input type="text" id="searchInput" placeholder="Search bank..." onkeyup="filterDropdown()">
            @foreach($banks as $bank)
                <div class="dropdown-item" onclick="selectBank('{{ $bank->bank_id }}', '{{ $bank->bank_name }}')">
                    {{ $bank->bank_name }}
                </div>
            @endforeach
        </div>
    </div>
    <!-- Hidden input to store selected bank value -->
    <input type="hidden" name="bankiin" id="selectedBankInput">
</div>

<script>
    function toggleDropdown() {
        const list = document.getElementById("dropdownList");
        list.style.display = list.style.display === "block" ? "none" : "block";
    }

    function selectBank(id, name) {
        document.querySelector(".dropdown-display").innerText = name;
        document.getElementById("selectedBankInput").value = id;
        document.getElementById("dropdownList").style.display = "none";
    }

    function filterDropdown() {
        const input = document.getElementById("searchInput").value.toLowerCase();
        const items = document.querySelectorAll(".dropdown-item");

        items.forEach(item => {
            const text = item.textContent.toLowerCase();
            item.style.display = text.includes(input) ? "" : "none";
        });
    }

    // Close dropdown when clicking outside
    document.addEventListener("click", function(event) {
        const dropdown = document.getElementById("bankDropdown");
        if (!dropdown.contains(event.target)) {
            document.getElementById("dropdownList").style.display = "none";
        }
    });
</script>

                            <!-- Amount Number Field -->
                            <div class="form-group mb-3">
                                <label for="amount" class="form-label">Amount</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text" class="form-control" id="amount" name="amount"
                                        placeholder="Enter Amount" maxlength="10" required
                                        inputmode="numeric"
                                        oninput="this.value = this.value.replace(/\D/g, '').slice(0, 10);" />
                                </div>
                            </div>


                           <!-- Mobile Number Field -->
                            <div class="form-group mb-3">
                                <label for="mobile" class="form-label">Mobile Number</label>
                                <input type="text" class="form-control" id="mobile" name="mobile"
                                    placeholder="Enter Mobile Number" maxlength="10" required
                                    inputmode="numeric"
                                    oninput="this.value = this.value.replace(/\D/g, '').slice(0, 10);" />
                            </div>


                            <!-- External Reference Field -->
                       
                              


                            <!-- Hidden Fields for Auto-filled Data -->

                            <!-- Latitude (hidden) -->
                          <!-- Hidden Fields for Latitude and Longitude -->
                        <input type="hidden" id="latitude" name="latitude" />
                        <input type="hidden" id="longitude" name="longitude" />

                            <!-- Biometric Data Fields (hidden) -->
                            {{-- <input type="hidden" id="dc" name="biometricData[dc]"/>
                            <input type="hidden" id="ci" name="biometricData[ci]"/>
                            <input type="hidden" id="dpId" name="biometricData[dpId]"/>
                            <input type="hidden" id="pidDataType" name="biometricData[pidDataType]"/> --}}
                            <input id="txtBiometricData"   name="biometricData" class="form-control m-1" rows="1" readonly placeholder="Biometric Data will appear here">
            
           
<!-- Device Dropdown -->
<div class="text-center mb-3">
  <select id="deviceSelector" class="form-select w-auto d-inline" onchange="toggleDeviceButtons()">
    <option value="">Select Device</option>
    <option value="mantra">Mantra</option>
    <option value="morpho">Morpho</option>
  </select>
</div>

<!-- Buttons -->
<div class="d-flex justify-content-center gap-2"> 
  <!-- Mantra Buttons -->
  <button onclick="discoverAvdm();" type="button" id="mantraBtn" class="btn btn-info d-none">Search RD</button>
  <button onclick="CaptureAvdm()" type="button" id="mtrCaptureBtn" class="btn btn-danger d-none">Capture</button>

  <!-- Morpho Buttons -->
  <button type="button" class="btn d-none" id="btn1" onclick="RDService()">Morpho</button>
  <button type="button" class="btn d-none btn-danger" id="btn3" onclick="Capture()">Mor Capture</button>
</div>

<!-- Submit -->
<button type="submit" id="" class="btn btn-primary mt-3" >Submit</button>

        </form>
    </div>

                </div>
            {{-- </div> --}}
        <!-- </div> -->

         <!-- Latest Transactions Section -->
         <!-- <div class="col-md-4 mt-2"> -->
         <div class="col-lg-4 col-md-4 col-12 lg:d-flex  md:d-flex justify-content-center mb-5">
            <div class="mb-5">
                <div class="card-header bg-gradient-success text-white text-center py-3">
                    <h5 class="mb-0"><i class="fas fa-receipt me-2"></i>Latest Transactions</h5>
                </div>
                <div class="card-body p-4 mb-5">
                    @if($latestTransactions && count($latestTransactions) > 0)
                        @foreach($latestTransactions as $transaction)
                            <div class="transaction-item d-flex justify-content-between align-items-center py-3 border-bottom position-relative">
                                <div class="transaction-details">
                                    <strong class="text-primary">₹{{ $transaction['status'] === 'success' ? $transaction['transactionAmount'] : $transaction['amount'] }}
                                    </strong>
                                    <div class="small text-muted">{{ $transaction['date'] ?? "N/A" }}</div>
                                </div>
                                <span 
                                    class="badge bg-{{ $transaction['status'] === 'success' ? 'success' : ($transaction['status'] === 'pending' ? 'warning' : 'danger') }} px-3 py-2">
                                    {{ ucfirst($transaction['status']) }}
                                </span>
                                <div class="transaction-icon position-absolute end-0 top-50 translate-middle-y me-3">
                                    <!-- <i class="fas fa-{{ $transaction['status'] === 'success' ? 'check-circle' : ($transaction['status'] === 'pending' ? 'hourglass-half' : 'times-circle') }} text-{{ $transaction['status'] === 'success' ? 'success' : ($transaction['status'] === 'pending' ? 'warning' : 'danger') }} fa-lg"></i> -->
                                    <i class="fas fa-{{ $transaction['status'] === 'pending' ? 'hourglass-half' : '' }} 
                                        text-{{ $transaction['status'] === 'success' ? 'success' : ($transaction['status'] === 'pending' ? 'warning' : 'danger') }} fa-lg">
                                    </i>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="text-center text-muted mb-0"><i class="fas fa-exclamation-circle me-2"></i>No recent transactions available.</p>
                    @endif
                </div>
            </div>
        </div>
        

    </div>
@include('user.AEPS.device');
   @endsection