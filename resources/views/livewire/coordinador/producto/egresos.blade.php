<div>
	<div id="egresos" wire:ignore>
	@include('coordinador.modales.producto.egresomodal')
	<button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#crearEgreso" ><i class="fas fa-store"></i>
	Agregar Egreso
	</button>
	<button type="button" class="btn btn-outline-success mb-2" wire:click.prevent="generaExcel()">
	<i class="fa fa-file-excel"></i> Generar Reporte
	</button>
	</div>

	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-header">
					
				</div>
				<div class="card-body p-0">
					<div class="row p-2 justify-content-center">
						<div class="col-lg-3 col-sm-12 mt-2">
							<input wire:model.debounce.300ms="search" type="text" class="form-control p-2" placeholder="Buscar Egreso...">
						</div>
						<div class="col-lg-2 col-sm-12 mt-2">
							<select wire:model="orderBy" class="custom-select " id="grid-state">
								<option value="id">ID</option>
								<option value="codigo">Codigo</option>
								<option value="total_egreso">Total Egreso</option>
								<option value="descripcion">Descripcion</option>
							</select>
							
						</div>
						<div class="col-lg-2 col-sm-12 mt-2">
							<select wire:model="orderAsc" class="custom-select " id="grid-state">
								<option value="1">Ascendente</option>
								<option value="0">Descenente</option>
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
									<th class="px-4 py-2 text-center ">Descripción</th>
									<th class="px-4 py-2 text-center ">Total</th>
									<th class="px-4 py-2 text-center ">Productos</th>
									<th class="px-4 py-2 text-center "  colspan="3" width="50">Acciones</th>
								</tr>
							</thead>
							<tbody class="text-center">
								@if ($egresos->isNotEmpty())
								@foreach($egresos as $egreso)
								<tr>
									<td class="p-0 text-center">{{ $egreso->codigo }}</td>
									<td class="p-0 text-center">{{ $egreso->descripcion }}</td>
									<td class="p-0 text-center">{{ number_format( $egreso->total_egreso, 2) }}</td>
									<td class="p-0 text-center">{{ $egreso->productos_count}}</td>
									<td width="50" class="p-0 text-center"><a href="{{ route('coordinador.producto.egresoshow', $egreso->id) }}" class="btn btn-primary"><i class="fa fa-eye"></i></a></td>
									<td width="50" class="p-0 text-center"><a href="" class="btn btn-warning" data-toggle="modal" data-target="#crearEgreso" wire:click.prevent="editarEgreso({{ $egreso->id }})"><i class="fa fa-edit"></i></a></td>
									<td class="p-0 text-center" width="50">
										<a class="btn btn-danger text-dark" wire:click.prevent="$emit('eliminarRegistro','Seguro que deseas eliminar este Egreso?','eliminarEgreso', {{ $egreso->id }})" >
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
	{!! $egresos->links() !!}
</div>