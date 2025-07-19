@extends('user/include.layout')
@section('content')

<div class="card col-md-6 mx-auto shadow-lg border-0 mt-5">
    <div class="card-header">
        <h4 class="card-heading mb-0">Register Beneficiary</h4>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <div class="card-body p-4">
        <form action="{{ route('cg-beneficiaryRegistrationStore') }}" method="POST">
            @csrf
            <input type="hidden" name="mobile" id="mobile" value="{{ $mobileNumber }}" class="form-control">

            <div class="form-group mb-2">
                <label for="benename" class="form-label">Beneficiary Name</label>
                <input type="text" name="benename" id="benename" class="form-control" placeholder="Enter beneficiary name" required>
            </div>

            <div class="form-group mb-2">
                <label for="beneMobile" class="form-label">Beneficiary Mobile No</label>
                <input type="text" name="beneMobile" id="beneMobile" class="form-control" placeholder="Enter Mobile No" required>
            </div>

            <div class="form-group mb-2">
                <label for="accno" class="form-label">Account Number</label>
                <input type="text" name="accno" id="accno" class="form-control" placeholder="Enter account number" required>
            </div>

            <!-- Custom Bank Dropdown with Search -->
            <div class="form-group position-relative mb-4">
                <label for="bank-search" class="form-label">Select Bank *</label>
                <input type="text" id="bank-search" class="form-control" placeholder="Type to search bank..." 
                       oninput="filterBanks()" onclick="toggleBankDropdown()" autocomplete="off" />

                <div id="bank-dropdown" class="bg-white border rounded mt-1 position-absolute w-100 shadow overflow-auto" 
                     style="max-height: 200px; z-index: 1000; display: none;">
                    @foreach($responseData['data'] as $bank)
                        <div class="px-3 py-2 dropdown-item text-dark" style="cursor: pointer;"
                            onclick="selectBank('{{ $bank['name'] }}', '{{ $bank['ifscGlobal'] }}')"
                            data-name="{{ $bank['name'] }}">
                            {{ $bank['name'] }}
                        </div>
                    @endforeach
                </div>

                <!-- Hidden input for bank name instead of bankId -->
                <input type="hidden" name="bank_name" id="bank-hidden">

                <!-- IFSC input (readonly) -->
                <label for="ifsc" class="form-label mt-3">IFSC Code</label>
                <input type="text" name="ifsc" id="ifsc" class="form-control" placeholder="Auto-filled IFSC" readonly>
            </div>

            <!-- Verify Button -->
            <div class="form-group mb-3">
                <button type="button" class="btn btn-primary w-100" onclick="verifyAccount()">Verify Bank Account</button>
            </div>

            <!-- Loader -->
            <div id="verifyLoader" style="display: none;" class="text-center my-2">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Verifying...</span>
                </div>
                <p class="mt-1">Verifying bank account...</p>
            </div>

            <!-- Hidden Location -->
            <input type="hidden" name="latitude" id="latitude" required>
            <input type="hidden" name="longitude" id="longitude" required>

            <!-- Submit Button -->
            <div class="text-center">
                <button type="submit" class="btn btn-success w-100 py-2">Register Beneficiary</button>
            </div>
        </form>
    </div>
</div>

<!-- Script Section -->
<script>
    function toggleBankDropdown() {
        document.getElementById('bank-dropdown').style.display = 'block';
    }

    function filterBanks() {
        const input = document.getElementById('bank-search').value.toLowerCase();
        const items = document.querySelectorAll('#bank-dropdown .dropdown-item');

        items.forEach(item => {
            const name = item.getAttribute('data-name').toLowerCase();
            item.style.display = name.includes(input) ? 'block' : 'none';
        });
    }

    function selectBank(name, ifsc) {
        document.getElementById('bank-search').value = name;
        document.getElementById('bank-hidden').value = name;
        document.getElementById('ifsc').value = ifsc;
        document.getElementById('bank-dropdown').style.display = 'none';
    }

    document.addEventListener('click', function (e) {
        const search = document.getElementById('bank-search');
        const dropdown = document.getElementById('bank-dropdown');
        if (!search.contains(e.target) && !dropdown.contains(e.target)) {
            dropdown.style.display = 'none';
        }
    });

    // Get location
    window.onload = function () {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                document.getElementById('latitude').value = position.coords.latitude;
                document.getElementById('longitude').value = position.coords.longitude;
            }, function (error) {
                console.error('Geolocation error:', error.message);
                document.getElementById('latitude').value = 'Unavailable';
                document.getElementById('longitude').value = 'Unavailable';
            });
        }
    };

    function verifyAccount() {
        const accno = document.getElementById('accno').value;
        const ifsc = document.getElementById('ifsc').value;
        const lat = document.getElementById('latitude').value;
        const long = document.getElementById('longitude').value;

        if (!accno || !ifsc || !lat || !long) {
            alert("Please fill all fields and allow location.");
            return;
        }

        document.getElementById('verifyLoader').style.display = 'block';

        fetch("https://codegraphi.com/B2B/api/v1/account/verify", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                outlet: "{{ session('outlet') }}",
                accountNumber: accno,
                ifsc: ifsc,
                latitude: lat,
                longitude: long
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const name = data.data?.payee?.name || '';
                const verifiedIfsc = data.data?.payee?.ifsc || '';
                if (name) document.getElementById('benename').value = name;
                if (verifiedIfsc) document.getElementById('ifsc').value = verifiedIfsc;

                return fetch("https://api.codegraphi.in/api/customer/decrease-balance", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        email: "{{ env('Business_Email') }}",
                        amount: 3,
                        service: "Account Verify"
                    })
                });
            } else {
                throw new Error(data.message || "Verification failed");
            }
        })
        .then(res => res.json())
        .then(balanceData => {
            document.getElementById('verifyLoader').style.display = 'none';
            if (balanceData.success) {
                alert("Bank account verified successfully. ₹3 deducted.");
            } else {
                alert("Verified, but: " + (balanceData.message || ''));
            }
        })
        .catch(err => {
            document.getElementById('verifyLoader').style.display = 'none';
            alert("Error: " + err.message);
            console.error("Error:", err);
        });
    }
</script>

@endsection
