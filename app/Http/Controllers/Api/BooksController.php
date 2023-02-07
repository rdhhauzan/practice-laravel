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

    public function showUserOrder()
    {
        $orders = DB::table('userbook')->join('books', 'userbook.bookId', '=', 'books.id')->join('users', 'userbook.userId', '=', 'users.id')->select('books.name AS bookName', 'books.price AS bookPrice', 'books.description AS bookDescription', 'books.image', 'userbook.status AS Status', 'users.email', 'userbook.bookId', 'userbook.userId')->paginate(10);

        return response()->json($orders);
    }

    public function editOrder($userId, $bookId)
    {
        $userbook = DB::table('userbook')->where('userId', $userId)->where('bookId', $bookId)->get();

        if ($userbook->isEmpty()) {
            return response()->json('Order Not Found!');
        }
        return response()->json($userbook);
    }

    public function orderUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bookId' => 'required',
            'userId' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->first(), 400);
        }

        DB::table('userbook')->where('userId', $request->userId)->where('bookId', $request->bookId)->update([
            'bookId' => $request->bookId,
            'userId' => $request->userId,
            'status' => $request->status,
        ]);

        return response()->json('Order Update Successfully');
    }
}