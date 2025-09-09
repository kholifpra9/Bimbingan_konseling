# 📱 DOKUMENTASI FITUR NOTIFIKASI WHATSAPP

## 🎯 Overview

Sistem Bimbingan Konseling SMK Negeri 1 Cilaku telah dilengkapi dengan fitur notifikasi WhatsApp otomatis menggunakan **Fonnte API** untuk berbagai aktivitas penting dalam sistem.

## 🔧 Konfigurasi

Pastikan `FONNTE_API_TOKEN` sudah dikonfigurasi di file `.env`:

```env
FONNTE_API_TOKEN=your_fonnte_api_token_here
```

## 📋 Fitur Notifikasi yang Tersedia

### 1. 🚨 **Notifikasi Pelanggaran Kritis (≥65 Poin)**

**Trigger:** Ketika siswa mencapai total poin pelanggaran ≥65
**Penerima:** Orang tua siswa (prioritas) atau siswa langsung
**Fitur:**

-   ✅ Otomatis terkirim saat input pelanggaran baru
-   ✅ Mencegah duplikasi notifikasi untuk threshold yang sama
-   ✅ Tracking status pengiriman di database
-   ✅ Format pesan profesional dengan detail lengkap

**Contoh Pesan:**

```
🚨 *PERINGATAN PELANGGARAN SISWA* 🚨

Kepada Yth. Orang Tua/Wali dari:
👤 *Nama*: Ahmad Rizki
🏫 *Kelas*: XII RPL 1
📚 *Jurusan*: Rekayasa Perangkat Lunak

📊 *INFORMASI PELANGGARAN:*
• Total Poin Pelanggaran: *70 poin*
• Pelanggaran Terbaru: Berkelahi dengan teman
• Poin Pelanggaran Terbaru: 25 poin

⚠️ *PERHATIAN:*
Siswa telah mencapai batas kritis pelanggaran (≥65 poin).
Mohon segera menghubungi Guru BK untuk konsultasi lebih lanjut.

📞 *Hubungi Guru BK:*
SMK SILIWANGI
Jl. Raya Garut - Tasikmalaya

Terima kasih atas perhatian dan kerjasamanya.

_Pesan otomatis dari Sistem Bimbingan Konseling_
```

### 2. 💬 **Notifikasi Curhat Rahasia**

**Fitur:**

-   ✅ Notifikasi ke Guru BK saat ada curhat baru
-   ✅ Notifikasi ke siswa saat Guru BK membalas
-   ✅ Notifikasi ke Guru BK saat siswa membalas

### 3. 📋 **Notifikasi Hasil Cek Masalah (DCM)**

**Fitur:**

-   ✅ Notifikasi ke siswa saat hasil DCM direview
-   ✅ Indikator tingkat urgensi dengan emoji
-   ✅ Status review yang jelas

### 4. 📅 **Notifikasi Bimbingan Lanjutan**

**Fitur:**

-   ✅ Notifikasi jadwal bimbingan ke siswa
-   ✅ Detail tanggal dan informasi lengkap

## 🏗️ Implementasi Teknis

### Database Schema

**Tabel `pelanggaran` - Kolom Notifikasi:**

```sql
- notifikasi_terkirim (boolean, default: false)
- tanggal_notifikasi (timestamp, nullable)
- pesan_notifikasi (text, nullable)
```

### Model Methods

**Pelanggaran Model:**

```php
// Cek apakah perlu notifikasi
public static function needsNotification($studentId)

// Hitung total poin siswa
public static function getTotalPointsForStudent($studentId)

// Tandai notifikasi sudah terkirim
public function markNotificationSent($message = null)
```

**Siswa Model:**

```php
// Dapatkan nomor WhatsApp (prioritas ortu)
public function getWhatsAppNumber()

// Cek apakah mencapai batas kritis
public function hasCriticalViolations()
```

### Service Class

**WhatsAppNotificationService:**

```php
// Notifikasi pelanggaran kritis
public function sendViolationNotification($phoneNumber, $message)

// Notifikasi curhat
public function notifyCurhatBaru($siswaId)
public function notifyBalasanGuru($siswaId)
public function notifyBalasanSiswa($siswaName)

// Notifikasi DCM
public function notifyCekMasalah($siswaId, $tingkatUrgensi)
public function notifyHasilCekMasalah($cekMasalah)

// Notifikasi bimbingan
public function notifyBimbinganLanjutan($siswaId, $tanggalBimbingan)

// Utilitas
public function testConnection()
public function sendTestMessage($phoneNumber, $message)
```

### Controller Integration

**PelanggaranController:**

```php
public function store(Request $request)
{
    // ... validasi dan simpan pelanggaran

    // Cek dan kirim notifikasi otomatis
    $this->checkAndSendViolationNotification($request->id_siswa, $pelanggaran);

    // ... return response
}

private function checkAndSendViolationNotification($studentId, $latestViolation)
{
    if (!Pelanggaran::needsNotification($studentId)) {
        return;
    }

    // Kirim notifikasi WhatsApp
    $whatsappService = new WhatsAppNotificationService();
    $sent = $whatsappService->sendViolationNotification($whatsappNumber, $message);

    if ($sent) {
        $latestViolation->markNotificationSent($message);
    }
}
```

## 🧪 Testing

### Manual Testing

Jalankan script test:

```bash
php test_violation_notification.php
```

### Test Cases

1. ✅ Siswa dengan poin < 65: Tidak ada notifikasi
2. ✅ Siswa dengan poin ≥ 65: Notifikasi terkirim
3. ✅ Siswa sudah pernah dapat notifikasi: Tidak duplikasi
4. ✅ Format nomor WhatsApp: Otomatis ke format internasional
5. ✅ Prioritas nomor: Orang tua > Siswa

## 📊 Monitoring & Logging

### Log Files

Semua aktivitas notifikasi tercatat di:

```
storage/logs/laravel.log
```

### Log Entries

```
[INFO] WhatsApp violation notification sent to Ahmad Rizki (6281234567890)
[ERROR] Failed to send WhatsApp violation notification to Ahmad Rizki
[WARNING] No WhatsApp number found for student: Ahmad Rizki (ID: 123)
```

### Database Tracking

-   Status pengiriman: `notifikasi_terkirim`
-   Waktu pengiriman: `tanggal_notifikasi`
-   Isi pesan: `pesan_notifikasi`

## 🔒 Security & Privacy

### Data Protection

-   ✅ Nomor telepon diformat secara aman
-   ✅ Pesan tidak mengandung data sensitif berlebihan
-   ✅ Log tidak menyimpan nomor telepon lengkap

### Error Handling

-   ✅ Graceful failure jika API tidak tersedia
-   ✅ Retry mechanism untuk pesan gagal
-   ✅ Fallback ke log jika WhatsApp gagal

## 🚀 Deployment Checklist

### Environment Setup

-   [ ] `FONNTE_API_TOKEN` dikonfigurasi
-   [ ] Database migration dijalankan
-   [ ] Nomor telepon siswa/ortu terisi
-   [ ] Role permissions sudah benar

### Testing Production

-   [ ] Test koneksi API: `/whatsapp/test-connection`
-   [ ] Test kirim pesan: `/whatsapp/send-test`
-   [ ] Test notifikasi pelanggaran
-   [ ] Monitor log files

## 📈 Future Enhancements

### Planned Features

-   📧 Email backup jika WhatsApp gagal
-   📊 Dashboard statistik notifikasi
-   ⏰ Scheduled notifications
-   🎯 Template pesan yang dapat dikustomisasi
-   📱 Multiple provider support (Twilio, etc.)

### Performance Optimization

-   🔄 Queue system untuk bulk notifications
-   📦 Batch processing untuk efisiensi
-   💾 Caching untuk data yang sering diakses

---

## 📞 Support

Untuk pertanyaan teknis atau troubleshooting:

1. Cek log files di `storage/logs/`
2. Test koneksi API via dashboard WhatsApp
3. Verifikasi konfigurasi environment
4. Pastikan nomor telepon dalam format yang benar

**Status:** ✅ **FULLY IMPLEMENTED & TESTED**
**Last Updated:** 15 Januari 2025
**Version:** 1.0.0
