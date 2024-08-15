<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }

    public function store(RegisterRequest $request)
    {
        User::create([
            'name'      => $request->name,
            'username'  => Str::slug($request->username),
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
        ]);

        // Autenticar un usuario
        // auth()->attempt([
        //     'email'     => $request->email,
        //     'password'  => $request->password,
        // ]);
        auth()->attempt($request->only('email', 'password'));

        return redirect()->route('posts.index', auth()->user());
    }
}
