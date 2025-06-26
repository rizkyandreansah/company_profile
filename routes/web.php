<?php

use App\Http\Controllers\compro\HomeComproController;
use App\Http\Controllers\compro\TentangKamiComproController;
use App\Http\Controllers\compro\FooterComproController; // TAMBAHAN BARU
use App\Http\Controllers\Compro\LayananComproController;
use App\Http\Controllers\Compro\HubungiKamiComproController;
use App\Http\Controllers\compro\KebijakanPrivasiComproController;
use App\Http\Controllers\compro\BeritaController;
use App\Http\Controllers\editor\AuthController;
use App\Http\Controllers\editor\HomeController;
use App\Http\Controllers\editor\MasterHeadController;
use App\Http\Controllers\editor\NewsController;
use App\Http\Controllers\editor\UserController;
use App\Http\Controllers\editor\ProfilePerusahaanController;
use App\Http\Controllers\Editor\KeunggulanKamiController;
use App\Http\Controllers\Editor\LayananKamiController;
use App\Http\Controllers\Editor\SertifikatController;
use App\Http\Controllers\editor\AlamatKantorController;
use App\Http\Controllers\Editor\FooterController;
use App\Http\Controllers\Editor\KebijakanPrivasiController;
use App\Http\Controllers\Editor\HubungiKamiController; // TAMBAHAN BARU UNTUK ADMIN
use Illuminate\Support\Facades\Route;

Route::controller(HomeComproController::class)->group(function(){
    Route::get('/', 'index')->name('home');
    Route::get('/data', 'getData')->name('home.data'); 
});

// Update route tentang-kami untuk mendukung getData dan getSertifikatData
Route::controller(TentangKamiComproController::class)->group(function(){
    Route::get('/tentang-kami', 'index')->name('about');
    Route::get('/tentang-kami/data', 'getData')->name('about.data');
    Route::get('/tentang-kami/sertifikat-data', 'getSertifikatData')->name('about.sertifikat.data');
});

// Route untuk Berita
Route::controller(BeritaController::class)->group(function(){
    Route::get('/berita', 'index')->name('berita');
    Route::get('/berita/data', 'getData')->name('berita.data');
});

// Route untuk Layanan 
Route::controller(LayananComproController::class)->group(function(){
    Route::get('/layanan', 'index')->name('layanan');
    Route::get('/layanan/data', 'getData')->name('layanan.data');
});

// route untuk Hubungi Kami - UPDATED WITH SUBMIT ROUTE
Route::controller(HubungiKamiComproController::class)->group(function(){
    Route::get('/hubungi-kami', 'index')->name('hubungikami');
    Route::get('/hubungi-kami/data', 'getData')->name('hubungikami.data'); 
    Route::post('/hubungi-kami/submit', 'submitForm')->name('hubungikami.submit'); // Route untuk submit form
});

// Route untuk Footer - TAMBAHAN BARU
Route::controller(FooterComproController::class)->group(function(){
    Route::get('/footer', 'index')->name('footer');
    Route::get('/footer/data', 'getData')->name('footer.data');
});

// Route Kebijakan Privasi
Route::controller(KebijakanPrivasiComproController::class)->group(function(){
    Route::get('/kebijakan-privasi', 'index')->name('kebijakan.privasi');
    Route::get('/kebijakan-privasi/data', 'getData')->name('kebijakan.privasi.data');
});

//Route Auth
Route::controller(AuthController::class)->middleware('guest')->group(function(){
    route::get('login','index')->name('login');
    route::post('login/auth','authenticate')->name('login.auth');
});

//Route Editor (CRUD Compro)
Route::prefix('editor')->middleware('auth')->group(function(){
    Route::controller(AuthController::class)->group(function(){
          route::post('logout','logout')->name('logout');
    });
    Route::controller(HomeController::class)->group(function(){
        Route::get('/','index')->name('editor.home');
    });
    Route::controller(UserController::class)->group(function(){
        Route::get('/users','index')->name('editor.users');
        Route::get('/users/data','getData')->name('editor.users.data');
        Route::post('/users/store','storeData')->name('editor.users.store');
        Route::get('/users/detail','detail')->name('editor.users.detail');
        Route::post('/users/update','updateData')->name('editor.users.update');
        Route::delete('/users/delete','deleteData')->name('editor.users.delete');
    });
    Route::controller(MasterHeadController::class)->group(function(){
        Route::get('/master-head','index')->name('editor.master-head');
        Route::get('/master-head/data','getData')->name('editor.master-head.data');
        Route::post('/master-head/store','storeData')->name('editor.master-head.store');
        Route::get('/master-head/detail','detail')->name('editor.master-head.detail');
        Route::post('/master-head/update','updateData')->name('editor.master-head.update');
        Route::delete('/master-head/delete','deleteData')->name('editor.master-head.delete');
    });
    Route::controller(NewsController::class)->group(function(){
        Route::get('/news','index')->name('editor.news');
        Route::get('/news/data','getData')->name('editor.news.data');
        Route::post('/news/store','storeData')->name('editor.news.store');
        Route::get('/news/detail','detail')->name('editor.news.detail');
        Route::post('/news/update','updateData')->name('editor.news.update');
        Route::delete('/news/delete','deleteData')->name('editor.news.delete');
    });
    // Profile Perusahaan Routes
    Route::controller(ProfilePerusahaanController::class)->group(function(){
        Route::get('/profile-perusahaan','index')->name('editor.profile-perusahaan');
        Route::get('/profile-perusahaan/data','getData')->name('editor.profile-perusahaan.data');
        Route::post('/profile-perusahaan/store','storeData')->name('editor.profile-perusahaan.store');
        Route::get('/profile-perusahaan/detail','detail')->name('editor.profile-perusahaan.detail');
        Route::post('/profile-perusahaan/update','updateData')->name('editor.profile-perusahaan.update');
        Route::delete('/profile-perusahaan/delete','deleteData')->name('editor.profile-perusahaan.delete');
    });
    // Keunggulan Kami Routes
    Route::controller(KeunggulanKamiController::class)->group(function(){
        Route::get('/keunggulan-kami','index')->name('editor.keunggulan-kami');
        Route::get('/keunggulan-kami/data','data')->name('editor.keunggulan-kami.data');
        Route::post('/keunggulan-kami/store','store')->name('editor.keunggulan-kami.store');
        Route::get('/keunggulan-kami/detail','detail')->name('editor.keunggulan-kami.detail');
        Route::post('/keunggulan-kami/update','update')->name('editor.keunggulan-kami.update');
        Route::delete('/keunggulan-kami/delete','delete')->name('editor.keunggulan-kami.delete');
    });
    
    // Layanan Kami Routes
    Route::controller(LayananKamiController::class)->group(function(){
        Route::get('/layanan-kami','index')->name('editor.layanan-kami');
        Route::get('/layanan-kami/data','getData')->name('editor.layanan-kami.data');
        Route::post('/layanan-kami/store','storeData')->name('editor.layanan-kami.store');
        Route::get('/layanan-kami/detail','detail')->name('editor.layanan-kami.detail');
        Route::post('/layanan-kami/update','updateData')->name('editor.layanan-kami.update');
        Route::delete('/layanan-kami/delete','deleteData')->name('editor.layanan-kami.delete');
    });

    // Sertifikat Routes
    Route::controller(SertifikatController::class)->group(function(){
        Route::get('/sertifikat','index')->name('editor.sertifikat');
        Route::get('/sertifikat/data','getData')->name('editor.sertifikat.data');
        Route::post('/sertifikat/store','storeData')->name('editor.sertifikat.store');
        Route::get('/sertifikat/detail','detail')->name('editor.sertifikat.detail');
        Route::post('/sertifikat/update','updateData')->name('editor.sertifikat.update');
        Route::delete('/sertifikat/delete','deleteData')->name('editor.sertifikat.delete');
    });

    // Alamat Kantor Routes
    Route::controller(AlamatKantorController::class)->group(function(){
        Route::get('/alamat-kantor','index')->name('editor.alamat-kantor');
        Route::get('/alamat-kantor/data','getData')->name('editor.alamat-kantor.data');
        Route::post('/alamat-kantor/store','storeData')->name('editor.alamat-kantor.store');
        Route::get('/alamat-kantor/detail','detail')->name('editor.alamat-kantor.detail');
        Route::post('/alamat-kantor/update','updateData')->name('editor.alamat-kantor.update');
        Route::delete('/alamat-kantor/delete','deleteData')->name('editor.alamat-kantor.delete');
    });

    // Footer Routes
    Route::controller(FooterController::class)->group(function(){
        Route::get('/footer','index')->name('editor.footer');
        Route::get('/footer/data','getData')->name('editor.footer.data');
        Route::post('/footer/store','storeData')->name('editor.footer.store');
        Route::get('/footer/detail','detail')->name('editor.footer.detail');
        Route::post('/footer/update','updateData')->name('editor.footer.update');
        Route::delete('/footer/delete','deleteData')->name('editor.footer.delete');
    });

    // Kebijakan Privasi Routes - TAMBAHAN BARU
    Route::controller(KebijakanPrivasiController::class)->group(function(){
        Route::get('/kebijakan-privasi','index')->name('editor.kebijakan-privasi');
        Route::get('/kebijakan-privasi/data','getData')->name('editor.kebijakan-privasi.data');
        Route::post('/kebijakan-privasi/store','storeData')->name('editor.kebijakan-privasi.store');
        Route::get('/kebijakan-privasi/detail','detail')->name('editor.kebijakan-privasi.detail');
        Route::post('/kebijakan-privasi/update','updateData')->name('editor.kebijakan-privasi.update');
        Route::delete('/kebijakan-privasi/delete','deleteData')->name('editor.kebijakan-privasi.delete');
    });

    // Hubungi Kami Admin Routes - TAMBAHAN BARU UNTUK MENGELOLA PESAN
    Route::controller(HubungiKamiController::class)->group(function(){
        Route::get('/hubungi-kami','index')->name('editor.hubungi-kami');
        Route::get('/hubungi-kami/data','getData')->name('editor.hubungi-kami.data');
        Route::get('/hubungi-kami/detail','detail')->name('editor.hubungi-kami.detail');
        Route::post('/hubungi-kami/toggle-read','toggleRead')->name('editor.hubungi-kami.toggle-read');
        Route::delete('/hubungi-kami/delete','deleteData')->name('editor.hubungi-kami.delete');
        Route::get('/hubungi-kami/stats','getStats')->name('editor.hubungi-kami.stats');
    });
});