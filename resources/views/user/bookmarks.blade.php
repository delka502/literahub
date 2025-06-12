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
    <div class="container py-5 animate__animated animate__fadeIn">
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="mb-0"><i class="fas fa-book-bookmark me-2"></i>Koleksi Buku Saya</h2>
                    <p class="mb-0 mt-2">Temukan dan kelola buku-buku favorit Anda</p>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <button class="btn btn-light rounded-pill">
                        <i class="fas fa-sort me-2"></i>Urutkan
                    </button>
                    <button class="btn btn-light rounded-pill ms-2">
                        <i class="fas fa-filter me-2"></i>Filter
                    </button>
                </div>
            </div>
        </div>
        
        <div class="filter-controls animate__animated animate__fadeInDown">
            <div class="row">
                <div class="col-md-8">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" placeholder="Cari buku dalam koleksi...">
                    </div>
                </div>
                <div class="col-md-4">
                    <select class="form-select">
                        <option selected>Semua Kategori</option>
                        <option>Novel</option>
                        <option>Fiksi</option>
                        <option>Sains</option>
                        <option>Sejarah</option>
                    </select>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-3 mb-4">
                <div class="stats-card animate__animated animate__fadeInLeft">
                    <div class="d-flex align-items-center mb-3">
                        <i class="fas fa-book fa-2x text-primary me-3"></i>
                        <div>
                            <h5 class="mb-0">Total Koleksi</h5>
                            <span class="stats-number">3</span>
                        </div>
                    </div>
                    <div class="progress" style="height: 8px;">
                        <div class="progress-bar" role="progressbar" style="width: 30%;" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="text-muted mt-2">
                        <small>30% dari target 10 buku</small>
                    </div>
                </div>
            </div>
            
            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <div class="book-card card h-100 animate__animated animate__fadeIn">
                            <div class="position-relative overflow-hidden">
                                <img src="/api/placeholder/200/300" class="card-img-top book-cover" alt="Cover Buku">
                                <span class="position-absolute top-0 end-0 m-2 badge bg-danger">Baru</span>
                            </div>
                            <div class="card-body">
                                <h5 class="book-title">Laskar Pelangi</h5>
                                <p class="book-author mb-2">
                                    <i class="fas fa-user-edit me-1"></i> Andrea Hirata
                                </p>
                                <span class="book-category badge-novel">Novel</span>
                                <p class="book-date">
                                    <i class="far fa-calendar-alt me-1"></i> Ditambahkan pada: 18 April 2025
                                </p>
                                <div class="d-flex justify-content-between">
                                    <a href="#" class="btn btn-action btn-detail">
                                        <i class="fas fa-info-circle me-1"></i> Detail
                                    </a>
                                    <a href="#" class="btn btn-action btn-remove">
                                        <i class="fas fa-trash-alt me-1"></i> Hapus
                                    </a>
                                </div>
                            </div>
                            <div class="card-footer bg-white border-top-0">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-star text-warning me-1"></i>
                                    <small class="text-muted">4.7/5 (254 ulasan)</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4 mb-4">
                        <div class="book-card card h-100 animate__animated animate__fadeIn" style="animation-delay: 0.2s">
                            <div class="position-relative overflow-hidden">
                                <img src="/api/placeholder/200/300" class="card-img-top book-cover" alt="Cover Buku">
                            </div>
                            <div class="card-body">
                                <h5 class="book-title">Bumi Manusia</h5>
                                <p class="book-author mb-2">
                                    <i class="fas fa-user-edit me-1"></i> Pramoedya Ananta Toer
                                </p>
                                <span class="book-category badge-fiction">Fiksi</span>
                                <p class="book-date">
                                    <i class="far fa-calendar-alt me-1"></i> Ditambahkan pada: 15 April 2025
                                </p>
                                <div class="d-flex justify-content-between">
                                    <a href="#" class="btn btn-action btn-detail">
                                        <i class="fas fa-info-circle me-1"></i> Detail
                                    </a>
                                    <a href="#" class="btn btn-action btn-remove">
                                        <i class="fas fa-trash-alt me-1"></i> Hapus
                                    </a>
                                </div>
                            </div>
                            <div class="card-footer bg-white border-top-0">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-star text-warning me-1"></i>
                                    <small class="text-muted">4.9/5 (342 ulasan)</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4 mb-4">
                        <div class="book-card card h-100 animate__animated animate__fadeIn" style="animation-delay: 0.4s">
                            <div class="position-relative overflow-hidden">
                                <img src="/api/placeholder/200/300" class="card-img-top book-cover" alt="Cover Buku">
                            </div>
                            <div class="card-body">
                                <h5 class="book-title">A Brief History of Time</h5>
                                <p class="book-author mb-2">
                                    <i class="fas fa-user-edit me-1"></i> Stephen Hawking
                                </p>
                                <span class="book-category badge-science">Sains</span>
                                <p class="book-date">
                                    <i class="far fa-calendar-alt me-1"></i> Ditambahkan pada: 10 April 2025
                                </p>
                                <div class="d-flex justify-content-between">
                                    <a href="#" class="btn btn-action btn-detail">
                                        <i class="fas fa-info-circle me-1"></i> Detail
                                    </a>
                                    <a href="#" class="btn btn-action btn-remove">
                                        <i class="fas fa-trash-alt me-1"></i> Hapus
                                    </a>
                                </div>
                            </div>
                            <div class="card-footer bg-white border-top-0">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-star text-warning me-1"></i>
                                    <small class="text-muted">4.5/5 (187 ulasan)</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row mt-4">
            <div class="col-12">
                <div class="stats-card animate__animated animate__fadeInUp">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <p class="mb-0 d-flex align-items-center">
                                <i class="fas fa-book-open me-2 text-success"></i>
                                <span>Total buku dalam koleksi: <strong>3</strong></span>
                            </p>
                        </div>
                        <div class="col-md-6 text-md-end mt-3 mt-md-0">
                            <a href="#" class="btn btn-primary rounded-pill">
                                <i class="fas fa-plus me-2"></i>Tambah Buku Baru
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Pagination -->
        <div class="row mt-4">
            <div class="col-12">
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="{{asset('perpustakaan/index.js')}}"></script>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .page-header {
            background: linear-gradient(135deg, #007bff 0%, #0027b2 100%);
            color: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .book-card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.07);
            transition: all 0.3s ease;
        }
        
        .book-card:hover {
            transform: translateY(-7px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        
        .book-cover {
            height: 250px;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        
        .book-card:hover .book-cover {
            transform: scale(1.05);
        }
        
        .book-title {
            font-weight: 600;
            margin-bottom: 10px;
            color: #343a40;
            height: 50px;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }
        
        .book-author {
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 15px;
        }
        
        .book-date {
            color: #adb5bd;
            font-size: 0.8rem;
            margin-bottom: 15px;
        }
        
        .book-category {
            display: inline-block;
            padding: 3px 12px;
            border-radius: 30px;
            font-size: 0.75rem;
            font-weight: 600;
            margin-bottom: 15px;
        }
        
        .btn-action {
            border-radius: 50px;
            font-size: 0.85rem;
            padding: 8px 16px;
            margin-right: 5px;
            transition: all 0.3s ease;
        }
        
        .btn-detail {
            background-color: #007bff;
            border-color: #007bff;
        }
        
        .btn-detail:hover {
            background-color: #0069d9;
            border-color: #0062cc;
            transform: translateY(-2px);
        }
        
        .btn-remove {
            color: #dc3545;
            border-color: #dc3545;
        }
        
        .btn-remove:hover {
            color: #fff;
            background-color: #dc3545;
            border-color: #dc3545;
            transform: translateY(-2px);
        }
        
        .filter-controls {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }
        
        .stats-card {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }
        
        .stats-number {
            font-size: 2rem;
            font-weight: 700;
            color: #007bff;
        }
        
        .empty-collection {
            text-align: center;
            padding: 40px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }
        
        .badge-fiction {
            background-color: #e9ecef;
            color: #495057;
        }
        
        .badge-novel {
            background-color: #d4edda;
            color: #155724;
        }
        
        .badge-science {
            background-color: #cce5ff;
            color: #004085;
        }
    </style>
</body>
</html>l