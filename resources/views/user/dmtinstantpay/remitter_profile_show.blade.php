@extends('user.include.layout')

@section('content')
<div class="container-fluid px-4">
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('customer/dashboard') }}">Home</a></li>
        <li class="breadcrumb-item active">Remitter Profile</li>
    </ol>
<a href="{{route('dmt.remitter-profile')}}" class="btn btn-info">Change Remitter</a>
    <div class="alert alert-success">
        <strong>{{ $responseData['status'] }}</strong>
    </div>

    <div class="row">
        <!-- Remitter Profile Card -->
        <div class="col-md-6">
            <div class="card mt-4">
                <div class="card-header">
                    <h5>Remitter Profile</h5>
                </div>
                <div class="card-body">
                    <p><strong>Mobile Number:</strong> {{ $responseData['data']['mobileNumber'] }}</p>
                    <p><strong>Name:</strong> {{ $responseData['data']['firstName'] }} {{ $responseData['data']['lastName'] }}</p>
                    <p><strong>City:</strong> {{ $responseData['data']['city'] }}</p>
                    <p><strong>Pincode:</strong> {{ $responseData['data']['pincode'] }}</p>
                </div>
            </div>
        </div>

        <!-- Transaction Limits Card -->
        <div class="col-md-6">
            <div class="card mt-4">
                <div class="card-header">
                    <h5>Transaction Limits</h5>
                </div>
                <div class="card-body">
                    <p><strong>Limit Per Transaction:</strong> ₹{{ $responseData['data']['limitPerTransaction'] }}</p>
                    <p><strong>Limit Total:</strong> ₹{{ $responseData['data']['limitTotal'] }}</p>
                    <p><strong>Limit Consumed:</strong> ₹{{ $responseData['data']['limitConsumed'] }}</p>
                    <p><strong>Limit Available:</strong> ₹{{ $responseData['data']['limitAvailable'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Beneficiaries Table Card -->
    <div class="card mt-4">
        <div class="card-header">
            <h5>Beneficiaries <a href="{{ route('dmt-beneficiaryRegistration', ['mobileNumber' => $responseData['data']['mobileNumber']]) }}" class="btn btn-success"> Add Beneficiary</a>
            </h5>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Account</th>
                        <th>Bank</th>
                        <th>IFSC</th>
                        <th>Beneficiary Mobile</th>
                        {{-- <th>Varified</th> --}}
                        <th>Send Money</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($responseData['data']['beneficiaries'] as $beneficiary)
                        <tr>
                            <td>{{ $beneficiary['name'] }}</td>
                            <td>{{ $beneficiary['account'] }}</td>
                            <td>{{ $beneficiary['bank'] }}</td>
                            <td>{{ $beneficiary['ifsc'] }}</td>
                            <td>{{ $beneficiary['beneficiaryMobileNumber'] }}</td>
                            {{-- <td>Verified</td> --}}
                                 <td>
                                <form action="{{ route('sendMoneyForm') }}" method="POST" style="display: inline;">
                                    @csrf
                                    <input type="hidden" name="mobile" value="{{ $responseData['data']['mobileNumber'] }}">
                                    <input type="text" hidden value="{{ $beneficiary['account'] ?? '' }}" name="account">

                                    <input type="text" hidden value="{{ $beneficiary['ifsc'] ?? '' }}" name="ifsc">
                                    <input type="hidden" name="referenceKey" value="{{ $responseData['data']['referenceKey'] }}">
                                    <button type="submit" class="btn btn-primary">Send</button>
                                </form>
                            </td>
                                
                        
                            <td>
                                <button type="button" class="btn btn-danger delete-beneficiary-btn" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#deleteBeneficiaryModal" 
                                    data-id="{{ $beneficiary['id'] }}">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Send Money Modal -->
<div class="modal fade" id="sendMoneyModal" tabindex="-1" aria-labelledby="sendMoneyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="sendMoneyModalLabel">Send Money</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="sendMoneyForm" action="{{ route('generateTransactionOtp') }}" method="POST">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="amount" class="form-label">Amount</label>
                        <input type="number" name="amount" id="amount" class="form-control" placeholder="Enter amount" required>
                    </div>
                  <input type="text" hidden  name="mobile" id="mobile" class="form-control" value="{{ $responseData['data']['mobileNumber'] }}" readonly>
                  
                  <input type="text" hidden value="{{ $beneficiary['account'] ?? '' }}" name="account">

                  <input type="text" hidden value="{{ $beneficiary['ifsc'] ?? '' }}" name="ifsc">
                    
                        <input type="text" hidden  name="referenceKey" id="referenceKey" class="form-control" value="{{ $responseData['data']['referenceKey'] }}" readonly>
                    <button type="submit" class="btn btn-success w-100">Send Money</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Beneficiary Modal -->
<div class="modal fade" id="deleteBeneficiaryModal" tabindex="-1" aria-labelledby="deleteBeneficiaryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteBeneficiaryModalLabel">Delete Beneficiary</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="deleteBeneficiaryForm" action="{{ route('dmt.delete') }}" method="POST">
                    @csrf
                    <p>Are you sure you want to delete this beneficiary?</p>
                    <input type="hidden" name="beneficiaryId" id="beneficiaryId">
                    <button type="submit" class="btn btn-danger w-100">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Populate Send Money Modal
        const sendMoneyButtons = document.querySelectorAll('.send-money-btn');
        const accountInput = document.getElementById('account');
        const ifscInput = document.getElementById('ifsc');

        sendMoneyButtons.forEach(button => {
            button.addEventListener('click', function () {
                accountInput.value = this.dataset.account;
                ifscInput.value = this.dataset.ifsc;
            });
        });

        // Populate Delete Beneficiary Modal
        const deleteButtons = document.querySelectorAll('.delete-beneficiary-btn');
        const beneficiaryIdInput = document.getElementById('beneficiaryId');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                beneficiaryIdInput.value = this.dataset.id;
            });
        });
    });
</script>
@endsection
