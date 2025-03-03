@extends('user/include.layout')

@section('content')
    <style>
        .profile-card {
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
            background-color: #f8f9fa;
            border-radius: 15px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
        .profile-header {
            display: flex;
            gap: 1rem;
            align-items: center;
            flex-wrap: wrap; /* Ensures items wrap on smaller screens */
            text-align: left;
            justify-content: left;
        }
        .profile-header img {
            height: 100px;
            width: 100px;
            border-radius: 50%;
        }
        .info-table {
            margin-top: 1.5rem;
            font-size: 14px; /* Adjust font size for mobile */
        }
        .info-table th, .info-table td {
            display: block;
            width: 100%;
            text-align: left;
        }
        @media (min-width: 576px) {
            .info-table th, .info-table td {
                display: table-cell;
                width: auto;
                text-align: left;
            }
        }
        .document-img {
            width: 100%; /* Full width on mobile */
            height: auto; /* Maintain aspect ratio */
            max-width: 250px;
            max-height: 150px;
            object-fit: cover;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
        .document-section {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
        .document-item {
            flex: 1 1 45%;
            text-align: center;
            padding: 5px;
        }
        @media (max-width: 576px) {
            .document-item {
                flex: 1 1 100%;
            }
        }
    </style>

    <div class="container">
        <div class="profile-card">
            <div class="profile-header">
                <img src="{{ $profile->aadhar_front }}" alt="Profile Picture">
                <div>
                    <h3>{{ $profile->name }} ({{ $profile->username }})</h3>
                    <p>Role: {{ $profile->role }}</p>
                    <p>Status: <span class="badge bg-{{ $profile->status == 'active' ? 'success' : 'danger' }}">{{ ucfirst($profile->status) }}</span></p>
                </div>
            </div>
            <table class="table info-table">
                <tr>
                    <th>Email</th>
                    <td>{{ $profile->email }}</td>
                </tr>
                <tr>
                    <th>Phone</th>
                    <td>{{ $profile->phone }}</td>
                </tr>
                <tr>
                    <th>Distributor Phone</th>
                    <td>{{ $profile->dis_phone }}</td>
                </tr>
                <tr>
                    <th>City</th>
                    <td>{{ $profile->city }}</td>
                </tr>
                <tr>
                    <th>State</th>
                    <td>{{ $profile->state }}</td>
                </tr>
                <tr>
                    <th>Bank Name</th>
                    <td>{{ $profile->bank_name }}</td>
                </tr>
                <tr>
                    <th>Account No</th>
                    <td>{{ $profile->account_no }}</td>
                </tr>
                <tr>
                    <th>IFSC Code</th>
                    <td>{{ $profile->ifsc_code }}</td>
                </tr>
                <tr>
                    <th>Aadhar Number</th>
                    <td>{{ $profile->aadhar_no }}</td>
                </tr>
            </table>
            <div class="text-center mt-4">
                <h5 class="text-center">Documents</h5>
                <div class="document-section">
                    <div class="document-item">
                        <img src="{{ $profile->aadhar_front }}" alt="Aadhar Front" class="img-fluid document-img">
                        <p>Aadhar Front</p>
                    </div>
                    <div class="document-item">
                        <img src="{{ $profile->aadhar_back }}" alt="Aadhar Back" class="img-fluid document-img">
                        <p>Aadhar Back</p>
                    </div>
                    <div class="document-item">
                        <img src="{{ $profile->pan_image }}" alt="PAN Image" class="img-fluid document-img">
                        <p>PAN Image</p>
                    </div>
                    <div class="document-item">
                        <img src="{{ $profile->bank_document }}" alt="Bank Document" class="img-fluid document-img">
                        <p>Bank Document</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
