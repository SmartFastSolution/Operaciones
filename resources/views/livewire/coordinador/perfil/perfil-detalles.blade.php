<div>
	@include('coordinador.modales.pefil.modalarchivos')
	<div class="row">
		<div class="col-12 col-md-12 col-lg-4">
			<div class="card profile-widget">
				<div class="profile-widget-header">
					@if ($user->avatar)
					<img alt="image" src="{{ $user->avatar }}" class="rounded-circle profile-widget-picture">
					@else
					<img alt="image" src="{{ Avatar::create($user->nombres)->setFontSize(35)->setChars(4) }}" class="rounded-circle profile-widget-picture">
					@endif
					<div class="profile-widget-items">
				</div>
				<div class="profile-widget-description pb-0">
					<div class="profile-widget-name text-center"> @role('super-admin') Super Admin @endrole @role('admin') Administrador @endrole @role('coordinador') Coordinador @endrole <div class="text-muted d-inline font-weight-normal">
						
					</div>
				</div>
				<p>@isset ($user->instituto->nombre)
					{{ $user->instituto->nombre }}
				@endisset</p>
			</div>
		</div>
	
	</div>
		<div class="card">
			<div class="card-header">
				<h4>Detalles</h4>
			</div>
			<div class="card-body">
				<div class="py-4">
					<p class="clearfix">
						<span class="float-left">
							Archivos
						</span>
						<span class="float-right text-muted">
							{{ $documentos->count() }}
						</span>
					</p>
					<p class="clearfix">
						<span class="float-left">
							Imagenes
						</span>
						<span class="float-right text-muted">
							{{ $imagenes->count() }}
						</span>
					</p>
				</div>
			</div>
		</div>
</div>
	<div class="col-12 col-md-12 col-lg-8">
		<div class="card" >
			<div wire:ignore.self class="padding-20">
				<ul  class="nav nav-tabs" id="myTab2" role="tablist">
					<li class="nav-item">
						<a wire:ignore class="nav-link active" id="personales-tab2" data-toggle="tab" href="#personales" role="tab" aria-selected="true">Personales</a>
					</li>
					<li class="nav-item">
						<a wire:ignore class="nav-link" id="mapas-tab2" data-toggle="tab" href="#mapas" role="tab" aria-selected="false"> Ubicación Georeferenciada</a>
					</li>
					<li class="nav-item">
						<a wire:ignore class="nav-link" id="avatar-tab2" data-toggle="tab" href="#avatar" role="tab" aria-selected="false"> Avatar</a>
					</li>
					<li class="nav-item">
						<a wire:ignore class="nav-link" id="contrasena-tab2" data-toggle="tab" href="#contrasena" role="tab" aria-selected="false"> Contraseña</a>
					</li>
				</ul>
				<div class="tab-content tab-bordered" id="myTab3Content">
					<div class="tab-pane fade show active" id="personales" role="tabpanel" aria-labelledby="personales-tab2" wire:ignore>
						<div id="datos">
							<h2 class="text-center font-weight-bold text-danger">DATOS PERSONALES</h2>
							<div class="form-row">
								<div class="form-group col-lg-12">
									<label for="">Nombres</label>
									<input type="text" class="form-control" disabled="" value="{{ $user->nombres }}">
								</div>
								<div class="form-group col-lg-6">
									<label for="">Cedula</label>
									<input type="text" class="form-control" disabled="" value="{{ $user->cedula }}">
								</div>
								<div class="form-group col-lg-6">
									<label for="">Correo</label>
									<input type="text" class="form-control" disabled="" value="{{ $user->email }}">
								</div>
								<div class="form-group col-lg-6">
									<label for="">Telefono</label>
									<input type="number" class="form-control" v-model="telefono">
								</div>
								<div class="form-group col-lg-6">
									<label for="">Sector</label>
									<model-list-select :list="options"
									v-model="sector"
									class="form-control"
									option-value="id"
									option-text="nombre"
									placeholder="Elije Tu Sector"
									@input="onSelect">
									</model-list-select>
									{{-- <model-select :options="options" v-model="sector"
									placeholder="ELEGIR CUENTA">
									</model-select> --}}
									{{-- <input type="text" class="form-control" v-model="sector"> --}}
								</div>
								<div class="form-group col-lg-12">
									<label for="">Dirección</label>
									<textarea name=" " id="" cols="30" rows="10"  v-model="direccion" class="form-control">{{$user->domicilio }}</textarea>
								</div>
								<div class="form-group col-lg-12">
									<label for="">Horario de Atención</label>
									<input type="text" class="form-control" v-model="horario_atencion">
								</div>
								<div class="form-group col-lg-12">
									<label for="">Actividad</label>
									<input type="text" class="form-control" v-model="actividad_personal">
								</div>
								<div  class="form-group col-lg-12">
									<label for="">Detalle de actividad</label>
									<vue-ckeditor v-model="detalle_actividad" :config="config"/>
								</div>
								
							</div>
							<div class="row justify-content-center">
								<a href="#" @click.prevent="guardarDatos" class="btn btn-danger">ACTUALIZAR DATOS</a>
							</div>
						</div>
						
					</div>
					<div class="tab-pane fade" id="contrasena" wire:ignore.self role="tabpanel" aria-labelledby="contrasena-tab2">
						@livewire('component.password')
					</div>
					<div wire:ignore class="tab-pane fade" id="mapas" role="tabpanel" aria-labelledby="mapas-tab2">
						<h2 class="text-center font-weight-bold text-danger">Marcar la Ubicación en el Mapa</h2>
						<div id="mapa">
							<gmap-map
								:center="center"
								:zoom="12"
								style="width:100%;  height: 350px;"
								@click="clicked"
								>
								<gmap-info-window :options="infoOptions" :position="infoWindowPos" :opened="infoWinOpen" @closeclick="infoWinOpen=false">
								</gmap-info-window>
								<gmap-marker
									:position="center"
									:clickable="true"
									icon="http://maps.google.com/mapfiles/kml/paddle/grn-circle.png"
									@click="toggleInfoWindow"
								></gmap-marker>
							</gmap-map>
							<div class="row justify-content-center mt-2">
								<a href="#" @click.prevent="guardarUbicacion" class="btn btn-primary">GUARDAR UBICACIÓN</a>
							</div>
						</div>
						
					</div>
					<div wire:ignore.self class="tab-pane fade" id="avatar" role="tabpanel" aria-labelledby="avatar-tab2">
						<h2 class="text-center font-weight-bold text-danger">FOTO DE PERFIL</h2>
						<div class="form-row">
							<div class="form-group col-10">
								<label for="recipient-name"  class="col-form-label">IMAGEN:</label>
								<div class="custom-file">
									<input type="file" wire:model="foto" accept="image/x-png,image/gif,image/jpeg"  class="custom-file-input" id="customFile">
									<label class="custom-file-label" for="customFile">@isset($foto) {{ $foto->getClientOriginalName() }} @endisset</label>
								</div>
								@error('foto') <span class="error">{{ $message }}</span> @enderror
							</div>
							<div class="form-group col-2">
								@isset($foto)
								<div class="row justify-content-center">
									<figure class="avatar mr-2 avatar-xl">
										<img src="{{ $foto->temporaryUrl() }}" >
									</figure><br>
									{{-- <small id="passwordHelpBlock" class="form-text text-danger">{{ $foto->getClientOriginalName() }} </small> --}}
								</div>
								@endisset
							</div>
						</div>
						<div class="row justify-content-center">
							<a href="" class="btn btn-danger" wire:click.prevent="guardarAvatar">GUARDAR AVATAR</a>
						</div>
					</div>
				</div>
				
			</div>
		</div>
	</div>
	<div class="col-12 col-md-12 col-lg-12">
		<div class="card" >
			<div class="card-body">
				<h2 class="text-danger font-weight-bold text-center">ARCHIVOS</h2>
				<div class="row">
					<button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#cargarArchivo" ><i class="fa fa-plus"></i>Cargar Archivos</button>
				</div>
				<ul  class="nav nav-tabs" id="myTab4" role="tablist">
					<li class="nav-item">
						<a wire:ignore class="nav-link active" id="archivos-tab2" data-toggle="tab" href="#archivos" role="tab" aria-selected="true">Archivos</a>
					</li>
					<li class="nav-item">
						<a wire:ignore class="nav-link" id="imagenes-tab2" data-toggle="tab" href="#imagenes" role="tab" aria-selected="false"> Imagenes</a>
					</li>
				</ul>
				<div class="tab-content tab-bordered" id="myTab4Content">
					<div class="tab-pane fade show active" id="archivos" role="tabpanel" aria-labelledby="archivos-tab2" wire:ignore.self>
						<table class="table table-striped">
							<tbody>
								<thead>
									<tr>
										<th>Nombre</th>
										<th>Extensión</th>
										<th  colspan="2" class="text-center">Acciones</th>
									</tr>
								</thead>
								@foreach($documentos as $documento)
								<tr>
									<td>{{ $documento->nombre }}</td>
									<td>{{ $documento->extension }}</td>
									<td width="25"><a target="_blank" href="{{ $documento->archivo }}" class="btn btn-primary"><i class="fa fa-download"></i></a></td>
									<td width="25"><a href="" class="btn btn-danger" wire:click.prevent="$emit('eliminarRegistro','Seguro que deseas eliminar este Archivo?','eliminarDocumento', {{ $documento->id }})" ><i class="fa fa-trash"></i></a></td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
					<div class="tab-pane fade" id="imagenes" role="tabpanel" aria-labelledby="imagenes-tab2" wire:ignore>
						<div id="galeria" class="row justify-content-center">
							<img class="image" v-for="(image, i) in images" :src="image" @click="onClick(i)">
							<vue-gallery-slideshow :images="images" :index="index" @close="index = null"></vue-gallery-slideshow>
							
						</div>
					</div>
				</div>
				
			</div>
			
		</div>
	</div>
</div>
</div>