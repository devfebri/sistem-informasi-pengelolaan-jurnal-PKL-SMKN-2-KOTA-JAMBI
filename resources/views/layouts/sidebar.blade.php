<section class="sidebar">
    <!-- Sidebar user panel -->

    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
        {{-- <li class="header">{{ auth()->user()->name }}</li> --}}
        @if(auth()->user()->role === 'admin')
        <li class="{{ request()->routeIs('instansi.*') ? 'active' : '' }}">
            <a href="{{ route('instansi.index') }}">
                <i class="fa fa-th"></i> <span>Instansi</span>
            </a>
        </li>
        <li class="{{ request()->routeIs('user.*') ? 'active' : '' }}">
            <a href="{{ route('user.index') }}">
                <i class="fa fa-th"></i> <span>User</span>
            </a>
        </li>
        @endif

        @if(auth()->user()->role === 'guru')
         <li class="{{ request()->routeIs('jurnal.*') ? 'active' : '' }}">
             <a href="{{ route('jurnal.index') }}">
                 <i class="fa fa-book"></i> <span>Jurnal PKL</span>
             </a>
         </li>

        {{-- <li class="{{ request()->routeIs('penilaian.*') ? 'active' : '' }}">
            <a href="{{ route('penilaian.index') }}">
                <i class="fa fa-star"></i> <span>Penilaian</span>
            </a>
        </li> --}}
        @endif

        @if(auth()->user()->role === 'siswa')
        <li class="{{ request()->routeIs('jurnal.*') ? 'active' : '' }}">
            <a href="{{ route('jurnal.index') }}">
                <i class="fa fa-book"></i> <span>Jurnal PKL</span>
            </a>
        </li>
        @endif
    </ul>
</section>
