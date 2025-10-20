    <ul class="menu">
        <li class="sidebar-title">Menu</li>

        @hasanyrole('administrator|admin|operator')
        <li class="sidebar-item {{ request()->is('dashboard*') ? ' active ' : '' }} ">
            <a href="{{ route('dashboard') }}" class='sidebar-link'>
                <i class="bi bi-grid-fill"></i>
                <span>Dashboard</span>
            </a>
        </li>
        @endhasanyrole

        @hasanyrole('administrator|admin')
        <li class="sidebar-item  has-sub {{ request()->is('master/*') ? 'active' : '' }}">
            <a href="#" class='sidebar-link'>
                <i class="bi bi-stack"></i>
                <span>Data Master</span>
            </a>
            <ul class="submenu">
                @role('administrator')
                <li class="submenu-item {{ request()->is('master/page-category*') ? 'active' : '' }}">
                    <a href="{{ route('master.page-category.index') }}" class="submenu-link">Kategori Halaman</a>
                </li>
                @endrole
                @role('administrator')
                <li class="submenu-item {{ request()->is('master/blog-category*') ? 'active' : '' }}">
                    <a href="{{  route('master.blog-category.index')}}" class="submenu-link">Kategori Blog</a>
                </li>
                @endrole
                @role('administrator')
                <li class="submenu-item {{ request()->is('master/programstudi*') ? 'active' : '' }}">
                     <a href="{{ route('master.programstudi.index') }}" class="submenu-link">Program Studi</a>
                </li>
                @endrole
                @role('administrator')
                <li class="submenu-item {{ request()->is('master/category_tag*') ? 'active' : '' }}">
                    <a href="{{  route('master.category_tag.index')}}" class="submenu-link">Kategori tag</a>
                </li>
                @endrole
            </ul>
        </li>
        @endhasanyrole

        @hasanyrole('administrator')
        <li class="sidebar-item  has-sub {{ request()->is('users*') ? 'active' : '' }}">
            <a href="#" class='sidebar-link'>
                <i class="bi bi-shield-check"></i>
                <span>Management Akses</span>
            </a>
            <ul class="submenu">
                <li class="submenu-item {{ request()->is('users') ? 'active' : '' }}">
                    <a href="{{  route('users.index')}}" class="submenu-link">Data User</a>
                </li>
                <li class="submenu-item {{ request()->is('users/roles*') ? 'active' : '' }}">
                    <a href="{{ route('users.roles.index') }}" class="submenu-link">Data Role</a>
                </li>
                <li class="submenu-item {{ request()->is('users/permission*') ? 'active' : '' }}">
                    <a href="{{  route('users.permission.index')}}" class="submenu-link">Data Permission</a>
                </li>
            </ul>
        </li>
        @endhasanyrole

        @hasanyrole('administrator|admin')
        <li class="sidebar-item  has-sub">
            <a href="#" class='sidebar-link'>
                <i class="bi bi-person-workspace"></i>
                <span>Kurikulum</span>
            </a>

            <ul class="submenu">
                <li class="submenu-item">
                    <a href="#" class="submenu-link">Praktikum</a>
                </li>
                <li class="submenu-item">
                    <a href="#" class="submenu-link">Tugas Akhir Mahasiswa</a>
                </li>
                <li class="submenu-item">
                    <a href="#" class="submenu-link">Prestasi Mahasiswa</a>
                </li>
                <li class="submenu-item">
                    <a href="#" class="submenu-link">Praktik Kerja Nyata</a>
                </li>
                <li class="submenu-item">
                    <a href="#" class="submenu-link">Unduhan</a>
                </li>
            </ul>
        </li>
        @endhasanyrole

        @hasanyrole('administrator|admin')
        <li class="sidebar-item {{ request()->is('adm/blog*') ? 'active' : '' }}">
            <a href="{{ route('adm.blog.index') }}" class='sidebar-link'>
                <i class="bi bi-newspaper"></i>
                <span>Blog & Artikel</span>
            </a>
        </li>
        @endhasanyrole

        <li class="sidebar-item pt-5">
            <a class='sidebar-link badge bg-danger text-light' href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
                <i class="bi bi-box-arrow-left text-light"></i>
                <span>Logout</span>
            </a>
        </li>
    </ul>
