@extends('layouts.app')

@section('content')
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333333;
            margin: 0;
            padding: 0;
        }

        .cart-container {
            max-width: 1200px;
            margin: 20px auto;
            display: flex;
            gap: 20px;
        }

        .cart-items-container {
            flex: 3;
            background-color: #ffffff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .checkout-container {
            flex: 1;
            background-color: #ffffff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .cart-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #333333;
        }

        .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #ddd;
        }

        .cart-item:last-child {
            border-bottom: none;
        }

        .item-details {
            display: flex;
            align-items: center;
        }

        .item-image {
            width: 70px;
            height: 70px;
            margin-right: 15px;
            border-radius: 8px;
            object-fit: cover;
        }

        .item-info h4 {
            margin: 0;
            color: #333333;
        }

        .item-quantity {
            margin-top: 10px;
        }

        .quantity-input {
            width: 50px;
            padding: 5px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .item-actions {
            display: flex;
            gap: 10px;
        }

        .action-button {
            padding: 5px 10px;
            background-color: #dc3545;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }

        .action-button i {
            font-size: 16px;
        }

        .action-button:hover {
            background-color: #c82333;
        }

        .checkout-summary {
            font-size: 18px;
            margin-bottom: 20px;
            color: #333333;
        }

        .checkout-button {
            width: 100%;
            background-color: #007bff;
            color: #ffffff;
            padding: 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 18px;
            transition: background-color 0.3s ease;
        }

        .checkout-button:disabled {
            background-color: #cccccc;
            cursor: not-allowed;
        }

        .checkout-button:hover:enabled {
            background-color: #0056b3;
        }

        .checkbox {
            margin-right: 10px;
        }
    </style>

<div class="cart-container">
    <!-- Daftar Barang -->
    <div class="cart-items-container">
        <h2 class="cart-title">Keranjang</h2>

        <!-- Checkbox Pilih Semua -->
        <div class="cart-item">
            <input type="checkbox" id="select-all-checkbox" class="checkbox">
            <label for="select-all-checkbox">Pilih Semua</label>
        </div>

        <!-- Barang dalam keranjang -->
        @foreach($cartItems as $item)
            <div class="cart-item" data-price="{{ $item->product->price }}">
                <div class="item-details">
                    <input type="checkbox" class="item-checkbox checkbox" name="selected_items[]" value="{{ $item->id }}">
                    <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="item-image">
                    <div class="item-info">
                        <h4>{{ $item->product->name }}</h4>
                        <p>Rp{{ number_format($item->product->price, 0, ',', '.') }}</p>
                        <div class="item-quantity">
                            <label for="quantity-{{ $item->id }}">Jumlah:</label>
                            <input type="number" id="quantity-{{ $item->id }}" class="quantity-input" name="quantities[{{ $item->id }}]" value="{{ $item->quantity }}" min="1">
                        </div>
                    </div>
                </div>
                <div class="item-actions">
                    <form action="{{ route('user.cart.remove', $item->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="action-button">
                            <i class="fa fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Ringkasan Belanja -->
    <div class="checkout-container">
        <div class="checkout-summary">
            <p>Total Belanja:</p>
            <h3 id="total-price">Rp0</h3>
        </div>
        <form action="{{ route('user.cart.checkout') }}" method="POST" id="checkout-form">
            @csrf
            <button type="submit" class="checkout-button" id="checkout-button" disabled>
                Checkout
            </button>
        </form>
    </div>
</div>

<script>
    // Ambil elemen yang diperlukan
    const selectAllCheckbox = document.getElementById('select-all-checkbox');
    const itemCheckboxes = document.querySelectorAll('.item-checkbox');
    const totalPriceElement = document.getElementById('total-price');
    const checkoutButton = document.getElementById('checkout-button');
    const quantities = document.querySelectorAll('.quantity-input');

    // Fungsi untuk menghitung total harga
    const calculateTotalPrice = () => {
        let totalPrice = 0;
        itemCheckboxes.forEach(checkbox => {
            if (checkbox.checked) {
                const item = checkbox.closest('.cart-item');
                const itemPrice = parseFloat(item.dataset.price);
                const quantity = parseInt(item.querySelector('.quantity-input').value) || 1;
                totalPrice += itemPrice * quantity;
            }
        });
        totalPriceElement.textContent = `Rp${totalPrice.toLocaleString('id-ID')}`;
    };

    // Fungsi untuk mengaktifkan atau menonaktifkan tombol checkout
    const toggleCheckoutButton = () => {
        const isAnyChecked = Array.from(itemCheckboxes).some(checkbox => checkbox.checked);
        checkoutButton.disabled = !isAnyChecked;
    };

    // Event listener untuk checkbox "Pilih Semua"
    selectAllCheckbox.addEventListener('change', () => {
        const isChecked = selectAllCheckbox.checked;
        itemCheckboxes.forEach(checkbox => (checkbox.checked = isChecked));
        calculateTotalPrice();
        toggleCheckoutButton();
    });

    // Event listener untuk setiap checkbox item
    itemCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', () => {
            calculateTotalPrice();
            toggleCheckoutButton();

            // Jika ada yang tidak dicentang, "Pilih Semua" harus dinonaktifkan
            if (!checkbox.checked) {
                selectAllCheckbox.checked = false;
            }
        });
    });

    // Event listener untuk input jumlah
    quantities.forEach(quantity => {
        quantity.addEventListener('change', calculateTotalPrice);
    });

    // Panggil fungsi saat halaman dimuat untuk memeriksa status awal
    calculateTotalPrice();
    toggleCheckoutButton();
</script>
@endsection
