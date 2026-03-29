<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use Illuminate\Http\Request;

class GaleriController extends Controller
{
    public function index()
    {
        $galeri = Galeri::orderBy('created_at', 'desc')->get();
        return view('galeri.index', compact('galeri'));
    }

    public function create()
    {
        return view('galeri.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
            'caption' => 'required|string',
        ]);

        $file = $request->file('foto');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads'), $filename);

        Galeri::create([
            'path' => $filename,
            'caption' => $request->caption,
            'tautan' => $request->tautan,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('galeri.index')->with('success', 'Foto berhasil ditambahkan');
    }

    public function destroy(Galeri $galeri)
    {
        $filepath = public_path('uploads/' . $galeri->path);
        if (file_exists($filepath)) {
            unlink($filepath);
        }
        $galeri->delete();
        return redirect()->route('galeri.index')->with('success', 'Foto berhasil dihapus');
    }
}
