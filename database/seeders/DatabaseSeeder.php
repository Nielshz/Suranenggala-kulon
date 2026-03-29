<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Default Admin — password auto-hashed Argon2id
        User::create([
            'nama' => 'Administrator',
            'username' => 'admin',
            'password' => 'admin123',
            'keterangan' => 'Super Administrator',
            'status' => 'Admin',
            'desa_kelurahan' => 'Kelurahan',
            'kecamatan' => 'Kecamatan',
            'kabupaten_kota' => 'Kabupaten',
            'provinsi' => 'Provinsi',
            'negara' => 'Indonesia',
            'rt' => '001',
            'rw' => '001',
        ]);

        // Sample RT user
        User::create([
            'nama' => 'Ketua RT',
            'username' => 'rt001',
            'password' => 'rt001123',
            'keterangan' => 'RT 001 RW 001',
            'status' => 'RT',
            'desa_kelurahan' => 'Kelurahan',
            'kecamatan' => 'Kecamatan',
            'kabupaten_kota' => 'Kabupaten',
            'provinsi' => 'Provinsi',
            'negara' => 'Indonesia',
            'rt' => '001',
            'rw' => '001',
        ]);
    }
}
