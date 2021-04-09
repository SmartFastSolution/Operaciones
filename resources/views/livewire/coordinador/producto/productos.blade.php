<div>
	@include('coordinador.modales.producto.modal')
	<button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#crearProducto" ><i class="fad fa-store"></i>
	Crear Nuevo Producto
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
									<th class="px-4 py-2 text-center ">Nombre</th>
									<th class="px-4 py-2 text-center ">Presentacion</th>
									<th class="px-4 py-2 text-center ">Unidad de Medida</th>
									<th class="px-4 py-2 text-center ">Precio Compra</th>
									<th class="px-4 py-2 text-center ">Precio Venta</th>
									<th class="px-4 py-2 text-center ">Iva (%)</th>
									<th class="px-4 py-2 text-center ">Cuenta Contable</th>
									<th class="px-4 py-2 text-center ">Estado</th>
									<th class="px-4 py-2 text-center " colspan="2">Accion</th>
								</tr>
							</thead>
							<tbody class="text-center">
								@if ($productos->isNotEmpty())
								@foreach($productos as $producto)
								<tr>
									<td class="p-0 text-center"><figure class="avatar mr-2 avatar-sm">
										<img src="{{ $producto->foto }}" >
									</figure> {{ $producto->nombre }}</td>
									<td class="p-0 text-center">{{ $producto->presentacion }}</td>
									<td class="p-0 text-center">{{ $producto->unidad }}</td>
									<td class="p-0 text-center">{{ number_format($producto->precio_compra,2) }}</td>
									<td class="p-0 text-center">{{ number_format($producto->precio_venta, 2) }}</td>
									<td class="p-0 text-center">{{ $producto->iva }}</td>
									<td class="p-0 text-center">{{ $producto->cuenta_contable }}</td>

									<td class="p-0 text-center">
										<span style="cursor: pointer;" wire:click.prevent="estadochange('{{ $producto->id  }}')" class="badge @if ($producto->estado == 'on')
											badge-success
											@else
											badge-danger
										@endif">{{ $producto->estado }}</span>
										
									</td>
									<td class="p-0 text-center"><a href="{{ route('coordinador.producto.show', $producto->id) }}" class="btn btn-primary"><i class="fa fa-eye"></i></a></td>

									<td class="p-0 text-center" width="50">
										<a class="btn btn-warning text-dark" data-toggle="modal" data-target="#crearProducto" wire:click.prevent="editProducto({{ $producto->id }})">
											<i class="fa fa-edit"></i>
										</a>
									</td>
									{{-- <td class="p-0 text-center" width="50">
										<a class="btn btn-danger text-dark" wire:click.prevent="$emit('eliminarRegistro','Seguro que deseas eliminar este Producto?','eliminarProducto', {{ $producto->id }})" >
											<i class="fa fa-trash"></i>
										</a>
									</td> --}}
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
	{!! $productos->links() !!}
</div>