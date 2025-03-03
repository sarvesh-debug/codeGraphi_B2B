@extends('user/include.layout')
@section('content')
@include('user.bbps.navbar')

<div class="card col-md-6 mx-auto shadow-lg border-0">
    <div class="card-header bg-success text-white text-center py-3">
        <h4 class="mb-0">Recharge Plan</h4>
    </div>
    <div class="card-body p-4">
        <form action="{{route('bbps.recharge')}}" method="POST">
            @csrf
            <div class="form-group mb-3">
                <label for="bene_id" class="form-label">ProductCode</label>
                <select id="billerSelect" name="subProductCode" class="form-select">
                    <option value="" selected disabled>-- Select Biller --</option>
                    <option value="ATP">Airtel</option>
                    <option value="BSNL00000NATHL">BSNL</option>
                    <option value="BGP">BSNL (OLD)</option>
                    <option value="IDP">Idea (OLD)</option>
                    <option value="MTNL00000NAT1U">MTNL</option>
                    <option value="MMP">MTNL (OLD)</option>
                    <option value="RJP">Reliance Jio</option>
                    <option value="VFP">Vi</option>
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="bene_id" class="form-label">ProductCode</label>
                <select id="circleSelect" name="telecomCircle"  class="form-select">
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
            <input type="text" hidden id="latitude" name="latitude" class="form-control" readonly placeholder="Fetching latitude..." required>
            <input type="text" hidden id="longitude" name="longitude" class="form-control" readonly placeholder="Fetching longitude..." required>
            <button type="submit" class="btn btn-success w-100">Submit</button>
        </form>
    </div>
</div>
<script>
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