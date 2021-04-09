@extends('layouts.nav')
@section('css')
<link rel="stylesheet" href="{{ asset('bundles/pretty-checkbox/pretty-checkbox.min.css') }}">
@endsection
@section('bodega', 'active')
@section('productos', 'active')
@section('content')
@section('titulo', '| Administrar Productos')
<div>
	<h1 class="text-danger text-center">EGRESOS</h1>
	@livewire('coordinador.producto.egresos')
</div>
@endsection