<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PengaduanController extends Controller
{

    // app/Http/Controllers/PengaduanController.php
    public function tandaiDitinjau(\App\Models\Pengaduan $pengaduan)
    {
        // opsional: policy/authorization bisa ditaruh di sini
        $pengaduan->update(['status' => 'ditinjau']);

        return back()->with([
            'message' => 'Pengaduan ditandai sebagai sudah ditinjau.',
            'alert-type' => 'success',
        ]);
    }


    public function index()
    {
        $user = auth()->user();

        $q = \App\Models\Pengaduan::with('siswa');

        if ($user->hasRole('siswa')) {
            // siswa hanya lihat miliknya sendiri (berdasarkan NIS)
            $nis = optional($user->siswa)->nis;   // via relasi user->siswa
            abort_if(!$nis, 403, 'Data siswa tidak ditemukan.');
            $q->where('nis', $nis);

            // Atau alternatif: via whereHas, tetap by NIS karena relasi sudah benar
            // $q->whereHas('siswa', fn($qq) => $qq->where('id_user', $user->id));
        } elseif ($user->hasRole('gurubk|admin')) {
            // guru BK: lihat semua (tanpa filter)
        } else {
            abort(403);
        }

        $pengaduan = $q->latest()->paginate(15);
        return view('pengaduan.index', compact('pengaduan'));
    }


    public function store(Request $request)
    {
        $validate = $request->validate([
            "nis" => 'required|max:10',
            "jenis_pengaduan" => 'required|max:50',
            "gambar" => 'nullable|image',
            "laporan_pengaduan" => 'required|max:50',
            "tgl_pengaduan" => 'required|max:30',
        ]);

        // dd($validate);
        if ($request->hasFile('gambar')) {
            $filename = 'gambar' . time() . '.' . $request->file('gambar')->extension();
            $path = $request->file('gambar')->storeAs('public/images', $filename);
            $validate['gambar'] = $filename;
        } else {
            $validate['gambar'] = null;
        }

        $tanggal = date('Y-m-d');

        $Pengaduan = Pengaduan::create([
            'nis' => $validate['nis'],
            'tgl_pengaduan' => $validate['tgl_pengaduan'],
            'jenis_pengaduan' => $validate['jenis_pengaduan'],
            'gambar' => $validate['gambar'],
            'laporan_pengaduan' => $validate['laporan_pengaduan'],

        ]);

        // WhatsApp Notification Logic for New Complaint
        try {
            // Placeholder phone number for Guru BK (can be made dynamic later)
            $guruBkPhoneNumber = '081234567890';
            
            // Create dynamic message
            $pesan = "Notifikasi Pengaduan Baru: Siswa dengan NIS {$Pengaduan->nis} telah mengirimkan laporan pengaduan. Mohon untuk segera ditindaklanjuti.";
            
            // Send WhatsApp notification via Fonnte API
            $response = Http::withHeaders([
                'Authorization' => env('FONNTE_API_TOKEN')
            ])->post('https://api.fonnte.com/send', [
                'target' => $guruBkPhoneNumber,
                'message' => $pesan
            ]);
            
        } catch (\Exception $e) {
            // Log error if WhatsApp notification fails
            Log::error('Gagal mengirim notifikasi WhatsApp untuk pengaduan baru: ' . $e->getMessage());
        }

        $notification = [
            'message' => 'Data berhasil disimpan',
            'alert-type' => 'success'
        ];

        return redirect()->route('dashboard')->with($notification);
    }

    /**
     * Display the specified resource.
     */
    public function show(\App\Models\Pengaduan $pengaduan)
    {
        $user = auth()->user();

        if ($user->hasRole('gurubk')) {
            return view('pengaduan.show', compact('pengaduan'));
        }

        if ($user->hasRole('siswa')) {
            $nis = optional($user->siswa)->nis;
            abort_if(!$nis || $pengaduan->nis !== $nis, 403);
            return view('pengaduan.show', compact('pengaduan'));
        }

        abort(403);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $siswa = Siswa::all();
        return view('pengaduan.create', compact('siswa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pengaduan = Pengaduan::findOrFail($id);
        $siswa = Siswa::all();
        return view('pengaduan.edit', compact('pengaduan', 'siswa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validate = $request->validate([
            "nis" => 'required|max:10',
            "jenis_pengaduan" => 'required|max:50',
            "gambar" => 'nullable|image',
            "laporan_pengaduan" => 'required|max:255',
            "tgl_pengaduan" => 'required|max:30',
            "status" => 'nullable|in:pending,proses,selesai',
            "tanggapan" => 'nullable|string',
        ]);

        $pengaduan = Pengaduan::findOrFail($id);

        // Handle file upload if new image is provided
        if ($request->hasFile('gambar')) {
            // Delete old image if exists
            if ($pengaduan->gambar && file_exists(storage_path('app/public/images/' . $pengaduan->gambar))) {
                unlink(storage_path('app/public/images/' . $pengaduan->gambar));
            }
            
            $filename = 'gambar' . time() . '.' . $request->file('gambar')->extension();
            $path = $request->file('gambar')->storeAs('public/images', $filename);
            $validate['gambar'] = $filename;
        } else {
            // Keep existing image
            unset($validate['gambar']);
        }

        $pengaduan->update($validate);

        $notification = [
            'message' => 'Data pengaduan berhasil diperbarui',
            'alert-type' => 'success'
        ];

        return redirect()->route('pengaduan.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $Pengaduan = Pengaduan::findOrFail($id);

        $Pengaduan->delete();


        $notification = array(
            'message' => "Data pengaduan berhasil dihapus",
            'alert-type' => 'success'
        );

        return redirect()->route('pengaduan.index')->with($notification);
    }
}

        
