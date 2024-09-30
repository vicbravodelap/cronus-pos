@extends('adminlte::page')

@section('title', 'Membresías')

@section('content_header')
    <h1>Membresías</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('memberships.create') }}" class="btn btn-primary">Nueva membresía</a>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Inicio</th>
                        <th>Fin</th>
                        <th>Dias restantes</th>
                        <th>Estado</th>
                        <th>Promoción</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($memberships as $membership)
                        <tr>
                            <td>{{ $membership->user->name }}</td>
                            <td>{{ $membership->start_at }}</td>
                            <td>{{ $membership->end_at }}</td>
                            <td>
                                @if ($membership->status === 'active')
                                    {{ $membership->days_left }} {{ $membership->days_left === 1 ? 'día' : 'días' }}
                                @else
                                    <span class="badge badge-secondary">N/A</span>
                            @endif
                            <td>
                                @if ($membership->status === 'active')
                                    <span class="badge badge-success">ACTIVO</span>
                                @elseif ($membership->status === 'inactive')
                                    <span class="badge badge-danger">INACTIVO</span>
                                @else
                                    <span class="badge badge-secondary">{{ strtoupper($membership->status) }}</span>
                                @endif
                            </td>
                            <td>
                                @if ($membership->promotions->isNotEmpty())
                                    @foreach ($membership->promotions as $promotion)
                                        <span class="badge badge-primary">{{ $promotion->code }}</span>
                                        <span class="badge badge-info">
                                            {{ $promotion->type === 'fixed' ? 'Fijo' : 'Porcentaje' }}: {{ $promotion->value }}
                                        </span>
                                    @endforeach
                                @else
                                    <span class="badge badge-secondary">N/A</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Acciones
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('memberships.edit', $membership) }}">Editar</a>
                                        <a class="dropdown-item" href="{{ route('memberships.destroy', $membership) }}" data-confirm-delete>
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
            {{ $memberships->links() }}
        </div>
    </div>
@stop
