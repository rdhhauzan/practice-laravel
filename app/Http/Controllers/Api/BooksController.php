<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BooksController extends Controller
{
    public function index()
    {
        $books = DB::table('books')->join('genre', 'books.genreId', '=', 'genre.id')->select('books.id AS bookId', 'books.name AS bookName', 'books.price', 'books.description', 'genre.*', 'books.image')->paginate(10);
        return response()->json(compact('books'));
    }

    public function search(Request $request)
    {
        $searchQuery = $request->query('name');
        $books = DB::table('books')->join('genre', 'books.genreId', '=', 'genre.id')->select('books.id AS bookId', 'books.name AS bookName', 'books.price', 'books.description', 'genre.*', 'books.image')->where('books.name', 'like', '%' . $searchQuery . '%')->paginate(10);

        return response()->json(compact('books'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'price' => 'required',
            'description' => 'required',
            'genreId' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:3072',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->first(), 400);
        }

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

        DB::table('books')->insert($data);

        return response()->json("Book Add Successfully", 200);
    }
}