<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIM-Evaluasi EMR RSU Muhammadiyah Metro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        :root {
            --primary-color: #198754;
            /* Hijau khas */
            --dark-overlay: rgba(15, 23, 42, 0.85);
            /* Overlay gelap agar teks terbaca */
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }

        /* Hero Section dengan Background Image */
        .hero-section {
            position: relative;
            /* Ganti URL di bawah dengan path gambar gedung rumah sakit Anda */
            background: url("{{ asset('assest/img/gedung rs.png') }}") no-repeat center center/cover;
            min-height: 100vh;
            color: white;
            display: flex;
            flex-direction: column;
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: var(--dark-overlay);
            z-index: 1;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            flex: 1;
        }

        /* Navbar Styling */
        .navbar {
            position: relative;
            z-index: 3;
            background: white !important;
        }

        /* Badge Evaluasi */
        .badge-evaluasi {
            background-color: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        /* Statistik Mini Card */
        .stat-card {
            background: white;
            color: #333;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .stat-card h3 {
            font-weight: 700;
            margin-bottom: 2px;
        }

        .stat-card p {
            font-size: 0.75rem;
            color: #6c757d;
            margin: 0;
        }

        /* Mockup Dashboard Card (Sisi Kanan) */
        .mockup-card {
            background: white;
            border-radius: 12px;
            padding: 24px;
            color: #333;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
        }

        .mockup-sidebar-line {
            height: 8px;
            background: #e2e8f0;
            border-radius: 4px;
            margin-bottom: 10px;
        }

        .chart-bar {
            height: 100px;
            background: linear-gradient(to top, #0284c7, #22d3ee);
            border-radius: 4px 4px 0 0;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-white py-3 shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="#">
                <div class="bg-primary text-white p-2 rounded d-flex align-items-center justify-content-center"
                    style="width: 40px; height: 40px;">
                    <i class="bi bi-building-fill-gear"></i>
                </div>
                <div>
                    <span class="fw-bold d-block mb-0" style="font-size: 1rem; color: #0f172a;">SIM-Evaluasi EMR</span>
                    <span class="text-muted d-block" style="font-size: 0.75rem;">RSU Muhammadiyah Metro</span>
                </div>
            </a>
            <div class="ms-auto d-flex gap-2">
                <a href="{{ route('login') }}" class="btn btn-outline-secondary btn-sm px-3">Masuk</a>
                <a href="{{ route('register') }}" class="btn btn-success btn-sm px-3 bg-gradient">Daftar Responden</a>
            </div>
        </div>
    </nav>

    <div class="hero-section">
        <div class="hero-overlay"></div>

        <div class="container hero-content my-auto py-5">
            <div class="row align-items-center g-5">

                <div class="col-lg-6">
                    <div class="badge-evaluasi mb-4">
                        <i class="bi bi-geo-alt-fill text-success"></i>RSU Muhammadiyah Metro
                    </div>

                    <h1 class="display-5 fw-bold mb-3 lh-sm">
                        SIM-Evaluasi EMR RSU Muhammadiyah Metro
                    </h1>

                    <p class="lead fs-6 text-white-50 mb-4" style="text-align: justify;">
                        Sistem penelitian untuk mengukur efektivitas pelayanan administrasi, akurasi data medis,
                        integrasi antar unit, dan penerimaan pengguna melalui metode PIECES dan TAM.
                    </p>

                    <div class="d-flex gap-3 mb-5">
                        <a href="{{ route('login') }}"
                            class="btn btn-success btn-lg px-4 fs-6 bg-gradient d-flex align-items-center gap-2">
                            <i class="bi bi-box-arrow-in-right"></i> Masuk Sistem
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg px-4 fs-6">
                            Registrasi Responden
                        </a>
                    </div>

                    <div class="row g-3">
                        <div class="col-6 col-sm-3">
                            <div class="stat-card">
                                <h3>{{ $totalResponden }}</h3>
                                <p>Responden</p>
                            </div>
                        </div>
                        <div class="col-6 col-sm-3">
                            <div class="stat-card">
                                <h3>{{ $totalPertanyaan }}</h3>
                                <p>Pertanyaan</p>
                            </div>
                        </div>
                        <div class="col-6 col-sm-3">
                            <div class="stat-card">
                                <h3>{{ $globalMeanPieces }}</h3>
                                <p>Mean PIECES</p>
                            </div>
                        </div>
                        <div class="col-6 col-sm-3">
                            <div class="stat-card">
                                <h3>{{ $globalMeanTam }}</h3>
                                <p>Mean TAM</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="mockup-card">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div style="width: 100px; height: 12px; background: #e2e8f0; border-radius: 6px;"></div>
                            <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2.5 py-1"
                                style="font-size: 0.7rem; font-weight: 600;">Realtime</span>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-4 border pe-3">
                                <div class="bg-light rounded p-2 mb-2" style="height: 40px;"></div>
                                <div class="mockup-sidebar-line" style="width: 80%;"></div>
                                <div class="mockup-sidebar-line" style="width: 60%;"></div>
                                <div class="mockup-sidebar-line" style="width: 70%;"></div>
                            </div>

                            <div class="col-8">
                                <div class="row g-3">

                                    <div class="col-6">
                                        <div class="p-3 border rounded bg-white">
                                            <i class="bi bi-people-fill text-primary mb-2 d-block"></i>
                                            <h5 class="fw-bold mb-0" style="font-size: 1.1rem;">100</h5>
                                            <small class="text-muted" style="font-size: 0.65rem;">Total
                                                responden</small>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="p-3 border rounded bg-white">
                                            <i class="bi bi-file-earmark-check-fill text-success mb-2 d-block"></i>
                                            <h5 class="fw-bold mb-0" style="font-size: 1.1rem;">2</h5>
                                            <small class="text-muted" style="font-size: 0.65rem;">Kuesioner
                                                final</small>
                                        </div>
                                    </div>

                                    <div class="col-12 mt-4">
                                        <div class="row g-2 align-items-end px-2">
                                            <div class="col">
                                                <div class="chart-bar" style="height: 40px;"></div>
                                            </div>
                                            <div class="col">
                                                <div class="chart-bar" style="height: 70px;"></div>
                                            </div>
                                            <div class="col">
                                                <div class="chart-bar" style="height: 55px;"></div>
                                            </div>
                                            <div class="col">
                                                <div class="chart-bar" style="height: 90px;"></div>
                                            </div>
                                            <div class="col">
                                                <div class="chart-bar" style="height: 65px;"></div>
                                            </div>
                                            <div class="col">
                                                <div class="chart-bar" style="height: 80px;"></div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-2 justify-content-start border-top pt-3"
                            style="font-size: 0.75rem; font-weight: 600;">
                            <span class="text-secondary"><i class="bi bi-bar-chart-fill text-primary"></i>
                                PIECES</span>
                            <span class="text-secondary"><i class="bi bi-person-fill-check text-success"></i>
                                TAM</span>
                            <span class="text-secondary"><i class="bi bi-file-earmark-pdf-fill text-danger"></i>
                                PDF</span>
                            <span class="text-secondary"><i class="bi bi-file-earmark-excel-fill text-success"></i>
                                Excel</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
