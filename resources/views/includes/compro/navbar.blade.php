<nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
            <div class="container">
                <a class="navbar-brand" href="{{ route('home')}}">
                    <img src="{{ asset('compro/assets/img/logo.png') }}" alt="..." />
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    Menu
                    <i class="fas fa-bars ms-1"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav text-uppercase ms-auto py-4 py-lg-0">
                        <li class="nav-item"><a class="nav-link" href="{{ route('about') }}">Tentang Kami</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('layanan') }}">Layanan</a></li> 
                        <li class="nav-item"><a class="nav-link" href="{{ route('berita') }}">Berita</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('hubungikami') }}">Hubungi Kami</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        