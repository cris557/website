@extends('layouts.app')
@section('title', $mahasiswa->exists ? 'Ubah Mahasiswa' : 'Tambah Mahasiswa')
@section('content')
<div class="mb-4"><a href="{{ route('mahasiswa.index') }}" class="text-decoration-none">&larr; Kembali ke mahasiswa</a><h1 class="h3 fw-bold mt-2">{{ $mahasiswa->exists ? 'Ubah data mahasiswa' : 'Tambah mahasiswa' }}</h1></div>
<div class="card border-0 shadow-sm"><div class="card-body p-4">
    <form action="{{ $mahasiswa->exists ? route('mahasiswa.update', $mahasiswa) : route('mahasiswa.store') }}" method="POST">
        @csrf
        @if($mahasiswa->exists) @method('PUT') @endif
        <div class="row g-3">
            <div class="col-md-6"><label class="form-label" for="nim">NIM</label><input id="nim" name="nim" class="form-control @error('nim') is-invalid @enderror" value="{{ old('nim', $mahasiswa->nim) }}" required>@error('nim')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
            <div class="col-md-6"><label class="form-label" for="nama">Nama lengkap</label><input id="nama" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $mahasiswa->nama) }}" required>@error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
            <div class="col-md-6"><label class="form-label" for="jurusan">Program studi</label><input id="jurusan" name="jurusan" class="form-control @error('jurusan') is-invalid @enderror" value="{{ old('jurusan', $mahasiswa->jurusan) }}" required>@error('jurusan')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
            <div class="col-md-6"><label class="form-label" for="angkatan">Tahun angkatan</label><input id="angkatan" type="number" name="angkatan" min="2000" max="2100" class="form-control @error('angkatan') is-invalid @enderror" value="{{ old('angkatan', $mahasiswa->angkatan) }}" required>@error('angkatan')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
        </div>
        <div class="mt-4 d-flex gap-2"><button class="btn btn-utama">{{ $mahasiswa->exists ? 'Simpan perubahan' : 'Tambah mahasiswa' }}</button><a href="{{ route('mahasiswa.index') }}" class="btn btn-light">Batal</a></div>
    </form>
</div></div>
@endsection
