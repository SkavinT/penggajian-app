<!-- filepath: resources/views/welcome.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang</title>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:700,400&display=swap" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #e1251b 0%, #fff 100%);
            min-height: 100vh;
            margin: 0;
            font-family: 'Montserrat', Arial, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .container {
            background: #fff;
            padding: 3rem 2.5rem;
            border-radius: 18px;
            box-shadow: 0 8px 32px rgba(44, 62, 80, 0.15);
            text-align: center;
            border-top: 10px solid #e1251b;
        }
        h1 {
            color: #e1251b;
            margin-bottom: 2.5rem;
            font-size: 2.2rem;
            font-weight: 700;
        }
        .btn-group {
            display: flex;
            gap: 20px;
            justify-content: center;
            margin-top: 24px;
        }
        .btn-login, .btn-register {
            flex: 1 1 0;
            max-width: 160px;
            padding: 0.75rem 0;
            border-radius: 30px;
            font-size: 1.1rem;
            font-weight: 600;
            text-decoration: none;
            border: 2px solid #e1251b;
            box-shadow: 0 2px 8px rgba(44, 62, 80, 0.10);
            transition: background 0.2s, color 0.2s, box-shadow 0.2s;
            text-align: center;
            display: inline-block;
        }
        .btn-login {
            background: linear-gradient(90deg, #e1251b 60%, #fff 100%);
            color: #fff;
        }
        .btn-login:hover {
            background: #e1251b;
            color: #fff;
            box-shadow: 0 4px 16px rgba(44, 62, 80, 0.18);
        }
        .btn-register {
            background: linear-gradient(90deg, #fff 60%, #e1251b 100%);
            color: #e1251b;
        }
        .btn-register:hover {
            background: #e1251b;
            color: #fff;
            box-shadow: 0 4px 16px rgba(44, 62, 80, 0.18);
        }
        @media (max-width: 500px) {
            .btn-group {
                flex-direction: column;
                gap: 12px;
            }
            .btn-login, .btn-register {
                max-width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="https://logowik.com/content/uploads/images/pertamina2579.jpg" alt="Logo Pertamina" style="width:140px; margin-bottom: 24px;">
        <h1>Selamat Datang di<br>Aplikasi Penggajian</h1>
        <div class="btn-group">
            <a href="{{ route('login') }}" class="btn-login">Login</a>
            <a href="{{ route('register') }}" class="btn-register">Register</a>
        </div>
    </div>
</body>
</html>