@extends('layouts.app')
@section('title', $user->exists ? 'Ubah Pengguna' : 'Tambah Pengguna')
@section('content')
<div class="mb-4"><a href="{{ route('users.index') }}" class="text-decoration-none">&larr; Kembali ke pengguna</a><h1 class="h3 fw-bold mt-2">{{ $user->exists ? 'Ubah pengguna' : 'Tambah pengguna' }}</h1></div>
<div class="card border-0 shadow-sm"><div class="card-body p-4">
<form action="{{ $user->exists ? route('users.update', $user) : route('users.store') }}" method="POST" enctype="multipart/form-data">@csrf @if($user->exists) @method('PUT') @endif
<div class="row g-3">
    <div class="col-md-6"><label class="form-label" for="nama_lengkap">Nama lengkap</label><input id="nama_lengkap" name="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror" value="{{ old('nama_lengkap', $user->nama_lengkap) }}" required>@error('nama_lengkap')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
    <div class="col-md-6"><label class="form-label" for="username">Username / NIM</label><input id="username" name="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username', $user->username) }}" required>@error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
    <div class="col-md-6"><label class="form-label" for="role_id">Level pengguna</label><select id="role_id" name="role_id" class="form-select @error('role_id') is-invalid @enderror" required>@foreach($roles as $role)<option value="{{ $role->id }}" @selected((string) old('role_id', $user->role_id) === (string) $role->id)>{{ $role->nama_role }}</option>@endforeach</select>@error('role_id')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
    <div class="col-md-6"><label class="form-label" for="is_active">Status akun</label><input type="hidden" name="is_active" value="0"><select id="is_active" name="is_active" class="form-select" required><option value="1" @selected((string) old('is_active', $user->exists ? (int) $user->is_active : 1) === '1')>Aktif</option><option value="0" @selected((string) old('is_active', $user->exists ? (int) $user->is_active : 1) === '0')>Nonaktif</option></select></div>
    <div class="col-md-6"><label class="form-label" for="password">Password {{ $user->exists ? '(kosongkan jika tidak diubah)' : '' }}</label><input id="password" type="password" name="password" class="form-control @error('password') is-invalid @enderror" {{ $user->exists ? '' : 'required' }} minlength="8" autocomplete="new-password">@error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
    <div class="col-md-6"><label class="form-label" for="password_confirmation">Konfirmasi password</label><input id="password_confirmation" type="password" name="password_confirmation" class="form-control" {{ $user->exists ? '' : 'required' }} minlength="8" autocomplete="new-password"></div>
    <div class="col-md-6"><label class="form-label" for="foto_profil">Foto profil (opsional, maks. 2 MB)</label><input id="foto_profil" type="file" name="foto_profil" accept="image/*" class="form-control @error('foto_profil') is-invalid @enderror">@error('foto_profil')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
</div>
<div class="mt-4 d-flex gap-2"><button class="btn btn-utama">{{ $user->exists ? 'Simpan perubahan' : 'Buat pengguna' }}</button><a href="{{ route('users.index') }}" class="btn btn-light">Batal</a></div>
</form></div></div>
@endsection
