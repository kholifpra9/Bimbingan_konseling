<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    use HasFactory;

    protected $table = 'pengaduan';

    protected $fillable = [
        'nis',
        'jenis_pengaduan',
        'gambar',
        'tgl_pengaduan',
        'laporan_pengaduan',
        'status',
    ];

    public function siswa()
    {
        // pengaduan.nis -> siswa.nis
        return $this->belongsTo(\App\Models\Siswa::class, 'nis', 'nis');
    }
}
