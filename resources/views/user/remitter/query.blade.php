@extends('user/include.layout')

@section('content')


<style>
    .form-container {
        max-width: 600px;
        margin: 20px auto;
        padding: 30px;
        background: #f8f9fa;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .form-title {
        font-size: 1.8rem;
        font-weight: bold;
        color: #333;
        text-align: center;
        margin-bottom: 20px;
    }

    .form-group label {
        font-weight: bold;
        color: #555;
    }

    .form-control {
        border-radius: 5px;
        border: 1px solid #ced4da;
        padding: 10px;
    }

    .btn-submit {
        background-color: #007bff;
        color: #fff;
        font-size: 1rem;
        padding: 10px 20px;
        border-radius: 5px;
        transition: background-color 0.3s;
    }

    .btn-submit:hover {
        background-color: #0056b3;
    }
</style>

<div class="container form-container">
    <div class="form-title">Remitter Query Form</div>
    <form action="{{ route('remitter.query') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="mobile">Mobile Number</label>
            <input type="text" class="form-control" name="mobile" placeholder="Enter Mobile Number" required>
        </div>
{{--         
        <div class="form-group">
            <label for="bank3_flag">Bank 3 Flag</label>
            <select class="form-control" name="bank3_flag" required>
                <option value="YES">Yes</option>
                <option value="NO" selected>No</option>
            </select>
        </div>

        <div class="form-group">
            <label for="bank4_flag">Bank 4 Flag</label>
            <select class="form-control" name="bank4_flag" required>
                <option value="YES">Yes</option>
                <option value="NO" selected>No</option>
            </select>
        </div>

        <div class="form-group">
            <label for="merchantcode">Merchant Code</label>
            <input type="text" class="form-control" name="merchantcode" placeholder="Enter Merchant Code (optional)">
        </div> --}}

        <button type="submit" class="btn btn-submit btn-block">Submit Query</button>
    </form>
</div>

@endsection
