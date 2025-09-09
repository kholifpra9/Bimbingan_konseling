<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pelanggaran;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PelanggaranController extends Controller
{
     public function index(Request $request)
    {
        $user = auth()->user();

        // 1) Kalau siswa, langsung redirect ke detail NIS dia
        if ($user->hasRole('siswa')) {
            $nis = optional($user->siswa)->nis;
            abort_unless($nis, 403, 'Data siswa tidak ditemukan.');
            return redirect()->route('pelanggaran.rekap.detail', $nis);
        }

        // 2) List rekap untuk role lain (gurubk/kajur/kesiswaan/kepsek)
        // Rapikan $search biar selalu ada
        $search = trim($request->input('q', ''));

        $query = Siswa::query()
            ->select('id','nis','nama','kelas')
            ->withSum('pelanggaran as total_point', 'point_pelanggaran');

        if ($search !== '') {
            $query->where(function($q) use ($search) {
                $q->where('nis', 'like', "%{$search}%")
                  ->orWhere('nama', 'like', "%{$search}%")
                  ->orWhere('kelas', 'like', "%{$search}%");
            });
        }

        $siswa = $query
            ->orderByDesc('total_point') // yang poinnya paling tinggi dulu
            ->paginate(15)
            ->withQueryString();

        // contoh view rekap: resources/views/pelanggaran/rekap.blade.php
        return view('pelanggaran.rekap', compact('siswa', 'search'));
    }

    // DETAIL: per siswa (by NIS), list semua pelanggaran + total
    public function show(Siswa $siswa) // gunakan {siswa:nis} di route
    {
        $user = auth()->user();

        // 3) Siswa hanya boleh lihat miliknya sendiri
        if ($user->hasRole('siswa')) {
            $nisUser = optional($user->siswa)->nis;
            abort_unless($nisUser && $nisUser === $siswa->nis, 403, 'Tidak boleh mengakses data siswa lain.');
        }

        $pelanggaran = $siswa->pelanggaran()
            ->select('id','jenis_pelanggaran','point_pelanggaran','created_at')
            ->latest()
            ->get();

        $total = $pelanggaran->sum('point_pelanggaran');

        // contoh view detail: resources/views/pelanggaran/detail.blade.php
        return view('pelanggaran.detail', compact('siswa','pelanggaran','total'));
    }

    // Menampilkan form tambah akun pelanggaran
    // Controller
    public function create(Request $request)
    {
        $prefillSiswa = null;

        if ($request->filled('nis')) {
            $prefillSiswa = Siswa::select('id','nis','nama','kelas')
                            ->where('nis', $request->nis)
                            ->first();
        }

        // untuk dropdown jika tidak ada prefill
        $siswas = Siswa::select('id','nis','nama','kelas')->orderBy('nama')->get();

        return view('pelanggaran.create', compact('siswas','prefillSiswa'));
    }

    // Menyimpan akun pelanggaran baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_siswa'          => ['required', 'exists:siswa,id'],
            'jenis_pelanggaran' => ['required', 'string', 'max:150'],
            'point_pelanggaran' => ['required', 'integer', 'min:1', 'max:1000'],
        ]);

        $pelanggaran = Pelanggaran::create($validated);

        $this->checkAndSendViolationNotification($validated['id_siswa'], $pelanggaran);

        return redirect()->route('pelanggaran.rekap')
            ->with(['message' => 'Data Pelanggaran berhasil disimpan', 'alert-type' => 'success']);
    }





    public function edit(string $id)
    {
        $pelanggarans = Pelanggaran::findOrFail($id);
        return view('pelanggaran.edit', $pelanggarans);
    }

    public function update(Request $request, string $id)
    {
        // Validate the incoming request
        $validate = $request->validate([
            'id_siswa' => 'required|max:255',
            'jenis_pelanggaran' => 'required|max:150',
            'point_pelanggaran' => 'required|max:20',
        ]);

        // Find the Siswa record by ID
        $pelanggaran = Pelanggaran::findOrFail($id);


        // Update the Siswa information
        $pelanggaran->update([
            'id_siswa' => $validate['id_siswa'],
            'jenis_pelanggaran' => $validate['jenis_pelanggaran'],
            'point_pelanggaran' => $validate['point_pelanggaran'],
        ]);

        $notification = [
            'message' => 'Data pelanggaran siswa berhasil diperbaharui',
            'alert-type' => 'success'
        ];

        return redirect()->route('pelanggaran.rekap')->with($notification);
    }

    public function destroy($id)
    {
        $pelanggaran = Pelanggaran::findOrFail($id);
        $pelanggaran->delete();

        $notification = array(
            'message' => 'Data pelanggaran berhasil dihapus',
            'alert-type' => 'success',
        );

        return redirect()->route('pelanggaran.rekap')->with($notification);
    }

    public function surat(Siswa $siswa)
    {
        $pelanggaran = $siswa->pelanggaran()->select('jenis_pelanggaran','point_pelanggaran','created_at')->orderBy('created_at')->get();
        $total = $pelanggaran->sum('point_pelanggaran');

        // Opsional: guard, kalau <65 arahkan balik
        if ($total < 65) {
            return redirect()->route('pelanggaran.rekap.detail', $siswa->nis)
                ->with(['message' => 'Total poin belum mencapai batas kritis (65).', 'alert-type' => 'warning']);
        }

        return view('pelanggaran.surat', compact('siswa','pelanggaran','total'));
    }

    /**
     * Check and send WhatsApp notification for critical violations (≥65 points)
     */
    private function checkAndSendViolationNotification($studentId, $latestViolation)
    {
        // Check if student needs notification
        if (!Pelanggaran::needsNotification($studentId)) {
            return;
        }

        try {
            $siswa = \App\Models\Siswa::with('user')->findOrFail($studentId);
            $totalPoints = Pelanggaran::getTotalPointsForStudent($studentId);
            
            // Get WhatsApp number (parent or student)
            $whatsappNumber = $siswa->getWhatsAppNumber();
            
            if (!$whatsappNumber) {
                \Log::warning("No WhatsApp number found for student: {$siswa->nama} (ID: {$studentId})");
                return;
            }

            // Prepare notification message
            $message = $this->prepareViolationNotificationMessage($siswa, $totalPoints, $latestViolation);
            
            // Send WhatsApp notification
            $whatsappService = new \App\Services\WhatsAppNotificationService();
            $sent = $whatsappService->sendViolationNotification($whatsappNumber, $message);
            
            if ($sent) {
                // Mark notification as sent for the latest violation
                $latestViolation->markNotificationSent($message);
                
                \Log::info("WhatsApp violation notification sent to {$siswa->nama} ({$whatsappNumber})");
            } else {
                \Log::error("Failed to send WhatsApp violation notification to {$siswa->nama}");
            }
            
        } catch (\Exception $e) {
            \Log::error('Error sending violation notification: ' . $e->getMessage());
        }
    }

    /**
     * Prepare WhatsApp notification message for violations
     */
    private function prepareViolationNotificationMessage($siswa, $totalPoints, $latestViolation)
    {
        $message = "🚨 *PERINGATAN PELANGGARAN SISWA* 🚨\n\n";
        $message .= "Kepada Yth. Orang Tua/Wali dari:\n";
        $message .= "👤 *Nama*: {$siswa->nama}\n";
        $message .= "🏫 *Kelas*: {$siswa->kelas}\n";
        $message .= "📚 *Jurusan*: {$siswa->jurusan}\n\n";
        
        $message .= "📊 *INFORMASI PELANGGARAN:*\n";
        $message .= "• Total Poin Pelanggaran: *{$totalPoints} poin*\n";
        $message .= "• Pelanggaran Terbaru: {$latestViolation->jenis_pelanggaran}\n";
        $message .= "• Poin Pelanggaran Terbaru: {$latestViolation->point_pelanggaran} poin\n\n";
        
        $message .= "⚠️ *PERHATIAN:*\n";
        $message .= "Siswa telah mencapai batas kritis pelanggaran (≥65 poin).\n";
        $message .= "Mohon segera menghubungi Guru BK untuk konsultasi lebih lanjut.\n\n";
        
        $message .= "📞 *Hubungi Guru BK:*\n";
        $message .= "SMK SILIWANGI\n";
        $message .= "Jl. Raya Garut - Tasikmalaya\n\n";
        
        $message .= "Terima kasih atas perhatian dan kerjasamanya.\n\n";
        $message .= "_Pesan otomatis dari Sistem Bimbingan Konseling_";
        
        return $message;
    }
}
