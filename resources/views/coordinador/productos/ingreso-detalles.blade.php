@extends('layouts.nav')
@section('breadcrumb')
<li class="breadcrumb-item" > <a href="{{ route('coordinador.producto.ingreso') }}"><i class="fas fa-arrow-circle-right"></i> Ingresos</a></li>
<li class="breadcrumb-item active" aria-current="page">{{ $id }}</li>
@endsection
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