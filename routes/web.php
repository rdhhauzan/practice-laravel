<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\PDFController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::middleware('admin')->group(function () {
    Route::get(
        '/',
        function () {
            return view('dashboard');
        }
    )->name('dashboard');

    Route::get('/books', [BookController::class, 'index']);
    Route::post('/book', [BookController::class, 'store']);
    Route::get('/book', [BookController::class, 'storeView']);
    Route::get('/book/delete/{id}', [BookController::class, 'delete']);
    Route::post('/book/update', [BookController::class, 'update']);
    Route::get('/book/update/{id}', [BookController::class, 'edit']);
    Route::get('/books/generate-pdf', [BookController::class, 'generatePDF']);
    Route::get('/book/generate-pdf/{id}', [BookController::class, 'generateOneDataPDF']);
    Route::get('/books/generate-excel', [BookController::class, 'generateExcel']);
    Route::get('/genres', [GenreController::class, 'index']);
    Route::post('/genre', [GenreController::class, 'store']);
    Route::get(
        '/genre',
        function () {
            return view('addGenre');
        }
    );
    Route::get('/genre/update/{id}', [GenreController::class, 'edit']);
    Route::get('/genre/delete/{id}', [GenreController::class, 'delete']);
    Route::post('/genre/update', [GenreController::class, 'update']);
    Route::get('/users', [UserController::class, 'index']);
    Route::get(
        '/user',
        function () {
            return view('addUser');
        }
    );
    Route::post('/user', [UserController::class, 'store']);
});

Route::middleware('Guest')->group(function () {
    Route::get(
        '/guest',
        function () {
            return view('Guest\GuestDashboard');
        }
    );
    Route::get('/guest/books', [GuestController::class, 'index']);
    Route::get('/guest/userBooks', [GuestController::class, 'getUserBook']);
    Route::get('/guest/book/buy/{id}', [GuestController::class, 'buy']);
    Route::post('/guest/book/add', [GuestController::class, 'storeBook'])->name('storeBook');
    Route::post('/guest/wishlist/add/{id}', [GuestController::class, 'addWishlist']);
    Route::get('/guest/wishlist', [GuestController::class, 'getWishlist']);
    Route::get('/guest/wishlist/delete/{id}', [GuestController::class, 'deleteWishlist']);
});

// ! RegisterController Route
Route::get('/register', [RegisterController::class, 'index'])->name('register')->middleware('guest');
Route::post('/register', [RegisterController::class, 'store']);

// ! LoginController Route
Route::get('/login', function () {
    return view('login');
})->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);