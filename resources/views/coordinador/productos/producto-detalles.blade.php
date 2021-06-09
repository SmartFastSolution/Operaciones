@extends('layouts.nav')
@section('breadcrumb')
<li class="breadcrumb-item active" aria-current="page"><i class="fas fa-store"></i>{{ $producto->nombre }}</li>
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('bundles/pretty-checkbox/pretty-checkbox.min.css') }}">

@endsection
@section('bodega', 'active')
@section('productos', 'active')
@section('content')
@section('titulo', '| Detalles Producto')
<div>
	@livewire('coordinador.producto.producto-detalles', [$id])
</div>
@endsection
@section('js')
@endsection