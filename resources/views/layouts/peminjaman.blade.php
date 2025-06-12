<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LiteraHub Admin - Peminjaman</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Custom CSS -->
    <link href="{{ asset('perpustakaan/admin.css') }}" rel="stylesheet">
</head>
<body>
    <!-- Sidebar -->
    @include('layouts.components_admin.sidebar')

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Navbar -->
        @include('layouts.components_admin.navbar')

        <!-- Page Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3">Manajemen Peminjaman</h1>
                <p class="text-muted">Kelola semua transaksi peminjaman buku perpustakaan</p>
            </div>
            <div>
                <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#exportModal">
                    <i class="fas fa-download me-2"></i> Ekspor Data
                </button>
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addBorrowingModal">
                    <i class="fas fa-plus me-2"></i> Peminjaman Baru
                </button>
            </div>
        </div>

        <!-- Filter and Search -->
        <div class="card dashboard-card mb-4">
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label for="statusFilter" class="form-label">Status</label>
                        <select class="form-select" id="statusFilter">
                            <option value="">Semua Status</option>
                            <option value="active">Aktif</option>
                            <option value="returned">Dikembalikan</option>
                            <option value="overdue">Terlambat</option>
                            <option value="pending">Menunggu</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="dateRange" class="form-label">Rentang Tanggal</label>
                        <select class="form-select" id="dateRange">
                            <option value="all">Semua Waktu</option>
                            <option value="today">Hari Ini</option>
                            <option value="week">Minggu Ini</option>
                            <option value="month">Bulan Ini</option>
                            <option value="custom">Kustom</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="searchBorrowing" class="form-label">Cari</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="searchBorrowing" placeholder="Cari ID, nama anggota, atau judul buku...">
                            <button class="btn btn-primary" type="button">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Borrowing Stats -->
        <div class="row g-4 mb-4">
            <!-- Active Borrowings -->
            <div class="col-md-3">
                <div class="card stat-card dashboard-card">
                    <div class="card-body">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-book-reader"></i>
                        </div>
                        <div class="stat-number">384</div>
                        <div class="stat-label">Peminjaman Aktif</div>
                    </div>
                </div>
            </div>
            
            <!-- Returned Today -->
            <div class="col-md-3">
                <div class="card stat-card dashboard-card">
                    <div class="card-body">
                        <div class="card-icon bg-success">
                            <i class="fas fa-undo-alt"></i>
                        </div>
                        <div class="stat-number">42</div>
                        <div class="stat-label">Dikembalikan Hari Ini</div>
                    </div>
                </div>
            </div>
            
            <!-- Due Today -->
            <div class="col-md-3">
                <div class="card stat-card dashboard-card">
                    <div class="card-body">
                        <div class="card-icon bg-warning">
                            <i class="fas fa-calendar-day"></i>
                        </div>
                        <div class="stat-number">18</div>
                        <div class="stat-label">Jatuh Tempo Hari Ini</div>
                    </div>
                </div>
            </div>
            
            <!-- Overdue -->
            <div class="col-md-3">
                <div class="card stat-card dashboard-card">
                    <div class="card-body">
                        <div class="card-icon bg-danger">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="stat-number">27</div>
                        <div class="stat-label">Terlambat</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Borrowing Table -->
        <div class="card dashboard-card mb-4">
            <div class="card-header bg-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Daftar Peminjaman</h5>
                    <div>
                        <button class="btn btn-sm btn-outline-secondary me-2">
                            <i class="fas fa-filter me-1"></i> Filter
                        </button>
                        <div class="dropdown d-inline-block">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-sort me-1"></i> Urutkan
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <li><a class="dropdown-item" href="#">Terbaru</a></li>
                                <li><a class="dropdown-item" href="#">Terlama</a></li>
                                <li><a class="dropdown-item" href="#">Jatuh Tempo (Terdekat)</a></li>
                                <li><a class="dropdown-item" href="#">Jatuh Tempo (Terjauh)</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="checkAll">
                                    </div>
                                </th>
                                <th>ID Peminjaman</th>
                                <th>Anggota</th>
                                <th>Judul Buku</th>
                                <th>Tanggal Pinjam</th>
                                <th>Tenggat</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox">
                                    </div>
                                </td>
                                <td>B-2025040901</td>
                                <td>Andi Pratama</td>
                                <td>Algoritma dan Pemrograman</td>
                                <td>01/04/2025</td>
                                <td>15/04/2025</td>
                                <td><span class="badge badge-active">Aktif</span></td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            Aksi
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#"><i class="fas fa-eye me-2"></i> Detail</a></li>
                                            <li><a class="dropdown-item" href="#"><i class="fas fa-undo me-2"></i> Pengembalian</a></li>
                                            <li><a class="dropdown-item" href="#"><i class="fas fa-edit me-2"></i> Edit</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-trash me-2"></i> Hapus</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox">
                                    </div>
                                </td>
                                <td>B-2025040902</td>
                                <td>Budi Santoso</td>
                                <td>Hukum Tata Negara</td>
                                <td>02/04/2025</td>
                                <td>16/04/2025</td>
                                <td><span class="badge badge-active">Aktif</span></td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            Aksi
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#"><i class="fas fa-eye me-2"></i> Detail</a></li>
                                            <li><a class="dropdown-item" href="#"><i class="fas fa-undo me-2"></i> Pengembalian</a></li>
                                            <li><a class="dropdown-item" href="#"><i class="fas fa-edit me-2"></i> Edit</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-trash me-2"></i> Hapus</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <tr class="table-warning">
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox">
                                    </div>
                                </td>
                                <td>B-2025032010</td>
                                <td>Deni Kurniawan</td>
                                <td>Basis Data Lanjutan</td>
                                <td>20/03/2025</td>
                                <td>03/04/2025</td>
                                <td><span class="badge badge-warning">Jatuh Tempo Hari Ini</span></td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            Aksi
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#"><i class="fas fa-eye me-2"></i> Detail</a></li>
                                            <li><a class="dropdown-item" href="#"><i class="fas fa-undo me-2"></i> Pengembalian</a></li>
                                            <li><a class="dropdown-item" href="#"><i class="fas fa-edit me-2"></i> Edit</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-trash me-2"></i> Hapus</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <tr class="table-danger">
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox">
                                    </div>
                                </td>
                                <td>B-2025031801</td>
                                <td>Farhan Rizky</td>
                                <td>Pengantar Ekonomi Bisnis</td>
                                <td>15/03/2025</td>
                                <td>29/03/2025</td>
                                <td><span class="badge badge-overdue">Terlambat (11 hari)</span></td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            Aksi
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#"><i class="fas fa-eye me-2"></i> Detail</a></li>
                                            <li><a class="dropdown-item" href="#"><i class="fas fa-undo me-2"></i> Pengembalian</a></li>
                                            <li><a class="dropdown-item" href="#"><i class="fas fa-edit me-2"></i> Edit</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-trash me-2"></i> Hapus</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <tr class="table-success">
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox">
                                    </div>
                                </td>
                                <td>B-2025040801</td>
                                <td>Gita Maharani</td>
                                <td>Psikologi Perkembangan</td>
                                <td>01/04/2025</td>
                                <td>15/04/2025</td>
                                <td><span class="badge badge-returned">Dikembalikan (08/04/2025)</span></td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            Aksi
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#"><i class="fas fa-eye me-2"></i> Detail</a></li>
                                            <li><a class="dropdown-item disabled" href="#"><i class="fas fa-undo me-2"></i> Pengembalian</a></li>
                                            <li><a class="dropdown-item" href="#"><i class="fas fa-edit me-2"></i> Edit</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-trash me-2"></i> Hapus</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox">
                                    </div>
                                </td>
                                <td>B-2025040907</td>
                                <td>Hendra Wijaya</td>
                                <td>Fisika Dasar</td>
                                <td>05/04/2025</td>
                                <td>19/04/2025</td>
                                <td><span class="badge badge-active">Aktif</span></td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            Aksi
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#"><i class="fas fa-eye me-2"></i> Detail</a></li>
                                            <li><a class="dropdown-item" href="#"><i class="fas fa-undo me-2"></i> Pengembalian</a></li>
                                            <li><a class="dropdown-item" href="#"><i class="fas fa-edit me-2"></i> Edit</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-trash me-2"></i> Hapus</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox">
                                    </div>
                                </td>
                                <td>B-2025040910</td>
                                <td>Indah Puspita</td>
                                <td>Kimia Organik</td>
                                <td>07/04/2025</td>
                                <td>21/04/2025</td>
                                <td><span class="badge badge-active">Aktif</span></td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            Aksi
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#"><i class="fas fa-eye me-2"></i> Detail</a></li>
                                            <li><a class="dropdown-item" href="#"><i class="fas fa-undo me-2"></i> Pengembalian</a></li>
                                            <li><a class="dropdown-item" href="#"><i class="fas fa-edit me-2"></i> Edit</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-trash me-2"></i> Hapus</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox">
                                    </div>
                                </td>
                                <td>B-2025040912</td>
                                <td>Joko Susilo</td>
                                <td>Statistika untuk Penelitian</td>
                                <td>08/04/2025</td>
                                <td>22/04/2025</td>
                                <td><span class="badge badge-pending">Menunggu</span></td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            Aksi
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#"><i class="fas fa-eye me-2"></i> Detail</a></li>
                                            <li><a class="dropdown-item" href="#"><i class="fas fa-check me-2"></i> Setujui</a></li>
                                            <li><a class="dropdown-item" href="#"><i class="fas fa-edit me-2"></i> Edit</a></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-trash me-2"></i> Hapus</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-0">Menampilkan 1-8 dari 384 data</p>
                    </div>
                    <nav aria-label="Page navigation">
                        <ul class="pagination mb-0">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Bulk Actions -->
        <div class="card dashboard-card mb-4">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0">Aksi Massal</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <select class="form-select" id="bulkAction">
                            <option selected>Pilih Aksi...</option>
                            <option value="return">Proses Pengembalian</option>
                            <option value="extend">Perpanjang Masa Pinjam</option>
                            <option value="remind">Kirim Pengingat</option>
                            <option value="delete">Hapus</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-primary w-100">Terapkan</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="mt-5 text-center text-muted">
            <p>&copy; 2025 LiteraHub Admin Panel | Dibuat oleh Tim Pengembang</p>
        </footer>
    </div>

    <!-- Add Borrowing Modal -->
    <div class="modal fade" id="addBorrowingModal" tabindex="-1" aria-labelledby="addBorrowingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addBorrowingModalLabel">Tambah Peminjaman Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="memberID" class="form-label">ID Anggota</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="memberID" placeholder="Masukkan ID anggota">
                                    <button class="btn btn-outline-secondary" type="button">Cari</button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="memberName" class="form-label">Nama Anggota</label>
                                <input type="text" class="form-control" id="memberName" placeholder="Nama akan muncul otomatis" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="bookID" class="form-label">ID Buku</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="bookID" placeholder="Masukkan ID buku">
                                    <button class="btn btn-outline-secondary" type="button">Cari</button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="bookTitle" class="form-label">Judul Buku</label>
                                <input type="text" class="form-control" id="bookTitle" placeholder="Judul akan muncul otomatis" readonly>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="borrowDate" class="form-label">Tanggal Pinjam</label>
                                <input type="date" class="form-control" id="borrowDate" value="2025-04-09">
                            </div>
                            <div class="col-md-6">
                                <label for="dueDate" class="form-label">Tanggal Jatuh Tempo</label>
                                <input type="date" class="form-control" id="dueDate" value="2025-04-23">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="notes" class="form-label">Catatan</label>
                            <textarea class="form-control" id="notes" rows="3" placeholder="Tambahkan catatan peminjaman jika ada..."></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Export Modal -->
    <div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exportModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exportModalLabel">Ekspor Data Peminjaman</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="exportFormat" class="form-label">Format File</label>
                            <select class="form-select" id="exportFormat">
                                <option value="excel">Excel (.xlsx)</option>
                                <option value="csv">CSV (.csv)</option>
                                <option value="pdf">PDF (.pdf)</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="exportRange" class="form-label">Rentang Data</label>
                            <select class="form-select" id="exportRange">
                                <option value="all">Semua Data</option>
                                <option value="filtered">Data yang Difilter</option>
                                <option value="selected">Data yang Dipilih</option>
                                <option value="custom">Kustom</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Pilih Kolom</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="colID" checked>
                                        <label class="form-check-label" for="colID">ID Peminjaman</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="colMember" checked>
                                        <label class="form-check-label" for="colMember">Anggota</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="colBook" checked>
                                        <label class="form-check-label" for="colBook">Judul Buku</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="colBorrowDate" checked>
                                        <label class="form-check-label" for="colBorrowDate">Tanggal Pinjam</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" id="colDueDate" checked>