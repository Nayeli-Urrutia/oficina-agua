@extends('adminlte::page')

@section('title', 'Nuevo Usuario')

@section('content_header')
<h1>Nuevo Usuario</h1>
@stop

@section('content')

<div class="card">
    <div class="card-body">

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">

                @foreach ($errors->all() as $error)
                <li>
                    {{ $error }}
                </li>
                @endforeach

            </ul>
        </div>
        @endif

        <form
            action="{{ route('usuarios.store') }}"
            method="POST">

            @csrf

            <div class="form-group mb-3">

                <label for="nombre">
                    Nombre *
                </label>

                <input
                    type="text"
                    name="nombre"
                    id="nombre"
                    class="form-control"
                    maxlength="120"
                    value="{{ old('nombre') }}"
                    required
                    autocomplete="name">

            </div>

            <div class="form-group mb-3">

                <label for="email">
                    Correo electrónico *
                </label>

                <input
                    type="email"
                    name="email"
                    id="email"
                    class="form-control"
                    maxlength="150"
                    value="{{ old('email') }}"
                    required
                    autocomplete="email">

                <small class="form-text text-muted">
                    El correo debe ser único dentro del sistema.
                </small>

            </div>

            <div class="form-group mb-3">

                <label for="rol_id">
                    Rol *
                </label>

                <select
                    name="rol_id"
                    id="rol_id"
                    class="form-control"
                    required>

                    <option value="">
                        Seleccione un rol
                    </option>

                    @foreach ($roles as $rol)

                    <option
                        value="{{ $rol->id }}"
                        {{ (string) old('rol_id') === (string) $rol->id
                         ? 'selected'
                  : '' }}
                        {{ $rol->nombre }}
                        </option>

                        @endforeach

                </select>

            </div>

            <div class="form-group mb-3">

                <label for="password">
                    Contraseña *
                </label>

                <input
                    type="password"
                    name="password"
                    id="password"
                    class="form-control"
                    minlength="8"
                    required
                    autocomplete="new-password">

                <small class="form-text text-muted">
                    Debe contener al menos 8 caracteres.
                </small>
                <div class="mt-2">
                    <div class="progress" style="height: 8px;">
                        <div
                            id="barraFuerza"
                            class="progress-bar"
                            role="progressbar"
                            style="width: 0%;"
                            aria-valuemin="0"
                            aria-valuemax="100">
                        </div>
                    </div>

                    <small id="textoFuerza" class="form-text font-weight-bold">
                        Fuerza: Sin evaluar
                    </small>

                    <div class="mt-2">
                        <small id="reqLongitud" class="d-block text-muted">
                            ○ 8 o más caracteres
                        </small>
                        <small id="reqMayuscula" class="d-block text-muted">
                            ○ Al menos una mayúscula
                        </small>
                        <small id="reqNumero" class="d-block text-muted">
                            ○ Al menos un número
                        </small>
                        <small id="reqSimbolo" class="d-block text-muted">
                            ○ Al menos un símbolo
                        </small>
                    </div>
                </div>

            </div>

            <div class="form-group mb-3">

                <label for="password_confirmation">
                    Confirmar contraseña *
                </label>

                <input
                    type="password"
                    name="password_confirmation"
                    id="password_confirmation"
                    class="form-control"
                    minlength="8"
                    required
                    autocomplete="new-password">

            </div>

            <div class="d-flex flex-column flex-sm-row flex-wrap gap-2">
                <button
                    type="submit"
                    class="btn btn-primary">
                    Guardar
                </button>

                <a
                    href="{{ route('usuarios.index') }}"
                    class="btn btn-secondary">
                    Cancelar
                </a>
            </div>
        </form>

    </div>
</div>

@stop
@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {

        const password = document.getElementById('password');
        const barra = document.getElementById('barraFuerza');
        const texto = document.getElementById('textoFuerza');

        const reqLongitud = document.getElementById('reqLongitud');
        const reqMayuscula = document.getElementById('reqMayuscula');
        const reqNumero = document.getElementById('reqNumero');
        const reqSimbolo = document.getElementById('reqSimbolo');

        password.addEventListener('input', function() {

            const valor = password.value;

            const longitud = valor.length >= 8;
            const mayuscula = /[A-Z]/.test(valor);
            const numero = /[0-9]/.test(valor);
            const simbolo = /[^A-Za-z0-9]/.test(valor);

            let puntos = 0;

            if (longitud) puntos++;
            if (mayuscula) puntos++;
            if (numero) puntos++;
            if (simbolo) puntos++;

            actualizarRequisito(
                reqLongitud,
                longitud,
                '8 o más caracteres'
            );

            actualizarRequisito(
                reqMayuscula,
                mayuscula,
                'Al menos una mayúscula'
            );

            actualizarRequisito(
                reqNumero,
                numero,
                'Al menos un número'
            );

            actualizarRequisito(
                reqSimbolo,
                simbolo,
                'Al menos un símbolo'
            );

            barra.className = 'progress-bar';

            if (valor.length === 0) {
                barra.style.width = '0%';
                texto.textContent = 'Fuerza: Sin evaluar';
                texto.className = 'form-text font-weight-bold';
            } else if (puntos <= 2) {
                barra.style.width = '33%';
                barra.classList.add('bg-danger');

                texto.textContent = 'Fuerza: Débil';
                texto.className = 'form-text font-weight-bold text-danger';
            } else if (puntos === 3) {
                barra.style.width = '66%';
                barra.classList.add('bg-warning');

                texto.textContent = 'Fuerza: Media';
                texto.className = 'form-text font-weight-bold text-warning';
            } else {
                barra.style.width = '100%';
                barra.classList.add('bg-success');

                texto.textContent = 'Fuerza: Fuerte';
                texto.className = 'form-text font-weight-bold text-success';
            }
        });

        function actualizarRequisito(elemento, cumple, mensaje) {
            if (cumple) {
                elemento.textContent = '✓ ' + mensaje;
                elemento.className = 'd-block text-success';
            } else {
                elemento.textContent = '○ ' + mensaje;
                elemento.className = 'd-block text-muted';
            }
        }

    });
</script>
@stop