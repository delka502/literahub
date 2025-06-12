<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PeminjamanController;


// Rute untuk beranda (home)
Route::get('/', function () {
    return view('layouts.dashboard_user'); // Pastikan nama file sesuai dengan nama view
});

// Rute untuk halaman admin (harus login terlebih dahulu)
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

Route::get('/admin/returns', [AdminController::class, 'returns'])->name('admin.returns');


// Rute untuk halaman peminjaman admin
Route::get('/peminjaman', function () {
    return view('layouts.pemninjaman'); // Pastikan nama view sesuai
})->name('admin.peminjaman')->middleware('auth');

//registrasi user 
Route::get('/register', [UserController::class, 'showregisterUser'])->name('register');
Route::post('/register', [UserController::class, 'register'])->name('register.post');
 //login user 
Route::get('/login', [UserController::class, 'showloginUser'])->name('login');
Route::post('/login', [UserController::class, 'login'])->name('login.post');
Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard_user')->middleware('auth');


Route::get('/profile', [UserController::class, 'Profile'])->name('profile')->middleware('auth');
Route::get('/bookmarks', [UserController::class, 'bookmarksUser'])->name('bookmarks');
// Route::get('/history', [UserController::class, 'historyUser'])->name('history');
// Add this new logout route
Route::post('/logout', [UserController::class, 'logout'])->name('logout');
// login admin
Route::get('/login_admin', [AdminController::class, 'showLoginForm'])->name('login_admin');
Route::post('/login_admin', [AdminController::class, 'login'])->name('login_admin.post');
// Route dashboard admin (ini yang dipanggil setelah login)
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('dashboard_admin');

// Route untuk menyimpan peminjaman buku
Route::post('/peminjaman/store', [App\Http\Controllers\PeminjamanController::class, 'store'])->name('peminjaman.store');

// Route untuk melihat peminjaman pengguna
Route::get('/peminjaman/my-loans/{student_id}', [App\Http\Controllers\PeminjamanController::class, 'userLoans'])->name('peminjaman.user');



// routes/web.php

Route::middleware(['auth'])->group(function () {
    Route::get('/history', [PeminjamanController::class, 'history'])->name('history');
    Route::get('/api/peminjaman/{id}', [PeminjamanController::class, 'show']);
    Route::post('/api/peminjaman/{id}/extend', [PeminjamanController::class, 'extend']);
});




// Route untuk admin melihat semua peminjaman
Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/admin/peminjaman', [App\Http\Controllers\PeminjamanController::class, 'index'])->name('admin.peminjaman.index');
});


Route::delete('/peminjaman/{id}/kembalikan', [PeminjamanController::class, 'kembalikan'])->name('peminjaman.kembalikan');


// Book Return Management Routes
Route::prefix('admin/pengembalian')->name('admin.pengembalian.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', 'PengembalianController@index')->name('index');
    Route::get('/pending', 'PengembalianController@pending')->name('pending');
    Route::get('/returned', 'PengembalianController@returned')->name('returned');
    Route::get('/overdue', 'PengembalianController@overdue')->name('overdue');
    Route::get('/damaged', 'PengembalianController@damaged')->name('damaged');
    Route::post('/', 'PengembalianController@store')->name('store');
    Route::post('/send-reminder', 'PengembalianController@sendReminder')->name('send-reminder');
    Route::post('/mass-reminder', 'PengembalianController@massReminder')->name('mass-reminder');
    Route::post('/pay-fine', 'PengembalianController@payFine')->name('pay-fine');
    Route::get('/export', 'PengembalianController@export')->name('export');
});

// Search route for borrowings
Route::get('admin/peminjaman/search', 'PeminjamanController@search')->name('admin.peminjaman.search');

Route::get('/dashboard-user', function () {
    return view('layouts.dashboard_user');
})->name('dashboard.user');
