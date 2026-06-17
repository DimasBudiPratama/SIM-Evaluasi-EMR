@extends('layouts.admin.app')

@section('title', 'Laporan Hasil Evaluasi')
@section('page-heading', 'Laporan Hasil Evaluasi')
@section('page-subheading', 'Unduh dan cetak hasil rekapitulasi data kuesioner PIECES & TAM')

@push('style')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css">
    <style>
        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid #e2e8f0;
            font-size: 0.85rem;
            border-radius: 4px;
            padding: 0.35rem 0.7rem;
        }

        .btn-download-action {
            padding: 0.45rem 1rem;
            font-size: 0.8rem;
            font-weight: 600;
            border-radius: 4px;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
    </style>
@endpush

@section('content')
    <div class="mb-4 d-flex justify-content-end gap-2">
        <a href="{{ route('laporanExcel.gabungan') }}" class="btn btn-success btn-download-action text-white shadow-sm">
            <i class="bi bi-file-earmark-excel-fill"></i> Unduh Excel Gabungan
        </a>
        <a href="{{ route('laporanPdf.gabungan') }}" class="btn btn-danger btn-download-action text-white shadow-sm">
            <i class="bi bi-file-earmark-pdf-fill"></i> Unduh PDF Gabungan
        </a>
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm bg-primary text-white" style="border-radius: 6px;">
                <div class="card-body p-4 d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div style="flex: 1; min-width: 250px;">
                        <h5 class="fw-bold mb-1">
                            <i class="bi bi-file-earmark-bar-graph me-2"></i>Pusat Konsolidasi Laporan
                        </h5>
                        <p class="mb-0 small text-white-50">
                            Data laporan bersumber dari akumulasi respons aktif pengguna SIMRS RSU Muhammadiyah Metro.
                        </p>
                    </div>

                    <div class="bg-white bg-opacity-20 px-4 py-2 rounded text-center" style="min-width: 150px;">
                        <span class="small d-block fw-bold text-uppercase text-black"
                            style="opacity: 0.7; font-size: 0.75rem; letter-spacing: 0.5px;">Sampel N</span>
                        <h3 class="fw-bold mb-0 text-black mt-1">
                            {{ $totalResponden }}
                            <span class="fs-6 fw-normal text-black text-opacity-75">Responden</span>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4" style="border-radius: 6px;">
        <div
            class="card-header bg-white border-bottom border-light py-3 px-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h6 class="text-dark fw-bold mb-0"><i class="bi bi-pie-chart text-info me-2"></i>Rekapitulasi Indikator Metode
                PIECES</h6>
            <div class="d-flex gap-2">
                <a href="{{ route('laporanExcel.pieces') }}" class="btn btn-success btn-download-action text-white">
                    <i class="bi bi-file-earmark-excel"></i> Excel PIECES
                </a>
                <a href="{{ route('laporanPdf.pieces') }}" class="btn btn-danger btn-download-action text-white">
                    <i class="bi bi-file-earmark-pdf"></i> PDF PIECES
                </a>
            </div>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive">
                <table id="tableLaporanPieces" class="table table-striped table-hover align-middle mb-0" style="width:100%">
                    <thead class="table-light text-secondary small fw-bold text-uppercase">
                        <tr>
                            <th class="py-3 px-3">Kategori / Dimensi Indikator</th>
                            <th class="py-3 text-center" style="width: 15%">Jumlah Butir</th>
                            <th class="py-3 text-center" style="width: 15%">Rata-rata (Mean)</th>
                            <th class="py-3 text-center" style="width: 15%">Persentase Kelayakan</th>
                            <th class="py-3 px-4 text-center" style="width: 20%">Kriteria Nilai</th>
                        </tr>
                    </thead>
                    <tbody class="text-dark" style="font-size: 0.88rem;">
                        @foreach ($laporanPieces as $row)
                            <tr class="border-bottom border-light">
                                <td class="py-3 px-3 fw-semibold text-secondary">{{ $row['kategori'] }}</td>
                                <td class="py-3 text-center fw-medium">{{ $row['total_butir'] }} Item</td>
                                <td class="py-3 text-center fw-bold text-primary">{{ number_format($row['mean'], 2) }}</td>
                                <td class="py-3 text-center fw-semibold text-success">{{ $row['persentase'] }}%</td>
                                <td class="py-3 text-center px-4">
                                    <span
                                        class="badge @if ($row['interpretasi'] == 'Sangat Baik') bg-primary bg-opacity-10 text-primary @elseif($row['interpretasi'] == 'Baik') bg-success bg-opacity-10 text-success @elseif($row['interpretasi'] == 'Cukup') bg-warning bg-opacity-10 text-warning @else bg-danger bg-opacity-10 text-danger @endif px-2.5 py-1.5 fw-bold w-100"
                                        style="max-width:120px; border-radius:4px;">
                                        {{ $row['interpretasi'] }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-5" style="border-radius: 6px;">
        <div
            class="card-header bg-white border-bottom border-light py-3 px-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h6 class="text-dark fw-bold mb-0"><i class="bi bi-laptop text-success me-2"></i>Rekapitulasi Indikator Metode
                TAM</h6>
            <div class="d-flex gap-2">
                <a href="{{ route('laporanExcel.tam') }}" class="btn btn-success btn-download-action text-white">
                    <i class="bi bi-file-earmark-excel"></i> Excel TAM
                </a>
                <a href="{{ route('laporanPdf.tam') }}" class="btn btn-danger btn-download-action text-white">
                    <i class="bi bi-file-earmark-pdf"></i> PDF TAM
                </a>
            </div>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive">
                <table id="tableLaporanTam" class="table table-striped table-hover align-middle mb-0" style="width:100%">
                    <thead class="table-light text-secondary small fw-bold text-uppercase">
                        <tr>
                            <th class="py-3 px-3">Kategori / Dimensi Indikator</th>
                            <th class="py-3 text-center" style="width: 15%">Jumlah Butir</th>
                            <th class="py-3 text-center" style="width: 15%">Rata-rata (Mean)</th>
                            <th class="py-3 text-center" style="width: 15%">Persentase Kelayakan</th>
                            <th class="py-3 px-4 text-center" style="width: 20%">Kriteria Nilai</th>
                        </tr>
                    </thead>
                    <tbody class="text-dark" style="font-size: 0.88rem;">
                        @foreach ($laporanTam as $row)
                            <tr class="border-bottom border-light">
                                <td class="py-3 px-3 fw-semibold text-secondary">{{ $row['kategori'] }}</td>
                                <td class="py-3 text-center fw-medium">{{ $row['total_butir'] }} Item</td>
                                <td class="py-3 text-center fw-bold text-primary">{{ number_format($row['mean'], 2) }}</td>
                                <td class="py-3 text-center fw-semibold text-success">{{ $row['persentase'] }}%</td>
                                <td class="py-3 text-center px-4">
                                    <span
                                        class="badge @if ($row['interpretasi'] == 'Sangat Baik') bg-primary bg-opacity-10 text-primary @elseif($row['interpretasi'] == 'Baik') bg-success bg-opacity-10 text-success @elseif($row['interpretasi'] == 'Cukup') bg-warning bg-opacity-10 text-warning @else bg-danger bg-opacity-10 text-danger @endif px-2.5 py-1.5 fw-bold w-100"
                                        style="max-width:120px; border-radius:4px;">
                                        {{ $row['interpretasi'] }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
