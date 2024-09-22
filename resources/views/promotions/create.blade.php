@extends('adminlte::page')

@section('title', 'Crear promoción')

@section('content_header')
    <h1>Crear promoción</h1>
@stop

@section('content')
    <form action="{{ route('promotions.store') }}" method="POST" onsubmit="prepareForm()">
        @csrf
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Datos de la promoción</h3>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="name">Nombre</label>
                        <x-adminlte.form.input name="name" id="name" placeholder="Nombre de la promoción" value="{{ old('name') }}" />
                    </div>

                    <div class="form-group col-md-4">
                        <label for="description">Descripción</label>
                        <x-adminlte.form.textarea name="description" id="description" placeholder="Descripción de la promoción">{{ old('description') }}</x-adminlte.form.textarea>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="code">Código</label>
                        <x-adminlte.form.input name="code" id="code" placeholder="Código promocional" value="{{ old('code') }}" />
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-2">
                        <label for="type">Tipo de promoción</label>
                        <x-adminlte.form.select name="type" id="type" onchange="toggleValueInput()">
                            <option>Selecciona un tipo</option>
                            <option {{ old('type') == 'percentage' ? 'selected' : null }} value="percentage">Porcentaje</option>
                            <option {{ old('type') == 'fixed' ? 'selected' : null }} value="fixed">Fijo</option>
                        </x-adminlte.form.select>
                    </div>

                    <div class="form-group col-md-2">
                        <label for="value">Valor</label>
                        <x-adminlte.form.input
                            name="value"
                            type="number"
                            id="value"
                            placeholder="Valor de la promoción"
                            value="{{ old('value') }}"
                        />
                    </div>

                    <div class="form-group col-md-2">
                        <label for="start_at">Fecha de inicio</label>
                        <input type="date" name="start_at" class="form-control" value="{{ old('start_at') }}" />
                        @error('start_at')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group col-md-2">
                        <label for="end_at">Fecha de fin</label>
                        <input type="date" name="end_at" class="form-control" value="{{ old('end_at') }}" />
                        @error('end_at')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group col-md-4">
                        <label for="applicable_models">Aplicable para:</label>
                        @foreach($availableModels as $model => $label)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="applicable_models[]" value="{{ $model }}" id="model_{{ $model }}" {{ in_array($model, old('applicable_models', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="model_{{ $model }}">
                                    {{ $label }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </form>
@stop
