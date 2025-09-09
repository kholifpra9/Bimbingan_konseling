<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswa';
    protected $primarykey = 'id';

    protected $fillable = [
        'nis',
        'nama',
        'kelas',
        'jurusan',
        'jenis_kelamin',
        'no_tlp',
        'no_tlp_ortu',
        'alamat',
        'id_user',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function pelanggaran(): HasMany
    {
        return $this->hasMany(Pelanggaran::class, 'id_siswa', 'id');
    }

    public function cekMasalah(): HasMany
    {
        return $this->hasMany(CekMasalah::class, 'id_siswa', 'id');
    }

    public function pengaduan()
    {
        // siswa.nis -> pengaduan.nis
        return $this->hasMany(\App\Models\Pengaduan::class, 'nis', 'nis');
    }

    /**
     * Calculate total violation points for this student
     */
    public function getTotalPoinPelanggaranAttribute()
    {
        return $this->pelanggaran()->sum('point_pelanggaran');
    }

    /**
     * Check if student has reached critical violation threshold (≥65 points)
     */
    public function hasCriticalViolations()
    {
        return $this->total_poin_pelanggaran >= 65;
    }

    /**
     * Check if notification has been sent for current violation level
     */
    public function hasNotificationSent()
    {
        return $this->pelanggaran()
            ->where('notifikasi_terkirim', true)
            ->where('point_pelanggaran', '>=', 65)
            ->exists();
    }

    /**
     * Get formatted phone number for WhatsApp (parent or student)
     */
    public function getWhatsAppNumber()
    {
        // Prioritize parent's phone number, fallback to student's
        $phoneNumber = $this->no_tlp_ortu ?: $this->no_tlp;
        
        if (!$phoneNumber) {
            return null;
        }

        // Format Indonesian phone number for WhatsApp
        $phoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber);
        
        // Convert 08xx to 628xx format
        if (substr($phoneNumber, 0, 2) === '08') {
            $phoneNumber = '62' . substr($phoneNumber, 1);
        }
        
        // Ensure it starts with 62
        if (substr($phoneNumber, 0, 2) !== '62') {
            $phoneNumber = '62' . $phoneNumber;
        }

        return $phoneNumber;
    }

    public function getRouteKeyName()
    {
        return 'nis';
    }
}


