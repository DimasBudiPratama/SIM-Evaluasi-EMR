@extends('layouts.admin.app')

@section('title', 'Analisis Otomatis Kuesioner')
@section('page-heading', 'Analisis Otomatis')
@section('page-subheading', 'Evaluasi Implementasi EMR berbasis PIECES dan TAM di RSU Muhammadiyah Metro')

@section('content')
    <div class="row g-4 mb-4">
        <div class="col-12 col-xl-6">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 6px;">
                <div class="card-header bg-white border-bottom border-light py-3 px-4">
                    <h6 class="text-dark fw-bold mb-0"><i class="bi bi-pie-chart text-info me-2"></i>Hasil PIECES</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light small fw-bold text-secondary">
                                <tr>
                                    <th class="py-3 px-4">Kategori</th>
                                    <th class="py-3 text-center">Mean</th>
                                    <th class="py-3 text-center">%</th>
                                    <th class="py-3 px-4">Interpretasi</th>
                                </tr>
                            </thead>
                            <tbody class="text-dark" style="font-size: 0.88rem;">
                                @forelse($analisisPieces as $ap)
                                    <tr class="border-bottom border-light">
                                        <td class="px-4 fw-semibold text-secondary">{{ $ap['kategori'] }}</td>
                                        <td class="text-center fw-bold text-dark">{{ $ap['mean'] }}</td>
                                        <td class="text-center fw-semibold text-primary">{{ $ap['persentase'] }}%</td>
                                        <td class="px-4">
                                            <span
                                                class="badge 
                                                    @if ($ap['interpretasi'] == 'Sangat Baik') bg-primary bg-opacity-10 text-primary
                                                    @elseif($ap['interpretasi'] == 'Baik') bg-success bg-opacity-10 text-success
                                                    @elseif($ap['interpretasi'] == 'Cukup') bg-warning bg-opacity-10 text-warning
                                                    @elseif($ap['interpretasi'] == 'Buruk' || $ap['interpretasi'] == 'Sangat Buruk') bg-danger bg-opacity-10 text-danger
                                                    @else bg-secondary bg-opacity-10 text-secondary @endif px-2.5 py-1.5 fw-bold"
                                                style="border-radius:4px;">
                                                {{ $ap['interpretasi'] }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted">Belum ada sampel data masuk.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-xl-6">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 6px;">
                <div class="card-header bg-white border-bottom border-light py-3 px-4">
                    <h6 class="text-dark fw-bold mb-0"><i class="bi bi-laptop text-success me-2"></i>Hasil TAM</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light small fw-bold text-secondary">
                                <tr>
                                    <th class="py-3 px-4">Kategori</th>
                                    <th class="py-3 text-center">Mean</th>
                                    <th class="py-3 text-center">%</th>
                                    <th class="py-3 px-4">Interpretasi</th>
                                </tr>
                            </thead>
                            <tbody class="text-dark" style="font-size: 0.88rem;">
                                @forelse($analisisTam as $at)
                                    <tr class="border-bottom border-light">
                                        <td class="px-4 fw-semibold text-secondary">{{ $at['kategori'] }}</td>
                                        <td class="text-center fw-bold text-dark">{{ $at['mean'] }}</td>
                                        <td class="text-center fw-semibold text-primary">{{ $at['persentase'] }}%</td>
                                        <td class="px-4">
                                            <span
                                                class="badge 
                                                    @if ($at['interpretasi'] == 'Sangat Baik') bg-primary bg-opacity-10 text-primary
                                                    @elseif($at['interpretasi'] == 'Baik') bg-success bg-opacity-10 text-success
                                                    @elseif($at['interpretasi'] == 'Cukup') bg-warning bg-opacity-10 text-warning
                                                    @elseif($at['interpretasi'] == 'Buruk' || $at['interpretasi'] == 'Sangat Buruk') bg-danger bg-opacity-10 text-danger
                                                    @else bg-secondary bg-opacity-10 text-secondary @endif px-2.5 py-1.5 fw-bold"
                                                style="border-radius:4px;">
                                                {{ $at['interpretasi'] }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4 text-muted">Belum ada sampel data masuk.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-12 col-lg-6">
            <div class="card border-0 shadow-sm" style="border-radius: 6px;">
                <div class="card-header bg-white border-bottom border-light py-3 px-4">
                    <h6 class="text-dark fw-bold mb-0"><i class="bi bi-check-circle text-primary me-2"></i>Uji Validitas
                    </h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive" style="max-height: 320px; overflow-y: auto;">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light small fw-bold text-secondary sticky-top">
                                <tr>
                                    <th class="px-4 py-2.5">Metode</th>
                                    <th class="py-2.5">Kode</th>
                                    <th class="py-2.5">r Hitung</th>
                                    <th class="py-2.5 text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody class="text-dark" style="font-size: 0.85rem;">
                                @foreach ($validitas as $v)
                                    <tr class="border-bottom border-light">
                                        <td class="px-4 text-muted small fw-medium">{{ $v['metode'] }}</td>
                                        <td class="fw-bold text-dark">{{ $v['kode'] }}</td>
                                        <td class="text-primary fw-semibold">{{ number_format($v['r_hitung'], 6) }}</td>
                                        <td class="text-center">
                                            <span
                                                class="badge {{ $v['status'] == 'Valid' ? 'bg-success' : 'bg-danger' }} px-2 py-1 text-white fw-bold small"
                                                style="border-radius: 4px;">
                                                {{ $v['status'] }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6">
            <div class="card border-0 shadow-sm" style="border-radius: 6px;">
                <div class="card-header bg-white border-bottom border-light py-3 px-4">
                    <h6 class="text-dark fw-bold mb-0"><i class="bi bi-shield-check text-warning me-2"></i>Uji Reliabilitas
                    </h6>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle mb-0 text-center" style="border-color: #f1f5f9;">
                            <thead class="table-light small fw-bold text-secondary">
                                <tr>
                                    <th class="py-2.5">Metode</th>
                                    <th class="py-2.5">Alpha</th>
                                    <th class="py-2.5">Interpretasi</th>
                                    <th class="py-2.5">Status</th>
                                </tr>
                            </thead>
                            <tbody style="font-size: 0.88rem;">
                                <tr class="border-bottom border-light">
                                    <td class="fw-bold text-secondary text-start px-3">PIECES</td>
                                    <td class="fw-semibold text-dark">{{ number_format($reliabilitasPieces, 6) }}</td>
                                    <td class="text-muted small">
                                        {{ $reliabilitasPieces >= 0.6 ? 'Reliabel' : 'Tidak Reliabel' }}</td>
                                    <td>
                                        <span
                                            class="badge {{ $reliabilitasPieces >= 0.6 ? 'bg-success' : 'bg-danger' }} px-2 py-1">
                                            {{ $reliabilitasPieces >= 0.6 ? 'Reliabel' : 'Tidak Reliabel' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold text-secondary text-start px-3">TAM</td>
                                    <td class="fw-semibold text-dark">{{ number_format($reliabilitasTam, 6) }}</td>
                                    <td class="text-muted small">
                                        {{ $reliabilitasTam >= 0.6 ? 'Reliabel' : 'Tidak Reliabel' }}</td>
                                    <td>
                                        <span
                                            class="badge {{ $reliabilitasTam >= 0.6 ? 'bg-success' : 'bg-danger' }} px-2 py-1">
                                            {{ $reliabilitasTam >= 0.6 ? 'Reliabel' : 'Tidak Reliabel' }}
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4 p-3 bg-light rounded" style="border-left: 4px solid #0d6efd;">
                        <small class="text-secondary d-block lh-base">
                            <strong>Keterangan Validasi Lampiran Skripsi:</strong><br>
                            * Batas kritis reliabilitas instrumen mengacu pada standar rule-of-thumb koefisien Alpha
                            Cronbach &ge; 0.60.<br>
                            * Nilai r-tabel dihitung secara otomatis berdasarkan derajat kebebasan (df = N-2).
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
