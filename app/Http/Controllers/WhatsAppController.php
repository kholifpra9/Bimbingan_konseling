<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\WhatsAppNotificationService;
use App\Models\GuruBK;
use App\Models\Siswa;

class WhatsAppController extends Controller
{
    protected $whatsappService;

    public function __construct()
    {
        $this->whatsappService = new WhatsAppNotificationService();
    }

    /**
     * Halaman pengaturan WhatsApp
     */
    public function index()
    {
        $guruBk = GuruBK::all();
        $siswa = Siswa::all();
        
        return view('admin.whatsapp.index', compact('guruBk', 'siswa'));
    }

    /**
     * Test koneksi API
     */
    public function testConnection()
    {
        $result = $this->whatsappService->testConnection();
        
        return response()->json($result);
    }

    /**
     * Kirim pesan test ke nomor tertentu
     */
    public function sendTestMessage(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|string',
            'message' => 'required|string|min:5',
        ]);

        try {
            $result = $this->whatsappService->sendTestMessage(
                $request->phone_number,
                $request->message
            );

            if ($result) {
                return response()->json([
                    'success' => true,
                    'message' => 'Pesan test berhasil dikirim!'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal mengirim pesan test'
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update nomor telepon Guru BK
     */
    public function updateGuruBkPhone(Request $request, $id)
    {
        $request->validate([
            'no_tlp' => 'required|string|min:10|max:15',
        ]);

        try {
            $guruBk = GuruBK::findOrFail($id);
            $guruBk->update([
                'no_tlp' => $request->no_tlp
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Nomor telepon Guru BK berhasil diperbarui!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update nomor telepon Siswa
     */
    public function updateSiswaPhone(Request $request, $id)
    {
        $request->validate([
            'no_tlp' => 'required|string|min:10|max:15',
        ]);

        try {
            $siswa = Siswa::findOrFail($id);
            $siswa->update([
                'no_tlp' => $request->no_tlp
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Nomor telepon siswa berhasil diperbarui!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Kirim notifikasi broadcast ke semua siswa
     */
    public function sendBroadcast(Request $request)
    {
        $request->validate([
            'message' => 'required|string|min:10',
            'target' => 'required|in:all_students,all_teachers,specific',
            'specific_ids' => 'required_if:target,specific|array',
        ]);

        try {
            $successCount = 0;
            $failCount = 0;

            if ($request->target === 'all_students') {
                $siswa = Siswa::whereNotNull('no_tlp')->get();
                foreach ($siswa as $s) {
                    $pesan = "📢 *PENGUMUMAN*\n\n";
                    $pesan .= "Halo {$s->nama},\n\n";
                    $pesan .= $request->message . "\n\n";
                    $pesan .= "_Sistem Bimbingan Konseling_";

                    if ($this->whatsappService->sendMessage($s->no_tlp, $pesan)) {
                        $successCount++;
                    } else {
                        $failCount++;
                    }
                }
            } elseif ($request->target === 'all_teachers') {
                $guruBk = GuruBK::whereNotNull('no_tlp')->get();
                foreach ($guruBk as $guru) {
                    $pesan = "📢 *PENGUMUMAN*\n\n";
                    $pesan .= "Halo {$guru->nama},\n\n";
                    $pesan .= $request->message . "\n\n";
                    $pesan .= "_Sistem Bimbingan Konseling_";

                    if ($this->whatsappService->sendMessage($guru->no_tlp, $pesan)) {
                        $successCount++;
                    } else {
                        $failCount++;
                    }
                }
            } elseif ($request->target === 'specific') {
                // Handle specific users
                foreach ($request->specific_ids as $id) {
                    $siswa = Siswa::find($id);
                    if ($siswa && $siswa->no_tlp) {
                        $pesan = "📢 *PENGUMUMAN*\n\n";
                        $pesan .= "Halo {$siswa->nama},\n\n";
                        $pesan .= $request->message . "\n\n";
                        $pesan .= "_Sistem Bimbingan Konseling_";

                        if ($this->whatsappService->sendMessage($siswa->no_tlp, $pesan)) {
                            $successCount++;
                        } else {
                            $failCount++;
                        }
                    }
                }
            }

            return response()->json([
                'success' => true,
                'message' => "Broadcast selesai! Berhasil: {$successCount}, Gagal: {$failCount}"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Lihat log notifikasi
     */
    public function viewLogs()
    {
        $logPath = storage_path('logs/laravel.log');
        $logs = [];

        if (file_exists($logPath)) {
            $logContent = file_get_contents($logPath);
            $logLines = explode("\n", $logContent);
            
            // Filter hanya log WhatsApp
            $whatsappLogs = array_filter($logLines, function($line) {
                return strpos($line, 'WhatsApp') !== false || 
                       strpos($line, 'Fonnte') !== false ||
                       strpos($line, 'notifikasi WA') !== false;
            });

            // Ambil 50 log terakhir
            $logs = array_slice(array_reverse($whatsappLogs), 0, 50);
        }

        return response()->json([
            'success' => true,
            'logs' => $logs
        ]);
    }
}
