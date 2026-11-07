@extends('layouts.app')
@section('title', 'Profil Saya')
@section('content')
<div class="mb-4"><h1 class="h3 fw-bold mb-1">Profil saya</h1><p class="text-muted mb-0">Perbarui identitas, foto profil, atau password akun.</p></div>
<div class="card border-0 shadow-sm"><div class="card-body p-4">
<form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">@csrf @method('PUT')
    <div class="d-flex align-items-center gap-3 mb-4"><img src="{{ asset($user->foto_profil ?: 'uploads/profil/default.svg') }}" width="84" height="84" class="rounded-circle border" style="object-fit:cover" alt="Foto profil"><div><div class="fw-semibold">{{ $user->nama_lengkap }}</div><div class="text-muted">{{ $user->role?->nama_role }} · {{ $user->username }}</div></div></div>
    <div class="row g-3">
        <div class="col-md-6"><label for="nama_lengkap" class="form-label">Nama lengkap</label><input id="nama_lengkap" name="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror" value="{{ old('nama_lengkap', $user->nama_lengkap) }}" required>@error('nama_lengkap')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
        <div class="col-md-6"><label for="username" class="form-label">Username / NIM</label><input id="username" name="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username', $user->username) }}" required>@error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
        <div class="col-md-6"><label for="password" class="form-label">Password baru (opsional)</label><input id="password" type="password" name="password" class="form-control @error('password') is-invalid @enderror" minlength="8" autocomplete="new-password">@error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
        <div class="col-md-6"><label for="password_confirmation" class="form-label">Konfirmasi password baru</label><input id="password_confirmation" type="password" name="password_confirmation" class="form-control" minlength="8" autocomplete="new-password"></div>
        <div class="col-md-6"><label for="foto_profil" class="form-label">Ganti foto profil (maks. 2 MB)</label><input id="foto_profil" type="file" name="foto_profil" accept="image/*" class="form-control @error('foto_profil') is-invalid @enderror">@error('foto_profil')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
    </div>
    <div class="mt-4"><button class="btn btn-utama">Simpan profil</button></div>
</form></div></div>
@endsection
