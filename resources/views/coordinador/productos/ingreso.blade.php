@extends('layouts.nav')
@section('css')
<link rel="stylesheet" href="{{ asset('bundles/pretty-checkbox/pretty-checkbox.min.css') }}">
<style type="text/css">
	input[type=number]::-webkit-inner-spin-button, 
input[type=number]::-webkit-outer-spin-button { 
  -webkit-appearance: none; 
  margin: 0; 
}

input[type=number] { -moz-appearance:textfield; }
</style>
@endsection
@section('bodega', 'active')
@section('ingresos', 'active')
@section('content')
@section('titulo', '| Ingresos')
<div>
	<h1 class="text-danger text-center">INGRESOS</h1>
	@livewire('coordinador.producto.ingresos')
</div>
@endsection

@section('js')
@endsection