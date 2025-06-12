<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LiteraHub Admin - Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Custom CSS -->
    <link href="{{ asset('perpustakaan/admin.css') }}" rel="stylesheet">
   
</head>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<body>
    <!-- Sidebar -->
 @include('layouts.components_admin.sidebar')

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Navbar -->
        @include('layouts.components_admin.navbar')

        <!-- Welcome Message -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3">Selamat Datang, Admin!</h1>
                <p class="text-muted">Berikut adalah ringkasan aktivitas perpustakaan hari ini</p>
            </div>
            {{-- <div>
                <button class="btn btn-primary me-2">
                    <i class="fas fa-download me-2"></i> Unduh Laporan
                </button>
                <button class="btn btn-success">
                    <i class="fas fa-plus me-2"></i> Tambah Buku
                </button>
            </div> --}}
        </div>

        <!-- Stats Overview -->
<div class="row g-4 mb-4">
    <!-- Total Books -->
    <div class="col-md-3">
        <div class="card stat-card dashboard-card">
            <div class="card-body">
                <div class="card-icon bg-primary">
                    <i class="fas fa-book"></i>
                </div>
                <div class="stat-number">{{ $totalBooksFromApi }}</div> <!-- Menampilkan jumlah buku dari Google Books -->
                <div class="stat-label">Total Buku</div>
            </div>
        </div>
    </div>

    <!-- Books Borrowed -->
    <div class="col-md-3">
        <div class="card stat-card dashboard-card">
            <div class="card-body">
                <div class="card-icon bg-warning">
                    <i class="fas fa-hands"></i>
                </div>
                <div class="stat-number">{{ $totalBorrowedBooks }}</div> <!-- Menampilkan jumlah buku dipinjam -->
                <div class="stat-label">Buku Dipinjam</div>
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
                <div class="stat-number">{{ $overdueBooks }}</div> <!-- Menampilkan jumlah buku terlambat -->
                <div class="stat-label">Terlambat</div>
            </div>
        </div>
    </div>
</div>


        <div class="row g-4 mb-4">
            <!-- Recent Borrowings -->
            <div class="col-lg-8">
                <div class="card dashboard-card h-100">
                    <div class="card-header bg-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Peminjaman Terbaru</h5>
                            <a href="admin-borrowing.html" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Anggota</th>
                                        <th>Judul Buku</th>
                                        <th>Tanggal Pinjam</th>
                                        <th>Tenggat</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($recentBorrowings as $pinjam)
                                        <tr>
                                            <td>{{ 'B-' . str_pad($pinjam->id, 10, '0', STR_PAD_LEFT) }}</td>
                                            <td>{{ $pinjam->fullname }}</td>
                                            <td>{{ $pinjam->book_title }}</td>
                                            <td>{{ \Carbon\Carbon::parse($pinjam->borrow_date)->format('d/m/Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($pinjam->return_date)->format('d/m/Y') }}</td>
                                            <td>
                                                <span class="badge {{ $pinjam->status == 'aktif' ? 'badge-active' : 'badge-secondary' }}">
                                                    {{ ucfirst($pinjam->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">Belum ada data peminjaman.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            {{-- <div class="col-lg-4">
                <div class="card dashboard-card h-100">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">Aksi Cepat</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button class="btn btn-primary btn-lg">
                                <i class="fas fa-book-medical me-2"></i> Tambah Buku Baru
                            </button>
                            <button class="btn btn-info btn-lg text-white">
                                <i class="fas fa-exchange-alt me-2"></i> Proses Peminjaman
                            </button>
                            <button class="btn btn-warning btn-lg">
                                <i class="fas fa-undo me-2"></i> Proses Pengembalian
                            </button>
                            <button class="btn btn-danger btn-lg">
                                <i class="fas fa-exclamation-circle me-2"></i> Periksa Keterlambatan
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}

        <div class="row g-4 mb-4">
            <!-- Popular Categories -->
            <div class="col-md-6">
                <div class="card dashboard-card h-100">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">Kategori Populer</h5>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <!-- Chart Placeholder -->
                            <div class="d-flex justify-content-center align-items-center h-100">
                                <div class="text-center">
                                    <i class="fas fa-chart-pie fa-4x text-primary mb-3"></i>
                                    <p class="text-muted">Chart akan dimuat di sini</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
            <!-- Borrowing Trends -->
            <div class="col-md-6">
                <div class="card dashboard-card h-100">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">Tren Peminjaman</h5>
                    </div>
                    <div class="card-body">
                        <div class="chart-container" style="height: 300px;">
                            <canvas id="borrowingTrendChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        

        <div class="row g-4">
            <!-- Recently Added Books -->
            <div class="col-lg-6">
                <div class="card dashboard-card">
                    <div class="card-header bg-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Buku Terbaru</h5>
                            <a href="admin-books.html" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Judul</th>
                                        <th>Penulis</th>
                                        <th>Kategori</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>BK-3421</td>
                                        <td>Pemrograman Python untuk Pemula</td>
                                        <td>Rudi Hartono</td>
                                        <td>Informatika</td>
                                        <td><span class="badge bg-success">Tersedia</span></td>
                                    </tr>
                                    <tr>
                                        <td>BK-3422</td>
                                        <td>Hukum Pidana Indonesia</td>
                                        <td>Prof. Susilo</td>
                                        <td>Hukum</td>
                                        <td><span class="badge bg-success">Tersedia</span></td>
                                    </tr>
                                    <tr>
                                        <td>BK-3423</td>
                                        <td>Farmasi Klinik</td>
                                        <td>Dr. Ani Wijaya</td>
                                        <td>Farmasi</td>
                                        <td><span class="badge bg-warning text-dark">Dipinjam</span></td>
                                    </tr>
                                    <tr>
                                        <td>BK-3424</td>
                                        <td>Sastra Indonesia Modern</td>
                                        <td>Maya Lestari</td>
                                        <td>Sastra</td>
                                        <td><span class="badge bg-success">Tersedia</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Active Users -->
            
<!-- Active Users -->
<div class="col-lg-6">
    <div class="card dashboard-card">
        <div class="card-header bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">Anggota Aktif</h5>
               
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Bergabung</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($allUsers as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td><span class="badge badge-active">Aktif</span></td>
                            <td>{{ $user->created_at->format('d/m/Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


        <!-- Footer -->
        <footer class="mt-5 text-center text-muted">
            <p>&copy; 2025 LiteraHub Admin Panel | Dibuat oleh Tim Pengembang</p>
        </footer>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle sidebar on mobile
        document.querySelector('.navbar-toggler').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('d-none');
        });
        
        // Add active class to current menu item
        document.addEventListener('DOMContentLoaded', function() {
            const currentLocation = location.href;
            const menuItems = document.querySelectorAll('.sidebar-menu a');
            menuItems.forEach(item => {
                if(item.href === currentLocation) {
                    item.classList.add('active');
                }
            });
        });
    </script>

<script>
    const ctx = document.getElementById('borrowingTrendChart').getContext('2d');
    const borrowingChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($months),
            datasets: [{
                label: 'Jumlah Peminjaman',
                data: @json($totals),
                fill: true,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 2,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            }
        }
    });
</script>

</body>
</html>