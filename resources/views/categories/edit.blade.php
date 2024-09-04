@extends('adminlte::page')

@section('title', 'Categories')

@section('content_header')
    <h1>Editar categoría</h1>
@stop

@section('content')
    <form action="{{ route('categories.update', ['category' => $category]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card col-md-6">
            <div class="card-header">
                <h3 class="card-title">Datos de la categoría</h3>
            </div>
            <div class="card-body">
                <x-adminlte-input
                    name="name"
                    type="text"
                    value="{{ $category->name }}"
                    fgroup-class="col-md-12"
                    required
                    placeholder="Nombre de la categoría"
                />

                <x-adminlte-textarea
                    name="description"
                    fgroup-class="col-md-12"
                    placeholder="Inserta una descripción..."
                >{{ $category->description }}</x-adminlte-textarea>
            </div>

            <div class="card-footer d-flex justify-content-center">
                <x-adminlte-button type="submit" label="Actualizar" theme="primary" icon="fas fa-lg fa-save"/>
            </div>
        </div>
    </form>
@stop
