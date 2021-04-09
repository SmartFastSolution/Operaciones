<div>
	@include('admin.modales.sectores.modalsector')
	<button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#createSector" ><i class="fa fa-user-plus"></i>
	Crear Nuevo Sector
	</button>
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
				</div>
				<div class="card-body p-0">
					<div class="row p-2">
						<div class="col-lg-3 col-sm-12 mt-2">
							<input wire:model.debounce.300ms="search" type="text" class="form-control p-2" placeholder="Buscar Sector...">
						</div>
						<div class="col-lg-2 col-sm-12 mt-2">
							<select wire:model="orderBy" class="custom-select " id="grid-state">
								<option value="id">ID</option>
								<option value="nombre">Nombre</option>
								<option value="descripcion">Descripcion</option>
							</select>
							
						</div>
						<div class="col-lg-2 col-sm-12 mt-2">
							<select wire:model="orderAsc" class="custom-select " id="grid-state">
								<option value="1">Ascendente</option>
								<option value="0">Descenente</option>
							</select>
							
						</div>
						<div class="col-lg-3 col-sm-12 mt-2">
							<select wire:model="status" class="custom-select " id="grid-state">
								<option value="">ESTADO</option>
								<option value="on">ON</option>
								<option value="off">OFF</option>
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
									<th class="px-4 py-2 text-center ">Nombre</th>
									<th class="px-4 py-2 text-center ">Descripcion</th>
									<th class="px-4 py-2 text-center ">Estado</th>
									<th class="px-4 py-2 text-center " colspan="2">Accion</th>
								</tr>
							</thead>
							<tbody class="text-center">
								@if ($sectores->isNotEmpty())
								@foreach($sectores as $sector)
								<tr>
									<td class="text-left">{{ $sector->nombre }}</td>
									<td class="text-left">{{ $sector->descripcion }}</td>
									<td class="p-0 text-center">
										<span style="cursor: pointer;" wire:click.prevent="estadochange('{{ $sector->id  }}')" class="badge @if ($sector->estado == 'on')
											badge-success
											@else
											badge-danger
										@endif">{{ $sector->estado }}</span>
										
									</td>
									<td class="p-0 text-center" width="50">
										<a class="btn btn-warning text-dark" data-toggle="modal" data-target="#createSector" wire:click.prevent="editSector({{ $sector->id }})">
											<i class="fa fa-edit"></i>
										</a>
									</td>
									<td class="p-0 text-center" width="50">
										<a class="btn btn-danger text-dark" wire:click.prevent="$emit('eliminarRegistro','Seguro que deseas eliminar este Sector?','eliminarSector', {{ $sector->id }})" >
											<i class="fa fa-trash"></i>
										</a>
									</td>
								</tr>
								@endforeach
								@else
								<tr>
									<td colspan="7"><p class="text-center">No hay resultado para la busqueda <strong>{{ $search }}</strong> en la pagina <strong>{{ $page }}</strong> al mostrar <strong>{{ $perPage }} </strong> por pagina </p></td>
								</tr>
								
								@endif
							</tbody>
							
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	{!! $sectores->links() !!}
</div>