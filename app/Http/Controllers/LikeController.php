<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class LikeController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('auth')
        ];
    }


    public function store(Request $request, Post $post)
    {
        $post->likes()->create([
            'user_id' => $request->user()->id
        ]);
        return back();
    }

    public function destroy(Request $request, Post $post)
    {
        // $like = Like::where('post_id', $post->id)
        //             ->where('user_id', auth()->user()->id)
        //             ->first();
        // $like->delete();

        $request->user()->likes()->where('post_id', $post->id)->delete();
        return back();
    }
}
