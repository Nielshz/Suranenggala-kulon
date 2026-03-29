<?php

namespace App\Http\Controllers;

use App\Models\KartuKeluarga;
use App\Models\Warga;
use Illuminate\Http\Request;

class KartuKeluargaController extends Controller
{
    public function index()
    {
        $kartuKeluarga = KartuKeluarga::with(['kepalaKeluarga', 'anggota'])->orderBy('created_at', 'desc')->get();
        return view('kartu-keluarga.index', compact('kartuKeluarga'));
    }

    public function create()
    {
        $warga = Warga::orderBy('nama')->get();
        return view('kartu-keluarga.create', compact('warga'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_keluarga' => 'required|string|max:16',
            'kepala_keluarga_id' => 'required|exists:warga,id',
        ]);

        $kk = KartuKeluarga::create([
            'nomor_keluarga' => $request->nomor_keluarga,
            'kepala_keluarga_id' => $request->kepala_keluarga_id,
            'alamat' => $request->alamat,
            'desa_kelurahan' => $request->desa_kelurahan,
            'kecamatan' => $request->kecamatan,
            'kabupaten_kota' => $request->kabupaten_kota,
            'provinsi' => $request->provinsi,
            'negara' => $request->negara ?? 'Indonesia',
            'rt' => $request->rt,
            'rw' => $request->rw,
            'kode_pos' => $request->kode_pos,
            'user_id' => auth()->id(),
        ]);
        $kk->document_hash = $kk->generateDocumentHash();
        $kk->save();

        return redirect()->route('kartu-keluarga.index')->with('success', 'Data KK berhasil ditambahkan');
    }

    public function show(KartuKeluarga $kartuKeluarga)
    {
        $kartuKeluarga->load(['kepalaKeluarga', 'anggota', 'user']);
        return view('kartu-keluarga.show', compact('kartuKeluarga'));
    }

    public function edit(KartuKeluarga $kartuKeluarga)
    {
        $warga = Warga::orderBy('nama')->get();
        return view('kartu-keluarga.edit', compact('kartuKeluarga', 'warga'));
    }

    public function update(Request $request, KartuKeluarga $kartuKeluarga)
    {
        $request->validate([
            'nomor_keluarga' => 'required|string|max:16',
            'kepala_keluarga_id' => 'required|exists:warga,id',
        ]);

        $kartuKeluarga->update($request->only([
            'nomor_keluarga', 'kepala_keluarga_id', 'alamat', 'desa_kelurahan',
            'kecamatan', 'kabupaten_kota', 'provinsi', 'negara', 'rt', 'rw', 'kode_pos',
        ]));
        $kartuKeluarga->document_hash = $kartuKeluarga->generateDocumentHash();
        $kartuKeluarga->save();

        return redirect()->route('kartu-keluarga.index')->with('success', 'Data KK berhasil diperbarui');
    }

    public function destroy(KartuKeluarga $kartuKeluarga)
    {
        $kartuKeluarga->anggota()->detach();
        $kartuKeluarga->delete();
        return redirect()->route('kartu-keluarga.index')->with('success', 'Data KK berhasil dihapus');
    }

    public function editAnggota(KartuKeluarga $kartuKeluarga)
    {
        $kartuKeluarga->load('anggota');
        $warga = Warga::orderBy('nama')->get();
        return view('kartu-keluarga.edit-anggota', compact('kartuKeluarga', 'warga'));
    }

    public function updateAnggota(Request $request, KartuKeluarga $kartuKeluarga)
    {
        $kartuKeluarga->anggota()->sync($request->anggota_ids ?? []);
        return redirect()->route('kartu-keluarga.show', $kartuKeluarga)->with('success', 'Anggota KK berhasil diperbarui');
    }
}
