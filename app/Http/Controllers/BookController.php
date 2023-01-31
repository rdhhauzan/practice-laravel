<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BooksExport;
use Illuminate\Support\Facades\Redis;

class BookController extends Controller
{
    public function index()
    {
        $cached = Redis::get('books');

        if (isset($cached)) {
            $books = json_decode($cached, null);
            return view('books', compact('books'));
        } else {
            $books = DB::table('books')->join('genre', 'books.genreId', '=', 'genre.id')->select('books.id AS bookId', 'books.name AS bookName', 'books.price', 'books.description', 'genre.*')->get();
            Redis::set('books', $books);
            return view('books', compact('books'));
        }
    }

    public function search(Request $request)
    {
        $books = DB::table('books')->join('genre', 'books.genreId', '=', 'genre.id')->select('books.id AS bookId', 'books.name AS bookName', 'books.price', 'books.description', 'genre.*')->where('books.name', 'like', '%' . $request->input('name') . '%')->get();

        return view('books', compact('books'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'price' => 'required|max:255',
            'description' => 'required',
            'genreId' => 'required',
        ]);

        Redis::del('books');
        // Book::create($data);
        DB::table('books')->insert($data);
        return redirect('/books')->with('success', 'Book Add Successfully');
    }

    public function storeView()
    {
        $genres = DB::table('genre')->orderBy('id', 'desc')->get();
        return view('addBook', compact('genres'));
    }

    public function delete($id)
    {
        DB::table('books')->where('id', $id)->delete();
        Redis::del('books');
        return redirect('/books')->with('success', 'Book Delete Successfully');
    }

    public function edit($id)
    {
        $book = DB::table('books')->where('id', $id)->get();
        $genres = DB::table('genre')->orderBy('id', 'desc')->get();
        return view('editBook', compact('book', 'genres'));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'price' => 'required|max:255',
            'description' => 'required',
            'genreId' => 'required',
        ]);

        DB::table('books')->where('id', $request->id)->update([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'genreId' => $request->genreId,
        ]);

        Redis::del('books');
        return redirect('/books')->with('success', 'Book Update Successfully');
    }

    public function generatePDF()
    {
        $books = DB::table('books')->join('genre', 'books.genreId', '=', 'genre.id')->select('books.id AS bookId', 'books.name AS bookName', 'books.price', 'books.description', 'genre.name AS genreName')->get();

        $pdf = PDF::loadView('pdf', compact('books'));
        return $pdf->download('test.pdf');
    }

    public function generateOneDataPDF($id)
    {
        $books = DB::table('books')->join('genre', 'books.genreId', '=', 'genre.id')->select('books.id AS bookId', 'books.name AS bookName', 'books.price', 'books.description', 'genre.name AS genreName')->where('books.id', $id)->get();

        $pdf = PDF::loadView('pdf', compact('books'));
        return $pdf->download('test.pdf');
    }

    public function generateExcel()
    {
        return Excel::download(new BooksExport, 'book.xlsx');
    }
}