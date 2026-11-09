<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
})->name('shop.index');

// Route Admin Dashboard (Menyelesaikan error route 'admin.dashboard' not found)
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard'); // atau sesuaikan dengan view admin Anda
})->middleware(['auth'])->name('admin.dashboard');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::prefix('admin')->name('admin.')->middleware(['auth','role:admin'])->group(function () { 
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index'); 
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store'); 
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update'); 
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy'); 
    Route::resource('products', AdminProductController::class)->except('show'); 
}); 

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');