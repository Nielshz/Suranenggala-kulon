<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KartuKeluarga extends Model
{
    protected $table = 'kartu_keluarga';

    protected $fillable = [
        'nomor_keluarga', 'kepala_keluarga_id', 'alamat', 'desa_kelurahan',
        'kecamatan', 'kabupaten_kota', 'provinsi', 'negara', 'rt', 'rw',
        'kode_pos', 'document_hash', 'user_id',
    ];

    public function kepalaKeluarga()
    {
        return $this->belongsTo(Warga::class, 'kepala_keluarga_id');
    }

    public function anggota()
    {
        return $this->belongsToMany(Warga::class, 'warga_kartu_keluarga');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function generateDocumentHash(): string
    {
        $crypto = app(\App\Services\CryptoService::class);
        return $crypto->hashDocument([
            'nomor_keluarga' => $this->nomor_keluarga,
            'kepala_keluarga_id' => $this->kepala_keluarga_id,
            'alamat' => $this->alamat,
            'rt' => $this->rt,
            'rw' => $this->rw,
        ]);
    }
}
