@extends('layouts.app')
@section('title', 'Data Mahasiswa')
@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div><h1 class="h3 fw-bold mb-1">Data Mahasiswa</h1><p class="text-muted mb-0">Kelola data akademik mahasiswa.</p></div>
    <a href="{{ route('mahasiswa.create') }}" class="btn btn-utama">+ Tambah mahasiswa</a>
</div>
<div class="card border-0 shadow-sm">
    <div class="card-body border-bottom">
        <form method="GET" class="row g-2">
            <div class="col-sm-9"><input class="form-control" name="search" value="{{ $search }}" placeholder="Cari nama, NIM, atau jurusan"></div>
            <div class="col-sm-3 d-grid"><button class="btn btn-outline-primary">Cari</button></div>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light"><tr><th>NIM</th><th>Nama</th><th>Jurusan</th><th>Angkatan</th><th class="text-end">Aksi</th></tr></thead>
            <tbody>
            @forelse($mahasiswa as $item)
                <tr>
                    <td class="fw-semibold">{{ $item->nim }}</td><td>{{ $item->nama }}</td><td>{{ $item->jurusan }}</td><td>{{ $item->angkatan }}</td>
                    <td class="text-end text-nowrap">
                        <a class="btn btn-sm btn-outline-primary" href="{{ route('mahasiswa.show', $item) }}">Detail</a>
                        <a class="btn btn-sm btn-outline-secondary" href="{{ route('mahasiswa.edit', $item) }}">Ubah</a>
                        @if(auth()->user()->role->nama_role === 'Admin')
                            <form class="d-inline" action="{{ route('mahasiswa.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus data mahasiswa ini?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger">Hapus</button></form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center py-4 text-muted">Belum ada data mahasiswa yang cocok.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($mahasiswa->hasPages())<div class="card-body">{{ $mahasiswa->links() }}</div>@endif
</div>
@endsection
