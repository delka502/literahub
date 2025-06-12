<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Profil Pengguna</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <link href="{{ asset('perpustakaan/index.css') }}" rel="stylesheet">
    <link href="{{ asset('perpustakaan/history.css') }}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @include('navbar_user')
</head>
<body>
    <style>
        /* Card Styling */
        .book-card {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.06);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            overflow: hidden;
            position: relative;
            margin-bottom: 20px;
        }
        
        .book-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .book-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 12px 40px rgba(0,0,0,0.12);
        }
        
        .book-card:hover::before {
            opacity: 1;
        }
        
        .book-cover-container {
            position: relative;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 6px 20px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        
        .book-card:hover .book-cover-container {
            transform: scale(1.05);
        }
        
        .book-cover {
            width: 100%;
            height: 180px;
            object-fit: cover;
            transition: all 0.3s ease;
        }
        
        .book-cover-placeholder {
            width: 100%;
            height: 180px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 12px;
        }
        
        .book-title {
            font-weight: 700;
            font-size: 1.1rem;
            color: #2d3748;
            line-height: 1.3;
            margin-bottom: 8px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .book-author {
            color: #718096;
            font-size: 0.9rem;
            font-weight: 500;
            margin-bottom: 12px;
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .loan-info {
            background: rgba(102, 126, 234, 0.05);
            border-radius: 10px;
            padding: 12px;
            margin-bottom: 15px;
            border-left: 4px solid #667eea;
        }
        
        .loan-info-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 6px;
        }
        
        .loan-info-item:last-child {
            margin-bottom: 0;
        }
        
        .loan-info-label {
            font-size: 0.8rem;
            color: #718096;
            font-weight: 500;
        }
        
        .loan-info-value {
            font-size: 0.85rem;
            color: #2d3748;
            font-weight: 600;
        }
        
        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        
        .status-dipinjam {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .status-dikembalikan {
            background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
            color: white;
        }
        
        .status-terlambat {
            background: linear-gradient(135deg, #f56565 0%, #e53e3e 100%);
            color: white;
        }
        
        .card-actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }
        
        .action-btn {
            flex: 1;
            min-width: 120px;
            padding: 10px 16px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.85rem;
            border: none;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .action-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s ease;
        }
        
        .action-btn:hover::before {
            left: 100%;
        }
        
        .btn-detail {
            background: linear-gradient(135deg, #4299e1 0%, #3182ce 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(66, 153, 225, 0.3);
        }
        
        .btn-detail:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(66, 153, 225, 0.4);
            color: white;
        }
        
        .btn-read {
            background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(72, 187, 120, 0.3);
        }
        
        .btn-read:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(72, 187, 120, 0.4);
            color: white;
        }
        
        .btn-return {
            background: linear-gradient(135deg, #f56565 0%, #e53e3e 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(245, 101, 101, 0.3);
        }
        
        .btn-return:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(245, 101, 101, 0.4);
            color: white;
        }
        
        .progress-indicator {
            height: 6px;
            background: #e2e8f0;
            border-radius: 3px;
            overflow: hidden;
            margin-top: 10px;
        }
        
        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
            border-radius: 3px;
            transition: width 1s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .progress-fill.overdue {
            background: linear-gradient(90deg, #f56565 0%, #e53e3e 100%);
        }
        
        .progress-fill.completed {
            background: linear-gradient(90deg, #48bb78 0%, #38a169 100%);
        }
        
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
            border-radius: 20px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        }
        
        .empty-state-icon {
            font-size: 4rem;
            color: #cbd5e0;
            margin-bottom: 20px;
        }
        
        .empty-state-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 10px;
        }
        
        .empty-state-subtitle {
            color: #718096;
            font-size: 1rem;
            margin-bottom: 30px;
        }
        
        .search-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 30px;
            border-radius: 25px;
            font-weight: 600;
            border: none;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
            transition: all 0.3s ease;
        }
        
        .search-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
            color: white;
        }
        
        .page-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 8px 32px rgba(102, 126, 234, 0.2);
        }
        
        .page-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 10px;
        }
        
        .page-subtitle {
            opacity: 0.9;
            font-size: 1.1rem;
        }
        
        /* Modal Styling */
        .timeline-badge {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            box-shadow: 0 3px 6px rgba(0,0,0,0.1);
        }
        
        .loan-detail-card {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.04);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        
        .loan-detail-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.08);
        }
        
        .loan-detail-card h6 {
            font-size: 0.8rem;
            margin-bottom: 5px;
            font-weight: 600;
        }
        
        .book-cover-modal-placeholder {
            background-color: #f5f5f5;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
            transition: transform 0.2s;
        }
        
        .book-cover-modal-placeholder:hover {
            transform: scale(1.02);
        }
        
        .timeline-item {
            position: relative;
            padding-bottom: 15px;
        }
        
        .timeline-item:not(:last-child):after {
            content: '';
            position: absolute;
            left: 18px;
            top: 36px;
            height: calc(100% - 36px);
            width: 2px;
            background-color: #e9ecef;
        }
        
        .timeline-content {
            flex: 1;
        }
        
        .progress {
            overflow: visible;
            border-radius: 10px;
            background-color: #e9ecef;
            box-shadow: inset 0 1px 3px rgba(0,0,0,0.1);
        }
        
        .progress-bar {
            border-radius: 10px;
            position: relative;
            transition: width 1s ease;
        }
        
        .modal-content {
            border-radius: 12px;
            overflow: hidden;
        }
        
        .modal-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #eaeaea;
        }
        
        .loan-progress-container {
            margin-top: 15px;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .book-card {
                margin-bottom: 15px;
            }
            
            .card-actions {
                flex-direction: column;
            }
            
            .action-btn {
                min-width: auto;
                width: 100%;
            }
            
            .page-header {
                padding: 20px;
                text-align: center;
            }
            
            .page-title {
                font-size: 1.5rem;
            }
        }
        
        /* Animation Classes */
        .fade-in-up {
            animation: fadeInUp 0.6s ease forwards;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .stagger-animation {
            animation-delay: calc(var(--stagger) * 0.1s);
        }
    </style>

    <div class="container py-4">
        <!-- Page Header -->
        <div class="page-header fade-in-up">
            <h1 class="page-title">
                <i class="fas fa-history me-3"></i>
                Riwayat Peminjaman Buku
            </h1>
            <p class="page-subtitle mb-0">Kelola dan pantau semua aktivitas peminjaman buku Anda</p>
        </div>

        @if(count($peminjaman) > 0)
            <div class="row">
                @foreach($peminjaman as $index => $item)
                    <div class="col-lg-4 col-md-6 col-sm-12 fade-in-up stagger-animation" style="--stagger: {{ $index }}">
                        <div class="card book-card">
                            <div class="card-body p-4">
                                <!-- Book Cover -->
                                <div class="book-cover-container mb-3">
                                    <div class="book-cover-placeholder" id="cover-{{ $item->id }}">
                                        <i class="fas fa-book fa-2x"></i>
                                    </div>
                                </div>
                                
                                <!-- Book Info -->
                                <h5 class="book-title">{{ $item->book_title }}</h5>
                                <p class="book-author">
                                    <i class="fas fa-user-edit me-1"></i>
                                    {{ $item->book_authors }}
                                </p>
                                
                                <!-- Loan Information -->
                                <div class="loan-info">
                                    <div class="loan-info-item">
                                        <span class="loan-info-label">
                                            <i class="fas fa-calendar-plus me-1"></i>
                                            Dipinjam
                                        </span>
                                        <span class="loan-info-value">
                                            {{ \Carbon\Carbon::parse($item->borrow_date)->format('d M Y') }}
                                        </span>
                                    </div>
                                    <div class="loan-info-item">
                                        <span class="loan-info-label">
                                            <i class="fas fa-calendar-check me-1"></i>
                                            Jatuh Tempo
                                        </span>
                                        <span class="loan-info-value">
                                            {{ \Carbon\Carbon::parse($item->return_date)->format('d M Y') }}
                                        </span>
                                    </div>
                                    
                                    <!-- Progress Indicator -->
                                    <div class="progress-indicator" id="progress-{{ $item->id }}">
                                        <div class="progress-fill" style="width: 0%"></div>
                                    </div>
                                </div>
                                
                                <!-- Status Badge -->
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span class="status-badge status-{{ strtolower(str_replace(' ', '', $item->getReturnStatus() === 'Dikembalikan' ? 'dikembalikan' : ($item->getReturnStatus() === 'Terlambat' ? 'terlambat' : 'dipinjam'))) }}">
                                        <i class="fas fa-{{ $item->getReturnStatus() === 'Dikembalikan' ? 'check' : ($item->getReturnStatus() === 'Terlambat' ? 'exclamation-triangle' : 'clock') }} me-1"></i>
                                        {{ $item->getReturnStatus() }}
                                    </span>
                                    @if($item->getReturnStatus() !== 'Dikembalikan')
                                        <small class="text-muted" id="days-info-{{ $item->id }}">
                                            <!-- Days info will be populated by JavaScript -->
                                        </small>
                                    @endif
                                </div>
                                
                                <!-- Action Buttons -->
                                <div class="card-actions">
                                    <button class="action-btn btn-detail view-details" 
                                            data-id="{{ $item->id }}"
                                            data-title="{{ $item->book_title }}"
                                            data-author="{{ $item->book_authors }}"
                                            data-isbn="{{ $item->book_isbn ?? 'N/A' }}"
                                            data-borrow-date="{{ $item->borrow_date }}" 
                                            data-return-date="{{ $item->return_date }}"
                                            data-status="{{ $item->getReturnStatus() }}"
                                            data-purpose="{{ $item->purpose ?? 'Tidak disebutkan' }}"
                                            data-bs-toggle="modal"
                                            data-bs-target="#detailModal">
                                        <i class="fas fa-eye me-1"></i>
                                        Detail
                                    </button>
                                    
                                    <button class="action-btn btn-read read-book" 
                                            data-title="{{ $item->book_title }}"
                                            data-author="{{ $item->book_authors }}"
                                            data-isbn="{{ $item->book_isbn ?? '' }}">
                                        <i class="fas fa-book-open me-1"></i>
                                        Baca
                                    </button>
                                    
                                    @if($item->getReturnStatus() !== 'Dikembalikan')
                                        <form action="{{ route('peminjaman.kembalikan', $item->id) }}" method="POST" class="d-inline w-100" onsubmit="return confirm('Yakin ingin mengembalikan buku ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-btn btn-return">
                                                <i class="fas fa-undo me-1"></i>
                                                Kembalikan
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state fade-in-up">
                <div class="empty-state-icon">
                    <i class="fas fa-book-open"></i>
                </div>
                <h3 class="empty-state-title">Belum Ada Riwayat Peminjaman</h3>
                <p class="empty-state-subtitle">Mulai jelajahi koleksi buku kami dan buat riwayat peminjaman pertama Anda!</p>
                <a href="{{ route('books') }}" class="search-btn">
                    <i class="fas fa-search me-2"></i>
                    Jelajahi Buku
                </a>
            </div>
        @endif
    </div>
    
    <!-- Modal Detail Peminjaman -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">Detail Peminjaman</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="book-cover-modal-placeholder rounded shadow-sm animate__animated animate__fadeIn" style="height: 180px;">
                                <img class="book-cover-img" src="" alt="Book Cover" style="max-width: 100%; max-height: 100%; object-fit: cover; display: none;">
                                <i class="fas fa-book fa-3x text-muted book-placeholder-icon"></i>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h5 class="book-title mb-2 animate__animated animate__fadeIn">-</h5>
                            <p class="book-author text-muted mb-2 animate__animated animate__fadeIn">-</p>
                            <p class="book-isbn mb-3 animate__animated animate__fadeIn"><small class="text-muted">ISBN: -</small></p>
                            
                            <div class="loan-progress-container animate__animated animate__fadeIn">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="text-muted small">Periode Peminjaman</span>
                                    <span class="loan-progress-text small">-</span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mb-3 animate__animated animate__fadeIn">
                        <div class="col-md-6">
                            <div class="loan-detail-card mb-3">
                                <h6 class="text-muted">TANGGAL PINJAM</h6>
                                <p class="borrow-date mb-0">-</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="loan-detail-card mb-3">
                                <h6 class="text-muted">TANGGAL KEMBALI</h6>
                                <p class="return-date mb-0">-</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="loan-detail-card mb-3">
                                <h6 class="text-muted">STATUS</h6>
                                <p class="status mb-0">-</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="loan-detail-card mb-3">
                                <h6 class="text-muted">TUJUAN PEMINJAMAN</h6>
                                <p class="purpose mb-0">-</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="timeline mt-4 animate__animated animate__fadeIn">
                        <h6 class="mb-3">Riwayat Aktivitas</h6>
                        <div class="timeline-items">
                            <!-- Timeline items will be populated by JavaScript -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success read-book-modal" style="display: none;">
                        <i class="fas fa-book-open me-1"></i> Baca Buku
                    </button>
                    <button type="button" class="btn btn-primary extend-loan" style="display: none;">Perpanjang Peminjaman</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Pilihan Baca Buku -->
    <div class="modal fade" id="readBookModal" tabindex="-1" aria-labelledby="readBookModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="readBookModalLabel">Pilih Cara Membaca</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-3">
                        <h6 class="read-book-title">-</h6>
                        <p class="text-muted read-book-author">-</p>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button class="btn btn-primary google-books-link" type="button">
                            <i class="fab fa-google me-2"></i> Baca di Google Books
                        </button>
                        <button class="btn btn-outline-primary search-alternatives" type="button">
                            <i class="fas fa-search me-2"></i> Cari Alternatif Lain
                        </button>
                    </div>
                    
                    <div class="mt-3 search-results" style="display: none;">
                        <h6>Hasil Pencarian:</h6>
                        <div class="search-results-content">
                            <!-- Search results will be populated here -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let currentBookData = {};
            
            // Initialize progress indicators and book covers
            @foreach($peminjaman as $item)
                initializeBookCard({{ $item->id }}, '{{ $item->book_title }}', '{{ $item->book_authors }}', '{{ $item->book_isbn ?? "" }}', '{{ $item->borrow_date }}', '{{ $item->return_date }}', '{{ $item->getReturnStatus() }}');
            @endforeach
            
            // Function to initialize each book card
            function initializeBookCard(id, title, author, isbn, borrowDate, returnDate, status) {
                // Load book cover
                loadBookCover(id, title, author, isbn);
                
                // Update progress indicator
                updateProgressIndicator(id, borrowDate, returnDate, status);
                
                // Update days info
                updateDaysInfo(id, borrowDate, returnDate, status);
            }
            
            // Function to load book cover
            async function loadBookCover(id, title, author, isbn) {
                try {
                    let query = '';
                    if (isbn && isbn !== 'N/A' && isbn !== '') {
                        query = `isbn:${isbn}`;
                    } else {
                        query = `${title} ${author}`.trim();
                    }
                    
                    const response = await fetch(`https://www.googleapis.com/books/v1/volumes?q=${encodeURIComponent(query)}&maxResults=1`);
                    const data = await response.json();
                    
                    const coverContainer = document.getElementById(`cover-${id}`);
                    
                    if (data.items && data.items.length > 0 && data.items[0].volumeInfo.imageLinks) {
                        const thumbnail = data.items[0].volumeInfo.imageLinks.thumbnail;
                        coverContainer.innerHTML = `<img src="${thumbnail}" alt="Cover" class="book-cover">`;
                    }
                } catch (error) {
                    console.log('Error loading book cover:', error);
                    // Keep the default placeholder
                }
            }
            
            // Function to update progress indicator
            function updateProgressIndicator(id, borrowDate, returnDate, status) {
                const progressElement = document.querySelector(`#progress-${id} .progress-fill`);
                if (!progressElement) return;
                
                const borrow = new Date(borrowDate);
                const due = new Date(returnDate);
                const today = new Date();
                
                const totalDays = Math.ceil((due - borrow) / (1000 * 60 * 60 * 24));
                const daysPassed = Math.ceil((today - borrow) / (1000 * 60 * 60 * 24));
                
                let progressPercent = Math.min(Math.max((daysPassed / totalDays) * 100, 0), 100);
                
                if (status === 'Dikembalikan') {
                    progressPercent = 100;
                    progressElement.classList.add('completed');
                } else if (status === 'Terlambat') {
                    progressPercent = 100;
                    progressElement.classList.add('overdue');
                }
                
                setTimeout(() => {
                    progressElement.style.width = progressPercent + '%';
                }, 100);
            }
            
            // Function to update days info
            function updateDaysInfo(id, borrowDate, returnDate, status) {
                const daysInfoElement = document.getElementById(`days-info-${id}`);
                if (!daysInfoElement) return;
                
                const today = new Date();
                const due = new Date(returnDate);
                const daysDiff = Math.ceil((due - today) / (1000 * 60 * 60 * 24));
                
                if (status === 'Dikembalikan') {
                    daysInfoElement.textContent = '';
                } else if (status === 'Terlambat') {
                    daysInfoElement.innerHTML = `<i class="fas fa-exclamation-triangle text-danger"></i> Terlambat ${Math.abs(daysDiff)} hari`;
                    daysInfoElement.classList.add('text-danger');
                } else {
                    if (daysDiff > 0) {
                        daysInfoElement.innerHTML = `<i class="fas fa-clock text-warning"></i> ${daysDiff} hari lagi`;
                        daysInfoElement.classList.add('text-warning');
                    } else if (daysDiff === 0) {
                        daysInfoElement.innerHTML = `<i class="fas fa-bell text-warning"></i> Jatuh tempo hari ini`;
                        daysInfoElement.classList.add('text-warning');
                    }
                }
            }
            
            // Handle view details button
            document.addEventListener('click', function(e) {
                if (e.target.closest('.view-details')) {
                    const button = e.target.closest('.view-details');
                    const data = {
                        id: button.dataset.id,
                        title: button.dataset.title,
                        author: button.dataset.author,
                        isbn: button.dataset.isbn,
                        borrowDate: button.dataset.borrowDate,
                        returnDate: button.dataset.returnDate,
                        status: button.dataset.status,
                        purpose: button.dataset.purpose
                    };
                    
                    populateDetailModal(data);
                }
            });
            
            // Function to populate detail modal
            async function populateDetailModal(data) {
                // Set basic info
                document.querySelector('#detailModal .book-title').textContent = data.title;
                document.querySelector('#detailModal .book-author').textContent = data.author;
                document.querySelector('#detailModal .book-isbn').innerHTML = `<small class="text-muted">ISBN: ${data.isbn}</small>`;
                document.querySelector('#detailModal .borrow-date').textContent = formatDate(data.borrowDate);
                document.querySelector('#detailModal .return-date').textContent = formatDate(data.returnDate);
                document.querySelector('#detailModal .status').innerHTML = getStatusBadge(data.status);
                document.querySelector('#detailModal .purpose').textContent = data.purpose;
                
                // Load book cover for modal
                await loadModalBookCover(data.title, data.author, data.isbn);
                
                // Update progress bar
                updateModalProgress(data.borrowDate, data.returnDate, data.status);
                
                // Generate timeline
                generateTimeline(data);
                
                // Show/hide action buttons
                const readButton = document.querySelector('.read-book-modal');
                const extendButton = document.querySelector('.extend-loan');
                
                readButton.style.display = 'inline-block';
                readButton.onclick = () => openReadBookModal(data.title, data.author, data.isbn);
                
                if (data.status !== 'Dikembalikan') {
                    extendButton.style.display = 'inline-block';
                } else {
                    extendButton.style.display = 'none';
                }
            }
            
            // Function to load book cover in modal
            async function loadModalBookCover(title, author, isbn) {
                try {
                    let query = '';
                    if (isbn && isbn !== 'N/A' && isbn !== '') {
                        query = `isbn:${isbn}`;
                    } else {
                        query = `${title} ${author}`.trim();
                    }
                    
                    const response = await fetch(`https://www.googleapis.com/books/v1/volumes?q=${encodeURIComponent(query)}&maxResults=1`);
                    const data = await response.json();
                    
                    const coverImg = document.querySelector('#detailModal .book-cover-img');
                    const placeholderIcon = document.querySelector('#detailModal .book-placeholder-icon');
                    
                    if (data.items && data.items.length > 0 && data.items[0].volumeInfo.imageLinks) {
                        const thumbnail = data.items[0].volumeInfo.imageLinks.thumbnail;
                        coverImg.src = thumbnail;
                        coverImg.style.display = 'block';
                        placeholderIcon.style.display = 'none';
                    }
                } catch (error) {
                    console.log('Error loading modal book cover:', error);
                }
            }
            
            // Function to update modal progress
            function updateModalProgress(borrowDate, returnDate, status) {
                const progressBar = document.querySelector('#detailModal .progress-bar');
                const progressText = document.querySelector('#detailModal .loan-progress-text');
                
                const borrow = new Date(borrowDate);
                const due = new Date(returnDate);
                const today = new Date();
                
                const totalDays = Math.ceil((due - borrow) / (1000 * 60 * 60 * 24));
                const daysPassed = Math.ceil((today - borrow) / (1000 * 60 * 60 * 24));
                
                let progressPercent = Math.min(Math.max((daysPassed / totalDays) * 100, 0), 100);
                let progressClass = 'bg-primary';
                let progressTextValue = '';
                
                if (status === 'Dikembalikan') {
                    progressPercent = 100;
                    progressClass = 'bg-success';
                    progressTextValue = 'Sudah dikembalikan';
                } else if (status === 'Terlambat') {
                    progressPercent = 100;
                    progressClass = 'bg-danger';
                    const overdueDays = Math.ceil((today - due) / (1000 * 60 * 60 * 24));
                    progressTextValue = `Terlambat ${overdueDays} hari`;
                } else {
                    const remainingDays = Math.ceil((due - today) / (1000 * 60 * 60 * 24));
                    if (remainingDays > 0) {
                        progressTextValue = `${remainingDays} hari tersisa`;
                    } else if (remainingDays === 0) {
                        progressTextValue = 'Jatuh tempo hari ini';
                        progressClass = 'bg-warning';
                    }
                }
                
                progressBar.className = `progress-bar ${progressClass}`;
                progressBar.style.width = progressPercent + '%';
                progressText.textContent = progressTextValue;
            }
            
            // Function to generate timeline
            function generateTimeline(data) {
                const timelineContainer = document.querySelector('#detailModal .timeline-items');
                const borrowDate = new Date(data.borrowDate);
                const returnDate = new Date(data.returnDate);
                const today = new Date();
                
                let timelineHTML = '';
                
                // Borrow event
                timelineHTML += `
                    <div class="timeline-item d-flex align-items-start">
                        <div class="timeline-badge bg-primary me-3">
                            <i class="fas fa-book fa-sm"></i>
                        </div>
                        <div class="timeline-content">
                            <h6 class="mb-1">Buku Dipinjam</h6>
                            <p class="text-muted mb-0">${formatDate(data.borrowDate)}</p>
                        </div>
                    </div>
                `;
                
                // Due date reminder
                if (data.status !== 'Dikembalikan') {
                    const daysUntilDue = Math.ceil((returnDate - today) / (1000 * 60 * 60 * 24));
                    
                    if (daysUntilDue > 0) {
                        timelineHTML += `
                            <div class="timeline-item d-flex align-items-start">
                                <div class="timeline-badge bg-warning me-3">
                                    <i class="fas fa-clock fa-sm"></i>
                                </div>
                                <div class="timeline-content">
                                    <h6 class="mb-1">Jatuh Tempo</h6>
                                    <p class="text-muted mb-0">${formatDate(data.returnDate)} (${daysUntilDue} hari lagi)</p>
                                </div>
                            </div>
                        `;
                    } else if (daysUntilDue === 0) {
                        timelineHTML += `
                            <div class="timeline-item d-flex align-items-start">
                                <div class="timeline-badge bg-danger me-3">
                                    <i class="fas fa-exclamation-triangle fa-sm"></i>
                                </div>
                                <div class="timeline-content">
                                    <h6 class="mb-1">Jatuh Tempo Hari Ini</h6>
                                    <p class="text-muted mb-0">${formatDate(data.returnDate)}</p>
                                </div>
                            </div>
                        `;
                    } else {
                        timelineHTML += `
                            <div class="timeline-item d-flex align-items-start">
                                <div class="timeline-badge bg-danger me-3">
                                    <i class="fas fa-exclamation-triangle fa-sm"></i>
                                </div>
                                <div class="timeline-content">
                                    <h6 class="mb-1">Terlambat</h6>
                                    <p class="text-muted mb-0">Sudah ${Math.abs(daysUntilDue)} hari terlambat</p>
                                </div>
                            </div>
                        `;
                    }
                }
                
                // Return event (if returned)
                if (data.status === 'Dikembalikan') {
                    timelineHTML += `
                        <div class="timeline-item d-flex align-items-start">
                            <div class="timeline-badge bg-success me-3">
                                <i class="fas fa-check fa-sm"></i>
                            </div>
                            <div class="timeline-content">
                                <h6 class="mb-1">Buku Dikembalikan</h6>
                                <p class="text-muted mb-0">Berhasil dikembalikan</p>
                            </div>
                        </div>
                    `;
                }
                
                timelineContainer.innerHTML = timelineHTML;
            }
            
            // Handle read book buttons
            document.addEventListener('click', function(e) {
                if (e.target.closest('.read-book')) {
                    const button = e.target.closest('.read-book');
                    const title = button.dataset.title;
                    const author = button.dataset.author;
                    const isbn = button.dataset.isbn;
                    
                    openReadBookModal(title, author, isbn);
                }
            });
            
            // Function to open read book modal
            function openReadBookModal(title, author, isbn) {
                currentBookData = { title, author, isbn };
                
                document.querySelector('#readBookModal .read-book-title').textContent = title;
                document.querySelector('#readBookModal .read-book-author').textContent = `oleh ${author}`;
                
                // Set up Google Books link
                const googleBooksButton = document.querySelector('.google-books-link');
                googleBooksButton.onclick = () => {
                    let searchQuery = '';
                    if (isbn && isbn !== 'N/A' && isbn !== '') {
                        searchQuery = `isbn:${isbn}`;
                    } else {
                        searchQuery = `${title} ${author}`.trim();
                    }
                    
                    const googleBooksUrl = `https://books.google.com/books?q=${encodeURIComponent(searchQuery)}`;
                    window.open(googleBooksUrl, '_blank');
                };
                
                // Hide search results initially
                document.querySelector('.search-results').style.display = 'none';
                
                const readBookModal = new bootstrap.Modal(document.getElementById('readBookModal'));
                readBookModal.show();
            }
            
            // Handle search alternatives
            document.querySelector('.search-alternatives').addEventListener('click', async function() {
                const searchResults = document.querySelector('.search-results');
                const searchResultsContent = document.querySelector('.search-results-content');
                
                searchResults.style.display = 'block';
                searchResultsContent.innerHTML = '<div class="text-center"><i class="fas fa-spinner fa-spin"></i> Mencari...</div>';
                
                try {
                    const searchLinks = await generateSearchLinks(currentBookData);
                    searchResultsContent.innerHTML = searchLinks;
                } catch (error) {
                    searchResultsContent.innerHTML = '<div class="text-danger">Gagal mencari alternatif. Silakan coba lagi.</div>';
                }
            });
            
            // Function to generate search links
            async function generateSearchLinks(bookData) {
                const { title, author, isbn } = bookData;
                const searchQuery = `${title} ${author}`.trim();
                
                const searchEngines = [
                    {
                        name: 'Open Library',
                        url: `https://openlibrary.org/search?q=${encodeURIComponent(searchQuery)}`,
                        icon: 'fas fa-book'
                    },
                    {
                        name: 'Internet Archive',
                        url: `https://archive.org/search.php?query=${encodeURIComponent(searchQuery)}`,
                        icon: 'fas fa-archive'
                    },
                    {
                        name: 'Project Gutenberg',
                        url: `https://www.gutenberg.org/ebooks/search/?query=${encodeURIComponent(searchQuery)}`,
                        icon: 'fas fa-book-open'
                    },
                    {
                        name: 'Google Scholar',
                        url: `https://scholar.google.com/scholar?q=${encodeURIComponent(searchQuery)}`,
                        icon: 'fas fa-graduation-cap'
                    }
                ];
                
                let linksHTML = '<div class="d-grid gap-2">';
                
                searchEngines.forEach(engine => {
                    linksHTML += `
                        <a href="${engine.url}" target="_blank" class="btn btn-outline-secondary btn-sm">
                            <i class="${engine.icon} me-2"></i>${engine.name}
                        </a>
                    `;
                });
                
                linksHTML += '</div>';
                
                return linksHTML;
            }
            
            // Utility functions
            function formatDate(dateString) {
                const date = new Date(dateString);
                const options = { 
                    year: 'numeric', 
                    month: 'long', 
                    day: 'numeric' 
                };
                return date.toLocaleDateString('id-ID', options);
            }
            
            function getStatusBadge(status) {
                const statusMap = {
                    'Dikembalikan': '<span class="badge bg-success"><i class="fas fa-check me-1"></i>Dikembalikan</span>',
                    'Terlambat': '<span class="badge bg-danger"><i class="fas fa-exclamation-triangle me-1"></i>Terlambat</span>',
                    'Dipinjam': '<span class="badge bg-primary"><i class="fas fa-clock me-1"></i>Dipinjam</span>'
                };
                
                return statusMap[status] || '<span class="badge bg-secondary">Unknown</span>';
            }
            
            // Add loading animation to cards
            const cards = document.querySelectorAll('.book-card');
            cards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.1}s`;
                card.classList.add('animate__animated', 'animate__fadeInUp');
            });
            
            // Add hover effects to action buttons
            document.querySelectorAll('.action-btn').forEach(button => {
                button.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-2px)';
                });
                
                button.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });
            
            // Initialize tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
            
            // Add success message for returned books
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('returned') === 'success') {
                const alert = document.createElement('div');
                alert.className = 'alert alert-success alert-dismissible fade show';
                alert.innerHTML = `
                    <i class="fas fa-check-circle me-2"></i>
                    Buku berhasil dikembalikan!
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;
                document.querySelector('.container').insertBefore(alert, document.querySelector('.page-header'));
                
                // Remove success parameter from URL
                window.history.replaceState({}, document.title, window.location.pathname);
            }
        });
    </script>
</body>
</html>