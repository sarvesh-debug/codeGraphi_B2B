@extends('user/include.layout')
@section('content')
@include('user.bbps.navbar')

<div class="container mt-5">
    <h2 class="mb-4 text-center">Recharge & Bill Pay3</h2>

    <div class="mb-4">
        <input type="text" id="searchBox" class="form-control" placeholder="Search for categories...">
    </div>

    <div class="row" id="categoryContainer">
        @forelse($categories as $category)
        <div class="col-lg-2 col-md-3 mb-4 category-card">
            <a href="{{ route('getbillers', ['key' => $category['categoryKey']]) }}" class="card shadow-sm text-decoration-none">
                <div class="card-body text-center">
                    <img 
                        src="{{ $category['iconUrl'] ?? 'https://via.placeholder.com/150' }}" 
                        class="img-fluid rounded-circle mb-3" 
                        alt="{{ $category['categoryName'] ?? 'Category Icon' }}" 
                        style="width: 60px; height: 60px; object-fit: contain;">
                    <h6 class="card-title font-weight-bold">{{ $category['categoryName'] ?? 'N/A' }}</h6>
                </div>
            </a>
        </div>
        @empty
        <div class="col-12">
            <p class="text-center text-danger">No categories found.</p>
        </div>
        @endforelse
    </div>
</div>

<script>
    document.getElementById('searchBox').addEventListener('input', function() {
        const searchValue = this.value.toLowerCase();
        const categoryCards = document.querySelectorAll('.category-card');

        categoryCards.forEach(card => {
            const categoryName = card.querySelector('h6').textContent.toLowerCase();
            if (categoryName.includes(searchValue)) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
    });
</script>
@endsection
