# 📚 Sistem Bimbingan Konseling SMKN 1 Cilaku

Sistem informasi bimbingan konseling berbasis web yang memungkinkan komunikasi antara siswa dan guru BK dengan fitur notifikasi WhatsApp otomatis.

## ✨ Fitur Utama

-   🔐 **Multi-Role Authentication** (Admin, Guru BK, Siswa)
-   💬 **Curhat Rahasia** - Komunikasi pribadi siswa dengan guru BK
-   📋 **Formulir Cek Masalah** - Siswa mengisi, guru BK mereview
-   🤝 **Bimbingan Konseling** - Konsultasi umum
-   📅 **Bimbingan Lanjutan** - Tindak lanjut kasus
-   📱 **Notifikasi WhatsApp** - Otomatis untuk setiap aktivitas penting
-   📎 **File Upload** - Attachment pada curhat
-   📊 **Dashboard** - Statistik dan overview

## 🚀 Quick Start

### Untuk Windows:

```bash
# Clone repository
git clone https://github.com/[username]/BimbinganKoseling.git
cd BimbinganKoseling

# Jalankan setup otomatis
setup.bat
```

### Untuk Linux/Mac:

```bash
# Clone repository
git clone https://github.com/[username]/BimbinganKoseling.git
cd BimbinganKoseling

# Beri permission dan jalankan setup
chmod +x setup.sh
./setup.sh
```

## 📖 Panduan Lengkap

Untuk panduan instalasi detail, baca: **[INSTALLATION_GUIDE.md](INSTALLATION_GUIDE.md)**

## 👤 Akun Default

Setelah setup selesai:

| Role    | Email            | Password |
| ------- | ---------------- | -------- |
| Admin   | admin@gmail.com  | password |
| Guru BK | gurubk@gmail.com | password |
| Siswa   | siswa@gmail.com  | password |

## 🔧 Konfigurasi Penting

### 1. Database

Edit file `.env`:

```env
DB_DATABASE=bimbingan_konseling
DB_USERNAME=root
DB_PASSWORD=
```

### 2. WhatsApp Notification

Daftar di [Fonnte.com](https://fonnte.com) dan tambahkan token:

```env
FONNTE_API_TOKEN=your_token_here
```

## 📱 Test WhatsApp

```bash
php artisan whatsapp:test
```

## 🛠️ Tech Stack

-   **Backend**: Laravel 10
-   **Frontend**: Blade Templates, Tailwind CSS
-   **Database**: MySQL
-   **WhatsApp API**: Fonnte
-   **Authentication**: Laravel Breeze + Spatie Roles

## 📁 Struktur Project

```
├── app/
│   ├── Http/Controllers/     # Controllers
│   ├── Models/              # Eloquent Models
│   └── Services/            # Business Logic
├── database/
│   ├── migrations/          # Database Migrations
│   └── seeders/            # Data Seeders
├── resources/
│   └── views/              # Blade Templates
└── routes/
    └── web.php             # Web Routes
```

## 🔄 Workflow

### Curhat Rahasia:

1. Siswa login → Buat curhat
2. Notifikasi WhatsApp ke Guru BK
3. Guru BK login → Balas curhat
4. Notifikasi WhatsApp ke Siswa

### Formulir Cek Masalah:

1. Siswa mengisi formulir
2. Guru BK mereview dan beri tindak lanjut
3. Notifikasi hasil ke siswa

## 🤝 Contributing

1. Fork repository
2. Buat branch feature (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

## 📞 Support

Jika mengalami masalah:

1. Cek `storage/logs/laravel.log`
2. Pastikan semua persyaratan sistem terpenuhi
3. Jalankan `php artisan cache:clear`

## 📄 License

Project ini menggunakan [MIT License](LICENSE).

---

**Dibuat dengan ❤️ untuk membantu sistem bimbingan konseling di sekolah**
