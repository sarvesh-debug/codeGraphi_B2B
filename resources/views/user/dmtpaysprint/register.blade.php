@extends('user.include.layout')

@section('content')

@php
$mobile = session()->get('mobile');
$stateResp = session()->get('stateresp');
$ekycId = session()->get('ekyc_id');
@endphp
<style>
    .form-container {
        max-width: 600px;
        margin: 50px auto;
        padding: 30px;
        background: #fff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
    }
    .form-title {
        font-size: 1.5rem;
        margin-bottom: 20px;
        color: #343a40;
        text-align: center;
    }
    .btn-submit {
        background-color: #007bff;
        color: #fff;
        font-weight: bold;
        transition: background-color 0.3s ease;
    }
    .btn-submit:hover {
        background-color: #0056b3;
    }
</style>

<div class="container form-container">
    <div class="form-title">Register Sender</div>
    <form action="{{ route('1remitter.register') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="mobile">Mobile Number</label>
            <input type="text" class="form-control" value="{{ $mobile}}" readonly name="mobile" placeholder="Enter Mobile Number" required>
        </div>
        <div class="form-group">
            <label for="firstname">KYC ID</label>
            <input type="text" class="form-control" value=" {{ $ekycId }}" readonly name="kyc_id" placeholder="" required>
        </div>
        {{-- <div class="form-group">
            <label for="lastname">Last Name</label>
            <input type="text" class="form-control" name="lastname" placeholder="Enter Last Name" required>
        </div> --}}
        {{-- <div class="form-group">
            <label for="address">Address</label>
            <input type="text" class="form-control" name="address" placeholder="Enter Address" required>
        </div> --}}
        <div class="form-group">
            <label for="otp">OTP</label>
            <input type="text" class="form-control" name="otp" placeholder="Enter OTP" required>
        </div>
        {{-- <div class="form-group">
            <label for="pincode">Pincode</label>
            <input type="text" class="form-control" name="pincode" placeholder="Enter Pincode" required>
        </div> --}}
        <div class="form-group">
            <label for="stateresp">State Response</label>
            <input type="text" class="form-control" name="stateresp" value=" {{ $stateResp }}" readonly placeholder="" required>
        </div>
        {{-- <div class="form-group">
            <label for="bank3_flag">Bank 3 Flag</label>
            <select class="form-control" name="bank3_flag" required>
                <option value="Yes">Yes</option>
                <option value="No" selected>No</option>
            </select>
        </div>
        <div class="form-group">
            <label for="dob">Date of Birth</label>
            <input type="date" class="form-control" name="dob" required>
        </div> --}}
        {{-- <div class="form-group">
            <label for="gst_state">GST State</label>
            <input type="text" class="form-control" name="gst_state" placeholder="Enter GST State" required>
        </div> --}}
        {{-- <div class="form-group mb-3">
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
        <div class="form-group">
            <label for="bank4_flag">Bank 4 Flag</label>
            <select class="form-control" name="bank4_flag" required>
                <option value="Yes">Yes</option>
                <option value="No" selected>No</option>
            </select>
        </div> --}}
        <button type="submit" class="btn btn-submit btn-block">Register Sender</button>
    </form>
</div>
@endsection
