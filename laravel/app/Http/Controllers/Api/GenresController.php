<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class GenresController extends Controller
{
    public function index()
    {
        $genres = DB::table('genre')->orderBy('id', 'desc')->get();
        return response()->json($genres);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->first(), 400);
        }

        $data = [
            'name' => $request->name
        ];

        DB::table('genre')->insert($data);
        return response()->json("Genre Add Successfully");
    }

    public function edit($id)
    {
        $genre = DB::table('genre')->where('id', $id)->get();
        return response()->json($genre);

    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->first(), 400);
        }

        DB::table('genre')->where('id', $id)->update([
            'name' => $request->name
        ]);

        return response()->json("Genre Update Successfully!");
    }

    public function delete($id)
    {
        $data = DB::table('genre')->where('id', $id)->get();

        if ($data->isEmpty()) {
            return response()->json("Genre Not Found", 401);
        } else {
            DB::table('genre')->where('id', $id)->delete();
            return response()->json("Genre Delete Successfully!");
        }
    }
}