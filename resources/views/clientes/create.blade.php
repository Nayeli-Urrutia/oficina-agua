@extends('adminlte::page')

@section('title', 'Nuevo Cliente')

@section('content_header')
<h1>Nuevo Cliente</h1>
@stop

@section('content')

<div class="card">
    <div class="card-body">

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('clientes.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="nombre">Nombre *</label>
                <input type="text" name="nombre" id="nombre"
                    class="form-control" value="{{ old('nombre') }}" required>
            </div>

            <div class="form-group">
                <label for="dpi">DPI *</label>
                <input type="text" name="dpi" id="dpi"
                    class="form-control" value="{{ old('dpi') }}" required maxlength="20">
            </div>

            <div class="form-group">
                <label for="telefono">Teléfono</label>
                <input type="text" name="telefono" id="telefono"
                    class="form-control" value="{{ old('telefono') }}">
            </div>

            <div class="form-group">
                <label for="direccion_principal">Dirección</label>

                <input type="text"
                    name="direccion_principal"
                    id="direccion_principal"
                    class="form-control"
                    value="{{ old('direccion_principal') }}"
                    maxlength="255">

                <div class="d-flex justify-content-between mt-1">
                    <small id="alertaCaracteres" class="form-text text-muted">
                        Escriba la dirección del cliente.
                    </small>

                    <small id="contadorCaracteres" class="form-text text-muted">
                        0 / 255 caracteres
                    </small>
                </div>
            </div>

            <div class="form-group form-check">
                <input type="checkbox" name="activo" id="activo"
                    class="form-check-input" value="1" checked>
                <label class="form-check-label" for="activo">Activo</label>
            </div>

            <div class="d-flex flex-column flex-sm-row flex-wrap gap-2">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="{{ route('clientes.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>

    </div>
</div>

@stop
@section('js')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const campo = document.getElementById('direccion_principal');
    const contador = document.getElementById('contadorCaracteres');
    const alerta = document.getElementById('alertaCaracteres');

    const limite = 255;
    const advertencia = 220;

    function actualizarContador() {

        const cantidad = campo.value.length;

        contador.textContent = cantidad + ' / ' + limite + ' caracteres';

        if (cantidad >= limite) {

            contador.className = 'form-text text-danger font-weight-bold';
            alerta.className = 'form-text text-danger font-weight-bold';
            alerta.textContent = 'Límite de caracteres alcanzado.';

        } else if (cantidad >= advertencia) {

            contador.className = 'form-text text-warning font-weight-bold';
            alerta.className = 'form-text text-warning font-weight-bold';
            alerta.textContent = 'Se está acercando al límite.';

        } else {

            contador.className = 'form-text text-muted';
            alerta.className = 'form-text text-muted';
            alerta.textContent = 'Escriba la dirección del cliente.';
        }
    }

    campo.addEventListener('input', actualizarContador);

    actualizarContador();

});
</script>
@stop