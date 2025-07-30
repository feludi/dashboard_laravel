<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foreigner Mapping Dashboard - Laravel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .hero-section {
            background: #667eea;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .feature-card {
            transition: transform 0.3s;
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .feature-card:hover {
            transform: translateY(-5px);
        }
    </style>
</head>
<body>
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 text-white">
                    <h1 class="display-4 fw-bold mb-4">
                        <i class="fas fa-globe me-3"></i>
                        Foreigner Mapping Dashboard
                    </h1>
                    <p class="lead mb-4">
                        A comprehensive Laravel-based system for tracking and visualizing foreign nationals with interactive geographic mapping.
                    </p>
                    <div class="d-grid gap-2 d-md-flex">
                        <a href="/demo.html" class="btn btn-light btn-lg">
                            <i class="fas fa-eye me-2"></i>View Interactive Demo
                        </a>
                        <a href="/health" class="btn btn-outline-light btn-lg">
                            <i class="fas fa-heartbeat me-2"></i>Health Check
                        </a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="text-center">
                        <i class="fas fa-map-marked-alt text-white" style="font-size: 15rem; opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-12">
                    <h2 class="display-5 fw-bold mb-3">System Status</h2>
                    <p class="lead text-muted">Current application configuration and requirements</p>
                </div>
            </div>
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card card h-100">
                        <div class="card-body text-center p-4">
                            <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                            <h5 class="card-title">Laravel Framework</h5>
                            <p class="card-text">✅ Laravel 11 application is running successfully</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="feature-card card h-100">
                        <div class="card-body text-center p-4">
                            <i class="fas fa-eye fa-3x text-primary mb-3"></i>
                            <h5 class="card-title">Interactive Demo</h5>
                            <p class="card-text">✅ Fully functional demo with sample data available</p>
                            <a href="/demo.html" class="btn btn-primary">View Demo</a>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="feature-card card h-100">
                        <div class="card-body text-center p-4">
                            <i class="fas fa-database fa-3x text-warning mb-3"></i>
                            <h5 class="card-title">Database Setup</h5>
                            <p class="card-text">⚠️ SQLite driver required for full functionality</p>
                            <small class="text-muted">Install php_sqlite3 extension</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-light py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h3 class="mb-4">Setup Instructions</h3>
                    <div class="alert alert-info">
                        <h5><i class="fas fa-info-circle me-2"></i>To enable full Laravel functionality:</h5>
                        <ol class="text-start mt-3">
                            <li><strong>Install SQLite PHP extension:</strong>
                                <ul>
                                    <li>Windows: Enable <code>extension=pdo_sqlite</code> and <code>extension=sqlite3</code> in php.ini</li>
                                    <li>Linux/Mac: Install php-sqlite3 package</li>
                                </ul>
                            </li>
                            <li><strong>Run database migrations:</strong> <code>php artisan migrate</code></li>
                            <li><strong>Seed sample data:</strong> <code>php artisan db:seed</code></li>
                        </ol>
                    </div>
                    
                    <div class="mt-4">
                        <h5>Available Options:</h5>
                        <div class="d-grid gap-2 d-md-flex justify-content-center">
                            <a href="/demo.html" class="btn btn-primary">
                                <i class="fas fa-eye me-2"></i>Interactive Demo
                            </a>
                            <a href="/health" class="btn btn-outline-secondary">
                                <i class="fas fa-heartbeat me-2"></i>API Health Check
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-dark text-light py-4">
        <div class="container text-center">
            <p class="mb-0">
                <i class="fas fa-globe me-2"></i>
                Foreigner Mapping Dashboard - Built with Laravel {{ app()->version() }}
            </p>
        </div>
    </footer>
</body>
</html>
