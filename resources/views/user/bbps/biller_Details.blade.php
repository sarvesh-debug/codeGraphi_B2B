@extends('user/include.layout') 
@section('content')
@include('user.bbps.navbar')

<div class="container my-5">
    <div class="card shadow border-0">
        <div class="card-body">
            @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
            <h2 class="text-center text-primary mb-4">
                {{ $response['data']['billerInfo']['name'] ?? 'Biller Information' }}
            </h2>

            @if (!empty($response['data']))
            @if($response['data']['category']['name'] == "Mobile (Prepaid)")
            <form id="rechargeForm">
                @csrf
                <input type="text" name="subProductCode" hidden value="{{ $response['data']['billerId'] }}">
                <div class="form-group mb-3">
                    <label for="bene_id" class="form-label">Select Circle</label>
                    <select id="circleSelect" name="telecomCircle" class="form-select">
                        <option value="" selected disabled>-- Select Circle --</option>
                        <option value="AS">ASSAM</option>
                        <option value="BR">BIHAR & JHARKHAND</option>
                        <option value="KO">KOLKATA</option>
                        <option value="OR">ODISHA</option>
                        <option value="NE">NORTH EAST</option>
                        <option value="WB">WEST BENGAL</option>
                        <option value="MH">MAHARASHTRA & GOA</option>
                        <option value="MP">MP & CHHATTISGARH</option>
                        <option value="MU">MUMBAI</option>
                        <option value="GJ">GUJARAT</option>
                        <option value="PB">PUNJAB</option>
                        <option value="RJ">RAJASTHAN</option>
                        <option value="UE">UP (EAST)</option>
                        <option value="UW">UP (WEST) & UTTARAKHAND</option>
                        <option value="HR">HARYANA</option>
                        <option value="HP">HIMACHAL PRADESH</option>
                        <option value="JK">JAMMU & KASHMIR</option>
                        <option value="DL">DELHI - NCR</option>
                        <option value="AP">AP & TELANGANA</option>
                        <option value="CH">CHENNAI</option>
                        <option value="KL">KERALA</option>
                        <option value="KA">KARNATAKA</option>
                        <option value="TN">TAMIL NADU</option>
                        <option value="-1">ALL INDIA</option>
                        <option value="UK">UTTARAKHAND</option>
                        <option value="N2">NE2</option>
                    </select>
                </div>
                
                {{-- <div class="form-group mb-3">
                    <label for="selectedCircle" class="form-label">Selected Circle</label>
                    <input type="text" id="selectedCircle" name="selectedCircle" class="form-control" readonly>
                </div> --}}
                
                <script>
                    document.getElementById('circleSelect').addEventListener('change', function () {
                        const selectedValue = this.value;
                        const selectedText = this.options[this.selectedIndex].text;
                
                        // Display the selected circle in the input box
                        document.getElementById('selectedCircle').value = '' + selectedValue + '';
                    });
                </script>
                
                <input type="text" hidden id="latitude" name="latitude" class="form-control" readonly placeholder="Fetching latitude...">
                <input type="text" hidden id="longitude" name="longitude" class="form-control" readonly placeholder="Fetching longitude...">
            </form>
        
            <div id="responseContainer" class="p-3 bg-light overflow-auto" style="height: 100px;"></div>
        
            {{-- <div class="mt-4">
                <label for="remarks" class="form-label">Amount</label>
                <input type="text" class="form-control" id="selectedPlanAmount" name="selectedPlanAmount" maxlength="50"
                       placeholder="Selected Plan Amount">
            </div> --}}
        
            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    autoFetchPlans();
                });
        
                document.getElementById('circleSelect').addEventListener('change', function () {
                    autoFetchPlans();
                });
        
                function autoFetchPlans() {
                    let form = document.getElementById('rechargeForm');
                    let formData = new FormData(form);
        
                    fetch("{{ route('bbps.recharge') }}", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value,
                            "Accept": "application/json",
                        },
                        body: formData,
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.statuscode === "TXN" && data.data && data.data.plans) {
                                let plans = data.data.plans;
                                let responseContainer = document.getElementById('responseContainer');
                                responseContainer.innerHTML = ""; // Clear previous content
        
                                plans.forEach(plan => {
                                    let card = document.createElement("div");
                                    card.className = "card";
                                    card.style = `
                                        margin: 10px;
                                        padding: 15px;
                                        border: 1px solid #ddd;
                                        border-radius: 8px;
                                        background: #f9f9f9;
                                        cursor: pointer;
                                    `;
        
                                    card.innerHTML = `
                                        <h4 style="color: #4CAF50; margin-bottom: 10px;">₹${plan.planAmount}</h4>
                                        <p style="margin: 0; font-size: 14px; color: #555;">${plan.planDescription}</p>
                                    `;
        
                                    // Add click event to store planAmount in a variable
                                    card.addEventListener("click", () => {
                                        document.getElementById('selectedPlanAmount').value = plan.planAmount;
                                        console.log("Selected Plan Amount:", plan.planAmount);
                                    });
        
                                    responseContainer.appendChild(card);
                                });
                            } else {
                                document.getElementById('responseContainer').innerHTML = `
                                    <div style="color: red; margin-top: 20px;">Failed to fetch plans. Please try again later.</div>
                                `;
                            }
                        })
                        .catch(error => {
                            console.error("Error:", error);
                            document.getElementById('responseContainer').innerHTML = `
                                <div style="color: red; margin-top: 20px;">An error occurred. Please try again later.</div>
                            `;
                        });
                }
            </script>
        @endif
        
           
                <form method="POST" action="{{route('bbps.getAllData')}}" id="rechargeForm" class="needs-validation" novalidate>
                    @csrf
                    <!-- Dynamic Form Fields -->
                    <input type="text"hidden name="billerId" value="{{$response['data']['billerId']}}">
                    <input type="text"hidden name="key" value="{{$response['data']['category']['key']}}">
                    <input type="text"hidden name="initChannel" value="AGT">
                    <input type="text"hidden name="supportValidation" value="{{$response['data']['supportValidation']}}" id="">
                    <input type="text"hidden name="fetchRequirement" value="{{$response['data']['fetchRequirement']}}" id="">
                    <div class="row g-4">
                        @foreach ($response['data']['parameters'] ?? [] as $param)
                            <div class="col-md-6">
                                <label for="{{ $param['name'] }}" class="form-label">
                                    {{ $param['desc'] }}
                                    <span class="text-danger">*</span>
                                    <i class="bi bi-info-circle" data-bs-toggle="tooltip" 
                                       data-bs-placement="top" 
                                       title="Please enter valid {{ $param['desc'] }}"></i>
                                </label>
                                <input type="text" class="form-control" id="{{ $param['name'] }}" 
                                    name="{{ $param['name'] }}" required 
                                    pattern="{{ $param['regex'] }}" 
                                    maxlength="{{ $param['maxLength'] }}" 
                                    placeholder="Enter {{ $param['desc'] }}">
                                <div class="invalid-feedback">
                                    Please provide a valid {{ $param['desc'] }}.
                                </div>
                            </div>
                        @endforeach
                    </div>
                        @if ($response['data']['fetchRequirement'] && $response['data']['supportValidation']==='NOT_SUPPORTED')

                         <!-- Remarks -->
                  
                        <input type="text" class="form-control" hidden  id="paymentMode" value="CashPayment" name="paymentMode" maxlength="50" 
                            placeholder="Enter Remarks (if any)">
                   
                          
                    <div class="mt-4">
                        <label for="remarks" class="form-label">Amount</label>
                        <input type="text" class="form-control"  id="selectedPlanAmount" name="selectedPlanAmount" maxlength="50" 
                            placeholder="Enter Amount">
                    </div>
{{--                            
                    <div class="mt-4">
                        <label for="remarks" class="form-label">Remark</label>
                        <input type="text" class="form-control"  id="remark" name="remark" maxlength="50" 
                            placeholder="remark">
                    </div> --}}
                        @endif
                   
                   
                    <!-- Additional Fixed Parameters -->
                   
                            <input type="text" class="form-control" id="terminalId" hidden name="terminalId" required 
                                pattern="^[0-9]{1,10}$" maxlength="10" 
                               
                            <input type="text" class="form-control" hidden value="{{session('mobile')}}" readonly id="agentMobile" name="agentMobile" required 
                                pattern="^[5-9][0-9]{9}$" maxlength="10" 
                                placeholder="Enter Mobile Number">
                         
                            <input type="text" hidden class="form-control" id="geoCode" name="geoCode" required 
                                pattern="^[0-9]{1,2}(\.[0-9]{4}),[0-9]{1,2}(\.[0-9]{4})$" maxlength="15" 
                                placeholder="Auto-detected GeoCode">
                 
                   

                    <!-- Submit Button -->
                     <div class="form-group mb-3">
                    <label for="selectedCircle" class="form-label">Selected Circle</label>
                    <input type="text" id="selectedCircle" name="telecomCircle1" class="form-control" readonly>
                </div>
                    <div class="mt-4">
                        <label for="remarks" class="form-label">Remark</label>
                        <input type="text" class="form-control"  id="remark" name="remark" maxlength="50" 
                            placeholder="remark">
                    </div>
                        
                    @if ($response['data']['fetchRequirement'] && $response['data']['supportValidation']==='NOT_SUPPORTED')
                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-success btn-lg px-5 shadow">
                            <i class="bi bi-lightning-fill"></i> Pay
                        </button>
                    </div>
                    @else
                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-primary btn-lg px-5 shadow">
                            <i class="bi bi-lightning-fill"></i> Fetch
                        </button>
                    </div>   
                    @endif
                  
                </form>
               
            @else
                <div class="alert alert-warning text-center mt-4">
                    No data available to display.
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    // Fetch user's location and populate the GeoCode field
    document.addEventListener('DOMContentLoaded', () => {
        const geoCodeField = document.getElementById('geoCode');

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const lat = position.coords.latitude.toFixed(4);
                    const lon = position.coords.longitude.toFixed(4);
                    geoCodeField.value = `${lat},${lon}`;
                },
                (error) => {
                    console.error('Error fetching geolocation:', error.message);
                    geoCodeField.placeholder = 'Unable to fetch GeoCode';
                }
            );
        } else {
            console.warn('Geolocation API not supported in this browser.');
            geoCodeField.placeholder = 'Geolocation not supported';
        }
    });

    document.addEventListener('DOMContentLoaded', function () {
        // Check if Geolocation is available
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function (position) {
                    // Success callback
                    document.getElementById('latitude').value = position.coords.latitude;
                    document.getElementById('longitude').value = position.coords.longitude;
                },
                function (error) {
                    // Error callback
                    console.error('Error fetching location:', error.message);
                    alert('Unable to fetch your location. Please enable location services.');
                }
            );
        } else {
            alert('Geolocation is not supported by your browser.');
        }
    });
</script>
@endsection











{{-- @extends('user/include.layout')

@section('content')
@include('user.bbps.navbar')

<div class="container my-5">
    <h2 class="text-center mb-4">{{ $response['data']['billerInfo']['name'] ?? '-' }}</h2>

    @if (!empty($response['data']))
        <form method="POST" id="rechargeForm" class="needs-validation" novalidate>
            @csrf

            {{-- <!-- Biller Information Section -->
            <h4>Biller Information</h4>
            <div class="card mb-3">
                <div class="card-header bg-primary text-white">
                    Biller Info
                </div>
                <div class="card-body">
                    <p><strong>Name:</strong> {{ $response['data']['billerInfo']['name'] ?? '-' }}</p>
                    <p><strong>Description:</strong> {{ $response['data']['billerInfo']['description'] ?? '-' }}</p>
                    <p><strong>Ownership:</strong> {{ $response['data']['billerInfo']['ownership'] ?? '-' }}</p>
                </div>
            </div>

            <!-- Category Information Section -->
            <h4>Category Information</h4>
            <div class="card mb-3">
                <div class="card-header bg-secondary text-white">
                    Category Info
                </div>
                <div class="card-body">
                    <p><strong>Category Key:</strong> {{ $response['data']['category']['key'] ?? '-' }}</p>
                    <p><strong>Category Name:</strong> {{ $response['data']['category']['name'] ?? '-' }}</p>
                </div>
            </div>

            <!-- Payment Modes Section -->
            <h4 class="mt-4">Payment Modes</h4>
            <div class="row">
                @foreach ($response['data']['paymentModes'] ?? [] as $mode)
                    <div class="col-md-4">
                        <div class="card mb-3 shadow-sm">
                            <div class="card-header bg-success text-white">
                                {{ $mode['desc'] }}
                            </div>
                            <div class="card-body">
                                <p><strong>Name:</strong> {{ $mode['name'] }}</p>
                                <ul>
                                    @foreach ($mode['paymentInfo'] ?? [] as $info)
                                        <li>
                                            <strong>{{ $info['desc'] }}</strong> 
                                            (Min: {{ $info['minLength'] }}, Max: {{ $info['maxLength'] }})
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div> --}}

            <!-- Form Inputs for Required Parameters -->
            {{-- <h4 class="mt-4">{{ $response['data']['billerInfo']['name'] ?? '-' }}</h4>
            @foreach ($response['data']['parameters'] ?? [] as $param)
                <div class="mb-3">
                    <label for="{{ $param['name'] }}" class="form-label">{{ $param['desc'] }}</label>
                    <input type="text" class="form-control" id="{{ $param['name'] }}" name="{{ $param['name'] }}"
                        required pattern="{{ $param['regex'] }}" maxlength="{{ $param['maxLength'] }}" 
                        placeholder="Enter {{ $param['desc'] }}">
                </div>
            @endforeach

            <!-- Terminal ID, Agent Mobile, and GeoCode -->
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="terminalId" class="form-label">Terminal ID</label>
                        <input type="text" class="form-control" id="terminalId" name="terminalId" required 
                            pattern="^[0-9]{1,10}$" maxlength="10" placeholder="Enter Terminal ID">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="agentMobile" class="form-label">Agent Mobile</label>
                        <input type="text" class="form-control" id="agentMobile" name="agentMobile" required 
                            pattern="^[5-9][0-9]{9}$" maxlength="10" placeholder="Enter Agent Mobile Number">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="geoCode" class="form-label">GeoCode (Latitude, Longitude)</label>
                        <input type="text" class="form-control" id="geoCode" name="geoCode" required 
                            pattern="^[0-9]{1,2}(\.[0-9]{4}),[0-9]{1,2}(\.[0-9]{4})$" maxlength="15" 
                            placeholder="Enter GeoCode">
                    </div>
                </div>
            </div>

            <!-- Remarks -->
            <div class="mb-3">
                <label for="remarks" class="form-label">Remarks (Optional for Cash payment)</label>
                <input type="text" class="form-control" id="remarks" name="remarks" maxlength="50" 
                    placeholder="Enter Remarks">
            </div>

            <!-- Submit Button -->
            <div class="mb-3 text-center">
                <button type="submit" class="btn btn-primary btn-lg">Recharge</button>
            </div>
        </form>
    @else
        <div class="alert alert-warning text-center">
            No data available to display.
        </div>
    @endif
</div>
@endsection --}} --}}


{{-- @extends('user.include.layout')

@section('content')
@include('user.bbps.navbar')

<div class="container mt-5">
    <h2 class="mb-4 text-center">Recharge Form</h2>
    <form method="POST" action="" id="rechargeForm">
        @csrf
        <!-- Mobile Number -->
        <div class="mb-3">
            <label for="mobileNumber" class="form-label">Mobile Number</label>
            <input type="text" class="form-control" id="mobileNumber" name="mobileNumber" required 
                pattern="^[5-9][0-9]{9}$" title="Mobile number must start with 5-9 and be 10 digits" 
                maxlength="10" placeholder="Enter Mobile Number">
        </div>

        <!-- Terminal ID -->
        <div class="mb-3">
            <label for="terminalId" class="form-label">Terminal ID</label>
            <input type="text" class="form-control" id="terminalId" name="terminalId" required 
                pattern="^[0-9]{1,10}$" title="Terminal ID should be a number between 1 to 10 digits" 
                maxlength="10" placeholder="Enter Terminal ID">
        </div>

        <!-- Agent Mobile -->
        <div class="mb-3">
            <label for="agentMobile" class="form-label">Agent Mobile</label>
            <input type="text" class="form-control" id="agentMobile" name="agentMobile" required 
                pattern="^[5-9][0-9]{9}$" title="Agent mobile number must start with 5-9 and be 10 digits" 
                maxlength="10" placeholder="Enter Agent Mobile Number">
        </div>

        <!-- GeoCode -->
        <div class="mb-3">
            <label for="geoCode" class="form-label">GeoCode (Latitude, Longitude)</label>
            <input type="text" class="form-control" id="geoCode" name="geoCode" required 
                pattern="^[0-9]{1,2}(\.[0-9]{4}),[0-9]{1,2}(\.[0-9]{4})$" title="Latitude and Longitude (e.g. 12.3456,78.9101)" 
                maxlength="15" placeholder="Enter GeoCode">
        </div>

        <!-- Postal Code -->
        <div class="mb-3">
            <label for="postalCode" class="form-label">Postal Code</label>
            <input type="text" class="form-control" id="postalCode" name="postalCode" required 
                pattern="^[1-9][0-9]{5}$" title="Postal code should be 6 digits" maxlength="6" 
                placeholder="Enter Postal Code">
        </div>

        <!-- Remarks (Optional for Cash payment) -->
        <div class="mb-3">
            <label for="remarks" class="form-label">Remarks</label>
            <input type="text" class="form-control" id="remarks" name="remarks" 
                pattern="^[A-Za-z0-9- .]{1,50}$" title="Remarks (max 50 characters)">
        </div>

        <!-- Submit Button -->
        <div class="mb-3 text-center">
            <button type="submit" class="btn btn-primary">Recharge</button>
        </div>
    </form>
</div>

@endsection

{{-- @extends('user/include.layout')
@section('content')
@include('user.bbps.navbar')
<div class="container my-5">
    <h2 class="text-center mb-4">Biller Details</h2>
    
    @if (!empty($response['data']))
        <div class="row">
            <!-- Display Biller Information -->
            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-header bg-primary text-white">
                        Biller Info
                    </div>
                    <div class="card-body">
                        <p><strong>Name:</strong> {{ $response['data']['billerInfo']['name'] ?? '-' }}</p>
                        <p><strong>Description:</strong> {{ $response['data']['billerInfo']['description'] ?? '-' }}</p>
                        <p><strong>Ownership:</strong> {{ $response['data']['billerInfo']['ownership'] ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- Display Category Information -->
            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-header bg-secondary text-white">
                        Category Info
                    </div>
                    <div class="card-body">
                        <p><strong>Category Key:</strong> {{ $response['data']['category']['key'] ?? '-' }}</p>
                        <p><strong>Category Name:</strong> {{ $response['data']['category']['name'] ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Display Payment Modes -->
        <h4 class="mt-4">Payment Modes</h4>
        <div class="row">
            @foreach ($response['data']['paymentModes'] ?? [] as $mode)
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-header bg-success text-white">
                            {{ $mode['desc'] }}
                        </div>
                        <div class="card-body">
                            <p><strong>Name:</strong> {{ $mode['name'] }}</p>
                            <ul>
                                @foreach ($mode['paymentInfo'] ?? [] as $info)
                                    <li>
                                        <strong>{{ $info['desc'] }}</strong> (Min: {{ $info['minLength'] }}, Max: {{ $info['maxLength'] }})
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-warning text-center">
            No data available to display.
        </div>
    @endif
</div>
@endsection --}} --}}
