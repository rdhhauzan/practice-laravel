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

    
}