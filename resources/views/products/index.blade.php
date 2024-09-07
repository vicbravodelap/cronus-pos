@extends('adminlte::page')

@section('title', 'Productos')

@section('content_header')
    <h1>Productos</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Listado de productos</h3>
            <div class="card-tools">
                <form action="{{ route('products.index') }}" method="GET" class="form-inline">
                    <div class="input-group input-group-sm">
                        <input type="text" name="search" class="form-control" placeholder="Buscar producto" value="{{ request('search') }}">
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
            <table class="table table-hover text-nowrap">
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
                            <td data-price="{{ $product->price }}">{{ $product->price }}</td>
                            <td>{{ $product->discount ?? 'No hay descuento' }}</td>
                            <td>
                                @if($product->status === 'active')
                                    <span class="badge badge-success">
                                        <i class="fas fa-check-circle"></i> ACTIVO
                                    </span>
                                @elseif($product->status === 'inactive')
                                    <span class="badge badge-warning">
                                        <i class="fas fa-exclamation-circle"></i> INACTIVO
                                    </span>
                                @elseif($product->status === 'discontinued')
                                    <span class="badge badge-danger">
                                        <i class="fas fa-times-circle"></i> DESCONTINUADO
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Opciones
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <a class="dropdown-item" href="{{ route('products.show', $product->id) }}">
                                            <i class="fas fa-eye"></i> Ver
                                        </a>
                                        <a class="dropdown-item" href="{{ route('products.edit', $product->id) }}">
                                            <i class="fas fa-edit"></i> Editar
                                        </a>
                                        <a class="dropdown-item" href="{{ route('products.destroy', $product->id) }}" data-confirm-delete>
                                            <i class="fas fa-trash-alt"></i> Eliminar
                                        </a>
                                        <button class="dropdown-item" data-toggle="modal" data-target="#stockModal" data-stock="{{ $product->stock->quantity }}" data-movements="{{ $product->stock->movements }}">
                                            <i class="fas fa-box"></i> Ver Stock
                                        </button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="card-footer">
            {{ $products->links() }}
        </div>
    </div>

    <div class="modal fade" id="stockModal" tabindex="-1" role="dialog" aria-labelledby="stockModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="stockModalLabel">Stock del Producto</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <h5 class="font-weight-bold">Cantidad en stock:</h5>
                        <p id="stockQuantity" class="lead"></p>
                    </div>
                    <div>
                        <h5 class="font-weight-bold">Movimientos de Stock</h5>
                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Tipo</th>
                                <th>Cantidad</th>
                                <th>Fecha</th>
                            </tr>
                            </thead>
                            <tbody id="stockMovementsList">
                            <!-- Stock movements will be populated here -->
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
$(document).ready(function() {
    $('#stockModal').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget);
        let stock = button.data('stock');
        let movements = button.data('movements');
        let modal = $(this);
        modal.find('.modal-body #stockQuantity').text(stock);

        let movementsList = modal.find('.modal-body #stockMovementsList');
        movementsList.empty();
        movements.forEach(movement => {
            let movementTypeBadge = movement.type === 'in'
                ? '<span class="badge badge-success">Entrada</span>'
                : '<span class="badge badge-danger">Salida</span>';
            let quantityText = movement.quantity === 1 ? 'pieza' : 'piezas';
            let listItem = `<tr>
                                <td>${movementTypeBadge}</td>
                                <td>${movement.quantity} ${quantityText}</td>
                                <td>${movement.created_at}</td>
                            </tr>`;
            movementsList.append(listItem);
                });
            });
        });

        function formatPriceInMXN(price) {
            return new Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN' }).format(price);
        }

        document.addEventListener('DOMContentLoaded', function() {
            const priceCells = document.querySelectorAll('td[data-price]');
            priceCells.forEach(cell => {
                const price = parseFloat(cell.textContent);
                cell.textContent = formatPriceInMXN(price);
            });
        });
    </script>
@stop
