@extends('layouts.compro')


@section('style')
<link href="{{ asset('compro/css/section/berita.css') }}" rel="stylesheet">
@endsection

@section('content')
    <section class="news-section">
        <div class="section-header">
            <h2 class="section-title">Berita Terbaru Dari Kami</h2>
            <div class="title-divider"></div>
        </div>
        
        <div class="news-grid" id="news-container">
            @if($news && $news->count() > 0)
                @foreach($news as $item)
                    <div class="news-card">
                        <div class="news-image">
                            @if($item->image)
                                <img src="/storage/{{ $item->image }}" alt="{{ $item->judul }}" onerror="this.src='/assets/img/no-image.jpg'">
                            @else
                                <img src="/assets/img/no-image.jpg" alt="{{ $item->judul }}">
                            @endif
                        </div>
                        <div class="news-content">
                            <div class="news-date">{{ $item->tanggal_publish->format('d F Y') }}</div>
                            <h4>{{ $item->judul }}</h4>
                            <p class="news-excerpt">
                                {{ Str::limit(strip_tags($item->isiberita), 100, '...') }}
                            </p>
                            <button class="news-btn" onclick="openNewsModal({{ $item->id }})">
                                Baca Selengkapnya
                                <span>→</span>
                            </button>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="no-news">
                    <p>Belum ada berita yang tersedia.</p>
                </div>
            @endif
        </div>

        <!-- News Modals -->
        @if($news && $news->count() > 0)
            @foreach($news as $item)
                <div class="news-modal-overlay" id="newsModal{{ $item->id }}">
                    <div class="news-modal-container">
                        <div class="news-modal-header">
                            <h3>Serasi Tunggal Mandiri</h3>
                            <button class="news-modal-close" onclick="closeNewsModal({{ $item->id }})">&times;</button>
                        </div>
                        <div class="news-modal-body">
                            <div class="news-modal-image">
                                @if($item->image)
                                    <img src="/storage/{{ $item->image }}" alt="{{ $item->judul }}" onerror="this.src='/assets/img/no-image.jpg'">
                                @else
                                    <img src="/assets/img/no-image.jpg" alt="{{ $item->judul }}">
                                @endif
                            </div>
                            <div class="news-meta">
                                <div class="news-date-detail">{{ $item->tanggal_publish->format('d F Y') }}</div>
                            </div>
                            <div class="news-full-content">
                                <h4>{{ $item->judul }}</h4>
                                <div>{!! $item->isiberita !!}</div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </section>
@endsection

@section('script')

@endsection