@extends('layouts.app')
@section('title', 'Data Mata Kuliah')
@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4"><div><h1 class="h3 fw-bold mb-1">Mata Kuliah</h1><p class="text-muted mb-0">Kelola katalog mata kuliah SiAkad.</p></div><a href="{{ route('matakuliah.create') }}" class="btn btn-utama">+ Tambah mata kuliah</a></div>
<div class="card border-0 shadow-sm"><div class="table-responsive"><table class="table table-hover mb-0"><thead class="table-light"><tr><th>Kode</th><th>Nama mata kuliah</th><th>SKS</th><th>Jumlah nilai</th><th class="text-end">Aksi</th></tr></thead><tbody>
@forelse($matakuliahs as $item)<tr><td class="fw-semibold">{{ $item->kode_mk }}</td><td>{{ $item->nama_mk }}</td><td>{{ $item->sks }}</td><td>{{ $item->nilai_count }}</td><td class="text-end text-nowrap"><a class="btn btn-sm btn-outline-primary" href="{{ route('matakuliah.show', $item) }}">Detail</a> <a class="btn btn-sm btn-outline-secondary" href="{{ route('matakuliah.edit', $item) }}">Ubah</a> @if(auth()->user()->role->nama_role === 'Admin')<form class="d-inline" action="{{ route('matakuliah.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus mata kuliah ini?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger">Hapus</button></form>@endif</td></tr>
@empty<tr><td colspan="5" class="text-center py-4 text-muted">Belum ada mata kuliah.</td></tr>@endforelse
</tbody></table></div>@if($matakuliahs->hasPages())<div class="card-body">{{ $matakuliahs->links() }}</div>@endif</div>
@endsection
