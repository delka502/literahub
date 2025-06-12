<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>LiteraHub - Sistem Perpustakaan Online</title>
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

</head>
<body>
   <!-- Navbar with Admin Access -->
  <!-- Navbar with Admin Access -->
  <nav class="navbar navbar-expand-lg navbar-light sticky-top">
    <div class="container">
        <a class="navbar-brand animated-logo" href="#">
            <i class="fas fa-book-open me-2"></i>
            Litera<span>Hub</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="#">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#katalog">Katalog</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#layanan">Layanan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#tentang">Tentang Kami</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#kontak">Kontak</a>
                </li>
            </ul>
            
            @guest
                <!-- Tampilkan tombol login/register jika pengguna belum login -->
                <button class="btn btn-outline-primary me-2" onclick="window.location.href='{{ route('login') }}'">Masuk</button>
                <button class="btn btn-primary me-2" onclick="window.location.href='{{ route('register') }}'">Daftar</button>
                <button class="btn btn-secondary" onclick="window.location.href='{{ route('login_admin') }}'">Admin</button>
            @else
                <!-- Tampilkan dropdown profil jika pengguna sudah login -->
                <div class="dropdown">
                    <button class="btn btn-link dropdown-toggle profile-dropdown" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ Auth::user()->profile_photo_url ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name) }}" alt="Profile" class="rounded-circle profile-image" width="32" height="32">
                        <span class="ms-2 d-none d-md-inline">{{ Auth::user()->name }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                        <!-- Arahkan ke halaman profil -->
                        <li><a class="dropdown-item" href="{{ url('/profile') }}"><i class="fas fa-user me-2"></i>Profil Saya</a></li>
                        <li><a class="dropdown-item" href="{{ route('bookmarks') }}"><i class="fas fa-bookmark me-2"></i>Koleksi Saya</a></li>
                        <li><a class="dropdown-item" href="{{ route('history') }}"><i class="fas fa-history me-2"></i>Rak Buku</a></li>
                        
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item"><i class="fas fa-sign-out-alt me-2"></i>Keluar</button>
                            </form>
                        </li>
                    </ul>
                </div>
            @endguest
        </div>
    </div>
</nav>



<!-- CSS for profile dropdown -->
<style>
.profile-dropdown {
    display: flex;
    align-items: center;
    text-decoration: none;
    color: #333;
    padding: 5px 10px;
}

.profile-dropdown:hover, .profile-dropdown:focus {
    color: #0d6efd;
    text-decoration: none;
}

.profile-image {
    object-fit: cover;
    border: 2px solid #efefef;
}
</style>


            </div>
        </div>
    </div>
</div>


 <!-- Hero Section with Enhanced Animations -->
<section class="hero animate__animated animate__fadeIn">
    <div class="hero-overlay">
        <div class="container hero-content">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="display-4 fw-bold mb-3 text-light animate__animated animate__fadeInDown animate__delay-1s">Temukan Dunia dalam Buku</h1>
                    <p class="lead mb-4 text-light animate__animated animate__fadeInUp animate__delay-1s">Akses ribuan buku dari berbagai genre dan penulis terkenal. Pinjam buku dengan mudah dan cepat.</p>

                    <!-- Animated Search Bar -->
                    <div class="search-bar animate__animated animate__fadeInUp animate__delay-2s">
                        <div class="input-group">
                            <input type="text" id="search-input" class="form-control search-input" placeholder="Cari judul, penulis, atau kategori...">
                            <div class="d-grid d-sm-block ms-sm-2">
                                <button class="btn btn-primary search-button pulse-button" onclick="searchBooks()">
                                    <i class="fas fa-search me-2"></i>Cari Buku
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Floating Book Icons -->
                    <div class="floating-icons animate__animated animate__fadeIn animate__delay-3s">
                        <i class="fas fa-book floating-icon" style="--delay: 0s; --position: -20%;"></i>
                        <i class="fas fa-bookmark floating-icon" style="--delay: 0.5s; --position: 20%;"></i>
                        <i class="fas fa-glasses floating-icon" style="--delay: 1s; --position: -30%;"></i>
                        <i class="fas fa-feather-alt floating-icon" style="--delay: 1.5s; --position: 30%;"></i>
                        
                        <!-- Ikon tambahan -->
                        <i class="fas fa-lightbulb floating-icon" style="--delay: 2s; --position: -15%;"></i> <!-- Inspirasi -->
                        <i class="fas fa-pencil-alt floating-icon" style="--delay: 2.5s; --position: 25%;"></i> <!-- Menulis -->
                        <i class="fas fa-scroll floating-icon" style="--delay: 3s; --position: -25%;"></i> <!-- Manuskrip -->
                        <i class="fas fa-graduation-cap floating-icon" style="--delay: 3.5s; --position: 35%;"></i> <!-- Pendidikan -->
                        <i class="fas fa-quote-left floating-icon" style="--delay: 4s; --position: -10%;"></i> <!-- Kutipan -->
                        <i class="fas fa-atlas floating-icon" style="--delay: 4.5s; --position: 40%;"></i> <!-- Atlas/Buku Besar -->
                        <i class="fas fa-book-reader floating-icon" style="--delay: 5s; --position: -35%;"></i> <!-- Pembaca Buku -->
                        <i class="fas fa-university floating-icon" style="--delay: 5.5s; --position: 20%;"></i> <!-- Perpustakaan -->
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

 <section class="py-5" id="kategori">
    <!-- CSS untuk background image dan dekorasi kiri -->
    <style>
        /* #kategori {
            position: relative;
            background-color: #f8f9fa;
            overflow: hidden;
        } */
        
        /* Dekorasi banner di sebelah kiri */
       
        /* Tambahkan pola dekoratif pada banner */
        .category-decoration::before {
            content: "";
            position: absolute;
            right: 1150px;
            bottom: 20%;
            width: 220px;
            height: 220px;
            background-image: url('{{ asset('image/background.avif') }}'); /* Bisa diganti dengan dekorasi SVG Anda */
            background-size: contain;
            background-repeat: no-repeat;
            opacity: 0.7;
        }
        
        /* Teks pada banner dekorasi */
      
        
        /* Memastikan konten kategori berada di atas dan tergeser sedikit */
        #kategori .container {
            position: relative;
            z-index: 2;
        }
    </style>

    <div class="container">
        <div class="section-header text-center mb-5">
            <h2 class="section-title position-relative d-inline-block">Jelajahi Kategori</h2>
            <div class="title-decoration">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <p class="text-muted mt-3">Temukan koleksi buku yang sesuai dengan minat dan kebutuhan Anda</p>
        </div>
        
        <div class="row justify-content-center" style="margin-left: 40px;">
            <!-- Kategori Farmasi -->
            <div class="col-6 col-md-4 col-lg-2 mb-4">
                <div class="category-card-wrapper" onclick="fetchBooks('farmasi')">
                    <div class="category-card">
                        <div class="card-front">
                            <div class="category-icon">
                                <i class="fas fa-flask"></i>
                            </div>
                            <h5>Farmasi</h5>
                        </div>
                        <div class="card-back">
                            {{-- <p>Temukan buku-buku farmasi dan ilmu obat-obatan terlengkap</p> --}}
                            <div class="explore-btn">
                                <span>Lihat</span>
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Kategori Hukum -->
            <div class="col-6 col-md-4 col-lg-2 mb-4">
                <div class="category-card-wrapper" onclick="fetchBooks('hukum')">
                    <div class="category-card">
                        <div class="card-front">
                            <div class="category-icon">
                                <i class="fas fa-landmark"></i>
                            </div>
                            <h5>Hukum</h5>
                        </div>
                        <div class="card-back">
                            {{-- <p>Akses literatur hukum dan perundang-undangan terkini</p> --}}
                            <div class="explore-btn">
                                <span>Lihat</span>
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Kategori Informatika -->
            <div class="col-6 col-md-4 col-lg-2 mb-4">
                <div class="category-card-wrapper" onclick="fetchBooks('informatika')">
                    <div class="category-card">
                        <div class="card-front">
                            <div class="category-icon">
                                <i class="fas fa-code"></i>
                            </div>
                            <h5>Informatika</h5>
                        </div>
                        <div class="card-back">
                            {{-- <p>Pelajari dunia IT dan pemrograman dari berbagai sumber terpercaya</p> --}}
                            <div class="explore-btn">
                                <span>Lihat</span>
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Kategori Sastra -->
            <div class="col-6 col-md-4 col-lg-2 mb-4">
                <div class="category-card-wrapper" onclick="fetchBooks('sastra')">
                    <div class="category-card">
                        <div class="card-front">
                            <div class="category-icon">
                                <i class="fas fa-book"></i>
                            </div>
                            <h5>Sastra</h5>
                        </div>
                        <div class="card-back">
                            {{-- <p>Nikmati karya sastra dari penulis terkenal dalam dan luar negeri</p> --}}
                            <div class="explore-btn">
                                <span>Lihat</span>
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Kategori Kesehatan -->
            <div class="col-6 col-md-4 col-lg-2 mb-4">
                <div class="category-card-wrapper" onclick="fetchBooks('kesehatan')">
                    <div class="category-card">
                        <div class="card-front">
                            <div class="category-icon">
                                <i class="fas fa-heartbeat"></i>
                            </div>
                            <h5>Kesehatan</h5>
                        </div>
                        <div class="card-back">
                            {{-- <p>Akses berbagai buku medis dan kesehatan untuk meningkatkan kualitas hidup</p> --}}
                            <div class="explore-btn">
                                <span>Lihat</span>
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
    
 <section class="py-5 bg-light" id="katalog">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="section-title mb-0">Buku Terbaru</h2>
                <a href="#" class="btn btn-link text-decoration-none">Lihat Semua</a>
            </div>
            <div id="loading-bar" class="text-center my-4" style="display: none;">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p>Memuat data buku...</p>
            </div>
            <div class="row" id="book-list">
                <!-- Buku akan di-generate secara dinamis oleh script.js -->
            </div>
        </div>
    </section>
    

   <!-- Statistics Section with Animated Counters -->
<section class="py-5 bg-primary text-white" id="statistik">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <h2 class="section-title text-white">Statistik Perpustakaan</h2>
                <p class="lead mb-5">Lihatlah bagaimana kami terus berkembang untuk melayani Anda lebih baik</p>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-md-3">
                <div class="stats-card bg-white text-dark animate__animated animate__fadeInUp animate__delay-1s">
                    <div class="stats-icon mx-auto mb-3">
                        <i class="fas fa-book text-primary fa-3x"></i>
                    </div>
                    <div class="stats-number" data-count="15000">0</div>
                    <h5 class="mb-0">Total Koleksi Buku</h5>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card bg-white text-dark animate__animated animate__fadeInUp animate__delay-1s">
                    <div class="stats-icon mx-auto mb-3">
                        <i class="fas fa-users text-primary fa-3x"></i>
                    </div>
                    <div class="stats-number" data-count="3500">0</div>
                    <h5 class="mb-0">Anggota Aktif</h5>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card bg-white text-dark animate__animated animate__fadeInUp animate__delay-2s">
                    <div class="stats-icon mx-auto mb-3">
                        <i class="fas fa-exchange-alt text-primary fa-3x"></i>
                    </div>
                    <div class="stats-number" data-count="7520">0</div>
                    <h5 class="mb-0">Peminjaman Bulan Ini</h5>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card bg-white text-dark animate__animated animate__fadeInUp animate__delay-2s">
                    <div class="stats-icon mx-auto mb-3">
                        <i class="fas fa-award text-primary fa-3x"></i>
                    </div>
                    <div class="stats-number" data-count="125">0</div>
                    <h5 class="mb-0">Penulis Terkemuka</h5>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Enhanced Layanan Section with Visual Elements -->
<section class="py-5" id="layanan">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <h2 class="section-title">Layanan Perpustakaan Kami</h2>
                <p class="lead mb-5">Nikmati berbagai layanan yang memudahkan Anda mengakses pengetahuan</p>
            </div>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="service-card animate__animated animate__fadeInUp">
                    <div class="service-icon-wrapper">
                        <div class="service-icon">
                            <i class="fas fa-book"></i>
                        </div>
                    </div>
                    <h4 class="mb-3">Peminjaman Buku</h4>
                    <p class="text-muted">Pinjam buku favorit Anda dengan mudah melalui sistem peminjaman online yang cepat dan efisien.</p>
                    <a href="#" class="btn btn-sm btn-outline-primary mt-3">Pelajari Lebih Lanjut</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="service-card animate__animated animate__fadeInUp animate__delay-1s">
                    <div class="service-icon-wrapper">
                        <div class="service-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                    <h4 class="mb-3">Perpanjangan Online</h4>
                    <p class="text-muted">Perpanjang masa peminjaman buku Anda kapan saja dan di mana saja tanpa perlu datang ke perpustakaan.</p>
                    <a href="#" class="btn btn-sm btn-outline-primary mt-3">Pelajari Lebih Lanjut</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="service-card animate__animated animate__fadeInUp animate__delay-2s">
                    <div class="service-icon-wrapper">
                        <div class="service-icon">
                            <i class="fas fa-bell"></i>
                        </div>
                    </div>
                    <h4 class="mb-3">Notifikasi Pengingat</h4>
                    <p class="text-muted">Dapatkan pengingat saat batas waktu peminjaman Anda hampir berakhir untuk menghindari denda.</p>
                    <a href="#" class="btn btn-sm btn-outline-primary mt-3">Pelajari Lebih Lanjut</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="service-card animate__animated animate__fadeInUp">
                    <div class="service-icon-wrapper">
                        <div class="service-icon">
                            <i class="fas fa-search"></i>
                        </div>
                    </div>
                    <h4 class="mb-3">Pencarian Lanjutan</h4>
                    <p class="text-muted">Temukan buku yang tepat dengan fitur pencarian canggih berdasarkan judul, penulis, dan kategori.</p>
                    <a href="#" class="btn btn-sm btn-outline-primary mt-3">Pelajari Lebih Lanjut</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="service-card animate__animated animate__fadeInUp animate__delay-1s">
                    <div class="service-icon-wrapper">
                        <div class="service-icon">
                            <i class="fas fa-bookmark"></i>
                        </div>
                    </div>
                    <h4 class="mb-3">Bookmark & Wishlist</h4>
                    <p class="text-muted">Simpan buku favorit Anda untuk dibaca nanti atau tambahkan ke daftar keinginan untuk referensi masa depan.</p>
                    <a href="#" class="btn btn-sm btn-outline-primary mt-3">Pelajari Lebih Lanjut</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="service-card animate__animated animate__fadeInUp animate__delay-2s">
                    <div class="service-icon-wrapper">
                        <div class="service-icon">
                            <i class="fas fa-history"></i>
                        </div>
                    </div>
                    <h4 class="mb-3">Riwayat Peminjaman</h4>
                    <p class="text-muted">Akses riwayat peminjaman Anda untuk melacak buku yang pernah Anda baca di masa lalu.</p>
                    <a href="#" class="btn btn-sm btn-outline-primary mt-3">Pelajari Lebih Lanjut</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Additional CSS for the new sections -->
<style>
/* Statistics Section Styling */
.stats-card {
    border-radius: 16px;
    padding: 2rem;
    text-align: center;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    height: 100%;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
}

.stats-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
}

.stats-icon {
    width: 80px;
    height: 80px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1rem;
}

.stats-number {
    font-size: 3rem;
    font-weight: 700;
    color: var(--primary);
    margin-bottom: 0.5rem;
    line-height: 1;
}

/* Enhanced Service Cards */
.service-card {
    background-color: white;
    border-radius: 16px;
    padding: 2.5rem 2rem;
    height: 100%;
    text-align: center;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    position: relative;
    overflow: hidden;
    z-index: 1;
}

.service-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
}

.service-card:hover .service-icon {
    background-color: var(--primary);
    color: white;
    transform: scale(1.1);
}

.service-icon-wrapper {
    margin-bottom: 1.5rem;
    position: relative;
    display: inline-block;
}

.service-icon {
    width: 80px;
    height: 80px;
    background-color: var(--secondary);
    color: var(--primary);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    border-radius: 50%;
    margin: 0 auto;
    transition: all 0.3s ease;
    position: relative;
    z-index: 2;
}

.service-icon-wrapper::before {
    content: '';
    position: absolute;
    top: -5px;
    left: -5px;
    right: -5px;
    bottom: -5px;
    background: linear-gradient(135deg, var(--primary), var(--accent));
    border-radius: 50%;
    opacity: 0.3;
    z-index: 1;
    transform: scale(0.8);
    transition: transform 0.3s ease, opacity 0.3s ease;
}

.service-card:hover .service-icon-wrapper::before {
    transform: scale(1.2);
    opacity: 0.5;
}

.service-card::after {
    content: '';
    position: absolute;
    width: 100%;
    height: 5px;
    background: linear-gradient(90deg, var(--primary), var(--accent));
    bottom: 0;
    left: 0;
    transform: scaleX(0);
    transform-origin: right;
    transition: transform 0.5s ease;
}

.service-card:hover::after {
    transform: scaleX(1);
    transform-origin: left;
}

/* Animate.css additional delay classes */
.animate__delay-3s {
    animation-delay: 3s !important;
}

.animate__delay-4s {
    animation-delay: 4s !important;
}

/* Counter animation script */
@keyframes countUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Add some responsive adjustments */
@media (max-width: 768px) {
    .stats-card {
        margin-bottom: 1.5rem;
    }
    
    .stats-number {
        font-size: 2.5rem;
    }
    
    .service-card {
        margin-bottom: 2rem;
    }
}
</style>

<!-- JavaScript for Counter Animation -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Counter Animation for Statistics
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const counters = document.querySelectorAll('.stats-number');
                counters.forEach(counter => {
                    const targetValue = parseInt(counter.getAttribute('data-count'));
                    const duration = 2000; // Animation duration in milliseconds
                    let startValue = 0;
                    const increment = targetValue / (duration / 20);
                    
                    // Animate the counter
                    const updateCounter = () => {
                        startValue += increment;
                        counter.textContent = Math.floor(startValue);
                        
                        if (startValue < targetValue) {
                            setTimeout(updateCounter, 20);
                        } else {
                            counter.textContent = targetValue.toLocaleString();
                        }
                    };
                    
                    // Start animation
                    updateCounter();
                });
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });

    // Observe the statistics section
    const statsSection = document.querySelector('#statistik');
    if (statsSection) {
        observer.observe(statsSection);
    }
    
    // Add animation class when scrolling into view
    const serviceCards = document.querySelectorAll('.service-card');
    const serviceObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate__animated', 'animate__fadeInUp');
                serviceObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.2 });
    
    serviceCards.forEach(card => {
        serviceObserver.observe(card);
    });
});
</script>
<style>
    :root {
        --primary-color: #3498db;
        --secondary-color: #2980b9;
    }

    body {
        font-family: 'Arial', sans-serif;
    }

    .footer-modern {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        padding: 3rem 0;
        position: relative;
        overflow: hidden;
    }

    .footer-modern::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255,255,255,0.05);
        transform: skewY(-6deg);
        transform-origin: top left;
        z-index: 0;
    }

    .footer-content {
        position: relative;
        z-index: 1;
    }

    .footer-modern h5 {
        font-weight: 700;
        margin-bottom: 1rem;
        position: relative;
        padding-bottom: 0.5rem;
    }

    .footer-modern h5::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 50px;
        height: 3px;
        background-color: white;
    }

    .footer-modern .nav-link {
        color: rgba(255,255,255,0.7);
        transition: color 0.3s ease;
    }

    .footer-modern .nav-link:hover {
        color: white;
        transform: translateX(5px);
    }

    .social-icons a {
        color: white;
        margin-right: 1rem;
        font-size: 1.5rem;
        transition: all 0.3s ease;
    }

    .social-icons a:hover {
        color: rgba(255,255,255,0.7);
        transform: scale(1.2) rotate(360deg);
    }

    .footer-bottom {
        border-top: 1px solid rgba(255,255,255,0.1);
        padding-top: 1.5rem;
        margin-top: 2rem;
    }

    @media (max-width: 768px) {
        .footer-modern {
            text-align: center;
        }

        .footer-modern h5::after {
            left: 50%;
            transform: translateX(-50%);
        }

        .social-icons {
            justify-content: center;
        }
    }
</style>
<footer class="footer-modern">
    <div class="container footer-content">
        <div class="row">
            <!-- Tentang Kami -->
            <div class="col-md-4 mb-4">
                <h5>Tentang Kami</h5>
                <p>Perpustakaan Digital kami menyediakan akses mudah dan cepat ke berbagai koleksi buku dan literatur berkualitas secara online, membuka pintu pengetahuan untuk semua.</p>
            </div>

            <!-- Navigasi -->
            <div class="col-md-4 mb-4">
                <h5>Navigasi Cepat</h5>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="#" class="nav-link ps-0">
                            <i class="fas fa-home me-2"></i>Beranda
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link ps-0">
                            <i class="fas fa-book me-2"></i>Katalog Buku
                   </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link ps-0">
                            <i class="fas fa-exchange-alt me-2"></i>Pinjam Buku
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link ps-0">
                            <i class="fas fa-envelope me-2"></i>Kontak
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Sosial Media -->
            <div class="col-md-4 mb-4">
                <h5>Terhubung Bersama Kami</h5>
                <div class="social-icons d-flex">
                    <a href="#" class="me-3" title="Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="me-3" title="Twitter">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="me-3" title="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" title="LinkedIn">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="footer-bottom text-center">
            <p class="mb-0">
                &copy; 2025 Perpustakaan Digital. Hak Cipta Dilindungi.
                <span class="d-block mt-2 text-white-50">
                    Terbangun dengan <i class="fas fa-heart text-danger"></i> untuk berbagi pengetahuan
                </span>
            </p>
        </div>
    </div>
</footer>


<script src="{{asset('perpustakaan/index.js')}}"></script> <!-- File JavaScript eksternal -->
<script src="{{asset('perpustakaan/peminjaman.js')}}"></script> <!-- File JavaScript eksternal -->
@yield('content') {{-- profile akan masuk ke sini --}}
                    
</body>