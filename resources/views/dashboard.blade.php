@extends('layouts.admin.app')

@section('title', 'Dashboard Utama')
@section('page-heading', 'Dashboard Sistem')
@section('page-subheading', 'Ringkasan eksekutif hasil evaluasi implementasi EMR RSU Muhammadiyah Metro')

@section('content')
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm bg-primary text-white" style="border-radius: 6px;">
                <div class="card-body p-4 d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div style="flex: 1; min-width: 250px;">
                        <h5 class="fw-bold mb-1"><i class="bi bi-file-earmark-bar-graph me-2"></i>Pusat Konsolidasi Laporan
                        </h5>
                        <p class="mb-0 small text-white-50">Data laporan bersumber dari akumulasi respons aktif pengguna
                            SIMRS RSU Muhammadiyah Metro.</p>
                    </div>
                    <div class="bg-white bg-opacity-20 px-4 py-2 rounded text-center" style="min-width: 150px;">
                        <span class="small d-block fw-bold text-uppercase text-black"
                            style="opacity: 0.7; font-size: 0.75rem; letter-spacing: 0.5px;">Sampel N</span>
                        <h3 class="fw-bold mb-0 text-black mt-1">
                            {{ $totalResponden }} <span class="fs-6 fw-normal text-black text-opacity-75">Responden</span>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-6 col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 6px;">
                <div class="card-body px-4 py-4-5 d-flex align-items-center">
                    <div class="avatar avatar-lg bg-primary bg-opacity-10 p-3 text-primary me-3 d-flex align-items-center justify-content-center"
                        style="border-radius: 8px; width: 48px; height: 48px;">
                        <i class="bi bi-list-check fs-4"></i>
                    </div>
                    <div>
                        <h6 class="text-muted font-semibold small mb-1">Indikator PIECES</h6>
                        <h5 class="font-extrabold mb-0 fw-bold text-dark">{{ $totalPertanyaanPieces ?? 18 }} <span
                                class="fs-7 fw-normal text-secondary">Butir</span></h5>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 6px;">
                <div class="card-body px-4 py-4-5 d-flex align-items-center">
                    <div class="avatar avatar-lg bg-teal bg-opacity-10 p-3 text-success me-3 d-flex align-items-center justify-content-center"
                        style="border-radius: 8px; width: 48px; height: 48px; background-color: #e6fffa; color: #0f766e !important;">
                        <i class="bi bi-shield-check fs-4"></i>
                    </div>
                    <div>
                        <h6 class="text-muted font-semibold small mb-1">Indikator TAM</h6>
                        <h5 class="font-extrabold mb-0 fw-bold text-dark">{{ $totalPertanyaanTam ?? 12 }} <span
                                class="fs-7 fw-normal text-secondary">Butir</span></h5>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 6px;">
                <div class="card-body px-4 py-4-5 d-flex align-items-center">
                    <div class="avatar avatar-lg bg-info bg-opacity-10 p-3 text-info me-3 d-flex align-items-center justify-content-center"
                        style="border-radius: 8px; width: 48px; height: 48px;">
                        <i class="bi bi-graph-up-arrow fs-4"></i>
                    </div>
                    <div>
                        <h6 class="text-muted font-semibold small mb-1">Mean PIECES Global</h6>
                        <h5 class="font-extrabold mb-0 fw-bold text-primary">{{ $globalMeanPieces ?? '3.17' }}</h5>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 6px;">
                <div class="card-body px-4 py-4-5 d-flex align-items-center">
                    <div class="avatar avatar-lg bg-warning bg-opacity-10 p-3 text-warning me-3 d-flex align-items-center justify-content-center"
                        style="border-radius: 8px; width: 48px; height: 48px;">
                        <i class="bi bi-star-half fs-4"></i>
                    </div>
                    <div>
                        <h6 class="text-muted font-semibold small mb-1">Mean TAM Global</h6>
                        <h5 class="font-extrabold mb-0 fw-bold text-warning">{{ $globalMeanTam ?? '3.42' }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12 col-xl-8 mb-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 6px;">
                <div
                    class="card-header bg-transparent border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="fw-bold text-dark mb-0">Visualisasi Nilai Rata-rata Kategori</h5>
                        <p class="text-muted small mb-0">Persentase Karegori PIECES</p>
                    </div>
                    <a href="{{ route('laporan.index') }}" class="btn btn-sm btn-outline-primary px-3"
                        style="border-radius: 4px;">Lihat Tabel Laporan</a>
                </div>
                <div class="card-body px-4 pb-4">
                    <div id="chartBarPieces" style="height: 300px; width: 100%;"></div>
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-4 mb-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 6px;">
                <div class="card-header bg-transparent border-0 pt-4 px-4">
                    <h5 class="fw-bold text-dark mb-0">TAM</h5>
                    <p class="text-muted small mb-0">Persentase Karegori TAM</p>
                </div>
                <div class="card-body px-4 pb-4 d-flex flex-column justify-content-center">
                    <div id="chartRadarTam" style="height: 300px; width: 100%;"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        window.addEventListener('load', function() {
            // Helper function untuk memastikan elemen ada sebelum render
            function renderChart(elementId, options) {
                var element = document.querySelector(elementId);
                if (element) {
                    new ApexCharts(element, options).render();
                } else {
                    console.error("Element not found: " + elementId);
                }
            }

            // A. Grafik PIECES
            var optionsPieces = {
                series: [{
                    name: 'Persentase Kelayakan',
                    // Data langsung dari variabel controller
                    data: [
                        {{ $persenPiecesData['Control'] ?? 0 }},
                        {{ $persenPiecesData['Economy'] ?? 0 }},
                        {{ $persenPiecesData['Performance'] ?? 0 }},
                        {{ $persenPiecesData['Information'] ?? 0 }},
                        {{ $persenPiecesData['Efficiency'] ?? 0 }},
                        {{ $persenPiecesData['Service'] ?? 0 }}
                    ]
                }],
                xaxis: {
                    // MENGGANTI ANGKA DENGAN NAMA KATEGORI
                    categories: ['Control', 'Economy', 'Performance', 'Information', 'Efficiency', 'Service'],
                },
                chart: {
                    type: 'bar',
                    height: 300
                },
                // ... (sisanya sama)
            };
            renderChart("#chartBarPieces", optionsPieces);

            // B. Grafik Radar TAM
            const chartTamEl = document.querySelector("#chartRadarTam");
            if (chartTamEl) {
                var optionsDonut = {
                    series: [
                        {{ $persenTamData['Perceived Usefulness'] ?? 0 }},
                        {{ $persenTamData['Perceived Ease of Use'] ?? 0 }},
                        {{ $persenTamData['Behavioral Intention to Use'] ?? 0 }}
                    ],
                    chart: {
                        type: 'donut',
                        height: 300, // Ukuran tinggi donut
                        toolbar: {
                            show: false
                        }
                    },
                    labels: ['Perceived Usefulness', 'Perceived Ease of Use', 'Behavioral Intention'],
                    colors: ['#198754', '#20c997', '#0f766e'], // Warna untuk 3 dimensi TAM
                    plotOptions: {
                        pie: {
                            donut: {
                                size: '65%', // Ketebalan donut
                                labels: {
                                    show: true,
                                    total: {
                                        show: true,
                                        label: 'Rata-rata',
                                        formatter: function(w) {
                                            const total = w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                            return (total / w.globals.seriesTotals.length).toFixed(1) + '%';
                                        }
                                    }
                                }
                            }
                        }
                    },
                    legend: {
                        position: 'bottom',
                        fontSize: '14px'
                    },
                    dataLabels: {
                        enabled: true,
                        formatter: (val) => val.toFixed(1) + "%"
                    },
                    tooltip: {
                        y: {
                            formatter: (val) => val + "%"
                        }
                    }
                };
                new ApexCharts(chartTamEl, optionsDonut).render();
            }
        });
    </script>
@endpush
