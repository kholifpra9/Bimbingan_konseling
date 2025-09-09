<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CekMasalah extends Model
{
    use HasFactory;

    protected $table = 'cek_masalahs';
    
    protected $fillable = [
        'id_siswa',
        'kategori_masalah',
        'masalah_terpilih',
        'masalah_lain',
        'tingkat_urgensi',
        'deskripsi_tambahan',
        'status',
        'catatan_guru',
        'tindak_lanjut',
        'tanggal_review',
        'tanggal_tindak_lanjut',
        'nomor_masalah_per_kategori',
        'skor_per_kategori',
        'total_masalah',
        'persentase_keseluruhan',
    ];

    protected $casts = [
        'masalah_terpilih' => 'array',
        'kategori_masalah' => 'array',
        'nomor_masalah_per_kategori' => 'array',
        'skor_per_kategori' => 'array',
        'tanggal_review' => 'datetime',
        'tanggal_tindak_lanjut' => 'datetime',
    ];

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id');
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => 'bg-yellow-100 text-yellow-800',
            'reviewed' => 'bg-blue-100 text-blue-800',
            'follow_up' => 'bg-orange-100 text-orange-800',
            'completed' => 'bg-green-100 text-green-800',
        ];

        return $badges[$this->status] ?? 'bg-gray-100 text-gray-800';
    }

    public function getStatusTextAttribute()
    {
        $texts = [
            'pending' => 'Menunggu Review',
            'reviewed' => 'Sudah Direview',
            'follow_up' => 'Tindak Lanjut',
            'completed' => 'Selesai',
        ];

        return $texts[$this->status] ?? 'Unknown';
    }

    public function getUrgencyBadgeAttribute()
    {
        $badges = [
            'rendah' => 'bg-green-100 text-green-800',
            'sedang' => 'bg-yellow-100 text-yellow-800',
            'tinggi' => 'bg-red-100 text-red-800',
        ];

        return $badges[$this->tingkat_urgensi] ?? 'bg-gray-100 text-gray-800';
    }

    /**
     * Get the DCM problem mapping with numbers
     */
    public static function getDaftarMasalahWithNumbers()
    {
        return [
            'pribadi' => [
                1 => 'Kesehatan',
                2 => 'Keadaan Ekonomi',
                3 => 'Kehidupan keluarga',
                4 => 'Agama & Moral',
                5 => 'Rekreasi & Hoby'
            ],
            'sosial' => [
                6 => 'Hub. Pribadi',
                7 => 'Kehidupan sos & org',
                8 => 'Masalah remaja'
            ],
            'belajar' => [
                9 => 'Cara belajar',
                10 => 'Penyesuaian thd kurikulum',
                11 => 'Kebiasaan Belajar'
            ],
            'karir' => [
                12 => 'Masa depan & Cita-cita'
            ]
        ];
    }

    /**
     * Calculate DCM scoring for each category
     */
    public function calculateDCMScoring()
    {
        $daftarMasalah = self::getDaftarMasalahWithNumbers();
        $masalahTerpilih = $this->masalah_terpilih ?? [];
        $kategoriMasalah = $this->kategori_masalah ?? [];
        
        $skorPerKategori = [];
        $nomorMasalahPerKategori = [];
        $totalMasalah = 0;

        foreach ($kategoriMasalah as $kategori) {
            if (!isset($daftarMasalah[$kategori])) continue;
            
            $masalahKategori = $daftarMasalah[$kategori];
            $totalMasalahKategori = count($masalahKategori);
            $masalahTerpilihKategori = [];
            $nomorTerpilih = [];
            
            // Find selected problems in this category
            foreach ($masalahTerpilih as $masalah) {
                foreach ($masalahKategori as $nomor => $namaMasalah) {
                    if ($masalah === $namaMasalah) {
                        $masalahTerpilihKategori[] = $masalah;
                        $nomorTerpilih[] = $nomor;
                        break;
                    }
                }
            }
            
            $jumlahTerpilih = count($masalahTerpilihKategori);
            $persentase = $totalMasalahKategori > 0 ? ($jumlahTerpilih / $totalMasalahKategori) * 100 : 0;
            
            $skorPerKategori[$kategori] = [
                'jumlah_terpilih' => $jumlahTerpilih,
                'total_masalah' => $totalMasalahKategori,
                'persentase' => round($persentase, 0),
                'kategori_masalah' => $this->getKategoriMasalah($persentase)
            ];
            
            $nomorMasalahPerKategori[$kategori] = $nomorTerpilih;
            $totalMasalah += $jumlahTerpilih;
        }

        // Calculate overall percentage
        $totalKeseluruhan = array_sum(array_column($daftarMasalah, null));
        $totalKeseluruhan = count($daftarMasalah['pribadi']) + count($daftarMasalah['sosial']) + 
                           count($daftarMasalah['belajar']) + count($daftarMasalah['karir']);
        
        $persentaseKeseluruhan = $totalKeseluruhan > 0 ? ($totalMasalah / $totalKeseluruhan) * 100 : 0;

        // Update the model
        $this->update([
            'skor_per_kategori' => $skorPerKategori,
            'nomor_masalah_per_kategori' => $nomorMasalahPerKategori,
            'total_masalah' => $totalMasalah,
            'persentase_keseluruhan' => round($persentaseKeseluruhan, 2)
        ]);

        return [
            'skor_per_kategori' => $skorPerKategori,
            'nomor_masalah_per_kategori' => $nomorMasalahPerKategori,
            'total_masalah' => $totalMasalah,
            'persentase_keseluruhan' => round($persentaseKeseluruhan, 2)
        ];
    }

    /**
     * Get problem category based on percentage
     */
    private function getKategoriMasalah($persentase)
    {
        if ($persentase > 50) {
            return 'BERMASALAH';
        } elseif ($persentase >= 26) {
            return 'CUKUP BERMASALAH';
        } elseif ($persentase >= 11) {
            return 'AGAK BERMASALAH';
        } else {
            return 'TIDAK BERMASALAH';
        }
    }

    /**
     * Get color class for category
     */
    public function getKategoriColor($kategori)
    {
        $colors = [
            'pribadi' => 'text-purple-600',
            'sosial' => 'text-green-600', 
            'belajar' => 'text-blue-600',
            'karir' => 'text-orange-600'
        ];

        return $colors[$kategori] ?? 'text-gray-600';
    }

    /**
     * Get kategori masalah as string for display
     */
    public function getKategoriMasalahStringAttribute()
    {
        if (is_array($this->kategori_masalah)) {
            return implode(', ', array_map('ucfirst', $this->kategori_masalah));
        }
        return ucfirst($this->kategori_masalah ?? '');
    }

    /**
     * Get appropriate badge class for kategori masalah
     */
    public function getKategoriMasalahBadgeAttribute()
    {
        $kategori = is_array($this->kategori_masalah) ? $this->kategori_masalah[0] : $this->kategori_masalah;
        
        $badges = [
            'akademik' => 'bg-blue-100 text-blue-800',
            'belajar' => 'bg-blue-100 text-blue-800',
            'sosial' => 'bg-green-100 text-green-800',
            'pribadi' => 'bg-purple-100 text-purple-800',
            'karir' => 'bg-orange-100 text-orange-800',
        ];

        return $badges[$kategori] ?? 'bg-gray-100 text-gray-800';
    }
}
