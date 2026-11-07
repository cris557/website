@extends('layouts.app')
@section('title', 'Detail Pengguna')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-4"><div><a href="{{ route('users.index') }}" class="text-decoration-none">&larr; Kembali ke pengguna</a><h1 class="h3 fw-bold mt-2">Detail pengguna</h1></div><a class="btn btn-utama" href="{{ route('users.edit', $user) }}">Ubah pengguna</a></div>
<div class="card border-0 shadow-sm"><div class="card-body p-4"><div class="d-flex align-items-center gap-3 mb-4"><img src="{{ asset($user->foto_profil ?: 'uploads/profil/default.svg') }}" width="88" height="88" class="rounded-circle border" style="object-fit:cover" alt="Foto profil"><div><h2 class="h4 mb-1">{{ $user->nama_lengkap }}</h2><span class="badge text-bg-primary">{{ $user->role->nama_role }}</span></div></div><dl class="row mb-0"><dt class="col-sm-3">Username</dt><dd class="col-sm-9">{{ $user->username }}</dd><dt class="col-sm-3">Status</dt><dd class="col-sm-9">{{ $user->is_active ? 'Aktif' : 'Nonaktif' }}</dd></dl></div></div>
@endsection
