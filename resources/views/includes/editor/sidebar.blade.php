       <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-text mx-3">STM Admin <sup>2</sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">


            <!-- Heading -->
            <div class="sidebar-heading">
                <br>
                Interface
            </div>

            <!-- Nav Item - Halam utama -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Halaman utama</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Edit Components:</h6>
                        <a class="collapse-item" href="{{ route('editor.master-head') }}">Master Head</a>
                        <a class="collapse-item" href="{{ route('editor.keunggulan-kami') }}">Keunggulan Kami</a>
                    </div>
                </div>
            </li>

            <!-- Nav Item - Tentang -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Tentang Kami</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Edit Components</h6>
                        <a class="collapse-item" href="{{ route('editor.profile-perusahaan') }}">Profil Perusahaan</a>
                        <a class="collapse-item" href="{{ route('editor.sertifikat') }}">Sertifikat Perusahaan</a>
                    </div>
                </div>
            </li>

            <!-- Divider -->
        

            <!-- Heading -->
          
            <!-- Nav Item - Layanan Kami -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('editor.layanan-kami') }}">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Layanan Kami</span>
                </a>


            <!-- Nav Item - Berita -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('editor.news') }}">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Berita</span></a>
            </li>

            <!-- Nav Item - Hubungi Kami -->
            <li class="nav-item">
                <a class="nav-link" href="{{ route('editor.alamat-kantor') }}">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Hubungi kami</span></a>
            </li>

            

             <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Footer -->
           <li class="nav-item">
                <a class="nav-link" href="{{ route('editor.footer') }}">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Footer</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('editor.kebijakan-privasi') }}">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Kebijakan Privasi</span></a>
            </li>

             <!-- Divider -->

            <hr class="sidebar-divider my-0">

            <li class="nav-item">
                <a class="nav-link" href="{{ route('editor.hubungi-kami') }}">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Pesan</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">
             <li class="nav-item {{  Request::is('editor/users') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('editor.users') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>User</span></a>
            </li>

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>