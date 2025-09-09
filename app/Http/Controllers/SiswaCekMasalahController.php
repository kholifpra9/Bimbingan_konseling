<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CekMasalah;
use Illuminate\Support\Facades\Auth;

class SiswaCekMasalahController extends Controller
{
    public function create()
    {
        // Updated problem list to match DCM format
        $daftarMasalah = [
            'pribadi' => [
                'Kesehatan',
                'Keadaan Ekonomi', 
                'Kehidupan keluarga',
                'Agama & Moral',
                'Rekreasi & Hoby'
            ],
            'sosial' => [
                'Hub. Pribadi',
                'Kehidupan sos & org',
                'Masalah remaja'
            ],
            'belajar' => [
                'Cara belajar',
                'Penyesuaian thd kurikulum',
                'Kebiasaan Belajar'
            ],
            'karir' => [
                'Masa depan & Cita-cita'
            ]
        ];

        return view('siswa.cek_masalah.create', compact('daftarMasalah'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_masalah' => 'required|array|min:1',
            'masalah_terpilih' => 'required|array|min:1',
            'masalah_lain' => 'nullable|string',
            'tingkat_urgensi' => 'required|in:rendah,sedang,tinggi',
            'deskripsi_tambahan' => 'nullable|string',
        ]);

        $user = Auth::user();
        
        // Cek apakah user memiliki data siswa
        if (!$user->siswa) {
            return redirect()->back()->with('error', 'Data siswa tidak ditemukan. Silakan hubungi administrator.');
        }
        
        // Create new CekMasalah record
        $cekMasalah = new CekMasalah();
        $cekMasalah->id_siswa = $user->siswa->id;
        $cekMasalah->kategori_masalah = $request->kategori_masalah; // Now supports array
        $cekMasalah->masalah_terpilih = $request->masalah_terpilih;
        $cekMasalah->masalah_lain = $request->masalah_lain;
        $cekMasalah->tingkat_urgensi = $request->tingkat_urgensi;
        $cekMasalah->deskripsi_tambahan = $request->deskripsi_tambahan;
        $cekMasalah->status = 'pending';
        $cekMasalah->save();

        // Calculate DCM scoring after saving
        $cekMasalah->calculateDCMScoring();

        return redirect()->route('siswa.cek-masalah.create')->with('success', 'Formulir cek masalah berhasil dikirim.');
    }

    /**
     * Show DCM report for a specific student
     */
    public function showDCMReport($id)
    {
        $cekMasalah = CekMasalah::with('siswa')->findOrFail($id);
        
        // Ensure scoring is calculated
        if (!$cekMasalah->skor_per_kategori) {
            $cekMasalah->calculateDCMScoring();
            $cekMasalah->refresh();
        }

        return view('siswa.cek_masalah.dcm_report', compact('cekMasalah'));
    }
}
