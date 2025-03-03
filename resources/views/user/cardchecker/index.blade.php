@extends('user/include.layout')

@section('content')

<div class="controller mt-3 mx-5">
    <div class="row">
        <!-- Navigation Tabs -->
         <!-- Navigation Bar -->
    
        </div>
        <script>
            // Function to get the user's geolocation
            function getGeolocation() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        document.getElementById('latitude').value = position.coords.latitude;
                        document.getElementById('longitude').value = position.coords.longitude;
                    });
                } else {
                    alert("Geolocation is not supported by this browser.");
                }
            }
    
            // Automatically trigger geolocation when the page loads
            window.onload = getGeolocation;
        </script>
        <div class="row change">
            <div class="col-lg-6 mx-auto">
                <div class="card shadow">
                    <div class="card-header bg-success text-white text-center py-3">
                        <h4 class="mb-0"><span class="text-success1">Credit Card</span><span class="text-info1">Checker</span></h4>
                    </div>

                    <div class="card-body">
                        <form action="" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                             <!-- mobile Nmber -->
                             <div class="mb-3">
                                <label for="remarkInput" class="form-label">Credit Card first 6 digits</label>
                                <input type="text" class="form-control" id="binNumber" name="binNumber" placeholder="Credit Card first 6 digits" />
                            </div>
                         
                            <input type="text" id="latitude" name="latitude" required hidden>
                            <input type="text" id="longitude" name="longitude" required hidden>
                    
                            
                            

                            <!-- Submit Button -->
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-success">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
