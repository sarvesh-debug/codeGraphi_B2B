@extends('user/include.layout')
@section('content')
<style>
    /* Loader overlay styles */
    #loadingOverlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);  /* Dark background with some opacity */
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;  /* Ensure it's above all other content */
    color: white;
}

.loader {
    border: 8px solid #f3f3f3;  /* Light gray background */
    border-top: 8px solid #3498db;  /* Blue color for the spinning part */
    border-radius: 50%;
    width: 50px;
    height: 50px;
    animation: spin 1s linear infinite;
}

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
<div class="controller mt-3 mx-3 loading">
   <div id="loadingOverlay">
    <div class="loader"></div>
</div>

    @include('user.AEPS.navbar')
<div class="container mt-3 ">
    <div class="row">
        <!-- <div id="kt_app_content" class="app-content flex-column-fluid mt-4 col-md-9"> -->
            {{-- <div id="kt_app_content_container" class="app-container container-fluid"> --}}
                <div class="card  col-lg-6 col-md-8 col-12 gap-3">
                    <div class="card-header">
                        <h4 class="mb-0"><span class="card-heading"> AEPS Cash Withdrawal </h4>
                    </div>

                    <div class="card-body p-4">
                        <form id="aeps-balance-enquiry-form" action="{{ route('cashWithdrawal') }}" method="post">
                            @csrf

                            <!-- Aadhaar Number Field -->
                            <div class="form-group mb-3">
                                <label for="aadhaar" class="form-label">Aadhaar Number</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="number" class="form-control numeric-input" id="aadhaar" name="aadhaarNumber" 
                                        placeholder="Enter Aadhaar Number" maxlength="12" required 
                                        inputmode="numeric" pattern="[0-9]{12}" oninput="this.value = this.value.replace(/\D/g, '')" />
                                </div>
                                <small class="form-text text-muted">Enter a valid 12-digit Aadhaar number.</small>
                            </div>
                           
                            <!-- Bank IIN (Institution Identification Number) Field -->
                            <div class="form-group">
                                <label for="bankCode">Select Bank</label>
                                <select class="form-control" id="bankCode" name="bankiin">
                                    <option value="">-- Select a Bank --</option>
                                    <option value="607094">STATE BANK OF INDIA</option>
                                    <option value="607027">Punjab National Bank</option>
                                    <option value="608314">INDIA POST PAYMENTS BANK</option>
                                    <option value="607105">INDIAN BANK</option>
                                    <option value="607161">UNION BANK OF INDIA</option>
                                    <option value="508505">BANK OF INDIA</option>
                                    <option value="606985">BANK OF BARODA</option>
                                    <option value="607396">CANARA BANK</option>
                                    <option value="607126">INDIAN OVERSEAS BANK</option>
                                    <option value="607066">UCO BANK</option>
                                    <option value="606993">BARODA UP BANK</option>
                                    <option value="607264">CENTRAL BANK OF INDIA</option>
                                    <option value="990320">AIRTEL PAYMENTS BANK</option>
                                    <option value="607280">BARODA RAJASTHAN KSHETRIYA GRAMIN BANK</option>
                                    <option value="607189">IndusInd Bank</option>
                                    <option value="607063">BANGIYA GRAMIN VIKASH BANK</option>
                                    <option value="607069">UTTAR BIHAR GRAMIN BANK</option>
                                    <option value="607387">BANK OF MAHARASHTRA</option>
                                    <option value="608001">FINO PAYMENTS BANK</option>
                                    <option value="607136">DAKSHIN BIHAR GRAMIN BANK</option>
                                    <option value="607135">PRATHAMA UP GRAMIN BANK</option>
                                    <option value="607087">PUNJAB AND SIND BANK</option>
                                    <option value="607121">ANDHRA PRAGATHI GRAMEENA BANK</option>
                                    <option value="607400">KARNATAKA GRAMIN BANK</option>
                                    <option value="607022">MADHYA PRADESH GRAMEEN BANK</option>
                                    <option value="607195">TELANGANA GRAMEENA BANK</option>
                                    <option value="607198">ANDHRA PRADESH GRAMEENA VIKAS BANK</option>
                                    <option value="607122">KARNATAKA VIKAS GRAMEENA BANK</option>
                                    <option value="990309">Kotak Mahindra Bank</option>
                                    <option value="607053">SAPTAGIRI GRAMEENA BANK</option>
                                    <option value="607139">SARVA HARYANA GRAMIN BANK</option>
                                    <option value="607060">ODISHA GRAMYA BANK</option>
                                    <option value="607152">HDFC Bank</option>
                                    <option value="607509">RAJASTHAN MARUDHARA GRAMIN BANK</option>
                                    <option value="508534">ICICI Bank</option>
                                    <option value="607024">ARYAVART BANK</option>
                                    <option value="607095">IDBI BANK</option>
                                    <option value="607052">TAMIL NADU GRAMA BANK</option>
                                    <option value="607065">TRIPURA GRAMIN BANK</option>
                                    <option value="607214">CHHATTISGARH RAJYA GRAMIN BANK</option>
                                    <option value="607234">UTKAL GRAMEEN BANK</option>
                                    <option value="607138">PUNJAB GRAMIN BANK</option>
                                    <option value="817304">FINCARE SMALL FINANCE BANK</option>
                                    <option value="607153">Axis Bank</option>
                                    <option value="607210">JHARKHAND RAJYA GRAMIN BANK</option>
                                    <option value="607073">UTTAR BANGA KSHETRIYA GRAMIN BANK</option>
                                    <option value="607232">MADHYANCHAL GRAMIN BANK</option>
                                    <option value="607363">FEDERAL BANK</option>
                                    <option value="607399">KERALA GRAMIN BANK</option>
                                    <option value="607440">JAMMU AND KASHMIR BANK</option>
                                    <option value="606995">BARODA GUJARAT GRAMIN BANK</option>
                                    <option value="607768">NSDL PAYMENTS BANK</option>
                                    <option value="607393">RBL BANK</option>
                                    <option value="607064 ">ASSAM GRAMIN VIKASH BANK</option>
                                    <option value="607324">CITY UNION BANK</option>
                                    <option value="607080">CHAITANYA GODAVARI GRAMEENA BANK</option>
                                    <option value="608022">SURYODAY SMALL FINANCE BANK</option>
                                    <option value="608087">AU Small Finance Bank</option>
                                    <option value="608117">IDFC FIRST Bank</option>
                                    <option value="508991">UJJIVAN SMALL FINANCE BANK</option>
                                    <option value="607270">KARNATAKA BANK</option>
                                    <option value="508647">THE CUDDALORE DISTRICT CENTRAL CO-OP BANK</option>
                                    <option value="607020">VIDHARBHA KONKAN GRAMIN BANK</option>
                                    <option value="608014">UTKARSH SMALL FINANCE BANK</option>
                                    <option value="508680">THE TIRUCHIRAPALLI DISTRICT CENTRAL CO-OP BANK</option>
                                    <option value="607197">UTTARAKHAND GRAMIN BANK</option>
                                    <option value="508720">THE KUMBAKONAM CENTRAL CO-OP BANK</option>
                                    <option value="508646">THE COIMBATORE DISTRICT CENTRAL CO-OP BANK</option>
                                    <option value="508737">THE VILLUPURAM DISTRICT CENTRAL CO-OP BANK</option>
                                    <option value="508662">KARUR VYSYA BANK</option>
                                    <option value="508659">THE DINDIGUL CENTRAL CO-OP BANK</option>
                                    <option value="508658">DHARMAPURI CENTRAL CO-OP BANK</option>
                                    <option value="607884">JIO PAYMENTS BANK</option>
                                    <option value="607439">SOUTH INDIAN BANK</option>
                                    <option value="607187">TAMILNAD MERCANTILE BANK</option>
                                    <option value="607618">Yes Bank</option>
                                    <option value="607054">PUDUVAI BHARATHIAR GRAMA BANK</option>
                                    <option value="508656">THE PUDUKKOTTAI DISTRICT CENTRAL CO-OP BANK</option>
                                    <option value="508660">THE NILGIRIS DISTRICT CENTRAL CO-OP BANK</option>
                                    <option value="508648">THE SALEM DISTRICT CENTRAL CO-OP BANK</option>
                                    <option value="508665">THE THANJAVUR CENTRAL CO-OP BANK</option>
                                    <option value="607058">LAKSHMI VILAS BANK</option>
                                    <option value="508677">THE TIRUNELVELI DISTRICT CENTRAL CO-OP BANK</option>
                                    <option value="508657">THE TIRUVANNAMALAI DISTRICT CENTRAL CO-OP BANK</option>
                                    <option value="652150">SARASWAT BANK</option>
                                    <option value="508681">THE MADURAI DISTRICT CENTRAL CO-OP BANK</option>
                                    <option value="508679">THE VELLORE DISTRICT CENTRAL CO-OP BANK</option>
                                    <option value="508998">EQUITAS SMALL FINANCE BANK</option>
                                    <option value="607140">HIMACHAL PRADESH GRAMIN BANK</option>
                                    <option value="508910">JANA SMALL FINANCE BANK</option>
                                    <option value="508676">THE RAMANATHAPURAM DISTRICT CENTRAL CO-OP BANK</option>
                                    <option value="508654">ERODE DISTRICT CENTRAL CO-OP BANK</option>
                                    <option value="607062">MANIPUR RURAL BANK</option>
                                    <option value="607206">MEGHALAYA RURAL BANK</option>
                                    <option value="607395">SBM BANK</option>
                                    <option value="508664">THE CHENNAI CENTRAL CO-OP BANK</option>
                                    <option value="508732">THE VIRUDHUNAGAR DISTRICT CENTRAL CO-OP BANK</option>
                                    <option value="607978">TRIPURA STATE CO-OP BANK</option>
                                    <option value="508754">ANGUL UNITED CENTRAL CO-OP BANK</option>
                                    <option value="508774">BOLANGIR DISTRICT CENTRAL CO-OP BANK</option>
                                    <option value="608194">COSMOS BANK</option>
                                    <option value="607082">CSB Bank</option>
                                    <option value="508776">CUTTACK CENTRAL CO-OP BANK</option>
                                    <option value="607218">ELLAQUAI DEH</option>
                            
                                    <option value="607094">STATE BANK OF INDIA</option>
                                    <option value="607027">Punjab National Bank</option>
                                    <option value="608314">INDIA POST PAYMENTS BANK</option>
                                    <option value="607105">INDIAN BANK</option>
                                    <option value="607161">UNION BANK OF INDIA</option>
                                    <option value="508505">BANK OF INDIA</option>
                                    <option value="606985">BANK OF BARODA</option>
                                    <option value="607396">CANARA BANK</option>
                                    <option value="607126">INDIAN OVERSEAS BANK</option>
                                    <option value="607066">UCO BANK</option>
                                    <option value="606993">BARODA UP BANK</option>
                                    <option value="607264">CENTRAL BANK OF INDIA</option>
                                    <option value="990320">AIRTEL PAYMENTS BANK</option>
                                    <option value="607280">BARODA RAJASTHAN KSHETRIYA GRAMIN BANK</option>
                                    <option value="607189">IndusInd Bank</option>
                                    <option value="607063">BANGIYA GRAMIN VIKASH BANK</option>
                                    <option value="607069">UTTAR BIHAR GRAMIN BANK</option>
                                    <option value="607387">BANK OF MAHARASHTRA</option>
                                    <option value="608001">FINO PAYMENTS BANK</option>
                                    <option value="607136">DAKSHIN BIHAR GRAMIN BANK</option>
                                    <option value="607135">PRATHAMA UP GRAMIN BANK</option>
                                    <option value="607087">PUNJAB AND SIND BANK</option>
                                    <option value="607121">ANDHRA PRAGATHI GRAMEENA BANK</option>
                                    <option value="607400">KARNATAKA GRAMIN BANK</option>
                                    <option value="607022">MADHYA PRADESH GRAMEEN BANK</option>
                                    <option value="607195">TELANGANA GRAMEENA BANK</option>
                                    <option value="607198">ANDHRA PRADESH GRAMEENA VIKAS BANK</option>
                                    <option value="607122">KARNATAKA VIKAS GRAMEENA BANK</option>
                                    <option value="990309">Kotak Mahindra Bank</option>
                                    <option value="607053">SAPTAGIRI GRAMEENA BANK</option>
                                    <option value="607139">SARVA HARYANA GRAMIN BANK</option>
                                    <option value="607060">ODISHA GRAMYA BANK</option>
                                    <option value="607152">HDFC Bank</option>
                                    <option value="607509">RAJASTHAN MARUDHARA GRAMIN BANK</option>
                                    <option value="508534">ICICI Bank</option>
                                    <option value="607024">ARYAVART BANK</option>
                                    <option value="607095">IDBI BANK</option>
                                    <option value="607052">TAMIL NADU GRAMA BANK</option>
                                    <option value="607065">TRIPURA GRAMIN BANK</option>
                                    <option value="607214">CHHATTISGARH RAJYA GRAMIN BANK</option>
                                    <option value="607234">UTKAL GRAMEEN BANK</option>
                                    <option value="607138">PUNJAB GRAMIN BANK</option>
                                    <option value="817304">FINCARE SMALL FINANCE BANK</option>
                                    <option value="607153">Axis Bank</option>
                                    <option value="607210">JHARKHAND RAJYA GRAMIN BANK</option>
                                    <option value="607073">UTTAR BANGA KSHETRIYA GRAMIN BANK</option>
                                    <option value="607232">MADHYANCHAL GRAMIN BANK</option>
                                    <option value="607363">FEDERAL BANK</option>
                                    <option value="607399">KERALA GRAMIN BANK</option>
                                    <option value="607440">JAMMU AND KASHMIR BANK</option>
                                    <option value="606995">BARODA GUJARAT GRAMIN BANK</option>
                                    <option value="607768">NSDL PAYMENTS BANK</option>
                                    <option value="607393">RBL BANK</option>
                                    <option value="607064">ASSAM GRAMIN VIKASH BANK</option>
                                    <option value="607324">CITY UNION BANK</option>
                                    <option value="607080">CHAITANYA GODAV</option>
                                  <option value="607218">ELLAQUAI DEHATI BANK</option>
                                  <option value="508992">ESAF SMALL FINANCE BANK</option>
                                  <option value="607000">MAHARASHTRA GRAMEEN BANK</option>
                                  <option value="508756">MAYURBHANJ CENTRAL CO-OP BANK</option>
                                  <option value="608032">PAYTM PAYMENTS BANK</option>
                                  <option value="607200">SAURASHTRA GRAMIN BANK</option>
                                  <option value="607119">SHIVALIK MERCANTILE CO-OP BANK</option>
                                  <option value="607131">TAMILNADU STATE APEX CO-OP BANK (TNSC BANK)</option>
                                  <option value="508761">THE BANKI CENTRAL CO-OP BANK</option>
                                  <option value="508734">THE KANCHIPURAM CENTRAL CO-OP BANK</option>
                                  <option value="508655">THE KANYAKUMARI DISTRICT CENTRAL CO-OP BANK</option>
                                  <option value="508771">THE KHORDHA CENTRAL CO-OP BANK</option>
                                  <option value="508755">THE KORAPUT CENTRAL CO-OP BANK</option>
                                  <option value="607315">THE MAHARASHTRA STATE CO-OP BANK</option>
                                  <option value="508777">THE SAMBALPUR DISTRICT CO-OP CENTRAL BANK</option>
                                  <option value="508678">THE THOOTHUKUDI DISTRICT CENTRAL CO-OP BANK</option>
                                  <option value="508782">UNITED PURI NIMAPARA CENTRAL CO-OP BANK</option>
                                  <option value="508758">BALASORE BHADRAK CENTRAL CO-OP BANK</option>
                                  <option value="508759">BERHAMPORE CENTRAL CO-OP BANK</option>
                                  <option value="508775">BOUDH CENTRAL CO-OP BANK</option>
                                  <option value="607808">JAMMU AND KASHMIR GRAMEEN BANK</option>
                                  <option value="508760">KEONJHAR CENTRAL CO-OP BANK</option>
                                  <option value="608165">KERALA STATE CO-OP BANK</option>
                                  <option value="607230">MIZORAM RURAL BANK</option>
                                  <option value="508772">NAYAGARH DISTRICT CENTRAL CO-OP BANK</option>
                                  <option value="607079">PASCHIM BANGA GRAMIN BANK</option>
                                  <option value="508757">SUNDARGARH CENTRAL CO-OP BANK</option>
                                  <option value="607051">THE AP MAHESH CO-OP URBAN BANK</option>
                                  <option value="508773">THE ASKA CO-OP CENTRAL BANK</option>
                                  <option value="607847">THE BHANDARA DISTRICT CENTRAL CO-OP BANK</option>
                                  <option value="508778">THE BHAWANIPATNA CENTRAL CO-OP BANK</option>
                                  <option value="607157">THE GAYATRI CO-OPERATIVE URBAN BANK</option>
                                  <option value="607935">THE ODISHA STATE CO-OP BANK</option>
                                  <option value="607266">THE RAJASTHAN STATE CO-OP BANK</option>
                                  <option value="508649">THE SIVAGANGAI DISTRICT CENTRAL CO-OP BANK</option>
                                  <option value="607602">THE YAVATMAL DISTRICT CENTRAL CO-OP BANK</option>
                                  <option value="607523">UTTAR PRADESH CO-OP BANK</option>
                                 
                                  <option value="607218">ELLAQUAI DEHATI BANK</option>
                                  <option value="508992">ESAF SMALL FINANCE BANK</option>
                                  <option value="607000">MAHARASHTRA GRAMEEN BANK</option>
                                  <option value="508756">MAYURBHANJ CENTRAL CO-OP BANK</option>
                                  <option value="608032">PAYTM PAYMENTS BANK</option>
                                  <option value="607200">SAURASHTRA GRAMIN BANK</option>
                                  <option value="607119">SHIVALIK MERCANTILE CO-OP BANK</option>
                                  <option value="607131">TAMILNADU STATE APEX CO-OP BANK (TNSC BANK)</option>
                                  <option value="508761">THE BANKI CENTRAL CO-OP BANK</option>
                                  <option value="508734">THE KANCHIPURAM CENTRAL CO-OP BANK</option>
                                  <option value="508655">THE KANYAKUMARI DISTRICT CENTRAL CO-OP BANK</option>
                                  <option value="508771">THE KHORDHA CENTRAL CO-OP BANK</option>
                                  <option value="508755">THE KORAPUT CENTRAL CO-OP BANK</option>
                                  <option value="607315">THE MAHARASHTRA STATE CO-OP BANK</option>
                                  <option value="508777">THE SAMBALPUR DISTRICT CO-OP CENTRAL BANK</option>
                                  <option value="508678">THE THOOTHUKUDI DISTRICT CENTRAL CO-OP BANK</option>
                                  <option value="508782">UNITED PURI NIMAPARA CENTRAL CO-OP BANK</option>
                                  <option value="508758">BALASORE BHADRAK CENTRAL CO-OP BANK</option>
                                  <option value="508759">BERHAMPORE CENTRAL CO-OP BANK</option>
                                  <option value="508775">BOUDH CENTRAL CO-OP BANK</option>
                                  <option value="607808">JAMMU AND KASHMIR GRAMEEN BANK</option>
                                  <option value="508760">KEONJHAR CENTRAL CO-OP BANK</option>
                                  <option value="608165">KERALA STATE CO-OP BANK</option>
                                  <option value="607230">MIZORAM RURAL BANK</option>
                                  <option value="508772">NAYAGARH DISTRICT CENTRAL CO-OP BANK</option>
                                  <option value="607079">PASCHIM BANGA GRAMIN BANK</option>
                                  <option value="508757">SUNDARGARH CENTRAL CO-OP BANK</option>
                                  <option value="607051">THE AP MAHESH CO-OP URBAN BANK</option>
                                  <option value="508773">THE ASKA CO-OP CENTRAL BANK</option>
                                  <option value="607847">THE BHANDARA DISTRICT CENTRAL CO-OP BANK</option>
                                  <option value="508778">THE BHAWANIPATNA CENTRAL CO-OP BANK</option>
                                  <option value="607157">THE GAYATRI CO-OPERATIVE URBAN BANK</option>
                                  <option value="607935">THE ODISHA STATE CO-OP BANK</option>
                                  <option value="607266">THE RAJASTHAN STATE CO-OP BANK</option>
                                  <option value="508649">THE SIVAGANGAI DISTRICT CENTRAL CO-OP BANK</option>
                                  <option value="607602">THE YAVATMAL DISTRICT CENTRAL CO-OP BANK</option>
                                  <option value="607523">UTTAR PRADESH CO-OP BANK</option>
                                    <!-- Add any additional banks as needed -->
                                </select>
                            </div>
                             <!-- Amount Number Field -->
                             <div class="form-group mb-3">
                                <label for="aadhaar" class="form-label">Amount</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text" class="form-control numeric-input" id="aadhaar" name="amount" placeholder="Enter Amount"  required/>
                                </div>
                              
                            </div>
                            <!-- Mobile Number Field -->
                            <div class="form-group mb-3">
                                <label for="mobile" class="form-label">Mobile Number</label>
                                <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Enter Mobile Number" maxlength="10" required/>
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
                            <textarea id="txtBiometricData" hidden name="biometricData" rows="10" cols="50" placeholder="Biometric Data will appear here"></textarea>
                            <!-- Submit and Reset Buttons -->
                            <a onclick="discoverAvdm();"  id="discoverButton" style="display:none;">Discover AVDM</a>
                            <div class="d-flex justify-content-end gap-3">
                                <!-- Capture Button -->
                                <button onclick="CaptureAvdm();" class="btn btn-custom btn-danger">Capture</button>
                            
                                <!-- Submit Button -->
                                <!-- <button type="submit" class="btn btn-success w-100 mb-2 mb-sm-0">Submit</button> -->
                            
                                <!-- Reset Button -->
                                <button type="reset" class="btn btn-warning">Reset</button>
                            </div>
                            
                        </form>
                    </div>
                </div>
            {{-- </div> --}}
        <!-- </div> -->

         <!-- Latest Transactions Section -->
         <div class="col-md-6">
            <div class="border-1 h-100">
                <div class="card-header bg-gradient-success text-white text-center">
                    <h5 class="mb-0 card-heading">Latest Transactions</h5>
                </div>
                <div class="card-body p-4">
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

    {{-- </div> --}}
</div>

<!-- JavaScript for Location and Biometric Data Fetching -->
<!-- JavaScript to Fetch Latitude and Longitude -->
<script>
  window.onload = async function () {
            try {
                // Run discoverAvdm function and wait for it to complete
                await discoverAvdm();
            } catch (error) {
                console.error("Error in discoverAvdm:", error);
            } finally {
                // Remove loader and enable interactions after the function finishes
                document.getElementById("loadingOverlay").style.display = "none";
                document.body.classList.remove("loading");
            }
        };

    document.addEventListener("DOMContentLoaded", () => {
        // Auto-fetch location details (latitude and longitude)
        function fetchLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        document.getElementById('latitude').value = position.coords.latitude;
                        document.getElementById('longitude').value = position.coords.longitude;
                        console.log("Location fetched: ", position.coords.latitude, position.coords.longitude);
                    },
                    (error) => {
                        console.error("Error fetching location: ", error);
                        alert("Unable to retrieve your location. Please enable location access or check permissions.");
                    }
                );
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        }

        // Call fetchLocation on page load
        fetchLocation();
    });
</script>


{{-- bio Data --}}

<div >

</div>




</div>
<!-- <div>
    <h4 >Initialized Framework</h4>
    <div>
        <button type="button" onclick="discoverAvdm();" type="button" value="Discover AVDM">Discover AVDM</button>

        <button type="button" value="Device Info" onclick="deviceInfoAvdm();">Device Info</button>

        <button type="button" value="Capture" onclick="CaptureAvdm();">Capture</button>

        <button type="button" onclick="reset();" value="Reset">Reset</button>
        &nbsp;&nbsp;
</div> -->
<!-- <div>
    <textarea id="txtPidData" rows="7"></textarea>
</div> -->
<div">
<section  style="display:none">


<div id="wrapper" >
    <div id="myNav">
        <div>
            <a href="#">Please wait while discovering port from 11100 to 11120.This will take some time.</a>
        </div>
    </div>
    <!-- Navigation -->
    <div  role="navigation">
        <div>
            <a><img src="logo.png" alt="Mantra logo"></a>
        </div>
        <!-- /.navbar-header -->

        <div>
            <h2>Mantra RD Service Call</h2>
        </div>
    </div>
    
    
    <div>

                                        <div>
                                            <label> Custom SSL Certificate Domain Name  Ex:(rd.myservice.com) </label>
                                            <input type="text" id="txtSSLDomName" placeholder="127.0.0.1">
                                        </div>
                                        </div>
                                </div>
                                <div>

                                        <div>
                                            <label ><b>[ After binding custom SSL certificate, add your domain name in hosts file  (C:\Windows\System32\drivers\etc\hosts)</b></label>
                                            <label><b>Ex: 127.0.0.1   rd.myservice.com ]</b></label>
                                        </div>
                                        </div>
                                </div>
    
    <div>
        <!-- /.row -->
        <div>
            <div>
                <div>

                    <!-- <h4>Initialized Framework</h4>
                    <div>
                        <button type="button" onclick="discoverAvdm();" type="button" value="Discover AVDM">Discover AVDM</button>

                        <button type="button" value="Device Info" onclick="deviceInfoAvdm();">Device Info</button>

                        <button type="button" value="Capture" onclick="CaptureAvdm();">Capture</button>

                        <button type="button" onclick="reset();" value="Reset">Reset</button>
                        &nbsp;&nbsp; -->
                        
                        <!-- <input   name="ChkRD" id="chkHttpsPort" type="checkbox">Custome Port For HTTPS</input> -->
                        {{-- <input   name="ChkRD" id="chkHttpsPort" type="checkbox"></input> --}}
                        
                    </div>



                </div>
            </div>

            <div style="display:none">
                <div>
                    <div>
                        Select Option to Capture
                    </div>
                    <div>
                        <div>
                            <div>
                                <div>
                                    <label>AVDM</label>
                                    <select id="ddlAVDM">
                                        <option></option>
                                    </select>
                                </div>
                                <div>
                                    <div>
                                        <div>
                                            <label>Timeout</label>
                                            <select id="Timeout">
                                                <option>10000</option>
                                                <option>11000</option>
                                                <option>12000</option>
                                                <option>13000</option>
                                                <option>14000</option>
                                                <option>15000</option>
                                                <option>16000</option>
                                                <option>17000</option>
                                                <option>18000</option>
                                                <option>19000</option>
                                                <option>20000</option>
                                                <option>30000</option>
                                                <option>40000</option>
                                                <option>50000</option>
                                                <option>60000</option>
                                                <option>70000</option>
                                                <option>80000</option>
                                                <option>90000</option>
                                                <option>100000</option>
                                                <option>0</option>
                                            </select>
                                        </div>


                                    </div>


                                    <div>
                                        <div>
                                            <label>PidVer</label>
                                            <select id="Pidver">
                                                <option>2.0</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div>
                                        <div>
                                            <label>Env</label>
                                            <select id="Env">
                                                <option>S</option>
                                                <option >PP</option>
                                                <option selected="true">P</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>


                                <div>
                                    <div>
                                        <div>
                                            <label>PTimeout</label>
                                            <select id="pTimeout">
                                                <option>10000</option>
                                                <option selected="selected">20000</option>
                                                <option>30000</option>
                                                <option>40000</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div>
                                        <div>
                                            <label>PGCount</label>
                                            <select id="pgCount">
                                                <option>1</option>
                                                <option selected="selected">2</option>
                                            </select>
                                        </div>
                                    </div>


                                </div>




                            </div>
                            <div>

                                <div >
                                    <label>DataType</label>
                                    <select id="Dtype">
                                        <option value="0">X</option>
                                        <option value="1">P</option>

                                    </select>
                                </div>

                                <div>
                                    <label>Client Key</label>
                                    <input id="txtCK"  type="text" placeholder="Enter text">
                                </div>

                                <div>
                                    <label>OTP</label>
                                    <input id="txtotp"  type="text" placeholder="Enter text">
                                </div>

                            </div>

                            <div>
                                <div>
                                    <label>Wadh</label>
                                    <textarea id="txtWadh" rows="3"></textarea>
                                </div>

                            </div>
                            <div >
                                <div>
                                    <div>
                                        <div>
                                            <label>Finger Count</label>
                                            <select id="Fcount">
                                                <option>0</option>
                                                <option selected="selected">1</option>
                                                <option>2</option>
                                                <option>3</option>
                                                <option>4</option>
                                                <option>5</option>
                                                <option>6</option>
                                                <option>7</option>
                                                <option>8</option>
                                                <option>9</option>
                                                <option>10</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label>Iris Count</label>
                                            <select id="Icount">
                                                <option>0</option>
                                                <option>1</option>
                                                <option>2</option>
                                            </select>
                                        </div>

                                    </div>
                                    <div>
                                        <div>
                                            <label>Face Count</label>
                                            <select id="Pcount">
                                                <option>0</option>
                                                <option>1</option>
                                            </select>
                                        </div>
                                        <div >
                                            <label>Finger Type</label>
                                            <select id="Ftype">
                                                <option value="0">FMR</option>
                                                <option value="1">FIR</option>
                                                <option value="2">BOTH</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div>

                                        <div>
                                            <label>Iris Type </label>
                                            <select id="Itype">
                                                <option>SELECT</option>
                                                <option>ISO</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label>Face Type</label>
                                            <select id="Ptype">
                                                <option>SELECT</option>
                                            </select>
                                        </div>
                                    </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div >
                <div>
                    <div>
                        AVDM / Device Info
                    </div>
                    <div>

                        <div>
                            <textarea rows="5" id="txtDeviceInfo"></textarea>
                        </div>


                        <!-- /.row (nested) -->
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <div>
                <div>
                    <div>
                        Pid Options
                    </div>
                    <div>

                        <div>
                            <textarea id="txtPidOptions" rows="5"></textarea>
                        </div>


                        <!-- /.row (nested) -->
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <div >
                <div>
                    <div>
                        Pid Data
                    </div>
                    <div>

                        <div>
                            <textarea id="txtPidData" rows="7"></textarea>
                        </div>


                        <!-- /.row (nested) -->
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <div>
                <div>
                    <div >
                        PERSONAL IDENTITY(PI)
                    </div>
                    <div>
                        <div>

                            <div>
                                <div>

                                    <div>
                                        <label>Name</label>
                                        <div>
                                            <input type="text"  id="txtName" placeholder="Enter Your Name">
                                        </div>
                                    </div>
                                    <div>
                                        <label>Local Name:</label>
                                        <div>
                                            <input type="text"  id="txtLocalNamePI" placeholder="Local Name">
                                        </div>
                                    </div>
                                    <div>
                                        <label>Gender</label>
                                        <div>
                                            <select id="drpGender">
                                                <option value="0">Select</option>
                                                <option>MALE</option>
                                                <option>FEMALE</option>
                                                <option>TRANSGENDER</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div >
                                        <label>DOB</label>
                                        <div>
                                            <input type="text"  id="txtDOB" placeholder="DOB">
                                        </div>
                                    </div>
                                    <div>
                                        <label >Phone</label>
                                        <div >
                                            <input type="text"  id="txtPhone" placeholder="Phone">
                                        </div>
                                    </div>
                                    <div>
                                        <label >DOB Type:</label>
                                        <div >
                                            <select id="drpDOBType" >
                                                <option value="0">select</option>
                                                <option>V</option>
                                                <option>D</option>
                                                <option>A</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div >
                                <div role="form">
                                    <div>
                                        <label >Match Strategy</label>
                                        <div >

                                            <label >
                                                <input type="radio" name="RDPI" id="rdExactPI" checked="true">Exact
                                            </label>
                                            <label >
                                                <input type="radio" name="RDPI" id="rdPartialPI"> Partial
                                            </label>
                                            <label>
                                                <input type="radio" name="RDPI" id="rdFuzzyPI"> Fuzzy
                                            </label>

                                        </div>
                                    </div>
                                    <div>
                                        <label>Match Value:</label>
                                        <div>
                                            <select id="drpMatchValuePI"></select>
                                        </div>
                                    </div>
                                    <div>
                                        <label>Age</label>
                                        <div>
                                            <input type="number"  id="txtAge" placeholder="Age">
                                        </div>
                                    </div>
                                    <div>
                                        <label>LocalMatchValue:</label>
                                        <div>
                                            <select  id="drpLocalMatchValuePI"></select>
                                        </div>
                                    </div>
                                    <div>
                                        <label >Email</label>
                                        <div>
                                            <input type="email"  id="txtEmail" placeholder="Email">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div   ">
                <div >
                    <div>
                        PERSONAL ADDRESS(PA)
                    </div>
                    <div>
                        <div >
                            <div >
                                <form role="form" >
                                    <div >
                                        <label >Care Of:</label>
                                        <div >
                                            <input type="text"  id="txtCareOf" placeholder="Care Of:">
                                        </div>
                                    </div>
                                    <div >
                                        <label >Landmark:</label>
                                        <div >
                                            <input type="text"  id="txtLandMark" placeholder="Landmark">
                                        </div>
                                    </div>
                                    <div >
                                        <label >Locality:</label>
                                        <div >
                                            <input type="text"  id="txtLocality" placeholder="Locality">
                                        </div>
                                    </div>
                                    <div >
                                        <label >City:</label>
                                        <div>
                                            <input type="text"  id="txtCity" placeholder="Email">
                                        </div>
                                    </div>
                                    <div >
                                        <label >District:</label>
                                        <div >
                                            <input type="text"  id="txtDist" placeholder="Email">
                                        </div>
                                    </div>
                                    <div >
                                        <label >PinCode:</label>
                                        <div >
                                            <input type="text"  id="txtPinCode" placeholder="PinCode">
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div >
                                <form role="form" >
                                    <div >
                                        <label>Building: 	</label>
                                        <div>
                                            <input type="text"  id="txtBuilding" placeholder="Building">
                                        </div>
                                    </div>
                                    <div >
                                        <label >Street:</label>
                                        <div >
                                            <input type="text"  id="txtStreet" placeholder="Street">
                                        </div>
                                    </div>
                                    <div >
                                        <label >PO Name: </label>
                                        <div>
                                            <input type="text"  id="txtPOName" placeholder="PO Name">
                                        </div>
                                    </div>
                                    <div >
                                        <label >Sub Dist:</label>
                                        <div >
                                            <input type="text"  id="txtSubDist" placeholder="Sub Dist">
                                        </div>
                                    </div>
                                    <div >
                                        <label >State:</label>
                                        <div >
                                            <input type="text"  id="txtState" placeholder="State">
                                        </div>
                                    </div>
                                    <div >
                                        <label >Match Strategy:</label>
                                        <div >
                                            <label >
                                                <input type="radio" name="optionsRadiosInline" id="rdMatchStrategyPA" checked="true" value="option1">Exact
                                            </label>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div >
                <div >
                    <div>
                        PERSONAL FULL ADDRESS(PFA)
                    </div>
                    <div >
                        <div >
                            <div>
                                <form role="form">
                                    <div >
                                        <label>Email </label>
                                        <label >
                                            <input type="radio" name="RD" id="rdExactPFA" checked="true">Exact
                                        </label>
                                        <label ">
                                            <input type="radio" name="RD" id="rdPartialPFA"> Partial
                                        </label>
                                        <label >
                                            <input type="radio" name="RD" id="rdFuzzyPFA"> Fuzzy
                                        </label>
                                    </div>
                                    <div >
                                        <div >
                                            <div >
                                                <label>Match Value:</label>
                                                <select  id="drpMatchValuePFA"></select>
                                            </div>
                                        </div>
                                        <div >
                                            <div>
                                                <label>Local Match Value:</label>
                                                <select  id="drpLocalMatchValue"></select>
                                            </div>
                                        </div>

                                    </div>

                                </form>
                            </div>
                            <div >
                                <form role="form">
                                    <div >
                                        <label>Address Value:</label>
                                        <textarea rows="2" id="txtAddressValue" ></textarea>
                                    </div>
                                </form>
                            </div>
                            <div >
                                <form role="form">
                                    <div>
                                        <label>Local Address:</label>
                                        <textarea rows="2" id="txtLocalAddress"></textarea>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div >
                <label id="lblstatus">
                </label>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /#page-wrapper -->
</div>
<!-- /#wrapper -->
<script language="javascript" type="text/javascript">

    var GetCustomDomName='127.0.0.1';
    var GetPIString='';
    var GetPAString='';
    var GetPFAString='';
    var DemoFinalString='';
    var select = '';
    select += '<option val=0>Select</option>';
    for (i=1;i<=100;i++){
        select += '<option val=' + i + '>' + i + '</option>';
    }
    $('#drpMatchValuePI').html(select);
    $('#drpMatchValuePFA').html(select);
    $('#drpLocalMatchValue').html(select);
    $('#drpLocalMatchValuePI').html(select);

    var finalUrl="";
    var MethodInfo="";
    var MethodCapture="";
    var OldPort=false;






    function test()
    {
        alert("I am calling..");
    }

    function reset()
    {
      
    

    
        $('#txtWadh').val('');
        $('#txtDeviceInfo').val('');
        $('#txtPidOptions').val('');
        $('#txtPidData').val('');
        $("select#ddlAVDM").prop('selectedIndex', 0);
        $("select#Timeout").prop('selectedIndex', 0);
        $("select#Icount").prop('selectedIndex', 0);
        $("select#Fcount").prop('selectedIndex', 0);
        $("select#Icount").prop('selectedIndex', 0);
        $("select#Itype").prop('selectedIndex', 0);
        $("select#Ptype").prop('selectedIndex', 0);
        $("select#Ftype").prop('selectedIndex', 0);
        $("select#Dtype").prop('selectedIndex', 0);

        $('#txtotp').val('');
        $("select#pTimeout").prop('selectedIndex', 1);
        $("select#pgCount").prop('selectedIndex', 1);
        $('#txtSSLDomName').val('');
    }
    // All New Function

    function Demo()
    {


    var GetPIStringstr='';
    var GetPAStringstr='';
    var GetPFAStringstr='';

        if(GetPI()==true)
        {
            GetPIStringstr ='<Pi '+GetPIString+' />';

        }
        else
        {
            GetPIString='';
        }

        if(GetPA()==true)
        {
            GetPAStringstr ='<Pa '+GetPAString+' />';
            //alert(GetPAStringstr);
        }
        else
        {
            GetPAString='';
        }

        if(GetPFA()==true)
        {
            GetPFAStringstr ='<Pfa '+GetPFAString+' />';
            //alert(GetPFAStringstr);
        }
        else
        {
            GetPFAString='';
        }

        if(GetPI()==false && GetPA()==false && GetPFA()==false)
        {
            //alert("Fill Data!");
            DemoFinalString='';
        }
        else
        {
            DemoFinalString = '<Demo>'+ GetPIStringstr +' ' + GetPAStringstr + ' ' + GetPFAStringstr + ' </Demo>';
            //alert(DemoFinalString)
        }


    }

    function GetPI()
    {
        var Flag=false;
        GetPIString='';

         if ($("#txtName").val().length > 0)
        {
            Flag = true;
            GetPIString += "name="+ "\""+$("#txtName").val()+"\"";
        }

        if ($("#drpMatchValuePI").val() > 0 && Flag)
        {
            Flag = true;
            GetPIString += " mv="+ "\""+$("#drpMatchValuePI").val()+"\"";
        }

        if ($('#rdExactPI').is(':checked') && Flag)
        {
            Flag = true;
            GetPIString += " ms="+ "\"E\"";
        }
        else if ($('#rdPartialPI').is(':checked') && Flag)
        {
            Flag = true;
           GetPIString += " ms="+ "\"P\"";
        }
        else if ($('#rdFuzzyPI').is(':checked') && Flag)
        {
            Flag = true;
            GetPIString += " ms="+ "\"F\"";
        }
        if ($("#txtLocalNamePI").val().length > 0)
        {
            Flag = true;
            GetPIString += " lname="+ "\""+$("#txtLocalNamePI").val()+"\"";
        }

        if ($("#txtLocalNamePI").val().length > 0 && $("#drpLocalMatchValuePI").val() > 0)
        {
            Flag = true;
            GetPIString += " lmv="+ "\""+$("#drpLocalMatchValuePI").val()+"\"";
        }



            if ($("#drpGender").val() == "MALE")
            {
                Flag = true;
                 GetPIString += " gender="+ "\"M\"";
            }
            else if ($("#drpGender").val() == "FEMALE")
            {
                Flag = true;
                 GetPIString += " gender="+ "\"F\"";
            }
            else if ($("#drpGender").val() == "TRANSGENDER")
            {
                Flag = true;
               GetPIString += " gender="+ "\"T\"";
            }
        //}
            if ($("#txtDOB").val().length > 0 )
            {
                Flag = true;
                GetPIString += " dob="+ "\""+$("#txtDOB").val()+"\"";
            }

            if ($("#drpDOBType").val() != "0")
            {
                Flag = true;
                GetPIString += " dobt="+ "\""+$("#drpDOBType").val()+"\"";
            }

            if ($("#txtAge").val().length)
            {
                Flag = true;
                GetPIString += " age="+ "\""+$("#txtAge").val()+"\"";
            }

            if ($("#txtPhone").val().length > 0 || $("#txtEmail").val().length > 0)
            {
                Flag = true;
                GetPIString += " phone="+ "\""+$("#txtPhone").val()+"\"";
            }
            if ($("#txtEmail").val().length > 0)
            {
                Flag = true;
                GetPIString += " email="+ "\""+$("#txtEmail").val()+"\"";
            }

        //alert(GetPIString);
        return Flag;
    }


    function GetPA()
    {
        var Flag=false;
        GetPAString='';

        if ($("#txtCareOf").val().length > 0)
        {
            Flag = true;
            GetPAString += "co="+ "\""+$("#txtCareOf").val()+"\"";
        }
        if ($("#txtLandMark").val().length > 0 )
        {
            Flag = true;
            GetPAString += " lm="+ "\""+$("#txtLandMark").val()+"\"";
        }
        if ($("#txtLocality").val().length > 0 )
        {
           Flag = true;
            GetPAString += " loc="+ "\""+$("#txtLocality").val()+"\"";
        }
        if ($("#txtCity").val().length > 0 )
        {
            Flag = true;
            GetPAString += " vtc="+ "\""+$("#txtCity").val()+"\"";
        }
        if ($("#txtDist").val().length > 0 )
        {
            Flag = true;
            GetPAString += " dist="+ "\""+$("#txtDist").val()+"\"";
        }
        if ($("#txtPinCode").val().length > 0 )
        {
            Flag = true;
            GetPAString += " pc="+ "\""+$("#txtPinCode").val()+"\"";
        }
        if ($("#txtBuilding").val().length > 0 )
        {
             Flag = true;
            GetPAString += " house="+ "\""+$("#txtBuilding").val()+"\"";
        }
        if ($("#txtStreet").val().length > 0 )
        {
             Flag = true;
            GetPAString += " street="+ "\""+$("#txtStreet").val()+"\"";
        }
        if ($("#txtPOName").val().length > 0 )
        {
             Flag = true;
            GetPAString += " po="+ "\""+$("#txtPOName").val()+"\"";
        }
        if ($("#txtSubDist").val().length > 0 )
        {
              Flag = true;
            GetPAString += " subdist="+ "\""+$("#txtSubDist").val()+"\"";
        }
        if ($("#txtState").val().length > 0)
        {
             Flag = true;
            GetPAString += " state="+ "\""+$("#txtState").val()+"\"";
        }
        if ( $('#rdMatchStrategyPA').is(':checked') && Flag)
        {
            Flag = true;
            GetPAString += " ms="+ "\"E\"";
        }
        //alert(GetPIString);
        return Flag;
    }



    function GetPFA()
    {
        var Flag=false;
        GetPFAString='';

        if ($("#txtAddressValue").val().length > 0)
        {
            Flag = true;
            GetPFAString += "av="+ "\""+$("#txtAddressValue").val()+"\"";
        }

        if ($("#drpMatchValuePFA").val() > 0 && $("#txtAddressValue").val().length > 0)
        {
            Flag = true;
            GetPFAString += " mv="+ "\""+$("#drpMatchValuePFA").val()+"\"";
        }

        if ($('#rdExactPFA').is(':checked') && Flag)
        {
            Flag = true;
            GetPFAString += " ms="+ "\"E\"";
        }
        else if ($('#rdPartialPFA').is(':checked') && Flag)
        {
            Flag = true;
           GetPFAString += " ms="+ "\"P\"";
        }
        else if ($('#rdFuzzyPFA').is(':checked') && Flag)
        {
            Flag = true;
            GetPFAString += " ms="+ "\"F\"";
        }

        if ($("#txtLocalAddress").val().length > 0)
        {
            Flag = true;
            GetPFAString += " lav="+ "\""+$("#txtLocalAddress").val()+"\"";
        }

        if ($("#drpLocalMatchValue").val() > 0 && $("#txtLocalAddress").val().length > 0)
        {
            Flag = true;
            GetPFAString += " lmv="+ "\""+$("#drpLocalMatchValue").val()+"\"";
        }
        //alert(GetPIString);
        return Flag;
    }

    $( "#ddlAVDM" ).change(function() {
    //alert($("#ddlAVDM").val());
    discoverAvdmFirstNode($("#ddlAVDM").val());
    });


    $( "#chkHttpsPort" ).change(function() {
        if($("#chkHttpsPort").prop('checked')==true)
        {
            OldPort=true;
        }
        else
        {
            OldPort=false;
        }

    });

    function discoverAvdmFirstNode(PortNo)
    {

        $('#txtWadh').val('');
        $('#txtDeviceInfo').val('');
        $('#txtPidOptions').val('');
        $('#txtPidData').val('');

    //alert(PortNo);

    var primaryUrl = "http://"+GetCustomDomName+":";
        url = "";
                 var verb = "RDSERVICE";
                    var err = "";
                    var res;
                    $.support.cors = true;
                    var httpStaus = false;
                    var jsonstr="";
                     var data = new Object();
                     var obj = new Object();

                        $.ajax({
                        type: "RDSERVICE",
                        async: false,
                        crossDomain: true,
                        url: primaryUrl + PortNo,
                        contentType: "text/xml; charset=utf-8",
                        processData: false,
                        cache: false,
                        async:false,
                        crossDomain:true,
                        success: function (data) {
                            httpStaus = true;
                            res = { httpStaus: httpStaus, data: data };
                            //alert(data);

                            //debugger;

                             $("#txtDeviceInfo").val(data);

                            var $doc = $.parseXML(data);

                            //alert($($doc).find('Interface').eq(1).attr('path'));


                            if($($doc).find('Interface').eq(0).attr('path')=="/rd/capture")

                            {
                              MethodCapture=$($doc).find('Interface').eq(0).attr('path');
                            }
                            if($($doc).find('Interface').eq(1).attr('path')=="/rd/capture")

                            {
                              MethodCapture=$($doc).find('Interface').eq(1).attr('path');
                            }

                            if($($doc).find('Interface').eq(0).attr('path')=="/rd/info")

                            {
                              MethodInfo=$($doc).find('Interface').eq(0).attr('path');
                            }
                            if($($doc).find('Interface').eq(1).attr('path')=="/rd/info")

                            {
                              MethodInfo=$($doc).find('Interface').eq(1).attr('path');
                            }

                            

                             alert("RDSERVICE Discover Successfully");
                        },
                        error: function (jqXHR, ajaxOptions, thrownError) {
                        $('#txtDeviceInfo').val("");
                        //alert(thrownError);
                            res = { httpStaus: httpStaus, err: getHttpError(jqXHR) };
                        },
                    });

                    return res;
    }








    async function discoverAvdm() {
    // Set the custom domain name
    let GetCustomDomName = "127.0.0.1";
    if ($("#txtSSLDomName").val().trim().length > 0) {
        GetCustomDomName = $("#txtSSLDomName").val().trim();
    }

    openNav();
    $('#txtWadh, #txtDeviceInfo, #txtPidOptions, #txtPidData').val('');
    $("#ddlAVDM").empty();

    const protocol = window.location.protocol.includes("https") ? "https://" : "http://";
    const primaryUrl = `${protocol}${GetCustomDomName}:`;
    let SuccessFlag = 0;

    for (let i = 11100; i <= 11105; i++) {
        const port = i === 11105 && OldPort ? "8005" : i.toString();
        $("#lblStatus1").text(`Discovering RD service on port: ${port}`);

        try {
            const url = `${primaryUrl}${port}`;
            const response = await fetch(url, { method: "RDSERVICE" });

            if (response.ok) {
                const data = await response.text();
                $("#txtDeviceInfo").val(data);

                const parser = new DOMParser();
                const xmlDoc = parser.parseFromString(data, "text/xml");

                const status = xmlDoc.querySelector("RDService").getAttribute("status");
                const info = xmlDoc.querySelector("RDService").getAttribute("info");

                if (info.includes("Mantra")) {
                    closeNav();

                    const interfaces = xmlDoc.querySelectorAll("Interface");
                    interfaces.forEach((iface) => {
                        const path = iface.getAttribute("path");
                        if (path === "/rd/capture") MethodCapture = path;
                        if (path === "/rd/info") MethodInfo = path;
                    });

                    $("#ddlAVDM").append(
                        `<option value="${port}">(${status} - ${port}) ${info}</option>`
                    );
                    SuccessFlag = 1;
                    break; // Stop loop after success
                }
            }
        } catch (error) {
            console.error(`Error discovering RD service on port ${port}:`, error);
        }
    }

    // if (SuccessFlag === 0) {
    //     alert("Connection failed. Please try again.");
    // } else {
    //     alert("RDService discovered successfully.");
    // }

    $("select#ddlAVDM").prop("selectedIndex", 0);
    closeNav();
}



    function openNav() {
        document.getElementById("myNav").style.width = "100%";
    }

    function closeNav() {
        document.getElementById("myNav").style.width = "0%";
    }

    function deviceInfoAvdm()
    {
        //alert($("#ddlAVDM").val());
     






        url = "";

                
                // $("#lblStatus").text("Discovering RD Service on Port : " + i.toString());
                //Dynamic URL

                    finalUrl = "http://"+GetCustomDomName+":" + $("#ddlAVDM").val();

                    try {
                        var protocol = window.location.href;
                        if (protocol.indexOf("https") >= 0) {
                            finalUrl = "https://"+GetCustomDomName+":" + $("#ddlAVDM").val();
                        }
                    } catch (e)
                    { }

                //
                 var verb = "DEVICEINFO";
                  //alert(finalUrl);

                    var err = "";

                    var res;
                    $.support.cors = true;
                    var httpStaus = false;
                    var jsonstr="";
                    ;
                        $.ajax({

                        type: "DEVICEINFO",
                        async: false,
                        crossDomain: true,
                        url: finalUrl+MethodInfo,
                        contentType: "text/xml; charset=utf-8",
                        processData: false,
                        success: function (data) {
                        //alert(data);
                            httpStaus = true;
                            res = { httpStaus: httpStaus, data: data };

                            $('#txtDeviceInfo').val(data);
                        },
                        error: function (jqXHR, ajaxOptions, thrownError) {
                        alert(thrownError);
                            res = { httpStaus: httpStaus, err: getHttpError(jqXHR) };
                        },
                    });

                    return res;

    }



    function CaptureAvdm() {
var strWadh = "";
var strOtp = "";
Demo();

if ($("#txtWadh").val() != "") {
    strWadh = ' wadh="' + $("#txtWadh").val() + '"';
}
if ($("#txtotp").val() != "") {
    strOtp = ' otp="' + $("#txtotp").val() + '"';
}


var fType = 2; // Ensure fType is explicitly defined if not from #Ftype
var XML = '<?xml version="1.0"?>' +
    '<PidOptions ver="1.0">' +
    '<Opts ' +
        'fCount="' + $("#Fcount").val() + '" ' +
        'fType="' + (fType) + '" ' + // Use fType variable if explicitly set
        'iCount="' + $("#Icount").val() + '" ' +
        'pCount="' + $("#Pcount").val() + '" ' +
        'pgCount="' + $("#pgCount").val() + '" ' +
        strOtp + // Ensure strOtp is a valid string or empty
        'format="' + $("#Dtype").val() + '" ' +
        'pidVer="' + $("#Pidver").val() + '" ' +
        'timeout="' + $("#Timeout").val() + '" ' +
        'pTimeout="' + $("#pTimeout").val() + '" ' +
        strWadh + // Ensure strWadh is a valid string or empty
        'posh="UNKNOWN" ' +
        'env="' + $("#Env").val() + '" />' +
    DemoFinalString + // Ensure DemoFinalString is valid XML-compatible content
    '<CustOpts>' +
        '<Param name="mantrakey" value="' + $("#txtCK").val() + '" />' +
    '</CustOpts>' +
    '</PidOptions>';

var finalUrl = "http://" + GetCustomDomName + ":" + $("#ddlAVDM").val();

try {
    var protocol = window.location.href;
    if (protocol.indexOf("https") >= 0) {
        finalUrl = "https://" + GetCustomDomName + ":" + $("#ddlAVDM").val();
    }
} catch (e) { }

var verb = "CAPTURE";
var httpStaus = false;

$.support.cors = true;

$.ajax({
    type: "CAPTURE",
    async: false,
    crossDomain: true,
    url: finalUrl + MethodCapture,
    data: XML,
    contentType: "text/xml; charset=utf-8",
    processData: false,
    success: function (data) {
        httpStaus = true;

        $('#txtPidData').val(data);
        $('#txtPidOptions').val(XML);

        // Parse the response XML to JSON
        var jsonStr = xmlToJson($.parseXML(data));
        var formattedJson = JSON.stringify(jsonStr, null, 4);

        // Display the JSON response in a textarea
        $('#txtJsonResponse').val(formattedJson);

        // Extract biometric data
        var biometricData = extractBiometricData(jsonStr);

        // Display extracted biometric data in a textarea
        var formattedBiometricData = JSON.stringify(biometricData, null, 4);
        $('#txtBiometricData').val(formattedBiometricData);

        // Display success message
        var message = $($.parseXML(data)).find('Resp').attr('errInfo');
        alert(message);
    },
    error: function (jqXHR, ajaxOptions, thrownError) {
        alert(thrownError);
    },
});
}

// Utility function to extract biometric data from JSON
function extractBiometricData(response) {
const biometricData = {
    dc: response?.PidData?.DeviceInfo?.["@attributes"]?.dc || "",
    ci: response?.PidData?.Skey?.["@attributes"]?.ci || "",
    hmac: response?.PidData?.Hmac?.["#text"] || "",
    dpId: response?.PidData?.DeviceInfo?.["@attributes"]?.dpId || "",
    mc: response?.PidData?.DeviceInfo?.["@attributes"]?.mc || "",
    pidDataType: response?.PidData?.Data?.["@attributes"]?.type || "",
    sessionKey: response?.PidData?.Skey?.["#text"] || "",
    mi: response?.PidData?.DeviceInfo?.["@attributes"]?.mi || "",
    rdsId: response?.PidData?.DeviceInfo?.["@attributes"]?.rdsId || "",
    errCode: response?.PidData?.Resp?.["@attributes"]?.errCode || "0",
    errInfo: response?.PidData?.Resp?.["@attributes"]?.errInfo || "",
    fCount: response?.PidData?.Resp?.["@attributes"]?.fCount || "1",
     fType: response?.PidData?.Resp?.["@attributes"]?.fType || "2",
    // fType:  "2",
    iCount: response?.PidData?.Resp?.["@attributes"]?.iCount || "1",
    iType: response?.PidData?.Resp?.["@attributes"]?.iType || "",
    pCount: response?.PidData?.Resp?.["@attributes"]?.pCount || "1",
    pType: response?.PidData?.Resp?.["@attributes"]?.pType || "",
    srno: response?.PidData?.DeviceInfo?.additional_info?.Param?.find(param => param["@attributes"]?.name === "srno")?.["@attributes"]?.value || "",
    sysid: response?.PidData?.DeviceInfo?.additional_info?.Param?.find(param => param["@attributes"]?.name === "sysid")?.["@attributes"]?.value || "",
    ts: response?.PidData?.DeviceInfo?.additional_info?.Param?.find(param => param["@attributes"]?.name === "ts")?.["@attributes"]?.value || "",
    pidData: response?.PidData?.Data?.["#text"] || "",
    qScore: response?.PidData?.Resp?.["@attributes"]?.qScore || "",
    nmPoints: response?.PidData?.Resp?.["@attributes"]?.nmPoints || "",
    rdsVer: response?.PidData?.DeviceInfo?.["@attributes"]?.rdsVer || ""
};

return biometricData;
}

// Utility function to convert XML to JSON
function xmlToJson(xml) {
var obj = {};
if (xml.nodeType === 1) { // element
    if (xml.attributes.length > 0) {
        obj["@attributes"] = {};
        for (var j = 0; j < xml.attributes.length; j++) {
            var attribute = xml.attributes.item(j);
            obj["@attributes"][attribute.nodeName] = attribute.nodeValue;
        }
    }
} else if (xml.nodeType === 3) { // text
    obj = xml.nodeValue;
}

if (xml.hasChildNodes()) {
    for (var i = 0; i < xml.childNodes.length; i++) {
        var item = xml.childNodes.item(i);
        var nodeName = item.nodeName;
        if (typeof (obj[nodeName]) === "undefined") {
            obj[nodeName] = xmlToJson(item);
        } else {
            if (typeof (obj[nodeName].push) === "undefined") {
                var old = obj[nodeName];
                obj[nodeName] = [];
                obj[nodeName].push(old);
            }
            obj[nodeName].push(xmlToJson(item));
        }
    }
}
return obj;
}


    function getHttpError(jqXHR) {
        var err = "Unhandled Exception";
        if (jqXHR.status === 0) {
            err = 'Service Unavailable';
        } else if (jqXHR.status == 404) {
            err = 'Requested page not found';
        } else if (jqXHR.status == 500) {
            err = 'Internal Server Error';
        } else if (thrownError === 'parsererror') {
            err = 'Requested JSON parse failed';
        } else if (thrownError === 'timeout') {
            err = 'Time out error';
        } else if (thrownError === 'abort') {
            err = 'Ajax request aborted';
        } else {
            err = 'Unhandled Error';
        }
        return err;
    }

</script>


</section>  
</div>
<script type="text/javascript" src="jquery-1.12.4.js"></script>

@endsection
