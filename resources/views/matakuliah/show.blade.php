@extends('layouts.app')
@section('title', 'Detail Mata Kuliah')
@section('content')
<div class="mb-4"><a href="{{ route('matakuliah.index') }}" class="text-decoration-none">&larr; Kembali ke mata kuliah</a><h1 class="h3 fw-bold mt-2">Detail mata kuliah</h1></div>
<div class="card border-0 shadow-sm mb-4"><div class="card-body p-4"><dl class="row mb-3"><dt class="col-sm-3">Kode</dt><dd class="col-sm-9">{{ $matakuliah->kode_mk }}</dd><dt class="col-sm-3">Nama</dt><dd class="col-sm-9">{{ $matakuliah->nama_mk }}</dd><dt class="col-sm-3">SKS</dt><dd class="col-sm-9">{{ $matakuliah->sks }}</dd></dl><a class="btn btn-utama" href="{{ route('matakuliah.edit', $matakuliah) }}">Ubah mata kuliah</a></div></div>
<div class="card border-0 shadow-sm"><div class="card-header bg-white fw-semibold py-3">Nilai mahasiswa</div><div class="table-responsive"><table class="table mb-0"><thead class="table-light"><tr><th>NIM</th><th>Nama</th><th>Nilai</th><th>Huruf</th></tr></thead><tbody>@forelse($matakuliah->nilai as $grade)<tr><td>{{ $grade->mahasiswa->nim }}</td><td>{{ $grade->mahasiswa->nama }}</td><td>{{ $grade->nilai_angka }}</td><td>{{ $grade->nilai_huruf }}</td></tr>@empty<tr><td colspan="4" class="text-center text-muted py-3">Belum ada nilai.</td></tr>@endforelse</tbody></table></div></div>
@endsection
