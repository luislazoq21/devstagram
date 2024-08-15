<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class FollowerController extends Controller
{
    public function store(User $user)
    {
        $user->followers()->sync(auth()->user()->id);

        return back();
    }

    public function destroy(User $user)
    {
        $user->followers()->sync([]);
        return back();
    }
}
