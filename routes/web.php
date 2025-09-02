<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;

Route::middleware('auth')->group(function () {

    Route::get('/', function () {
        return view('home', ['title' => 'Home Page']);
    })->name('home');

    Route::resource('kategori', CategoryController::class)->middleware('role:admin');

    Route::get('/buku', function () {
        return view('buku', ['title' => 'Buku Page']);
    });

    Route::get('/peminjaman', function () {
        return view('peminjaman', ['title' => 'Peminjaman Page']);
    });

    Route::get('/daftar', function () {
        return view('daftar', ['title' => 'Daftar Member Page']);
    });

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware('verified')->name('dashboard');

    Route::get('/admin-panel', function () {
        return 'Ini adalah halaman khusus Admin!';
    })->middleware('role:admin');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
