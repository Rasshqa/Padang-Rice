<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'register']);
    Route::get('/login', [\App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    
    Route::get('/orders/{order}/payment', [\App\Http\Controllers\PaymentController::class, 'show'])->name('payments.show');
    Route::post('/orders/{order}/payment', [\App\Http\Controllers\PaymentController::class, 'store'])->name('payments.store');
    Route::get('/orders/{order}/payment/upload', [\App\Http\Controllers\PaymentController::class, 'uploadForm'])->name('payments.upload');
    Route::post('/orders/{order}/payment/upload', [\App\Http\Controllers\PaymentController::class, 'uploadProof'])->name('payments.uploadProof');
    Route::get('/orders/{order}/payment/status', [\App\Http\Controllers\PaymentController::class, 'status'])->name('payments.status');
    
    Route::get('/pesanan', [OrderController::class, 'history'])->name('orders.history');
    Route::get('/pesanan/{order}', [OrderController::class, 'show'])->name('orders.show');
});
Route::get('/tentang', [AboutController::class, 'index'])->name('about');
Route::get('/berita', [NewsController::class, 'index'])->name('news.index');
Route::get('/berita/{slug}', [NewsController::class, 'show'])->name('news.show');
Route::get('/galeri', [GalleryController::class, 'index'])->name('gallery');
Route::get('/kontak', [ContactController::class, 'index'])->name('contact.index');
Route::post('/kontak', [ContactController::class, 'store'])->name('contact.store');

Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
Route::get('/menu/{menu}', [MenuController::class, 'show'])->name('menu.show');

Route::get('/keranjang', [CartController::class, 'index'])->name('cart.index');
Route::post('/keranjang/tambah', [CartController::class, 'add'])->name('cart.add');
Route::post('/keranjang/tambah-ajax', [CartController::class, 'addAjax'])->name('cart.add.ajax');
Route::patch('/keranjang/{menu}', [CartController::class, 'update'])->name('cart.update');
Route::patch('/keranjang/{menu}/ajax', [CartController::class, 'updateAjax'])->name('cart.update.ajax');
Route::delete('/keranjang/{menu}', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('/keranjang', [CartController::class, 'clear'])->name('cart.clear');

Route::get('/checkout', [OrderController::class, 'checkout'])->name('orders.checkout')->middleware('auth');
Route::post('/checkout', [OrderController::class, 'store'])->name('orders.store')->middleware('auth');
Route::get('/pesanan/sukses/{order}', [OrderController::class, 'success'])->name('orders.success')->middleware('auth');

Route::middleware('guest:admin')->group(function () {
    Route::get('/admin/login', [\App\Http\Controllers\Admin\AuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/admin/login', [\App\Http\Controllers\Admin\AuthController::class, 'login']);
});

Route::middleware(['auth:admin', 'admin'])->group(function () {
    Route::get('/admin', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');
    Route::post('/admin/logout', [\App\Http\Controllers\Admin\AuthController::class, 'logout'])->name('admin.logout');

    Route::resource('admin/berita', \App\Http\Controllers\Admin\NewsController::class)
        ->parameters(['berita' => 'news'])
        ->names('admin.berita');
    Route::resource('admin/galeri', \App\Http\Controllers\Admin\GalleryController::class)
        ->parameters(['galeri' => 'gallery'])
        ->names('admin.galeri');
    Route::resource('admin/pesan', \App\Http\Controllers\Admin\MessageController::class)
        ->parameters(['pesan' => 'message'])
        ->names('admin.pesan');
    Route::resource('admin/menus', \App\Http\Controllers\Admin\MenuController::class)
        ->names('admin.menus');
    Route::resource('admin/payment-methods', \App\Http\Controllers\Admin\PaymentMethodController::class)
        ->names('admin.payment-methods')
        ->except(['show']);
    Route::get('/admin/orders', [\App\Http\Controllers\Admin\OrderController::class, 'index'])->name('admin.orders.index');
    Route::get('/admin/orders/{order}', [\App\Http\Controllers\Admin\OrderController::class, 'show'])->name('admin.orders.show');
    Route::patch('/admin/orders/{order}/status', [\App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
    Route::get('/admin/payments', [\App\Http\Controllers\Admin\PaymentController::class, 'index'])->name('admin.payments.index');
    Route::get('/admin/payments/{payment}', [\App\Http\Controllers\Admin\PaymentController::class, 'show'])->name('admin.payments.show');
    Route::post('/admin/payments/{payment}/approve', [\App\Http\Controllers\Admin\PaymentController::class, 'approve'])->name('admin.payments.approve');
    Route::post('/admin/payments/{payment}/reject', [\App\Http\Controllers\Admin\PaymentController::class, 'reject'])->name('admin.payments.reject');
    Route::get('/admin/pengaturan', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('admin.settings.index');
    Route::post('/admin/pengaturan', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('admin.settings.update');
});
