<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    protected $table = 'laporan';

    protected $fillable = [
        'nama_pelapor', 'no_hp', 'alamat_pelapor', 'subjek',
        'isi_laporan', 'kategori', 'status', 'tanggapan',
        'responded_by', 'responded_at',
    ];

    protected $casts = [
        'responded_at' => 'datetime',
    ];

    public function responder()
    {
        return $this->belongsTo(User::class, 'responded_by');
    }

    /**
     * Generate WhatsApp link to notify admin about this report
     */
    public function getWaLinkAttribute(): string
    {
        $adminPhone = config('app.admin_wa', '6281234567890');
        $text = urlencode(
            "📋 *LAPORAN WARGA BARU*\n\n"
            . "Dari: {$this->nama_pelapor}\n"
            . "HP: {$this->no_hp}\n"
            . "Kategori: {$this->kategori}\n"
            . "Subjek: {$this->subjek}\n\n"
            . "{$this->isi_laporan}\n\n"
            . "— Dikirim dari Website Desa Suranenggala Kulon"
        );
        return "https://wa.me/{$adminPhone}?text={$text}";
    }

    /**
     * Generate WA reply link to pelapor
     */
    public function getWaReplyLinkAttribute(): string
    {
        $phone = preg_replace('/^08/', '628', $this->no_hp);
        $phone = preg_replace('/[^0-9]/', '', $phone);
        $text = urlencode(
            "Yth. Bapak/Ibu {$this->nama_pelapor},\n\n"
            . "Terima kasih atas laporan Anda mengenai: *{$this->subjek}*\n\n"
            . "Status: {$this->status}\n\n"
            . "— Pemerintah Desa Suranenggala Kulon"
        );
        return "https://wa.me/{$phone}?text={$text}";
    }
}
