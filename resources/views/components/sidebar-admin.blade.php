<div class="sidebar">
    <div class="sidebar-brand px-4 pt-4 pb-3">
        <span class="fw-bold d-block text-white" style="font-size: 1.05rem; letter-spacing: 0.3px;">SIM-Evaluasi
            EMR</span>
        <small class="text-secondary d-block mt-0" style="font-size: 0.72rem; color: #8a94a6 !important;">RSU Muhammadiyah
            Metro</small>
    </div>

    <ul class="sidebar-menu px-3">
        <li class="sidebar-item mb-1 {{ Request::is('dashboard-admin') || Request::is('dashboard') ? 'active' : '' }}">
            <a href="/dashboard-admin"><i class="bi bi-graph-up-arrow"></i> Dashboard</a>
        </li>
        <li class="sidebar-item mb-1 {{ Request::is('kuesioner-pieces*') ? 'active' : '' }}">
            <a href="#"><i class="bi bi-list-check"></i> Kuesioner PIECES</a>
        </li>
        <li class="sidebar-item mb-1 {{ Request::is('kuesioner-tam*') ? 'active' : '' }}">
            <a href="#"><i class="bi bi-shield-check"></i> Kuesioner TAM</a>
        </li>
        <li class="sidebar-item mb-1 {{ Request::is('riwayat*') ? 'active' : '' }}">
            <a href="#"><i class="bi bi-clock-history"></i> Riwayat</a>
        </li>
        <li class="sidebar-item mb-1 {{ Request::is('responden*') ? 'active' : '' }}">
            <a href="#"><i class="bi bi-people"></i> Responden</a>
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
