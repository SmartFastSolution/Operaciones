<div>
	@include('coordinador.modales.producto.ingresomodal')
	<button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#crearIngreso" ><i class="fas fa-store"></i>
	Agregar Ingreso
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
								<option value="">Todos</option>
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
									<th class="px-4 py-2 text-center ">Codigo</th>
									<th class="px-4 py-2 text-center ">Descripcion</th>
									<th class="px-4 py-2 text-center ">Total</th>
									<th class="px-4 py-2 text-center ">Detalles</th>
								</tr>
							</thead>
							<tbody class="text-center">
								@if ($ingresos->isNotEmpty())
								@foreach($ingresos as $producto)
								<tr>
									<td class="p-0 text-center">{{ $producto->codigo }}</td>
									<td class="p-0 text-center">{{ $producto->descripcion }}</td>
									<td class="p-0 text-center">{{ $producto->total_ingreso }}</td>
									<td class="p-0 text-center"><a href="{{ route('coordinador.producto.ingresoshow', $producto->id) }}" class="btn btn-primary"><i class="fa fa-eye"></i></a></td>
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
	{!! $ingresos->links() !!}
</div>