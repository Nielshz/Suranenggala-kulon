<?php

namespace App\Models;

use App\Services\CryptoService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Warga extends Model
{
    protected $table = 'warga';

    protected $fillable = [
        'nik_encrypted', 'nik_hash', 'nama', 'tempat_lahir', 'tanggal_lahir',
        'jenis_kelamin', 'alamat_ktp', 'alamat', 'desa_kelurahan', 'kecamatan',
        'kabupaten_kota', 'provinsi', 'negara', 'rt', 'rw', 'agama',
        'pendidikan_terakhir', 'pekerjaan', 'status_perkawinan', 'status',
        'document_hash', 'user_id', 'updated_by', 'keterangan_perubahan',
    ];

    protected $appends = ['nik', 'usia'];

    /**
     * Accessor: Decrypt NIK for display
     */
    protected function nik(): Attribute
    {
        return Attribute::make(
            get: function () {
                $crypto = app(CryptoService::class);
                return $crypto->decryptNik($this->nik_encrypted);
            }
        );
    }

    /**
     * Accessor: Calculate age
     */
    protected function usia(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (!$this->tanggal_lahir || $this->tanggal_lahir == '0000-00-00') {
                    return '-';
                }
                return \Carbon\Carbon::parse($this->tanggal_lahir)->age;
            }
        );
    }

    /**
     * Set NIK: auto-encrypt and auto-hash
     */
    public function setNikValue(string $nik): void
    {
        $crypto = app(CryptoService::class);
        $this->nik_encrypted = $crypto->encryptNik($nik);
        $this->nik_hash = $crypto->hmacNik($nik);
    }

    /**
     * Generate document hash (SHA-256) for verification
     */
    public function generateDocumentHash(): string
    {
        $crypto = app(CryptoService::class);
        $data = [
            'nik_hash' => $this->nik_hash,
            'nama' => $this->nama,
            'tempat_lahir' => $this->tempat_lahir,
            'tanggal_lahir' => $this->tanggal_lahir,
            'jenis_kelamin' => $this->jenis_kelamin,
            'alamat' => $this->alamat,
            'rt' => $this->rt,
            'rw' => $this->rw,
        ];
        return $crypto->hashDocument($data);
    }

    /**
     * Verify document integrity
     */
    public function verifyDocument(): bool
    {
        $crypto = app(CryptoService::class);
        $data = [
            'nik_hash' => $this->nik_hash,
            'nama' => $this->nama,
            'tempat_lahir' => $this->tempat_lahir,
            'tanggal_lahir' => $this->tanggal_lahir,
            'jenis_kelamin' => $this->jenis_kelamin,
            'alamat' => $this->alamat,
            'rt' => $this->rt,
            'rw' => $this->rw,
        ];
        return $crypto->verifyDocument($data, $this->document_hash ?? '');
    }

    /**
     * Find warga by plain NIK (using HMAC lookup)
     */
    public static function findByNik(string $nik)
    {
        $crypto = app(CryptoService::class);
        $hash = $crypto->hmacNik($nik);
        return static::where('nik_hash', $hash)->first();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function kartuKeluarga()
    {
        return $this->belongsToMany(KartuKeluarga::class, 'warga_kartu_keluarga');
    }
}
