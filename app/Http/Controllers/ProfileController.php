<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit', ['user' => auth()->user()]);
    }

    public function update(Request $request)
    {
        $user = $request->user();
        $data = $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:100'],
            'username' => ['required', 'string', 'max:50', Rule::unique('t003_users', 'username')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'foto_profil' => ['nullable', 'image', 'max:2048'],
        ]);

        if (filled($data['password'] ?? null)) {
            $user->password = Hash::make($data['password']);
        }

        if ($request->hasFile('foto_profil')) {
            $directory = public_path('uploads/profil');
            File::ensureDirectoryExists($directory);
            $filename = 'user-'.$user->id.'-'.bin2hex(random_bytes(8)).'.'.$request->file('foto_profil')->extension();
            $request->file('foto_profil')->move($directory, $filename);
            $data['foto_profil'] = 'uploads/profil/'.$filename;
        }

        $user->fill(collect($data)->except('password')->all())->save();

        if ($user->mahasiswa) {
            $user->mahasiswa->update(['nama' => $user->nama_lengkap, 'nim' => $user->username]);
        }

        return redirect()->route('profile.edit')->with('success', 'Profil berhasil diperbarui.');
    }
}
