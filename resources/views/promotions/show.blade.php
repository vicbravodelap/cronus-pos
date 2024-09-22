@extends('adminlte::page')

@section('title', 'Detalles de la promoción')

@section('content_header')
    <h1>Detalles de la promoción</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Información de la promoción</h3>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="name">Nombre</label>
                    <p id="name">{{ $promotion->name }}</p>
                </div>

                <div class="form-group col-md-4">
                    <label for="description">Descripción</label>
                    <p id="description">{{ $promotion->description }}</p>
                </div>

                <div class="form-group col-md-4">
                    <label for="code">Código</label>
                    <p id="code">{{ $promotion->code }}</p>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-2">
                    <label for="type">Tipo de promoción</label>
                    <p id="type">{{ $promotion->type == 'percentage' ? 'Porcentaje' : 'Fijo' }}</p>
                </div>

                <div class="form-group col-md-2">
                    <label for="value">Valor</label>
                    <p id="value">{{ $promotion->value }}</p>
                </div>

                <div class="form-group col-md-2">
                    <label for="start_at">Fecha de inicio</label>
                    <p id="start_at">{{ $promotion->start_at->format('Y-m-d') }}</p>
                </div>

                <div class="form-group col-md-2">
                    <label for="end_at">Fecha de fin</label>
                    <p id="end_at">{{ $promotion->end_at->format('Y-m-d') }}</p>
                </div>

                <div class="form-group col-md-4">
                    <label for="applicable_models">Aplicable para:</label>
                    <ul id="applicable_models">
                        @foreach($promotion->applicable_models as $model)
                            <li>{{ \App\Models\Promotion::$availableModels[$model] }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <div class="card-footer">
            <a href="{{ route('promotions.index') }}" class="btn btn-secondary">Volver</a>
        </div>
    </div>
@stop
