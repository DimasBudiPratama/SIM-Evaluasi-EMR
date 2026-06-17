<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - SIM-Evaluasi EMR RSU Muhammadiyah Metro</title>
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
            max-width: 460px;
            /* Sedikit diperlebar agar form isian demografi muat dengan ideal */
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

        .input-group-merge:focus-within .form-control,
        .input-group-merge:focus-within .form-select {
            border-color: #0d6efd !important;
        }
    </style>
</head>

<body>

    <div class="auth-card p-4 m-3">
        <div class="text-center mb-4">
            <div class="bg-primary text-white p-3 d-inline-flex align-items-center justify-content-center mx-auto mb-3 shadow-xs"
                style="width: 52px; height: 52px; border-radius: 6px; background-image: linear-gradient(to bottom right, #0d6efd, #0b5ed7);">
                <i class="bi bi-person-plus fs-4"></i>
            </div>
            <h4 class="fw-bold mb-1 text-dark" style="letter-spacing: -0.5px;">Daftar Responden</h4>
            <p class="text-muted small">SIM-Evaluasi EMR RSU Muhammadiyah Metro</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label text-secondary small fw-semibold mb-1">Nama Lengkap</label>
                <div class="input-group input-group-merge">
                    <span class="input-group-text bg-light border-end-0 text-muted px-3"
                        style="border-color: #e2e8f0; border-radius: 4px 0 0 4px;">
                        <i class="bi bi-person"></i>
                    </span>
                    <input id="name"
                        class="form-control border-start-0 ps-0 custom-auth-input @error('name') is-invalid @enderror"
                        type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                        placeholder="Masukkan nama lengkap beserta gelar"
                        style="border-color: #e2e8f0; border-radius: 0 4px 4px 0; font-size: 0.9rem; padding: 0.55rem 0.75rem;">
                </div>
                @error('name')
                    <div class="text-danger small mt-1"><i class="bi bi-exclamation-circle me-1"></i> {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="jenis_kelamin" class="form-label text-secondary small fw-semibold mb-1">Jenis
                    Kelamin</label>
                <div class="input-group input-group-merge">
                    <span class="input-group-text bg-light border-end-0 text-muted px-3"
                        style="border-color: #e2e8f0; border-radius: 4px 0 0 4px;">
                        <i class="bi bi-gender-ambiguous"></i>
                    </span>
                    <select id="jenis_kelamin" name="jenis_kelamin"
                        class="form-select border-start-0 ps-0 custom-auth-input @error('jenis_kelamin') is-invalid @enderror"
                        required
                        style="border-color: #e2e8f0; border-radius: 0 4px 4px 0; font-size: 0.9rem; padding: 0.55rem 0.75rem;">
                        <option value="" disabled selected>-- Pilih Jenis Kelamin --</option>
                        <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki
                        </option>
                        <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan
                        </option>
                    </select>
                </div>
                @error('jenis_kelamin')
                    <div class="text-danger small mt-1"><i class="bi bi-exclamation-circle me-1"></i> {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="profesi" class="form-label text-secondary small fw-semibold mb-1">Profesi / Jabatan</label>
                <div class="input-group input-group-merge">
                    <span class="input-group-text bg-light border-end-0 text-muted px-3"
                        style="border-color: #e2e8f0; border-radius: 4px 0 0 4px;">
                        <i class="bi bi-briefcase"></i>
                    </span>
                    <input id="profesi"
                        class="form-control border-start-0 ps-0 custom-auth-input @error('profesi') is-invalid @enderror"
                        type="text" name="profesi" value="{{ old('profesi') }}" required
                        placeholder="Contoh: Dokter, Perawat, Perekam Medis"
                        style="border-color: #e2e8f0; border-radius: 0 4px 4px 0; font-size: 0.9rem; padding: 0.55rem 0.75rem;">
                </div>
                @error('profesi')
                    <div class="text-danger small mt-1"><i class="bi bi-exclamation-circle me-1"></i> {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="unit_kerja" class="form-label text-secondary small fw-semibold mb-1">Unit Kerja /
                    Ruangan</label>
                <div class="input-group input-group-merge">
                    <span class="input-group-text bg-light border-end-0 text-muted px-3"
                        style="border-color: #e2e8f0; border-radius: 4px 0 0 4px;">
                        <i class="bi bi-building"></i>
                    </span>
                    <input id="unit_kerja"
                        class="form-control border-start-0 ps-0 custom-auth-input @error('unit_kerja') is-invalid @enderror"
                        type="text" name="unit_kerja" value="{{ old('unit_kerja') }}" required
                        placeholder="Contoh: Rawat Jalan, Rekam Medis, IGD"
                        style="border-color: #e2e8f0; border-radius: 0 4px 4px 0; font-size: 0.9rem; padding: 0.55rem 0.75rem;">
                </div>
                @error('unit_kerja')
                    <div class="text-danger small mt-1"><i class="bi bi-exclamation-circle me-1"></i> {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label text-secondary small fw-semibold mb-1">Alamat Email</label>
                <div class="input-group input-group-merge">
                    <span class="input-group-text bg-light border-end-0 text-muted px-3"
                        style="border-color: #e2e8f0; border-radius: 4px 0 0 4px;">
                        <i class="bi bi-envelope"></i>
                    </span>
                    <input id="email"
                        class="form-control border-start-0 ps-0 custom-auth-input @error('email') is-invalid @enderror"
                        type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                        placeholder="nama@rsmetro.test"
                        style="border-color: #e2e8f0; border-radius: 0 4px 4px 0; font-size: 0.9rem; padding: 0.55rem 0.75rem;">
                </div>
                @error('email')
                    <div class="text-danger small mt-1"><i class="bi bi-exclamation-circle me-1"></i> {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label text-secondary small fw-semibold mb-1">Password</label>
                <div class="input-group input-group-merge">
                    <span class="input-group-text bg-light border-end-0 text-muted px-3"
                        style="border-color: #e2e8f0; border-radius: 4px 0 0 4px;">
                        <i class="bi bi-lock"></i>
                    </span>
                    <input id="password"
                        class="form-control border-start-0 ps-0 custom-auth-input @error('password') is-invalid @enderror"
                        type="password" name="password" required autocomplete="new-password"
                        placeholder="Minimal 8 karakter"
                        style="border-color: #e2e8f0; border-radius: 0 4px 4px 0; font-size: 0.9rem; padding: 0.55rem 0.75rem;">
                </div>
                @error('password')
                    <div class="text-danger small mt-1"><i class="bi bi-exclamation-circle me-1"></i> {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="form-label text-secondary small fw-semibold mb-1">Konfirmasi
                    Password</label>
                <div class="input-group input-group-merge">
                    <span class="input-group-text bg-light border-end-0 text-muted px-3"
                        style="border-color: #e2e8f0; border-radius: 4px 0 0 4px;">
                        <i class="bi bi-shield-lock"></i>
                    </span>
                    <input id="password_confirmation" class="form-control border-start-0 ps-0 custom-auth-input"
                        type="password" name="password_confirmation" required autocomplete="new-password"
                        placeholder="Ulangi password Anda"
                        style="border-color: #e2e8f0; border-radius: 0 4px 4px 0; font-size: 0.9rem; padding: 0.55rem 0.75rem;">
                </div>
            </div>

            <div class="d-grid mb-3">
                <button type="submit" class="btn btn-primary btn-lg text-white fs-6 fw-semibold py-2.5 shadow-sm"
                    style="border-radius: 4px;">
                    <i class="bi bi-check-circle me-2"></i> Daftar Sekarang
                </button>
            </div>

            <div class="text-center mt-4 border-top border-light pt-3">
                <p class="text-muted small mb-1">Sudah punya akun sebelumnya?</p>
                <a href="{{ route('login') }}" class="text-primary fw-semibold text-decoration-none small">
                    Masuk ke Sistem <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
