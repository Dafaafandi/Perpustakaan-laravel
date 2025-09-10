<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MemberController;
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

        Route::prefix('books')->name('admin.books.')->group(function () {

            Route::get('/', [BookController::class, 'index'])->name('index');
            Route::get('create', [BookController::class, 'create'])->name('create');
            Route::post('/', [BookController::class, 'store'])->name('store');

            Route::get('{book}', [BookController::class, 'show'])->name('show');
            Route::get('{book}/edit', [BookController::class, 'edit'])->name('edit');
            Route::put('{book}', [BookController::class, 'update'])->name('update');
            Route::delete('{book}', [BookController::class, 'destroy'])->name('destroy');

            Route::get('export/excel', [BookController::class, 'exportExcel'])->name('export.excel');
            Route::get('export/pdf', [BookController::class, 'exportPdf'])->name('export.pdf');
            Route::get('template/download', [BookController::class, 'downloadTemplate'])->name('template.download');
            Route::post('import/excel', [BookController::class, 'importExcel'])->name('import.excel');
        });

        Route::get('/buku', [BookController::class, 'index'])->name('buku.index');

        Route::prefix('borrowing')->name('admin.borrowing.')->group(function () {
            Route::get('/', [BorrowingController::class, 'index'])->name('index');
            Route::get('search/members', [BorrowingController::class, 'searchMembers'])->name('search-members');
            Route::get('api/statistics', [BorrowingController::class, 'statistics'])->name('statistics');
            Route::get('{borrowing}', [BorrowingController::class, 'show'])->name('show');
            Route::post('{borrowing}/approve', [BorrowingController::class, 'approve'])->name('approve');
            Route::post('{borrowing}/reject', [BorrowingController::class, 'reject'])->name('reject');
            Route::post('{borrowing}/return', [BorrowingController::class, 'return'])->name('return');
        });

        // Route::get('/peminjaman', [BorrowingController::class, 'index'])->name('peminjaman');

        Route::prefix('members')->name('admin.members.')->group(function () {
            Route::get('/', [MemberController::class, 'index'])->name('index');
            Route::get('{id}', [MemberController::class, 'show'])->name('show');
            Route::delete('{id}', [MemberController::class, 'destroy'])->name('destroy');
        });
    });
});

require __DIR__ . '/auth.php';
