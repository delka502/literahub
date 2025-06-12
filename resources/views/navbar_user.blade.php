
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
                    <a class="nav-link active" href="{{ route('dashboard_user') }}">Beranda</a>
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


    {{-- Main Content --}}
    {{-- <div class="container mt-4 mb-5">
        @yield('content')
    </div> --}}

    {{-- Bootstrap Script --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
