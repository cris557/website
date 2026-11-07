<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SiAkad-003 - @yield('title', 'Sistem Akademik')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root { --siakad-blue: #1E88E5; --siakad-blue-dark: #1565C0; }
        .bg-utama { background-color: var(--siakad-blue) !important; }
        .btn-utama { background-color: var(--siakad-blue); color: #fff; }
        .btn-utama:hover { background-color: var(--siakad-blue-dark); color: #fff; }
        .text-utama { color: var(--siakad-blue) !important; }
        .navbar .nav-link.active { color: #fff; font-weight: 700; }
        .table > :not(caption) > * > * { vertical-align: middle; }
    </style>
</head>
<body class="d-flex flex-column min-vh-100 bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-utama shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">SiAkad-003</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Buka navigasi">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a></li>
                    @if(in_array(auth()->user()->role?->nama_role, ['Admin', 'Dosen']))
                        <li class="nav-item"><a class="nav-link" href="{{ route('mahasiswa.index') }}">Mahasiswa</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('matakuliah.index') }}">Mata Kuliah</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('nilai.index') }}">Nilai</a></li>
                    @endif
                    @if(auth()->user()->role?->nama_role === 'Admin')
                        <li class="nav-item"><a class="nav-link" href="{{ route('users.index') }}">Pengguna</a></li>
                    @endif
                </ul>
                <div class="d-flex align-items-center gap-2 text-white">
                    <img src="{{ asset(auth()->user()->foto_profil ?: 'uploads/profil/default.svg') }}" width="34" height="34" class="rounded-circle border border-2 border-white" style="object-fit:cover" alt="Foto profil">
                    <div class="small d-none d-sm-block">
                        <div class="fw-semibold">{{ auth()->user()->nama_lengkap }}</div>
                        <div>{{ auth()->user()->role?->nama_role }}</div>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="btn btn-sm btn-outline-light ms-2">Profil</a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-light text-primary fw-semibold">Keluar</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <main class="container my-4 flex-grow-1">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        @endif
        @yield('content')
    </main>

    <footer class="bg-white text-center py-3 border-top mt-auto">
        <div class="container d-flex justify-content-center align-items-center gap-2 text-secondary small">
            <img src="{{ asset(auth()->user()->foto_profil ?: 'uploads/profil/default.svg') }}" width="28" height="28" class="rounded-circle border" style="object-fit:cover" alt="">
            <span>© 2026 {{ auth()->user()->nama_lengkap }} - {{ auth()->user()->username }}</span>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
