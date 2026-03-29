<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add audit trail to warga
        Schema::table('warga', function (Blueprint $table) {
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('keterangan_perubahan')->nullable();
        });

        // Pengumuman (announcements)
        Schema::create('pengumuman', function (Blueprint $table) {
            $table->id();
            $table->string('judul', 150);
            $table->text('isi');
            $table->enum('kategori', ['Umum', 'Penting', 'Kegiatan', 'Layanan'])->default('Umum');
            $table->boolean('is_active')->default(true);
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });

        // Laporan warga (citizen reports)
        Schema::create('laporan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pelapor', 100);
            $table->string('no_hp', 20);
            $table->string('alamat_pelapor')->nullable();
            $table->string('subjek', 150);
            $table->text('isi_laporan');
            $table->enum('kategori', ['Administrasi', 'Infrastruktur', 'Keamanan', 'Kebersihan', 'Sosial', 'Lainnya'])->default('Lainnya');
            $table->enum('status', ['Masuk', 'Dibaca', 'Diproses', 'Selesai', 'Ditolak'])->default('Masuk');
            $table->text('tanggapan')->nullable();
            $table->foreignId('responded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('responded_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan');
        Schema::dropIfExists('pengumuman');
        Schema::table('warga', function (Blueprint $table) {
            $table->dropForeign(['updated_by']);
            $table->dropColumn(['updated_by', 'keterangan_perubahan']);
        });
    }
};
