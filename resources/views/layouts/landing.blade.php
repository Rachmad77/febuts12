<!DOCTYPE HTML>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Fakultas Ekonomi dan Bisnis - UTS')</title>

    <link rel="stylesheet" href="{{ asset('assets/compiled/css/style.css') }}">
    <link rel="icon" href="{{ asset('assets/img/uts_logo.png') }}" type="image/png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    @yield('css')
</head>
<body>
    {{-- HEADER --}}
    <header>
        {{-- Bagian atas biru --}}
        <div class="top-header text-white py-2">
            <div class="container d-flex justify-content-between align-items-center">
                <div>
                    <a class="text-white me-3 text-decoration-none align-middle">
                        📧feb@utssurabaya.ac.id
                        {{-- <i class="bi bi-envelope-fill">📧feb@utssurabaya.ac.id</i> --}}
                    </a>
                    <a class="text-white text-decoration-none align-middle">
                        🌐utssurabaya.ac.id
                        {{-- <i class="bi bi-website-fill">utssurabaya.ac.id</i> --}}
                    </a>
                </div>
                <div class="language-switcher text-white">
                    <label for="language" class="me-1">Bahasa</label>
                    <select id="language" name="language" class="form-select form-select-sm d-inline-block w-auto">
                        <option value="id">Indonesia</option>
                        <option value="en">English</option>
                    </select>
                </div>
            </div>
        </div>
    {{-- Bagian bawah putih --}}
    <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="{{ asset('assets/img/uts_logo.png') }}" alt="Logo UTS" class="logo-img me-3">
                <div class="divider"></div>
                <div class="Faculty-text ms-3">
                    <span class="fw-semibold text-dark">Fakultas Ekonomi dan Bisnis</span>
                </div>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    {{-- Fakultas --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="fakultasDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Fakultas
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="fakultasDropdown">
                            <li><a class="dropdown-item" href="#">Tentang FEB</a></li>
                            <li><a class="dropdown-item" href="#">Visi & Misi</a></li>
                            <li><a class="dropdown-item" href="#">Struktur Organisasi</a></li>
                            <li><a class="dropdown-item" href="#">Profil Dosen</a></li>
                        </ul>
                    </li>
                    {{-- Akademik --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="akademikDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Akademik
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="akademikDropdown">
                            <li><a class="dropdown-item" href="#">Program Studi</a></li>
                            <li><a class="dropdown-item" href="#">Laboratorium</a></li>
                            <li><a class="dropdown-item" href="#">Tugas Akhir Mahasiswa</a></li>
                            <li><a class="dropdown-item" href="#">Layanan Kemahasiswaan</a></li>
                        </ul>
                    </li>
                    {{-- Kemahasiswaan --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="kemahasiswaanDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Kemahasiswaan
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="kemahasiswaanDropdown">
                            <li><a class="dropdown-item" href="#">Organisasi Kemahasiswaan</a></li>
                            <li><a class="dropdown-item" href="#">Prestasi Mahasiswa</a></li>
                        </ul>
                    </li>
                    {{-- Pusat Studi --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="pstudiDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Pusat Studi
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="pstudiDropdown">
                            <li><a class="dropdown-item" href="#">Nexus Law and Study</a></li>
                            <li><a class="dropdown-item" href="#">Asean Studies</a></li>
                        </ul>
                    </li>
                    {{-- Informasi --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="informasiDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Informasi
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="informasiDropdown">
                            <li><a class="dropdown-item" href="#">Kebijakan</a></li>
                            <li><a class="dropdown-item" href="#">Akreditasi</a></li>
                            <li><a class="dropdown-item" href="#">Alur Layanan</a></li>
                            <li><a class="dropdown-item" href="#">Berita</a></li>
                        </ul>
                    </li>
                    {{-- E-Journal --}}
                    <li class="nav-item">
                        <a class="nav-link active" href="#">E-Journal</a>
                    </li>
                    {{-- <li class="nav-item"><a class="nav-link" href="#">Fakultas</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Akademik</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Kemahasiswaan</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Pusat Studi</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Informasi</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">E-Journal</a></li> --}}
                </ul>
            </div>
        </div>
    </nav>

    {{-- Main Content --}}
    <main>
        @yield('content');
    </main>

    {{-- Footer --}}
    <footer>
        <div class="container">
            <p class="mb-1">Fakultas Ekonomi dan Bisnis - Universitas Teknologi Surabaya</p>
            <p class="mb-0">&copy; {{date('y')}} FEB UTS. Semua hak cipta dilindungi</p>
        </div>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('js')
</body>
</html>