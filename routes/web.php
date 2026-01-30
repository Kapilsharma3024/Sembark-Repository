<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\InviteController;
use App\Http\Controllers\ShortUrlController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', [AuthController::class, 'homepage']);


Route::get('/s/{short_code}',[ShortUrlController::class, 'redirect'])->name('short.redirect');
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login_page'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

    Route::get('/short-rul/create', [ShortUrlController::class, 'create'])->name('short-url.create');
    Route::post('/short-url', [ShortUrlController::class, 'store'])->name('short-url.store');
    Route::get('/invite', [InviteController::class, 'create'])->name('invite.create');
    Route::post('/invite', [InviteController::class, 'store'])->name('invite.store');
    Route::get('short-url', [ShortUrlController::class, 'index'])->name('short-url.index');
});
