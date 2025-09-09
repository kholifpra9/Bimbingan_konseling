<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Konsultasi extends Model
{
    use HasFactory;

    protected $table = 'konsultasi';
    protected $primaryKey = 'id';

    // Status constants
    const STATUS_BELUM_DIBACA = 'belum dibaca';
    const STATUS_SUDAH_DIBACA = 'sudah dibaca';
    const STATUS_DALAM_PERCAKAPAN = 'dalam percakapan';
    const STATUS_SELESAI = 'selesai';

    protected $fillable = [
        'id_siswa',
        'isi_curhat',
        'tgl_curhat',
        'status_baca',
        'attachment',
        'reply_guru',
        'reply_date',
    ];

    protected $casts = [
        'tgl_curhat' => 'datetime',
        'reply_date' => 'datetime',
    ];

    /**
     * Get all valid status values
     */
    public static function getValidStatuses()
    {
        return [
            self::STATUS_BELUM_DIBACA,
            self::STATUS_SUDAH_DIBACA,
            self::STATUS_DALAM_PERCAKAPAN,
            self::STATUS_SELESAI,
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_siswa', 'id');
    }

    public function conversations(): HasMany
    {
        return $this->hasMany(CurhatConversation::class, 'konsultasi_id');
    }

    public function latestConversation()
    {
        return $this->hasOne(CurhatConversation::class, 'konsultasi_id')->latest();
    }

    public function unreadConversations()
    {
        return $this->hasMany(CurhatConversation::class, 'konsultasi_id')->where('is_read', false);
    }
}
