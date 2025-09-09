# Setup Notifikasi WhatsApp dengan Fonnte API

## 📋 Daftar Isi

1. [Persiapan API Token](#persiapan-api-token)
2. [Konfigurasi Environment](#konfigurasi-environment)
3. [Setup Database](#setup-database)
4. [Testing Koneksi](#testing-koneksi)
5. [Fitur Notifikasi](#fitur-notifikasi)
6. [Troubleshooting](#troubleshooting)

## 🔑 Persiapan API Token

### 1. Daftar di Fonnte

1. Kunjungi [https://fonnte.com](https://fonnte.com)
2. Daftar akun baru atau login
3. Beli paket sesuai kebutuhan
4. Dapatkan API Token dari dashboard

### 2. Setup WhatsApp Device

1. Scan QR Code di dashboard Fonnte
2. Pastikan WhatsApp device tetap online
3. Test kirim pesan manual dari dashboard

## ⚙️ Konfigurasi Environment

### 1. Edit File .env

Tambahkan konfigurasi berikut di file `.env`:

```env
# Fonnte WhatsApp API Configuration
FONNTE_API_TOKEN=your_fonnte_api_token_here
```

### 2. Contoh Token

```env
FONNTE_API_TOKEN=abc123def456ghi789jkl012mno345pqr678stu901vwx234yz
```

## 🗄️ Setup Database

### 1. Pastikan Nomor Telepon Tersedia

Pastikan tabel `siswa` dan `gurubk` memiliki kolom `no_tlp`:

```sql
-- Untuk tabel siswa
ALTER TABLE siswa ADD COLUMN no_tlp VARCHAR(15) NULL;

-- Untuk tabel gurubk
ALTER TABLE gurubk ADD COLUMN no_tlp VARCHAR(15) NULL;
```

### 2. Update Data Nomor Telepon

```sql
-- Contoh update nomor guru BK
UPDATE gurubk SET no_tlp = '085198639072' WHERE id = 1;

-- Contoh update nomor siswa
UPDATE siswa SET no_tlp = '087890058179' WHERE id = 1;
```

## 🧪 Testing Koneksi

### 1. Test via Command Line

```bash
php artisan whatsapp:test
```

### 2. Test via Web Interface

1. Login sebagai Admin atau Guru BK
2. Akses `/whatsapp`
3. Klik "Test Connection"
4. Kirim pesan test ke nomor tertentu

### 3. Expected Output

```
✅ Koneksi API berhasil
Device: Connected
Status: Active
Quota: 1000/1000
```

## 📱 Fitur Notifikasi

### 1. Curhat Rahasia

**Trigger**: Siswa mengirim curhat baru
**Penerima**: Guru BK
**Format Pesan**:

```
🔔 *CURHAT BARU*

Siswa: [Nama Siswa]
Telah mengirimkan curhat rahasia.

Silakan cek dashboard untuk melihat detail.

_Sistem Bimbingan Konseling_
```

### 2. Balasan Guru BK

**Trigger**: Guru BK membalas curhat siswa
**Penerima**: Siswa yang bersangkutan
**Format Pesan**:

```
🔔 *BALASAN GURU BK*

Halo [Nama Siswa],

Guru BK telah membalas curhat Anda.
Silakan cek aplikasi untuk melihat balasan.

_Sistem Bimbingan Konseling_
```

### 3. Balasan Siswa

**Trigger**: Siswa membalas pesan guru BK
**Penerima**: Guru BK
**Format Pesan**:

```
🔔 *BALASAN SISWA*

Siswa: [Nama Siswa]
Telah membalas curhat.

Silakan cek dashboard untuk melihat balasan.

_Sistem Bimbingan Konseling_
```

### 4. Bimbingan Lanjutan

**Trigger**: Guru BK membuat jadwal bimbingan lanjutan
**Penerima**: Siswa yang dijadwalkan
**Format Pesan**:

```
📅 *BIMBINGAN LANJUTAN*

Halo [Nama Siswa],

Anda telah dijadwalkan untuk bimbingan lanjutan.
Tanggal: [DD/MM/YYYY]

Silakan cek aplikasi untuk detail lengkap.

_Sistem Bimbingan Konseling_
```

### 5. Hasil Cek Masalah

**Trigger**: Guru BK memproses hasil cek masalah siswa
**Penerima**: Siswa yang bersangkutan
**Format Pesan**:

```
📋 *HASIL CEK MASALAH*

Halo [Nama Siswa],

Hasil cek masalah Anda telah diproses.
Tingkat Urgensi: 🔴 Tinggi

Silakan cek aplikasi untuk detail lengkap.

_Sistem Bimbingan Konseling_
```

## 🔧 Troubleshooting

### 1. Error: FONNTE_API_TOKEN tidak ditemukan

**Solusi**:

-   Pastikan file `.env` sudah dikonfigurasi
-   Jalankan `php artisan config:clear`
-   Restart server aplikasi

### 2. Error: Failed to send WhatsApp notification

**Kemungkinan Penyebab**:

-   API Token salah atau expired
-   Device WhatsApp offline
-   Quota API habis
-   Nomor telepon format salah

**Solusi**:

-   Cek status device di dashboard Fonnte
-   Verifikasi API token
-   Pastikan format nomor: 62812345678xx

### 3. Error: Nomor telepon kosong

**Solusi**:

-   Update nomor telepon di database
-   Pastikan format nomor benar (dimulai 08xx atau 62xx)

### 4. Pesan tidak terkirim

**Debugging**:

1. Cek log aplikasi: `storage/logs/laravel.log`
2. Test koneksi API: `php artisan whatsapp:test`
3. Cek quota di dashboard Fonnte
4. Verifikasi nomor telepon target

## 📊 Monitoring & Logs

### 1. Melihat Log Notifikasi

```bash
# Via command line
tail -f storage/logs/laravel.log | grep WhatsApp

# Via web interface
/whatsapp/logs
```

### 2. Format Log

```
[2024-01-15 10:30:45] local.INFO: WhatsApp notification sent successfully to 6281234567890
[2024-01-15 10:30:46] local.ERROR: Failed to send WhatsApp notification: Invalid phone number
```

## 🚀 Fitur Tambahan

### 1. Broadcast Message

-   Kirim pesan ke semua siswa
-   Kirim pesan ke semua guru
-   Kirim pesan ke siswa tertentu

### 2. Management Interface

-   Update nomor telepon siswa/guru
-   Test kirim pesan
-   Monitoring status API
-   View logs notifikasi

## 📝 Format Nomor Telepon

### Format yang Diterima:

-   `081234567890` (akan dikonversi ke `6281234567890`)
-   `6281234567890` (format internasional)
-   `+6281234567890` (akan dibersihkan ke `6281234567890`)

### Format yang Tidak Valid:

-   `1234567890` (terlalu pendek)
-   `08123456789012345` (terlalu panjang)
-   `abc123def456` (mengandung huruf)

## 🔒 Security Notes

1. **API Token**: Jangan commit API token ke repository
2. **Environment**: Gunakan `.env` untuk konfigurasi sensitif
3. **Validation**: Selalu validasi nomor telepon sebelum kirim
4. **Rate Limiting**: Perhatikan quota API untuk menghindari spam
5. **Logging**: Monitor log untuk deteksi anomali

## 📞 Support

Jika mengalami masalah:

1. Cek dokumentasi Fonnte: [https://docs.fonnte.com](https://docs.fonnte.com)
2. Contact support Fonnte
3. Cek log aplikasi untuk error details
4. Test koneksi API secara berkala

---

**Catatan**: Pastikan device WhatsApp selalu online dan API token valid untuk memastikan notifikasi berjalan dengan baik.
