<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">Grapegrow</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">GA</a>
        </div>
        <ul class="sidebar-menu">
            <li class="nav-item dropdown">
                <a href="home"><span>Dashboard</span></a>
            </li>
            <li class="nav-item dropdown">
                <a href="#"
                    class="nav-link has-dropdown"><span>Users</span></a>
                <ul class="dropdown-menu">
                    <li>
                        <a class="nav-link"
                            href="{{ route('user.index') }}">All Users</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a href="#"
                    class="nav-link has-dropdown"><span>Varietas Anggur</span></a>
                <ul class="dropdown-menu">
                    <li>
                        <a class="nav-link"
                            href="{{ route('varietas.index') }}">All Varietas</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item dropdown">
                <a href="#"
                    class="nav-link has-dropdown"><span>Hama & Penyakit Anggur</span></a>
                <ul class="dropdown-menu">
                    <li>
                        <a class="nav-link"
                            href="{{ route('hama.index') }}">All Hama</a>
                    </li>
                </ul>
            </li>
        </ul>
    </aside>
</div>
