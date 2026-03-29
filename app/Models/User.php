<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'nama', 'username', 'password', 'keterangan', 'status',
        'desa_kelurahan', 'kecamatan', 'kabupaten_kota', 'provinsi', 'negara', 'rt', 'rw',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'password' => 'hashed', // Auto-hash with Argon2id
        ];
    }

    public function warga()
    {
        return $this->hasMany(Warga::class);
    }

    public function kartuKeluarga()
    {
        return $this->hasMany(KartuKeluarga::class);
    }

    public function mutasi()
    {
        return $this->hasMany(Mutasi::class);
    }

    public function galeri()
    {
        return $this->hasMany(Galeri::class);
    }
}
