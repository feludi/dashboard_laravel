<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SIMWNA - Sistem Pemetaan WNA Kantor Imigrasi Kelas I TPI Cirebon')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        :root {
            --primary-dark-blue: #1a237e;
            --secondary-dark-blue: #283593;
            --gold: #ffd700;
            --light-gold: #ffecb3;
            --white: #ffffff;
            --text-dark: #2c3e50;
            --shadow: rgba(26, 35, 126, 0.1);
        }

        body {
            background-color: var(--white);
            color: var(--text-dark);
        }

        .sidebar {
            min-height: 100vh;
            background: var(--primary-dark-blue);
            box-shadow: 4px 0 10px var(--shadow);
        }
        
        .sidebar .nav-link {
            color: var(--white);
            border-radius: 8px;
            margin: 2px 0;
            transition: all 0.3s ease;
            border: 1px solid transparent;
        }
        
        .sidebar .nav-link:hover {
            background: var(--gold);
            color: var(--primary-dark-blue);
            border: 1px solid var(--gold);
            transform: translateX(5px);
            font-weight: 600;
        }
        
        .sidebar .nav-link.active {
            background: var(--gold);
            color: var(--primary-dark-blue);
            border: 1px solid var(--gold);
            font-weight: 600;
            box-shadow: 0 4px 8px rgba(255, 215, 0, 0.3);
        }

        .card {
            border: 1px solid #e8f4f8;
            box-shadow: 0 4px 12px var(--shadow);
            transition: all 0.3s ease;
            background: var(--white);
        }
        
        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 20px var(--shadow);
            border-color: var(--gold);
        }

        .card-header {
            background: var(--light-gold);
            color: var(--primary-dark-blue);
            font-weight: 600;
            border-bottom: 2px solid var(--gold);
        }

        .stat-card {
            background: var(--gold);
            color: var(--primary-dark-blue);
            border: 2px solid var(--gold);
        }
        
        .stat-card.primary {
            background: var(--primary-dark-blue);
            color: var(--white);
        }
        
        .stat-card.success {
            background: #4caf50;
            color: var(--white);
        }
        
        .stat-card.warning {
            background: #ff9800;
            color: var(--primary-dark-blue);
        }
        
        .stat-card.danger {
            background: #f44336;
            color: var(--white);
        }

        .btn-primary {
            background: var(--primary-dark-blue);
            border: 1px solid var(--primary-dark-blue);
            color: var(--white);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: var(--gold);
            border: 1px solid var(--gold);
            color: var(--primary-dark-blue);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(255, 215, 0, 0.3);
        }

        .btn-outline-secondary {
            border: 1px solid var(--primary-dark-blue);
            color: var(--primary-dark-blue);
        }

        .btn-outline-secondary:hover {
            background: var(--primary-dark-blue);
            border: 1px solid var(--primary-dark-blue);
            color: var(--white);
        }

        .btn-outline-light {
            border: 1px solid var(--gold);
            color: var(--gold);
        }

        .btn-outline-light:hover {
            background: var(--gold);
            border: 1px solid var(--gold);
            color: var(--primary-dark-blue);
        }

        .border-bottom {
            border-color: var(--gold) !important;
            border-width: 2px !important;
        }

        .text-primary {
            color: var(--primary-dark-blue) !important;
        }

        .bg-primary {
            background: var(--primary-dark-blue) !important;
        }

        .navbar-brand, .h2 {
            color: var(--primary-dark-blue);
            font-weight: 700;
        }

        .table th {
            background: var(--light-gold);
            color: var(--primary-dark-blue);
            border-color: var(--gold);
        }

        .table-striped > tbody > tr:nth-of-type(odd) > td {
            background-color: rgba(255, 215, 0, 0.05);
        }

        .alert-success {
            background: var(--light-gold);
            border: 1px solid var(--gold);
            color: var(--primary-dark-blue);
        }

        .alert-danger {
            background: rgba(244, 67, 54, 0.1);
            border: 1px solid #f44336;
            color: #d32f2f;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 0.2rem rgba(255, 215, 0, 0.25);
        }

        .map-container {
            height: 500px;
            border-radius: 10px;
            overflow: hidden;
            border: 3px solid var(--gold);
            box-shadow: 0 6px 15px var(--shadow);
        }
        
        .nationality-flag {
            width: 24px;
            height: 16px;
            border-radius: 2px;
            margin-right: 8px;
            border: 1px solid var(--gold);
            object-fit: cover;
        }
        
        .flag-emoji {
            font-size: 16px;
            margin-right: 8px;
        }

        /* Sidebar brand styling */
        .sidebar h4 {
            color: var(--gold) !important;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
            font-weight: 700;
        }

        .sidebar small {
            color: rgba(255, 255, 255, 0.8) !important;
        }

        /* Badge styling */
        .badge {
            background: var(--gold) !important;
            color: var(--primary-dark-blue) !important;
        }

        /* Custom scrollbar for sidebar */
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: var(--secondary-dark-blue);
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: var(--gold);
            border-radius: 3px;
        }

        /* Pagination styling */
        .pagination .page-link {
            color: var(--primary-dark-blue);
            border-color: var(--gold);
        }

        .pagination .page-link:hover {
            color: var(--white);
            background-color: var(--gold);
            border-color: var(--gold);
        }

        .pagination .page-item.active .page-link {
            background-color: var(--primary-dark-blue);
            border-color: var(--primary-dark-blue);
            color: var(--white);
        }

        /* Form select styling */
        .form-select {
            border-color: #e1e5e9;
        }

        .form-select:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 0.2rem rgba(255, 215, 0, 0.25);
        }

        /* Dropdown menu styling */
        .dropdown-menu {
            border: 1px solid var(--gold);
            box-shadow: 0 4px 12px var(--shadow);
        }

        .dropdown-item:hover {
            background-color: var(--light-gold);
            color: var(--primary-dark-blue);
        }

        /* Modal styling */
        .modal-content {
            border: 2px solid var(--gold);
            box-shadow: 0 10px 30px var(--shadow);
        }

        .modal-header {
            background: var(--light-gold);
            color: var(--primary-dark-blue);
            border-bottom: 2px solid var(--gold);
        }

        .modal-footer {
            border-top: 1px solid var(--gold);
        }

        /* Success and error message styling */
        .alert-success {
            background: var(--light-gold);
            border: 1px solid var(--gold);
            color: var(--primary-dark-blue);
        }

        /* Progress bars */
        .progress {
            background-color: #f8f9fa;
        }

        .progress-bar {
            background: var(--primary-dark-blue);
        }

        /* Input group styling */
        .input-group-text {
            background-color: var(--light-gold);
            border-color: var(--gold);
            color: var(--primary-dark-blue);
        }

        /* Link styling */
        a {
            color: var(--primary-dark-blue);
            transition: color 0.3s ease;
        }

        a:hover {
            color: var(--gold);
        }

        /* Chart container styling */
        .chart-container {
            background: var(--white);
            border: 1px solid var(--gold);
            border-radius: 10px;
            padding: 1rem;
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar p-3">
                <div class="text-center mb-4">
                    <h4 class="text-white">
                        <i class="fas fa-globe me-2"></i>
                        SIMWNA
                    </h4>
                    <small class="text-light">Sistem Pemetaan WNA - Kantor Imigrasi Kelas I TPI Cirebon</small>
                </div>
                
                <ul class="nav nav-pills flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard*') && !request()->routeIs('dashboard.map') && !request()->routeIs('dashboard.analytics') ? 'active' : '' }}" 
                           href="{{ route('dashboard.index') }}">
                            <i class="fas fa-tachometer-alt me-2"></i>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard.map') ? 'active' : '' }}" 
                           href="{{ route('dashboard.map') }}">
                            <i class="fas fa-map me-2"></i>
                            Peta Interaktif
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard.analytics') ? 'active' : '' }}" 
                           href="{{ route('dashboard.analytics') }}">
                            <i class="fas fa-chart-line me-2"></i>
                            Analitik
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('foreigners*') ? 'active' : '' }}" 
                           href="{{ route('foreigners.index') }}">
                            <i class="fas fa-users me-2"></i>
                            Data WNA
                        </a>
                    </li>
                    <li class="nav-item mt-3">
                        <hr class="text-light">
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('foreigners.create') }}">
                            <i class="fas fa-plus me-2"></i>
                            Tambah Data WNA
                        </a>
                    </li>
                    <li class="nav-item mt-3">
                        <hr class="text-light">
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('profile*') ? 'active' : '' }}" 
                           href="{{ route('profile.show') }}">
                            <i class="fas fa-user-circle me-2"></i>
                            Profil Saya
                        </a>
                    </li>
                </ul>

                <!-- Info Pengguna & Keluar -->
                <div class="mt-auto pt-3">
                    <hr class="text-light">
                    @php
                        $currentUser = \App\Http\Controllers\AuthController::user();
                    @endphp
                    @if($currentUser)
                        <div class="text-light mb-2">
                            <small>
                                <i class="fas fa-user me-1"></i>
                                @if(is_object($currentUser))
                                    {{ $currentUser->name }}
                                @else
                                    {{ ucfirst($currentUser['username']) }}
                                @endif
                            </small>
                        </div>
                        <div class="text-light mb-3">
                            <small>
                                <i class="fas fa-clock me-1"></i>
                                @if(is_object($currentUser))
                                    {{ now()->format('H:i') }}
                                @else
                                    {{ $currentUser['login_time']->format('H:i') }}
                                @endif
                            </small>
                        </div>
                    @endif
                    
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-light btn-sm w-100">
                            <i class="fas fa-sign-out-alt me-2"></i>
                            Keluar
                        </button>
                    </form>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">@yield('page-title', 'Dashboard')</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        @yield('page-actions')
                    </div>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @stack('scripts')
</body>
</html>
