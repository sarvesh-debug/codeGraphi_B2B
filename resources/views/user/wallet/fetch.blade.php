@extends('user/include.layout')

@section('content')
   <!-- Check if there are any errors -->
   @if($errors->any())
   <div class="alert alert-danger">
       <ul>
           @foreach ($errors->all() as $error)
               <li>{{ $error }}</li>
           @endforeach
       </ul>
   </div>
@endif

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="card shadow-lg rounded border-0">
                <img src="https://media.istockphoto.com/id/1327592506/vector/default-avatar-photo-placeholder-icon-grey-profile-picture-business-man.jpg?s=612x612&w=0&k=20&c=BpR0FVaEa5F24GIw7K8nMWiiGmbb8qmhfkpXcp1dhQg=" alt="Profile Picture" class="card-img-top rounded-circle mx-auto mt-3" style="width: 120px; height: 120px;">
                <div class="card-body">
                    <h5 class="card-title text-center">{{ $user->name }}</h5>
                    <p class="text-center text-muted">{{ $user->role }}</p>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <strong>User Id:</strong> {{ $user->username }}
                        </li>
                        <li class="list-group-item">
                            <strong>Email:</strong> <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                        </li>
                        <li class="list-group-item">
                            <strong>Phone:</strong> <a href="tel:{{ $user->phone }}">{{ $user->phone }}</a>
                        </li>
                        {{-- <li class="list-group-item">
                            <strong>PIN:</strong> {{ $user->pin }}
                        </li>
                        <li class="list-group-item">
                            <strong>Balance:</strong> ₹{{ $user->balance }}
                        </li> --}}
                    </ul>
                    <form action="{{route('wallet.send')}}" method="post">
                        @csrf
                        
                         <!-- mobile Nmber -->
                         <div class="mb-3">
                            <label for="remarkInput" class="form-label">Transfer</label>
                            <input type="text" class="form-control" id="amount" name="amount" required />
                        </div>
                        <div class="mb-3">
                            <label for="remark" class="form-label">Remark</label>
                            <input type="text" class="form-control" id="remark" name="remark" required>
                        </div>
                        <input type="text" hidden  name="reciver" value="{{ $user->username }}">
                        <input type="text" hidden  name="sender" value="{{session('username')}}">
                        
                        <!-- Submit Button -->
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                    </form>
                    {{-- <div class="text-center mt-3">
                        <a href="#" class="btn btn-primary">Edit Profile</a>
                    </div> --}}
                </div>
                <div class="card-footer text-center">
                    <small class="text-muted">Account Created: {{ \Carbon\Carbon::parse($user->created_at)->format('d M Y') }}</small>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection