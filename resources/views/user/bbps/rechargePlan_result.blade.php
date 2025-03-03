@extends('user/include.layout')
@section('content')
@include('user.bbps.navbar')
<div class="container mt-4">
    <h1 class="mb-4">Recharge Plans</h1>

    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    <div class="row">
        @forelse($plans as $plan)
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <strong>{{ $plan['planCategory'] ?? 'N/A' }}</strong>
                </div>
                <div class="card-body">
                    <p><strong>Amount:</strong> ₹{{ $plan['planAmount'] ?? 'N/A' }}</p>
                    <p><strong>Validity:</strong> {{ $plan['planValidity'] ?? 'N/A' }}</p>
                    <p><strong>Description:</strong> {{ $plan['planDescription'] ?? 'N/A' }}</p>
                    @if(isset($plan['talktimeBenefits']))
                    <p><strong>Talktime:</strong> ₹{{ $plan['talktimeBenefits'] }}</p>
                    @endif
                    @if(isset($plan['dataBenefits']))
                    <p><strong>Data:</strong> {{ $plan['dataBenefits'] }}</p>
                    @endif
                </div>
                <div class="card-footer text-muted">
                    Disclaimer: {{ $plan['disclaimer'] ?? 'N/A' }}
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <p class="text-center">No plans available.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
