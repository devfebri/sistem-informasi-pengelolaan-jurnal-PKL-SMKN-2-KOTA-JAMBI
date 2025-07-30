<!-- filepath: d:\0. Usaha\0. odading\dina - Perancangan sistem informasi pengelolaan jurnal PKL SMKN 2 KOTA JAMBI\websiteJurnalPKL\resources\views\welcome.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SI Jurnal PKL SMKN 2 KOTA JAMBI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">Jurnal PKL SMKN 2 KOTA JAMBI</a>
        </div>
    </nav>
    <div class="container mt-5">
        <div class="text-center">
            <img src="{{ asset('img/logo.jpg') }}" alt="Logo SMKN 2 Kota Jambi" width="120" class="mb-3">
            <h1 class="mb-3">Sistem Informasi Pengelolaan Jurnal PKL</h1>
            <p class="lead">Selamat datang di sistem informasi pengelolaan jurnal PKL SMKN 2 Kota Jambi.<br>
            Silakan login untuk mulai menggunakan aplikasi.</p>
            <a href="/login" class="btn btn-primary btn-lg mt-3">Login</a>
        </div>
    </div>
    <footer class="text-center mt-5 mb-3 text-muted">
        &copy; {{ date('Y') }} SMKN 2 Kota Jambi
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>