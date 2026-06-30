@extends('layouts.admin.app')

@section('title', 'Data Responden')
@section('page-heading', 'Data Responden')
@section('page-subheading', 'Kelola data demografi pengguna dan responden sistem EMR')

@section('content')
    <div class="mb-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-primary px-2.5 py-1.5 fw-semibold small">Subjek Riset</span>
            <small class="text-secondary fw-medium">Total: <strong>{{ $responden->count() }}</strong> responden
                berpartisipasi</small>
        </div>
        <button type="button" class="btn btn-primary d-flex align-items-center gap-2 shadow-sm py-2 px-3"
            data-bs-toggle="modal" data-bs-target="#modalTambahResponden" style="border-radius: 4px;">
            <i class="bi bi-plus-circle"></i>
            <span class="fw-semibold small">Tambah Responden</span>
        </button>
    </div>

    <div class="card border-0 shadow-sm mb-5" style="border-radius: 6px;">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table id="tableRespondenMaster" class="table table-striped table-hover align-middle mb-0"
                    style="width: 100%; min-width: 1000px;">
                    <thead class="table-light text-secondary small fw-bold text-uppercase" style="letter-spacing: 0.5px;">
                        <tr>
                            <th class="py-3 px-3 text-center" style="width: 70px;">No.</th>
                            <th class="py-3">Nama Responden</th>
                            <th class="py-3" style="width: 160px;">Jenis Kelamin</th>
                            <th class="py-3" style="width: 180px;">Profesi</th>
                            <th class="py-3" style="width: 180px;">Unit Kerja</th>
                            <th class="py-3" style="width: 250px;">Alamat Email</th>
                            <th class="py-3 text-center" style="width: 120px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-dark" style="font-size: 0.88rem;">
                        @foreach ($responden as $index => $item)
                            <tr class="border-bottom border-light">
                                <td class="py-3 px-3 text-center text-muted fw-medium">{{ $index + 1 }}</td>
                                <td class="py-3"><span class="fw-bold text-dark">{{ $item->nama }}</span></td>
                                <td class="py-3">
                                    @if ($item->jenis_kelamin == 'Laki-laki')
                                        <span
                                            class="badge bg-primary bg-opacity-10 text-primary border-0 px-2.5 py-1.5 fw-bold"
                                            style="font-size: 0.75rem;">
                                            <i class="bi bi-gender-male me-1"></i> Laki-laki
                                        </span>
                                    @else
                                        <span
                                            class="badge bg-danger bg-opacity-10 text-danger border-0 px-2.5 py-1.5 fw-bold"
                                            style="font-size: 0.75rem;">
                                            <i class="bi bi-gender-female me-1"></i> Perempuan
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3 text-secondary fw-medium">{{ $item->profesi }}</td>
                                <td class="py-3 text-secondary">{{ $item->unit_kerja }}</td>
                                <td class="py-3 text-muted">{{ $item->user->email ?? '-' }}</td>
                                <td class="py-3 text-center">
                                    <div class="d-flex justify-content-center">
                                        <form action="{{ route('responden.destroy', $item->id) }}" method="POST"
                                            class="form-hapus-responden m-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                class="btn btn-sm btn-light border border-light-subtle text-danger p-2 d-flex align-items-center justify-content-center btn-delete-swal"
                                                style="border-radius: 4px; width: 32px; height: 32px;"
                                                title="Hapus Responden">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalTambahResponden" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow" style="border-radius: 6px;">
                <div class="modal-header border-bottom border-light py-3 px-4">
                    <h5 class="modal-title fw-bold text-dark" style="font-size: 1.1rem;">
                        <i class="bi bi-person-plus text-primary me-2"></i>Tambah Responden Baru
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('responden.store') }}" method="POST">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-secondary">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control custom-form-input"
                                placeholder="Masukkan nama lengkap beserta gelar" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-secondary">Profesi / Jabatan</label>
                            <input type="text" name="profesi" class="form-control custom-form-input"
                                placeholder="Contoh: Dokter Spesialis, Perawat, Perekam Medis" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-secondary">Unit Kerja</label>
                            <input type="text" name="unit_kerja" class="form-control custom-form-input"
                                placeholder="Contoh: Poli Rawat Jalan, Rekam Medis, IGD" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-secondary">Alamat Email</label>
                            <input type="email" name="email" class="form-control custom-form-input"
                                placeholder="username@rsummetro.com" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-secondary">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-select custom-form-input" required>
                                <option value="" disabled selected>-- Pilih Jenis Kelamin --</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
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

        /* Sinkronisasi DataTables Bootstrap agar tidak merusak Card Layout */
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
            $('#tableRespondenMaster').DataTable({
                "order": [], // Menghormati susunan default dari backend Laravel
                "pageLength": 10,
                "lengthMenu": [5, 10, 25, 50],
                // Menggunakan susunan baris pembungkus grid Bootstrap murni
                "dom": "<'row mb-3 align-items-center'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row mt-3 align-items-center'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                "language": {
                    "search": "Cari Responden:",
                    "lengthMenu": "Tampilkan _MENU_ data",
                    "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ responden",
                    "infoEmpty": "Menampilkan 0 data",
                    "infoFiltered": "(disaring dari _MAX_ total data)",
                    "zeroRecords": "Tidak ditemukan data responden yang cocok",
                    "paginate": {
                        "next": "<i class='bi bi-chevron-right small'></i>",
                        "previous": "<i class='bi bi-chevron-left small'></i>"
                    }
                }
            });
        });

        // Event Handler SweetAlert untuk Tombol Hapus Responden
        $(document).on('click', '.btn-delete-swal', function(e) {
            e.preventDefault();
            let form = $(this).closest('form');

            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Data responden dan akun user terkait akan dihapus permanen dari sistem!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#0d6efd', // Menyesuaikan ke warna utama Primary Blue adminHMD
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
