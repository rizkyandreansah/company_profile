@extends('layouts.compro')

 <!-- Home Section -->

@section('style')
<link href="{{ asset('compro/css/section/home.css') }}" rel="stylesheet">
@endsection

@section('content')

          <!-- Loader Overlay -->
        <div class="loader-overlay" id="loaderOverlay">
            <div class="loader">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>

        <header class="masthead">
            <div class="container">
                <div class="masthead-subheading" id="masthead-title">"Moto"</div>
                <div class="masthead-heading text-uppercase" id="masthead-subtitle">Profil Singkat</div>
            </div>
        </header>

<section>
         <div class="keunggulan-section">
        <h2 class="section-title">Keunggulan Kami</h2> 
        <div class="title-divider"></div>
        
        <div class="keunggulan-grid" id="keunggulan-container">
            <!-- Default loading state -->
            <div class="keunggulan-loading" id="keunggulan-loading">
                <p>Memuat keunggulan kami...</p>
            </div>
            
            <!-- Fallback content jika tidak ada data -->
            <div class="keunggulan-empty" id="keunggulan-empty" style="display: none;">
                <p>Belum ada data keunggulan yang tersedia.</p>
            </div>
        </div>
    </div>
</section>

@endsection

@section('script')
<script>
$('document').ready(function(e){
    $.ajax({
        url: "{{ route('home.data') }}" ,
        method: 'GET',
        beforeSend: function(){
            // Tampilkan loader sebelum request dimulai
            $('#loaderOverlay').addClass('loader-show');
            $('#keunggulan-loading').show();
        },
        success: function(response){
            // Handle master head data
            let masterhead = response.master_head;
            if(masterhead) {
                $('#masthead-title').empty().text(masterhead.title);
                $('#masthead-subtitle').empty().text(masterhead.subtitle);
                $('.masthead').css({
                    'background-image': `url("/storage/${masterhead.image}")`
                });
            }
            
            // Handle keunggulan kami data
            let keunggulanKami = response.keunggulan_kami;
            let keunggulanContainer = $('#keunggulan-container');
            
            // Hapus loading state
            $('#keunggulan-loading').hide();
            
            if(keunggulanKami && keunggulanKami.length > 0) {
                // Clear existing content
                keunggulanContainer.empty();
                
                // Build HTML untuk setiap keunggulan
                keunggulanKami.forEach(function(item) {
                    let iconSrc = item.gambar_ikon || '/assets/images/default-icon.svg';
                    let iconAlt = item.judul || 'ICON';
                    
                    let keunggulanItem = `
                        <div class="keunggulan-item">
                            <div class="icon-container">
                                <img src="${iconSrc}" alt="${iconAlt}" class="icon" onerror="this.src='/assets/images/default-icon.svg'">
                            </div>
                            <h3 class="keunggulan-title">${item.judul}</h3>
                            <p class="keunggulan-description">${item.deskripsi}</p>
                        </div>
                    `;
                    
                    keunggulanContainer.append(keunggulanItem);
                });
            } else {
                // Tampilkan pesan jika tidak ada data
                $('#keunggulan-empty').show();
            }
            
            // Delay 2 detik setelah success
            setTimeout(function() {
                // Sembunyikan loader setelah delay
                $('#loaderOverlay').removeClass('loader-show');
            }, 2000);
        },
        error: function(xhr, status, error) {
            // Handle error
            console.log('Error:', error);
            $('#keunggulan-loading').hide();
            
            // Tampilkan pesan error atau fallback content
            let keunggulanContainer = $('#keunggulan-container');
            keunggulanContainer.html(`
                <div class="keunggulan-error">
                    <p>Terjadi kesalahan saat memuat data keunggulan.</p>
                </div>
            `);
            
            // Tetap sembunyikan loader meskipun error
            setTimeout(function() {
                $('#loaderOverlay').removeClass('loader-show');
            }, 2000);
        },
        complete: function(){
            // Complete function kosong karena delay sudah ditangani di success dan error
        }
    });
});
</script>
@endsection