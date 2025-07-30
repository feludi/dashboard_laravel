<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Pemetaan WNA Kantor Imigrasi Kelas I TPI Cirebon</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-dark-blue: #1a237e;
            --secondary-dark-blue: #283593;
            --gold: #ffd700;
            --light-gold: #ffecb3;
            --white: #ffffff;
            --text-dark: #2c3e50;
        }

        body {
            background: var(--primary-dark-blue);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            position: relative;
            overflow: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 215, 0, 0.05);
        }
        
        .login-container {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(15px);
            border-radius: 20px;
            box-shadow: 
                0 20px 40px rgba(26, 35, 126, 0.2),
                0 0 0 1px rgba(255, 215, 0, 0.2);
            padding: 3rem;
            width: 100%;
            max-width: 450px;
            border: 2px solid var(--gold);
            position: relative;
            z-index: 1;
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .login-header h1 {
            color: var(--primary-dark-blue);
            font-weight: 700;
            margin-bottom: 0.5rem;
            font-size: 2rem;
            text-shadow: 0 2px 4px rgba(26, 35, 126, 0.1);
        }

        .login-header .fa-globe {
            color: var(--gold);
            margin-right: 10px;
            font-size: 2.2rem;
        }
        
        .login-header p {
            color: var(--text-dark);
            margin: 0;
            font-weight: 500;
        }
        
        .form-floating {
            margin-bottom: 1rem;
        }

        .form-control {
            border: 2px solid #e1e5e9;
            border-radius: 10px;
            padding: 0.8rem;
            transition: all 0.3s ease;
            background: var(--white);
        }

        .form-control:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 0.2rem rgba(255, 215, 0, 0.25);
            background: var(--white);
        }

        .form-floating > label {
            color: var(--text-dark);
            opacity: 0.7;
            padding-left: 0.75rem;
        }

        /* Override for icon inputs - labels should always be positioned right of icons */
        .icon-input .form-floating > label {
            padding-left: 4rem !important;
            color: rgba(44, 62, 80, 0.6);
            font-weight: 400;
            /* Keep labels visible and positioned right of icons at all times */
            transform: scale(1) translateY(0) translateX(0);
            position: absolute;
            top: 0;
            height: 100%;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
            opacity: 1;
            z-index: 5;
        }

        .form-floating:not(.icon-input) > .form-control:focus ~ label,
        .form-floating:not(.icon-input) > .form-control:not(:placeholder-shown) ~ label {
            opacity: 1;
            padding-left: 0.75rem;
        }

        .btn-primary {
            background: var(--primary-dark-blue);
            border: 2px solid var(--primary-dark-blue);
            border-radius: 10px;
            padding: 0.8rem 2rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            width: 100%;
            position: relative;
            overflow: hidden;
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(255, 215, 0, 0.4);
            transition: left 0.5s;
        }

        .btn-primary:hover::before {
            left: 100%;
        }

        .btn-primary:hover {
            background: var(--gold);
            border-color: var(--gold);
            color: var(--primary-dark-blue);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(255, 215, 0, 0.3);
        }

        .alert-danger {
            background: rgba(244, 67, 54, 0.1);
            border: 1px solid #f44336;
            border-radius: 10px;
            color: #d32f2f;
        }

        .demo-info {
            background: var(--light-gold);
            border: 1px solid var(--gold);
            border-radius: 10px;
            padding: 1rem;
            margin-top: 1.5rem;
            color: var(--primary-dark-blue);
        }

        .demo-info h6 {
            color: var(--primary-dark-blue);
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .feature-list {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.5rem;
            margin-top: 1rem;
        }

        .feature-item {
            display: flex;
            align-items: center;
            color: var(--text-dark);
            font-size: 0.85rem;
        }

        .feature-item i {
            color: var(--gold);
            margin-right: 0.5rem;
            width: 16px;
        }

        /* Loading animation */
        .btn-primary:disabled {
            opacity: 0.7;
        }

        .spinner-border-sm {
            color: var(--white);
        }

        /* Clean login form styles */
        .form-group {
            position: relative;
            margin-bottom: 2rem;
        }
        
        .icon-input i {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gold);
            z-index: 10;
            font-size: 1rem;
            transition: all 0.3s ease;
            pointer-events: none;
        }
        
        .icon-input .form-control {
            padding-left: 4rem;
            height: calc(3.5rem + 2px);
        }
        
        .icon-input .form-floating > label {
            padding-left: 4rem !important;
            color: rgba(44, 62, 80, 0.6);
            font-weight: 400;
            /* Keep labels visible and positioned right of icons at all times */
            transform: scale(1) translateY(0) translateX(0);
            position: absolute;
            top: 0;
            height: 100%;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
        }
        
        .icon-input .form-control:focus ~ i {
            color: var(--primary-dark-blue);
            transform: translateY(-50%) scale(1.1);
        }
        
        .icon-input .form-control:focus ~ label,
        .icon-input .form-control:not(:placeholder-shown) ~ label {
            color: var(--gold);
            font-weight: 500;
            padding-left: 4rem !important;
            /* When focused or filled, move label up but keep horizontal position */
            transform: scale(0.85) translateY(-1.2rem) translateX(0.15rem);
            line-height: 1;
            height: auto;
            display: block;
        }
        
        /* Clean input styling */
        .form-group input {
            width: 100%;
            padding: 1.2rem 1rem 1.2rem 3.5rem;
            border: 2px solid #e1e5e9;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: var(--white);
            color: var(--text-dark);
            outline: none;
            font-weight: 500;
        }

        .form-group input:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 4px rgba(255, 215, 0, 0.1);
            transform: translateY(-1px);
        }

        .form-group input::placeholder {
            color: rgba(44, 62, 80, 0.5);
            font-weight: 400;
        }
        
        .form-group .icon {
            position: absolute;
            left: 1.2rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gold);
            font-size: 1.1rem;
            transition: all 0.3s ease;
            z-index: 2;
        }

        .form-group input:focus ~ .icon {
            color: var(--primary-dark-blue);
            transform: translateY(-50%) scale(1.15);
        }

        .form-group.has-error input {
            border-color: #dc3545;
            box-shadow: 0 0 0 4px rgba(220, 53, 69, 0.1);
        }

        .form-group .invalid-feedback {
            display: block;
            margin-top: 0.5rem;
            font-size: 0.875rem;
            color: #dc3545;
            font-weight: 500;
        }

        /* Enhanced button styling */
        .btn-login {
            width: 100%;
            padding: 1.2rem 2rem;
            background: var(--primary-dark-blue);
            border: none;
            border-radius: 12px;
            color: var(--white);
            font-size: 1.1rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(26, 35, 126, 0.2);
            cursor: pointer;
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(255, 215, 0, 0.3);
            transition: left 0.6s ease;
        }

        .btn-login:hover::before {
            left: 100%;
        }

        .btn-login:hover {
            background: var(--gold);
            color: var(--primary-dark-blue);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255, 215, 0, 0.3);
        }

        .btn-login:active {
            transform: translateY(0);
            box-shadow: 0 4px 15px rgba(26, 35, 126, 0.2);
        }

        .btn-login i {
            margin-right: 0.5rem;
            transition: transform 0.3s ease;
        }

        .btn-login:hover i {
            transform: translateX(2px);
        }
        
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h1><i class="fas fa-globe"></i>SIMWNA</h1>
            <p>Sistem Pemetaan WNA</p>
            <p><small>Kantor Imigrasi Kelas I TPI Cirebon</small></p>
        </div>

        @if(session('error'))
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-triangle me-2"></i>
                {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.attempt') }}">
            @csrf
            
            <div class="form-group {{ $errors->has('username') ? 'has-error' : '' }}">
                <input type="text" 
                       id="username" 
                       name="username" 
                       placeholder="Enter your username"
                       value="{{ old('username') }}"
                       required>
                <i class="fas fa-user icon"></i>
                @error('username')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                <input type="password" 
                       id="password" 
                       name="password" 
                       placeholder="Enter your password"
                       required>
                <i class="fas fa-lock icon"></i>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn-login">
                <i class="fas fa-sign-in-alt"></i>
                Sign In
            </button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto-focus username field
        document.getElementById('username').focus();
        
        // Add subtle animations
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.querySelector('.login-container');
            container.style.opacity = '0';
            container.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                container.style.transition = 'all 0.6s ease';
                container.style.opacity = '1';
                container.style.transform = 'translateY(0)';
            }, 100);
        });
    </script>
</body>
</html>
