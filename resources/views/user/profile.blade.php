@extends('layouts.app')

@section('content')
    <style>
        body {
            background-color: #f0f4f8;
            color: #333333;
            font-family: 'Arial', sans-serif;
        }

        .container {
            display: flex;
            gap: 20px;
            flex-direction: row;
        }

        .profile-image-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
            width: 40%;
            text-align: center;
        }

        .profile-image-container img {
            width: 100%;
            max-width: 200px;
            border-radius: 12px;
            object-fit: cover;
            border: 2px solid #ccc;
        }

        .profile-image-container button {
            padding: 12px 30px;
            background-color: #007bff;
            color: white;
            border: 1px solid #007bff;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: all 0.3s ease;
            width: 50%;
            margin-top: 10px;
        }

        .profile-image-container button:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .info-container {
            display: flex;
            flex-direction: column;
            gap: 30px;
            width: 60%;
        }

        .info-container h2 {
            font-size: 28px;
            border-bottom: 2px solid #007bff;
            padding-bottom: 8px;
            margin-bottom: 15px;
            color: #007bff;
        }

        .info-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 16px;
            color: #555555;
        }

        .info-section span {
            font-weight: bold;
            color: #333333;
        }

        .edit-link {
            color: #007bff;
            font-weight: bold;
            font-size: 14px;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .edit-link:hover {
            color: #0056b3;
        }

        .verified-badge {
            display: inline-block;
            padding: 5px 12px;
            background-color: #007bff;
            color: white;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }

        .divider {
            height: 1px;
            background-color: #ddd;
            margin: 20px 0;
        }

        /* Logout Button Styling */
        .logout-button {
            background-color: #dc3545;
            color: white;
            padding: 12px 30px;
            border: 1px solid #dc3545;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: background-color 0.3s ease, border-color 0.3s ease;
            margin-top: 20px;
        }

        .logout-button:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }

        /* Responsiveness */
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                padding: 15px;
            }

            .profile-image-container button,
            .logout-button {
                width: 70%;
            }

            .info-container h2 {
                font-size: 24px;
            }

            .info-section {
                flex-direction: column;
                gap: 10px;
                align-items: flex-start;
            }

            .edit-link {
                margin-top: 10px;
            }
        }
    </style>





<div class="container">
    <!-- Profile Image Section -->
    <div class="profile-image-container">
        <img src="{{ asset('storage/profile_images/' . $user->profile_image) }}" alt="Profile Image">
        <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="file" name="profile_image" accept="image/*" style="margin-top: 10px;">
            <button type="submit">Simpan Foto</button>
        </form>
        <small>Besar file: maksimum 10 MB. Ekstensi file yang diperbolehkan: JPG, JPEG, PNG</small>
    </div>

    <!-- Info Section -->
    <div class="info-container">
        <h2>Ubah Biodata Diri</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <!-- Name Section -->
        <div class="info-section">
            <label>Nama</label>
            <span>{{ $user->name }}</span>
            <form action="{{ route('user.profile.update') }}" method="POST" style="display: inline;">
                @csrf
                @method('PUT')
                <input type="text" name="name" value="{{ $user->name }}" class="form-input" required>
                <button type="submit" class="edit-link">Ubah</button>
            </form>
        </div>

        <!-- Birthdate Section -->
        <div class="info-section">
            <label>Tanggal Lahir</label>
            <span>{{ $user->dob }}</span>
            <form action="{{ route('user.profile.update') }}" method="POST" style="display: inline;">
                @csrf
                @method('PUT')
                <input type="date" name="dob" value="{{ $user->dob }}" class="form-input" required>
                <button type="submit" class="edit-link">Ubah Tanggal Lahir</button>
            </form>
        </div>

        <!-- Gender Section -->
        <div class="info-section">
            <label>Jenis Kelamin</label>
            <span>{{ $user->gender }}</span>
            <form action="{{ route('user.profile.update') }}" method="POST" style="display: inline;">
                @csrf
                @method('PUT')
                <select name="gender" class="form-input" required>
                    <option value="male" {{ $user->gender == 'male' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="female" {{ $user->gender == 'female' ? 'selected' : '' }}>Perempuan</option>
                    <option value="other" {{ $user->gender == 'other' ? 'selected' : '' }}>Lainnya</option>
                </select>
                <button type="submit" class="edit-link">Ubah Jenis Kelamin</button>
            </form>
        </div>

        <div class="divider"></div>

        <h2>Ubah Kontak</h2>

        <!-- Email Section -->
        <div class="info-section">
            <label>Email</label>
            <span>{{ $user->email }}</span>

            <form action="{{ route('user.profile.update') }}" method="POST" style="display: inline;">
                @csrf
                @method('PUT')
                <input type="email" name="email" value="{{ $user->email }}" class="form-input" required>
                <button type="submit" class="edit-link">Ubah</button>
            </form>
        </div>

        <!-- Logout Button -->
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-button">Logout</button>
        </form>
    </div>
</div>



@endsection
