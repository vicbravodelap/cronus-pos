@extends('adminlte::page')

@section('title', 'Categories')

@section('content_header')
    <h1>Categorías</h1>
@stop

@section('content')
    <div class="mb-3">
        <a href="{{ route('categories.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Crear categoría
        </a>
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Listado de categorías</h3>
            <div class="card-tools">
                <form action="{{ route('categories.index') }}" method="GET" class="form-inline">
                    <div class="input-group input-group-sm">
                        <input type="text" name="search" class="form-control" placeholder="Buscar categoría" value="{{ request('search') }}">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->description }}</td>
                            <td>
                                <a href="{{ route('categories.edit', $category) }}" class="btn btn-warning">Editar</a>
                                <a
                                    href="{{ route('categories.destroy', $category->id) }}"
                                    class="btn btn-danger"
                                    data-confirm-delete>Delete
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="card-footer">
            {{ $categories->links() }}
        </div>
    </div>
@stop
