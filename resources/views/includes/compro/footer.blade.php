@php
    $footerData = App\Models\Footer::getFooterWithDefault();
@endphp

<footer class="footer-section">
    <div class="container">
        <div class="footer-content">
            <div class="footer-logo">
                <img src="{{ asset('compro/assets/img/logo.png') }}" alt="PT STM Logo" />
            </div>
            <div class="footer-info">
                <h3>PT. Serasi Tunggal Mandiri</h3>
                <p>{!! $footerData->profil_singkat !!}</p>
                
                <div class="footer-office">
                    <h4>Kantor Pusat Kami</h4>
                    <p>{!! $footerData->alamat_kantor !!}</p>
                </div>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>© {{ date('Y') }} PT. Serasi Tunggal Mandiri. All rights reserved.</p>
            <div class="footer-links">
                <a href="{{ route('kebijakan.privasi') }}">Kebijakan Privasi</a>
                <!-- Bisa tambahkan link lain jika diperlukan -->
            </div>
        </div>
    </div>
</footer>