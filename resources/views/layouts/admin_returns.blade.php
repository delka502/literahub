```blade
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LiteraHub Admin - Pengembalian</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Custom CSS -->
    <link href="{{ asset('perpustakaan/admin.css') }}" rel="stylesheet">
</head>
<body>
    @include('layouts.components_admin.sidebar')
    
    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light mb-4">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <span class="navbar-text">
                    <i class="fas fa-calendar-alt me-2"></i> {{ now()->format('l, d F Y') }}
                </span>
                <div class="d-flex align-items-center">
                  
                </div>
            </div>
        </nav>

        <!-- Tabs Navigation -->
        <ul class="nav nav-tabs mb-3" id="returnsTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending" type="button" role="tab">
                    Buku Dipinjam
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="returned-tab" data-bs-toggle="tab" data-bs-target="#returned" type="button" role="tab">
                    Buku Dikembalikan
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="overdue-tab" data-bs-toggle="tab" data-bs-target="#overdue" type="button" role="tab">
                    Buku Terlambat
                </button>
            </li>
        </ul>

        <!-- Tab Contents -->
        <div class="tab-content" id="returnsTabContent">
            <!-- Pending Returns Tab -->
            <div class="tab-pane fade show active" id="pending" role="tabpanel" aria-labelledby="pending-tab">
                <div class="card dashboard-card">
                    <div class="card-header bg-white py-3">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Cari berdasarkan ID, judul, atau anggota...">
                                    <button class="btn btn-outline-secondary" type="button">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <select class="form-select">
                                    <option selected>Filter Status</option>
                                    <option>Segera Jatuh Tempo</option>
                                    <option>Jatuh Tempo Hari Ini</option>
                                    <option>Semua</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="form-select">
                                    <option selected>Urutkan Berdasarkan</option>
                                    <option>Tenggat Terdekat</option>
                                    <option>Nama Anggota</option>
                                    <option>Judul Buku</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
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
                                    @forelse($pendingReturns as $loan)
                                    <tr>
                                        <td>{{ $loan->id }}</td>
                                        <td>
                                            <img src="https://via.placeholder.com/32" class="rounded-circle me-2" width="32" height="32" alt="User">
                                            {{ $loan->fullname }}
                                        </td>
                                        <td>{{ $loan->book_title }}</td>
                                        <td>{{ \Carbon\Carbon::parse($loan->borrow_date)->format('d/m/Y') }}</td>
                                        <td class="{{ $loan->status_badge == 'badge-danger' ? 'text-danger' : ($loan->status_badge == 'badge-warning' ? 'text-warning' : '') }}">
                                            {{ \Carbon\Carbon::parse($loan->return_date)->format('d/m/Y') }}
                                        </td>
                                        <td>
                                            <span class="badge {{ $loan->status_badge }}">
                                                {{ $loan->status_text }}
                                            </span>
                                        </td>
                                        <td>
                                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#processReturnModal">
                                                <i class="fas fa-undo me-1"></i> Proses
                                            </button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Tidak ada peminjaman tertunda</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recently Returned Tab -->
            <div class="tab-pane fade" id="returned" role="tabpanel" aria-labelledby="returned-tab">
                <div class="card dashboard-card">
                    <div class="card-header bg-white py-3">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Cari berdasarkan ID, judul, atau anggota...">
                                    <button class="btn btn-outline-secondary" type="button">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <select class="form-select">
                                    <option selected>Filter Periode</option>
                                    <option>Hari Ini</option>
                                    <option>Minggu Ini</option>
                                    <option>Bulan Ini</option>
                                    <option>Semua</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select class="form-select">
                                    <option selected>Urutkan Berdasarkan</option>
                                    <option>Terbaru</option>
                                    <option>Terlama</option>
                                    <option>Nama Anggota</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID Peminjaman</th>
                                        <th>Anggota</th>
                                        <th>Judul Buku</th>
                                        <th>Tanggal Pinjam</th>
                                        <th>Tanggal Kembali</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($returnedBooks as $loan)
                                    <tr>
                                        <td>{{ $loan->id }}</td>
                                        <td>
                                            <img src="https://via.placeholder.com/32" class="rounded-circle me-2" width="32" height="32" alt="User">
                                            {{ $loan->fullname }}
                                        </td>
                                        <td>{{ $loan->book_title }}</td>
                                        <td>{{ \Carbon\Carbon::parse($loan->borrow_date)->format('d/m/Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($loan->actual_return_date)->format('d/m/Y') }}</td>
                                        <td>
                                            <span class="badge bg-success">Tepat Waktu</span>
                                        </td>
                                        <td>
                                            <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#viewReturnDetailsModal">
                                                <i class="fas fa-eye me-1"></i> Detail
                                            </button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Tidak ada buku yang dikembalikan</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Overdue Returns Tab -->
            <div class="tab-pane fade" id="overdue" role="tabpanel" aria-labelledby="overdue-tab">
                <div class="card dashboard-card">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Buku Terlambat Dikembalikan</h5>
                        <button class="btn btn-danger">
                            <i class="fas fa-envelope me-1"></i> Kirim Pengingat Massal
                        </button>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="selectAll">
                                                <label class="form-check-label" for="selectAll"></label>
                                            </div>
                                        </th>
                                        <th>ID Peminjaman</th>
                                        <th>Anggota</th>
                                        <th>Judul Buku</th>
                                        <th>Tenggat</th>
                                        <th>Terlambat</th>
                                        <th>Denda</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($overdueBooks as $loan)
                                    <tr>
                                          <td>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox">
                                                <label class="form-check-label"></label>
                                            </div>
                                        </td>
                                        <td>{{ $loan->id }}</td>
                                        <td>
                                            <img src="https://via.placeholder.com/32" class="rounded-circle me-2" width="32" height="32" alt="User">
                                            {{ $loan->fullname }}
                                        </td>
                                        <td>{{ $loan->book_title }}</td>
                                        <td>{{ \Carbon\Carbon::parse($loan->return_date)->format('d/m/Y') }}</td>
                                        <td class="text-danger">{{ $loan->days_overdue }} hari</td>
                                        <td>Rp {{ number_format($loan->late_fee, 0, ',', '.') }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#sendReminderModal">
                                                    <i class="fas fa-bell me-1"></i> Ingatkan
                                                </button>
                                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#processReturnModal">
                                                    <i class="fas fa-undo me-1"></i> Proses
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center">Tidak ada buku terlambat dikembalikan</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>