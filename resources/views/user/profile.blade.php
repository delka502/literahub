<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pengguna</title>
    <!-- Tambahkan link ke Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
       <!-- Bootstrap CSS -->
       <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

       <!-- Animate.css -->
       <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
   
       <!-- Font Awesome (Opsional) -->
       <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
   
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
      <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
      <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
      <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('perpustakaan/index.css') }}" rel="stylesheet">
    @include('navbar_user')
</head>
<body>
    <!-- Navbar akan diinclude dari file terpisah -->
    
    <div class="container py-5 animate__animated animate__fadeIn">
        <div class="profile-header text-center text-md-start">
            <div class="row align-items-center">
                <div class="col-md-4 text-center mb-4 mb-md-0">
                    <div class="profile-img-container">
                        <img src="{{ Auth::user()->profile_photo_url ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=random' }}" alt="avatar"
                            class="profile-img rounded-circle img-fluid">
                    </div>
                </div>
                <div class="col-md-8">
                    <h2 class="fw-bold mb-1">{{ Auth::user()->name }}</h2>
                    <div class="mb-3">
                        <span class="badge-member mb-2 d-inline-block">
                            <i class="fas fa-user-check me-1"></i> Anggota Perpustakaan
                        </span>
                    </div>
                    <p class="text-light mb-3">
                        <i class="fas fa-id-card me-2"></i> ID: {{ Auth::user()->id }}
                    </p>
                    <button class="edit-button">
                        <i class="fas fa-edit me-2"></i> Edit Profil
                    </button>
                </div>
            </div>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="info-card card mb-4 animate__animated animate__fadeInLeft">
                    <div class="card-header py-3">
                        <h5 class="mb-0"><i class="fas fa-user-circle me-2"></i>Informasi Pribadi</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <p class="profile-data-label mb-0">Nama Lengkap</p>
                            </div>
                            <div class="col-sm-8">
                                <p class="profile-data-value mb-0">{{ Auth::user()->name }}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <p class="profile-data-label mb-0">Email</p>
                            </div>
                            <div class="col-sm-8">
                                <p class="profile-data-value mb-0">{{ Auth::user()->email }}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-4">
                                <p class="profile-data-label mb-0">Tanggal Bergabung</p>
                            </div>
                            <div class="col-sm-8">
                                <p class="profile-data-value mb-0">
                                    <i class="far fa-calendar-alt me-2"></i>
                                    {{ Auth::user()->created_at->format('d F Y') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
    
        <!-- Kartu Statistik Perpustakaan -->
        <div class="col-lg-6">
            <div class="info-card card mb-4 animate__animated animate__fadeInRight">
                <div class="card-header py-3">
                    <h5 class="mb-0"><i class="fas fa-book me-2"></i>Statistik Perpustakaan</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-6 text-center border-end">
                            <h3 class="fw-bold text-primary">{{ $jumlahDipinjam }}</h3>
                            <p class="text-muted">Buku Dipinjam</p>
                        </div>
                        <div class="col-6 text-center">
                            <h3 class="fw-bold text-success">{{ $jumlahDikembalikan }}</h3>
                            <p class="text-muted">Buku Dikembalikan</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row text-center">
                        <div class="col-12 mb-3">
                            <h5 class="text-muted">Status Keanggotaan</h5>
                            <h4 class="text-success"><i class="fas fa-check-circle me-2"></i>Aktif</h4>
                        </div>
                    </div>
                    <div class="text-center pt-2">
                        <button class="btn btn-secondary" onclick="window.location.href='{{ route('history') }}'">Riwayat Peminjaman</button>
                    </div>
                </div>
            </div>
        </div>
       
            <div class="col-12">
                <div class="info-card card mb-4 animate__animated animate__fadeInUp">
                    <div class="card-header py-3">
                        <h5 class="mb-0"><i class="fas fa-bell me-2"></i>Notifikasi Terbaru</h5>
                    </div>
                    <div class="card-body">
                        <div class="text-center py-4">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Anda tidak memiliki notifikasi terbaru</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .profile-header {
            background: linear-gradient(135deg, #007bff 0%, #0027b2 100%);
            color: white;
            border-radius: 15px;
            margin-bottom: 25px;
            padding: 30px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        }
        .profile-img-container {
            position: relative;
            margin-bottom: 1rem;
        }
        .profile-img {
            width: 180px;
            height: 180px;
            border: 5px solid white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease;
        }
        .profile-img:hover {
            transform: scale(1.05);
        }
        .info-card {
            border-radius: 15px;
            border: none;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease;
        }
        .info-card:hover {
            transform: translateY(-5px);
        }
        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #e9ecef;
            font-weight: 600;
            color: #495057;
        }
        .badge-member {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
            color: white;
            font-weight: 500;
            padding: 8px 15px;
            border-radius: 30px;
        }
        .profile-data-label {
            font-weight: 600;
            color: #495057;
        }
        .profile-data-value {
            color: #6c757d;
        }
        .edit-button {
            background: linear-gradient(135deg, #e8e8e8 0%, #edf8ff 100%);
            border: none;
            border-radius: 50px;
            padding: 10px 25px;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        .edit-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
            background: linear-gradient(135deg, #c4c4c4 0%, #ffffff 70%);
        }
    </style>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="{{asset('perpustakaan/index.js')}}"></script>
</body>
</html>
