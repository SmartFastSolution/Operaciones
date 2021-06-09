@extends('layouts.nav')
@section('breadcrumb')
<li class="breadcrumb-item active" aria-current="page"><i class="fas fa-user"></i> {{ $user->nombres }}</li>
@endsection
@section('content')
@section('user', 'active')
@section('titulo', '| '.$user->nombres)
<div id="confirmareliminar" >
	<div class="row">
		<div class="col-12 col-md-12 col-lg-4">
			<div class="card profile-widget">
				<div class="profile-widget-header">
					<img alt="image" src="{{ Avatar::create($user->nombres)->setFontSize(35)->setChars(4) }}" class="rounded-circle profile-widget-picture">
					<div class="profile-widget-items">
						<div class="profile-widget-item">
							<div class="profile-widget-item-label">Requerimientos</div>
							<div class="profile-widget-item-value">{{ $user->requerimientos->count() }}</div>
						</div>
						{{-- 	<div class="profile-widget-item">
							<div class="profile-widget-item-label">Followers</div>
							<div class="profile-widget-item-value">9,3K</div>
						</div>
						<div class="profile-widget-item">
							<div class="profile-widget-item-label">Following</div>
							<div class="profile-widget-item-value">3,7K</div>
						</div> --}}
					</div>
				</div>
				<div class="profile-widget-description pb-0">
					<div class="profile-widget-name text-center"> Operador<div class="text-muted d-inline font-weight-normal">
						
					</div>
				</div>
			</div>
		</div>
		<div class="card">
			<div class="card-header">
				<h4>Detalles</h4>
			</div>
			<div class="card-body">
				<p class="clearfix">
					<span class="float-left">
						Requerimientos Pendientes
					</span>
					<span class="float-right text-danger">
						{{ $user->requerimientos->where('estado', 'pendiente')->count() }}
					</span>
				</p>
				<p class="clearfix">
					<span class="float-left">
						Requerimientos Atendidos
					</span>
					<span class="float-right text-success">
						{{ $user->requerimientos->where('estado', 'ejecutado')->count() }}
					</span>
				</p>
			</div>
		</div>
	</div>
	<div class="col-12 col-md-12 col-lg-8">
		<div class="card" style="height: 550px">
			<div wire:ignore.self class="padding-20">
				<ul  class="nav nav-tabs" id="myTab2" role="tablist">
					<li class="nav-item">
						<a wire:ignore class="nav-link active" id="personales-tab2" data-toggle="tab" href="#personales" role="tab" aria-selected="true">Personales</a>
					</li>
					<li class="nav-item">
						<a wire:ignore class="nav-link" id="contrasena-tab2" data-toggle="tab" href="#contrasena" role="tab" aria-selected="false"> Contraseña</a>
					</li>
				</ul>
				<div wire:ignore.self  class="tab-content tab-bordered" id="myTab3Content">
					<div class="tab-pane fade show active" id="personales" role="tabpanel" aria-labelledby="personales-tab2" wire:ignore.self>
						@livewire('component.datos-personales')
					
					</div>
					<div class="tab-pane fade" id="contrasena" role="tabpanel" aria-labelledby="contrasena-tab2" wire:ignore.self>
						@livewire('component.password')
						
					</div>
				</div>
				
			</div>
		</div>
	</div>
</div>
</div>
@endsection