<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\DB;
use Midtrans\Config;
use Midtrans\Snap;

class GuestController extends Controller
{
    public function index()
    {
        $cached = Redis::get('books');

        if (isset($cached)) {
            $books = json_decode($cached, null);
            return view('Guest\GuestBooks', compact('books'));
        } else {
            $books = DB::table('books')->join('genre', 'books.genreId', '=', 'genre.id')->select('books.id AS bookId', 'books.name AS bookName', 'books.price', 'books.description', 'genre.*')->get();
            Redis::set('books', $books);
            return view('Guest\GuestBooks', compact('books'));
        }
    }

    public function search(Request $request)
    {
        $books = DB::table('books')->join('genre', 'books.genreId', '=', 'genre.id')->select('books.id AS bookId', 'books.name AS bookName', 'books.price', 'books.description', 'genre.*')->where('books.name', 'like', '%' . $request->input('name') . '%')->get();

        return view('Guest\GuestBooks', compact('books'));
    }

    public function buy($id)
    {
        $book = DB::table('books')->where('id', $id)->get();
        $bookId = $id;
        // dd($book[0]->price);
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

        // dd($snapToken);

        return view('Guest\payment', compact('snapToken', 'bookId'));
    }

    public function storeBook(Request $request)
    {
        $bookId = $request->input('bookId');
        $userId = Auth::user()->id;

        DB::table('userbook')->insert([
            'bookId' => $bookId,
            'userId' => $userId,
        ]);

        return redirect('/')->with('success', 'Book success to buy');
    }

    public function getUserBook()
    {
        $books = DB::table('userbook')->join('books', 'userbook.bookId', '=', 'books.id')->join('genre', 'books.genreId', '=', 'genre.id')->select('books.name AS bookName', 'books.price AS bookPrice', 'genre.name AS genreName', 'books.description AS bookDescription')->where('userId', Auth::user()->id)->get();

        return view('Guest\userBooks', compact('books'));
    }

    public function addWishlist($id)
    {
        DB::table('wishlist')->insert([
            'bookId' => $id,
            'userId' => Auth::user()->id
        ]);

        return redirect('/guest/wishlist')->with('success', 'Book Add to wishlist Successfully');
    }

    public function getWishlist()
    {
        $books = DB::table('wishlist')->join('books', 'wishlist.bookId', '=', 'books.id')->join('genre', 'books.genreId', '=', 'genre.id')->select('books.name AS bookName', 'books.price AS bookPrice', 'genre.name AS genreName', 'books.description AS bookDescription', 'books.id AS bookId')->where('userId', Auth::user()->id)->get();

        return view('Guest\Wishlist', compact('books'));
    }

    public function deleteWishlist($id)
    {
        DB::table('wishlist')->where('bookId', $id)->where('userId', Auth::user()->id)->delete();

        return redirect('/guest/wishlist')->with('success', 'Wishlist Delete Successfully!');
    }
}