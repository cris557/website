<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Akses Ditolak</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center min-vh-100">
    <div class="text-center p-5 bg-white rounded shadow-sm" style="max-width: 500px;">
        <h1 class="display-1 fw-bold text-danger">403</h1>
        <h3 class="fw-bold mb-3">Akses Ditolak!</h3>
        <p class="text-muted mb-4">
            {{ $exception->getMessage() ?: 'Anda tidak memiliki hak akses untuk membuka halaman ini.' }}
        </p>
        <a href="{{ route('dashboard') }}" class="btn btn-primary px-4 fw-bold">
            Kembali ke Dashboard
        </a>
    </div>
</body>
</html>