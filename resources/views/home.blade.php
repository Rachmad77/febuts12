@extends('layouts.landing')

@section('title', 'Beranda - FEB UTS')

@section('content')

{{-- Hero Section --}}
<section class="hero-section">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <h1 class="fw-bold-mb-3">Fakultas Ekonomi dan Bisnis</h1>
        <p class="mb-4">Universitas Teknologi Surabaya</p>
        {{-- <p>Mencetak Pemimpin Inovatif dan Berintegritas</p> --}}
        {{-- <a href="#" class="btn btn-uts btn-lg">Lihat Program Studi</a> --}}
    </div>
</section>

<section class="py-5 bg-light text-center">
    <div class="container">
        <h2 class="section-tittle">Program Studi</h2>
        <div class="row justify-content-center">
            <div class="col-md-3 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-tittle">S1 Manajemen</h5>
                        <p class="card-text">Membentuk calon pemimpin bisnis yang strategis dan inovatif.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-tittle">S1 Akuntansi</h5>
                        <p class="card-text">Menyiapkan profesional akuntansi dengan integritas dan analisis tinggi.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
