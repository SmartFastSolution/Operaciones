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
							<div class="profile-widget-item-label">Talleres</div>
							{{-- <div class="profile-widget-item-value">{{ $user->tallers->count() }}</div> --}}
						</div>
						<div class="profile-widget-item">
							<div class="profile-widget-item-label">Followers</div>
							<div class="profile-widget-item-value">9,3K</div>
						</div>
						<div class="profile-widget-item">
							<div class="profile-widget-item-label">Following</div>
							<div class="profile-widget-item-value">3,7K</div>
						</div>
					</div>
				</div>
				<div class="profile-widget-description pb-0">
					<div class="profile-widget-name text-center"> @role('super-admin') Super Admin @endrole @role('admin') Administrador @endrole <div class="text-muted d-inline font-weight-normal">
						
					</div>
				</div>
				<p>@isset ($user->instituto->nombre)
					{{ $user->instituto->nombre }}
				@endisset</p>
			</div>
		</div>
		<div class="card">
			<div class="card-header">
				<h4>Detalles</h4>
			</div>
			<div class="card-body">
				{{-- <div class="py-4">
					@isset ($user->distribucion->curso->nombre)
					<p class="clearfix">
						<span class="float-left">
							Curso
						</span>
						<span class="float-right text-muted">
							{{ $user->distribucion->curso->nombre }}
						</span>
					</p>
					@endisset
					@isset ($user->nivel->nombre)
					<p class="clearfix">
						<span class="float-left">
							Paralelo
						</span>
						<span class="float-right text-muted">
							{{ $user->nivel->nombre }}
						</span>
					</p>
					@endisset
					<p class="clearfix">
						<span class="float-left">
							Direccion
						</span>
						<span class="float-right text-muted">
							{{ $user->domicilio }}
						</span>
					</p>
					<p class="clearfix">
						<span class="float-left">
							Correo
						</span>
						<span class="float-right text-muted">
							{{ $user->email }}
						</span>
					</p>
					<p class="clearfix">
						<span class="float-left">
							Telefono
						</span>
						<span class="float-right text-muted">
							{{ $user->telefono }}
						</span>
					</p>
					
				</div> --}}
			</div>
		</div>
	</div>
	<div class="col-12 col-md-12 col-lg-8">
		<div class="card" style="height: 500px">
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
						<h2 class="text-center font-weight-bold text-danger">DATOS PERSONALES</h2>
						<div class="form-row">
							<div class="form-group col-lg-8">
								<label for="">Nombres</label>
								<input type="text" class="form-control" disabled="" value="{{ $user->nombres }}">
							</div>
							<div class="form-group col-lg-4">
								<label for="">Cedula</label>
								<input type="text" class="form-control" disabled="" value="{{ $user->cedula }}">
							</div>
							<div class="form-group col-lg-6">
								<label for="">Telefono</label>
								<input type="number" class="form-control" disabled="" value="{{ $user->telefono }}">
							</div>
							<div class="form-group col-lg-6">
								<label for="">Celular</label>
								<input type="text" class="form-control" disabled="" value="{{ $user->celular }}">
							</div>
							<div class="form-group col-lg-12">
								<label for="">Direccion</label>
								<textarea name=" " id="" cols="30" rows="10" class="form-control" disabled="">{{$user->domicilio }}</textarea>
							</div>
						</div>
					</div>
					<div class="tab-pane fade" id="contrasena" role="tabpanel" aria-labelledby="contrasena-tab2" wire:ignore.self>
						@livewire('component.password')
						
					</div>
				</div>
				
			</div>
		</div>
	</div>
</div>
<br>
</div>
@endsection