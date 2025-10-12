<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url("{{ asset('images/bg-pattern.png') }}"); 
            background-size: cover;        
            background-position: center;   
            background-repeat: no-repeat;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }
        .login-container {
            display: flex;
            width: 900px;
            height: 550px;
            background-color: #fbe6d4;
            border-radius: 10px;
            box-shadow: 0 6px 25px 8px rgba(0, 0, 0, 0.15);
        }
        .login-left {
            background-color: #a20a0a; /* merah tua */
            border-top-left-radius: 10px;
            border-bottom-left-radius: 10px;
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 20px;
        }
        .login-left img {
            width: 90%;
            max-width: 300px;
        }
        .login-left .logo {
            width: 100px;
            margin-bottom: 10px;
        }
        .login-right {
            flex: 1.2;
            padding: 50px 60px;
            position: relative;
        }
        h2 {
            text-align: center;
            font-weight: 600;
            margin-bottom: 40px;
            margin-top: 20px;
        }
        .form-control {
            border-radius: 10px;
            padding: 10px;
        }
        .btn-login {
            background-color: #223a59;
            color: white;
            border-radius: 15px;
            padding: 10px;
            width: 100%;
            margin-top: 15px;
            font-size: 1.1rem;
        }
        .btn-login:hover {
            background-color: #a20a0a; /* merah tua */
            color: white;
        }
        .btn-back {
            display: block;
            width: 150px;
            margin: 40px auto 0;
            border-radius: 10px;
            padding: 8px 25px;
            color: #223a59;
            border: 1px solid #223a59;
            text-decoration: none;
            transition: 0.3s;
        }
        .btn-back:hover {
            background-color: #a20a0a;
            color: white;
            border-color: #a20a0a;
        }

        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
                width: 95%;
                height: auto;
            }
            .login-left {
                display: none;
            }
        }
    </style>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body>
    <div class="login-container">
        {{-- Bagian Kiri --}}
        <div class="login-left">
            <img src="{{ asset('images/librain-logo.png') }}" class="logo" alt="LIBRAIN Logo">
            <img src="{{ asset('images/login-illustration.png') }}" alt="Welcome Image">
        </div>

        {{-- Bagian Kanan --}}
        <div class="login-right">
            <h2>Log In</h2>

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form method="POST" action="/login">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-login">Login</button>
            </form>
            <a href="{{ url()->previous() }}" class="btn-back">⬅️ Kembali</a>
        </div>
    </div>
</body>
</html>
