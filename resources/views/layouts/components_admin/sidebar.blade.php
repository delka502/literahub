<div class="sidebar">
    <div class="sidebar-header">
        <a href="admin-dashboard.html" class="sidebar-brand">
            <i class="fas fa-book-open me-2"></i>Litera<span>Hub</span>
        </a>
    </div>
    <ul class="sidebar-menu mt-4">
        <li>
            <a href="{{ route('dashboard_admin') }}" class="{{ request()->routeIs('dashboard_admin') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>
        
        <li>
            <a href="{{ route('admin.returns') }}" class="{{ request()->routeIs('admin.returns') ? 'active' : '' }}">
                <i class="fas fa-undo"></i>
                <span>Pengembalian</span>
            </a>
        </li>
        
        
        {{-- <li>
            <a href="admin-categories.html">
                <i class="fas fa-tags"></i>
                <span>Kategori</span>
            </a>
        </li>
        <li>
            <a href="admin-reports.html">
                <i class="fas fa-chart-bar"></i>
                <span>Laporan</span>
            </a>
        </li>
        <li>
            <a href="admin-settings.html">
                <i class="fas fa-cog"></i>
                <span>Pengaturan</span>
            </a>
        </li> --}}
       
        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item"><i class="fas fa-sign-out-alt me-2"></i>Keluar</button>
                            </form>
                        </li>
    </ul>
</div>