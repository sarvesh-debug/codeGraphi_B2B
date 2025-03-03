@extends('user/include.layout')

@section('content')
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8fafc;
        }
        .container {
            max-width: 500px;
            margin: 3rem auto;
            padding: 2rem;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            font-size: 1.75rem;
            font-weight: 700;
            text-align: center;
            color: #4a5568;
            margin-bottom: 1.5rem;
        }
    </style>

    <script>
        // Automatically get the latitude and longitude
        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition((position) => {
                    document.getElementById('latitude').value = position.coords.latitude;
                    document.getElementById('longitude').value = position.coords.longitude;
                });
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        }
    </script>

    <body onload="getLocation()">
        @include('user.account-verification.navbar')
        <div class="container">
            
            <h1>Verify Bank Account</h1>
            <form action="{{ route('verify.bank') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" name="name" id="name" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="accountNumber">Account Number:</label>
                    <input type="text" name="accountNumber" id="accountNumber" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="bankIfsc">Bank IFSC:</label>
                    <input type="text" name="bankIfsc" id="bankIfsc" class="form-control" required>
                </div>

                {{-- <div class="form-group">
                    <label for="beneBank">Beneficiary Bank:</label>
                    <input type="text" name="beneBank" id="beneBank" class="form-control">
                </div> --}}

                    <input type="text" name="latitude" id="latitude" class="form-control" hidden readonly required>
         
                    <input type="text" name="longitude" id="longitude" class="form-control" hidden readonly required>
          

                <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-block mt-3">
                        Verify Bank Account
                    </button>
                </div>
            </form>
        </div>

<!-- Display API response if it exists -->
@if(isset($response))
<div class="card p-4 mt-4">
    <h4 class="text-center mb-3">Verification Response</h4>
    <div class="table-responsive">
        <table class="table table-bordered">
            <tbody>
                @foreach ($response as $key => $value)
                    <tr>
                        <th>{{ ucfirst($key) }}</th>
                        <td>{{ is_array($value) ? json_encode($value) : $value }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif
</div>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    </body>
@endsection
