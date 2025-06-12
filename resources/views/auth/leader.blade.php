<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Perpustakaan Online - Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #1e3a8a, #3b82f6);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }
        
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url("/api/placeholder/1920/1080");
            background-size: cover;
            background-position: center;
            opacity: 0.1;
            z-index: -1;
        }
        
        .container {
            width: 100%;
            max-width: 450px;
            padding: 20px;
            z-index: 10;
        }
        
        .login-card {
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            position: relative;
        }
        
        .login-header {
            background-color: #1e40af;
            padding: 30px 20px;
            text-align: center;
            position: relative;
        }
        
        .login-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 20px;
            background: white;
            border-radius: 50% 50% 0 0 / 100% 100% 0 0;
        }
        
        .login-header h1 {
            color: white;
            font-size: 26px;
            margin-bottom: 8px;
            font-weight: 600;
        }
        
        .login-header p {
            color: rgba(255, 255, 255, 0.9);
            font-size: 14px;
        }
        
        .login-body {
            padding: 30px;
        }
        
        .form-group {
            margin-bottom: 24px;
            position: relative;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #374151;
            font-size: 14px;
        }
        
        .input-with-icon {
            position: relative;
        }
        
        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #6b7280;
        }
        
        .form-control {
            width: 100%;
            padding: 12px 15px 12px 45px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            font-size: 15px;
            transition: all 0.3s;
            background-color: #f9fafb;
        }
        
        .form-control:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
            background-color: white;
        }
        
        .form-check {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .form-check input {
            width: 16px;
            height: 16px;
            margin-right: 10px;
            accent-color: #2563eb;
        }
        
        .form-check label {
            font-size: 14px;
            color: #4b5563;
            margin-bottom: 0;
        }
        
        .btn {
            display: block;
            width: 100%;
            padding: 14px;
            background-color: #2563eb;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }
        
        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: 0.5s;
            z-index: -1;
        }
        
        .btn:hover {
            background-color: #1d4ed8;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(37, 99, 235, 0.4);
        }
        
        .btn:hover::before {
            left: 100%;
        }
        
        .forgot-password {
            text-align: center;
            margin-top: 24px;
        }
        
        .forgot-password a {
            color: #2563eb;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s;
        }
        
        .forgot-password a:hover {
            color: #1d4ed8;
            text-decoration: underline;
        }
        
        .admin-icon {
            width: 90px;
            height: 90px;
            background-color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
        }
        
        .admin-icon i {
            font-size: 40px;
            color: #1e40af;
        }
        
        .alert {
            padding: 12px 15px;
            background-color: #fee2e2;
            color: #b91c1c;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            font-size: 14px;
        }
        
        .alert i {
            margin-right: 10px;
            font-size: 16px;
        }
        
        .card-decoration {
            position: absolute;
            top: -30px;
            right: -30px;
            width: 150px;
            height: 150px;
            background-color: rgba(219, 234, 254, 0.4);
            border-radius: 50%;
            z-index: 0;
        }
        
        .card-decoration:nth-child(2) {
            bottom: -50px;
            left: -50px;
            top: auto;
            right: auto;
            width: 200px;
            height: 200px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-card">
            <div class="card-decoration"></div>
            <div class="card-decoration"></div>
            <div class="login-header">
                <div class="admin-icon">
                    <i class="fas fa-book-reader"></i>
                </div>
                <h1>Perpustakaan Digital</h1>
                <p>Panel Admin - Login untuk mengelola sistem</p>
            </div>
            <div class="login-body">
                @if($errors->any())
                    <div class="alert" id="loginAlert">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ $errors->first() }}
                    </div>
                @endif
                <form method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="username">Email Admin</label>
                        <div class="input-with-icon">
                            <i class="fas fa-envelope input-icon"></i>
                            <input type="email" name="email" class="form-control" id="username" placeholder="Masukkan email admin" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password">Kata Sandi</label>
                        <div class="input-with-icon">
                            <i class="fas fa-lock input-icon"></i>
                            <input type="password" name="password" class="form-control" id="password" placeholder="Masukkan kata sandi" required>
                        </div>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" id="remember">
                        <label for="remember">Ingat saya</label>
                    </div>
                    <button type="submit" class="btn">
                        <i class="fas fa-sign-in-alt" style="margin-right: 8px;"></i>
                        Masuk ke Dashboard
                    </button>
                </form>
                <div class="forgot-password">
                    <a href="#">Lupa kata sandi?</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>