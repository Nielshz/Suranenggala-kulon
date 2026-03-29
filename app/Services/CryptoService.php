<?php

namespace App\Services;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class CryptoService
{
    /**
     * PASSWORD: Hash using Argon2id
     */
    public function hashPassword(string $password): string
    {
        return Hash::make($password, ['rounds' => 4, 'memory' => 65536, 'threads' => 1]);
    }

    public function verifyPassword(string $password, string $hash): bool
    {
        return Hash::check($password, $hash);
    }

    /**
     * NIK PRIVACY: HMAC-SHA256 for lookup/search
     */
    public function hmacNik(string $nik): string
    {
        $secret = config('app.nik_hmac_secret', env('NIK_HMAC_SECRET'));
        return hash_hmac('sha256', $nik, $secret);
    }

    /**
     * NIK PRIVACY: AES-256-CBC encrypt (reversible, to display NIK)
     */
    public function encryptNik(string $nik): string
    {
        return Crypt::encryptString($nik);
    }

    public function decryptNik(string $encrypted): string
    {
        try {
            return Crypt::decryptString($encrypted);
        } catch (\Exception $e) {
            return '**ERROR DECRYPT**';
        }
    }

    /**
     * DOCUMENT VERIFICATION: SHA-256 hash
     */
    public function hashDocument(array $data): string
    {
        // Sort keys to ensure consistent hash regardless of order
        ksort($data);
        return hash('sha256', json_encode($data, JSON_UNESCAPED_UNICODE));
    }

    public function verifyDocument(array $data, string $hash): bool
    {
        return hash_equals($this->hashDocument($data), $hash);
    }
}
