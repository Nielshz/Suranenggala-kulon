<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('warga', function (Blueprint $table) {
            $table->id();
            $table->text('nik_encrypted'); // AES-256-CBC via Laravel Crypt
            $table->string('nik_hash', 64)->index(); // HMAC-SHA256 for lookup
            $table->string('nama', 45);
            $table->string('tempat_lahir', 30)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->text('alamat_ktp')->nullable();
            $table->text('alamat')->nullable();
            $table->string('desa_kelurahan', 30)->nullable();
            $table->string('kecamatan', 30)->nullable();
            $table->string('kabupaten_kota', 30)->nullable();
            $table->string('provinsi', 30)->nullable();
            $table->string('negara', 30)->default('Indonesia');
            $table->string('rt', 3)->nullable();
            $table->string('rw', 3)->nullable();
            $table->enum('agama', ['Islam', 'Kristen', 'Katholik', 'Hindu', 'Budha', 'Konghucu'])->nullable();
            $table->string('pendidikan_terakhir', 20)->nullable();
            $table->string('pekerjaan', 30)->nullable();
            $table->enum('status_perkawinan', ['Kawin', 'Tidak Kawin'])->nullable();
            $table->enum('status', ['Tetap', 'Kontrak'])->default('Tetap');
            $table->string('document_hash', 64)->nullable(); // SHA-256
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('kartu_keluarga', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_keluarga', 16);
            $table->foreignId('kepala_keluarga_id')->constrained('warga')->onDelete('cascade');
            $table->text('alamat')->nullable();
            $table->string('desa_kelurahan', 30)->nullable();
            $table->string('kecamatan', 30)->nullable();
            $table->string('kabupaten_kota', 30)->nullable();
            $table->string('provinsi', 30)->nullable();
            $table->string('negara', 30)->default('Indonesia');
            $table->string('rt', 3)->nullable();
            $table->string('rw', 3)->nullable();
            $table->string('kode_pos', 5)->nullable();
            $table->string('document_hash', 64)->nullable(); // SHA-256
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('warga_kartu_keluarga', function (Blueprint $table) {
            $table->foreignId('warga_id')->constrained('warga')->onDelete('cascade');
            $table->foreignId('kartu_keluarga_id')->constrained('kartu_keluarga')->onDelete('cascade');
            $table->primary(['warga_id', 'kartu_keluarga_id']);
        });

        Schema::create('mutasi', function (Blueprint $table) {
            $table->id();
            $table->text('nik_encrypted');
            $table->string('nik_hash', 64)->index();
            $table->string('nama', 45);
            $table->string('tempat_lahir', 30)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->text('alamat_ktp')->nullable();
            $table->text('alamat')->nullable();
            $table->string('desa_kelurahan', 30)->nullable();
            $table->string('kecamatan', 30)->nullable();
            $table->string('kabupaten_kota', 30)->nullable();
            $table->string('provinsi', 30)->nullable();
            $table->string('negara', 30)->default('Indonesia');
            $table->string('rt', 3)->nullable();
            $table->string('rw', 3)->nullable();
            $table->enum('agama', ['Islam', 'Kristen', 'Katholik', 'Hindu', 'Budha', 'Konghucu'])->nullable();
            $table->string('pendidikan_terakhir', 20)->nullable();
            $table->string('pekerjaan', 30)->nullable();
            $table->enum('status_perkawinan', ['Kawin', 'Tidak Kawin'])->nullable();
            $table->enum('status', ['Tetap', 'Kontrak'])->default('Tetap');
            $table->string('document_hash', 64)->nullable();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('galeri', function (Blueprint $table) {
            $table->id();
            $table->string('path', 100);
            $table->text('caption')->nullable();
            $table->string('tautan', 100)->nullable();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('galeri');
        Schema::dropIfExists('mutasi');
        Schema::dropIfExists('warga_kartu_keluarga');
        Schema::dropIfExists('kartu_keluarga');
        Schema::dropIfExists('warga');
    }
};
