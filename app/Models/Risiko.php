<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Risiko extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'kode_risiko',
        'nama_risiko',
        'kategori_risiko',
        'deskripsi',

        'sasaran',
        'proyeksi_risiko',
        'tren_risiko',
        'mitigasi_terlaksana',
        'penanggung_jawab',
        'keterangan_pemantauan',

        'penyebab_risiko',
        'dampak_risiko',
        'kontrol_eksisting',
        'kuantifikasi',
        'target_kemungkinan',
        'target_dampak',
        'besaran_risiko_residual',
        'level_risiko_residual',
        'kuantifikasi_residual',
        'kemungkinan',
        'dampak',
        'besaran_risiko',
        'level_risiko',
        'warna_level',
        'rencana_penanganan',
        'batas_waktu',
        'status_penanganan',
        'status_verifikasi',
        'verifikator_id',
        'tanggal_verifikasi',
        'catatan_verifikasi',
        'status_reviu',
        'pereviu_id',
        'tanggal_reviu',
        'catatan_perbaikan',
    ];

    protected $casts = [
        'kemungkinan' => 'integer',
        'dampak' => 'integer',
        'besaran_risiko' => 'integer',
        'batas_waktu' => 'date',
        'tanggal_verifikasi' => 'datetime',
        'tanggal_reviu' => 'datetime',

        'kuantifikasi' => 'decimal:2',
        'kuantifikasi_residual' => 'decimal:2',
        'target_kemungkinan' => 'integer',
        'target_dampak' => 'integer',
        'besaran_risiko_residual' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function verifikator()
    {
        return $this->belongsTo(
            User::class,
            'verifikator_id'
        );
    }

    public function pereviu()
    {
        return $this->belongsTo(
            User::class,
            'pereviu_id'
        );
    }

    public function statusPeringatan(): ?string
    {
        if (
            !$this->batas_waktu
            || $this->status_penanganan === 'Selesai'
        ) {
            return null;
        }

        if ($this->batas_waktu->lt(today())) {
            return 'Terlambat';
        }

        if ($this->batas_waktu->isToday()) {
            return 'Jatuh Tempo Hari Ini';
        }

        if (
            $this->batas_waktu->betweenIncluded(
                today(),
                today()->copy()->addDays(3)
            )
        ) {
            return 'Mendekati Batas Waktu';
        }

        return null;
    }

    public function dapatDieditOlehUpr(): bool
    {
        return $this->status_verifikasi === 'Perlu Perbaikan'
            || $this->status_reviu === 'Perlu Perbaikan';
    }

    public function dapatDihapusOlehUpr(): bool
    {
        return $this->dapatDieditOlehUpr();
    }
}