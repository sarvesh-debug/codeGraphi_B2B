@extends('user/include.layout')

@section('content')
@include('user.beneficiary.navbar')

<div class="container my-5">
    <div class="card shadow-lg border-0">
        <div class="card-header bg-success text-white text-center">
            <h2 class="fw-bold">🎉 Refund Successful 🎉</h2>
        </div>
        <div class="card-body">
            <p class="text-center fs-5 mb-4 text-muted">{{ $message }}</p>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <table class="table table-bordered table-striped">
                        <tbody>
                            <tr>
                                <th>Reference ID</th>
                                <td>{{ $referenceId }}</td>
                            </tr>
                            <tr>
                                <th>Acknowledgement Number (Ackno)</th>
                                <td>{{ $ackno }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
      
    </div>
</div>

@endsection
