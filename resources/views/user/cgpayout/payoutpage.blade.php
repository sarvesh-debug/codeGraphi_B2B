@extends('user/include.layout')

@section('content')
<style>
    .centered-form {
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }
</style>

<div class="container centered-form">
    <div class="col-md-6">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header bg-gradient text-white text-center rounded-top-4" style="background: linear-gradient(45deg, #007bff, #00c6ff);">
                <h4 class="mb-0">💸 Payout Initiate</h4>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{route('usercg.payout')}}">
                    @csrf
                    <input type="text" hidden value="{{$token}}"  name="token">
                    <input type="text" hidden value="{{$rtId}}" name="rtId">
                    <div class="mb-3">
                        <label for="amount" class="form-label">💰 Amount</label>
                        <input type="number" class="form-control" id="amount" name="amount" min="100" required 
                            placeholder="Enter amount above ₹99" value="">
                    </div>
                    

                    <div class="mb-3">
                        <label for="receiver_name" class="form-label">👤 Receiver Name</label>
                        <input type="text" class="form-control" id="receiver_name" name="receiver_name" 
                            value="{{ session('user_name') }}" readonlys>
                    </div>

                    <div class="mb-3">
                        <label for="payment_mode" class="form-label">💳 Payment Mode</label>
                        <input type="text" class="form-control" id="payment_mode" name="payment_mode" 
                            value="IMPS">
                    </div>
                   
                        <input type="hidden" class="form-control" id="bankName" name="bankName" 
                            value="{{ session('bankName') }}">
                    
                    <div class="mb-3">
                        <label for="ifsc" class="form-label">🏦 IFSC Code</label>
                        <input type="text" class="form-control" id="ifsc" name="ifsc" 
                            value="{{ session('ifsc') }}">
                    </div>

                    <div class="mb-3">
                        <label for="account_no" class="form-label">🔐 Account Number</label>
                        <input type="text" class="form-control" id="account_no" name="account_no" 
                            value="{{ session('accountNo') }}">
                    </div>

                    
                        <input type="hidden" class="form-control" id="ip_address" name="ip_address" 
                            value="{{ request()->ip() }}">
                    
                    <input 
                    type="hidden" 
                    class="form-control" 
                    id="email" 
                    name="Business_Email" 
                    value="{{ env('Business_Email') }}" 
                    readonly
                >
                <input 
                type="hidden" 
                class="form-control" 
                id="email" 
                name="Business_Id" 
                value="{{ env('Business_Id') }}" 
                readonly
            >
                    <div class="d-grid">
                        <button type="submit" class="btn btn-success btn-lg rounded-pill">🚀 Initiate Payout</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



@endsection
