<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Bimbingan Konseling - SMK Negeri 1 Cilaku</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
        }
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 100px 0;
        }
        .feature-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }
        .feature-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 24px;
        }
        .navbar-brand img {
            width: 40px;
            height: 40px;
            object-fit: cover;
        }
        .btn-custom {
            padding: 12px 30px;
            border-radius: 25px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
        }
        .btn-primary-custom {
            background: #667eea;
            color: white;
            border: 2px solid #667eea;
        }
        .btn-primary-custom:hover {
            background: #5a6fd8;
            border-color: #5a6fd8;
            color: white;
        }
        .btn-outline-custom {
            background: transparent;
            color: white;
            border: 2px solid white;
        }
        .btn-outline-custom:hover {
            background: white;
            color: #667eea;
        }
        footer {
            background: #2c3e50;
            color: white;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="{{ asset('img/Logo smk.png') }}" alt="Logo SMK" class="rounded-circle me-2">
                <span class="fw-bold">SMK Negeri 1 Cilaku</span>
            </a>
            
            @if (Route::has('login'))
                <div class="d-flex">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn btn-primary-custom">
                            <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">
                            <i class="fas fa-sign-in-alt me-2"></i>Masuk
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-primary-custom">
                                <i class="fas fa-user-plus me-2"></i>Daftar
                            </a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section text-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <img src="{{ asset('img/Logo smk.png') }}" alt="Logo SMK" class="rounded-circle mb-4" style="width: 120px; height: 120px; object-fit: cover;">
                    <h1 class="display-4 fw-bold mb-4">Sistem Bimbingan Konseling</h1>
                    <h2 class="h4 mb-4 opacity-75">SMK Negeri 1 Cilaku - Cianjur</h2>
                    <p class="lead mb-5">
                        Platform digital untuk mendukung layanan bimbingan dan konseling yang profesional, 
                        membantu siswa dalam pengembangan akademik, sosial, dan karir.
                    </p>
                    
                    @guest
                        <div class="d-flex gap-3 justify-content-center flex-wrap">
                            <a href="{{ route('login') }}" class="btn-custom btn-primary-custom">
                                <i class="fas fa-sign-in-alt me-2"></i>Masuk ke Sistem
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn-custom btn-outline-custom">
                                    <i class="fas fa-user-plus me-2"></i>Daftar Akun
                                </a>
                            @endif
                        </div>
                    @else
                        <a href="{{ url('/dashboard') }}" class="btn-custom btn-primary-custom">
                            <i class="fas fa-tachometer-alt me-2"></i>Masuk ke Dashboard
                        </a>
                    @endguest
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold mb-3">Layanan Bimbingan Konseling</h2>
                <p class="lead text-muted">Kami menyediakan berbagai layanan untuk mendukung perkembangan siswa secara menyeluruh</p>
            </div>

            <div class="row g-4">
                <!-- Konsultasi Personal -->
                <div class="col-md-6 col-lg-4">
                    <div class="card feature-card h-100 text-center p-4">
                        <div class="feature-icon bg-primary bg-opacity-10 text-primary">
                            <i class="fas fa-comments"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Konsultasi Personal</h5>
                        <p class="text-muted mb-3">Layanan konsultasi individual untuk membantu siswa mengatasi masalah pribadi dan akademik.</p>
                        <small class="text-primary fw-semibold">Tersedia Online 24/7</small>
                    </div>
                </div>

                <!-- Bimbingan Karir -->
                <div class="col-md-6 col-lg-4">
                    <div class="card feature-card h-100 text-center p-4">
                        <div class="feature-icon bg-success bg-opacity-10 text-success">
                            <i class="fas fa-briefcase"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Bimbingan Karir</h5>
                        <p class="text-muted mb-3">Panduan untuk memilih jurusan, merencanakan karir, dan persiapan dunia kerja.</p>
                        <small class="text-success fw-semibold">Konsultasi Profesional</small>
                    </div>
                </div>

                <!-- Monitoring Pelanggaran -->
                <div class="col-md-6 col-lg-4">
                    <div class="card feature-card h-100 text-center p-4">
                        <div class="feature-icon bg-danger bg-opacity-10 text-danger">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Monitoring Pelanggaran</h5>
                        <p class="text-muted mb-3">Sistem pemantauan dan pembinaan untuk mendukung kedisiplinan siswa.</p>
                        <small class="text-danger fw-semibold">Sistem Terintegrasi</small>
                    </div>
                </div>

                <!-- Pengaduan Online -->
                <div class="col-md-6 col-lg-4">
                    <div class="card feature-card h-100 text-center p-4">
                        <div class="feature-icon bg-warning bg-opacity-10 text-warning">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Pengaduan Online</h5>
                        <p class="text-muted mb-3">Platform untuk menyampaikan keluhan dan masalah dengan aman dan terpercaya.</p>
                        <small class="text-warning fw-semibold">Rahasia & Aman</small>
                    </div>
                </div>

                <!-- Rekap Bimbingan -->
                <div class="col-md-6 col-lg-4">
                    <div class="card feature-card h-100 text-center p-4">
                        <div class="feature-icon bg-info bg-opacity-10 text-info">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Rekap Bimbingan</h5>
                        <p class="text-muted mb-3">Laporan dan analisis perkembangan siswa untuk evaluasi berkelanjutan.</p>
                        <small class="text-info fw-semibold">Data Terstruktur</small>
                    </div>
                </div>

                <!-- Manajemen Data -->
                <div class="col-md-6 col-lg-4">
                    <div class="card feature-card h-100 text-center p-4">
                        <div class="feature-icon bg-secondary bg-opacity-10 text-secondary">
                            <i class="fas fa-users-cog"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Manajemen Data</h5>
                        <p class="text-muted mb-3">Pengelolaan data siswa, guru, dan administrasi dengan sistem yang terintegrasi.</p>
                        <small class="text-secondary fw-semibold">Akses Multi-Role</small>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="display-5 fw-bold mb-3">Hubungi Kami</h2>
                <p class="lead text-muted">Tim Bimbingan Konseling siap membantu Anda</p>
            </div>

            <div class="row g-4">
                <div class="col-md-4 text-center">
                    <div class="feature-icon bg-primary bg-opacity-10 text-primary">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Alamat</h5>
                    <p class="text-muted">SMK Negeri 1 Cilaku<br>Cianjur, Jawa Barat</p>
                </div>

                <div class="col-md-4 text-center">
                    <div class="feature-icon bg-success bg-opacity-10 text-success">
                        <i class="fas fa-phone"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Telepon</h5>
                    <p class="text-muted">+62 xxx-xxxx-xxxx<br>Senin - Jumat: 07:00 - 16:00</p>
                </div>

                <div class="col-md-4 text-center">
                    <div class="feature-icon bg-info bg-opacity-10 text-info">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Email</h5>
                    <p class="text-muted">bk@smkn1cilaku.sch.id<br>Respon dalam 24 jam</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="d-flex align-items-center mb-3">
                        <img src="{{ asset('img/Logo smk.png') }}" alt="Logo SMK" class="rounded-circle me-3" style="width: 50px; height: 50px; object-fit: cover;">
                        <h5 class="fw-bold mb-0">SMK Negeri 1 Cilaku</h5>
                    </div>
                    <p class="text-light opacity-75">
                        Sistem Bimbingan Konseling digital yang mendukung perkembangan siswa secara menyeluruh 
                        dengan layanan profesional dan terintegrasi.
                    </p>
                </div>

                <div class="col-lg-3">
                    <h6 class="fw-bold mb-3">Layanan</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#" class="text-light opacity-75 text-decoration-none">Konsultasi Personal</a></li>
                        <li class="mb-2"><a href="#" class="text-light opacity-75 text-decoration-none">Bimbingan Karir</a></li>
                        <li class="mb-2"><a href="#" class="text-light opacity-75 text-decoration-none">Monitoring Pelanggaran</a></li>
                        <li class="mb-2"><a href="#" class="text-light opacity-75 text-decoration-none">Pengaduan Online</a></li>
                    </ul>
                </div>

                <div class="col-lg-3">
                    <h6 class="fw-bold mb-3">Kontak</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2 text-light opacity-75">SMK Negeri 1 Cilaku</li>
                        <li class="mb-2 text-light opacity-75">Cianjur, Jawa Barat</li>
                        <li class="mb-2 text-light opacity-75">+62 xxx-xxxx-xxxx</li>
                        <li class="mb-2 text-light opacity-75">bk@smkn1cilaku.sch.id</li>
                    </ul>
                </div>
            </div>

            <hr class="my-4 opacity-25">
            <div class="text-center">
                <p class="mb-0 text-light opacity-75">
                    &copy; {{ date('Y') }} SMK Negeri 1 Cilaku. Sistem Bimbingan Konseling. All rights reserved.
                </p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
