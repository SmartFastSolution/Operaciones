@extends('layouts.nav')
@section('breadcrumb')
<li class="breadcrumb-item active" aria-current="page"><i class="fad fa-map"></i> Sectores</li>
@endsection
@section('content')
@section('sectores', 'active')
@section('titulo', '| Administrar Usuarios')
<div id="confirmareliminar" >
	<h1 class="text-danger text-center">Administracion de Sectores</h1>
	<br>
	<div class="col-sm-2 ml-auto">
	</div>
	<br>
	@livewire('admin.sectors.sectores')
</div>
@endsection