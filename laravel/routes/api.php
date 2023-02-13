<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BooksController;
use App\Http\Controllers\Api\GenresController;
use App\Http\Controllers\Api\GuestController;
use App\Http\Controllers\Api\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware(['jwt.auth', 'admin'])->group(function () {
    Route::get('/books', [BooksController::class, 'index']);
    Route::get('/books/search', [BooksController::class, 'search']);
    Route::post('/book', [BooksController::class, 'store']);
    Route::get('/orders', [BooksController::class, 'showUserOrder']);
    Route::get('/order/edit/{userId}/{bookId}', [BooksController::class, 'editOrder']);
    Route::post('/order/update', [BooksController::class, 'orderUpdate']);
    Route::get('/book/delete/{id}', [BooksController::class, 'delete']);
    Route::get('/book/update/{id}', [BooksController::class, 'edit']);
    Route::post('/book/update/{id}', [BooksController::class, 'update']);
    Route::get('/books/generate-pdf', [BooksController::class, 'generatePDF']);
    Route::get('/book/generate-pdf/{id}', [BooksController::class, 'generateOneDataPDF']);
    Route::get('/books/generate-excel', [BooksController::class, 'generateExcel']);

    Route::get('/genres', [GenresController::class, 'index']);
    Route::post('/genre', [GenresController::class, 'store']);
    Route::get('/genre/update/{id}', [GenresController::class, 'edit']);
    Route::get('/genre/delete/{id}', [GenresController::class, 'delete']);
    Route::post('/genre/update/{id}', [GenresController::class, 'update']);

    Route::get('/users', [UsersController::class, 'index']);
    Route::post('/user', [UsersController::class, 'store']);
});

Route::middleware(['jwt.auth', 'Guest'])->group(function () {
    Route::get('/guest/books', [GuestController::class, 'index']);
    Route::get('/guest/books/search', [GuestController::class, 'search'])->name('search');
    Route::get('/guest/userBooks', [GuestController::class, 'getUserBook']);
    Route::get('/guest/book/buy/{id}', [GuestController::class, 'buy']);
    Route::post('/guest/book/add', [GuestController::class, 'storeBook'])->name('storeBook');
    Route::post('/guest/wishlist/add/{id}', [GuestController::class, 'addWishlist']);
    Route::get('/guest/wishlist', [GuestController::class, 'getWishlist']);
    Route::get('/guest/wishlist/delete/{id}', [GuestController::class, 'deleteWishlist']);
});