@extends('layouts.compro')

@section('style')
<link href="{{ asset('compro/css/section/kebijakanprivasi.css') }}" rel="stylesheet">
@endsection

@section('content')
<section class="privacy-policy-section">
    <div class="container">
        <div class="privacy-section-header">
            <h1 class="privacy-section-title">Kebijakan Privasi</h1>
            <div class="title-underline"></div>
            <p class="section-subtitle">Kami berkomitmen untuk melindungi privasi dan data pribadi Anda</p>
        </div>

        <div class="privacy-content">
            @if(isset($kebijakanPrivasiList) && $kebijakanPrivasiList->count() > 0)
                @foreach($kebijakanPrivasiList as $kebijakanPrivasi)
                    <div class="privacy-item">
                        <div class="privacy-header">
                            <h2>{{ $kebijakanPrivasi->judul }}</h2>
                        </div>
                        <div class="privacy-body">
                            <p>{{ $kebijakanPrivasi->content }}</p>
                        </div>
                    </div>
                @endforeach
            @else
                <!-- Fallback content jika tidak ada data di database -->
                <div class="privacy-item">
                    <div class="privacy-header">
                        <h2>Perlindungan Data Pribadi</h2>
                    </div>
                    <div class="privacy-body">
                        <p>Kami mengumpulkan dan memproses data pribadi Anda dengan penuh tanggung jawab sesuai dengan peraturan perlindungan data yang berlaku. Data yang kami kumpulkan meliputi: Informasi kontak yang Anda berikan melalui formulir kontak (nama, email, nomor telepon), Pesan atau pertanyaan yang Anda kirimkan kepada kami, Semua data pribadi Anda disimpan dengan aman menggunakan enkripsi dan hanya dapat diakses oleh personel yang berwenang.</p>
                    </div>
                </div>

                <div class="privacy-item">
                    <div class="privacy-header">
                        <h2>Berbagi Informasi</h2>
                    </div>
                    <div class="privacy-body">
                        <p>Kami berkomitmen untuk tidak membagikan, menjual, atau menyewakan data pribadi Anda kepada pihak ketiga tanpa persetujuan Anda, Setiap berbagi informasi akan dilakukan dengan standar keamanan yang ketat dan sesuai dengan ketentuan hukum yang berlaku.</p>
                    </div>
                </div>

                <div class="privacy-item">
                    <div class="privacy-header">
                        <h2>Pembaruan Kebijakan</h2>
                    </div>
                    <div class="privacy-body">
                        <p>Kebijakan privasi ini dapat diperbarui dari waktu ke waktu untuk mencerminkan perubahan dalam praktik atau peraturan hukum. Kami mendorong Anda untuk meninjau kebijakan privaci ini secara berkala untuk tetap mengetahui bagaimana kami melindungi informasi Anda.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section> 
@endsection