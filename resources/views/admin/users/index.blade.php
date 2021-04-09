@extends('layouts.nav')
@section('breadcrumb')
<li class="breadcrumb-item active" aria-current="page"><i class="fas fa-users"></i> Usuarios</li>
@endsection
@section('content')
@section('usuarios', 'active')
@section('titulo', '| Administrar Usuarios')
<div id="confirmareliminar" >
	<h1 class="text-danger text-center">Administracion de Usuarios</h1>
	<br>
	<div class="col-sm-2 ml-auto">
	</div>
	<br>
	@livewire('admin.users.usuarios')
</div>
@endsection