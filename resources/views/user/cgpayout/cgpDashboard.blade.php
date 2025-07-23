@extends('user/include.layout')

@section('content')

<div class="container py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#" class="text-decoration-none text-primary">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Retailer Profile</li>
        </ol>
    </nav>

   <div class="row g-4">
    <!-- Business Profile -->
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header bg-light">
                <h5 class="mb-0">Retailer Profile</h5>
            </div>
            <div class="card-body">
                <p><strong>Mobile Number:</strong> {{ session('mobile') }}</p>
                <p><strong>Name:</strong> {{ session('user_name') }}</p>
                <p><strong>UserId:</strong> {{ session('username') }}</p>
            </div>
        </div>
    </div>

    <!-- Transactions Summary Card -->
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header bg-light">
                <h5 class="mb-0">Transaction Summary</h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <!-- Today Transaction -->
                    <div class="col-12 mb-3">
                        <div class="border rounded p-3 bg-light">
                            <h6 class="text-muted">Today</h6>
                            <h4 class="text-success">₹ {{ number_format($todayTxn, 2) }}</h4>
                        </div>
                    </div>

                    <!-- Monthly Transaction -->
                    <div class="col-6">
                        <div class="border rounded p-3 bg-light">
                            <h6 class="text-muted">Monthly</h6>
                            <h4 class="text-primary">₹ {{ number_format($monthTxn, 2) }}</h4>
                        </div>
                    </div>

                    <!-- Total Transaction -->
                    <div class="col-6">
                        <div class="border rounded p-3 bg-light">
                            <h6 class="text-muted">Total</h6>
                            <h4 class="text-dark">₹ {{ number_format($totalTxn, 2) }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


    <!-- Beneficiary List -->
    <div class="card mt-5">
        <div class="card-body">
            <div class="mb-3">
                <input type="text" id="beneSearchBox" placeholder="Search beneficiary..." class="form-control">
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-2">
                <h5 class="mb-0">Beneficiaries</h5>
                <a href="{{ route('add.bene') }}" class="btn btn-success btn-sm">Add Beneficiary</a>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover table-sm">
                    <thead class="table-light">
                        <tr>
                            <th>Name</th>
                            <th>Account</th>
                            <th>Bank</th>
                            <th>IFSC</th>
                            <th>Beneficiary Mobile</th>
                            <th>Send Money</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody id="beneTableBody">
                        @foreach ($beneFiciary as $beneficiary)
                        <tr class="beneRow">
                            <td>{{ $beneficiary->beneName }}</td>
                            <td>{{ $beneficiary->beneAccount }}</td>
                            <td>{{ $beneficiary->beneBankName }}</td>
                            <td>{{ $beneficiary->beneIFSC }}</td>
                            <td>{{ $beneficiary->beneMobileNo }}</td>
                            <td>
                                <button type="button"
                                    class="btn btn-primary btn-sm open-send-modal"
                                    data-name="{{ $beneficiary->beneName }}"
                                    data-account="{{ $beneficiary->beneAccount }}"
                                    data-ifsc="{{ $beneficiary->beneIFSC }}"
                                    data-bank="{{ $beneficiary->beneBankName }}"
                                    data-mobile="{{ $beneficiary->beneMobileNo }}"
                                    data-bs-toggle="modal"
                                    data-bs-target="#sendMoneyModal">
                                    Send
                                </button>
                            </td>
                            <td>
                                <button type="button"
                                    class="btn btn-danger btn-sm delete-beneficiary-btn"
                                    data-bs-toggle="modal"
                                    data-bs-target="#deleteBeneficiaryModal"
                                    data-id="{{ $beneficiary->id }}">
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
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteBeneficiaryModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="deleteBeneficiaryForm" action="{{route('delete.beneStore')}}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title text-danger" id="deleteModalLabel">Delete Beneficiary</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this beneficiary?</p>
                    <input type="hidden" name="beneficiaryId" id="beneficiaryId">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger w-100">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Send Money Modal -->
<div class="modal fade" id="sendMoneyModal" tabindex="-1" aria-labelledby="sendMoneyLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{route('sendMoney.Form')}}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title text-primary" id="sendMoneyLabel">Send Money</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="alert alert-warning small">
                        <strong>Disclaimer:</strong> Please check the beneficiary details carefully before proceeding.
                        <ul class="mt-2 ps-3">
                            <li><strong>Name:</strong> <span id="modalName"></span></li>
                            <li><strong>Account:</strong> <span id="modalAccount"></span></li>
                            <li><strong>IFSC:</strong> <span id="modalIFSC"></span></li>
                            <li><strong>Bank:</strong> <span id="modalBank"></span></li>
                            <li><strong>Mobile:</strong> <span id="modalMobile"></span></li>
                        </ul>
                    </div>

                    <input type="hidden" name="name" id="formName">
                    <input type="hidden" name="account" id="formAccount">
                    <input type="hidden" name="ifsc" id="formIFSC">
                    <input type="hidden" name="bankName" id="formBank">
                    <input type="hidden" name="mobile" id="formMobile">

                    <div class="mb-3">
                        <label for="amount" class="form-label">Amount</label>
                        <input type="number" name="amount" id="amount" class="form-control" placeholder="Must be a multiple of 100" required>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Send Money</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- JS -->
<script>
    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
    }

    document.addEventListener('DOMContentLoaded', function () {
        // Delete modal
        const deleteButtons = document.querySelectorAll('.delete-beneficiary-btn');
        const deleteModal = document.getElementById('deleteBeneficiaryModal');
        const beneficiaryIdInput = document.getElementById('beneficiaryId');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                beneficiaryIdInput.value = this.dataset.id;
                deleteModal.classList.remove('hidden');
            });
        });
    //serch model
     // Search functionality
    const searchBox = document.getElementById('beneSearchBox');
    searchBox.addEventListener('input', function () {
        const searchText = searchBox.value.toLowerCase();
        const rows = document.querySelectorAll('#beneTableBody .beneRow');
        rows.forEach(row => {
            const name = row.querySelector('td:nth-child(1)').textContent.toLowerCase();
            const account = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
            const bank = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
            const ifsc = row.querySelector('td:nth-child(4)').textContent.toLowerCase();
            const mobile = row.querySelector('td:nth-child(5)').textContent.toLowerCase();

            // Show or hide rows based on the search input
            if (name.includes(searchText) || account.includes(searchText) || bank.includes(searchText) || ifsc.includes(searchText) || mobile.includes(searchText)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

        // Send money modal
        const sendButtons = document.querySelectorAll('.open-send-modal');
        const sendModal = document.getElementById('sendMoneyModal');

        sendButtons.forEach(button => {
            button.addEventListener('click', function () {
                // Set visible text
                document.getElementById('modalName').textContent = this.dataset.name;
                document.getElementById('modalAccount').textContent = this.dataset.account;
                document.getElementById('modalIFSC').textContent = this.dataset.ifsc;
                document.getElementById('modalBank').textContent = this.dataset.bank;
                document.getElementById('modalMobile').textContent = this.dataset.mobile;

                // Set form input values
                document.getElementById('formName').value = this.dataset.name;
                document.getElementById('formAccount').value = this.dataset.account;
                document.getElementById('formIFSC').value = this.dataset.ifsc;
                document.getElementById('formBank').value = this.dataset.bank;
                document.getElementById('formMobile').value = this.dataset.mobile;

                sendModal.classList.remove('hidden');
            });
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.delete-beneficiary-btn');
        const modal = document.getElementById('deleteBeneficiaryModal');
        const beneficiaryIdInput = document.getElementById('beneficiaryId');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                beneficiaryIdInput.value = this.dataset.id;
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            });
        });
    });
</script>
@if (session('success'))
    <!-- Success Modal -->
    <div id="successModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md text-center">
            <h2 class="text-xl font-semibold text-green-700 mb-4">Success</h2>
            <p class="text-gray-800">{{ session('success') }}</p>
            <button onclick="closeSuccessModal()" class="mt-6 bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                OK
            </button>
        </div>
    </div>

    <!-- Script to auto-close modal after 3 seconds (optional) -->
    <script>
        function closeSuccessModal() {
            document.getElementById('successModal').style.display = 'none';
        }

        // Auto-hide after 3 seconds
        setTimeout(() => {
            closeSuccessModal();
        }, 3000);
    </script>
@endif
@endsection
