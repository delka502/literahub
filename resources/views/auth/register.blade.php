<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gramedia - Registrasi</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #bdd7f0, hsl(204, 100%, 78%), #ffffff);
            background-size: 400% 400%;
            animation: GradientBackground 15s ease infinite;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            font-family: 'Arial', sans-serif;
        }

        @keyframes GradientBackground {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .register-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            overflow: hidden;
            max-width: 1000px;
        }

        .illustration-side {
            background-color: #f0f4f8;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px;
        }

        .illustration-side img {
            max-width: 100%;
            height: auto;
        }

        .register-form {
            padding: 40px 30px;
        }

        .register-form h2 {
            color: #333;
            margin-bottom: 25px;
            text-align: center;
        }

        .social-login .btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .social-login .btn i {
            font-size: 1.2em;
        }

        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 20px 0;
        }

        .divider::before, .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #ddd;
        }

        .divider span {
            padding: 0 10px;
            color: #888;
        }

        .google-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: white;
            border: 1px solid #ddd;
            color: #757575;
            font-weight: 500;
        }

        .google-btn img {
            width: 24px;
            margin-right: 10px;
        }

        @media (max-width: 768px) {
            .illustration-side {
                display: none;
            }
            .register-form {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card register-container">
                    <div class="row g-0">
                        <div class="col-md-6 illustration-side">
                            <img src="auth.d9706f79.avif" alt="Ilustrasi Membaca">
                        </div>

                        <div class="col-md-6">
                            <div class="register-form">
                                <h2>Buat Akun </h2>

                                {{-- Pesan sukses --}}
                                @if(session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                {{-- Tampilkan error validasi --}}
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('register.post') }}">
                                    @csrf

                                    <div class="mb-3">
                                        <input type="text" class="form-control" name="name" placeholder="Nama Lengkap" value="{{ old('name') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <input type="email" class="form-control" name="email" placeholder="Email" value="{{ old('email') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <input type="password" class="form-control" name="password" placeholder="Kata Sandi" required>
                                    </div>
                                    <div class="mb-3">
                                        <input type="password" class="form-control" name="password_confirmation" placeholder="Konfirmasi Kata Sandi" required>
                                    </div>

                                    <button type="submit" class="btn btn-secondary w-100 mb-3">Daftar</button>

                                    <div class="divider">
                                        <span>Atau Daftar Dengan</span>
                                    </div>

                                    <div class="social-login">
                                        <div class="row g-2">
                                            <div class="col-12 mb-2">
                                                <button type="button" class="btn google-btn w-100" id="googleRegister">
                                                    <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" alt="Google Logo">
                                                    Daftar dengan Google
                                                </button>
                                            </div>
                                            <div class="col-12 mb-2">
                                                <button type="button" class="btn btn-outline-secondary w-100" id="appleRegister">
                                                    <i class="fab fa-apple"></i> Daftar dengan Apple
                                                </button>
                                            </div>
                                            <div class="col-12">
                                                <button type="button" class="btn btn-outline-info w-100" id="facebookRegister">
                                                    <i class="fab fa-facebook"></i> Daftar dengan Facebook
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-center mt-3">
                                        <p class="small text-muted">
                                            Sudah punya akun? <a href="{{ route('login') }}" class="text-primary">Masuk</a>
                                        </p>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>