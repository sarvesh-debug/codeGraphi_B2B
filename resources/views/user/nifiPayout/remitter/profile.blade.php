@extends('user.include.layout')

@section('content')
<div class="container-fluid px-4">
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('customer/dashboard') }}">Home</a></li>
        <li class="breadcrumb-item active">Remitter Profile</li>
    </ol>

    <a href="{{ route('remProfile') }}" class="btn btn-info mb-3">Change Remitter</a>

    <div class="row">
        <!-- Remitter Profile -->
        <div class="col-md-6">
            <div class="card mt-4">
                <div class="card-header">
                    <h5>Remitter Profile</h5>
                </div>
                <div class="card-body">
                    <p><strong>Mobile Number:</strong> {{ $responseData->mobile }}</p>
                    <p><strong>Name:</strong> {{ $responseData->name }}</p>
                    <p><strong>City:</strong> {{ $responseData->city }}</p>
                    <p><strong>Pincode:</strong> {{ $responseData->pincode }}</p>
                </div>
            </div>
        </div>

        <!-- Transaction Limits -->
        <div class="col-md-6">
            <div class="card mt-4">
                <div class="card-header">
                    <h5>Transaction Limits</h5>
                </div>
                <div class="card-body">
                    <p><strong>Limit Per Transaction:</strong> ₹{{ $responseData->perday_limit }}</p>
                    <p><strong>Limit Total:</strong> ₹{{ $responseData->monthly_limit }}</p>
                    <p><strong>Limit Consumed:</strong> ₹{{$summary->total_amount}}</p>
                    <p><strong>Limit Available:</strong> ₹{{$responseData->monthly_limit -$summary->total_amount}}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Beneficiary Table -->
    <div class="card mt-4">
        <div class="card-header">
            <h5>
                Beneficiaries
                <a href="{{ route('cg-beneficiaryRegistration', ['mobile' => $responseData->mobile]) }}" class="btn btn-success btn-sm float-end">
                    Add Beneficiary
                </a>
            </h5>
        </div>
        <div class="card-body">
            @if($beneficiaries->isEmpty())
                <div class="alert alert-warning text-center">No beneficiaries found.</div>
            @else
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Account</th>
                            <th>Bank</th>
                            <th>IFSC</th>
                            <th>Mobile</th>
                            <th>Send</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($beneficiaries as $bene)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{ $bene->benename }}</td>
                                <td>{{ $bene->accno }}</td>
                                <td>{{ $bene->bank_name }}</td>
                                <td>{{ $bene->ifsc }}</td>
                                <td>{{ $bene->beneMobile }}</td>
                               <td>
    <form action="{{ route('sendMoneyFormDmt1') }}" method="POST" 
          onsubmit="@if($responseData->monthly_limit <= $summary->total_amount) 
                        alert('🚫 Your limit has been reached. You cannot send more money.');
                        return false;
                    @endif">
        @csrf
        <input type="hidden" name="mobile" value="{{ $responseData->mobile }}">
        <input type="hidden" name="account" value="{{ $bene->accno }}">
        <input type="hidden" name="ifsc" value="{{ $bene->ifsc }}">
        <input type="hidden" name="beneName" value="{{ $bene->benename }}">
        <input type="hidden" name="email" value="{{ session('email')}}">

        <button type="submit" class="btn btn-primary btn-sm"
            @if($responseData->monthly_limit <= $summary->total_amount) disabled @endif>
            Send
        </button>
    </form>
</td>

                                <td>
                                    <button class="btn btn-danger btn-sm delete-beneficiary-btn"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteBeneficiaryModal"
                                            data-id="{{ $bene->beneId }}">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteBeneficiaryModal" tabindex="-1" aria-labelledby="deleteBeneficiaryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('beneDelete') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Delete Beneficiary</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this beneficiary?
                    <input type="hidden" name="beneficiaryId" id="beneficiaryId">
                    <input type="hidden" name="remMobile" value="{{ $responseData->mobile }}">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
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
