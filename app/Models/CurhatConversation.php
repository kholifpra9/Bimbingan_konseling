<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CurhatConversation extends Model
{
    use HasFactory;

    protected $table = 'curhat_conversations';

    protected $fillable = [
        'konsultasi_id',
        'sender_id',
        'sender_type',
        'message',
        'attachment',
        'is_read',
        'read_at',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];

    public function konsultasi(): BelongsTo
    {
        return $this->belongsTo(Konsultasi::class, 'konsultasi_id');
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function scopeForKonsultasi($query, $konsultasiId)
    {
        return $query->where('konsultasi_id', $konsultasiId)->orderBy('created_at', 'asc');
    }

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function markAsRead()
    {
        $this->update([
            'is_read' => true,
            'read_at' => now(),
        ]);
    }
}
