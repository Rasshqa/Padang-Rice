<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\ContactController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/tentang', [AboutController::class, 'index'])->name('about');
Route::get('/berita', [NewsController::class, 'index'])->name('news.index');
Route::get('/berita/{slug}', [NewsController::class, 'show'])->name('news.show');
Route::get('/galeri', [GalleryController::class, 'index'])->name('gallery');
Route::get('/kontak', [ContactController::class, 'index'])->name('contact.index');
Route::post('/kontak', [ContactController::class, 'store'])->name('contact.store');

Route::middleware('guest:admin')->group(function () {
    Route::get('/admin/login', [\App\Http\Controllers\Admin\AuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/admin/login', [\App\Http\Controllers\Admin\AuthController::class, 'login']);
});

Route::middleware(['auth:admin', 'admin'])->group(function () {
    Route::get('/admin', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');
    Route::post('/admin/logout', [\App\Http\Controllers\Admin\AuthController::class, 'logout'])->name('admin.logout');

    Route::resource('admin/berita', \App\Http\Controllers\Admin\NewsController::class);
    Route::resource('admin/galeri', \App\Http\Controllers\Admin\GalleryController::class);
    Route::resource('admin/pesan', \App\Http\Controllers\Admin\MessageController::class);
    Route::get('/admin/pengaturan', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('admin.settings.index');
    Route::post('/admin/pengaturan', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('admin.settings.update');
});
