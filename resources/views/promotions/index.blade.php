@extends('adminlte::page')

@section('title', 'Promociones')

@section('content_header')
    <h1>Promociones</h1>
@stop

@section('content')
    <div class="mb-3">
        <a href="{{ route('promotions.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Crear promoción
        </a>
    </div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Listado de promociónes</h3>
            <div class="card-tools">
                <form action="{{ route('promotions.index') }}" method="GET" class="form-inline">
                    <div class="input-group input-group-sm">
                        <input type="text" name="search" class="form-control" placeholder="Buscar promoción" value="{{ request('search') }}">
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
            <table class="table table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Código</th>
                        <th>Descripción</th>
                        <th>Fecha de Inicio</th>
                        <th>Fecha de Fin</th>
                        <th>Valor</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($promotions as $promotion)
                        <tr>
                            <td>{{ $promotion->name }}</td>
                            <td>{{ $promotion->code }}</td>
                            <td>{{ $promotion->description }}</td>
                            <td>{{ $promotion->start_at }}</td>
                            <td>{{ $promotion->end_at }}</td>
                            <td>
                                @if($promotion->type == 'percentage')
                                    {{ $promotion->value }}%
                                @else
                                    ${{ number_format($promotion->value, 2) }}
                                @endif
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Acciones
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="{{ route('promotions.show', $promotion) }}">Ver</a>
                                        <a class="dropdown-item" href="{{ route('promotions.edit', $promotion) }}">Editar</a>
                                        <a class="dropdown-item" href="{{ route('promotions.assignments.create', $promotion) }}">Aplicar</a>
                                        <a class="dropdown-item" href="{{ route('promotions.destroy', $promotion->id) }}" data-confirm-delete>
                                            <i class="fas fa-trash-alt"></i> Eliminar
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="card-footer">
            {{ $promotions->links() }}
        </div>
    </div>
@stop
