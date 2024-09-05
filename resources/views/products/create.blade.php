@extends('adminlte::page')
@section('plugins.BsCustomFileInput', true)

@section('title', 'Productos')

@section('content_header')
    <h1>Crear producto</h1>
@stop

@section('content')
    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Datos del producto</h3>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-4">
                        <x-adminlte.form.input id="name" value="{{ old('name') }}" name="name" label="Nombre" placeholder="Nombre del producto" />
                    </div>

                    <div class="form-group col-md-4">
                        <x-adminlte.form.select id="category_id" enable-old-support name="category_id" label="Categoría del producto" >
                            <option selected>Selecciona una categoría</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </x-adminlte.form.select>
                    </div>

                    <div class="form-group col-md-4">
                        <x-adminlte.form.input disabled value="{{ old('sku') }}" name="sku" label="SKU" placeholder="SKU del producto">
                            <x-slot name="bottomSlot">
                                <span class="text-muted">El SKU es calculado automáticamente</span>
                            </x-slot>
                        </x-adminlte.form.input>
                    </div>


                </div>

                <div class="row">
                    <div class="form-group col-md-4">
                        <x-adminlte.form.input value="{{ old('discount') }}" name="discount" label="Descuento" placeholder="Descuento del producto" type="number">
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
                        <x-adminlte.form.select enable-old-support name="status" label="Estatus del producto" >
                            <option value="active" selected>Activo</option>
                            <option value="inactive">Inactivo</option>
                            <option value="discontinued">Descontinuado</option>
                        </x-adminlte.form.select>
                    </div>

                    <div class="form-group col-md-4">
                        <x-adminlte.form.input value="{{ old('price') }}" name="price" label="Precio" placeholder="Precio del producto" type="number">
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
                        <x-adminlte.form.textarea name="description" label="Descripción" placeholder="Descripción del producto">
                            {{ old('description') }}
                        </x-adminlte.form.textarea>
                    </div>

                    <div class="form-group col-md-6">
                        <x-adminlte.form.input-file name="image" label="Imagen del producto" placeholder="Escoge una imagén...">
                            <x-slot name="prependSlot">
                                <div class="input-group-text bg-primary">
                                    <i class="fas fa-upload"></i>
                                </div>
                            </x-slot>
                        </x-adminlte.form.input-file>
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
                        <x-adminlte.form.input value="{{ old('quantity') }}" name="quantity" label="Cantidad" placeholder="Cantidad en stock" type="number" />
                    </div>
                    <div class="form-group col-md-4">
                        <x-adminlte.form.input value="{{ old('reorder_level') }}" name="reorder_level" label="Nivel de reorden" placeholder="Nivel de reorden" type="number" />
                    </div>

                    <div class="form-group col-md-4">
                        <x-adminlte.form.input value="{{ old('max_level') }}" name="max_level" label="Nivel máximo" placeholder="Nivel máximo" type="number" />
                    </div>
                </div>
            </div>

            <div class="card-footer d-flex justify-content-center">
                <x-adminlte.form.button type="submit" label="Guardar" theme="primary" icon="fas fa-lg fa-save"/>
            </div>
        </div>
    </form>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            function generateSku(name, category, size = null, color = null) {
                const namePart = name.split(' ')
                    .map(word => word.substring(0, 3).toUpperCase())
                    .join('');

                const categoryPart = category.substring(0, 3).toUpperCase();

                let sku = `${categoryPart}-${namePart}`;

                if (size) {
                    sku += `-${size.toUpperCase()}`;
                }

                if (color) {
                    sku += `-${color.charAt(0).toUpperCase()}`;
                }

                return sku;
            }

            $('#name, #category_id').on('change', function() {
                const name = $('#name').val();
                const category = $('#category_id option:selected').text();

                if (category === 'Selecciona una categoría') {
                    $('#sku').val('');
                } else {
                    const sku = generateSku(name, category);
                    $('#sku').val(sku);
                }
            });
        });
    </script>

@endsection
