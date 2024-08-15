@extends('layouts.app')

@section('titulo', 'Crea una nueva publicación')

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
@endpush

@push('scripts')
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
    @vite('resources/js/dropzone.js')
@endpush

@section('contenido')
    <div class="md:flex md:justify-center md:gap-10 md:items-center">
        <div class="md:w-6/12">
            <form action="{{ route('imagenes.store') }}" method="POST" enctype="multipart/form-data" id="dropzone" class="dropzone border-dashed border-2 w-full h-96 rounded flex flex-col justify-center items-center">
                @csrf
            </form>
        </div>
        <div class="md:w-6/12 p-6 rounded-lg shadow-xl">
            <form action="{{ route('posts.store') }}" method="POST" novalidate>
                @csrf

                <div class="mb-5">
                    <label for="titulo" class="mb-2 block uppercase text-gray-500 font-bold">Título</label>
                    <input
                        type="text"
                        name="titulo"
                        id="titulo"
                        value="{{ old('titulo') }}"
                        placeholder="Título de la publicación"
                        class="border p-3 w-full rounded-lg @error('titulo') border-red-500 @enderror"
                    />
                    @error('titulo')
                        <p class="text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="descripcion" class="mb-2 block uppercase text-gray-500 font-bold">Descripción</label>
                    <textarea
                        name="descripcion"
                        id="descripcion"
                        placeholder="Descripción de la publicación"
                        class="border p-3 w-full rounded-lg resize-none @error('descripcion') border-red-500 @enderror"
                        >{{ old('descripcion') }}</textarea>
                    @error('descripcion')
                        <p class="text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <input
                        type="hidden"
                        name="imagen"
                        value="{{ old('imagen') }}"
                    />

                    @error('imagen')
                        <p class="text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <input
                    type="submit"
                    value="Crear publicación"
                    class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer uppercase font-bold text-white w-full p-3 rounded-lg"
                />
            </form>
        </div>
    </div>
@endsection
