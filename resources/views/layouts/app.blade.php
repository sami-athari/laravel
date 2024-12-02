<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PlazaBox</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome CDN -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@700&display=swap" rel="stylesheet">
    <style>
        body {

            font-family: Arial, sans-serif;
        }

        /* Navbar Styling */
        .navbar {
            display:flex;
            justify-content: flex-start;
    position: sticky; /* Membuat navbar absolut */
    top: 0;
    left: 0;
    right: 0;
    z-index: 1030; /* Supaya tetap di atas konten lain */
    background-color: rgba(255, 255, 255, 0.8); /* Transparansi */
    border-bottom: 1px solid #dcdcdc; /* Garis tipis di bawah navbar */
    backdrop-filter: blur(5px); /* Efek blur untuk transparansi */
}


        .navbar .navbar-brand {
            display:flex
            justify-content: flex-start;
            font-family: 'Poppins', sans-serif; /* Gunakan font untuk PlazaBox */
            font-weight: bold;
            color: #1E90FF !important; /* Warna biru dengan prioritas tinggi */
            font-size: 24px;
        }

        .navbar .navbar-brand:hover {
            text-decoration: none;
            color: #1E90FF !important; /* Warna tetap saat hover */
        }

        /* Search Bar Styling */
        .form-inline {
            width: 60%; /* Search bar lebih panjang */
            margin: 0 auto; /* Search bar ditengah */
        }

        .form-inline .form-control {
            flex: 1;
            border-radius: 20px;
        }

        .form-inline .btn {
            border-radius: 20px;
        }

        /* Icon Styling */
        .navbar-nav .nav-item .nav-link i,
        .navbar-nav .nav-item .nav-link img {
            font-size: 24px; /* Perbesar ikon */
            width: 36px;
            height: 36px;
        }

        .navbar-nav .nav-item {
            margin-left: 15px;
        }

        /* Responsive Search Icon */
        .icon-search {
            font-size: 24px;
            margin-left: 10px;
            cursor: pointer;
        }

        /* Main Content Area */
        .main-container {
            max-width: 900px;
            margin: 0 auto;
            padding: 80px 20px 20px; /* Give space for the navbar */
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <!-- Logo -->
            <a class="navbar-brand" href="/user">
                PlazaBox
            </a>

            <!-- Search Bar -->
            <form class="form-inline my-2 my-lg-0 mx-auto" action="{{ route('user.search') }}" method="GET" id="search-form">
                <input class="form-control" type="search" name="keyword" placeholder="Cari di PlazaBox" aria-label="Search" value="{{ request('keyword') }}">

            </form>

            <!-- Menu Items -->
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/user/cart" title="Keranjang">
                            <i class="fas fa-shopping-cart"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/user/transactions" title="Transaksi">
                            <i class="fas fa-wallet"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/user/profile" title="Akun">
                            <img src="{{ Auth::user()->profile_image ? asset('storage/profile_images/' . Auth::user()->profile_image) : 'https://www.gravatar.com/avatar/' . md5(strtolower(trim(Auth::user()->email))) . '?d=mp&s=40' }}" alt="Profile" class="rounded-circle">
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Search Icon (Responsive Support) -->
            <a href="#" class="nav-link icon-search d-lg-none" id="search-toggle">
                <i class="fas fa-search"></i>
            </a>
        </div>
    </nav>

    <!-- Main Content Area -->
    <main class="main-container">
        @yield('content')

        <!-- Pagination -->
        @if(isset($products) && $products->hasPages())
            <div class="mt-4">
                {{ $products->links() }} <!-- Menambahkan link pagination -->
            </div>
        @endif
    </main>

    <!-- Bootstrap and FontAwesome -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> <!-- Versi penuh jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.4.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        // Menangani klik pada ikon pencarian untuk submit form
        document.getElementById('search-toggle').addEventListener('click', function(event) {
            event.preventDefault(); // Mencegah aksi default dari <a href="#">
            document.getElementById('search-form').submit(); // Men-submit form pencarian
        });
    </script>
</body>
</html>
