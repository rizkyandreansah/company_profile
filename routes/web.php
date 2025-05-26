<?php

use App\Http\Controllers\editor\AuthController;
use App\Http\Controllers\editor\HomeController;
use App\Http\Controllers\editor\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::controller(AuthController::class)->middleware('guest')->group(function(){
    route::get('login','index')->name('login');
    route::post('login/auth','authenticate')->name('login.auth');
});

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
    
});