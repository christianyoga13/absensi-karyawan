<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login - Sistem Absensi</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito:400,600,700" rel="stylesheet">

    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .login-card {
            border-radius: 20px;
            border: none;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
        }
        .login-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 20px 20px 0 0;
            color: white;
            padding: 2rem;
            text-align: center;
        }
        .login-body {
            padding: 2.5rem;
        }
        .form-control {
            border-radius: 12px;
            border: 2px solid #e9ecef;
            padding: 12px 16px;
            font-size: 16px;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 12px;
            padding: 12px 24px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        .input-group-text {
            border-radius: 12px 0 0 12px;
            border: 2px solid #e9ecef;
            border-right: none;
            background-color: #f8f9fa;
        }
        .input-group .form-control {
            border-radius: 0 12px 12px 0;
            border-left: none;
        }
        .input-group:focus-within .input-group-text {
            border-color: #667eea;
            background-color: #667eea;
            color: white;
        }
        .input-group:focus-within .form-control {
            border-color: #667eea;
        }
        .logo-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.9;
        }
        .alert {
            border-radius: 12px;
            border: none;
        }
        .forgot-password {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .forgot-password:hover {
            color: #764ba2;
            text-decoration: underline;
        }
        .login-footer {
            text-align: center;
            color: #6c757d;
            padding: 1rem;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7 col-sm-9">
                <div class="card login-card">
                    <div class="login-header">
                        <i class="bi bi-clock-history logo-icon"></i>
                        <h3 class="mb-0">Sistem Absensi</h3>
                        <p class="mb-0 mt-2 opacity-75">Masuk ke akun Anda</p>
                    </div>
                    
                    <div class="login-body">
                        @if (session('error'))
                            <div class="alert alert-danger d-flex align-items-center mb-4" role="alert">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                <div>{{ session('error') }}</div>
                            </div>
                        @endif

                        @if (session('success'))
                            <div class="alert alert-success d-flex align-items-center mb-4" role="alert">
                                <i class="bi bi-check-circle-fill me-2"></i>
                                <div>{{ session('success') }}</div>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            
                            <div class="mb-4">
                                <label for="email" class="form-label fw-semibold">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-envelope"></i>
                                    </span>
                                    <input type="email" 
                                           class="form-control @error('email') is-invalid @enderror" 
                                           id="email" 
                                           name="email" 
                                           value="{{ old('email') }}" 
                                           placeholder="Masukkan email Anda"
                                           required 
                                           autofocus>
                                </div>
                                @error('email')
                                    <div class="text-danger mt-1 small">
                                        <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label fw-semibold">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-lock"></i>
                                    </span>
                                    <input type="password" 
                                           class="form-control @error('password') is-invalid @enderror" 
                                           id="password" 
                                           name="password" 
                                           placeholder="Masukkan password Anda"
                                           required>
                                    <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                                        <i class="bi bi-eye" id="togglePasswordIcon"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="text-danger mt-1 small">
                                        <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">
                                        Ingat saya
                                    </label>
                                </div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="bi bi-box-arrow-in-right me-2"></i>Masuk
                                </button>
                            </div>
                        </form>

                        <div class="text-center mt-4">
                            <a href="#" class="forgot-password">Lupa password?</a>
                        </div>

                        <div class="mt-4 p-3" style="background-color: #f8f9fa; border-radius: 12px; border-left: 4px solid #667eea;">
                            <h6 class="text-muted mb-3"><i class="bi bi-info-circle me-2"></i>Demo Login:</h6>
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <strong class="text-primary">Admin:</strong><br>
                                    <small class="text-muted">
                                        Email: admin@absensi.com<br>
                                        Password: admin123
                                    </small>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <strong class="text-success">User:</strong><br>
                                    <small class="text-muted">
                                        Email: user@absensi.com<br>
                                        Password: user123
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="login-footer">
                        <div class="mt-3">
                            <small>&copy; {{ date('Y') }} Sistem Absensi. All rights reserved.</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('togglePasswordIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('bi-eye');
                toggleIcon.classList.add('bi-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('bi-eye-slash');
                toggleIcon.classList.add('bi-eye');
            }
        });

        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);

        document.querySelector('form').addEventListener('submit', function(e) {
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            
            if (!email || !password) {
                e.preventDefault();
                
                if (!email) {
                    document.getElementById('email').classList.add('is-invalid');
                }
                if (!password) {
                    document.getElementById('password').classList.add('is-invalid');
                }
            }
        });

        document.getElementById('email').addEventListener('input', function() {
            this.classList.remove('is-invalid');
        });

        document.getElementById('password').addEventListener('input', function() {
            this.classList.remove('is-invalid');
        });
    </script>
</body>
</html>
