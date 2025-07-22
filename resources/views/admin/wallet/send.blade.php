{{-- @extends('admin/include.layout')
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
            <h5 class="card-title text-success">Wallet Transfer Successful ✅</h5>
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

@endsection --}}




{{-- @extends('admin/include.layout')

@section('content')

<!-- Modal -->
<div class="modal fade" id="walletStatusModal" tabindex="-1" aria-labelledby="walletStatusModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      
      @if(isset($status) && $status === 'success')
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title" id="walletStatusModalLabel">Wallet Transfer Successful ✅</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <p>Your wallet transfer has been processed successfully! Thank you for using our service. 😊</p>
      </div>

      @elseif(isset($status) && $status === 'error')
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="walletStatusModalLabel">Wallet Transfer Failed ❌</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <p>Unfortunately, the transfer could not be completed. Please try again later or contact support. 🔧</p>
      </div>

      @else
      <div class="modal-header bg-warning text-white">
        <h5 class="modal-title" id="walletStatusModalLabel">Transaction Alert ⚠️</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <p>Insufficient balance for the transaction. Please try again later or contact support. 🔧</p>
      </div>
      @endif

      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>

<!-- Auto-trigger the modal if status exists -->
@if(isset($status))
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var walletModal = new bootstrap.Modal(document.getElementById('walletStatusModal'));
        walletModal.show();
    });
</script>
@endif

@endsection --}}






@extends('admin/include.layout')

@section('content')
<style>
    .popup-card {
        width: 400px;
        margin: auto;
        margin-top: 10vh;
        padding: 25px;
        border-radius: 15px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
        animation: fadeInScale 0.4s ease-in-out;
    }

    .popup-success {
        background: linear-gradient(135deg, #38b000, #70e000); /* Green gradient */
        color: #fff;
    }

    .popup-error {
        background: linear-gradient(135deg, #d00000, #ff6b6b); /* Red gradient */
        color: #fff;
    }

    .popup-warning {
        background: linear-gradient(135deg, #ffba08, #faa307); /* Yellow-orange */
        color: #fff;
    }

    @keyframes fadeInScale {
        0% {
            transform: scale(0.8);
            opacity: 0;
        }
        100% {
            transform: scale(1);
            opacity: 1;
        }
    }

    .popup-card h5 {
        font-size: 1.5rem;
        font-weight: bold;
    }

    .popup-card p {
        font-size: 1rem;
        margin-top: 10px;
    }
</style>

<div class="container-fluid d-flex justify-content-center align-items-center">
    @if(isset($status) && $status === 'success')
        <div class="popup-card popup-success text-center">
            <h5>✅ Wallet Transfer Successful</h5>
            <p>Your wallet transfer has been processed successfully! Thank you for using our service. 😊</p>
        </div>
    @elseif(isset($status) && $status === 'error')
        <div class="popup-card popup-error text-center">
            <h5>❌ Wallet Transfer Failed</h5>
            <p>Unfortunately, the transfer could not be completed. Please try again later or contact support. 🔧</p>
        </div>
    @else
        <div class="popup-card popup-warning text-center">
            <h5>⚠️ Transaction Alert</h5>
            <p>Insufficient balance for the transaction. Please try again later or contact support. 🔧</p>
        </div>
    @endif
</div>
@endsection
