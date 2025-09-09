<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Rekap;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RekapController extends Controller
{
    // Tidak ada middleware khusus di controller ini
    // Middleware diatur di routes/web.php
    public function selesai(Rekap $rekap)
    {
        // hanya gurubk (sudah diproteksi middleware), aman langsung update
        if ($rekap->status !== 'selesai') {
            $rekap->update(['status' => 'selesai']);
        }

        return back()->with('success', 'Bimbingan ditandai selesai.');
    }

    public function index()
    {
        $user = auth()->user();

        $q = \App\Models\Rekap::with('siswa');

        if ($user->hasRole('siswa')) {
            // siswa hanya lihat milik sendiri
            $q->whereHas('siswa', fn($qq) => $qq->where('id_user', $user->id));
        } elseif ($user->hasRole('gurubk')) {
            // guru bk: semua data (tidak filter)
        } else {
            // role lain: sesuaikan kebijakanmu, misal juga tidak boleh melihat
            abort(403);
        }

        $rekap = $q->latest()->paginate(15);
        return view("rekap.index", compact('rekap'));
    }

    // Menampilkan form tambah akun pelanggaran
    public function create()
    {
        $user = auth()->user();
        $mySiswa = null;

        if ($user->hasRole('siswa')) {
            // sesuaikan kolom relasi (mis. user_id) dengan skema kamu
            $mySiswa = Siswa::select('id','nis','nama','kelas')
                ->where('id_user', $user->id)
                ->first(); // firstOrFail() jika wajib ada
        }

        // daftar siswa untuk Guru BK
        $siswas = Siswa::select('id','nis','nama','kelas')
            ->orderBy('nama')
            ->get();

        return view('rekap.create', compact('siswas','mySiswa'));
    }

    // Menyimpan akun rekap baru
    public function store(Request $request)
    {
        $request->validate([
            'id_siswa' => 'required|max:255',
            'jenis_bimbingan' => 'required|max:150',
            'tgl_bimbingan' => 'required|max:20',
            'keterangan' => 'required',
        ]);
        
        Rekap::create([
            'id_siswa' => $request->id_siswa,
            'jenis_bimbingan' => $request->jenis_bimbingan,
            'tgl_bimbingan' => $request->tgl_bimbingan,
            'keterangan' => $request->keterangan,
        ]);

        $notification = [
            'message' => 'Data rekap bimbingan berhasil disimpan',
            'alert-type' => 'success'
        ];

        return redirect()->route('rekap.index')->with($notification);
    }

    public function edit(string $id)
    {
        $bimbingan = Rekap::findOrFail($id);
        return view('rekap.edit', ['bimbingan' => $bimbingan]);
    }

    public function update(Request $request, string $id)
    {   
    // Validasi data
    $validated = $request->validate([
        'balasan' => 'required|string',
    ]);

    // Temukan data Rekap berdasarkan ID
    $rekap = Rekap::findOrFail($id);

    // Update data balasan
    $rekap->update([
        'balasan' => $validated['balasan'],
    ]);

    // WhatsApp Notification Logic for Guru BK Reply
    try {
        // Get student data from related Siswa model
        $siswa = $rekap->siswa;
        
        // Check if student data and phone number exist
        if ($siswa && $siswa->no_tlp) {
            // Create personalized message for student
            $pesan = "Info Bimbingan: Halo {$siswa->nama}, Guru BK telah memberikan balasan untuk sesi bimbingan Anda tanggal {$rekap->tgl_bimbingan}. Silakan periksa aplikasi untuk melihat detailnya.";
            
            // Send WhatsApp notification via Fonnte API
            $response = Http::withHeaders([
                'Authorization' => env('FONNTE_API_TOKEN')
            ])->post('https://api.fonnte.com/send', [
                'target' => $siswa->no_tlp,
                'message' => $pesan
            ]);
        }
        
    } catch (\Exception $e) {
        // Log error if WhatsApp notification fails
        Log::error('Gagal mengirim notifikasi WhatsApp untuk balasan bimbingan: ' . $e->getMessage());
    }

    // Berikan notifikasi keberhasilan
    $notification = [
        'message' => 'Data rekap siswa berhasil diperbarui.',
        'alert-type' => 'success',
    ];

    return redirect()->route('rekap.index')->with($notification);
}

public function destroy($id)
    {
        $rekap = Rekap::findOrFail($id);
        $rekap->delete();

        $notification = array(
            'message' => 'Data rekap berhasil dihapus',
            'alert-type' => 'success',
        );

    return redirect()->route('rekap.index')->with($notification);
}
}