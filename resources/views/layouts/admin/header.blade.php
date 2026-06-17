<nav class="navbar admin-navbar navbar-expand bg-white border-bottom py-2">
    <div class="container-fluid px-3 px-lg-4">
        <button class="sidebar-toggle btn btn-link text-dark p-0 border-0 me-3" type="button" data-sidebar-toggle
            aria-controls="adminSidebar" aria-expanded="true" aria-label="Toggle sidebar">
            <i class="bi bi-list fs-3"></i>
        </button>

        <div class="navbar-actions ms-auto d-flex align-items-center gap-2">

            <div class="dropdown ms-2">
                <button
                    class="btn btn-link text-decoration-none dropdown-toggle p-0 d-flex align-items-center gap-2 text-dark shadow-none"
                    type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    @php
                        $words = explode(' ', Auth::user()->name ?? 'Admin');
                        $initials = '';
                        foreach ($words as $w) {
                            $initials .= $w[0];
                        }
                        $initials = strtoupper(substr($initials, 0, 2));
                    @endphp

                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold"
                        style="width: 35px; height: 35px; font-size: 13px; letter-spacing: 0.5px;">
                        {{ $initials }}
                    </div>
                    <span
                        class="profile-name d-none d-sm-inline fw-semibold small">{{ Auth::user()->name ?? 'User Admin' }}</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2">
                    <li>
                        <a class="dropdown-item text-danger small py-2" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="bi bi-box-arrow-right me-2"></i>Sign out
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
