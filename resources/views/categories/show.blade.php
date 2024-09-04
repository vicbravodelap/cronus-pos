@extends('adminlte::page')

@section('title', 'Categories')

@section('content_header')
    <h1>Ver categoría</h1>
@stop

@section('content')
    <div class="card col-md-6">
        <div class="card-header">
            <h3 class="card-title">Datos de la categoría</h3>
        </div>
        <div class="card-body">
            <x-adminlte-input
                name="name"
                type="text"
                disabled
                value="{{ $category->name }}"
                fgroup-class="col-md-12"
                required
                placeholder="Nombre de la categoría"
            />

            <x-adminlte-textarea
                name="description"
                disabled
                fgroup-class="col-md-12"
                placeholder="Inserta una descripción..."
            >{{ $category->description }}</x-adminlte-textarea>
        </div>
    </div>
@stop
