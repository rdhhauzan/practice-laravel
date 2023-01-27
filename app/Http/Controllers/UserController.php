<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function index()
    {
        $users = DB::table('users')->select('users.id', 'users.email', 'users.name', 'users.role')->get();
        return view('users', compact('users'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|unique:users',
            'password' => 'required',
            'role' => 'required',
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']);

        DB::table('users')->insert($validatedData);
        return redirect('users')->with('success', 'User Add Successfully');
    }
}