@extends('layouts.adminapp')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-5 text-primary">Edit Product</h1>

    <div class="card shadow-lg rounded-lg p-4">
        <form action="{{ route('admin.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group mb-4">
                <label for="name" class="font-weight-bold">Product Name</label>
                <input type="text" name="name" id="name" class="form-control form-control-lg" value="{{ $product->name }}" required>
            </div>

            <div class="form-group mb-4">
                <label for="price" class="font-weight-bold">Price</label>
                <input type="number" name="price" id="price" class="form-control form-control-lg" value="{{ $product->price }}" required>
            </div>

            <div class="form-group mb-4">
                <label for="image" class="font-weight-bold">Image</label>
                <input type="file" name="image" id="image" class="form-control-file">
                <small class="form-text text-muted">Upload a new image or leave it empty to keep the current one.</small>
            </div>

            <div class="form-group mb-4">
                <label for="stock" class="font-weight-bold">Stock</label>
                <input type="number" name="stock" id="stock" class="form-control form-control-lg" value="{{ $product->stock }}" required min="0">
            </div>

            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-success btn-lg px-4 py-2">Update Product</button>
                <a href="{{ route('admin.index') }}" class="btn btn-secondary btn-lg px-4 py-2">Cancel</a>
            </div>
        </form>
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
            max-width: 900px;
        }

        h1 {
            font-size: 36px;
            font-weight: 600;
        }

        .card {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Form Styling */
        .form-group {
            margin-bottom: 25px;
        }

        label {
            font-size: 1.1rem;
            font-weight: bold;
        }

        .form-control,
        .form-control-file {
            font-size: 1rem;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        .form-text {
            font-size: 0.9rem;
        }

        .btn {
            font-weight: 600;
            border-radius: 5px;
            padding: 12px 25px;
        }

        .btn:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }

        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }

        .btn-success:hover {
            background-color: #218838;
        }

        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        /* Responsive Styling */
        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }

            h1 {
                font-size: 28px;
            }

            .form-group {
                margin-bottom: 15px;
            }

            .btn {
                width: 100%;
                margin-bottom: 10px;
            }
        }
    </style>
@endsection
