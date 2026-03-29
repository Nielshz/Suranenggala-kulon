<?php

namespace App\Http\Controllers;

use App\Models\Warga;
use App\Models\KartuKeluarga;
use App\Models\Mutasi;
use App\Models\Laporan;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_warga' => Warga::count(),
            'warga_l' => Warga::where('jenis_kelamin', 'L')->count(),
            'warga_p' => Warga::where('jenis_kelamin', 'P')->count(),
            'warga_gte17' => Warga::whereNotNull('tanggal_lahir')->where('tanggal_lahir', '<=', now()->subYears(17)->format('Y-m-d'))->count(),
            'warga_lt17' => Warga::whereNotNull('tanggal_lahir')->where('tanggal_lahir', '>', now()->subYears(17)->format('Y-m-d'))->count(),
            'total_kk' => KartuKeluarga::count(),
            'total_mutasi' => Mutasi::count(),
            'mutasi_l' => Mutasi::where('jenis_kelamin', 'L')->count(),
            'mutasi_p' => Mutasi::where('jenis_kelamin', 'P')->count(),
            'laporan_masuk' => Laporan::where('status', 'Masuk')->count(),
            'laporan_total' => Laporan::count(),
        ];

        return view('dashboard.index', compact('stats'));
    }
}
