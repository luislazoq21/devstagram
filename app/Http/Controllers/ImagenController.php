<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Intervention\Image\Laravel\Facades\Image;

class ImagenController extends Controller
{
    public function store(Request $request)
    {
        $manager = new ImageManager(new Driver());

        $imagen = $request->file('file');

        //generar un id unico para las imagenes
        $nombre_imagen = Str::uuid() . "." . $imagen->extension();

        //guardar la imagen al servidor
        $imagen_servidor = $manager->read($imagen);
        //agregamos efecto a la imagen con intervention
        $imagen_servidor->cover(1000, 1000);
        // la unidad de mide en PX 1= 1pixiel

        //agregamos la imagen a la  carpeta en public donde se guardaran las imagenes
        $imagen_path = public_path('uploads') . '/' . $nombre_imagen;
        //Una vez procesada la imagen entonces guardamos la imagen en la carpeta que creamos
        $imagen_servidor->save($imagen_path);

        //retornamos el nombre de la imagen, que es el nombre que nos da el ID unico con uuid()
        return response()->json(['imagen' => $nombre_imagen]);
    }
}
