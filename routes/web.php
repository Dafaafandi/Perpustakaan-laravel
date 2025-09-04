<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');

Route::middleware('auth')->group(function () {

    Route::get('/', function () {
        if (auth()->user()->hasRole('admin')) {
            return view('admin.home', ['title' => 'Admin Dashboard']);
        } else {
            return view('member.home', ['title' => 'Member Dashboard']);
        }
    })->name('home');

    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });

    Route::middleware('role:admin')->group(function () {
        Route::resource('kategori', CategoryController::class);

        Route::prefix('books')->name('books.')->group(function () {
            Route::get('export/excel', [BookController::class, 'exportExcel'])->name('export.excel');
            Route::get('export/pdf', [BookController::class, 'exportPdf'])->name('export.pdf');
            Route::get('template/download', [BookController::class, 'downloadTemplate'])->name('template.download');
            Route::post('import/excel', [BookController::class, 'importExcel'])->name('import.excel');
        });

        Route::resource('books', BookController::class);
        Route::get('/buku', [BookController::class, 'index'])->name('buku.index');

        Route::get('/peminjaman', function () {
            return view('borrowing.peminjaman', ['title' => 'Borrowing Page']);
        })->name('peminjaman');

        Route::get('/daftar', function () {
            return view('admin.daftar', ['title' => 'Member List Page']);
        })->name('daftar');
    });
});

require __DIR__ . '/auth.php';
