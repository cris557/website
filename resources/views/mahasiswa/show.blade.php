@extends('layouts.app')
@section('title', 'Detail Mahasiswa')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4"><div><a href="{{ route('mahasiswa.index') }}" class="text-decoration-none">&larr; Kembali ke mahasiswa</a><h1 class="h3 fw-bold mt-2">Detail mahasiswa</h1></div><a class="btn btn-utama" href="{{ route('mahasiswa.edit', $mahasiswa) }}">Ubah data</a></div>
<div class="card border-0 shadow-sm mb-4"><div class="card-body p-4"><dl class="row mb-0"><dt class="col-sm-3">NIM</dt><dd class="col-sm-9">{{ $mahasiswa->nim }}</dd><dt class="col-sm-3">Nama</dt><dd class="col-sm-9">{{ $mahasiswa->nama }}</dd><dt class="col-sm-3">Program studi</dt><dd class="col-sm-9">{{ $mahasiswa->jurusan }}</dd><dt class="col-sm-3">Angkatan</dt><dd class="col-sm-9">{{ $mahasiswa->angkatan }}</dd></dl></div></div>
<div class="card border-0 shadow-sm"><div class="card-header bg-white fw-semibold py-3">Riwayat nilai</div><div class="table-responsive"><table class="table mb-0"><thead class="table-light"><tr><th>Mata kuliah</th><th>Nilai angka</th><th>Nilai huruf</th></tr></thead><tbody>
@forelse($mahasiswa->nilai as $grade)<tr><td>{{ $grade->matakuliah->nama_mk }}</td><td>{{ $grade->nilai_angka }}</td><td>{{ $grade->nilai_huruf }}</td></tr>@empty<tr><td colspan="3" class="text-center text-muted py-3">Belum ada nilai.</td></tr>@endforelse
</tbody></table></div></div>
@endsection
