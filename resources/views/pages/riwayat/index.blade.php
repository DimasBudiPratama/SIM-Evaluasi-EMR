@extends('layouts.admin.app')

@section('title', 'Riwayat Pengisian')
@section('page-heading', 'Riwayat Pengisian')
@section('page-subheading', 'Evaluasi Implementasi EMR berbasis PIECES dan TAM')

@push('style')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css">
    <style>
        /* Override Override Sinkronisasi DataTables Bootstrap agar klop dengan Template adminHMD */
        .dataTables_wrapper .dataTables_paginate .page-link {
            padding: 0.4rem 0.75rem;
            font-size: 0.85rem;
            color: #475569;
            border-color: #e2e8f0;
        }

        .dataTables_wrapper .page-item.active .page-link {
            background-color: var(--bs-primary, #0d6efd) !important;
            border-color: var(--bs-primary, #0d6efd) !important;
            color: #fff !important;
        }

        .dataTables_wrapper .dataTables_filter input,
        .dataTables_wrapper .dataTables_length select {
            border: 1px solid #e2e8f0;
            font-size: 0.85rem;
            border-radius: 4px;
        }

        .dataTables_wrapper .dataTables_filter input:focus,
        .dataTables_wrapper .dataTables_length select:focus {
            border-color: var(--bs-primary, #0d6efd);
            box-shadow: none;
            outline: none;
        }

        /* Custom Tab adminHMD Link Style */
        .nav-pills .nav-link {
            color: #64748b;
            font-weight: 600;
            transition: all 0.2s ease;
            border-radius: 4px;
        }

        .nav-pills .nav-link.active {
            background-color: var(--bs-primary, #0d6efd) !important;
            box-shadow: 0 4px 10px rgba(13, 110, 253, 0.15);
            color: #fff !important;
        }
    </style>
@endpush

@section('content')
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 6px;">
        <div class="card-body p-2 bg-light bg-opacity-50" style="border-radius: 6px;">
            <ul class="nav nav-pills border-0 small" id="riwayatTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active px-4 py-2.5" id="pieces-tab" data-bs-toggle="tab"
                        data-bs-target="#pieces-panel" type="button" role="tab" aria-controls="pieces-panel"
                        aria-selected="true">
                        <i class="bi bi-list-check me-2"></i>PIECES
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link px-4 py-2.5" id="tam-tab" data-bs-toggle="tab" data-bs-target="#tam-panel"
                        type="button" role="tab" aria-controls="tam-panel" aria-selected="false">
                        <i class="bi bi-shield-check me-2"></i>TAM
                    </button>
                </li>
            </ul>
        </div>
    </div>

    <div class="tab-content" id="riwayatTabContent">

        <div class="tab-pane fade show active" id="pieces-panel" role="tabpanel" aria-labelledby="pieces-tab">
            <div class="card border-0 shadow-sm p-4" style="border-radius: 6px;">
                <div class="table-responsive">
                    <table id="tableRiwayatPieces" class="table table-striped table-hover align-middle mb-0"
                        style="width:100%">
                        <thead class="table-light text-secondary small fw-bold text-uppercase"
                            style="letter-spacing: 0.5px;">
                            <tr>
                                <th class="py-3 px-3" style="width: 10%">Kode</th>
                                <th class="py-3" style="width: 25%">Kategori</th>
                                <th class="py-3 text-center" style="width: 12%">Skor Likert</th>
                                <th class="py-3 px-3" style="width: 18%">Nama Responden</th>
                                <th class="py-3" style="width: 20%">Tanggal Submit</th>
                            </tr>
                        </thead>
                        <tbody class="text-dark" style="font-size: 0.88rem;">
                            @foreach ($riwayatPieces as $row)
                                <tr class="border-bottom border-light">
                                    <td class="py-3 px-3"><span
                                            class="fw-bold text-primary">{{ $row->pertanyaan->kode_pertanyaan ?? '-' }}</span>
                                    </td>
                                    <td class="py-3 text-secondary fw-semibold">{{ $row->pertanyaan->kategori ?? '-' }}</td>
                                    <td class="py-3 text-center">
                                        @php
                                            $badgeClass = match ($row->skor_likert) {
                                                1 => 'bg-danger',
                                                2 => 'bg-warning text-dark',
                                                3 => 'bg-info text-dark',
                                                4 => 'bg-primary',
                                                5 => 'bg-success',
                                                default => 'bg-secondary',
                                            };
                                        @endphp

                                        <span class="badge {{ $badgeClass }} px-3 py-2 fw-bold">
                                            {{ $row->skor_likert }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-3 fw-semibold text-dark">{{ $row->user->name ?? '-' }}</td>
                                    <td class="py-3 text-muted small"><i
                                            class="bi bi-calendar3 me-1.5"></i>{{ $row->created_at->format('d/m/Y H:i') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="tam-panel" role="tabpanel" aria-labelledby="tam-tab">
            <div class="card border-0 shadow-sm p-4" style="border-radius: 6px;">
                <div class="table-responsive">
                    <table id="tableRiwayatTam" class="table table-striped table-hover align-middle mb-0"
                        style="width:100%">
                        <thead class="table-light text-secondary small fw-bold text-uppercase"
                            style="letter-spacing: 0.5px;">
                            <tr>
                                <th class="py-3 px-3" style="width: 10%">Kode</th>
                                <th class="py-3" style="width: 25%">Kategori</th>
                                <th class="py-3 text-center" style="width: 12%">Skor Likert</th>
                                <th class="py-3 px-3" style="width: 18%">Nama Pengisi</th>
                                <th class="py-3" style="width: 20%">Tanggal Submit</th>
                            </tr>
                        </thead>
                        <tbody class="text-dark" style="font-size: 0.88rem;">
                            @foreach ($riwayatTam as $row)
                                <tr class="border-bottom border-light">
                                    <td class="py-3 px-3"><span
                                            class="fw-bold text-primary">{{ $row->pertanyaan->kode_pertanyaan ?? '-' }}</span>
                                    </td>
                                    <td class="py-3 text-secondary fw-semibold">{{ $row->pertanyaan->kategori ?? '-' }}
                                    </td>
                                    <td class="py-3 text-center">
                                        @php
                                            $badgeClass = match ($row->skor_likert) {
                                                1 => 'bg-danger',
                                                2 => 'bg-warning text-dark',
                                                3 => 'bg-info text-dark',
                                                4 => 'bg-primary',
                                                5 => 'bg-success',
                                                default => 'bg-secondary',
                                            };
                                        @endphp

                                        <span class="badge {{ $badgeClass }} px-3 py-2 fw-bold">
                                            {{ $row->skor_likert }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-3 fw-semibold text-dark">{{ $row->user->name ?? '-' }}</td>
                                    <td class="py-3 text-muted small"><i
                                            class="bi bi-calendar3 me-1.5"></i>{{ $row->created_at->format('d/m/Y H:i') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.js"></script>

    <script>
        $(document).ready(function() {
            // Konfigurasi parameter default DataTables Bootstrap 5
            const dtConfig = {
                "order": [],
                "pageLength": 10,
                "lengthMenu": [5, 10, 25, 50],
                "deferRender": true,
                "dom": "<'row mb-3 align-items-center'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row mt-3 align-items-center'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                "language": {
                    "search": "Cari data:",
                    "lengthMenu": "Tampilkan _MENU_ entri",
                    "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    "infoEmpty": "Menampilkan 0 data",
                    "infoFiltered": "(disaring dari _MAX_ total data)",
                    "zeroRecords": "Tidak ditemukan riwayat pengisian yang cocok",
                    "paginate": {
                        "next": "<i class='bi bi-chevron-right small'></i>",
                        "previous": "<i class='bi bi-chevron-left small'></i>"
                    }
                }
            };

            // Inisialisasi masing-masing tabel secara terpisah menggunakan ID unik
            const tablePieces = $('#tableRiwayatPieces').DataTable(dtConfig);
            const tableTam = $('#tableRiwayatTam').DataTable(dtConfig);

            // Perbaikan Bug Auto-Width: Hitung ulang kolom tabel saat Tab Bootstrap diklik
            $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
                const targetId = $(e.target).data('bs-target');
                if (targetId === '#pieces-panel') {
                    tablePieces.columns.adjust().draw();
                } else if (targetId === '#tam-panel') {
                    tableTam.columns.adjust().draw();
                }
            });
        });
    </script>
@endpush
