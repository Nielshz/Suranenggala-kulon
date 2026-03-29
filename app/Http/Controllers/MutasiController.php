<?php

namespace App\Http\Controllers;

use App\Models\Mutasi;
use App\Models\Warga;
use App\Services\CryptoService;
use Illuminate\Http\Request;

class MutasiController extends Controller
{
    protected CryptoService $crypto;

    public function __construct(CryptoService $crypto)
    {
        $this->crypto = $crypto;
    }

    public function index()
    {
        $mutasi = Mutasi::with('user')->orderBy('created_at', 'desc')->get();
        return view('mutasi.index', compact('mutasi'));
    }

    public function create(Request $request)
    {
        $warga = null;
        if ($request->has('warga_id')) {
            $warga = Warga::find($request->warga_id);
        }
        return view('mutasi.create', compact('warga'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required|string|size:16',
            'nama' => 'required|string|max:45',
            'jenis_kelamin' => 'required|in:L,P',
        ]);

        $mutasi = new Mutasi();
        $mutasi->setNikValue($request->nik);
        $mutasi->nama = $request->nama;
        $mutasi->tempat_lahir = $request->tempat_lahir;
        $mutasi->tanggal_lahir = $request->tanggal_lahir;
        $mutasi->jenis_kelamin = $request->jenis_kelamin;
        $mutasi->alamat_ktp = $request->alamat_ktp;
        $mutasi->alamat = $request->alamat;
        $mutasi->desa_kelurahan = $request->desa_kelurahan;
        $mutasi->kecamatan = $request->kecamatan;
        $mutasi->kabupaten_kota = $request->kabupaten_kota;
        $mutasi->provinsi = $request->provinsi;
        $mutasi->negara = $request->negara ?? 'Indonesia';
        $mutasi->rt = $request->rt;
        $mutasi->rw = $request->rw;
        $mutasi->agama = $request->agama;
        $mutasi->pendidikan_terakhir = $request->pendidikan_terakhir;
        $mutasi->pekerjaan = $request->pekerjaan;
        $mutasi->status_perkawinan = $request->status_perkawinan;
        $mutasi->status = $request->status ?? 'Tetap';
        $mutasi->user_id = auth()->id();
        $mutasi->document_hash = $mutasi->generateDocumentHash();
        $mutasi->save();

        // Delete from warga if came from warga
        if ($request->from_warga_id) {
            Warga::find($request->from_warga_id)?->delete();
        }

        return redirect()->route('mutasi.index')->with('success', 'Data mutasi berhasil ditambahkan');
    }

    public function show(Mutasi $mutasi)
    {
        return view('mutasi.show', compact('mutasi'));
    }

    public function destroy(Mutasi $mutasi)
    {
        $mutasi->delete();
        return redirect()->route('mutasi.index')->with('success', 'Data mutasi berhasil dihapus');
    }
}
