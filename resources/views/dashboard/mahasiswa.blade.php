@extends('layouts.app')
@section('title', 'Dashboard Mahasiswa')

@section('content')
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body d-flex align-items-center gap-3">
        <img src="{{ asset($user->foto_profil ?: 'uploads/profil/default.svg') }}" width="80" height="80" class="rounded-circle border border-3 border-info" style="object-fit:cover;" alt="Foto profil {{ $user->nama_lengkap }}">
        <div>
            <span class="badge bg-info text-white text-uppercase mb-1">PANEL {{ $user->role->nama_role }}</span>
            <h3 class="fw-bold mb-0">{{ $user->nama_lengkap }}</h3>
            <p class="text-muted mb-0">Username/NIM: <strong>{{ $user->username }}</strong> | Level: {{ $user->role->nama_role }}</p>
        </div>
        <div class="ms-auto">
            <a href="{{ route('profile.edit') }}" class="btn btn-outline-info btn-sm">Edit Profil (RU)</a>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-6">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h6 class="m-0 fw-bold text-info">Data Akademik Saya <span class="badge bg-secondary">Akses: R (Milik Sendiri)</span></h6>
            </div>
            <div class="card-body">
                @forelse($dataMahasiswa as $mhs)
                    <p class="mb-1"><strong>NIM:</strong> {{ $mhs->nim }}</p>
                    <p class="mb-1"><strong>Nama:</strong> {{ $mhs->nama }}</p>
                    <p class="mb-1"><strong>Jurusan:</strong> {{ $mhs->jurusan }}</p>
                    <p class="mb-0"><strong>Angkatan:</strong> {{ $mhs->angkatan }}</p>
                @empty
                    <p class="text-muted mb-0">Data profil akademik belum terhubung.</p>
                @endforelse
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h6 class="m-0 fw-bold text-dark">KHS / Nilai Saya <span class="badge bg-secondary">Akses: R</span></h6>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover align-middle m-0">
                    <thead class="table-light">
                        <tr>
                            <th>Mata Kuliah</th>
                            <th>Nilai</th>
                            <th>Huruf</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dataNilai as $n)
                        <tr>
                            <td>{{ $n->matakuliah->nama_mk ?? '-' }}</td>
                            <td><strong>{{ $n->nilai_angka }}</strong></td>
                            <td><span class="badge bg-success">{{ $n->nilai_huruf }}</span></td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center py-3 text-muted">Belum ada nilai yang diinput.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection