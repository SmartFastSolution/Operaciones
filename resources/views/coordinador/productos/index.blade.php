@extends('layouts.nav')
@section('breadcrumb')
<li class="breadcrumb-item active" aria-current="page"><i class="fas fa-store"></i> Productos</li>
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('bundles/pretty-checkbox/pretty-checkbox.min.css') }}">
@endsection
@section('bodega', 'active')
@section('productos', 'active')
@section('content')
@section('titulo', '| Administrar Productos')
<div>
	<h1 class="text-danger text-center">Administracion de Productos</h1>
	@livewire('coordinador.producto.productos')
</div>
@endsection