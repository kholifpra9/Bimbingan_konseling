<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pelanggaran extends Model
{
    use HasFactory;

    protected $table = 'pelanggaran';
    protected $primarykey = 'id_siswa';

    protected $fillable = [
        'id_siswa',
        'jenis_pelanggaran',
        'point_pelanggaran',
        'notifikasi_terkirim',
        'tanggal_notifikasi',
        'pesan_notifikasi',
    ];

    protected $casts = [
        'notifikasi_terkirim' => 'boolean',
        'tanggal_notifikasi' => 'datetime',
    ];

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id');
    }

    /**
     * Mark notification as sent
     */
    public function markNotificationSent($message = null)
    {
        $this->update([
            'notifikasi_terkirim' => true,
            'tanggal_notifikasi' => now(),
            'pesan_notifikasi' => $message
        ]);
    }

    /**
     * Get total points for a specific student
     */
    public static function getTotalPointsForStudent($studentId)
    {
        return self::where('id_siswa', $studentId)->sum('point_pelanggaran');
    }
    

    /**
     * Check if student needs notification (≥65 points and no notification sent)
     */
    public static function needsNotification($studentId)
    {
        $totalPoints = self::getTotalPointsForStudent($studentId);
        
        if ($totalPoints < 65) {
            return false;
        }

        // Check if notification already sent for this threshold
        $hasNotification = self::where('id_siswa', $studentId)
            ->where('notifikasi_terkirim', true)
            ->exists();

        return !$hasNotification;
    }
    
}
