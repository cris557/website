<?php

namespace App\Http\Controllers;

use App\Models\Matakuliah;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MatakuliahController extends Controller
{
    public function index()
    {
        $matakuliahs = Matakuliah::withCount('nilai')->orderBy('kode_mk')->paginate(10);

        return view('matakuliah.index', compact('matakuliahs'));
    }

    public function create()
    {
        return view('matakuliah.form', ['matakuliah' => new Matakuliah]);
    }

    public function store(Request $request)
    {
        Matakuliah::create($this->validatedData($request));

        return redirect()->route('matakuliah.index')->with('success', 'Mata kuliah berhasil ditambahkan.');
    }

    public function show(Matakuliah $matakuliah)
    {
        $matakuliah->load(['nilai.mahasiswa']);

        return view('matakuliah.show', compact('matakuliah'));
    }

    public function edit(Matakuliah $matakuliah)
    {
        return view('matakuliah.form', compact('matakuliah'));
    }

    public function update(Request $request, Matakuliah $matakuliah)
    {
        $matakuliah->update($this->validatedData($request, $matakuliah));

        return redirect()->route('matakuliah.index')->with('success', 'Mata kuliah berhasil diperbarui.');
    }

    public function destroy(Matakuliah $matakuliah)
    {
        if ($matakuliah->nilai()->exists()) {
            return back()->with('error', 'Mata kuliah masih memiliki data nilai. Hapus nilai terkait terlebih dahulu.');
        }

        $matakuliah->delete();

        return redirect()->route('matakuliah.index')->with('success', 'Mata kuliah berhasil dihapus.');
    }

    private function validatedData(Request $request, ?Matakuliah $matakuliah = null): array
    {
        return $request->validate([
            'kode_mk' => ['required', 'string', 'max:10', Rule::unique('t003_matakuliah', 'kode_mk')->ignore($matakuliah?->id)],
            'nama_mk' => ['required', 'string', 'max:100'],
            'sks' => ['required', 'integer', 'between:1,6'],
        ]);
    }
}
