<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - SIM-Evaluasi EMR</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        :root {
            --bg-main: #f2f7ff;
            --sidebar-bg: #1e232f;
            --sidebar-active: rgba(255, 255, 255, 0.08);
        }

        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background-color: var(--bg-main);
        }

        /* SIDEBAR GLOBAL STYLE */
        .sidebar {
            width: 260px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background-color: var(--sidebar-bg);
            z-index: 100;
        }

        .sidebar-menu {
            list-style: none;
            margin: 0;
        }

        .sidebar-item a {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 12px 18px;
            color: #7c889b;
            text-decoration: none;
            font-size: 0.92rem;
            font-weight: 500;
            border-radius: 8px;
            transition: all 0.2s;
        }

        .sidebar-item a:hover {
            color: #fff;
            background-color: rgba(255, 255, 255, 0.04);
        }

        .sidebar-item.active a {
            color: #fff;
            background-color: var(--sidebar-active);
        }

        /* MAIN CONTENT GLOBAL STYLE */
        .main-content {
            margin-left: 260px;
            padding: 35px 40px;
            min-height: 100vh;
        }

        /* REUSABLE CARDS MAZER LUX */
        .stat-card {
            background: white;
            border: none;
            border-radius: 12px;
            padding: 20px 24px;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.02);
        }

        .icon-box-round {
            width: 46px;
            height: 46px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
        }

        .chart-card {
            background: white;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.02);
            border: none;
        }
    </style>

    {{-- Placeholder CSS Kustom Tambahan Per Halaman --}}
    @stack('style')
</head>

<body>

    <div class="sidebar">
        <div class="sidebar-brand px-4 pt-4 pb-3">
            <span class="fw-bold d-block text-white" style="font-size: 1.05rem; letter-spacing: 0.3px;">SIM-Evaluasi
                EMR</span>
            <small class="text-secondary d-block mt-0" style="font-size: 0.72rem; color: #8a94a6 !important;">RSU
                Muhammadiyah Metro</small>
        </div>

        <ul class="sidebar-menu px-3">
            <li
                class="sidebar-item mb-1 {{ Request::is('dashboard-admin') || Request::is('dashboard') ? 'active' : '' }}">
                <a href="/dashboard-admin"><i class="bi bi-graph-up-arrow"></i> Dashboard</a>
            </li>
            <li class="sidebar-item mb-1 {{ Request::is('kuesioner-pieces*') ? 'active' : '' }}">
                <a href="{{ route('kuesioner-pieces.index') }}"><i class="bi bi-list-check"></i> Kuesioner PIECES</a>
            </li>
            <li class="sidebar-item mb-1 {{ Request::is('kuesioner-tam*') ? 'active' : '' }}">
                <a href="{{ route('kuesioner-tam.index') }}"><i class="bi bi-shield-check"></i> Kuesioner TAM</a>
            </li>
            <li class="sidebar-item mb-1 {{ Request::is('riwayat*') ? 'active' : '' }}">
                <a href="{{ route('riwayat.index') }}"><i class="bi bi-clock-history"></i> Riwayat</a>
            </li>
            <li class="sidebar-item mb-1 {{ Request::is('responden*') ? 'active' : '' }}">
                <a href="{{ route('responden.index') }}"><i class="bi bi-people"></i> Responden</a>
            </li>
            <li class="sidebar-item mb-1 {{ Request::is('pertanyaan*') ? 'active' : '' }}">
                <a href="{{ route('pertanyaan.index') }}"><i class="bi bi-question-circle"></i> Pertanyaan</a>
            </li>
            <li class="sidebar-item mb-1 {{ Request::is('analisis*') ? 'active' : '' }}">
                <a href="#"><i class="bi bi-sliders"></i> Analisis</a>
            </li>
            <li class="sidebar-item mb-1 {{ Request::is('laporan*') ? 'active' : '' }}">
                <a href="#"><i class="bi bi-file-earmark-text"></i> Laporan</a>
            </li>
        </ul>
    </div>

    <div class="main-content">

        <div class="d-flex justify-content-between align-items-start mb-4">
            <div>
                <h3 class="fw-bold text-dark mb-1" style="font-size: 1.6rem;">@yield('page-heading')</h3>
                <p class="text-muted small mb-0">@yield('page-subheading')</p>
            </div>

            <div class="d-flex align-items-center gap-3 bg-white px-3 py-2 rounded-3 shadow-sm border border-light">
                <span class="small fw-semibold text-secondary" style="font-size: 0.88rem;">Administrator</span>

                <form method="POST" action="{{ route('logout') }}"
                    class="m-0 d-flex align-items-center border-start ps-3">
                    @csrf
                    <button type="submit" class="btn btn-link p-0 text-danger border-0 d-flex align-items-center"
                        title="Keluar Sistem">
                        <i class="bi bi-box-arrow-right fs-5"></i>
                    </button>
                </form>
            </div>
        </div>

        @yield('content')

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        @if (session('success'))
            Swal.fire({
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                icon: 'success',
                timer: 2500,
                showConfirmButton: false
            });
        @endif

        @if (session('error'))
            Swal.fire({
                title: 'Gagal!',
                text: "{{ session('error') }}",
                icon: 'error',
                confirmButtonColor: '#dc3545'
            });
        @endif
    </script>

    {{-- Placeholder Script Tambahan Per Halaman (Misal Chart.js) --}}
    @stack('script')
</body>

</html>
