@extends('adminlte::page')

@section('title', 'Productos')

@section('content_header')
    <h1>Productos</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title
            ">Listado de productos</h3>
        </div>

        <div class="card-body">
            <table class="table table-bordered table-striped dataTable">
                <thead>
                    <tr>
                        <th>Imagen</th>
                        <th>Nombre</th>
                        <th>Categoría</th>
                        <th>SKU</th>
                        <th>Precio</th>
                        <th>Descuento</th>
                        <th>Estatus</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td>
                                <img
                                    src="{{ Storage::url($product->image_path) }}"
                                    alt="{{ $product->name }}"
                                    class="img-thumbnail"
                                    width="100"
                                >
                            </td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->category->name }}</td>
                            <td>{{ $product->sku }}</td>
                            <td>{{ $product->price }}</td>
                            <td>{{ $product->discount }}</td>
                            <td>{{ $product->status }}</td>
                            <td>
                                <a href="{{ route('products.show', $product->id) }}" class="btn btn-info">Ver</a>
                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">Editar</a>
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop
