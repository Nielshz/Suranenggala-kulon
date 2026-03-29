<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 45);
            $table->string('username', 20)->unique();
            $table->string('password'); // Argon2id
            $table->text('keterangan')->nullable();
            $table->enum('status', ['Admin', 'RT', 'RW'])->default('RT');
            $table->string('desa_kelurahan', 30)->nullable();
            $table->string('kecamatan', 30)->nullable();
            $table->string('kabupaten_kota', 30)->nullable();
            $table->string('provinsi', 30)->nullable();
            $table->string('negara', 30)->default('Indonesia');
            $table->string('rt', 3)->nullable();
            $table->string('rw', 3)->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('users');
    }
};
