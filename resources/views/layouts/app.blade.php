<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Perpustakaan - @yield('title')</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <style>
        body {
            padding-top: 60px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .sidebar {
            min-height: calc(100vh - 60px);
            background-color: #f8f9fa;
            border-right: 1px solid #dee2e6;
        }
        .sidebar .nav-link {
            color: #333;
            border-radius: 0;
        }
        .sidebar .nav-link:hover {
            background-color: #e9ecef;
        }
        .sidebar .nav-link.active {
            color: #fff;
            background-color: #0d6efd;
        }
        main {
            flex: 1;
        }
        .footer {
            margin-top: auto;
            background-color: #f8f9fa;
            border-top: 1px solid #dee2e6;
            padding: 1rem 0;
        }
        .action-buttons {
            white-space: nowrap;
        }
    </style>
    @yield('styles')
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="fas fa-book-reader me-2"></i>Sistem Perpustakaan
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-user me-1"></i> Profil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-sign-out-alt me-1"></i> Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">
                                <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('buku*') ? 'active' : '' }}" href="{{ route('buku.index') }}">
                                <i class="fas fa-book me-2"></i>Buku
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('siswa*') ? 'active' : '' }}" href="{{ route('siswa.index') }}">
                                <i class="fas fa-user-graduate me-2"></i>Siswa
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('petugas*') ? 'active' : '' }}" href="{{ route('petugas.index') }}">
                                <i class="fas fa-user-tie me-2"></i>Petugas
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('peminjaman*') ? 'active' : '' }}" href="{{ route('peminjaman.index') }}">
                                <i class="fas fa-clipboard-list me-2"></i>Peminjaman
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('denda*') ? 'active' : '' }}" href="{{ route('denda.index') }}">
                                <i class="fas fa-money-bill-wave me-2"></i>Denda
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('laporan*') ? 'active' : '' }}" href="#">
                                <i class="fas fa-chart-bar me-2"></i>Laporan
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                <!-- Flash Messages -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Page Title and Content -->
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                    <h1 class="h2">@yield('title')</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        @yield('action_buttons')
                    </div>
                </div>

                @yield('content')
            </main>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer text-center py-3">
        <div class="container">
            <span class="text-muted">&copy; {{ date('Y') }} Sistem Perpustakaan. All rights reserved.</span>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Custom JS -->
    @yield('scripts')
</body>
</html>