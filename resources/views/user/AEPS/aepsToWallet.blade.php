@extends('user/include.layout')

@section('content')

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#" class="text-primary">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">AePS To Main Wallet</li>
    </ol>
</nav>

<main class="p-3">
    <div class="bg-white shadow rounded p-4">
        {{-- Flash Message --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Entries & Search --}}
        <div class="row mb-3">
            <div class="col-md-6 d-flex align-items-center gap-2">
                <label for="entries" class="form-label mb-0">Show</label>
                <select id="entries" class="form-select form-select-sm w-auto">
                    <option value="5">5</option>
                    <option value="10" selected>10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                </select>
                <span>entries</span>
            </div>
            <div class="col-md-6 d-flex justify-content-end gap-2">
                <input type="text" id="search" class="form-control form-control-sm" placeholder="Search...">
                <button onclick="filterTable()" class="btn btn-primary btn-sm">Search</button>
            </div>
        </div>

        {{-- Table --}}
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>SL</th>
                        <th>Date Time</th>
                        <th>Remark</th>
                        <th>Opening Balance</th>
                        <th>Credit</th>
                        <th>Closing Balance</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($getLadger as $fundRequest)
                    <tr>
                        <td>{{ $loop->count - $loop->iteration + 1 }}</td>
                        <td>{{ $fundRequest->created_at }}</td>
                        <td>{{ $fundRequest->remarks }}</td>
                        <td class="fw-bold">{{ $fundRequest->openingBal }}</td>
                        <td>{{ $fundRequest->amount }}</td>
                        <td class="fw-bold">{{ $fundRequest->closingBal }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="d-flex justify-content-between align-items-center mt-3">
            <button id="prev" class="btn btn-secondary btn-sm">Previous</button>
            <span id="page-info" class="small"></span>
            <button id="next" class="btn btn-secondary btn-sm">Next</button>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let table = document.querySelector("table tbody");
            let rows = Array.from(table.querySelectorAll("tr"));
            let currentPage = 1;
            let rowsPerPage = 50;

            function displayTable() {
                let start = (currentPage - 1) * rowsPerPage;
                let end = start + rowsPerPage;

                rows.forEach((row, index) => {
                    row.style.display = (index >= start && index < end) ? "" : "none";
                });

                updatePagination();
            }

            function updatePagination() {
                document.getElementById("page-info").textContent = `Page ${currentPage} of ${Math.ceil(rows.length / rowsPerPage)}`;
                document.getElementById("prev").disabled = currentPage === 1;
                document.getElementById("next").disabled = currentPage === Math.ceil(rows.length / rowsPerPage);
            }

            document.getElementById("entries").addEventListener("change", function () {
                rowsPerPage = parseInt(this.value);
                currentPage = 1;
                displayTable();
            });

            document.getElementById("prev").addEventListener("click", function () {
                if (currentPage > 1) {
                    currentPage--;
                    displayTable();
                }
            });

            document.getElementById("next").addEventListener("click", function () {
                if (currentPage < Math.ceil(rows.length / rowsPerPage)) {
                    currentPage++;
                    displayTable();
                }
            });

            displayTable();
        });
    </script>
</main>
@endsection
