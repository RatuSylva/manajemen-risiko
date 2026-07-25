<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatRisiko extends Model
{
    use HasFactory;

    protected $fillable = [
        'risiko_id',
        'user_id',
        'role_pengguna',
        'jenis_aktivitas',
        'status_sebelum',
        'status_sesudah',
        'data_sebelum',
        'data_sesudah',
        'deskripsi',
    ];

    protected $casts = [
        'data_sebelum' => 'array',
        'data_sesudah' => 'array',
    ];

    public function risiko()
    {
        return $this->belongsTo(Risiko::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}