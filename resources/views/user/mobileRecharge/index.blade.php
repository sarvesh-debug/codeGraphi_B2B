
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
                        <strong style="color: white">Mobile Recharge</strong>
                    </div>
                    <div class="p-6">
                        <form action="{{route('mobileRechargePay')}}" method="post">
                            @csrf

                            <div class="mb-4">
                                <label for="mobile-number" class="block text-sm font-medium">Mobile Number *</label>
                                <input type="text" name="mobile"
                                    class="form-input mt-1 w-full p-1.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    id="mobile-number" placeholder="Enter Mobile Number" maxlength="10" required
                                    inputmode="numeric" pattern="[0-9]{10}"
                                    oninput="this.value = this.value.replace(/\D/g, '').slice(0,10)" />
                            </div>


                            

                            <div class="mb-4">
                                <label for="operator" class="block text-sm font-medium">Operator List *</label>
                                <select class="form-select mt-1 w-full" id="operator" name="operator">
                                    <option value="">Select Biller</option>
                                    <option value="ATP">Airtel</option>
                                    <option value="BGP">BSNL</option>
                                    <option value="BSNL00000NATHL">BSNL (BBPS)</option>
                                    <option value="IDP" disabled>Idea (OLD)</option>
                                    <option value="MTNL00000NAT1U">MTNL</option>
                                    <option value="MMP" disabled>MTNL (OLD)</option>
                                    <option value="RJP">Reliance Jio</option>
                                    <option value="VFP">Vi</option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <label for="circle" class="block text-sm font-medium">Circle *</label>
                                <select class="form-select mt-1 w-full" id="circle" name="circle">
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
                            
                            <div class="mb-4">
                                <label for="recharge-amount" class="block text-sm font-medium">Recharge Amount *</label>
                                <input type="text"
                                    class="form-input mt-1 w-full p-1.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    required name="rechargeAmount" id="recharge-amount" placeholder="Enter Recharge Amount"
                                    maxlength="10" inputmode="numeric" pattern="[0-9]{1,10}"
                                    oninput="this.value = this.value.replace(/\D/g, '').slice(0,10)" />
                                <small class="text-blue-600">
                                    <a href="#" id="browse-plans-link">Browse Plans</a>
                                </small>
                            </div>

                            <div class="mb-4">
                                <label for="mobile-number" class="block text-sm font-medium">M Pin *</label>
                                <input type="text" name="mpin"
                                    class="form-input mt-1 w-full p-1.5 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    id="mobile-number" placeholder="Enter M Pin" maxlength="4" required
                                    inputmode="numeric" pattern="[0-9]{4}"
                                    oninput="this.value = this.value.replace(/\D/g, '').slice(0,4)" />
                            </div>

                            <button type="submit" class="btn btn-success  w-full text-white bg-indigo-100 py-2 px-4 rounded-lg" style="background: linear-gradient(to right, #0a22aa, #b62512); color: white; border: none;">Submit</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Browse Plans -->
            <div class="w-full lg:w-[45%] mb-4 flex justify-center align-center ">
                <div class="bg-white shadow-lg rounded-lg">
                    <div class="bg-indigo-100 text-black p-4 rounded-t-lg" style="background: linear-gradient(to right, #0a22aa, #b62512); color: white; border: none;">
                        <strong style="color: white">Browse Plans</strong>
                    </div>
                    <div class="p-6">
                        <p class="text-sm text-gray-500">
                            Disclaimer: While we support most recharges, we request you to verify with your operator once before proceeding.
                        </p>
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
    
                        @if(session('data'))
                            <div class="alert alert-light text-start mt-3 p-2">
                                <p class="mb-1"><strong>Ref:</strong> <span class="text-primary">{{ session('data.externalRef') }}</span></p>
                                <p class="mb-1"><strong>Amount:</strong> <span class="text-success">₹{{ session('data.txnValue') }}</span></p>
                                <p class="mb-1"><strong>Operator:</strong> <span class="text-dark">{{ session('data.billerDetails.name') }}</span></p>
                                <p class="mb-1"><strong>Mobile No:</strong> <span class="text-dark">{{ session('data.billerDetails.account') }}</span></p>
                            </div>
                        @endif
    
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
                alert("Error fetching plans.");
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
