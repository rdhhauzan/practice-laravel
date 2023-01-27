<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GenreController extends Controller
{

    public function index()
    {
        $genres = DB::table('genre')->orderBy('id', 'desc')->get();
        return view('genres', compact('genres'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
        ]);

        DB::table('genre')->insert($data);
        return redirect('genres')->with('success', 'Genre Add Successfully');
    }

    public function edit($id)
    {
        $genre = DB::table('genre')->where('id', $id)->get();
        return view('editGenre', compact('genre'));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
        ]);

        DB::table('genre')->where('id', $request->id)->update([
            'name' => $request->name,
        ]);

        return redirect('/genres')->with('success', 'Genre Update Successfully');
    }

    public function delete($id)
    {
        DB::table('genre')->where('id', $id)->delete();
        return redirect('/genres')->with('success', 'Genre Delete Successfully');
    }
}