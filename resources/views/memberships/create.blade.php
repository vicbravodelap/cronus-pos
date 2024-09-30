@extends('adminlte::page')

@section('plugins.Select2', true)

@section('title', 'Crear Membresía')

@section('content_header')
    <h1>Crear membresía</h1>
@stop

@section('content')
    <form action="{{ route('memberships.store') }}" method="POST">
        @csrf
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    Datos de la membresía
                </h3>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 form-group">
                        <label for="name">Nombre</label>
                        <x-adminlte.form.input name="name" enable-old-support />
                    </div>

                    <div class="col-md-3 form-group">
                        <label for="name">Email</label>
                        <x-adminlte.form.input name="email" type="email" enable-old-support />
                    </div>

                    <div class="col-md-3 form-group">
                        <label for="name">Contraseña</label>
                        <x-adminlte.form.input type="password" name="password" />
                    </div>

                    <div class="col-md-3 form-group">
                        <label for="name">Confirmación de contraseña</label>
                        <x-adminlte.form.input type="password" name="password_confirmation" />
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3 form-group">
                        <label for="start_at">Inicia</label>
                        <x-adminlte.form.input name="start_at" type="date" enable-old-support />
                    </div>

                    <div class="col-md-3 form-group">
                        <label for="end_at">Termina</label>
                        <x-adminlte.form.input name="end_at" type="date" enable-old-support />
                    </div>

                    <div class="col-md-3 form-group">
                        <label for="status">Estatus</label>
                        <x-adminlte.form.select name="status" enable-old-support>
                            <option value="active">Activa</option>
                            <option value="inactive">Inactiva</option>
                        </x-adminlte.form.select>
                    </div>

                    <div class="col-md-3">
                        <label for="promotion_id">Promoción</label>
                        <x-adminlte.form.select2 :enable-old-support name="promotion_id" id="promotion-select" />
                    </div>
                </div>
            </div>

            <div class="card-footer d-flex justify-content-center">
                <button class="btn btn-primary">
                    Guardar
                </button>
            </div>
        </div>
    </form>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            $('#promotion-select').select2({
                theme: 'bootstrap4',
                placeholder: "Selecciona una promoción",
                allowClear: true,
                ajax: {
                    url: '{{ route("promotions.search") }}',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data
                        };
                    },
                    cache: true
                }
            });
        });
    </script>
@stop

