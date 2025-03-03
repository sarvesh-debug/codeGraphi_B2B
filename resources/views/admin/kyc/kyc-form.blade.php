@extends('admin/include.layout') 

@section('content')

<div class="controller mt-3 mx-5">
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{(route('cash.withdrawal.form'))}}">Home</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{route('balance.enquiry-form')}}">Balance Enquiry</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Mini Statement</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/user">Exit</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="row">
        <!-- Welcome Marquee -->
        <br>
        <marquee width="100%" direction="left" class="h5">
            Welcome To <span class="text-success1">Graphi</span><span class="text-info1">Graphi</span> Solutions 🙂
        </marquee>

        <!-- Content Section -->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <!-- Content container -->
            <div id="kt_app_content_container" class="app-container container-fluid">
                <div class="card col-md-6 mx-auto shadow-lg border-0">
                    <!-- Card Header -->
                    <div class="card-header bg-success text-white text-center py-3">
                        <h4 class="mb-0">Apply For KYC</h4>
                    </div>

                    <!-- Card Body -->
                    <div class="card-body p-4">
                        <!-- Display success message -->
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{route('admin/kyc.store')}}" method="POST" enctype="multipart/form-data">
                            @csrf

                             <!-- Name Field -->
                             <div class="form-group mb-3">
                                <label for="name" class="form-label">Name</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="{{ old('name') }}" required>
                                </div>
                            </div>

                            <!-- Username Field -->
                            <div class="form-group mb-3">
                                <label for="username" class="form-label">Username</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text" class="form-control" id="username" name="username" placeholder="Enter Username" value="{{ old('username') }}" required>
                                </div>
                            </div>

                            <!-- Aadhaar Number Field -->
                            <div class="form-group mb-3">
                                <label for="aadhaar" class="form-label">Aadhaar Number</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input type="text" class="form-control numeric-input" id="aadhaar" name="aadhaar" placeholder="Enter Aadhaar Number" maxlength="12" value="{{ old('aadhaar') }}" required/>
                                </div>
                                <small class="form-text text-muted">Enter a valid 12-digit Aadhaar number.</small>
                            </div>

                            <!-- Aadhaar Card Image (Front) -->
                            <div class="form-group mb-3">
                                <label for="aadhaar_front" class="form-label">Aadhaar Card (Front Side)</label>
                                <input type="file" class="form-control" id="aadhaar_front" name="aadhaar_front" accept="image/*" required/>
                                <small class="form-text text-muted">Upload the front side of your Aadhaar card.</small>
                            </div>

                            <!-- Aadhaar Card Image (Back) -->
                            <div class="form-group mb-3">
                                <label for="aadhaar_back" class="form-label">Aadhaar Card (Back Side)</label>
                                <input type="file" class="form-control" id="aadhaar_back" name="aadhaar_back" accept="image/*" required/>
                                <small class="form-text text-muted">Upload the back side of your Aadhaar card.</small>
                            </div>

                            <!-- PAN Field -->
                            <div class="form-group mb-3">
                                <label for="pan" class="form-label">PAN</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-credit-card"></i></span>
                                    <input type="text" class="form-control" id="pan" name="pan" placeholder="Enter PAN" value="{{ old('pan') }}" required>
                                </div>
                            </div>

                            <!-- PAN Card Image -->
                            <div class="form-group mb-3">
                                <label for="pan_card" class="form-label">PAN Card</label>
                                <input type="file" class="form-control" id="pan_card" name="pan_card" accept="image/*" required/>
                                <small class="form-text text-muted">Upload your PAN card.</small>
                            </div>

                            <!-- City Field -->
                            <div class="form-group mb-3">
                                <label for="city" class="form-label">City</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-building"></i></span>
                                    <input type="text" class="form-control" id="city" name="city" placeholder="Enter City" value="{{ old('city') }}" required>
                                </div>
                            </div>

                            <!-- State Dropdown -->
                            <div class="form-group mb-3">
                                <label for="state" class="form-label">State</label>
                                <select class="form-control" id="state" name="state" required>
                                    <option value="">Select State</option>
                                    <option value="Andhra Pradesh">Andhra Pradesh</option>
                                    <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                                    <option value="Assam">Assam</option>
                                    <option value="Bihar">Bihar</option>
                                    <option value="Chhattisgarh">Chhattisgarh</option>
                                    <option value="Goa">Goa</option>
                                    <option value="Gujarat">Gujarat</option>
                                    <option value="Haryana">Haryana</option>
                                    <option value="Himachal Pradesh">Himachal Pradesh</option>
                                    <option value="Jharkhand">Jharkhand</option>
                                    <option value="Karnataka">Karnataka</option>
                                    <option value="Kerala">Kerala</option>
                                    <option value="Madhya Pradesh">Madhya Pradesh</option>
                                    <option value="Maharashtra">Maharashtra</option>
                                    <option value="Manipur">Manipur</option>
                                    <option value="Meghalaya">Meghalaya</option>
                                    <option value="Mizoram">Mizoram</option>
                                    <option value="Nagaland">Nagaland</option>
                                    <option value="Odisha">Odisha</option>
                                    <option value="Punjab">Punjab</option>
                                    <option value="Rajasthan">Rajasthan</option>
                                    <option value="Sikkim">Sikkim</option>
                                    <option value="Tamil Nadu">Tamil Nadu</option>
                                    <option value="Telangana">Telangana</option>
                                    <option value="Tripura">Tripura</option>
                                    <option value="Uttar Pradesh">Uttar Pradesh</option>
                                    <option value="Uttarakhand">Uttarakhand</option>
                                    <option value="West Bengal">West Bengal</option>
                                    <option value="Delhi">Delhi</option>
                                </select>
                            </div>

                            <!-- Pincode Field -->
                            <div class="form-group mb-3">
                                <label for="pincode" class="form-label">Pincode</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-pin"></i></span>
                                    <input type="text" class="form-control" id="pincode" name="pincode" placeholder="Enter Pincode" maxlength="6" value="{{ old('pincode') }}" required/>
                                </div>
                            </div>

                            <!-- Outlet Name Field -->
                            <div class="form-group mb-3">
                                <label for="outlet_name" class="form-label">Outlet Name</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-shop"></i></span>
                                    <input type="text" class="form-control" id="outlet_name" name="outlet_name" placeholder="Enter Outlet Name" value="{{ old('outlet_name') }}" required>
                                </div>
                            </div>

                            <!-- Submit Button -->
                          
                            <div class="text-center">
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
