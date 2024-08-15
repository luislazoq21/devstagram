@extends('layouts.app')

@section('titulo', 'Página principal')

@section('contenido')

    <x-listar-posts :posts="$posts" />

@endsection
