<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RumahController;
use App\Http\Controllers\BudidayaController;
use App\Http\Controllers\PetaController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PublicController;

// Public Routes
Route::get('/', [PublicController::class, 'home'])->name('home');

Route::get('/budidaya/index', [PublicController::class, 'budidaya'])
    ->name('public.budidaya.index');

Route::get('/budidaya/detail/{id}', [PublicController::class, 'budidayaDetail'])
    ->name('public.budidaya.detail');

Route::get('/budidaya/kategori/{kategoriId}', [PublicController::class, 'filterByKategori'])
    ->name('public.budidaya.filter');

Route::get('/budidaya/search', [PublicController::class, 'search'])
    ->name('public.budidaya.search');

// Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Warga Routes (Dashboard)
    Route::get('/dashboard', [DashboardController::class, 'warga'])->name('dashboard');
    
    Route::prefix('rumah')->name('rumah.')->group(function () {
        Route::get('/', [RumahController::class, 'index'])->name('index');
        Route::get('/create', [RumahController::class, 'create'])->name('create');
        Route::post('/', [RumahController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [RumahController::class, 'edit'])->name('edit');
        Route::put('/{id}', [RumahController::class, 'update'])->name('update');
    });
    
    Route::prefix('budidaya')->name('budidaya.')->group(function () {
        Route::get('/', [BudidayaController::class, 'index'])->name('index');
        Route::get('/create', [BudidayaController::class, 'create'])->name('create');
        Route::post('/', [BudidayaController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [BudidayaController::class, 'edit'])->name('edit');
        Route::put('/{id}', [BudidayaController::class, 'update'])->name('update');
        Route::delete('/{id}', [BudidayaController::class, 'destroy'])->name('destroy');
    });
    
    // Admin Routes
    Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/warga', [AdminController::class, 'warga'])->name('warga');
        Route::delete('/warga/{id}', [AdminController::class, 'destroyWarga'])->name('warga.destroy');
        Route::get('/rumah', [AdminController::class, 'rumah'])->name('rumah');
        Route::delete('/rumah/{id}', [AdminController::class, 'destroyRumah'])->name('rumah.destroy');
        Route::get('/budidaya', [AdminController::class, 'budidaya'])->name('budidaya');
        Route::delete('/budidaya/{id}', [AdminController::class, 'destroyBudidaya'])->name('budidaya.destroy');
        Route::get('/statistik', [AdminController::class, 'statistik'])->name('statistik');
    });
});