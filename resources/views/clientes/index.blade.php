@extends('adminlte::page')

@section('title', 'Clientes')

@section('content_header')
<h1>Clientes</h1>
@stop

@section('content')

@if (session('exito'))
<div class="alert alert-success">{{ session('exito') }}</div>
@endif

@if (session('error'))
<div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">

            <div class="col-12 col-lg-7">
                <input type="text"
                    id="busquedaCliente"
                    class="form-control"
                    placeholder="Buscar cliente...">
            </div>

            <a href="{{ route('clientes.create') }}" class="btn btn-primary">
                + Nuevo Cliente
            </a>
        </div>
    </div>

    <div class="card-body p-0 table-responsive">
        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>DPI</th>
                    <th>Teléfono</th>
                    <th>Dirección</th>
                    <th>Estado</th>
                    <th style="width: 160px;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($clientes as $cliente)
               
                <tr class="fila-cliente">
                    <td>{{ $cliente->nombre }}</td>
                    <td>{{ $cliente->dpi }}</td>
                    <td>{{ $cliente->telefono ?? '—' }}</td>
                    <td>{{ $cliente->direccion_principal ?? '—' }}</td>
                    <td>
                        @if ($cliente->activo)
                        <span class="badge text-bg-success">Activo</span>
                        @else
                        <span class="badge text-bg-secondary">Inactivo</span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex flex-wrap gap-2">
                            <a href="{{ route('clientes.edit', $cliente) }}"
                                class="btn btn-sm btn-warning">Editar</a>

                            <form action="{{ route('clientes.destroy', $cliente) }}"
                                method="POST" class="d-inline"
                                onsubmit="return confirm('¿Seguro que querés eliminar este cliente?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    Eliminar
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4">
                        No hay clientes registrados todavía.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div id="sinResultados" class="text-center py-4 d-none">
            No se encontraron resultados.
        </div>
    </div>

    <div class="card-footer">
        {{ $clientes->links('pagination::bootstrap-5') }}
    </div>
</div>

@stop

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const buscador = document.getElementById('busquedaCliente');
        const filas = document.querySelectorAll('.fila-cliente');
        const sinResultados = document.getElementById('sinResultados');

        buscador.addEventListener('input', function () {
            const texto = this.value.toLowerCase().trim();
            let encontrados = 0;

            filas.forEach(function (fila) {
                const contenido = fila.textContent.toLowerCase();
                const coincide = contenido.includes(texto);

                fila.style.display = coincide ? '' : 'none';

                if (coincide) {
                    encontrados++;
                }
            });

            sinResultados.classList.toggle('d-none', encontrados > 0);
        });
    });
</script>
@stop