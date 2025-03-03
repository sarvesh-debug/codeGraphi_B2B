@extends('user/include.layout')

@section('content')
@include('user.beneficiary.navbar')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-success text-white text-center py-3">
                    <h4 class="mb-0">
                        <span class="text-success1">Transaction</span>
                        <span class="text-info1">OTP</span>
                    </h4>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('transact.perform') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Hidden Fields -->
                        <input type="hidden" class="form-control" value="{{ $mobile }}" id="mobile" name="mobile" />
                        <input type="hidden" class="form-control" value="{{ $referenceid }}" id="referenceid" name="referenceid" />
                        <input type="hidden" class="form-control" value="{{ $txntype }}" id="txntype" name="txntype" />
                        <input type="hidden" class="form-control" value="{{ $bene_id }}" id="bene_id" name="bene_id" />
                        <input type="hidden" class="form-control" value="{{ $amount }}" id="amount" name="amount" />
                        <input type="hidden" class="form-control" value="{{ $stateresp }}" id="stateresp" name="stateresp" />

                        <!-- OTP Field -->
                        <div class="form-group mb-3">
                            <label for="otp" class="form-label">OTP</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-key"></i></span>
                                <input type="text" class="form-control" id="otp" name="otp" placeholder="Enter OTP" required />
                            </div>
                        </div>

                        <!-- Submit and Reset Buttons -->
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-success w-45">
                                <i class="bi bi-check-circle"></i> Submit
                            </button>
                            <button type="reset" class="btn btn-warning w-45">
                                <i class="bi bi-x-circle"></i> Reset
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
















{{-- @extends('user/include.layout')
@section('content')
@include('user.beneficiary.navbar')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-success text-white text-center py-3">
                    <h4 class="mb-0"><span class="text-success1">Transaction</span> <span class="text-info1">Form</span></h4>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('transact.perform') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        
                                <input type="text" hidden class="form-control" value="{{ $mobile }}" id="mobile" name="mobile" placeholder="Enter Mobile Number" maxlength="10" required />
                       
                              
                                <input type="text" hidden class="form-control" value="{{ $referenceid }}" id="referenceid" name="referenceid" placeholder="Enter Reference ID" required />
                          

                     
                        <!-- Beneficiary ID -->
                       
                           
                                <input type="text" hidden class="form-control" value="{{ $bene_id }}" id="bene_id" name="bene_id" placeholder="Enter Beneficiary ID" required />
                          
                            <input type="text" hidden class="form-control" value="{{ $txntype  }}" id="bene_id" name="bene_id" placeholder="Enter Beneficiary ID" required />
                        </div>

                        <!-- Amount -->
                    
                                <input type="text" hidden class="form-control" value="{{ $amount }}" id="amount" name="amount" placeholder="Enter Amount" required />
                          

                        <!-- Merchant Code -->
       
                                <input type="text" hidden class="form-control" value="{{ $stateresp }}" id="merchantcode" name="merchantcode" placeholder="Enter Merchant Code" />
                       
                         <!-- OTP -->
                         <div class="form-group mb-3">
                            <label for="merchantcode" class="form-label">OTP</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-shop"></i></span>
                                <input type="text" class="form-control"  id="otp" name="otp" placeholder="Enter OTP" />
                            </div>
                        </div>


                        <!-- Submit and Reset Buttons -->
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-success w-45"><i class="bi bi-check-circle"></i> Submit</button>
                            <button type="reset" class="btn btn-warning w-45"><i class="bi bi-x-circle"></i> Reset</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection --}}
