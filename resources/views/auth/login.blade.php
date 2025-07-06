<!-- filepath: resources/views/auth/login.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Aplikasi Penggajian Pertamina</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 4 CDN -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #e1251b 0%, #ffffff 100%);
            min-height: 100vh;
        }
        .login-container {
            margin-top: 80px;
        }
        .card {
            border-radius: 1rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }
        .btn-pertamina {
            background: #e1251b;
            border: none;
            color: #fff;
            font-weight: bold;
        }
        .btn-pertamina:hover {
            background: #ffffff;
            color: #e1251b;
            border: 1px solid #e1251b;
        }
        .pertamina-title {
            color: #e1251b;
            font-weight: bold;
            letter-spacing: 1px;
            margin-top: 20px;
            margin-bottom: 0;
        }
        .subtitle {
            color: #000;
            font-size: 15px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<div class="container login-container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card">
                <div class="text-center bg-white pt-4">
                    <h3 class="pertamina-title">APLIKASI GAJI</h3>
                    <div class="subtitle">PT PERTAMINA</div>
                </div>
                <div class="card-body p-4">
                    @if(session('status'))
                        <div class="alert alert-success">{{ session('status') }}</div>
                    @endif
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input id="email" type="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   name="email" value="{{ old('email') }}" required autofocus>
                            @error('email')
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mt-3">
                            <label for="password">Password</label>
                            <input id="password" type="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   name="password" required>
                            @error('password')
                                <span class="invalid-feedback d-block">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group form-check mt-3">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember">
                            <label class="form-check-label" for="remember">Ingat Saya</label>
                        </div>
                        <button type="submit" class="btn btn-pertamina btn-block mt-4">Login</button>
                    </form>
                </div>
            </div>
            <p class="text-center mt-3 text-white">&copy; {{ date('Y') }} PT Pertamina (Persero)</p>
        </div>
    </div>
</div>
</body>
</html>