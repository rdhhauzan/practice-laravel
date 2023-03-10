<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BooksExport;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\File;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $column = $request->column ? $request->column : 'id';
        $direction = $request->direction ? $request->direction : 'desc';
        if ($direction != 'asc' && $direction != 'desc') {
            $direction = 'desc';
        }

        $books = DB::table('books')->join('genre', 'books.genreId', '=', 'genre.id')->select('books.id AS bookId', 'books.name AS bookName', 'books.price', 'books.description', 'genre.*', 'books.image')->orderBy($column, $direction)->paginate(10);
        $genres = DB::table('genre')->orderBy('id', 'desc')->get();

        return view('books', compact('books', 'genres'));
    }

    public function search(Request $request)
    {
        $books = DB::table('books')->join('genre', 'books.genreId', '=', 'genre.id')->select('books.id AS bookId', 'books.name AS bookName', 'books.price', 'books.description', 'genre.*', 'books.image')->where('books.name', 'like', '%' . $request->input('name') . '%')->paginate(10);
        $genres = DB::table('genre')->orderBy('id', 'desc')->get();
        return view('books', compact('books', 'genres'));
    }

    public function showUserOrder()
    {
        $orders = DB::table('userbook')->join('books', 'userbook.bookId', '=', 'books.id')->join('users', 'userbook.userId', '=', 'users.id')->select('books.name AS bookName', 'books.price AS bookPrice', 'books.description AS bookDescription', 'books.image', 'userbook.status AS Status', 'users.email', 'userbook.bookId', 'userbook.userId')->paginate(10);

        // dd($orders);
        return view('orders', compact('orders'));
    }

    public function editOrder($userId, $bookId)
    {
        $userbook = DB::table('userbook')->where('userId', $userId)->where('bookId', $bookId)->get();

        // dd($userbook);
        return view('editOrder', compact('userbook'));
    }

    public function orderUpdate(Request $request)
    {
        $this->validate($request, [
            'bookId' => 'required',
            'userId' => 'required',
            'status' => 'required',
        ]);

        DB::table('userbook')->where('userId', $request->userId)->where('bookId', $request->bookId)->update([
            'bookId' => $request->bookId,
            'userId' => $request->userId,
            'status' => $request->status,
        ]);

        return redirect('/orders')->with('success', 'Order Update Successfully');
    }

    public function store(Request $request)
    {
        $validator = $request->validate(
            [
                'name' => 'required|max:255',
                'price' => 'required|max:255',
                'description' => 'required',
                'genreId' => 'required',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:3072',
            ],
            [
                'genreId.required' => 'The genre field is required.'
            ]
        );
        $image = $request->file('image');
        $input['imageName'] = time() . '.' . $image->getClientOriginalExtension();
        $destinationPath = public_path('/images');
        $image->move($destinationPath, $input['imageName']);

        $data = [
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'genreId' => $request->genreId,
            'image' => $input['imageName']
        ];

        // Redis::del('books');
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
        $getBook = DB::table('books')->where('id', $id)->get();
        $image_path = public_path() . '/images/' . $getBook[0]->image;
        File::delete($image_path);
        DB::table('books')->where('id', $id)->delete();
        // Redis::del('books');
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
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:3072',
        ]);
        if ($request->hasFile('image')) {
            $getBook = DB::table('books')->where('id', $request->id)->get();
            $image_path = public_path() . '/images/' . $getBook[0]->image;
            File::delete($image_path);

            $image = $request->file('image');
            $input['imageName'] = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images');
            $image->move($destinationPath, $input['imageName']);

            DB::table('books')->where('id', $request->id)->update([
                'name' => $request->name,
                'price' => $request->price,
                'description' => $request->description,
                'genreId' => $request->genreId,
                'image' => $input['imageName'],
            ]);

        } else {
            DB::table('books')->where('id', $request->id)->update([
                'name' => $request->name,
                'price' => $request->price,
                'description' => $request->description,
                'genreId' => $request->genreId,
            ]);
        }

        // Redis::del('books');
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
        $books = DB::table('books')->join('genre', 'books.genreId', '=', 'genre.id')->select('books.id AS bookId', 'books.name AS bookName', 'books.price', 'books.description', 'genre.name AS genreName', 'books.image')->where('books.id', $id)->get();

        $pdf = PDF::loadView('onePdf', compact('books'));
        return $pdf->download('test.pdf');
        // dd($books[0]->image);
    }

    public function generateExcel()
    {
        return Excel::download(new BooksExport, 'book.xlsx');
    }
}