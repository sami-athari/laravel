@extends('layouts.app')

@section('content')
<style>
    /* Hero Section */
    .hero {
        background: url('{{ asset('storage/images/hero.png') }}') no-repeat center center;
        background-size: cover;
        height: 400px;
        display: flex;
        justify-content: center;
        align-items: center;
        color: blue;
        text-align: center;
        border-radius: 8px;
        margin-bottom: 30px;
    }

    .hero h1 {
        font-size: 3rem;
        font-weight: bold;
    }

    .hero p {
        font-size: 1.25rem;
        margin-top: 10px;
    }

    .product-card {
        display: flex;
        align-items: start;
        padding: 16px;
        width: 100%;
        max-width: 256px;
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        flex-direction: column;
        cursor: pointer;
        transition: transform 0.3s ease;
    }

    .product-card:hover {
        transform: translateY(-10px);
    }

    .product-image {
        width: 100%;
        height: 150px;
        margin-bottom: 12px;
        border-radius: 8px;
        object-fit: cover;
    }

    .product-name {
        font-size: 1.125rem;
        font-weight: bold;
        margin: 0;
    }

    .product-category {
        font-size: 0.875rem;
        font-weight: 600;
        color: #4b5563;
    }

    .price-current {
        color: #16a34a;
        font-weight: bold;
    }

    .price-old {
        color: #9ca3af;
        text-decoration: line-through;
        font-size: 0.875rem;
    }

    .grid-container {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 24px;
        justify-items: center;
    }

    @media (max-width: 1280px) {
        .grid-container {
            grid-template-columns: repeat(4, 1fr);
        }
    }

    @media (max-width: 1024px) {
        .grid-container {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 768px) {
        .grid-container {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 480px) {
        .grid-container {
            grid-template-columns: 1fr;
        }
    }

    /* Pagination */
    .pagination {
        display: flex;
        justify-content: center;
        gap: 8px;
        margin-top: 24px;
    }

    .pagination a {
        padding: 8px 16px;
        background-color: #4caf50;
        color: white;
        text-decoration: none;
        border-radius: 4px;
        font-weight: bold;
    }

    .pagination a:hover {
        background-color: #45a049;
    }

    .pagination .disabled {
        background-color: #e5e5e5;
        color: #9e9e9e;
    }

    .pagination .active {
        background-color: #3e8e41;
        color: white;
    }
</style>

<div class="container mx-auto p-6">

    <!-- Hero Section -->
    <div class="hero">
        
    </div>

    <h2 class="text-2xl font-bold mb-6">Daftar Produk</h2>

    <div class="grid-container">
        @foreach ($products as $product)
        <a href="{{ route('user.product', $product->id) }}" class="product-card">
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="product-image">

            <div>
                <h2 class="product-category">{{ $product->category }}</h2>
                <p class="product-name">{{ $product->name }}</p>
                <div class="flex items-center gap-2 my-2">
                    @if($product->discount)
                    <span class="price-current">
                        ${{ number_format($product->price - ($product->price * $product->discount / 100), 2) }}
                    </span>
                    <span class="price-old">
                        ${{ number_format($product->price, 2) }}
                    </span>
                    @else
                    <span class="price-current">${{ number_format($product->price, 2) }}</span>
                    @endif
                </div>
            </div>
        </a>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="pagination">
        {{ $products->links() }}
    </div>
</div>

@endsection
