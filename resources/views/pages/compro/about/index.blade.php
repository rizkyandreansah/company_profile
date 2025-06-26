@extends('layouts.compro')

@section('style')
<link href="{{ asset('compro/css/section/tentangkami.css') }}" rel="stylesheet">
@endsection

@section('content')
 <!-- About Section -->
        <section id="about" class="about-section">
            <div class="container">
                <div class="section-header">
                    <h2 class="section-title">Tentang Kami</h2>
                    <div class="title-divider"></div>
                </div>
                
                <div class="about-content">
                    <!-- Company Profile -->
                    <div class="profile-card" onclick="openModal()" style="cursor: pointer;">
                        <div class="card-icon">
                            <svg width="50" height="50" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0H5m0 0H3m6-10h6m-6 4h6m-3-7h.01" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <h3>Profil Perusahaan</h3>
                        <p>{!! $profilePerusahaan->isi_singkat_profil !!}</p>
                        <p style="color: #3182ce; font-weight: 600; margin-top: 15px;">
                            <i class="fas fa-external-link-alt" style="margin-right: 5px;"></i>
                            Klik untuk membaca selengkapnya
                        </p>
                    </div>

                    <!-- Vision and Mission Grid -->
                    <div class="vision-mission-grid">
                        <!-- Vision -->
                        <div class="vm-card vision-card">
                            <div class="vm-icon">
                                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2"/>
                                </svg>
                            </div>
                            <h4>Visi</h4>
                            <p>{!! $profilePerusahaan->visi !!}</p>
                        </div>

                        <!-- Mission -->
                        <div class="vm-card mission-card">
                            <div class="vm-icon">
                                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9 11l3 3L22 4M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            <h4>Misi</h4>
                            <p>{!! $profilePerusahaan->misi !!}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

         <!-- Company Modal -->
        <div class="modal-overlay" id="companyModal">
            <div class="modal-container">
                <div class="modal-header">
                    <h3>Profil Perusahaan PT. Serasi Tunggal Mandiri</h3>
                    <button class="modal-close" onclick="closeModal()">&times;</button>
                </div>
                <div class="modal-body">
                    <h4>Sejarah Perusahaan</h4>
                    <p>{!! $profilePerusahaan->isi_lengkap_profil !!}</p>
                </div>
            </div>
        </div>

        <!-- Portfolio - Sertifikat Section -->
        <div class="sertifikat-container">
            <div class="sertifikat-header">
                <h1 class="sertifikat-title">Pencapaian Sertifikat Perusahaan</h1>
                <div class="title-divider"></div>
                <p class="sertifikat-subtitle">Pengakuan atas dedikasi kami dalam memberikan layanan pengelolaan gedung terbaik</p>
            </div>

        <div class="sertifikat-timeline-wrapper">
        <div class="sertifikat-line"></div>

            @if($sertifikat->count() > 0)
                @foreach($sertifikat as $cert)
                <!-- Sertifikat Item -->
                <div class="certificate-item">
                    <div class="certificate-content">
                        <div class="certificate-date">{{ $cert->tanggal_terbit->format('d F Y') }}</div>
                        <h2 class="certificate-title">{{ $cert->judul }}</h2>
                        <div class="certificate-issuer">Diterbitkan oleh: {{ $cert->penerbit }}</div>
                        <div class="certificate-description">
                            {!! $cert->deskripsi !!}
                        </div>
                    </div>
                    <div class="timeline-dot"></div>
                    <div class="certificate-image">
                        <div class="certificate-card">
                            @if($cert->image)
                                <img src="{{ $cert->image_url }}" 
                                     alt="{{ $cert->judul }}" 
                                     class="certificate-img" 
                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            @endif
                            <div class="certificate-img-placeholder" style="{{ $cert->image ? 'display: none;' : 'display: flex;' }}">
                                <svg width="60" height="60" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 2h12a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4a2 2 0 012-2z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <span>Gambar Tidak Tersedia</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <!-- No Certificate Message -->
                <div class="no-certificate-message">
                    <div class="no-cert-icon">
                        <svg width="80" height="80" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <h3>Belum Ada Sertifikat</h3>
                    <p>Sertifikat perusahaan akan ditampilkan di sini setelah ditambahkan.</p>
                </div>
            @endif
        </div>
@endsection

@section('script')
<script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add scroll animation
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -100px 0px'
            };

            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);

            // Initialize animation for certificate items
            const certificateItems = document.querySelectorAll('.certificate-item');
            certificateItems.forEach(item => {
                item.style.opacity = '0';
                item.style.transform = 'translateY(50px)';
                item.style.transition = 'all 0.6s ease-out';
                observer.observe(item);
            });

            // Initialize animation for vision-mission cards
            const vmCards = document.querySelectorAll('.vm-card');
            vmCards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(50px)';
                card.style.transition = `all 0.6s ease-out ${index * 0.2}s`; // Staggered animation
                observer.observe(card);
            });

            // Initialize animation for profile card
            const profileCard = document.querySelector('.profile-card');
            if (profileCard) {
                profileCard.style.opacity = '0';
                profileCard.style.transform = 'translateY(50px)';
                profileCard.style.transition = 'all 0.6s ease-out';
                observer.observe(profileCard);
            }
        });
</script>
@endsection