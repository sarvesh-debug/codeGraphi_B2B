@extends('admin/include.layout')
<style>
    .container-fluid {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.card {
    width: 60%;
    padding: 30px;
    text-align: center;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
}

.card-title {
    font-size: 1.5rem;
    font-weight: bold;
    margin-bottom: 15px;
}

.card-text {
    font-size: 1.2rem;
}

</style>
@section('content')
<div class="container-fluid d-flex justify-content-center align-items-center" style="height: 100vh;">
    @if(isset($status) && $status === 'success')
    <div class="card text-center" style="width: 50%; padding: 30px;">
        <div class="card-body">
            <h5 class="card-title text-dark">Wallet Transfer Successful ✅</h5>
            <p class="card-text">
                Your wallet transfer has been processed successfully! Thank you for using our service. 😊
            </p>
        </div>
    </div>
    @elseif(isset($status) && $status === 'error')
    <div class="card text-center" style="width: 50%; padding: 30px;">
        <div class="card-body">
            <h5 class="card-title text-danger">Wallet Transfer Failed ❌</h5>
            <p class="card-text">
                Unfortunately, the transfer could not be completed. Please try again later or contact support. 🔧
            </p>
        </div>
    </div>
    @else
    <div class="card text-center" style="width: 50%; padding: 30px;">
        <div class="card-body">
            <h5 class="card-title text-warning">Transaction Alert ⚠️</h5>
            <p class="card-text">
                Insufficient balance for the transaction. Please try again later or contact support. 🔧
            </p>
        </div>
    </div>
    @endif
</div>

@endsection
