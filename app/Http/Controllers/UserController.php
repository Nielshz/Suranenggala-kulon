<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('nama')->get();
        return view('user.index', compact('users'));
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:45',
            'username' => 'required|string|max:20|unique:users',
            'password' => 'required|string|min:6',
            'status' => 'required|in:Admin,RT,RW',
        ]);

        User::create([
            'nama' => $request->nama,
            'username' => $request->username,
            'password' => $request->password, // Auto-hashed Argon2id via cast
            'keterangan' => $request->keterangan,
            'status' => $request->status,
            'desa_kelurahan' => $request->desa_kelurahan,
            'kecamatan' => $request->kecamatan,
            'kabupaten_kota' => $request->kabupaten_kota,
            'provinsi' => $request->provinsi,
            'negara' => $request->negara ?? 'Indonesia',
            'rt' => $request->rt,
            'rw' => $request->rw,
        ]);

        return redirect()->route('user.index')->with('success', 'User berhasil ditambahkan');
    }

    public function show(User $user)
    {
        return view('user.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('user.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'nama' => 'required|string|max:45',
            'username' => 'required|string|max:20|unique:users,username,' . $user->id,
            'status' => 'required|in:Admin,RT,RW',
        ]);

        $data = $request->only(['nama', 'username', 'keterangan', 'status',
            'desa_kelurahan', 'kecamatan', 'kabupaten_kota', 'provinsi', 'negara', 'rt', 'rw']);

        if ($request->filled('password')) {
            $data['password'] = $request->password;
        }

        $user->update($data);
        return redirect()->route('user.index')->with('success', 'User berhasil diperbarui');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak bisa menghapus diri sendiri');
        }
        $user->delete();
        return redirect()->route('user.index')->with('success', 'User berhasil dihapus');
    }
}
