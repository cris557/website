@extends('layouts.app')
@section('title', 'Detail Nilai')
@section('content')
<div class="mb-4"><a href="{{ route('nilai.index') }}" class="text-decoration-none">&larr; Kembali ke nilai</a><h1 class="h3 fw-bold mt-2">Detail nilai</h1></div>
<div class="card border-0 shadow-sm"><div class="card-body p-4"><dl class="row mb-4"><dt class="col-sm-3">Mahasiswa</dt><dd class="col-sm-9">{{ $nilai->mahasiswa->nama }} ({{ $nilai->mahasiswa->nim }})</dd><dt class="col-sm-3">Mata kuliah</dt><dd class="col-sm-9">{{ $nilai->matakuliah->nama_mk }} ({{ $nilai->matakuliah->kode_mk }})</dd><dt class="col-sm-3">Nilai angka</dt><dd class="col-sm-9">{{ $nilai->nilai_angka }}</dd><dt class="col-sm-3">Nilai huruf</dt><dd class="col-sm-9">{{ $nilai->nilai_huruf }}</dd></dl><a class="btn btn-utama" href="{{ route('nilai.edit', $nilai) }}">Ubah nilai</a></div></div>
@endsection
