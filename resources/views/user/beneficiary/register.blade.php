@extends('user/include.layout')
@section('content')
@include('user.beneficiary.navbar')

<div class="card col-md-6 mx-auto shadow-lg border-0 mt-5">
    <div class="card-header bg-success text-white text-center py-3">
        <h4 class="mb-0">Register Beneficiary</h4>
    </div>
    <div class="card-body p-4">
        <form action="{{ route('register.beneficiary') }}" method="POST">
            @csrf

           
                <input type="text" name="mobile" id="mobile" hidden value="{{ $mobile }}" class="form-control" placeholder="Enter mobile number" required>
            

            <div class="form-group mb-3">
                <label for="benename" class="form-label">Beneficiary Name</label>
                <input type="text" name="benename" id="benename" class="form-control" placeholder="Enter beneficiary name" required>
            </div>

            {{-- <div class="form-group mb-3">
                <label for="bank-search">Search Bank</label>
              
            </div> --}}
            
            <div class="form-group mb-3">
                <label for="bank">Select Bank</label>
                <input type="text" id="bank-search" class="form-control" placeholder="Type to search..." oninput="filterBanks()" />
                <select name="bankid" id="bank" class="form-control">
                    <option value="">-- Select Bank --</option>
                    @foreach($bankData as $bank)
                        <option value="{{ $bank->bankId }}" data-name="{{ $bank->bankName }}">{{ $bank->bankName }}</option>
                    @endforeach
                </select>
            </div>
            
            <script>
                function filterBanks() {
                    const searchInput = document.getElementById('bank-search').value.toLowerCase();
                    const bankOptions = document.querySelectorAll('#bank option');
            
                    bankOptions.forEach(option => {
                        const bankName = option.getAttribute('data-name')?.toLowerCase();
                        if (bankName && bankName.includes(searchInput)) {
                            option.style.display = ''; // Show option
                        } else if (option.value !== '') {
                            option.style.display = 'none'; // Hide option
                        }
                    });
                }
            </script>
            

            <div class="form-group mb-3">
                <label for="accno" class="form-label">Account Number</label>
                <input type="text" name="accno" id="accno" class="form-control" placeholder="Enter account number" required>
            </div>

            <div class="form-group mb-3">
                <label for="ifsccode" class="form-label">IFSC Code</label>
                <input type="text" name="ifsccode" id="ifsccode" class="form-control" placeholder="Enter IFSC code" required>
            </div>

            {{-- <div class="form-group mb-3">
                <label for="verified" class="form-label">Verified</label>
                <select name="verified" id="verified" class="form-select">
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="state">Select State</label>
                <select name="gst_state" id="state" class="form-control">
                    <option value="">-- Select State --</option>
                    <option value="01">Jammu and Kashmir</option>
                    <option value="02">Himachal Pradesh</option>
                    <option value="03">Punjab</option>
                    <option value="04">Chandigarh</option>
                    <option value="05">Uttarakhand</option>
                    <option value="06">Haryana</option>
                    <option value="07">Delhi</option>
                    <option value="08">Rajasthan</option>
                    <option value="09">Uttar Pradesh</option>
                    <option value="10">Bihar</option>
                    <option value="11">Sikkim</option>
                    <option value="12">Arunachal Pradesh</option>
                    <option value="13">Nagaland</option>
                    <option value="14">Manipur</option>
                    <option value="15">Mizoram</option>
                    <option value="16">Tripura</option>
                    <option value="17">Meghalaya</option>
                    <option value="18">Assam</option>
                    <option value="19">West Bengal</option>
                    <option value="20">Jharkhand</option>
                    <option value="21">Odisha</option>
                    <option value="22">Chhattisgarh</option>
                    <option value="23">Madhya Pradesh</option>
                    <option value="24">Gujarat</option>
                    <option value="26">Dadra and Nagar Haveli and Daman and Diu (Newly Merged UT)</option>
                    <option value="27">Maharashtra</option>
                    <option value="28">Andhra Pradesh (Before Division)</option>
                    <option value="29">Karnataka</option>
                    <option value="30">Goa</option>
                    <option value="31">Lakshadweep</option>
                    <option value="32">Kerala</option>
                    <option value="33">Tamil Nadu</option>
                    <option value="34">Puducherry</option>
                    <option value="35">Andaman and Nicobar Islands</option>
                    <option value="36">Telangana</option>
                    <option value="37">Andhra Pradesh (Newly Added)</option>
                    <option value="38">Ladakh (Newly Added)</option>
                    <option value="97">Other Territory</option>
                    <option value="99">Centre Jurisdiction</option>
                </select>
            </div>
            

            <div class="form-group mb-3">
                <label for="dob" class="form-label">Date of Birth</label>
                <input type="date" name="dob" id="dob" class="form-control" required>
            </div>

            <div class="form-group mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" name="address" id="address" class="form-control" placeholder="Enter address" required>
            </div>

            <div class="form-group mb-4">
                <label for="pincode" class="form-label">Pincode</label>
                <input type="text" name="pincode" id="pincode" class="form-control" placeholder="Enter pincode" required>
            </div> --}}

            <button type="submit" class="btn btn-success w-100 py-2">Register Beneficiary</button>
        </form>
    </div>
</div>
<!-- Include Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- Include Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

@endsection
