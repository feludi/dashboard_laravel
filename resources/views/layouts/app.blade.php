<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ImmiTrace – Immigration Tracing and Mapping System')</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="shortcut icon" href="/favicon.ico">
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    
    <!-- Stylesheets -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        :root {
            --primary-blue: #1e40af;
            --secondary-blue: #3b82f6;
            --light-blue: #dbeafe;
            --gold: #d4af37;
            --light-gold: #fef3c7;
            --white: #ffffff;
            --light-gray: #f8fafc;
            --border-color: #e5e7eb;
            --text-primary: #1f2937;
            --text-secondary: #6b7280;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        body {
            background-color: var(--light-gray);
            color: var(--text-primary);
            font-size: 14px;
            line-height: 1.5;
        }

        /* Main sidebar styling */
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(145deg, var(--primary-blue), var(--secondary-blue));
            border-right: 1px solid var(--border-color);
            box-shadow: var(--shadow-md);
            position: relative;
            overflow: hidden;
        }
        
        .sidebar::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Ccircle cx='9' cy='9' r='1'/%3E%3Cpath d='m19 19h1v1h-1z'/%3E%3Ccircle cx='49' cy='49' r='1'/%3E%3Cpath d='m39 39h1v1h-1z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            pointer-events: none;
        }
        
        .sidebar .nav-link {
            color: var(--white) !important;
            border-radius: 8px;
            margin: 1px 0;
            padding: 8px 12px;
            font-size: 13px;
            font-weight: 500;
            transition: all 0.15s ease;
        }
        
        .sidebar .nav-link:hover {
            background: var(--gold) !important;
            color: var(--white) !important;
        }
        
        .sidebar .nav-link.active {
            background: var(--gold) !important;
            color: var(--white) !important;
        }

        /* Card styles - keep them clean and simple */
        .card {
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-sm);
            transition: all 0.15s ease;
            border-radius: 8px;
            background: var(--white);
        }
        
        .card:hover {
            box-shadow: var(--shadow-md);
        }

        .card-header {
            background: var(--light-blue);
            color: var(--primary-blue);
            font-weight: 600;
            font-size: 13px;
            border-bottom: 1px solid var(--border-color);
            padding: 12px 16px;
        }

        .btn {
            font-size: 13px;
            font-weight: 500;
            padding: 6px 12px;
            border-radius: 6px;
            transition: all 0.15s ease;
        }

        .btn-primary {
            background: var(--primary-blue);
            border: 1px solid var(--primary-blue);
            color: var(--white);
        }

        .btn-primary:hover {
            background: var(--secondary-blue);
            border-color: var(--secondary-blue);
        }

        .btn-primary:focus,
        .btn-primary:active,
        .btn-primary.active {
            background: var(--secondary-blue) !important;
            border-color: var(--secondary-blue) !important;
            color: var(--white) !important;
            box-shadow: 0 0 0 2px rgba(30, 64, 175, 0.25) !important;
        }

        .btn-outline-primary {
            border: 1px solid var(--primary-blue);
            color: var(--primary-blue);
            background: transparent;
        }

        .btn-outline-primary:hover {
            background: var(--primary-blue);
            border-color: var(--primary-blue);
            color: var(--white);
        }

        .btn-outline-primary:focus,
        .btn-outline-primary:active,
        .btn-outline-primary.active {
            background: var(--primary-blue) !important;
            border-color: var(--primary-blue) !important;
            color: var(--white) !important;
            box-shadow: 0 0 0 2px rgba(30, 64, 175, 0.25) !important;
        }

        .btn-outline-secondary {
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
        }

        .btn-outline-secondary:hover {
            background: var(--light-gray);
            border-color: var(--border-color);
            color: var(--text-primary);
        }

        .btn-outline-light {
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: var(--white);
        }

        .btn-outline-light:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.5);
            color: var(--white);
        }

        .btn-outline-warning {
            border: 1px solid var(--gold);
            color: var(--gold);
            background: transparent;
        }

        .btn-outline-warning:hover {
            background: var(--gold);
            border-color: var(--gold);
            color: var(--white);
        }

        .btn-outline-danger {
            border: 1px solid #dc2626;
            color: #dc2626;
            background: transparent;
        }

        .btn-outline-danger:hover {
            background: #dc2626;
            border-color: #dc2626;
            color: var(--white);
        }

        /* Ensure button states work properly */
        .btn:focus {
            outline: none;
        }

        .btn:not(:disabled):not(.disabled):active,
        .btn:not(:disabled):not(.disabled).active {
            transform: translateY(1px);
        }

        /* Override Bootstrap defaults */
        .btn-primary:not(:disabled):not(.disabled):active,
        .btn-primary:not(:disabled):not(.disabled).active,
        .show > .btn-primary.dropdown-toggle {
            background-color: var(--secondary-blue) !important;
            border-color: var(--secondary-blue) !important;
        }

        .btn-outline-primary:not(:disabled):not(.disabled):active,
        .btn-outline-primary:not(:disabled):not(.disabled).active,
        .show > .btn-outline-primary.dropdown-toggle {
            background-color: var(--primary-blue) !important;
            border-color: var(--primary-blue) !important;
            color: var(--white) !important;
        }

        .btn-sm {
            padding: 4px 8px;
            font-size: 12px;
        }

        .text-primary {
            color: var(--primary-blue) !important;
        }

        .bg-primary {
            background: var(--primary-blue) !important;
        }

        .border-primary {
            border-color: var(--primary-blue) !important;
        }

        /* Form controls */
        .form-control, .form-select {
            border: 1px solid var(--border-color);
            border-radius: 6px;
            font-size: 13px;
            padding: 6px 10px;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 2px rgba(245, 158, 11, 0.1);
        }

        /* Table styling */
        .table {
            font-size: 13px;
        }

        .table th {
            background: var(--light-blue);
            border-color: var(--border-color);
            font-weight: 600;
            font-size: 12px;
            padding: 8px 12px;
            color: var(--primary-blue);
        }

        .table td {
            padding: 8px 12px;
            border-color: var(--border-color);
        }

        /* Navbar */
        .navbar {
            background: var(--white) !important;
            border-bottom: 1px solid var(--border-color);
            box-shadow: var(--shadow-sm);
            padding: 8px 0;
        }

        .navbar-brand {
            font-weight: 600;
            font-size: 16px;
            color: var(--primary-blue) !important;
        }

        /* Alert styling */
        .alert {
            border-radius: 6px;
            font-size: 13px;
            padding: 8px 12px;
        }

        .alert-success {
            background: var(--light-gold);
            border: 1px solid var(--gold);
            color: var(--primary-blue);
        }

        /* Badge styling */
        .badge {
            font-size: 11px;
            font-weight: 500;
            padding: 4px 6px;
        }

        .badge.bg-primary {
            background: var(--primary-blue) !important;
        }

        .badge.bg-warning {
            background: var(--gold) !important;
            color: var(--primary-blue) !important;
        }

        /* Pagination */
        .pagination .page-link {
            color: var(--primary-blue);
            border-color: var(--border-color);
        }

        .pagination .page-link:hover {
            color: var(--white);
            background-color: var(--gold);
            border-color: var(--gold);
        }

        .pagination .page-item.active .page-link {
            background-color: var(--primary-blue);
            border-color: var(--primary-blue);
            color: var(--white);
        }

        /* Compact spacing */
        .mb-2 { margin-bottom: 0.5rem !important; }
        .mb-3 { margin-bottom: 0.75rem !important; }
        .mb-4 { margin-bottom: 1rem !important; }
        .p-2 { padding: 0.5rem !important; }
        .p-3 { padding: 0.75rem !important; }
        .py-2 { padding-top: 0.5rem !important; padding-bottom: 0.5rem !important; }
        .px-3 { padding-left: 0.75rem !important; padding-right: 0.75rem !important; }

        /* Global compact form styling */
        .form-label {
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 4px;
            color: var(--text-primary);
        }

        .form-control-sm, .form-select-sm {
            font-size: 13px;
            padding: 4px 8px;
        }

        /* Compact modals */
        .modal-header {
            padding: 12px 16px;
            border-bottom: 1px solid var(--border-color);
            background: var(--light-blue);
            color: var(--primary-blue);
        }

        .modal-body {
            padding: 16px;
        }

        .modal-footer {
            padding: 12px 16px;
            border-top: 1px solid var(--border-color);
        }

        /* Compact pagination */
        .pagination {
            font-size: 13px;
        }

        .page-link {
            padding: 4px 8px;
        }

        /* Compact breadcrumb */
        .breadcrumb {
            font-size: 13px;
            margin-bottom: 0.5rem;
            padding: 6px 0;
            background: none;
        }

        /* Compact dropdowns */
        .dropdown-menu {
            font-size: 13px;
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-md);
        }

        .dropdown-item {
            padding: 6px 12px;
        }

        .dropdown-item:hover {
            background-color: var(--light-gold);
            color: var(--primary-blue);
        }

        /* Responsive utilities */
        @media (max-width: 576px) {
            .btn {
                font-size: 12px;
                padding: 4px 8px;
            }
            
            .card-header {
                padding: 8px 12px;
            }
            
            .card-body {
                padding: 12px;
            }
            
            .table-responsive {
                font-size: 12px;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar p-3">
                <div class="text-center mb-3">
                    <h5 class="text-white mb-1">
                        <i class="fas fa-globe me-2"></i>
                        ImmiTrace
                    </h5>
                    <small class="text-white opacity-75">Immigration Tracing & Mapping System</small>
                </div>
                
                <ul class="nav nav-pills flex-column">
                    <li class="nav-item mb-1">
                        <a class="nav-link {{ request()->routeIs('dashboard*') && !request()->routeIs('dashboard.map') && !request()->routeIs('dashboard.analytics') ? 'active' : '' }}" 
                           href="{{ route('dashboard.index') }}">
                            <i class="fas fa-tachometer-alt me-2"></i>
                            Dashboard
                        </a>
                    </li>
                    @php
                        $currentUser = \App\Http\Controllers\AuthController::user();
                    @endphp
                    @if($currentUser && is_object($currentUser) && $currentUser->canViewMaps())
                    <li class="nav-item mb-1">
                        <a class="nav-link {{ request()->routeIs('dashboard.map') ? 'active' : '' }}" 
                           href="{{ route('dashboard.map') }}">
                            <i class="fas fa-map me-2"></i>
                            Interactive Map
                        </a>
                    </li>
                    @endif
                    <li class="nav-item mb-1">
                        <a class="nav-link {{ request()->routeIs('dashboard.analytics') ? 'active' : '' }}" 
                           href="{{ route('dashboard.analytics') }}">
                            <i class="fas fa-chart-line me-2"></i>
                            Analytics
                        </a>
                    </li>
                    @if($currentUser && is_object($currentUser) && $currentUser->canViewForeignerList())
                    <li class="nav-item mb-1">
                        <a class="nav-link {{ request()->routeIs('foreigners.index') || request()->routeIs('foreigners.show') || request()->routeIs('foreigners.edit') ? 'active' : '' }}" 
                           href="{{ route('foreigners.index') }}">
                            <i class="fas fa-users me-2"></i>
                            Foreign Nationals
                        </a>
                    </li>
                    @endif
                    
                    <hr class="my-2 border-white opacity-25">
                    
                    <!-- Quick Actions Section (available to operators) -->
                    @if($currentUser && is_object($currentUser) && ($currentUser->canAddForeigners() || $currentUser->canImportForeigners()))
                    <li class="nav-item">
                        <h6 class="text-white opacity-75 mb-2" style="font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px;">
                            Quick Actions
                        </h6>
                    </li>
                    @if($currentUser && is_object($currentUser) && $currentUser->canAddForeigners())
                    <li class="nav-item mb-1">
                        <a class="nav-link {{ request()->routeIs('foreigners.create') ? 'active' : '' }}" 
                           href="{{ route('foreigners.create') }}">
                            <i class="fas fa-user-plus me-2"></i>
                            Add New Record
                        </a>
                    </li>
                    @endif
                    @if($currentUser && is_object($currentUser) && $currentUser->canImportForeigners())
                    <li class="nav-item mb-1">
                        <a class="nav-link {{ request()->routeIs('imports*') ? 'active' : '' }}" 
                           href="{{ route('imports.index') }}">
                            <i class="fas fa-file-import me-2"></i>
                            Import Data
                        </a>
                    </li>
                    @endif
                    <hr class="my-2 border-white opacity-25">
                    @endif
                    
                    <li class="nav-item mb-1">
                        <a class="nav-link {{ request()->routeIs('profile*') ? 'active' : '' }}" 
                           href="{{ route('profile.show') }}">
                            <i class="fas fa-user-circle me-2"></i>
                            My Profile
                        </a>
                    </li>
                </ul>

                <!-- User Info & Logout -->
                <div class="mt-auto pt-3">
                    <hr class="border-white opacity-25">
                    @php
                        $currentUser = \App\Http\Controllers\AuthController::user();
                    @endphp
                    @if($currentUser)
                        <div class="text-white opacity-75 mb-2">
                            <small style="font-size: 11px;">
                                <i class="fas fa-user me-1"></i>
                                @if(is_object($currentUser))
                                    {{ $currentUser->name }}
                                @else
                                    {{ ucfirst($currentUser['username']) }}
                                @endif
                            </small>
                        </div>
                    @endif
                    
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-light btn-sm w-100">
                            <i class="fas fa-sign-out-alt me-1"></i>
                            Logout
                        </button>
                    </form>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-2 mb-3 border-bottom">
                    <h4 class="mb-0">@yield('page-title', 'Dashboard')</h4>
                    <div class="btn-toolbar">
                        @yield('page-actions')
                    </div>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <!-- Toast Notification Container -->
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1050;">
        <!-- Toasts will be inserted here dynamically -->
    </div>

    <!-- Loading Spinner Overlay -->
    <div id="loading-overlay" class="position-fixed top-0 start-0 w-100 h-100 d-none" style="background: rgba(0,0,0,0.5); z-index: 2000;">
        <div class="d-flex justify-content-center align-items-center h-100">
            <div class="text-center text-white">
                <div class="spinner-border mb-3" role="status" style="width: 3rem; height: 3rem;">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p>Processing your request...</p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- Toast Notification System -->
    <script>
        // Toast notification function
        function showToast(message, type = 'info', duration = 5000) {
            const toastContainer = document.querySelector('.toast-container');
            const toastId = 'toast-' + Date.now();
            
            const toastHtml = `
                <div id="${toastId}" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="toast-header">
                        <i class="fas fa-${getToastIcon(type)} text-${type} me-2"></i>
                        <strong class="me-auto">ImmiTrace</strong>
                        <small class="text-muted">just now</small>
                        <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
                    </div>
                    <div class="toast-body">
                        ${message}
                    </div>
                </div>
            `;
            
            toastContainer.insertAdjacentHTML('beforeend', toastHtml);
            
            const toastElement = document.getElementById(toastId);
            const toast = new bootstrap.Toast(toastElement, { delay: duration });
            toast.show();
            
            // Remove toast element after it's hidden
            toastElement.addEventListener('hidden.bs.toast', () => {
                toastElement.remove();
            });
        }
        
        function getToastIcon(type) {
            const icons = {
                'success': 'check-circle',
                'info': 'info-circle', 
                'warning': 'exclamation-triangle',
                'danger': 'times-circle',
                'error': 'times-circle'
            };
            return icons[type] || 'info-circle';
        }
        
        // Loading overlay functions
        function showLoading() {
            document.getElementById('loading-overlay').classList.remove('d-none');
        }
        
        function hideLoading() {
            document.getElementById('loading-overlay').classList.add('d-none');
        }
        
        // Auto-hide alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert:not(.alert-permanent)');
            alerts.forEach(alert => {
                setTimeout(() => {
                    if (alert && !alert.classList.contains('show')) return;
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>
