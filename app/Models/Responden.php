<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Responden extends Model
{
    use SoftDeletes;

    protected $table = 'responden'; // Menegaskan nama tabel jika bukan jamak (respondens)

    protected $fillable = [
        'user_id',
        'nama',
        'jenis_kelamin',
        'profesi',
        'unit_kerja',
    ];

    // Relasi balik ke User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
