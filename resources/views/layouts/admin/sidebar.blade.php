<aside class="admin-sidebar" id="adminSidebar" aria-label="Main navigation">
    <div class="sidebar-header">
        <a class="brand-mark text-decoration-none" href="{{ route('dashboard') }}" aria-label="SIM-Evaluasi EMR">
            <span class="brand-icon"><i class="bi bi-hospital" aria-hidden="true"></i></span>
            <span class="brand-copy">
                <span class="brand-title">SIM-Evaluasi EMR</span>
                <span class="brand-subtitle">RSU Muhammadiyah Metro</span>
            </span>
        </a>
    </div>

    <nav class="sidebar-nav">
        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}"
            {!! request()->routeIs('dashboard') ? 'aria-current="page"' : '' !!}>
            <span class="nav-icon"><i class="bi bi-speedometer2" aria-hidden="true"></i></span>
            <span class="nav-text">Dashboard</span>
        </a>

        <a class="nav-link {{ request()->routeIs('kuesioner-pieces.*') ? 'active' : '' }}"
            href="{{ route('kuesioner-pieces.index') }}">
            <span class="nav-icon"><i class="bi bi-list-check" aria-hidden="true"></i></span>
            <span class="nav-text">Kuesioner PIECES</span>
        </a>

        <a class="nav-link {{ request()->routeIs('kuesioner-tam.*') ? 'active' : '' }}"
            href="{{ route('kuesioner-tam.index') }}">
            <span class="nav-icon"><i class="bi bi-shield-check" aria-hidden="true"></i></span>
            <span class="nav-text">Kuesioner TAM</span>
        </a>

        <a class="nav-link {{ request()->routeIs('riwayat.*') ? 'active' : '' }}" href="{{ route('riwayat.index') }}">
            <span class="nav-icon"><i class="bi bi-clock-history" aria-hidden="true"></i></span>
            <span class="nav-text">Riwayat</span>
        </a>

        <a class="nav-link {{ request()->routeIs('responden.*') ? 'active' : '' }}"
            href="{{ route('responden.index') }}">
            <span class="nav-icon"><i class="bi bi-people" aria-hidden="true"></i></span>
            <span class="nav-text">Responden</span>
        </a>

        <a class="nav-link {{ request()->routeIs('pertanyaan.*') ? 'active' : '' }}"
            href="{{ route('pertanyaan.index') }}">
            <span class="nav-icon"><i class="bi bi-question-circle" aria-hidden="true"></i></span>
            <span class="nav-text">Pertanyaan</span>
        </a>

        <a class="nav-link {{ request()->routeIs('analisis.*') ? 'active' : '' }}"
            href="{{ route('analisis.index') }}">
            <span class="nav-icon"><i class="bi bi-sliders" aria-hidden="true"></i></span>
            <span class="nav-text">Analisis</span>
        </a>

        <a class="nav-link {{ request()->routeIs('laporan.*') ? 'active' : '' }}" href="{{ route('laporan.index') }}">
            <span class="nav-icon"><i class="bi bi-file-earmark-text" aria-hidden="true"></i></span>
            <span class="nav-text">Laporan</span>
        </a>
    </nav>

    <div class="sidebar-footer">
        <span class="status-dot"></span>
        <span class="sidebar-footer-text">System running smoothly</span>
    </div>
</aside>
