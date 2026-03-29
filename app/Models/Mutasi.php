<?php

namespace App\Models;

use App\Services\CryptoService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Mutasi extends Model
{
    protected $table = 'mutasi';

    protected $fillable = [
        'nik_encrypted', 'nik_hash', 'nama', 'tempat_lahir', 'tanggal_lahir',
        'jenis_kelamin', 'alamat_ktp', 'alamat', 'desa_kelurahan', 'kecamatan',
        'kabupaten_kota', 'provinsi', 'negara', 'rt', 'rw', 'agama',
        'pendidikan_terakhir', 'pekerjaan', 'status_perkawinan', 'status',
        'document_hash', 'user_id',
    ];

    protected $appends = ['nik', 'usia'];

    protected function nik(): Attribute
    {
        return Attribute::make(
            get: fn () => app(CryptoService::class)->decryptNik($this->nik_encrypted)
        );
    }

    protected function usia(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (!$this->tanggal_lahir || $this->tanggal_lahir == '0000-00-00') return '-';
                return \Carbon\Carbon::parse($this->tanggal_lahir)->age;
            }
        );
    }

    public function setNikValue(string $nik): void
    {
        $crypto = app(CryptoService::class);
        $this->nik_encrypted = $crypto->encryptNik($nik);
        $this->nik_hash = $crypto->hmacNik($nik);
    }

    public function generateDocumentHash(): string
    {
        $crypto = app(CryptoService::class);
        return $crypto->hashDocument([
            'nik_hash' => $this->nik_hash, 'nama' => $this->nama,
            'tanggal_lahir' => $this->tanggal_lahir, 'jenis_kelamin' => $this->jenis_kelamin,
        ]);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
