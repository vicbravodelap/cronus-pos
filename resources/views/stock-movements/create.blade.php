@extends('adminlte::page')

@section('title', 'Crear movimiento de stock')

@section('content_header')
    <h1>Crear movimiento de stock</h1>
@endsection


@section('content')
    <form action="{{ route('stock.movements.store', ['stock' => request()->route('stock' )]) }}" method="POST">
        @csrf
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Datos del movimiento</h3>
            </div>
            <div class="card-body">
                <input type="hidden" name="stock_id" value="{{ request()->route('stock') }}">
                <div class="row">
                    <div class="form-group col-md-3">
                        <x-adminlte.form.select name="type" enable-old-support>
                            <option>Selección un tipo</option>
                            <option value="in">Entrada</option>
                            <option value="out">Salida</option>
                        </x-adminlte.form.select>
                    </div>

                    <div class="form-group col-md-3">
                        <x-adminlte.form.input name="quantity" type="number" placeholder="Cantidad" />
                    </div>

                    <div class="form-group col-md-3">
                        <input type="date" name="date" class="form-control">
                        @error('date')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group col-md-3">
                        <x-adminlte.form.textarea name="reason" placeholder="Razón" />
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <button class="btn btn-primary" type="submit">Guardar</button>
            </div>
        </div>
    </form>
@endsection
