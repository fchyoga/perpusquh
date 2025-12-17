<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastr@2.1.4/build/toastr.min.css"
        integrity="sha256-R91pD48xW+oHbpJYGn5xR0Q7tMhH4xOrWn1QqMRINtA=" crossorigin="anonymous">
    <title>Perpustakaan Digital</title>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .nav:first-child {
            box-shadow: 4px 4px 50px rgba(145, 145, 145, 0.2);
            padding-bottom: 20px !important;
            padding-top: 10px !important;
            background: white;
        }

        .navbar-nav>li {
            margin-left: 30px;
        }

        .title-text {
            font-size: 3rem;
            font-weight: bold;
        }

        .title-desc {
            color: #848484;
            font-size: 1.1em;
        }

        .bordered {
            width: 100%;
            border: 0.3px solid #dadada !important;
            margin-bottom: 8px;
        }

        h5 {
            background: '#29291e';
            color: 'white';
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar d-flex flex-column flex-shrink-0 p-3 bg-white shadow-sm" id="sidebar">
        <a href="{{ url('/dashboard') }}" class="sidebar-brand text-decoration-none">
            <img src="{{ asset('images/logo-stmik.png') }}" alt="logo" width="40" height="40">
            <div class="d-flex flex-column ms-2">
                <span class="fw-bold text-dark" style="font-size: 1rem; line-height: 1.2;">SIPO-SWU</span>
                <span class="text-muted small" style="font-size: 0.7rem;">STMIK Widya Utama</span>
            </div>
        </a>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto">
            @if (auth()->user()->role == 'admin')
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}"
                        class="nav-link-sidebar {{ request()->is('dashboard') ? 'active' : '' }}">
                        <i class="bi bi-grid"></i>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('book-management') }}"
                        class="nav-link-sidebar {{ request()->is('dashboard/book-management*') ? 'active' : '' }}">
                        <i class="bi bi-book"></i>
                        Manajemen Buku
                    </a>
                </li>
                <li>
                    <a href="{{ route('loan-management') }}"
                        class="nav-link-sidebar {{ request()->is('dashboard/loan-management*') ? 'active' : '' }}">
                        <i class="bi bi-arrow-left-right"></i>
                        Peminjaman
                    </a>
                </li>
                <li>
                    <a href="{{ route('student-management') }}"
                        class="nav-link-sidebar {{ request()->is('dashboard/student-management*') ? 'active' : '' }}">
                        <i class="bi bi-people"></i>
                        Manajemen Anggota
                    </a>
                </li>
                <li>
                    <a href="{{ route('settings.index') }}"
                        class="nav-link-sidebar {{ request()->is('dashboard/settings*') ? 'active' : '' }}">
                        <i class="bi bi-gear"></i>
                        Pengaturan
                    </a>
                </li>
                <li>
                    <a href="#masterDataSubmenu" data-bs-toggle="collapse"
                        class="nav-link-sidebar d-flex justify-content-between align-items-center {{ request()->is('dashboard/master*') ? '' : 'collapsed' }}"
                        aria-expanded="{{ request()->is('dashboard/master*') ? 'true' : 'false' }}">
                        <span><i class="bi bi-database"></i> Data Master</span>
                        <i class="bi bi-chevron-down small"></i>
                    </a>
                    <div class="collapse {{ request()->is('dashboard/master*') ? 'show' : '' }}" id="masterDataSubmenu">
                        <ul class="nav flex-column ms-3 mt-1">
                            <li class="nav-item">
                                <a href="{{ route('admin.master.prodi.index') }}"
                                    class="nav-link-sidebar py-1 {{ request()->is('dashboard/master/prodi*') ? 'active' : '' }}"
                                    style="font-size: 0.9em;">
                                    Prodi
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.master.jurusan.index') }}"
                                    class="nav-link-sidebar py-1 {{ request()->is('dashboard/master/jurusan*') ? 'active' : '' }}"
                                    style="font-size: 0.9em;">
                                    Jurusan
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.master.semester.index') }}"
                                    class="nav-link-sidebar py-1 {{ request()->is('dashboard/master/semester*') ? 'active' : '' }}"
                                    style="font-size: 0.9em;">
                                    Semester
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            @endif

            @if (auth()->user()->role == 'member')
                <li class="nav-item">
                    <a href="{{ route('member.dashboard') }}"
                        class="nav-link-sidebar {{ request()->is('member/dashboard') ? 'active' : '' }}">
                        <i class="bi bi-grid"></i>
                        Katalog Buku
                    </a>
                </li>
                <li>
                    <a href="{{ route('member.history') }}"
                        class="nav-link-sidebar {{ request()->is('member/history') ? 'active' : '' }}">
                        <i class="bi bi-clock-history"></i>
                        Riwayat Peminjaman
                    </a>
                </li>
            @endif
        </ul>
        <div class="mt-auto pt-3 border-top">
            <div class="d-flex align-items-center mb-3 px-2">
                <div class="bg-primary text-white rounded-circle d-flex justify-content-center align-items-center me-2"
                    style="width: 32px; height: 32px;">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="d-flex flex-column">
                    <span class="fw-bold text-dark small">{{ Auth::user()->name }}</span>
                    <span class="text-muted" style="font-size: 0.7rem;">{{ ucfirst(Auth::user()->role) }}</span>
                </div>
            </div>

            <ul class="nav nav-pills flex-column">
                @if (auth()->user()->role == 'member')
                    <li class="nav-item">
                        <a href="{{ route('member.profile') }}"
                            class="nav-link-sidebar {{ request()->is('member/profile') ? 'active' : '' }}">
                            <i class="bi bi-person"></i>
                            Profil Saya
                        </a>
                    </li>
                @endif
                @if (auth()->user()->role == 'admin')
                    <li class="nav-item">
                        <a href="{{ route('profile-admin') }}"
                            class="nav-link-sidebar {{ request()->is('dashboard/profile*') ? 'active' : '' }}">
                            <i class="bi bi-person"></i>
                            Profil Saya
                        </a>
                    </li>
                @endif
                <li class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link-sidebar text-danger"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="bi bi-box-arrow-right"></i>
                        Sign Out
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Mobile Toggle -->
        <nav class="navbar navbar-light bg-light d-lg-none mb-4 rounded shadow-sm">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar"
                    aria-controls="sidebar" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <span class="navbar-brand mb-0 h1">SIPO-SWU</span>
            </div>
        </nav>

        @yield('content')
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
    <script>
        $(document).ready(function () {
            // Initialize Bootstrap dropdowns
            var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'))
            var dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
                return new bootstrap.Dropdown(dropdownToggleEl)
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/toastr@2.1.4/build/toastr.min.js"
        integrity="sha256-Hgwq1OBpJ276HUP9H3VJkSv9ZCGRGQN+JldPJ8pNcUM=" crossorigin="anonymous"></script>
    <script>
        toastr.options = {
            "debug": false,
            "positionClass": "toast-bottom-right",
            "onclick": null,
            "fadeIn": 300,
            "fadeOut": 1000,
            "timeOut": 5000,
            "extendedTimeOut": 1000
        }
        @if ($message = Session::get('success'))
            toastr.success("{{ $message }}")
        @endif

        @if(Session::has('error'))
            toastr.error("{{ session('error') }}");
        @endif

    </script>
</body>

</html>