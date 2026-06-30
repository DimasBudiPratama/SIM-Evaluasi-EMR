@extends('layouts.admin.app')

@section('title', 'Pengaturan User')
@section('page-heading', 'Pengaturan User')
@section('page-subheading', 'Pengaturan User')

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
            <ul class="nav nav-pills border-0 small" id="settingsTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active px-4 py-2.5" id="user-tab" data-bs-toggle="tab"
                        data-bs-target="#user-panel" type="button" role="tab" aria-controls="user-panel"
                        aria-selected="true">
                        <i class="bi bi-person-lines-fill me-2"></i>USER LIST
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link px-4 py-2.5" id="role-tab" data-bs-toggle="tab" data-bs-target="#role-panel"
                        type="button" role="tab" aria-controls="role-panel" aria-selected="false">
                        <i class="bi bi-shield-check me-2"></i>ROLE LIST
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link px-4 py-2.5" id="permission-tab" data-bs-toggle="tab"
                        data-bs-target="#permission-panel" type="button" role="tab" aria-controls="permission-panel"
                        aria-selected="false">
                        <i class="bi bi-key-fill me-2"></i>PERMISSION LIST
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link px-4 py-2.5" id="assign-tab" data-bs-toggle="tab" data-bs-target="#assign-panel"
                        type="button" role="tab" aria-controls="assign-panel" aria-selected="false">
                        <i class="bi bi-person-check-fill me-2"></i>ASSIGN PERMISSION
                    </button>
                </li>
            </ul>
        </div>
    </div>

    <div class="tab-content" id="settingsTabContent">
        <div class="tab-pane fade show active" id="user-panel" role="tabpanel" aria-labelledby="user-tab">
            <div class="card border-0 shadow-sm p-4">
                <div class="table-responsive">
                    <table id="tableRiwayatPieces" class="table table-striped table-hover align-middle mb-0"
                        style="width:100%">
                        <thead class="table-light text-secondary small fw-bold text-uppercase"
                            style="letter-spacing: 0.5px;">
                            <tr>
                                <th class="py-3 px-3" style="width: 10%">#</th>
                                <th class="py-3" style="width: 25%">Name</th>
                                <th class="py-3 text-center" style="width: 12%">Email</th>
                                <th class="py-3 px-3" style="width: 18%">Role</th>
                                <th class="py-3" style="width: 20%">Dibuat</th>
                                <th class="py-3" style="width: 20%">Action</th>
                            </tr>
                        </thead>
                        <tbody class="text-dark" style="font-size: 0.88rem;">
                            @foreach ($users as $row)
                                <tr class="border-bottom border-light">
                                    <td class="py-3 px-3">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="py-3 px-3"><span class="fw-bold text-primary">{{ $row->name ?? '-' }}</span>
                                    </td>
                                    <td class="py-3 text-secondary fw-semibold">{{ $row->email ?? '-' }}</td>
                                    <td class="py-3 text-center">
                                        @forelse($row->roles as $role)
                                            <span class="badge bg-primary px-3 py-2 fw-bold">
                                                {{ $role->name }}
                                            </span>
                                        @empty
                                            <span class="text-muted">-</span>
                                        @endforelse
                                    </td>
                                    <td class="py-3 text-muted small"><i
                                            class="bi bi-calendar3 me-1.5"></i>{{ $row->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="py-3">
                                        <div class="d-flex gap-2">
                                            <button type="button" class="btn btn-sm btn-outline-primary" title="Edit"
                                                onclick="editUser({{ $row->id }}, '{{ $row->name }}', '{{ $row->email }}', '{{ $row->roles->first()->name ?? '' }}')">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>

                                            <form action="{{ route('users.destroy', $row->id) }}" method="POST"
                                                class="form-hapus-responden m-0">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                    class="btn btn-sm btn-light border border-light-subtle text-danger p-2 d-flex align-items-center justify-content-center btn-delete-users"
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

        <div class="tab-pane fade" id="role-panel" role="tabpanel" aria-labelledby="role-tab">
            <div class="card border-0 shadow-sm p-4">
                <div class="table-responsive">
                    <button type="button" class="btn btn-primary btn-sm mb-3" data-bs-toggle="modal"
                        data-bs-target="#addRoleModal">
                        <i class="bi bi-plus-lg me-1"></i> Tambah
                    </button>
                    <table id="tableRole" class="table table-striped table-hover align-middle mb-0" style="width:100%">
                        <thead class="table-light text-secondary small fw-bold text-uppercase">
                            <tr>
                                <th class="py-3 px-3">#</th>
                                <th class="py-3">Role Name</th>
                                <th class="py-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $role)
                                <tr>
                                    <td class="py-3 px-3">{{ $loop->iteration }}</td>
                                    <td class="py-3 fw-bold text-primary">{{ $role->name }}</td>
                                    <td class="py-3">
                                        <div class="d-flex gap-2">
                                            <button type="button" class="btn btn-sm btn-outline-primary"
                                                onclick="editRole({{ $role->id }}, '{{ $role->name }}')">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                            <form action="{{ route('roles.destroy', $role->id) }}" method="POST"
                                                class="form-hapus-role">
                                                @csrf @method('DELETE')
                                                <button type="button"
                                                    class="btn btn-sm btn-outline-danger btn-delete-roles">
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

        <div class="tab-pane fade" id="permission-panel" role="tabpanel" aria-labelledby="permission-tab">
            <div class="card border-0 shadow-sm p-4">
                <div class="table-responsive">
                    <button type="button" class="btn btn-primary btn-sm mb-3" data-bs-toggle="modal"
                        data-bs-target="#addPermissionModal">
                        <i class="bi bi-plus-lg me-1"></i> Tambah
                    </button>
                    <table id="tablePermission" class="table table-striped table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Permission Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($permissions as $permission)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><span class="badge bg-secondary">{{ $permission->name }}</span></td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <button class="btn btn-sm btn-outline-primary"
                                                onclick="editPermission({{ $permission->id }}, '{{ $permission->name }}')">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                            <form action="{{ route('permissions.destroy', $permission->id) }}"
                                                method="POST" class="form-hapus-permission">
                                                @csrf @method('DELETE')
                                                <button type="button"
                                                    class="btn btn-sm btn-outline-danger btn-delete-permission">
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

        <div class="tab-pane fade" id="assign-panel" role="tabpanel" aria-labelledby="assign-tab">
            <div class="card border-0 shadow-sm p-4">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Role Name</th>
                            <th>Permissions</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $role)
                            <tr>
                                <td><span class="badge bg-primary">{{ $role->name }}</span></td>
                                <td>
                                    @foreach ($role->permissions as $perm)
                                        <span class="badge bg-info text-dark m-1">{{ $perm->name }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-outline-primary"
                                        onclick="openAssignModal({{ $role->id }}, {{ $role->permissions->pluck('name') }})">
                                        Set Permission
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>



    {{-- Users --}}
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="editUserForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Name</label>
                            <input type="text" name="name" id="editName" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" name="email" id="editEmail" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Role</label>
                            <select name="role" id="editRole" class="form-select">
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    {{-- Roles --}}
    <div class="modal fade" id="addRoleModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('roles.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Role Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Role</label>
                            <input type="text" name="name" class="form-control" placeholder="Contoh: editor"
                                required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="editRoleModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form id="editRoleForm" method="POST">
                @csrf @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Role</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="text" name="name" id="editRoleName" class="form-control" required>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Permissions --}}
    <div class="modal fade" id="addPermissionModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('permissions.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Permission Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Permission</label>
                            <input type="text" name="name" class="form-control" placeholder="Contoh: dashboard"
                                required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="editPermissionModal" tabindex="-1">
        <div class="modal-dialog">
            <form id="editPermissionForm" method="POST">
                @csrf @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Permission</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="text" name="name" id="editPermissionName" class="form-control" required>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Assign Permission --}}
    <div class="modal fade" id="assignModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <form id="assignForm" method="POST">
                @csrf @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Assign Permissions</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            @foreach ($permissions as $permission)
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]"
                                            value="{{ $permission->name }}" id="perm_{{ $permission->id }}">
                                        <label class="form-check-label" for="perm_{{ $permission->id }}">
                                            {{ $permission->name }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.js"></script>

    {{-- User --}}
    <script>
        function editUser(id, name, email, role) {
            // Set action form
            document.getElementById('editUserForm').action = '/users/' + id;

            // Isi input modal
            document.getElementById('editName').value = name;
            document.getElementById('editEmail').value = email;
            document.getElementById('editRole').value = role;

            // Tampilkan modal
            var myModal = new bootstrap.Modal(document.getElementById('editUserModal'));
            myModal.show();
        }

        $(document).on('click', '.btn-delete-users', function(e) {
            e.preventDefault();
            let form = $(this).closest('form');

            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Data User dihapus permanen dari sistem!",
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

    {{-- Roles --}}
    <script>
        function editRole(id, name) {
            $('#editRoleForm').attr('action', '/roles/' + id);
            $('#editRoleName').val(name);
            $('#editRoleModal').modal('show');
        }

        // Untuk SweetAlert Hapus Role
        $('.btn-delete-roles').on('click', function() {
            let form = $(this).closest('form');
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Data Roles dihapus permanen dari sistem!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) form.submit();
            });
        });
    </script>

    {{-- Permissions --}}
    <script>
        function editPermission(id, name) {
            $('#editPermissionForm').attr('action', '/permissions/' + id);
            $('#editPermissionName').val(name);
            $('#editPermissionModal').modal('show');
        }

        // Untuk SweetAlert Hapus Role
        $('.btn-delete-permissions').on('click', function() {
            let form = $(this).closest('form');
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Data Permission dihapus permanen dari sistem!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) form.submit();
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // ... (konfigurasi dtConfig sama seperti sebelumnya)

            // Inisialisasi masing-masing tabel
            const tableUser = $('#tableUser').DataTable(dtConfig);
            const tableRole = $('#tableRole').DataTable(dtConfig);
            const tablePermission = $('#tablePermission').DataTable(dtConfig);
            const tableAssign = $('#tableAssign').DataTable(dtConfig);

            // Perbaikan Bug Auto-Width saat berpindah tab
            $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
                $.fn.dataTable.tables({
                    visible: true,
                    api: true
                }).columns.adjust();
            });
        });
    </script>

    {{-- Assign Permission --}}
    <script>
        function openAssignModal(roleId, rolePermissions) {
            // 1. Update URL form
            $('#assignForm').attr('action', '/roles/' + roleId + '/permissions');

            // 2. Reset semua checkbox ke tidak dicentang
            $('input[name="permissions[]"]').prop('checked', false);

            // 3. Centang checkbox yang ada di database (array rolePermissions)
            rolePermissions.forEach(function(permissionName) {
                $('input[name="permissions[]"][value="' + permissionName + '"]').prop('checked', true);
            });

            // 4. Tampilkan modal
            $('#assignModal').modal('show');
        }
    </script>
@endpush
