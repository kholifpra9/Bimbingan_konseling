<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rekap extends Model
{
    use HasFactory;

    protected $table = 'rekap';
    protected $primarykey = 'id';

    protected $fillable = [
        'id_siswa',
        'jenis_bimbingan',
        'tgl_bimbingan',
        'keterangan',
        'balasan',
        'masalah',
        'solusi',
        'tindak_lanjut',
        'status',
    ];

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id');
    }
}
