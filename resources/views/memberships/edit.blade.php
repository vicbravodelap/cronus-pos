@extends('adminlte::page')

@section('plugins.Select2', true)

@section('title', 'Editar Membresía')

@section('content_header')
    <h1>Editar membresía</h1>
@stop

@section('content')
    <form action="{{ route('memberships.update', ['membership' => $membership]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    Datos de la membresía
                </h3>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="name">Nombre</label>
                        <x-adminlte.form.input name="name" value="{{ $membership->user->name }}" enable-old-support />
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="email">Email</label>
                        <x-adminlte.form.input name="email" type="email" value="{{ $membership->user->email }}" enable-old-support />
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3 form-group">
                        <label for="start_at">Inicia</label>
                        <x-adminlte.form.input name="start_at" type="date" value="{{ $membership->start_at->format('Y-m-d') }}" enable-old-support />
                    </div>

                    <div class="col-md-3 form-group">
                        <label for="end_at">Termina</label>
                        <x-adminlte.form.input name="end_at" type="date" value="{{ $membership->end_at->format('Y-m-d') }}" enable-old-support />
                    </div>

                    <div class="col-md-3 form-group">
                        <label for="status">Estatus</label>
                        <x-adminlte.form.select name="status" enable-old-support>
                            <option value="active" {{ $membership->status == 'active' ? 'selected' : '' }}>Activa</option>
                            <option value="inactive" {{ $membership->status == 'inactive' ? 'selected' : '' }}>Inactiva</option>
                        </x-adminlte.form.select>
                    </div>

                    <div class="col-md-3">
                        <label for="promotion_id">Promoción</label>
                        <select name="promotion_id" id="promotion-select" class="select2 form-control">
                            @foreach($promotions as $promotion)
                                <option value="{{ $promotion->id }}" {{ $membership->promotion_id == $promotion->id ? 'selected' : '' }}>
                                    {{ $promotion->name }}
                                </option>
                            @endforeach
                        </select>
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
