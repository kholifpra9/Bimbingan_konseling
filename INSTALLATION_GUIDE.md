# 📚 Panduan Instalasi Sistem Bimbingan Konseling

## 🔧 Persyaratan Sistem

Sebelum memulai, pastikan komputer Anda memiliki:

1. **PHP** >= 8.1
2. **Composer** (https://getcomposer.org/)
3. **Node.js** & NPM (https://nodejs.org/)
4. **MySQL** atau **MariaDB**
5. **Git** (untuk clone repository)

## 📥 Langkah-Langkah Instalasi

### 1. Clone Repository

```bash
git clone https://github.com/[username]/BimbinganKoseling.git
cd BimbinganKoseling
```

### 2. Install Dependencies PHP

```bash
composer install
```

### 3. Install Dependencies JavaScript

```bash
npm install
```

### 4. Setup Environment

Copy file `.env.example` menjadi `.env`:

```bash
cp .env.example .env
```

### 5. Konfigurasi Database

Edit file `.env` dan sesuaikan dengan database Anda:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bimbingan_konseling
DB_USERNAME=root
DB_PASSWORD=
```

### 6. Konfigurasi WhatsApp (Fonnte)

Tambahkan API token Fonnte di file `.env`:

```env
FONNTE_API_TOKEN=your_fonnte_api_token_here
```

> **Note**: Untuk mendapatkan token Fonnte, daftar di https://fonnte.com/

### 7. Generate Application Key

```bash
php artisan key:generate
```

### 8. Buat Database

Buat database baru di MySQL/MariaDB:

```sql
CREATE DATABASE bimbingan_konseling;
```

### 9. Jalankan Migration

```bash
php artisan migrate
```

### 10. Jalankan Seeder (Data Awal)

```bash
php artisan db:seed
```

### 11. Build Assets

```bash
npm run build
```

Atau untuk development:

```bash
npm run dev
```

### 12. Buat Storage Link

```bash
php artisan storage:link
```

### 13. Jalankan Aplikasi

```bash
php artisan serve
```

Aplikasi akan berjalan di: http://localhost:8000

## 👤 Akun Default

Setelah menjalankan seeder, gunakan akun berikut untuk login:

### Admin

-   Email: admin@gmail.com
-   Password: password

### Guru BK

-   Email: gurubk@gmail.com
-   Password: password

### Siswa

-   Email: siswa@gmail.com
-   Password: password

## 🔧 Troubleshooting

### Error: SQLSTATE[HY000] [1049] Unknown database

**Solusi**: Pastikan database sudah dibuat di MySQL/MariaDB

### Error: SQLSTATE[HY000] [1045] Access denied for user

**Solusi**: Periksa username dan password database di file `.env`

### Error: Class not found

**Solusi**: Jalankan `composer dump-autoload`

### Error: Mix manifest not found

**Solusi**: Jalankan `npm run build`

### WhatsApp Notification tidak terkirim

**Solusi**:

1. Pastikan `FONNTE_API_TOKEN` sudah diisi dengan benar
2. Cek saldo Fonnte Anda
3. Pastikan nomor telepon dalam format yang benar (08xxx)

## 📝 Konfigurasi Tambahan

### Mengubah Data Guru BK

1. Login sebagai admin
2. Pergi ke menu Guru BK
3. Edit data guru BK sesuai kebutuhan
4. **Penting**: Pastikan nomor telepon guru BK valid untuk menerima notifikasi WhatsApp

### Mengubah Data Siswa

1. Login sebagai admin/guru BK
2. Pergi ke menu Siswa
3. Tambah/edit data siswa
4. **Penting**: Pastikan nomor telepon siswa valid untuk menerima notifikasi WhatsApp

## 🚀 Fitur Utama

1. **Curhat Rahasia**: Komunikasi pribadi antara siswa dan guru BK
2. **Formulir Cek Masalah**: Siswa mengisi, guru BK mereview
3. **Bimbingan Konseling**: Konsultasi umum
4. **Bimbingan Lanjutan**: Tindak lanjut kasus
5. **Notifikasi WhatsApp**: Otomatis untuk setiap aktivitas penting

## 📱 Testing WhatsApp

Untuk test koneksi WhatsApp:

```bash
php artisan whatsapp:test
```

## 🔐 Keamanan

1. Ganti semua password default setelah instalasi
2. Jangan share `FONNTE_API_TOKEN` Anda
3. Backup database secara berkala
4. Update dependencies secara rutin

## 📞 Dukungan

Jika mengalami masalah:

1. Cek log di `storage/logs/laravel.log`
2. Pastikan semua persyaratan sistem terpenuhi
3. Coba clear cache: `php artisan cache:clear`

---

**Happy Coding! 🎉**
