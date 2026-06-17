@extends('layouts.admin.app')

@section('title', 'Daftar Pertanyaan Kuesioner')
@section('page-heading', 'Daftar Pertanyaan Kuesioner')
@section('page-subheading', 'Kelola butir instrumen kuesioner evaluasi metode PIECES dan TAM')

@section('content')
    <div class="mb-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-primary px-2.5 py-1.5 fw-semibold small">Instrumen Evaluasi</span>
            <small class="text-secondary fw-medium">Total: <strong>{{ $pertanyaan->count() }}</strong> butir pertanyaan
                terdaftar</small>
        </div>
        <button type="button" class="btn btn-primary d-flex align-items-center gap-2 shadow-sm py-2 px-3"
            data-bs-toggle="modal" data-bs-target="#modalTambahPertanyaan" style="border-radius: 4px;">
            <i class="bi bi-plus-circle"></i>
            <span class="fw-semibold small">Tambah Pertanyaan</span>
        </button>
    </div>

    <div class="card border-0 shadow-sm mb-5" style="border-radius: 6px;">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table id="tablePertanyaanMaster" class="table table-striped table-hover align-middle mb-0"
                    style="width: 100%; min-width: 1000px;">
                    <thead class="table-light text-secondary small fw-bold text-uppercase" style="letter-spacing: 0.5px;">
                        <tr>
                            <th class="py-3 px-3 text-center" style="width: 70px;">No.</th>
                            <th class="py-3" style="width: 100px;">Kode</th>
                            <th class="py-3" style="width: 120px;">Metode</th>
                            <th class="py-3" style="width: 240px;">Kategori / Dimensi</th>
                            <th class="py-3">Isi Pertanyaan</th>
                            <th class="py-3 text-center" style="width: 130px;">Status</th>
                            <th class="py-3 text-center" style="width: 140px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-dark" style="font-size: 0.88rem;">
                        @forelse($pertanyaan as $index => $item)
                            <tr class="border-bottom border-light">
                                <td class="py-3 px-3 text-center text-muted fw-medium">{{ $index + 1 }}</td>
                                <td class="py-3"><span class="fw-bold text-primary">{{ $item->kode_pertanyaan }}</span>
                                </td>
                                <td class="py-3">
                                    <span
                                        class="badge {{ $item->metode == 'PIECES' ? 'bg-info bg-opacity-10 text-info' : 'bg-success bg-opacity-10 text-success' }} border-0 px-2.5 py-1.5 fw-bold"
                                        style="font-size: 0.75rem;">
                                        {{ $item->metode }}
                                    </span>
                                </td>
                                <td class="py-3 text-secondary fw-semibold">{{ $item->kategori ?? '-' }}</td>
                                <td class="py-3 text-wrap lh-base" style="max-width: 450px;">{{ $item->isi_pertanyaan }}
                                </td>
                                <td class="py-3 text-center">
                                    @if ($item->status)
                                        <span class="badge bg-success bg-opacity-10 text-success px-2.5 py-1.5 fw-semibold"
                                            style="font-size: 0.75rem; border-radius: 4px;">
                                            <span class="status-dot bg-success d-inline-block me-1.5"
                                                style="width: 6px; height: 6px; border-radius: 50%;"></span> Aktif
                                        </span>
                                    @else
                                        <span class="badge bg-danger bg-opacity-10 text-danger px-2.5 py-1.5 fw-semibold"
                                            style="font-size: 0.75rem; border-radius: 4px;">
                                            <span class="status-dot bg-danger d-inline-block me-1.5"
                                                style="width: 6px; height: 6px; border-radius: 50%;"></span> Non-Aktif
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3 text-center">
                                    <div class="d-flex justify-content-center gap-1.5">
                                        <button
                                            class="btn btn-sm btn-light border border-light-subtle text-warning p-2 d-flex align-items-center justify-content-center"
                                            data-bs-toggle="modal" data-bs-target="#modalEditPertanyaan{{ $item->id }}"
                                            style="border-radius: 4px; width: 32px; height: 32px;" title="Ubah Pertanyaan">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <form action="{{ route('pertanyaan.destroy', $item->id) }}" method="POST"
                                            class="form-hapus-kuesioner m-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                class="btn btn-sm btn-light border border-light-subtle text-danger p-2 d-flex align-items-center justify-content-center btn-delete-swal"
                                                style="border-radius: 4px; width: 32px; height: 32px;" title="Hapus">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            <div class="modal fade" id="modalEditPertanyaan{{ $item->id }}" tabindex="-1"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 shadow" style="border-radius: 6px;">
                                        <div class="modal-header border-bottom border-light py-3 px-4">
                                            <h5 class="modal-title fw-bold text-dark" style="font-size: 1.1rem;"><i
                                                    class="bi bi-pencil-square text-warning me-2"></i>Ubah Data Pertanyaan
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('pertanyaan.update', $item->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body p-4">
                                                <div class="mb-3">
                                                    <label class="form-label small fw-semibold text-secondary">Kode
                                                        Pertanyaan</label>
                                                    <input type="text" name="kode_pertanyaan"
                                                        class="form-control custom-form-input"
                                                        value="{{ $item->kode_pertanyaan }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label small fw-semibold text-secondary">Metode
                                                        Evaluasi</label>
                                                    <select name="metode" class="form-select custom-form-input" required>
                                                        <option value="PIECES"
                                                            {{ $item->metode == 'PIECES' ? 'selected' : '' }}>PIECES
                                                        </option>
                                                        <option value="TAM"
                                                            {{ $item->metode == 'TAM' ? 'selected' : '' }}>TAM</option>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label small fw-semibold text-secondary">Kategori /
                                                        Dimensi</label>
                                                    <input type="text" name="kategori"
                                                        class="form-control custom-form-input"
                                                        value="{{ $item->kategori }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label small fw-semibold text-secondary">Isi
                                                        Pertanyaan</label>
                                                    <textarea name="isi_pertanyaan" class="form-control custom-form-input" rows="4" required>{{ $item->isi_pertanyaan }}</textarea>
                                                </div>
                                                <div class="form-check form-switch mt-3.5">
                                                    <input class="form-check-input" type="checkbox" name="status"
                                                        id="statusEdit{{ $item->id }}" value="1"
                                                        {{ $item->status ? 'checked' : '' }}>
                                                    <label class="form-check-label small fw-semibold text-dark ms-1"
                                                        for="statusEdit{{ $item->id }}">Aktifkan pertanyaan
                                                        ini</label>
                                                </div>
                                            </div>
                                            <div
                                                class="modal-header border-0 bg-light bg-opacity-40 py-3 px-4 d-flex justify-content-end gap-2">
                                                <button type="button"
                                                    class="btn btn-white bg-white border border-light-subtle btn-sm px-3 py-2 fw-medium"
                                                    data-bs-dismiss="modal" style="border-radius: 4px;">Batal</button>
                                                <button type="submit"
                                                    class="btn btn-primary btn-sm px-3 py-2 fw-semibold"
                                                    style="border-radius: 4px;">Simpan Perubahan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <div class="avatar avatar-lg bg-light text-muted mb-3 mx-auto"
                                        style="width: 55px; height: 55px; display: flex; align-items: center; justify-content: center; border-radius: 50%;">
                                        <i class="bi bi-folder-x fs-3"></i>
                                    </div>
                                    <h6 class="text-dark fw-bold mb-1">Data Kosong</h6>
                                    <p class="text-muted small mb-0">Belum ada data pertanyaan kuesioner terdaftar di
                                        sistem.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalTambahPertanyaan" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow" style="border-radius: 6px;">
                <div class="modal-header border-bottom border-light py-3 px-4">
                    <h5 class="modal-title fw-bold text-dark" style="font-size: 1.1rem;"><i
                            class="bi bi-plus-circle text-primary me-2"></i>Tambah Pertanyaan Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('pertanyaan.store') }}" method="POST">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-secondary">Kode Pertanyaan</label>
                            <input type="text" name="kode_pertanyaan" class="form-control custom-form-input"
                                placeholder="Contoh: P1" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-secondary">Metode Evaluasi</label>
                            <select name="metode" class="form-select custom-form-input" required>
                                <option value="" disabled selected>-- Pilih Metode Evaluasi --</option>
                                <option value="PIECES">PIECES</option>
                                <option value="TAM">TAM</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-secondary">Kategori / Dimensi Indikator</label>
                            <input type="text" name="kategori" class="form-control custom-form-input"
                                placeholder="Contoh: Performance / Perceived Usefulness" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-secondary">Isi Butir Pertanyaan</label>
                            <textarea name="isi_pertanyaan" class="form-control custom-form-input" rows="4"
                                placeholder="Tulis teks kuesioner disini..." required></textarea>
                        </div>
                        <div class="form-check form-switch mt-3.5">
                            <input class="form-check-input" type="checkbox" name="status" id="statusTambah"
                                value="1" checked>
                            <label class="form-check-label small fw-semibold text-dark ms-1" for="statusTambah">Aktifkan
                                pertanyaan ini</label>
                        </div>
                    </div>
                    <div class="modal-header border-0 bg-light bg-opacity-40 py-3 px-4 d-flex justify-content-end gap-2">
                        <button type="button"
                            class="btn btn-white bg-white border border-light-subtle btn-sm px-3 py-2 fw-medium"
                            data-bs-dismiss="modal" style="border-radius: 4px;">Batal</button>
                        <button type="submit" class="btn btn-primary btn-sm px-3 py-2 fw-semibold"
                            style="border-radius: 4px;">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .custom-form-input {
            border-color: #e2e8f0;
            border-radius: 4px;
            font-size: 0.88rem;
            padding: 0.55rem 0.75rem;
        }

        .custom-form-input:focus {
            border-color: var(--bs-primary, #0d6efd);
            box-shadow: none;
        }

        /* Override Style DataTables Bootstrap agar klop dengan Template adminHMD */
        .dataTables_wrapper .dataTables_paginate .page-link {
            padding: 0.4rem 0.75rem;
            font-size: 0.85rem;
            color: #475569;
            border-color: #e2e8f0;
        }

        .dataTables_wrapper .page-item.active .page-link {
            background-color: #0d6efd !important;
            border-color: #0d6efd !important;
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
            border-color: #0d6efd;
            box-shadow: none;
            outline: none;
        }
    </style>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Inisialisasi DataTables berbasis integrasi CSS/JS Bootstrap 5 murni
            $('#tablePertanyaanMaster').DataTable({
                "order": [], // Menghormati susunan default dari backend Laravel
                "pageLength": 10,
                "lengthMenu": [5, 10, 25, 50],
                // Menggunakan elemen baris pembungkus grid Bootstrap murni
                "dom": "<'row mb-3 align-items-center'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row mt-3 align-items-center'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                "language": {
                    "search": "Cari Instrumen:",
                    "lengthMenu": "Tampilkan _MENU_ entri",
                    "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ pertanyaan",
                    "infoEmpty": "Menampilkan 0 data",
                    "infoFiltered": "(disaring dari _MAX_ total data)",
                    "zeroRecords": "Tidak ditemukan data yang cocok",
                    "paginate": {
                        "next": "<i class='bi bi-chevron-right small'></i>",
                        "previous": "<i class='bi bi-chevron-left small'></i>"
                    }
                }
            });
        });

        // Event Handler SweetAlert untuk Tombol Hapus
        $(document).on('click', '.btn-delete-swal', function(e) {
            e.preventDefault();
            let form = $(this).closest('form');

            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Data ini akan dihapus permanen dari basis data!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#0d6efd',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    </script>
@endpush
