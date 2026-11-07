<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MahasiswaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->string('search')->toString();
        $mahasiswa = Mahasiswa::with('user')
            ->when($search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('nama', 'like', "%{$search}%")
                        ->orWhere('nim', 'like', "%{$search}%")
                        ->orWhere('jurusan', 'like', "%{$search}%");
                });
            })
            ->orderBy('nama')
            ->paginate(10)
            ->withQueryString();

        return view('mahasiswa.index', compact('mahasiswa', 'search'));
    }

    public function create()
    {
        return view('mahasiswa.form', ['mahasiswa' => new Mahasiswa]);
    }

    public function store(Request $request)
    {
        Mahasiswa::create($this->validatedData($request));

        return redirect()->route('mahasiswa.index')->with('success', 'Data mahasiswa berhasil ditambahkan.');
    }

    public function show(Mahasiswa $mahasiswa)
    {
        $mahasiswa->load(['nilai.matakuliah', 'user']);

        return view('mahasiswa.show', compact('mahasiswa'));
    }

    public function edit(Mahasiswa $mahasiswa)
    {
        return view('mahasiswa.form', compact('mahasiswa'));
    }

    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        $mahasiswa->update($this->validatedData($request, $mahasiswa));

        if ($mahasiswa->user) {
            $mahasiswa->user->update(['nama_lengkap' => $mahasiswa->nama]);
        }

        return redirect()->route('mahasiswa.index')->with('success', 'Data mahasiswa berhasil diperbarui.');
    }

    public function destroy(Mahasiswa $mahasiswa)
    {
        if ($mahasiswa->nilai()->exists()) {
            return back()->with('error', 'Mahasiswa masih memiliki data nilai. Hapus nilai terkait terlebih dahulu.');
        }

        $mahasiswa->delete();

        return redirect()->route('mahasiswa.index')->with('success', 'Data mahasiswa berhasil dihapus.');
    }

    private function validatedData(Request $request, ?Mahasiswa $mahasiswa = null): array
    {
        return $request->validate([
            'nim' => ['required', 'string', 'max:20', Rule::unique('t003_mahasiswa', 'nim')->ignore($mahasiswa?->id)],
            'nama' => ['required', 'string', 'max:100'],
            'jurusan' => ['required', 'string', 'max:50'],
            'angkatan' => ['required', 'integer', 'between:2000,2100'],
        ]);
    }
}
