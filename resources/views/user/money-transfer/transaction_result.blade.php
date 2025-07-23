@extends('user/include.layout') 
@section('content')
@include('user.beneficiary.navbar')

<div class="container mt-5">
    <h2 class="text-center">Transaction Result</h2>

    @if (isset($error))
        <div class="alert alert-danger">{{ $error }}</div>
    @elseif (isset($transactionData) && $transactionData['status'])
        <div class="alert alert-success">{{ $transactionData['message'] }}</div>

        <!-- Transaction Details Card -->
        <div class="card col-md-8 mx-auto shadow-lg border-0 mt-3">
            <div class="card-header bg-success text-white text-center py-3">
                <h5 class="mb-0">Transaction Details</h5>
            </div>

            <div class="card-body">
                <!-- All Data in One Card -->
                <div class="row">
                     <!-- Show referenceid -->
                     <div class="col-md-12 mb-3">
                        <div class="card h-100">
                            <div class="card-body p-3">
                                <h6 class="card-title">Reference ID</h6>
                                <p class="card-text">{{ $referenceid ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <h5>Transaction Information</h5>
                        <ul id="transaction-list" class="list-group">
                            @foreach ([ 
                                  'Transaction Amount' => $transactionData['txn_amount'] ?? 'N/A',
                                  'Balance' => $transactionData['balance'] ?? 'N/A',
                                  'Beneficiary Name' => $transactionData['benename'] ?? 'N/A',
                                  'Remarks' => $transactionData['remarks'] ?? 'N/A',
                                  'ACK Number' => $transactionData['ackno'] ?? 'N/A',
                                  'UTR' => $transactionData['utr'] ?? 'N/A',
                                  'Transaction Status' => $transactionData['txn_status'] ?? 'N/A',
                                  'Account Number' => $transactionData['account_number'] ?? 'N/A',
                                  'Customer Charge' => $transactionData['customercharge'] ?? 'N/A',
                                  'GST' => $transactionData['gst'] ?? 'N/A',
                                  'TDS' => $transactionData['tds'] ?? 'N/A',
                                  'Net Commission' => $transactionData['netcommission'] ?? 'N/A',
                                  'Remitter' => $transactionData['remitter'] ?? 'N/A',
                                  'PaySprint Share' => $transactionData['paysprint_share'] ?? 'N/A'
                            ] as $label => $value)
                                <li class="list-group-item">
                                    <strong>{{ $label }}:</strong> {{ $value }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Print PDF Button -->
                <div class="text-center mt-4">
                    <button class="btn btn-primary" id="printPdfBtn">Download</button>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-warning">No transaction details available.</div>
    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('printPdfBtn').addEventListener('click', async function () {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            // Transaction Data
            const transactionData = @json($transactionData); // PHP data passed to JS
            const title = "CodeGraphi Transaction Slip";
            const transactionDate =new Date().toLocaleDateString('en-GB', {
    day: 'numeric',
    month: 'short',
    year: 'numeric'
});


            // Fields to include in the PDF
            const fields = [
                { label: "Transaction Amount", value: transactionData['txn_amount'] ?? 'N/A' },
                { label: "Beneficiary Name", value: transactionData['benename'] ?? 'N/A' },
                { label: "Remarks", value: transactionData['remarks'] ?? 'N/A' },
                { label: "ACK Number", value: transactionData['ackno'] ?? 'N/A' },
                { label: "Balance", value: transactionData['balance'] ?? 'N/A' },
            ];

            // Logo Image URL (replace with your actual logo path)
            const logoUrl = "{{ asset('assets/img/icons/abhipay.png') }}"; // Assuming the logo is in the 'public/images' directory

            try {
                // Add Logo to the PDF
                const logoWidth = 40; // Width of the logo
                const logoHeight = 40; // Height of the logo
                doc.addImage(logoUrl, 'PNG', 14, 10, logoWidth, logoHeight);

                // Add Title
                doc.setFontSize(16);
                doc.text(title, 105, 20, null, null, "center");

                // Add Transaction Date
                doc.setFontSize(12);
                doc.text(`Transaction Date: ${transactionDate}`, 14, 50);

                // Draw transaction details
                let yPosition = 70;
                fields.forEach(({ label, value }) => {
                    doc.text(`${label}:`, 14, yPosition);
                    doc.text(value, 80, yPosition);
                    yPosition += 10;

                    // Handle page overflow
                    if (yPosition > 280) {
                        doc.addPage();
                        yPosition = 20;
                    }
                });

                // Save the PDF
                doc.save("transaction_slip.pdf");
            } catch (error) {
                console.error("Error generating PDF:", error);
                alert("Failed to generate the PDF. Please try again.");
            }
        });
    });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

@endsection
