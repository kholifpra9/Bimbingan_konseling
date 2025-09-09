<?php

namespace App\Http\Controllers;

use App\Models\Konsultasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Services\WhatsAppNotificationService;

class KonsultasiController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        if ($user->hasRole('siswa')) {
            // Siswa hanya bisa melihat konsultasi miliknya sendiri
            $konsultasi = Konsultasi::with(['user', 'conversations.sender'])
                ->where('id_siswa', $user->id)
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            // Guru BK bisa melihat semua konsultasi
            $konsultasi = Konsultasi::with(['user', 'conversations.sender'])
                ->orderBy('created_at', 'desc')
                ->get();
        }
        
        return view('konsultasi.index', compact('konsultasi'));
    }

    public function show($id)
    {
        $konsultasi = Konsultasi::with(['user', 'conversations.sender'])->findOrFail($id);
        $user = auth()->user();
        
        // Validasi akses: siswa hanya bisa melihat konsultasi miliknya sendiri
        if ($user->hasRole('siswa') && $konsultasi->id_siswa != $user->id) {
            abort(403, 'Anda tidak memiliki akses ke konsultasi ini.');
        }
        
        return view('konsultasi.show', compact('konsultasi'));
    }

    public function create()
    {
        return view('konsultasi.create');
    }

    public function balas(Request $request)
    {
        $request->validate([
            'konsultasi_id' => 'required|exists:konsultasi,id',
            'message' => 'required|string|min:5',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
        ]);

        $konsultasi = Konsultasi::findOrFail($request->konsultasi_id);
        $user = auth()->user();
        
        // Tentukan sender_type berdasarkan role user
        $senderType = $user->hasRole('gurubk') ? 'gurubk' : 'siswa';
        
        // Validasi akses: siswa hanya bisa reply ke konsultasi miliknya sendiri
        if ($user->hasRole('siswa') && $konsultasi->id_siswa != $user->id) {
            abort(403, 'Anda tidak memiliki akses ke konsultasi ini.');
        }

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('konsultasi_attachments', 'public');
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
            'status_baca' => Konsultasi::STATUS_DALAM_PERCAKAPAN,
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
            'message' => 'Balasan berhasil dikirim!',
            'alert-type' => 'success'
        ];

        return redirect()->route('konsultasi.index')->with($notification);
    }

    public function store(Request $request)
    {
        $request->validate([
            'isi_curhat' => 'required|string|min:10',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120', // Max 5MB
        ]);

        $attachmentPath = null;
        
        // Handle file upload
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $attachmentPath = $file->storeAs('konsultasi_attachments', $fileName, 'public');
        }

        Konsultasi::create([
            'id_siswa' => Auth::user()->id,
            'isi_curhat' => $request->isi_curhat,
            'tgl_curhat' => now(),
            'status_baca' => Konsultasi::STATUS_BELUM_DIBACA,
            'attachment' => $attachmentPath,
        ]);

        // Kirim notifikasi WhatsApp ke Guru BK menggunakan service
        $whatsappService = new WhatsAppNotificationService();
        $whatsappService->notifyCurhatBaru(Auth::user()->id);

        $notification = ['message' => 'Curhat rahasia berhasil dikirim!', 'alert-type' => 'success'];
        return redirect()->route('konsultasi.create')->with($notification);
    }
}
