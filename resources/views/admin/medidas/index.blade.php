@extends('layouts.nav')
@section('content')
@section('breadcrumb')
<li class="breadcrumb-item active" aria-current="page"><i class="fad fa-map"></i> Unidades de Medidas</li>
@endsection
@section('medidas', 'active')
@section('titulo', '| Unidades de Medidas')
<div id="confirmareliminar" >
	<h1 class="text-danger text-center">Administracion de Unidades de Medidas</h1>
	<br>
	@livewire('admin.medida.unidades-medidas')
</div>
@endsection