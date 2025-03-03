@extends('user/include.layout')
@section('content')
@include('user.bbps.navbar')

<div class="container mt-5">
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active">Biller List</li>
    </ol>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="mb-4">
        <input type="text" id="searchBox" class="form-control" placeholder="Search for billers...">
    </div>

    <div class="row" id="billerContainer">
        @foreach ($billers as $biller)
            <div class="col-md-3 mb-4 biller-card">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center">
                        <img src="{{ $biller['iconUrl'] }}" alt="Biller Icon" class="img-fluid rounded-circle" style="width: 60px; height: 60px;">
                        <h6 class="mt-2 font-weight-bold">{{ $biller['billerName'] }}</h6>
                    </div>
                    <div class="card-footer text-center">
                        <form action="{{ route('bbps.billerDetails') }}" method="POST">
                            @csrf
                            <input type="hidden" name="billerId" value="{{ $biller['billerId'] }}">
                            <button class="btn btn-primary btn-sm">More Info</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<script>
    document.getElementById('searchBox').addEventListener('input', function() {
        const searchValue = this.value.toLowerCase();
        const billerCards = document.querySelectorAll('.biller-card');

        billerCards.forEach(card => {
            const billerName = card.querySelector('h6').textContent.toLowerCase();
            if (billerName.includes(searchValue)) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
    });
</script>
@endsection
