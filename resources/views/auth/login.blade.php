<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - SIM-Evaluasi EMR RSU Muhammadiyah Metro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .auth-card {
            width: 100%;
            max-width: 420px;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        }

        .custom-auth-input:focus {
            border-color: #e2e8f0 !important;
            box-shadow: none !important;
        }

        .input-group-merge:focus-within .input-group-text {
            border-color: #0d6efd !important;
            background-color: #fff !important;
        }

        .input-group-merge:focus-within .form-control {
            border-color: #0d6efd !important;
        }

        .form-check-input:checked {
            background-color: #0d6efd !important;
            border-color: #0d6efd !important;
        }
    </style>
</head>

<body>

    <div class="auth-card p-4 m-3">
        <div class="text-center mb-4">
            <div class="bg-primary text-white p-3 d-inline-flex align-items-center justify-content-center mx-auto mb-3 shadow-xs"
                style="width: 52px; height: 52px; border-radius: 6px; background-image: linear-gradient(to bottom right, #0d6efd, #0b5ed7);">
                <i class="bi bi-hospital fs-4"></i>
            </div>
            <h4 class="fw-bold mb-1 text-dark" style="letter-spacing: -0.5px;">Masuk Sistem</h4>
            <p class="text-muted small">SIM-Evaluasi EMR RSU Muhammadiyah Metro</p>
        </div>

        @if (session('status'))
            <div class="alert alert-success border-0 small mb-3" role="alert" style="border-radius: 4px;">
                <i class="bi bi-check-circle-fill me-2 text-success"></i> {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label text-secondary small fw-semibold mb-1">Alamat Email</label>
                <div class="input-group input-group-merge">
                    <span class="input-group-text bg-light border-end-0 text-muted px-3"
                        style="border-color: #e2e8f0; border-radius: 4px 0 0 4px;">
                        <i class="bi bi-envelope"></i>
                    </span>
                    <input id="email"
                        class="form-control border-start-0 ps-0 custom-auth-input @error('email') is-invalid @enderror"
                        type="email" name="email" value="{{ old('email') }}" required autofocus
                        autocomplete="username" placeholder="nama@rsmetro.test"
                        style="border-color: #e2e8f0; border-radius: 0 4px 4px 0; font-size: 0.9rem; padding: 0.55rem 0.75rem;">
                </div>
                @error('email')
                    <div class="text-danger small mt-1"><i class="bi bi-exclamation-circle me-1"></i> {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <label for="password" class="form-label text-secondary small fw-semibold mb-0">Password</label>
                </div>
                <div class="input-group input-group-merge">
                    <span class="input-group-text bg-light border-end-0 text-muted px-3"
                        style="border-color: #e2e8f0; border-radius: 4px 0 0 4px;">
                        <i class="bi bi-lock"></i>
                    </span>
                    <input id="password"
                        class="form-control border-start-0 ps-0 custom-auth-input @error('password') is-invalid @enderror"
                        type="password" name="password" required autocomplete="current-password"
                        placeholder="Masukkan password Anda"
                        style="border-color: #e2e8f0; border-radius: 0 4px 4px 0; font-size: 0.9rem; padding: 0.55rem 0.75rem;">
                </div>
                @error('password')
                    <div class="text-danger small mt-1"><i class="bi bi-exclamation-circle me-1"></i> {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-check mb-4 text-start">

            </div>

            <div class="d-grid mb-3">
                <button type="submit" class="btn btn-primary btn-lg text-white fs-6 fw-semibold py-2.5 shadow-sm"
                    style="border-radius: 4px;">
                    <i class="bi bi-box-arrow-in-right me-2"></i> Masuk Sekarang
                </button>
            </div>

            <div class="text-center mt-4 border-top border-light pt-3">
                <p class="text-muted small mb-1">Belum terdaftar sebagai responden?</p>
                <a href="{{ route('register') }}" class="text-primary fw-semibold text-decoration-none small">
                    Buat Akun Responden <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
