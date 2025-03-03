@php
    $customer = session('customer');
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Banking Point Certificate</title>
  <title>ZPay OTP Verification</title>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

  <style>
    @page {
      size: A4;
      margin: 0;
    }

    body {
      font-family: 'Arial', sans-serif;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: flex-start;
      min-height: 100vh;
      background-color: #f3f4f6;
    }

    .certificate-container {
      width: 90%;
      max-width: 800px;
      padding: 20px;
      border: 8px solid #1d4ed8;
      border-radius: 15px;
      background-color: white;
      box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.15), 0px 0px 20px rgba(0, 0, 0, 0.2);
      position: relative;
      padding-bottom: 80px; /* Space for the download button */
    }

    @media (max-width: 640px) {
      .certificate-container {
        padding: 15px;
        border-width: 3px; /* Reduce border thickness */
      }
      .logo {
        width: 70px;
        height: 70px;
      }
      .heading h1 {
        font-size: 18px; /* Reduce heading size */
      }
      .heading p {
        font-size: 12px;
      }
      .details {
        font-size: 12px;
      }
      .download-btn {
        font-size: 12px;
        padding: 8px 15px;
      }
    }
  </style>
</head>
<body>

<main class="certificate-container text-center mt-4">
  <div class="heading">
    <img src="{{ asset('assets/img/icons/zPay_cer.jpg') }}" alt="Logo" class="logo w-24 h-24 sm:w-20 sm:h-20 mx-auto rounded-lg shadow-md">
    <h1 class="text-xl sm:text-lg md:text-2xl font-bold text-blue-700 uppercase">Authorized Banking Point</h1>
    <p class="text-sm sm:text-xs md:text-base text-gray-600 uppercase">Certificate of Authorization</p>
  </div>

  <div class="details text-sm sm:text-xs md:text-base text-gray-700 mt-4 leading-relaxed">
    <p>This is to certify that</p>
    <p><span class="font-bold text-blue-700">{{ $customer->name }}</span> is an authorized Retailer of <span class="font-bold">ZPay</span>.</p>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
      <div>
        <p>RT No: <span class="font-bold text-blue-700">{{ $customer->username }}</span></p>
      </div>
      <div>
        <p>Mobile No: <span class="font-bold text-blue-700">{{ $customer->phone }}</span></p>
      </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
      <div>
        <p>Shop Name: <span class="font-bold text-blue-700">{{ $customer->owner }}</span></p>
      </div>
      <div>
        <p>Effective From: <span class="font-bold text-blue-700">{{ $customer->created_at->format('Y-m-d') }}</span></p>
      </div>
    </div>
  </div>

  <div class="signature mt-6">
    <hr class="w-24 mx-auto border-t-2 border-blue-700">
    <p class="text-sm sm:text-xs md:text-base font-bold">ZPay</p>
    <p class="text-xs sm:text-[10px] md:text-sm text-gray-600">Chief Sales Officer</p>
  </div>

  <div class="footer mt-4 text-xs sm:text-[10px] text-gray-500">
    <p>*Terms and conditions: The appointment is subject to acceptance of the terms and conditions of ZPay and subject to change. The Banking point shall only function as per terms set out in the service agreement with ZPay.</p>
  </div>
</main>

<!-- Download Button -->
<button id="download-btn" class="download-btn absolute bottom-16 left-1/2 transform -translate-x-1/2 bg-blue-700 text-white px-5 py-2 sm:px-3 sm:py-1 text-sm sm:text-xs rounded-lg shadow-md hover:bg-blue-800">
  Download Certificate as PDF
</button>

<script>
  document.getElementById('download-btn').addEventListener('click', function () {
    const element = document.querySelector('main');
    const options = {
      margin: 0.5,
      filename: '{{ $customer->name }}_Certificate.pdf',
      image: { type: 'jpeg', quality: 0.98 },
      html2canvas: { scale: 2 },
      jsPDF: { unit: 'in', format: 'a4', orientation: 'portrait' }
    };
    html2pdf().set(options).from(element).save();
  });
</script>

</body>
</html>
