<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Akses Ditolak - Sistem Bimbingan Konseling</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .error-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            padding: 3rem;
            text-align: center;
            max-width: 600px;
            margin: 2rem;
        }
        .error-icon {
            width: 120px;
            height: 120px;
            background: linear-gradient(135deg, #ff6b6b, #ee5a24);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 2rem;
            color: white;
            font-size: 3rem;
        }
        .error-code {
            font-size: 4rem;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 1rem;
        }
        .error-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 1rem;
        }
        .error-message {
            color: #7f8c8d;
            margin-bottom: 2rem;
            line-height: 1.6;
        }
        .btn-custom {
            padding: 12px 30px;
            border-radius: 25px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
            margin: 0.5rem;
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
            transform: translateY(-2px);
        }
        .btn-secondary-custom {
            background: transparent;
            color: #667eea;
            border: 2px solid #667eea;
        }
        .btn-secondary-custom:hover {
            background: #667eea;
            color: white;
            transform: translateY(-2px);
        }
        .role-info {
            background: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 1rem;
            margin: 1.5rem 0;
            border-radius: 0 8px 8px 0;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-icon">
            <i class="fas fa-lock"></i>
        </div>
        
        <div class="error-code">403</div>
        
        <h1 class="error-title">Akses Ditolak</h1>
        
        <p class="error-message">
            Maaf, Anda tidak memiliki izin untuk mengakses halaman ini. 
            Halaman yang Anda coba akses memerlukan hak akses khusus yang tidak tersedia untuk akun Anda saat ini.
        </p>

        @auth
            <div class="role-info">
                <strong><i class="fas fa-user-tag me-2"></i>Role Anda:</strong> 
                @if(auth()->user()->hasRole('admin'))
                    <span class="badge bg-danger">Administrator</span>
                @elseif(auth()->user()->hasRole('gurubk'))
                    <span class="badge bg-success">Guru BK</span>
                @elseif(auth()->user()->hasRole('kesiswaan'))
                    <span class="badge bg-warning">Kesiswaan</span>
                @elseif(auth()->user()->hasRole('orangtua'))
                    <span class="badge bg-info">Orang Tua</span>
                @elseif(auth()->user()->hasRole('siswa'))
                    <span class="badge bg-primary">Siswa</span>
                @elseif(auth()->user()->hasRole('kepsek'))
                    <span class="badge bg-dark">Kepala Sekolah</span>
                @elseif(auth()->user()->hasRole('kajur'))
                    <span class="badge bg-secondary">Ketua Jurusan</span>
                @else
                    <span class="badge bg-light text-dark">Tidak Diketahui</span>
                @endif
            </div>
        @endauth

        <div class="mt-4">
            <a href="{{ url('/dashboard') }}" class="btn-custom btn-primary-custom">
                <i class="fas fa-tachometer-alt me-2"></i>Kembali ke Dashboard
            </a>
            
            <a href="{{ url('/') }}" class="btn-custom btn-secondary-custom">
                <i class="fas fa-home me-2"></i>Halaman Utama
            </a>
        </div>

        <div class="mt-4">
            <small class="text-muted">
                <i class="fas fa-info-circle me-1"></i>
                Jika Anda merasa ini adalah kesalahan, silakan hubungi administrator sistem.
            </small>
        </div>

        <div class="mt-3">
            <small class="text-muted">
                <strong>Sistem Bimbingan Konseling</strong><br>
                SMK Negeri 1 Cilaku - Cianjur
            </small>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
