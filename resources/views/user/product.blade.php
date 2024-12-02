@extends('layouts.app')

@section('content')
<!-- Styling for the image and layout -->
<style>
    .product-image {
        width: 100%;
        height: auto;
        object-fit: cover;
        border-radius: 8px;
        border: 4px solid #e5e7eb; /* Larger border for image */
    }

    .product-detail-card {
        max-width: 100%;
        margin: 0 auto;
        background: white;
        padding: 32px;
        border-radius: 16px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    /* Layout Grid */
    .product-detail-card .grid {
        display: grid;
        grid-template-columns: 1fr 3fr 1fr; /* Adjusted column sizes for larger content */
        gap: 32px;
    }

    /* Product Image Section */
    .product-image-container {
        border: 4px solid #e5e7eb; /* Border around image */
        padding: 16px;
        border-radius: 12px;
    }

    /* Product Info Section */
    .product-info-container {
        border: 4px solid #e5e7eb; /* Border around the description */
        padding: 16px;
        border-radius: 12px;
    }

    /* Price Section */
    .price-section {
        display: flex;
        gap: 16px;
        font-size: 1.5rem; /* Increased font size */
    }

    .price-section .discount {
        color: #16a34a; /* Green 600 */
        font-weight: bold;
    }

    .price-section .old-price {
        color: #9ca3af; /* Gray 400 */
        text-decoration: line-through;
        font-size: 1rem; /* Slightly smaller font for old price */
    }

    /* Add to Cart Section */
    .add-to-cart-form {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 16px;
        border: 4px solid #e5e7eb; /* Border around checkout */
        padding: 16px;
        border-radius: 12px;
    }

    .add-to-cart-form input {
        width: 80px; /* Larger input box */
        padding: 10px;
        border: 1px solid #d1d5db; /* Gray 300 */
        border-radius: 8px;
        text-align: center;
    }

    .add-to-cart-form button {
        background-color: #16a34a; /* Green 600 */
        color: white;
        justify-content: center;
        display: flex;
        padding: 10px 1px;
        border-radius: 8px;
        font-size: 1rem; /* Larger font size */
        transition: background-color 0.2s;
    }

    .add-to-cart-form button:hover {
        background-color: #15803d; /* Green 700 */
    }

    /* Buy Now Button */
    .buy-now-button {
        background-color: #2563eb; /* Blue 600 */
        color: white;
        font-size: 1rem;
        padding: 10px 1px;
        border-radius: 8px;
        transition: background-color 0.2s;
        width: 100%;
        margin-top: 16px;
    }

    .buy-now-button:hover {
        background-color: #1d4ed8; /* Blue 700 */
    }
</style>

<div class="container mx-auto p-6">
    <!-- Product Detail Card -->
    <div class="product-detail-card">
        <!-- Grid Layout for Image, Product Info, and Add to Cart -->
        <div class="grid">

            <!-- Product Image Section (Left-Aligned, with Border) -->
            <div class="product-image-container flex justify-center items-center">
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="product-image">
            </div>

            <!-- Product Info and Description Section (Centered, with Border) -->
            <div class="product-info-container text-left">
                <h2 class="text-4xl font-bold text-gray-800 mb-4">{{ $product->name }}</h2>
                <p class="text-xl text-gray-600 mb-4">{{ $product->category }}</p>
                <p class="text-gray-700 text-lg mb-6">{{ $product->description }}</p>

                <!-- Price Section -->
                <div class="price-section mb-6">
                    @if($product->discount)
                    <span class="discount">
                        ${{ number_format($product->price - ($product->price * $product->discount / 100), 2) }}
                    </span>
                    <span class="old-price">
                        ${{ number_format($product->price, 2) }}
                    </span>
                    @else
                    <span class="discount">${{ number_format($product->price, 2) }}</span>
                    @endif
                </div>
            </div>

            <!-- Add to Cart Section (Right-Aligned, with Border) -->
            <div class="add-to-cart-form flex justify-center items-center gap-4">
                <!-- Add to Cart Form -->
                <form action="{{ route('user.cart.add', $product->id) }}" method="POST">
                    @csrf
                    <input type="number" name="quantity" value="1" min="1" max="99" class="w-16 p-2 border border-gray-300 rounded-md text-center">
                    <button type="submit">Add to Cart</button>
                </form>

                <!-- Buy Now Form -->
                <form action="{{ route('user.cart.checkout') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" class="buy-now-button">Buy Now</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
