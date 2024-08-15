<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('auth', except:['show', 'index', 'destroy']),
        ];
    }

    public function index(User $user)
    {
        // $posts = $user->posts;
        $posts = Post::where('user_id', $user->id)->latest()->paginate(20);
        return view('dashboard', compact('user', 'posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo'      => 'required|max:255',
            'descripcion' => 'required',
            'imagen'      => 'required',
        ]);

        $user = auth()->user();

        // Post::create([
        //     'titulo'        => $request->titulo,
        //     'descripcion'   => $request->descripcion,
        //     'imagen'        => $request->imagen,
        //     'user_id'       => $user->id,
        // ]);

        // Otra forma
        // $post = new Post;
        // $post->titulo       = $request->titulo;
        // $post->descripcion  = $request->descripcion;
        // $post->imagen       = $request->imagen;
        // $post->user_id      = $user->id;
        // $post->save();

        $request->user()->posts()->create([
            'titulo'        => $request->titulo,
            'descripcion'   => $request->descripcion,
            'imagen'        => $request->imagen,
            'user_id'       => $user->id,
        ]);

        return redirect()->route('posts.index', $user->username);
    }

    public function show(User $user, Post $post)
    {
        if( $user->id !== $post->user_id ) abort(404);
        return view('posts.show', compact('post', 'user'));
    }

    public function destroy(Post $post)
    {
        Gate::authorize('delete', $post);

        $post->delete();

        // eliminar la imagen
        $imagen_path = public_path('uploads/' . $post->imagen);

        if(File::exists($imagen_path)) {
            unlink($imagen_path);
        }

        return redirect()->route('posts.index', auth()->user());
    }
}
