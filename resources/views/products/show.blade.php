@extends('adminlte::page')

@section('title', 'Productos')

@section('content_header')
    <h1>Ver producto</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Datos del producto</h3>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="form-group col-md-4">
                    <x-adminlte.form.input id="name" disabled value="{{ $product->name }}" name="name" label="Nombre" placeholder="Nombre del producto" />
                </div>

                <div class="form-group col-md-4">
                    <x-adminlte.form.select disabled id="category_id" name="category_id" label="Categoría del producto" >
                        <option selected>Selecciona una categoría</option>
                        @foreach($categories as $category)
                            <option {{ $category->id == $product->category_id ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </x-adminlte.form.select>
                </div>

                <div class="form-group col-md-4">
                    <x-adminlte.form.input disabled value="{{ $product->sku }}" name="sku" label="SKU" placeholder="SKU del producto">
                        <x-slot name="bottomSlot">
                            <span class="text-muted">El SKU es calculado automáticamente</span>
                        </x-slot>
                    </x-adminlte.form.input>
                </div>


            </div>

            <div class="row">
                <div class="form-group col-md-4">
                    <x-adminlte.form.input disabled value="{{ $product->discount }}" name="discount" label="Descuento" placeholder="Descuento del producto" type="number">
                        <x-slot name="prependSlot">
                            <div class="input-group-text text-olive">
                                <i class="fas fa-percent"></i>
                            </div>
                        </x-slot>

                        <x-slot name="bottomSlot">
                            <span class="text-muted">El descuento es en porcentaje del total del precio</span>
                        </x-slot>
                    </x-adminlte.form.input>
                </div>

                <div class="form-group col-md-4">
                    <x-adminlte.form.select disabled name="status" label="Estatus del producto" >
                        <option {{ 'active' == $product->status ? 'selected' : '' }} value="active" selected>Activo</option>
                        <option {{ 'inactive' == $product->status ? 'selected' : '' }} value="inactive">Inactivo</option>
                        <option {{ 'discontinued' == $product->status ? 'selected' : '' }} value="discontinued">Descontinuado</option>
                    </x-adminlte.form.select>
                </div>

                <div class="form-group col-md-4">
                    <x-adminlte.form.input disabled value="{{ $product->price }}" name="price" label="Precio" placeholder="Precio del producto" type="number">
                        <x-slot name="prependSlot">
                            <div class="input-group-text text-olive">
                                <i class="fas fa-money-bill-alt"></i>
                            </div>
                        </x-slot>
                    </x-adminlte.form.input>
                </div>

            </div>

            <div class="row">
                <div class="form-group col-md-6">
                    <x-adminlte.form.textarea disabled name="description" label="Descripción" placeholder="Descripción del producto">
                        {{ $product->description }}
                    </x-adminlte.form.textarea>
                </div>

                <div class="form-group col-md-6">
                    <label for="image">Imagén del producto</label>
                    <input disabled type="file" class="form-control" name="image" placeholder="Escoge una imagén">
                    @error('image')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-header">
            <h3 class="card-title">Datos del stock</h3>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="form-group col-md-4">
                    <x-adminlte.form.input disabled value="{{ $product->stock->quantity }}" name="quantity" label="Cantidad" placeholder="Cantidad en stock" type="number" />
                </div>
                <div class="form-group col-md-4">
                    <x-adminlte.form.input disabled value="{{ $product->stock->reorder_level }}" name="reorder_level" label="Nivel de reorden" placeholder="Nivel de reorden" type="number" />
                </div>

                <div class="form-group col-md-4">
                    <x-adminlte.form.input disabled value="{{ $product->stock->max_level }}" name="max_level" label="Nivel máximo" placeholder="Nivel máximo" type="number" />
                </div>
            </div>
        </div>
    </div>
@stop
