<?php

use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImagenController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home')->middleware('auth');

Route::get('/register', [RegisterController::class, 'index'])->name('register.index');
Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store'])->name('login.store');
Route::post('/logout', LogoutController::class)->name('logout');

// Perfil
Route::middleware('auth')->controller(PerfilController::class)->group( function() {
    Route::get('/editar-perfil',        'index')->name('perfil.index');
    Route::post('/editar-perfil',       'store')->name('perfil.store');
});

// posts
Route::controller(PostController::class)->group( function() {
    Route::get('/{user:username}',                  'index')->name('posts.index');
    Route::get('/posts/create',                     'create')->name('posts.create');
    Route::post('/posts',                           'store')->name('posts.store');
    Route::get('/{user:username}/posts/{post}',     'show')->name('posts.show');
    Route::delete('/posts/{post}',                  'destroy')->name('posts.destroy');
});

// comentarios
Route::post('/{user:username}/posts/{post}', [ComentarioController::class, 'store'])->name('comentarios.store');

// imagen
Route::post('/imagenes', [ImagenController::class, 'store'])->name('imagenes.store');


// Like a las fotos
Route::post('/posts/{post}/likes', [LikeController::class, 'store'])->name('posts.likes.store');
Route::delete('/posts/{post}/likes', [LikeController::class, 'destroy'])->name('posts.likes.destroy');

// Siguiendo usuarios
Route::middleware('auth')->controller(FollowerController::class)->group(function() {
    Route::post('/{user:username}/follow',      'store')->name('users.follow');
    Route::delete('/{user:username}/unfollow',  'destroy')->name('users.unfollow');
});
