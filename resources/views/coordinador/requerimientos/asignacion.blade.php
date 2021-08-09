@extends('layouts.nav')
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('coordinador.requerimiento.index') }}"><i
                class="fas fa-clipboard-list"></i> Requerimientos</a></li>
    <li class="breadcrumb-item active" aria-current="page"> Asignacion</li>
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('bundles/pretty-checkbox/pretty-checkbox.min.css') }}">
@endsection
@section('requerimiento', 'active')
@section('asignacion', 'active')
@section('content')
@section('titulo', '| Asignacion')
<div>
<h1 class="text-danger text-center">Asignación de Requerimientos</h1>
@livewire('coordinador.requerimiento.asignacion-requerimiento')
@livewire('coordinador.requerimiento.liberacion-requerimiento')
</div>
@endsection

@section('js')
<script src="https://cdn.ckeditor.com/4.10.0/full/ckeditor.js"></script>
<script type="text/javascript">
    let operadores = @json($operadores);
    const requerimiento = new Vue({
        el: "#requerimiento",
        data: {
            operador_id: '',
            operadores: operadores,
        },
        methods: {
            operadorEmit() {
                Livewire.emit('cargarOperador', this.operador_id);
            },
            limpiarCampos() {
                this.sector = '';
            },
        }

    });
    Livewire.on('guardarObservacion', function() {
        Livewire.emit('createRequerimiento', requerimiento.detalle_actividad);
    });
    Livewire.on('limpiarCampo', function() {
        requerimiento.limpiarCampos();
    });
</script>
@endsection
