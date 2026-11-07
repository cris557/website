@extends('layouts.app')
@section('title', $nilai->exists ? 'Ubah Nilai' : 'Input Nilai')
@section('content')
<div class="mb-4"><a href="{{ route('nilai.index') }}" class="text-decoration-none">&larr; Kembali ke nilai</a><h1 class="h3 fw-bold mt-2">{{ $nilai->exists ? 'Ubah nilai' : 'Input nilai mahasiswa' }}</h1></div>
<div class="card border-0 shadow-sm"><div class="card-body p-4">
@if($mahasiswas->isEmpty() || $matakuliahs->isEmpty())<div class="alert alert-warning mb-0">Tambahkan data mahasiswa dan mata kuliah sebelum menginput nilai.</div>@else
<form action="{{ $nilai->exists ? route('nilai.update', $nilai) : route('nilai.store') }}" method="POST">@csrf @if($nilai->exists) @method('PUT') @endif
<div class="row g-3">
    <div class="col-md-6"><label for="mahasiswa_id" class="form-label">Mahasiswa</label><select id="mahasiswa_id" name="mahasiswa_id" class="form-select @error('mahasiswa_id') is-invalid @enderror" required><option value="">Pilih mahasiswa</option>@foreach($mahasiswas as $mahasiswa)<option value="{{ $mahasiswa->id }}" @selected((string) old('mahasiswa_id', $nilai->mahasiswa_id) === (string) $mahasiswa->id)>{{ $mahasiswa->nim }} · {{ $mahasiswa->nama }}</option>@endforeach</select>@error('mahasiswa_id')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
    <div class="col-md-6"><label for="matakuliah_id" class="form-label">Mata kuliah</label><select id="matakuliah_id" name="matakuliah_id" class="form-select @error('matakuliah_id') is-invalid @enderror" required><option value="">Pilih mata kuliah</option>@foreach($matakuliahs as $matakuliah)<option value="{{ $matakuliah->id }}" @selected((string) old('matakuliah_id', $nilai->matakuliah_id) === (string) $matakuliah->id)>{{ $matakuliah->kode_mk }} · {{ $matakuliah->nama_mk }}</option>@endforeach</select>@error('matakuliah_id')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
    <div class="col-md-6"><label for="nilai_angka" class="form-label">Nilai angka (0-100)</label><input id="nilai_angka" type="number" name="nilai_angka" min="0" max="100" class="form-control @error('nilai_angka') is-invalid @enderror" value="{{ old('nilai_angka', $nilai->nilai_angka) }}" required>@error('nilai_angka')<div class="invalid-feedback">{{ $message }}</div>@enderror</div>
</div>
<p class="form-text mt-3 mb-0">Nilai huruf dihitung otomatis dari nilai angka.</p>
<div class="mt-4 d-flex gap-2"><button class="btn btn-utama">{{ $nilai->exists ? 'Simpan perubahan' : 'Simpan nilai' }}</button><a href="{{ route('nilai.index') }}" class="btn btn-light">Batal</a></div>
</form>@endif
</div></div>
@endsection
