<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Matakuliah;
use App\Models\Nilai;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class NilaiController extends Controller
{
    public function index(Request $request)
    {
        $nilai = Nilai::with(['mahasiswa', 'matakuliah'])
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->string('search')->toString();
                $query->where(function ($query) use ($search) {
                    $query->whereHas('mahasiswa', function ($query) use ($search) {
                        $query->where('nama', 'like', "%{$search}%")->orWhere('nim', 'like', "%{$search}%");
                    })->orWhereHas('matakuliah', function ($query) use ($search) {
                        $query->where('nama_mk', 'like', "%{$search}%")->orWhere('kode_mk', 'like', "%{$search}%");
                    });
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('nilai.index', compact('nilai'));
    }

    public function create()
    {
        return view('nilai.form', [
            'nilai' => new Nilai,
            'mahasiswas' => Mahasiswa::orderBy('nama')->get(),
            'matakuliahs' => Matakuliah::orderBy('kode_mk')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);
        $data['nilai_huruf'] = $this->letterGrade($data['nilai_angka']);
        Nilai::create($data);

        return redirect()->route('nilai.index')->with('success', 'Nilai berhasil ditambahkan.');
    }

    public function show(Nilai $nilai)
    {
        $nilai->load(['mahasiswa', 'matakuliah']);

        return view('nilai.show', compact('nilai'));
    }

    public function edit(Nilai $nilai)
    {
        return view('nilai.form', [
            'nilai' => $nilai,
            'mahasiswas' => Mahasiswa::orderBy('nama')->get(),
            'matakuliahs' => Matakuliah::orderBy('kode_mk')->get(),
        ]);
    }

    public function update(Request $request, Nilai $nilai)
    {
        $data = $this->validatedData($request, $nilai);
        $data['nilai_huruf'] = $this->letterGrade($data['nilai_angka']);
        $nilai->update($data);

        return redirect()->route('nilai.index')->with('success', 'Nilai berhasil diperbarui.');
    }

    public function destroy(Nilai $nilai)
    {
        $nilai->delete();

        return redirect()->route('nilai.index')->with('success', 'Nilai berhasil dihapus.');
    }

    private function validatedData(Request $request, ?Nilai $nilai = null): array
    {
        return $request->validate([
            'mahasiswa_id' => ['required', 'integer', 'exists:t003_mahasiswa,id', Rule::unique('t003_nilai', 'mahasiswa_id')
                ->where('matakuliah_id', $request->input('matakuliah_id'))
                ->ignore($nilai?->id)],
            'matakuliah_id' => ['required', 'integer', 'exists:t003_matakuliah,id'],
            'nilai_angka' => ['required', 'integer', 'between:0,100'],
        ]);
    }

    private function letterGrade(int $score): string
    {
        return match (true) {
            $score >= 85 => 'A',
            $score >= 70 => 'B',
            $score >= 60 => 'C',
            $score >= 50 => 'D',
            default => 'E',
        };
    }
}
