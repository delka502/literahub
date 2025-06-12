<nav class="navbar navbar-expand-lg navbar-light mb-4">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button">
            <span class="navbar-toggler-icon"></span>
        </button>
        <span class="navbar-text">
            <i class="fas fa-calendar-alt me-2"></i>
            <span id="tanggal-hari-ini"></span>
        </span>
        <div class="d-flex align-items-center">
            <div class="dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                    <i class="fas fa-bell me-2"></i>
                    <span class="badge rounded-pill bg-danger">3</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="#">5 buku baru perlu diverifikasi</a></li>
                    <li><a class="dropdown-item" href="#">10 permintaan peminjaman menunggu</a></li>
                    <li><a class="dropdown-item" href="#">3 buku melewati tenggat pengembalian</a></li>
                </ul>
            </div>
            <div class="dropdown ms-3">
                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                    <img src="https://via.placeholder.com/40" class="rounded-circle me-2" width="40" height="40" alt="Admin">
                    <span>Admin Perpustakaan</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="#">Profil Saya</a></li>
                    <li><a class="dropdown-item" href="#">Pengaturan</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#">Keluar</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>
<script>
    const hari = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
    const bulan = [
        "Januari", "Februari", "Maret", "April", "Mei", "Juni",
        "Juli", "Agustus", "September", "Oktober", "November", "Desember"
    ];

    const today = new Date();
    const namaHari = hari[today.getDay()];
    const tanggal = today.getDate();
    const namaBulan = bulan[today.getMonth()];
    const tahun = today.getFullYear();

    const tanggalLengkap = `${namaHari}, ${tanggal} ${namaBulan} ${tahun}`;
    document.getElementById("tanggal-hari-ini").textContent = tanggalLengkap;
</script>