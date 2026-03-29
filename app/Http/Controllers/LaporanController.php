<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    // ─── Public: form laporan warga (no auth) ───
    public function create()
    {
        return view('laporan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pelapor' => 'required|string|max:100',
            'no_hp' => 'required|string|max:20',
            'subjek' => 'required|string|max:150',
            'isi_laporan' => 'required|string',
            'kategori' => 'required|in:Administrasi,Infrastruktur,Keamanan,Kebersihan,Sosial,Lainnya',
        ]);

        $laporan = Laporan::create([
            'nama_pelapor' => $request->nama_pelapor,
            'no_hp' => $request->no_hp,
            'alamat_pelapor' => $request->alamat_pelapor,
            'subjek' => $request->subjek,
            'isi_laporan' => $request->isi_laporan,
            'kategori' => $request->kategori,
        ]);

        // Redirect to WhatsApp with report auto-filled
        return redirect()->back()
            ->with('success', 'Laporan berhasil dikirim! Nomor tiket: #' . str_pad($laporan->id, 4, '0', STR_PAD_LEFT))
            ->with('wa_link', $laporan->wa_link);
    }

    // ─── Admin: list all laporan ───
    public function index()
    {
        $laporan = Laporan::orderByDesc('created_at')->get();
        $stats = [
            'masuk' => Laporan::where('status', 'Masuk')->count(),
            'proses' => Laporan::where('status', 'Diproses')->count(),
            'selesai' => Laporan::where('status', 'Selesai')->count(),
        ];
        return view('laporan.index', compact('laporan', 'stats'));
    }

    public function show(Laporan $laporan)
    {
        // Mark as read if still "Masuk"
        if ($laporan->status === 'Masuk') {
            $laporan->update(['status' => 'Dibaca']);
        }
        return view('laporan.show', compact('laporan'));
    }

    public function respond(Request $request, Laporan $laporan)
    {
        $request->validate([
            'status' => 'required|in:Dibaca,Diproses,Selesai,Ditolak',
            'tanggapan' => 'nullable|string',
        ]);

        $laporan->update([
            'status' => $request->status,
            'tanggapan' => $request->tanggapan,
            'responded_by' => auth()->id(),
            'responded_at' => now(),
        ]);

        return redirect()->route('laporan.show', $laporan)
            ->with('success', 'Status laporan berhasil diperbarui')
            ->with('wa_reply', $laporan->fresh()->wa_reply_link);
    }

    public function destroy(Laporan $laporan)
    {
        $laporan->delete();
        return redirect()->route('laporan.index')->with('success', 'Laporan berhasil dihapus');
    }
}
