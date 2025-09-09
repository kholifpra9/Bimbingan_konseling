<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GuruBK extends Model
{
    use HasFactory;
    protected $table = 'gurubk';

    protected $fillable = [
        'nip',
        'id_user',
        'nama',
        'jenis_kelamin',
        'no_tlp',
        'alamat'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}
