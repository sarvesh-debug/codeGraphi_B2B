<!DOCTYPE html>
<html>
<head>
    <title>KYC Status</title>
</head>
<body>
    <script>
        alert("Your KYC is pending.");
        window.location.href = "{{ url()->previous() }}"; // Redirect back to the previous page
    </script>
</body>
</html>
