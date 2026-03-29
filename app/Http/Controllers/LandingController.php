<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use App\Models\Laporan;

class LandingController extends Controller
{
    public function index()
    {
        $pengumuman = Pengumuman::active()
            ->orderByDesc('created_at')
            ->take(6)
            ->get();

        $laporanCount = Laporan::where('status', '!=', 'Selesai')->count();

        return view('landing', compact('pengumuman', 'laporanCount'));
    }
}
