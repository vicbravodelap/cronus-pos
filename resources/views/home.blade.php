@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1></h1>
@stop

@section('content')
    <div class="container mt-5">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Identificación Virtual del Usuario</h4>
            </div>
            <div class="card-body">
                <div class="row align-items-center">
                    <!-- Información del usuario -->
                    <div class="col-md-8">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Nombre:</strong>
                                <p>{{ $user->name }}</p>
                            </div>
                            <div class="col-md-6">
                                <strong>Email:</strong>
                                <p>{{ $user->email }}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-4">
                                <strong>Inicio de membresía:</strong>
                                <p>{{ $user->membership->start_at->format('Y-m-d') ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-4">
                                <strong>Final de membresía:</strong>
                                <p>{{ $user->membership->end_at->format('Y-m-d') ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-4">
                                <strong>Dias restantes:</strong>
                                <p>{{ $user->membership->days_left }} {{ $user->membership->days_left == 1 ? 'dia' : 'dias' }}</p>
                            </div>
                        </div>
                    </div>
                    <!-- Código QR -->
                    <div class="col-md-4 text-center">
                        <strong>QR Code:</strong>
                        <div class="p-3 border rounded">
                            <a href="#" data-toggle="modal" data-target="#qrModal">
                                {!! QrCode::size(200)->generate($token) !!}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="qrModal" tabindex="-1" role="dialog" aria-labelledby="qrModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="qrModalLabel">Código QR</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    {!! QrCode::size(380)->generate($token) !!}
                </div>
            </div>
        </div>
    </div>
@stop
