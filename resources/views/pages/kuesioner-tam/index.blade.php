@extends('layouts.admin.app')

@section('title', 'Kuesioner TAM')
@section('page-heading', 'Kuesioner TAM')
@section('page-subheading', 'Evaluasi Implementasi EMR berbasis PIECES dan TAM')

@section('content')
    <div class="container-fluid px-0">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="header-back-info">
            </div>
            <div>
                <span class="badge bg-primary px-3 py-2 fw-semibold shadow-sm" id="timer-display"
                    style="font-size: 0.9rem; border-radius: 4px; letter-spacing: 0.5px;">
                    <i class="bi bi-stopwatch me-1"></i> 00:00
                </span>
            </div>
        </div>

        @if ($sudahMengisi)
            <div class="alert alert-info border-0 shadow-sm mb-4 d-flex align-items-center" style="border-radius: 6px;">
                <i class="bi bi-info-circle-fill me-3 fs-5 text-info"></i>
                <div>
                    <strong class="d-block mb-05">Mode Lihat Jawaban</strong>
                    <span class="text-secondary small">Anda telah menyelesaikan kuesioner ini. Di bawah ini adalah riwayat
                        jawaban Anda yang tersimpan di sistem.</span>
                </div>
            </div>
        @endif

        <form action="{{ route('kuesioner-tam.store') }}" method="POST">
            @csrf

            <input type="hidden" name="durasi_detik" id="durasi_detik" value="{{ $durasiTersimpan }}">

            @forelse($pertanyaanGrouped as $kategori => $daftarPertanyaan)
                <div class="d-flex align-items-center mt-5 mb-3">
                    <div class="bg-primary text-white px-3 py-1 rounded-1 fw-bold me-2 small shadow-sm"
                        style="font-size: 0.75rem; letter-spacing: 1px;">KATEGORI</div>
                    <h5 class="text-dark fw-bold mb-0 text-uppercase" style="letter-spacing: 0.5px; font-size: 1.05rem;">
                        {{ $kategori }}</h5>
                </div>

                @foreach ($daftarPertanyaan as $item)
                    <div class="card border-0 shadow-sm mb-4" style="border-radius: 6px;">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-start mb-3">
                                <span
                                    class="badge bg-light text-primary fw-bold me-2 px-2.5 py-1.5 border border-primary-subtle"
                                    style="font-size: 0.85rem;">
                                    {{ $item->kode_pertanyaan }}
                                </span>
                                <p class="fw-semibold text-dark mb-0 pt-0.5" style="font-size: 1rem; line-height: 1.5;">
                                    {{ $item->isi_pertanyaan }}
                                </p>
                            </div>

                            <div class="row g-2 pt-2">
                                @php
                                    $options = [
                                        1 => 'Sangat Tidak Setuju',
                                        2 => 'Tidak Setuju',
                                        3 => 'Netral',
                                        4 => 'Setuju',
                                        5 => 'Sangat Setuju',
                                    ];

                                    $skorTerpilih =
                                        $sudahMengisi && isset($jawabanUser[$item->id])
                                            ? $jawabanUser[$item->id]->skor_likert
                                            : null;
                                @endphp

                                @foreach ($options as $value => $label)
                                    <div class="col-md col-12">
                                        <input type="radio" class="btn-check" name="jawaban[{{ $item->id }}]"
                                            id="pilihan_{{ $item->id }}_{{ $value }}" value="{{ $value }}"
                                            {{ $sudahMengisi ? 'disabled' : '' }}
                                            {{ $skorTerpilih == $value ? 'checked' : '' }} required>

                                        <label
                                            class="btn btn-outline-primary w-100 py-3 px-2 d-flex flex-column align-items-center justify-content-center h-100 shadow-xs custom-likert-card {{ $sudahMengisi ? 'pe-none opacity-100' : '' }}"
                                            for="pilihan_{{ $item->id }}_{{ $value }}"
                                            style="border-color: #e2e8f0; border-radius: 6px; transition: all 0.15s ease-in-out;">

                                            <span class="fw-bold fs-5 mb-1 id-angka text-dark">{{ $value }}</span>
                                            <span class="small id-teks text-muted text-center fw-normal"
                                                style="font-size: 0.75rem; line-height: 1.3;">{{ $label }}</span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            @empty
                <div class="card border-0 shadow-sm" style="border-radius: 6px;">
                    <div class="card-body text-center py-5 text-muted">
                        <div class="avatar avatar-lg bg-light-danger text-danger mb-3 mx-auto"
                            style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; border-radius: 50%;">
                            <i class="bi bi-folder-x fs-2"></i>
                        </div>
                        <h6 class="text-dark fw-bold mb-1">Data Pertanyaan Kosong</h6>
                        <p class="text-muted small mb-0">Belum ada butir pertanyaan untuk instrumen kuesioner TAM saat ini.
                        </p>
                    </div>
                </div>
            @endforelse

            @if ($pertanyaanGrouped->isNotEmpty() && !$sudahMengisi)
                <div class="d-flex justify-content-end mt-4 mb-5">
                    <button type="submit" class="btn btn-primary px-5 py-2.5 fw-semibold shadow-sm"
                        style="border-radius: 4px;">
                        <i class="bi bi-send-fill me-2"></i> Kirim Jawaban Kuesioner
                    </button>
                </div>
            @endif
        </form>
    </div>

    <style>
        .btn-check:checked+.custom-likert-card {
            background-color: var(--bs-primary, #0d6efd) !important;
            border-color: var(--bs-primary, #0d6efd) !important;
            box-shadow: 0 4px 12px rgba(13, 110, 253, 0.15) !important;
        }

        .btn-check:checked+.custom-likert-card .id-angka,
        .btn-check:checked+.custom-likert-card .id-teks {
            color: #ffffff !important;
        }

        /* Hover Effect for Interactive Forms */
        .custom-likert-card:not(.pe-none):hover {
            background-color: #fcfdfe;
            border-color: var(--bs-primary, #0d6efd) !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        /* Disabled Checked Styling Style Correction */
        .btn-check:disabled:checked+.custom-likert-card {
            background-color: #6c757d !important;
            border-color: #6c757d !important;
            opacity: 0.85;
        }

        .btn-check:disabled:checked+.custom-likert-card .id-angka,
        .btn-check:disabled:checked+.custom-likert-card .id-teks {
            color: #ffffff !important;
        }
    </style>
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const sudahMengisi = @json($sudahMengisi);
            const timerDisplay = document.getElementById('timer-display');

            if (sudahMengisi) {
                let totalSeconds = parseInt(document.getElementById('durasi_detik').value) || 0;
                formatDanTampilkanWaktu(totalSeconds);
            } else {
                let totalSeconds = 0;
                const durasiInput = document.getElementById('durasi_detik');

                setInterval(() => {
                    totalSeconds++;
                    durasiInput.value = totalSeconds;
                    formatDanTampilkanWaktu(totalSeconds);
                }, 1000);
            }

            function formatDanTampilkanWaktu(secondsCount) {
                let minutes = Math.floor(secondsCount / 60);
                let seconds = secondsCount % 60;

                minutes = minutes < 10 ? '0' + minutes : minutes;
                seconds = seconds < 10 ? '0' + seconds : seconds;

                timerDisplay.innerHTML = `<i class="bi bi-stopwatch me-1"></i> ${minutes}:${seconds}`;
            }
        });
    </script>
@endpush
