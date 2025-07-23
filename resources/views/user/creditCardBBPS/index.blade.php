
@extends('user/include.layout')
@section('content')


<main class="p-4">
<div class="max-w-5xl mx-auto   rounded-lg overflow-hidden">




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/font-awesome@6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        /* Prevent horizontal and vertical overflow on small screens */
        

        /* Optional: If you need to control the body overflow more finely on larger screens */
        
    </style>
</head>
<body>
    <div class="container-fluid mt-4 flex flex-col  lg:flex-row justify-between space-y-4 lg:space-y-0 lg:space-x-4 px-4 lg:px-0">
        <div class="flex space-x-4 flex-col lg:flex-row justify-center align-center">
            <!-- Mobile Recharge Form -->
            <div class="w-full lg:w-[45%] mb-4 flex justify-center align-center ">
                <div class="bg-white shadow-lg rounded-lg w-full">
                    <div class="bg-indigo-100 text-black p-4 rounded-t-lg" style="background: linear-gradient(to right, #0a22aa, #b62512); color: white; border: none;">
                        <strong style="color: white;">Credit Card Bill Pay</strong>
                    </div>
                    <div class="p-6">
                        <form action="{{route('creditCardBillFetch')}}" method="post">
                            @csrf
                           <div class="mb-4">
                            <label for="customer-id" class="block text-sm font-medium">Registered Mobile Number *</label>
                            <input type="text" name="mobile"
                                class="form-input mt-1 w-full p-1.5 border border-gray-300"
                                id="customer-id"
                                placeholder="Registered Mobile Number"
                                maxlength="10"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)">
                        </div>

                       <div class="mb-4">
                            <label for="cardNumber" class="block text-sm font-medium">Last 4 digits of Credit Card Number *</label>
                            <input type="text" name="cardNumber"
                                class="form-input mt-1 w-full p-1.5 border border-gray-300"
                                id="cardNumber"
                                placeholder="Last 4 digits of Credit Card Number"
                                maxlength="4"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 4)">
                        </div>



                            {{-- <div class="mb-4">
                                <label for="mobile-number" class="block text-sm font-medium "> Customer Mobile *</label>
                                <input type="text" name="mobile" class="form-input mt-1 w-full p-1.5" id="mobile-number" placeholder="Enter Mobile Number">
                            </div> --}}
     <div class="relative w-full mb-4">
                            <label for="operator-search" class="block text-sm font-medium">Select Bank *</label>
                            
                            <input type="text" id="operator-search" class="form-control w-full" placeholder="Type to search..." oninput="filterDropdown()" onclick="toggleDropdown()" autocomplete="off" />

                            <div id="dropdown" class="absolute z-10 mt-1 w-full bg-white border border-gray-300 rounded-md shadow-md max-h-60 overflow-y-auto hidden">
                                @foreach($billers as $biller)
                                    <div class="dropdown-item px-4 py-2 hover:bg-gray-100 cursor-pointer" 
                                        onclick="selectBiller('{{ $biller['billerId'] }}', '{{ $biller['billerName'] }}')"
                                        data-name="{{ $biller['billerName'] }}">
                                        {{ $biller['billerName'] }}
                                    </div>
                                @endforeach
                            </div>

    <input type="hidden" name="operator" id="operator-hidden">
</div>
<script>
    function toggleDropdown() {
    document.getElementById('dropdown').classList.toggle('hidden');
}

function filterDropdown() {
    const input = document.getElementById('operator-search').value.toLowerCase();
    const items = document.querySelectorAll('#dropdown .dropdown-item');
    
    items.forEach(item => {
        const name = item.getAttribute('data-name').toLowerCase();
        item.style.display = name.includes(input) ? 'block' : 'none';
    });
}

function selectBiller(id, name) {
    document.getElementById('operator-search').value = name;
    document.getElementById('operator-hidden').value = id;
    document.getElementById('dropdown').classList.add('hidden');
}

</script>


                            <input type="text" hidden id="latitude" name="latitude" class="form-control" readonly placeholder="Fetching latitude...">
                            <input type="text" hidden id="longitude" name="longitude" class="form-control" readonly placeholder="Fetching longitude...">
                            <input type="text" hidden id="geoCode" name="geoCode" class="form-control" readonly>
                            
                            <script>
                                document.addEventListener("DOMContentLoaded", function () {
                                    if (navigator.geolocation) {
                                        navigator.geolocation.getCurrentPosition(function (position) {
                                            let lat = position.coords.latitude.toFixed(4); // Limit to 4 decimal places
                                            let lon = position.coords.longitude.toFixed(4); // Limit to 4 decimal places
                                            document.getElementById("latitude").value = lat;
                                            document.getElementById("longitude").value = lon;
                                            document.getElementById("geoCode").value = lat + "," + lon;
                                        });
                                    } else {
                                        alert("Geolocation is not supported by this browser.");
                                    }
                                });
                                </script>
                            
                            {{-- <div class="mb-4">
                                <label for="recharge-amount" class="block text-sm font-medium">Recharge Amount *</label>
                                <input type="text" class="form-input mt-1 w-full p-1.5" required name="rechargeAmount" id="recharge-amount" placeholder="Enter Recharge Amount">
                                <small class="text-blue-600">
                                    <a href="#" id="browse-plans-link">Browse Plans</a>
                                </small>
                            </div> --}}
                            <button type="submit" class="btn btn-success  w-full bg-indigo-100 py-2 px-4 rounded-lg" style="background: linear-gradient(to right, #0a22aa, #b62512); color: white; border: none;">Submit</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Browse Plans -->
            <div class="w-full lg:w-[45%] mb-4 flex justify-center align-center ">
                <div class="bg-white shadow-lg rounded-lg">
                    <div class="bg-indigo-100 text-black p-4 rounded-t-lg" style="background: linear-gradient(to right, #0a22aa, #b62512); color: white; border: none;">
                        <strong class="text-white">Fetch Bill</strong>
                    </div>
                    <div class="p-6">
                        <p class="text-sm text-gray-500">
                            Any discrepancies in the bill amount or due date should be resolved with the respective mobile service provider</p>
                            @if (session('data'))
                            @php $billData = session('data'); @endphp
                        
                            <p><strong>Consumer Name</strong>:       {{ $billData['customerName'] ?? 'N/A' }}</p>
                            <p><strong>Bill Number</strong>:        {{ $billData['billNumber'] ?? 'N/A' }}</p>
                            <p><strong>Bill Date</strong>:      {{ $billData['billDate'] ?? 'N/A' }}</p>
                            <p><strong>Bill Due Date</strong>:      {{ $billData['billDueDate'] ?? 'N/A' }}</p>
                        
                            <form action="{{route('creditCardRechargePay')}}" method="post">
                                @csrf
                                <input type="text" hidden name="enquiryReferenceId" value="{{ $billData['enquiryReferenceId'] ?? '' }}">
                                <input type="text" hidden name="billerId" value="{{ $billData['billerId'] ?? '' }}">
                                <input type="text"  name="cardNo" value="{{ $billData['cardNo'] ?? '' }}">
                                <input type="text" hidden name="mobile" value="{{ $billData['mobile'] ?? '' }}">
                                <input type="text" hidden name="geoCode" value="{{ $billData['geoCode'] ?? '' }}">
                            
                            <div class="mb-4">
                                <label for="billAmount" class="block text-sm font-medium ">Bill Amount*</label>
                                <input type="text" name="billAmount" value="{{ $billData['billAmount'] ?? '' }}" class="form-input mt-1 w-full p-1.5" id="billAmount" placeholder="Enter Consumer Number">
                            </div>

                             <div class="mb-4">
                                <label for="mobile-number" class="block text-sm font-medium">M Pin *</label>
                                <input type="text" name="mpin"
                                    class="form-input mt-1 w-full p-1.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    id="mobile-number" placeholder="Enter M Pin" maxlength="4" required
                                    inputmode="numeric" pattern="[0-9]{4}"
                                    oninput="this.value = this.value.replace(/\D/g, '').slice(0,4)" />
                            </div>
                            <button type="submit" class="btn btn-success  w-full text-primary bg-indigo-100 py-2 px-4 rounded-lg">Pay</button>
                            </form>
                        @endif
                       
                        <div id="plans-container"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content text-center">
                <div class="modal-body">
                    @if(session('success'))
                        <img src="https://cdn-icons-png.flaticon.com/512/5610/5610944.png" alt="Success" width="80" class="d-block mx-auto">
                        <h5 class="mt-2 text-dark">{{ session('success') }}</h5>
    
                    @elseif(session('error'))
                        <img src="https://media.giphy.com/media/TqiwHbFBaZ4ti/giphy.gif" alt="Failed" width="80" class="d-block mx-auto">
                        <h5 class="mt-2 text-danger">{{ session('error') }}</h5>
                    @endif
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal" style="background: linear-gradient(to right, #0a22aa, #b62512); color: white; border: none;">Close</button>
                </div>
            </div>
        </div>
    </div>
    
    
    
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            @if(session('success') || session('error'))
                var modal = new bootstrap.Modal(document.getElementById('statusModal'));
                modal.show();
            @endif
        });
    
        (function () {
            'use strict';
            const forms = document.querySelectorAll('.needs-validation');
            Array.from(forms).forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        })();
    </script>
    <script>
        document.getElementById('browse-plans-link').addEventListener('click', async function(e) {
            e.preventDefault();
        
            // Get form values
            let operator = document.getElementById('operator').value;
            let circle = document.getElementById('circle').value;
        
            if (!operator || !circle) {
                alert("Please select an operator and circle.");
                return;
            }
        
            // Get outlet from session (Replace with actual session retrieval)
            let outLet = "{{ session('outlet') ?? '494085' }}"; // Default value if session is not available
        
            // Auto-detect latitude and longitude
            let latitude = '';
            let longitude = '';
        
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        latitude = position.coords.latitude;
                        longitude = position.coords.longitude;
                        fetchPlans(operator, circle, outLet, latitude, longitude);
                    },
                    (error) => {
                        console.error("Geolocation error:", error);
                        alert("Could not detect location. Please enable location services.");
                    }
                );
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        });
        
        // Function to fetch and display plans
        async function fetchPlans(subProductCode, telecomCircle, outLet, latitude, longitude) {
            const externalRef = "ext-" + Math.random().toString(36).substr(2, 10); // Auto-generate reference ID
        
            // API Payload
            let requestData = {
                outLet,
                subProductCode,
                telecomCircle,
                latitude,
                longitude,
                externalRef
            };
        console.log(requestData);
            try {
                let response = await fetch('https://codegraphi.com/B2B/api/v1/bbps/getRechargePlans', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(requestData)
                });
        
                let data = await response.json();
        console.log("data ",data.data.plans);
        
        displayPlans(data.data.plans);
               
            } catch (error) {
                console.error("Error fetching plans:", error);
                alert("Error fetching plans. Check console for details.");
            }
        }
        
        // Function to display plans
        function displayPlans(plans) {
            const container = document.getElementById('plans-container');
            container.innerHTML = ''; // Clear existing content
        
            if (!plans.length) {
                container.innerHTML = "<p class='text-red-500'>No plans available.</p>";
                return;
            }
        
            (plans.length && plans.forEach(plan => {
                const planCard = `
                    <div class="flex justify-between items-center mb-3">
                        <div>
                            <h6 class="font-semibold">${plan.telecomCircle} - ${plan.planCategory}</h6>
                            <p class="text-sm text-gray-500">${plan.planDescription}</p>
                        </div>
                        <button class="btn btn-primary text-white bg-blue-600 py-1 px-3 rounded-md">Rs. ${plan.planAmount}</button>
                    </div>
                `;
                container.innerHTML += planCard;
            }));
        }
        </script>
            <!-- Blur Overlay -->
<div id="loadingOverlay" class="fixed top-0 left-0 w-full h-full bg-white bg-opacity-50 backdrop-blur-sm z-50 hidden flex items-center justify-center">
    <div class="text-center">
        <svg class="animate-spin h-10 w-10 text-indigo-600 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
        </svg>
        <p class="text-sm mt-2 text-indigo-700 font-medium">Processing, please wait...</p>
    </div>
</div>
<script>
document.querySelector('form').addEventListener('submit', function (e) {
    // Show loading overlay
    document.getElementById('loadingOverlay').classList.remove('hidden');

    // Disable all buttons
    const buttons = document.querySelectorAll('button');
    buttons.forEach(btn => {
        btn.disabled = true;
        btn.classList.add('opacity-50', 'cursor-not-allowed');
    });
});
</script>
</body>
</html>

</div>
<main>
    
@endsection
