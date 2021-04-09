<div>
	@include('admin.modales.users.modaluser')
	@include('admin.modales.users.importusermodal')
	<button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#createUser" ><i class="fa fa-user-plus"></i>
	Crear Nuevo Usuario
	</button>
	<button type="button" class="btn btn-outline-success mb-2" wire:click.prevent="generaExcel()">
	<i class="fa fa-file-excel"></i> Generar Reporte
	</button>
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					
				</div>
				<div class="card-body p-0">
					<div class="row p-2">
						<div class="col-lg-3 col-sm-12 mt-2">
							<input wire:model.debounce.300ms="search" type="text" class="form-control p-2" placeholder="Buscar Usuarios...">
						</div>
						<div class="col-lg-2 col-sm-12 mt-2">
							<select wire:model="orderBy" class="custom-select " id="grid-state">
								<option value="id">ID</option>
								<option value="nombres">Nombre</option>
								<option value="email">Correo</option>
								<option value="cedula">Cedula</option>
								<option value="telefono">Cedula</option>
							</select>
							
						</div>
						<div class="col-lg-2 col-sm-12 mt-2">
							<select wire:model="orderAsc" class="custom-select " id="grid-state">
								<option value="1">Ascendente</option>
								<option value="0">Descenente</option>
							</select>
							
						</div>
						<div class="col-lg-3 col-sm-12 mt-2">
							<select wire:model="findrole" class="custom-select " id="grid-state">
								<option value="">Roles</option>
								<option value="admin">Administrador</option>
								<option value="coordinador">Coordiandor</option>
								<option value="operador">Operador</option>
							</select>
							
						</div>
						<div class="col-lg-2 col-sm-12 mt-2">
							<select wire:model="perPage" class="custom-select " id="grid-state">
								<option>10</option>
								<option>25</option>
								<option>50</option>
								<option>100</option>
							</select>
							
						</div>
					</div>
					<div class="table-responsive">
						<table class="table table-striped">
							<thead class="">
								<tr class="">
									<th class="px-4 py-2 text-center ">Nombres</th>
									<th class="px-4 py-2 text-center ">Usuario</th>
									<th class="px-4 py-2 text-center ">Correo</th>
									<th class="px-4 py-2 text-center ">Telefono</th>
									<th class="px-4 py-2 text-center ">Rol</th>
									<th class="px-4 py-2 text-center ">Estado</th>
									<th class="px-4 py-2 text-center ">Ultimo Acceso</th>
									<th class="px-4 py-2 text-center " colspan="2">Accion</th>
								</tr>
							</thead>
							<tbody class="text-center">
								@if ($data->isNotEmpty())
								@foreach($data as $user)
								<tr>
									<td class="p-0 text-center">{{ $user->nombres }}</td>
									<td class="p-0 text-center">{{ $user->username }}</td>
									<td class="p-0 text-center">{{ $user->email }}</td>
									<td class="p-0 text-center">{{ $user->telefono }}</td>
									<td class="p-0 text-center">@if ($user->hasRole('operador'))
										<div class="badge badge-success badge-shadow">Operador</div>
										
										@elseif ($user->hasRole('admin'))
										<div class="badge badge-info badge-shadow">Administrador</div>
										@elseif ($user->hasRole('coordinador'))
										<div class="badge badge-danger badge-shadow">Coordinador</div>
										@endif
									</td>
									<td class="p-0 text-center">
										<span style="cursor: pointer;" wire:click.prevent="estadochange('{{ $user->id  }}')" class="badge @if ($user->estado == 'on')
											badge-success
											@else
											badge-danger
										@endif">{{ $user->estado }}</span>
										
									</td>
									<td>
										@isset ($user->access_at)
										{{Carbon\Carbon::parse($user->access_at)->diffForHumans()}}
										@else
										Sin Ingreso
										@endisset
									</td>
									<td class="p-0 text-center" width="50">
										<a class="btn btn-warning text-dark" data-toggle="modal" data-target="#createUser" wire:click.prevent="editUser({{ $user->id }})">
											<i class="fa fa-edit"></i>
										</a>
									</td>
									<td class="p-0 text-center" width="50">
										<a class="btn btn-danger text-dark" wire:click.prevent="$emit('eliminarRegistro','Seguro que deseas eliminar este Usuario?','eliminarUser', {{ $user->id }})" >
											<i class="fa fa-trash"></i>
										</a>
									</td>
								</tr>
								@endforeach
								@else
								<tr>
									<td colspan="10"><p class="text-center">No hay resultado para la busqueda <strong>{{ $search }}</strong> en la pagina <strong>{{ $page }}</strong> al mostrar <strong>{{ $perPage }} </strong> por pagina </p></td>
								</tr>
								
								@endif
							</tbody>
							
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	{!! $data->links() !!}
	{{-- {{ $data->links() }} --}}
</div>