<section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
        <div class="pull-left image">
            <img src="{{ asset('img/logo.jpg') }}" class="img-circle" alt="User Image">
        </div>        <div class="pull-left info">
            <p>{{ Auth::user()->name }}</p>
            <small><i class="fa fa-circle text-success"></i> {{ ucfirst(Auth::user()->role) }}</small>
        </div>    </div>

    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MENU NAVIGASI</li>
          <!-- Dashboard untuk semua role -->
        <li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <a href="{{ route('dashboard') }}">
                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            </a>
        </li>

        @if(Auth::user()->role === 'admin')
        <!-- Menu untuk Admin -->
        <li class="{{ request()->routeIs('instansi.*') ? 'active' : '' }}">
            <a href="{{ route('instansi.index') }}">
                <i class="fa fa-building"></i> <span>Kelola Instansi</span>
            </a>
        </li>
        
        <li class="treeview {{ request()->routeIs(['siswa.*', 'guru.*']) ? 'active menu-open' : '' }}">
            <a href="#">
                <i class="fa fa-users"></i>
                <span>Kelola Pengguna</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li class="{{ request()->routeIs('siswa.*') ? 'active' : '' }}">
                    <a href="{{ route('siswa.index') }}">
                        <i class="fa fa-graduation-cap"></i> Data Siswa
                    </a>
                </li>
                <li class="{{ request()->routeIs('guru.*') ? 'active' : '' }}">
                    <a href="{{ route('guru.index') }}">
                        <i class="fa fa-user-md"></i> Data Guru
                    </a>
                </li>
            </ul>
        </li>

        <li class="{{ request()->routeIs('jurnal.*') ? 'active' : '' }}">
            <a href="{{ route('jurnal.index') }}">
                <i class="fa fa-book"></i> <span>Kelola Jurnal PKL</span>
            </a>
        </li>

        <li class="{{ request()->routeIs('penilaian-berkala.*') ? 'active' : '' }}">
            <a href="{{ route('penilaian-berkala.index') }}">
                <i class="fa fa-star"></i> <span>Penilaian Berkala</span>
            </a>
        </li>

        @endif

        @if(Auth::user()->role === 'guru')
        <!-- Menu untuk Guru -->
        <li class="{{ request()->routeIs('jurnal.*') ? 'active' : '' }}">
            <a href="{{ route('jurnal.index') }}">
                <i class="fa fa-book"></i> <span>Jurnal PKL Siswa</span>
            </a>
        </li>

        <li class="{{ request()->routeIs('penilaian-berkala.*') ? 'active' : '' }}">
            <a href="{{ route('penilaian-berkala.index') }}">
                <i class="fa fa-star"></i> <span>Penilaian Berkala</span>
            </a>
        </li>

        @endif        @if(Auth::user()->role === 'siswa')
        <!-- Menu untuk Siswa -->
        <li class="{{ request()->routeIs('jurnal.*') ? 'active' : '' }}">
            <a href="{{ route('jurnal.index') }}">
                <i class="fa fa-book"></i> <span>Jurnal PKL Saya</span>
            </a>
        </li>

        <li class="{{ request()->routeIs('penilaian-berkala.*') ? 'active' : '' }}">
            <a href="{{ route('penilaian-berkala.index') }}">
                <i class="fa fa-star"></i> <span>Nilai Penilaian Saya</span>
            </a>
        </li>
        
        @endif

        @if(Auth::user()->role === 'pimpinan')
        <!-- Menu untuk Pimpinan -->
        <li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <a href="{{ route('dashboard') }}">
                <i class="fa fa-bar-chart"></i> <span>Laporan PKL</span>
            </a>
        </li>
        @endif

        <!-- Menu Profile untuk semua role -->
        <li class="header">PENGATURAN</li>
        <li class="{{ request()->routeIs('profile.*') ? 'active' : '' }}">
            <a href="{{ route('profile') }}">
                <i class="fa fa-user"></i> <span>Profil Saya</span>
            </a>
        </li>

        <li>
            <a href="{{ route('logout') }}" 
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fa fa-sign-out"></i> <span>Logout</span>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </li>

        <!-- Footer Info -->
        <li class="header">INFORMASI SISTEM</li>
        <li class="footer-info">
            <div style="padding: 10px 15px; color: #b8c7ce; font-size: 11px; line-height: 1.4;">
                <div style="border-bottom: 1px solid #3c8dbc; padding-bottom: 8px; margin-bottom: 8px;">
                    <strong style="color: #fff;">SIPKL - SMKN 2 Kota Jambi</strong><br>
                    <small>Sistem Informasi PKL</small>
                </div>
                <div>
                    <i class="fa fa-user text-aqua"></i> <strong>Rahma Dyna</strong><br>
                    <i class="fa fa-id-card text-aqua"></i> 213002030009<br>
                    <i class="fa fa-calendar text-aqua"></i> {{ date('Y') }}
                </div>
            </div>
        </li>
    </ul>
</section>
