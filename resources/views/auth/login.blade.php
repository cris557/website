<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk - SiAkad-003</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root { --siakad-blue: #1E88E5; }
        body { background: linear-gradient(135deg, #eaf4ff, #f7fbff); }
        .login-card { max-width: 440px; width: 100%; border-radius: 1rem; }
        .login-brand { background: var(--siakad-blue); color: white; border-radius: 1rem 1rem 0 0; }
        .btn-utama { background: var(--siakad-blue); color: white; }
        .btn-utama:hover { background: #1565C0; color: white; }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center min-vh-100 p-3">
    <main class="card login-card shadow border-0 overflow-hidden">
        <div class="login-brand text-center py-4">
            <div class="fw-bold fs-3">SiAkad-003</div>
            <div class="small opacity-75">Sistem Informasi Akademik</div>
        </div>
        <div class="card-body p-4 p-md-5">
            <h1 class="h4 fw-bold mb-1">Selamat datang</h1>
            <p class="text-muted mb-4">Masuk menggunakan username dan password Anda.</p>

            @if($errors->any())
                <div class="alert alert-danger py-2" role="alert">{{ $errors->first() }}</div>
            @endif
            @if(session('status'))
                <div class="alert alert-info py-2" role="status">{{ session('status') }}</div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="username" class="form-label fw-semibold">Username / NIM</label>
                    <input id="username" type="text" name="username" class="form-control form-control-lg @error('username') is-invalid @enderror" value="{{ old('username') }}" placeholder="Masukkan username atau NIM" autocomplete="username" required autofocus>
                    @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-4">
                    <label for="password" class="form-label fw-semibold">Password</label>
                    <input id="password" type="password" name="password" class="form-control form-control-lg" placeholder="Masukkan password" autocomplete="current-password" required>
                </div>
                <button type="submit" class="btn btn-utama btn-lg w-100 fw-semibold">Masuk</button>
            </form>

        </div>
    </main>
</body>
</html>
