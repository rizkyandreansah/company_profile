@extends('layouts.compro')

@section('style')
<link href="{{ asset('compro/css/section/layanan.css') }}" rel="stylesheet">
<link href="{{ asset('compro/css/section/tentangkami.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="layanan-container">
        <div class="service-section">
            <div class="service-header">
                <h1 class="layanan-title">Layanan Kami</h1>
                <div class="title-divider"></div>
                <div class="company-highlight">
                    <strong>
                        {{ $headline ?? 'Layanan Profesional untuk Kebutuhan Anda' }}
                    </strong>
                </div>
            </div>
        </div>
        
        <div class="services-grid">
            @if($layananList && $layananList->count() > 0)
                @foreach($layananList as $layanan)
                    <div class="service-card">
                        <h3 class="service-title">{{ $layanan->judul_layanan }}</h3>
                        <p class="service-description">{{ $layanan->deskripsi_layanan }}</p>
                    </div>
                @endforeach
            @else
                <div class="no-services">
                    <p>Belum ada layanan yang tersedia saat ini.</p>
                </div>
            @endif
        </div>
    </div>
@endsection