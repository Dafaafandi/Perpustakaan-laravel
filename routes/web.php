<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BookController;

Route::middleware('auth')->group(function () {

    Route::get('/', function () {
        return view('home', ['title' => 'Home Page']);
    })->name('home');

    Route::resource('kategori', CategoryController::class)->middleware('role:admin');

    Route::get('/buku', [BookController::class, 'index'])->name('buku.index');

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

    Route::get('books/export/excel', [BookController::class, 'exportExcel'])->name('books.export.excel');
    Route::get('books/export/pdf', [BookController::class, 'exportPdf'])->name('books.export.pdf');
    Route::post('books/import/excel', [BookController::class, 'importExcel'])->name('books.import.excel');

    Route::resource('books', BookController::class);
});

require __DIR__ . '/auth.php';
