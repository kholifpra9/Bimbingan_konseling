<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\GuruBK;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Services\WhatsAppNotificationService;

class GuruBkController extends Controller
{
    // Menampilkan daftar guru BK - semua user bisa lihat
    public function index()
    {
        $guru_bk = GuruBK::all();
        return view('guru_bk.index', compact('guru_bk'));
    }

    // Menampilkan detail guru BK
    public function show($id)
    {
        $guru_bk = GuruBK::findOrFail($id);
        return view('guru_bk.show', compact('guru_bk'));
    }

    // Menampilkan daftar curhat rahasia untuk Guru BK dan Siswa
    public function listCurhat()
    {
        $user = auth()->user();
        
        if ($user->hasRole('siswa')) {
            // Siswa hanya bisa melihat curhat miliknya sendiri
            $curhats = \App\Models\Konsultasi::with(['user', 'conversations.sender'])
                ->where('id_siswa', $user->id)
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            // Guru BK bisa melihat semua curhat
            $curhats = \App\Models\Konsultasi::with(['user', 'conversations.sender'])
                ->orderBy('created_at', 'desc')
                ->get();
        }
        
        return view('guru_bk.curhat', compact('curhats'));
    }

    // Menyimpan balasan guru BK atau siswa (komunikasi dua arah)
    public function replyToConsultation(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string|min:5',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
        ]);

        $konsultasi = \App\Models\Konsultasi::findOrFail($id);
        $user = auth()->user();
        
        // Tentukan sender_type berdasarkan role user
        $senderType = $user->hasRole('gurubk') ? 'gurubk' : 'siswa';
        
        // Validasi akses: siswa hanya bisa reply ke curhat miliknya sendiri
        if ($user->hasRole('siswa') && $konsultasi->id_siswa != $user->id) {
            abort(403, 'Anda tidak memiliki akses ke curhat ini.');
        }

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('curhat_attachments', 'public');
        }

        // Simpan pesan ke tabel conversations
        \App\Models\CurhatConversation::create([
            'konsultasi_id' => $konsultasi->id,
            'sender_id' => $user->id,
            'sender_type' => $senderType,
            'message' => $request->message,
            'attachment' => $attachmentPath,
            'is_read' => false,
        ]);

        // Update status konsultasi
        $konsultasi->update([
            'status_baca' => \App\Models\Konsultasi::STATUS_DALAM_PERCAKAPAN,
        ]);

        // Kirim notifikasi WhatsApp menggunakan service
        $whatsappService = new WhatsAppNotificationService();
        
        if ($user->hasRole('gurubk')) {
            // Jika guru yang membalas, kirim notifikasi ke siswa
            $whatsappService->notifyBalasanGuru($konsultasi->id_siswa);
        } else {
            // Jika siswa yang membalas, kirim notifikasi ke guru BK
            $whatsappService->notifyBalasanSiswa($user->name);
        }

        $notification = [
            'message' => 'Pesan berhasil dikirim!',
            'alert-type' => 'success'
        ];

        return redirect()->route('gurubk.curhat')->with($notification);
    }

    // Mark curhat as read
    public function markCurhatAsRead($id)
    {
        $curhat = \App\Models\Konsultasi::findOrFail($id);
        $curhat->update(['status_baca' => \App\Models\Konsultasi::STATUS_SUDAH_DIBACA]);

        $notification = [
            'message' => 'Curhat telah ditandai sebagai sudah dibaca',
            'alert-type' => 'success'
        ];

        return redirect()->route('gurubk.curhat')->with($notification);
    }

    // Menampilkan form tambah guru BK - hanya admin
    public function create()
    {
        // Cek apakah user adalah admin
        if (!auth()->user()->hasRole('admin')) {
            abort(403, 'Anda tidak memiliki akses untuk menambah data guru BK.');
        }
        
        return view('guru_bk.create');
    }

    // Menyimpan guru BK baru - hanya admin
    public function store(Request $request)
    {
        // Cek apakah user adalah admin
        if (!auth()->user()->hasRole('admin')) {
            abort(403, 'Anda tidak memiliki akses untuk menambah data guru BK.');
        }

        $request->validate([
            'nip' => 'required|max:255',
            'nama' => 'required|max:255',
            'email' => 'required|max:255',
            'jenis_kelamin' => 'required|max:255',
            'no_tlp' => 'required|max:255',
            'alamat' => 'required|max:255',
        ]);

        $user = new User();
        $user->name = $request['nama'];
        $user->email = $request['email'];
        $user->password = Hash::make('password');
        $user->save();

        GuruBK::create([
            'nip' => $request->nip,
            'nama' => $request->nama,
            'jenis_kelamin' => $request->jenis_kelamin,
            'no_tlp' => $request->no_tlp,
            'alamat' => $request->alamat,
            'id_user' => $user->id,
        ]);

        $user->assignRole('gurubk');

        $notification = [
            'message' => 'Data Guru_bk berhasil disimpan',
            'alert-type' => 'success'
        ];

        return redirect()->route('guru_bk.index')->with($notification);
    }

    public function edit(string $id)
    {
        // Cek apakah user adalah admin
        if (!auth()->user()->hasRole('admin')) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit data guru BK.');
        }

        $gurubk = GuruBK::findOrFail($id);
        return view('guru_bk.edit', $gurubk);
    }

    public function update(Request $request, string $id)
    {
        // Cek apakah user adalah admin
        if (!auth()->user()->hasRole('admin')) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit data guru BK.');
        }

        // Validate the incoming request
        $validate = $request->validate([
            'nip' => 'required|max:255',
            'nama' => 'required|max:150',
            'jenis_kelamin' => 'required|max:20',
            'no_tlp' => 'required|max:50',
            'alamat' => 'required|max:50',
            'email' => 'required|email|max:255',
        ]);

        $gurubk = GuruBK::findOrFail($id);
        $user = User::find($gurubk->id_user);

        if (!$user) {
            return redirect()->route('guru_bk.index')->with('error', 'User terkait tidak ditemukan.');
        }

        $user->name = $validate['nama'];
        $user->email = $validate['email'];
        $user->save();

        $gurubk->update([
            'nip' => $validate['nip'],
            'nama' => $validate['nama'],
            'jenis_kelamin' => $validate['jenis_kelamin'],
            'no_tlp' => $validate['no_tlp'],
            'alamat' => $validate['alamat'],
            'email' => $validate['email'],
        ]);

        $notification = [
            'message' => 'Data guru bk berhasil diperbaharui',
            'alert-type' => 'success'
        ];

        return redirect()->route('guru_bk.index')->with($notification);
    }

    public function destroy($id)
    {
        // Cek apakah user adalah admin
        if (!auth()->user()->hasRole('admin')) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus data guru BK.');
        }

        $gurubk = GuruBK::findOrFail($id);
        $gurubk->delete();

        $notification = array(
            'message' => 'Data guru bk berhasil dihapus',
            'alert-type' => 'success',
        );

        return redirect()->route('guru_bk.index')->with($notification);
    }

    // ===== FITUR BIMBINGAN LANJUTAN =====
    
    public function bimbinganLanjutan()
    {
        $user = auth()->user();
        
        if ($user->hasRole('siswa')) {
            // Siswa hanya bisa melihat bimbingan lanjutan yang terkait dengan dirinya
            $siswa = \App\Models\Siswa::where('id_user', $user->id)->first();
            if ($siswa) {
                $bimbinganLanjutan = \App\Models\Rekap::where('jenis_bimbingan', 'lanjutan')
                    ->where('id_siswa', $siswa->id)
                    ->with('siswa')
                    ->orderBy('created_at', 'desc')
                    ->get();
            } else {
                $bimbinganLanjutan = collect();
            }
        } else {
            // Guru BK bisa melihat semua bimbingan lanjutan
            $bimbinganLanjutan = \App\Models\Rekap::where('jenis_bimbingan', 'lanjutan')
                ->with('siswa')
                ->orderBy('created_at', 'desc')
                ->get();
        }
        
        return view('guru_bk.bimbingan_lanjutan.index', compact('bimbinganLanjutan'));
    }

    public function createBimbinganLanjutan()
    {
        $siswa = \App\Models\Siswa::all();
        return view('guru_bk.bimbingan_lanjutan.create', compact('siswa'));
    }

    public function storeBimbinganLanjutan(Request $request)
    {
        $request->validate([
            'id_siswa' => 'required|exists:siswa,id',
            'masalah' => 'required|string|min:10',
            'solusi' => 'required|string|min:10',
            'tindak_lanjut' => 'required|string|min:10',
            'tanggal_bimbingan' => 'required|date',
        ]);

        \App\Models\Rekap::create([
            'id_siswa' => $request->id_siswa,
            'masalah' => $request->masalah,
            'solusi' => $request->solusi,
            'tindak_lanjut' => $request->tindak_lanjut,
            'tgl_bimbingan' => $request->tanggal_bimbingan, // Perbaikan: gunakan tgl_bimbingan sesuai database
            'jenis_bimbingan' => 'lanjutan',
            'status' => 'selesai',
        ]);

        // Kirim notifikasi WhatsApp ke siswa menggunakan service
        $whatsappService = new WhatsAppNotificationService();
        $whatsappService->notifyBimbinganLanjutan($request->id_siswa, $request->tanggal_bimbingan);

        $notification = [
            'message' => 'Bimbingan lanjutan berhasil ditambahkan!',
            'alert-type' => 'success'
        ];

        return redirect()->route('gurubk.bimbingan-lanjutan')->with($notification);
    }

    public function editBimbinganLanjutan($id)
    {
        $bimbingan = \App\Models\Rekap::findOrFail($id);
        $siswa = \App\Models\Siswa::all();
        return view('guru_bk.bimbingan_lanjutan.edit', compact('bimbingan', 'siswa'));
    }

    public function updateBimbinganLanjutan(Request $request, $id)
    {
        $request->validate([
            'id_siswa' => 'required|exists:siswa,id',
            'masalah' => 'required|string|min:10',
            'solusi' => 'required|string|min:10',
            'tindak_lanjut' => 'required|string|min:10',
            'tanggal_bimbingan' => 'required|date',
        ]);

        $bimbingan = \App\Models\Rekap::findOrFail($id);
        $bimbingan->update([
            'id_siswa' => $request->id_siswa,
            'masalah' => $request->masalah,
            'solusi' => $request->solusi,
            'tindak_lanjut' => $request->tindak_lanjut,
            'tgl_bimbingan' => $request->tanggal_bimbingan, // Perbaikan: gunakan tgl_bimbingan sesuai database
        ]);

        $notification = [
            'message' => 'Bimbingan lanjutan berhasil diperbarui!',
            'alert-type' => 'success'
        ];

        return redirect()->route('gurubk.bimbingan-lanjutan')->with($notification);
    }

    public function destroyBimbinganLanjutan($id)
    {
        $bimbingan = \App\Models\Rekap::findOrFail($id);
        $bimbingan->delete();

        $notification = [
            'message' => 'Bimbingan lanjutan berhasil dihapus!',
            'alert-type' => 'success'
        ];

        return redirect()->route('gurubk.bimbingan-lanjutan')->with($notification);
    }

    // ===== FITUR DAFTAR CEK MASALAH =====
    
    // Menampilkan hasil daftar cek masalah yang sudah diisi siswa
    public function daftarCekMasalah()
    {
        $cekMasalahs = \App\Models\CekMasalah::with('siswa')->orderBy('created_at', 'desc')->get();
        return view('guru_bk.daftar_cek_masalah.hasil', compact('cekMasalahs'));
    }

    // Review dan tindak lanjut cek masalah siswa
    public function reviewCekMasalah(Request $request, $id)
    {
        $cekMasalah = \App\Models\CekMasalah::findOrFail($id);
        
        $request->validate([
            'catatan_guru' => 'required|string',
            'tindak_lanjut' => 'required|string',
            'status' => 'required|in:reviewed,follow_up,completed'
        ]);

        $cekMasalah->update([
            'catatan_guru' => $request->catatan_guru,
            'tindak_lanjut' => $request->tindak_lanjut,
            'status' => $request->status,
            'tanggal_review' => now(),
        ]);

        // Send WhatsApp notification to student
        try {
            $whatsappService = new WhatsAppNotificationService();
            $whatsappService->notifyHasilCekMasalah($cekMasalah);
        } catch (\Exception $e) {
            \Log::error('Failed to send WhatsApp notification for cek masalah review: ' . $e->getMessage());
        }

        $notification = [
            'message' => 'Review berhasil disimpan dan notifikasi telah dikirim ke siswa.',
            'alert-type' => 'success'
        ];

        return redirect()->route('gurubk.daftar-cek-masalah')->with($notification);
    }

    /**
     * Cetak surat pemanggilan orang tua
     */
    public function cetakSuratPemanggilan($id)
    {
        $cekMasalah = \App\Models\CekMasalah::with('siswa')->findOrFail($id);
        
        // Data sekolah - bisa diambil dari config atau database
        $dataSekolah = [
            'nama' => 'SMK Negeri 1 Cilaku',
            'alamat' => 'Jl. Raya Cilaku No. 123, Cilaku, Cianjur',
            'telepon' => '(0263) 123456',
            'email' => 'info@smkn1cilaku.sch.id',
            'website' => 'www.smkn1cilaku.sch.id',
            'kepala_sekolah' => 'Drs. H. Ahmad Suryadi, M.Pd',
            'guru_bk' => auth()->user()->name ?? 'Guru BK'
        ];

        return view('guru_bk.surat_pemanggilan.cetak', compact('cekMasalah', 'dataSekolah'));
    }
}
