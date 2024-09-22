@extends('adminlte::page')

@section('title', 'Asignar promoción')

@section('content_header')
    <h1>Asignar promoción</h1>
@stop

@section('plugins.Select2', true)

@section('content')
    <form action="{{ route('promotions.assignments.store') }}" method="POST">
        @csrf
        <input type="hidden" name="promotion_id" value="{{ $promotion->id }}" />
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Asignar promoción</h3>
            </div>
            <div class="card-body">
                @foreach ($modelsData as $model => $items)
                    @if (!empty($items))
                        <div class="form-group col-md-4">
                            <label for="{{ class_basename($model) }}">{{ \App\Models\Promotion::$availableModels[$model] }}</label>
                            <select name="{{ class_basename($model) }}_ids[]" id="{{ class_basename($model) }}" multiple class="form-control select2">
                                <option value="all">Todos</option>
                                @foreach ($items as $item)
                                    <option value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                                @endforeach
                            </select>
                            @error('{{ class_basename($model) }}_ids')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    @endif
                @endforeach
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </form>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            $('#{{ class_basename($model) }}').select2({
                placeholder: 'Seleccione una o varias opciones',
                allowClear: true,
            });
        });
    </script>
@stop

@section('css')
    <style>
        /* Estilos para las opciones seleccionadas */
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            color: black;
        }
    </style>
@endsection
