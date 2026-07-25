<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    public function risikos()
    {
        return $this->hasMany(
            Risiko::class,
            'user_id'
        );
    }

    public function risikoDiverifikasi()
    {
        return $this->hasMany(
            Risiko::class,
            'verifikator_id'
        );
    }

    public function risikoDireviu()
    {
        return $this->hasMany(
            Risiko::class,
            'pereviu_id'
        );
    }

    public function riwayatRisiko()
    {
        return $this->hasMany(
            RiwayatRisiko::class,
            'user_id'
        );
    }

    public function aktif(): bool
    {
        return $this->is_active === true;
    }
}