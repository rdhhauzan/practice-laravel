<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\SendEmailJob;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class GuestController extends Controller
{
    public function index(Request $request)
    {
        $books = DB::table('books')->join('genre', 'books.genreId', '=', 'genre.id')->select('books.id AS bookId', 'books.name AS bookName', 'books.price', 'books.description', 'genre.*', 'books.image')->get();
        return response()->json(compact('books'));
    }

    public function search(Request $request)
    {
        $books = DB::table('books')->join('genre', 'books.genreId', '=', 'genre.id')->select('books.id AS bookId', 'books.name AS bookName', 'books.price', 'books.description', 'genre.*', 'books.image')->where('books.name', 'like', '%' . $request->input('name') . '%')->get();

        return response()->json(compact('books'));

    }

    public function buy($id)
    {
        $book = DB::table('books')->join('genre', 'books.genreId', '=', 'genre.id')->select('books.id AS bookId', 'books.name AS bookName', 'books.price', 'books.description', 'genre.*')->where('books.id', $id)->get();
        $bookId = $id;

        Config::$serverKey = 'SB-Mid-server-nU1WKAwolq2Zzv-eKVov7L65';
        Config::$isProduction = false;

        $snapToken = Snap::getSnapToken(
            array(
                'transaction_details' => array(
                    'order_id' => uniqid(),
                    'gross_amount' => $book[0]->price,
                ),
                'customer_details' => array(
                    'first_name' => Auth::user()->name,
                    'email' => Auth::user()->email,
                ),
            )
        );

        return response()->json(compact('snapToken', 'bookId', 'book'));
    }

    public function storeBook(Request $request)
    {
        $bookId = $request->input('bookId');
        $userId = Auth::user()->id;

        DB::table('userbook')->insert([
            'bookId' => $bookId,
            'userId' => $userId
        ]);

        SendEmailJob::dispatch(Auth::user()->email, $bookId);
        return response()->json('Success Buy Book!');
    }

    public function getUserBook()
    {
        $books = DB::table('userbook')->join('books', 'userbook.bookId', '=', 'books.id')->join('genre', 'books.genreId', '=', 'genre.id')->select('books.name AS bookName', 'books.price AS bookPrice', 'genre.name AS genreName', 'books.description AS bookDescription', 'books.image', 'userbook.status AS Status')->where('userId', Auth::user()->id)->get();

        $countBooks = DB::table('userbook')->join('books', 'userbook.bookId', '=', 'books.id')->join('genre', 'books.genreId', '=', 'genre.id')->select('books.name AS bookName', 'books.price AS bookPrice', 'genre.name AS genreName', 'books.description AS bookDescription')->where('userId', Auth::user()->id)->get();

        $countPrices = 0;

        foreach ($countBooks as $count) {
            $countPrices += $count->bookPrice;
        }
        $countPrices = "Rp " . number_format($countPrices, 2, ',', '.');

        return response()->json(compact('books', 'countBooks', 'countPrices'));
    }

    public function addWishlist($id)
    {
        DB::table('wishlist')->insert([
            'bookId' => $id,
            'userId' => Auth::user()->id
        ]);

        return response()->json('Book Add to wishlist Successfully!');
    }

    public function getWishlist()
    {
        $books = DB::table('wishlist')->join('books', 'wishlist.bookId', '=', 'books.id')->join('genre', 'books.genreId', '=', 'genre.id')->select('books.name AS bookName', 'books.price AS bookPrice', 'genre.name AS genreName', 'books.description AS bookDescription', 'books.id AS bookId')->where('userId', Auth::user()->id)->get();

        return response()->json(compact('books'));
    }

    public function deleteWishlist($id)
    {
        DB::table('wishlist')->where('bookId', $id)->where('userId', Auth::user()->id)->delete();

        return response()->json('Wishlist Delete Successfully!');
    }
}