@extends('layouts.nav')
@section('css')
<link rel="stylesheet" href="{{ asset('bundles/pretty-checkbox/pretty-checkbox.min.css') }}">

@endsection
@section('bodega', 'active')
@section('ingresos', 'active')
@section('content')
@section('titulo', '| Detalles Ingreso')
<div>
	@livewire('coordinador.producto.ingreso-detalles', [$id])
</div>
@endsection
@section('js')
@endsection