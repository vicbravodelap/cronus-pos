@extends('adminlte::page')

@section('title', 'Productos')

@section('content_header')
    <h1>Editar producto</h1>
@stop

@section('content')
    <form action="{{ route('products.update', ['product' => $product]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Datos del producto</h3>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-4">
                        <x-adminlte.form.input id="name" value="{{ $product->name }}" name="name" label="Nombre" placeholder="Nombre del producto" />
                    </div>

                    <div class="form-group col-md-4">
                        <x-adminlte.form.select id="category_id" name="category_id" label="Categoría del producto" >
                            <option selected>Selecciona una categoría</option>
                            @foreach($categories as $category)
                                <option {{ $category->id == $product->category_id ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </x-adminlte.form.select>
                    </div>

                    <div class="form-group col-md-4">
                        <x-adminlte.form.input value="{{ $product->sku }}" name="sku" label="SKU" placeholder="SKU del producto">
                            <x-slot name="bottomSlot">
                                <span class="text-muted">El SKU es calculado automáticamente</span>
                            </x-slot>
                        </x-adminlte.form.input>
                    </div>


                </div>

                <div class="row">
                    <div class="form-group col-md-4">
                        <x-adminlte.form.input value="{{ $product->discount }}" name="discount" label="Descuento" placeholder="Descuento del producto" type="number">
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
                        <x-adminlte.form.select name="status" label="Estatus del producto" >
                            <option {{ 'active' == $product->status ? 'selected' : '' }} value="active" selected>Activo</option>
                            <option {{ 'inactive' == $product->status ? 'selected' : '' }} value="inactive">Inactivo</option>
                            <option {{ 'discontinued' == $product->status ? 'selected' : '' }} value="discontinued">Descontinuado</option>
                        </x-adminlte.form.select>
                    </div>

                    <div class="form-group col-md-4">
                        <x-adminlte.form.input value="{{ $product->price }}" name="price" label="Precio" placeholder="Precio del producto" type="number">
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
                            {{ $product->description }}
                        </x-adminlte.form.textarea>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="image">Imagén del producto</label>
                        <input type="file" class="form-control" name="image" id="image" placeholder="Escoge una imagén">
                        @error('image')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                        <div class="mt-3">
                            <img id="imagePreview" src="{{ Storage::url($product->image_path) }}" alt="Imagen del producto" class="img-thumbnail" style="max-width: 200px;">
                        </div>
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
                        <x-adminlte.form.input value="{{ $product->stock->quantity }}" name="quantity" label="Cantidad" placeholder="Cantidad en stock" type="number" />
                    </div>
                    <div class="form-group col-md-4">
                        <x-adminlte.form.input value="{{ $product->stock->reorder_level }}" name="reorder_level" label="Nivel de reorden" placeholder="Nivel de reorden" type="number" />
                    </div>

                    <div class="form-group col-md-4">
                        <x-adminlte.form.input value="{{ $product->stock->max_level }}" name="max_level" label="Nivel máximo" placeholder="Nivel máximo" type="number" />
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

            function updateSku() {
                const name = nameSelector.val();
                const category = $('#category_id option:selected').text();

                if (category === 'Selecciona una categoría') {
                    $('#sku').val('');
                } else {
                    const sku = generateSku(name, category);
                    console.log('Generated SKU:', sku);
                    $('#sku').val(sku);
                }
            }

            const nameSelector = $('#name');

            if (nameSelector.val() && $('#category_id').val()) {
                updateSku();
            }

            nameSelector.add('#category_id').on('change', function() {
                updateSku();
            });

            $('form').on('submit', function() {
                const sku = $('#sku').val();
                if (!sku) {
                    alert('SKU cannot be empty');
                    return false;
                }
            });

            $('#image').on('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#imagePreview').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
@endsection
