<?php

namespace App\Http\Controllers;

use App\Http\Requests\PerfilRequest;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class PerfilController extends Controller
{
    public function __construct()
    {
        // validar que el usuario autenticado solo acceda a su perfil
    }

    public function index()
    {
        return view('perfil.index');
    }

    public function store(PerfilRequest $request)
    {
        if($request->imagen) {
            $manager = new ImageManager(new Driver());

            $imagen = $request->file('imagen');

            //generar un id unico para las imagenes
            $nombre_imagen = Str::uuid() . "." . $imagen->extension();

            //guardar la imagen al servidor
            $imagen_servidor = $manager->read($imagen);
            //agregamos efecto a la imagen con intervention
            $imagen_servidor->cover(1000, 1000);
            // la unidad de mide en PX 1= 1pixiel

            //agregamos la imagen a la  carpeta en public donde se guardaran las imagenes
            $imagen_path = public_path('perfiles') . '/' . $nombre_imagen;
            //Una vez procesada la imagen entonces guardamos la imagen en la carpeta que creamos
            $imagen_servidor->save($imagen_path);
        }

        // guardar cambios
        $usuario = User::find(auth()->user()->id);
        $usuario->username  = $request->username;
        $usuario->email     = $request->email;

        // imagen
        $usuario->imagen = $nombre_imagen ?? auth()->user()->imagen ?? null;

        $usuario->save();

        return redirect()->route('posts.index', $usuario);
    }
}
