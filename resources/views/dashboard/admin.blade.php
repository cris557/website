@extends('layouts.app')
@section('title', 'Dashboard Admin')
@section('content')
<div class="card border-0 shadow-sm mb-4"><div class="card-body p-4 d-flex flex-wrap align-items-center gap-3">
    <img src="{{ asset($user->foto_profil ?: 'uploads/profil/default.svg') }}" width="82" height="82" class="rounded-circle border border-3 border-primary" style="object-fit:cover" alt="Foto profil {{ $user->nama_lengkap }}">
    <div><span class="badge text-bg-primary mb-2">ADMINISTRATOR</span><h1 class="h3 fw-bold mb-1">{{ $user->nama_lengkap }}</h1><div class="text-muted">Username: {{ $user->username }} · Level: {{ $user->role->nama_role }}</div></div>
    <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary ms-auto">Edit profil</a>
</div></div>
<div class="row g-3 mb-4">
    <div class="col-md-4"><div class="card border-0 shadow-sm h-100"><div class="card-body"><div class="text-muted small">Total mahasiswa</div><div class="display-6 fw-bold text-utama">{{ $totalMahasiswa }}</div><a href="{{ route('mahasiswa.index') }}" class="small">Kelola mahasiswa &rarr;</a></div></div></div>
    <div class="col-md-4"><div class="card border-0 shadow-sm h-100"><div class="card-body"><div class="text-muted small">Mata kuliah</div><div class="display-6 fw-bold text-success">{{ $totalMataKuliah }}</div><a href="{{ route('matakuliah.index') }}" class="small">Kelola mata kuliah &rarr;</a></div></div></div>
    <div class="col-md-4"><div class="card border-0 shadow-sm h-100"><div class="card-body"><div class="text-muted small">Pengguna sistem</div><div class="display-6 fw-bold text-dark">{{ $totalPengguna }}</div><a href="{{ route('users.index') }}" class="small">Kelola pengguna &rarr;</a></div></div></div>
</div>
<div class="card border-0 shadow-sm mb-4"><div class="card-body d-flex flex-wrap gap-2"><a href="{{ route('users.index') }}" class="btn btn-utama">Kelola pengguna</a><a href="{{ route('mahasiswa.index') }}" class="btn btn-outline-primary">Data mahasiswa</a><a href="{{ route('matakuliah.index') }}" class="btn btn-outline-primary">Data mata kuliah</a><a href="{{ route('nilai.index') }}" class="btn btn-outline-primary">Data nilai</a></div></div>
<div class="card border-0 shadow-sm"><div class="card-header bg-white fw-semibold py-3">Mahasiswa terbaru</div><div class="table-responsive"><table class="table table-hover mb-0"><thead class="table-light"><tr><th>NIM</th><th>Nama</th><th>Program studi</th><th>Angkatan</th><th></th></tr></thead><tbody>@forelse($dataMahasiswa as $mhs)<tr><td>{{ $mhs->nim }}</td><td>{{ $mhs->nama }}</td><td>{{ $mhs->jurusan }}</td><td>{{ $mhs->angkatan }}</td><td class="text-end"><a href="{{ route('mahasiswa.show', $mhs) }}" class="btn btn-sm btn-outline-primary">Detail</a></td></tr>@empty<tr><td colspan="5" class="text-center text-muted py-3">Belum ada data mahasiswa.</td></tr>@endforelse</tbody></table></div><div class="card-footer bg-white text-end"><a href="{{ route('mahasiswa.index') }}">Lihat semua mahasiswa &rarr;</a></div></div>
@endsection
