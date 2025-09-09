<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\GuruBK;
use App\Models\Siswa;

class WhatsAppNotificationService
{
    private $apiToken;
    private $apiUrl;

    public function __construct()
    {
        $this->apiToken = env('FONNTE_API_TOKEN');
        $this->apiUrl = 'https://api.fonnte.com/send';
    }

    /**
     * Kirim notifikasi curhat baru ke Guru BK
     */
    public function notifyCurhatBaru($siswaId)
    {
        try {
            $guruBk = GuruBK::first();
            $siswa = Siswa::where('id_user', $siswaId)->first();
            
            if (!$guruBk || !$guruBk->no_tlp) {
                Log::warning('Guru BK tidak ditemukan atau nomor telepon kosong');
                return false;
            }

            if (!$siswa) {
                Log::warning('Data siswa tidak ditemukan untuk user ID: ' . $siswaId);
                return false;
            }

            $namaSiswa = $siswa->nama;
            $pesan = "🔔 *CURHAT BARU*\n\n";
            $pesan .= "Siswa: {$namaSiswa}\n";
            $pesan .= "Telah mengirimkan curhat rahasia.\n\n";
            $pesan .= "Silakan cek dashboard untuk melihat detail.\n\n";
            $pesan .= "_Sistem Bimbingan Konseling_";

            Log::info("Mengirim notifikasi curhat baru ke Guru BK: {$guruBk->no_tlp}");
            $result = $this->sendMessage($guruBk->no_tlp, $pesan);
            
            if ($result) {
                Log::info("Notifikasi curhat baru berhasil dikirim ke Guru BK");
            } else {
                Log::error("Gagal mengirim notifikasi curhat baru ke Guru BK");
            }
            
            return $result;
        } catch (\Exception $e) {
            Log::error('Error notifikasi curhat baru: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Kirim notifikasi balasan guru ke siswa
     */
    public function notifyBalasanGuru($siswaId)
    {
        try {
            $siswa = Siswa::where('id_user', $siswaId)->first();
            
            if (!$siswa || !$siswa->no_tlp) {
                Log::warning('Siswa tidak ditemukan atau nomor telepon kosong');
                return false;
            }

            $pesan = "🔔 *BALASAN GURU BK*\n\n";
            $pesan .= "Halo {$siswa->nama},\n\n";
            $pesan .= "Guru BK telah membalas curhat Anda.\n";
            $pesan .= "Silakan cek aplikasi untuk melihat balasan.\n\n";
            $pesan .= "_Sistem Bimbingan Konseling_";

            return $this->sendMessage($siswa->no_tlp, $pesan);
        } catch (\Exception $e) {
            Log::error('Error notifikasi balasan guru: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Kirim notifikasi balasan siswa ke guru BK
     */
    public function notifyBalasanSiswa($siswaName)
    {
        try {
            $guruBk = GuruBK::first();
            
            if (!$guruBk || !$guruBk->no_tlp) {
                Log::warning('Guru BK tidak ditemukan atau nomor telepon kosong');
                return false;
            }

            $pesan = "🔔 *BALASAN SISWA*\n\n";
            $pesan .= "Siswa: {$siswaName}\n";
            $pesan .= "Telah membalas curhat.\n\n";
            $pesan .= "Silakan cek dashboard untuk melihat balasan.\n\n";
            $pesan .= "_Sistem Bimbingan Konseling_";

            return $this->sendMessage($guruBk->no_tlp, $pesan);
        } catch (\Exception $e) {
            Log::error('Error notifikasi balasan siswa: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Kirim notifikasi bimbingan lanjutan ke siswa
     */
    public function notifyBimbinganLanjutan($siswaId, $tanggalBimbingan)
    {
        try {
            $siswa = Siswa::findOrFail($siswaId);
            
            if (!$siswa->no_tlp) {
                Log::warning('Nomor telepon siswa kosong');
                return false;
            }

            $tanggal = date('d/m/Y', strtotime($tanggalBimbingan));
            
            $pesan = "📅 *BIMBINGAN LANJUTAN*\n\n";
            $pesan .= "Halo {$siswa->nama},\n\n";
            $pesan .= "Anda telah dijadwalkan untuk bimbingan lanjutan.\n";
            $pesan .= "Tanggal: {$tanggal}\n\n";
            $pesan .= "Silakan cek aplikasi untuk detail lengkap.\n\n";
            $pesan .= "_Sistem Bimbingan Konseling_";

            return $this->sendMessage($siswa->no_tlp, $pesan);
        } catch (\Exception $e) {
            Log::error('Error notifikasi bimbingan lanjutan: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Kirim notifikasi hasil cek masalah ke siswa
     */
    public function notifyCekMasalah($siswaId, $tingkatUrgensi)
    {
        try {
            $siswa = Siswa::findOrFail($siswaId);
            
            if (!$siswa->no_tlp) {
                Log::warning('Nomor telepon siswa kosong');
                return false;
            }

            $urgency = ucfirst($tingkatUrgensi);
            $emoji = $tingkatUrgensi === 'tinggi' ? '🔴' : ($tingkatUrgensi === 'sedang' ? '🟡' : '🟢');
            
            $pesan = "📋 *HASIL CEK MASALAH*\n\n";
            $pesan .= "Halo {$siswa->nama},\n\n";
            $pesan .= "Hasil cek masalah Anda telah diproses.\n";
            $pesan .= "Tingkat Urgensi: {$emoji} {$urgency}\n\n";
            $pesan .= "Silakan cek aplikasi untuk detail lengkap.\n\n";
            $pesan .= "_Sistem Bimbingan Konseling_";

            return $this->sendMessage($siswa->no_tlp, $pesan);
        } catch (\Exception $e) {
            Log::error('Error notifikasi cek masalah: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Kirim notifikasi hasil cek masalah ke siswa (alias method)
     */
    public function notifyHasilCekMasalah($cekMasalah)
    {
        try {
            $siswa = $cekMasalah->siswa;
            
            if (!$siswa || !$siswa->no_tlp) {
                Log::warning('Siswa tidak ditemukan atau nomor telepon kosong');
                return false;
            }

            $urgency = ucfirst($cekMasalah->tingkat_urgensi);
            $emoji = $cekMasalah->tingkat_urgensi === 'tinggi' ? '🔴' : ($cekMasalah->tingkat_urgensi === 'sedang' ? '🟡' : '🟢');
            
            $pesan = "📋 *HASIL REVIEW CEK MASALAH*\n\n";
            $pesan .= "Halo {$siswa->nama},\n\n";
            $pesan .= "Hasil cek masalah Anda telah direview oleh Guru BK.\n";
            $pesan .= "Tingkat Urgensi: {$emoji} {$urgency}\n";
            $pesan .= "Status: " . ucfirst(str_replace('_', ' ', $cekMasalah->status)) . "\n\n";
            $pesan .= "Silakan cek aplikasi untuk detail lengkap.\n\n";
            $pesan .= "_Sistem Bimbingan Konseling_";

            return $this->sendMessage($siswa->no_tlp, $pesan);
        } catch (\Exception $e) {
            Log::error('Error notifikasi hasil cek masalah: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Kirim pesan WhatsApp (private method)
     */
    private function sendMessagePrivate($phoneNumber, $message)
    {
        try {
            if (!$this->apiToken) {
                Log::error('FONNTE_API_TOKEN tidak ditemukan di environment');
                return false;
            }

            // Pastikan nomor telepon dalam format yang benar
            $phoneNumber = $this->formatPhoneNumber($phoneNumber);

            $response = Http::withHeaders([
                'Authorization' => $this->apiToken
            ])->post($this->apiUrl, [
                'target' => $phoneNumber,
                'message' => $message,
            ]);

            if ($response->successful()) {
                Log::info("WhatsApp notification sent successfully to {$phoneNumber}");
                return true;
            } else {
                Log::error("Failed to send WhatsApp notification: " . $response->body());
                return false;
            }
        } catch (\Exception $e) {
            Log::error('Error sending WhatsApp message: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Format nomor telepon ke format internasional
     */
    private function formatPhoneNumber($phoneNumber)
    {
        // Hapus semua karakter non-digit
        $phoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber);
        
        // Jika dimulai dengan 0, ganti dengan 62
        if (substr($phoneNumber, 0, 1) === '0') {
            $phoneNumber = '62' . substr($phoneNumber, 1);
        }
        
        // Jika tidak dimulai dengan 62, tambahkan 62
        if (substr($phoneNumber, 0, 2) !== '62') {
            $phoneNumber = '62' . $phoneNumber;
        }
        
        return $phoneNumber;
    }

    /**
     * Test koneksi API
     */
    public function testConnection()
    {
        try {
            if (!$this->apiToken) {
                return [
                    'success' => false,
                    'message' => 'FONNTE_API_TOKEN tidak ditemukan'
                ];
            }

            // Test dengan endpoint yang benar untuk Fonnte
            $response = Http::withHeaders([
                'Authorization' => $this->apiToken
            ])->post('https://api.fonnte.com/validate', []);

            if ($response->successful()) {
                $data = $response->json();
                return [
                    'success' => true,
                    'message' => 'Koneksi API berhasil',
                    'data' => $data
                ];
            } else {
                // Jika validate gagal, coba test dengan send message kosong
                $testResponse = Http::withHeaders([
                    'Authorization' => $this->apiToken
                ])->post($this->apiUrl, [
                    'target' => '6281234567890', // Nomor dummy untuk test
                    'message' => 'Test connection - ignore this message',
                    'countryCode' => '62'
                ]);

                if ($testResponse->successful()) {
                    return [
                        'success' => true,
                        'message' => 'Koneksi API berhasil (via test send)',
                        'data' => $testResponse->json()
                    ];
                } else {
                    return [
                        'success' => false,
                        'message' => 'Koneksi API gagal: ' . $response->body() . ' | Test send: ' . $testResponse->body()
                    ];
                }
            }
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Kirim pesan test
     */
    public function sendTestMessage($phoneNumber, $message)
    {
        try {
            $testMessage = "🧪 *TEST MESSAGE*\n\n";
            $testMessage .= $message . "\n\n";
            $testMessage .= "_Ini adalah pesan test dari Sistem Bimbingan Konseling_";

            return $this->sendMessage($phoneNumber, $testMessage);
        } catch (\Exception $e) {
            Log::error('Error sending test message: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Kirim pesan umum (public method untuk controller)
     */
    public function sendMessage($phoneNumber, $message)
    {
        return $this->sendMessagePrivate($phoneNumber, $message);
    }

    /**
     * Kirim notifikasi pelanggaran kritis ke orang tua/siswa
     */
    public function sendViolationNotification($phoneNumber, $message)
    {
        try {
            Log::info("Sending violation notification to: {$phoneNumber}");
            
            $result = $this->sendMessage($phoneNumber, $message);
            
            if ($result) {
                Log::info("Violation notification sent successfully to {$phoneNumber}");
            } else {
                Log::error("Failed to send violation notification to {$phoneNumber}");
            }
            
            return $result;
        } catch (\Exception $e) {
            Log::error('Error sending violation notification: ' . $e->getMessage());
            return false;
        }
    }
}
