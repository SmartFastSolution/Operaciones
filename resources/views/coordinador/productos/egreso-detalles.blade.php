@extends('layouts.nav')
@section('breadcrumb')
<li class="breadcrumb-item" > <a href="{{ route('coordinador.producto.egreso') }}"><i class="fas fa-arrow-circle-right"></i> Egresos</a></li>
<li class="breadcrumb-item active" aria-current="page">{{ $egreso->codigo }}</li>
@endsection
@section('css')
<link rel="stylesheet" href="{{ asset('bundles/pretty-checkbox/pretty-checkbox.min.css') }}">

@endsection
@section('bodega', 'active')
@section('egresos', 'active')
@section('content')
@section('titulo', '| Detalles Egreso')
<div>
	@livewire('coordinador.producto.egreso-detalles', [$id])
</div>
@endsection
@section('js')
@endsection