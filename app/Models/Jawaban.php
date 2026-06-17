<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Jawaban extends Model
{
    protected $table = 'jawaban'; // Menegaskan nama tabel jika bukan jamak (respondens)

    protected $fillable = [
        'user_id',
        'pertanyaan_id',
        'skor_likert',
        'durasi_detik',
    ];

    // Relasi balik ke User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function pertanyaan()
    {
        return $this->belongsTo(Pertanyaan::class, 'pertanyaan_id');
    }
}
