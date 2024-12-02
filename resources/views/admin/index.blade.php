@extends('layouts.adminapp')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-5 text-primary">Admin Dashboard</h1>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('admin.create') }}" class="btn btn-success btn-lg px-4 py-2">Tambah Produk</a>

            
    </div>

    <div class="table-responsive shadow-lg rounded-lg bg-white">
        <table class="table table-hover table-bordered table-striped">
            <thead class="thead-light">
                <tr class="text-center">
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                <tr>
                    <td class="align-middle">{{ $product->name }}</td>
                    <td class="align-middle">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                    <td class="align-middle">{{ $product->stock }}</td>
                    <td class="align-middle text-center">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" width="100" class="rounded-lg shadow-sm">
                    </td>
                    <td class="align-middle text-center">
                        <a href="{{ route('admin.edit', $product->id) }}" class="btn btn-warning btn-sm px-3 py-2 mb-1">Edit</a>
                        <form action="{{ route('admin.destroy', $product->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm px-3 py-2 mb-1">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-4">Tidak ada produk ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('styles')
    <style>
        /* Global Styling */
        body {
            background-color: #f8f9fa;
            color: #343a40;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .container {
            padding: 30px;
            max-width: 1200px;
        }

        h1 {
            font-size: 36px;
            font-weight: 600;
        }

        /* Table Styling */
        .table {
            border-collapse: collapse;
            width: 100%;
        }

        .table th,
        .table td {
            padding: 15px;
            text-align: left;
        }

        .table-hover tbody tr:hover {
            background-color: #f1f1f1;
            cursor: pointer;
        }

        .thead-light th {
            background-color: #007bff;
            color: white;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid #ddd;
        }

        /* Button Styling */
        .btn {
            font-weight: 600;
            border-radius: 5px;
            padding: 10px 20px;
        }

        .btn:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }

        .btn-lg {
            font-size: 1.2rem;
        }

        .btn-sm {
            font-size: 0.9rem;
        }

        .btn-info,
        .btn-success {
            transition: background-color 0.3s ease;
        }

        .btn-info:hover {
            background-color: #17a2b8;
        }

        .btn-success:hover {
            background-color: #218838;
        }

        .btn-warning {
            background-color: #f0ad4e;
            border-color: #f0ad4e;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .btn-warning:hover {
            background-color: #e08e32;
        }

        .btn-danger:hover {
            background-color: #c82333;
        }

        /* Responsive Styling */
        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }

            h1 {
                font-size: 28px;
            }

            .btn {
                width: 100%;
                margin-bottom: 10px;
            }

            .d-flex {
                flex-direction: column;
            }

            .table-responsive {
                overflow-x: auto;
            }
        }
    </style>
@endsection
