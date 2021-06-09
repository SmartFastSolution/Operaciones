<div class="row mt-sm-4">
	<div class="col-12 col-md-12 col-lg-4">
		<div class="card author-box">
			<div class="card-body">
				<div class="author-box-center">
					<img alt="image" src="{{ asset($producto->foto) }}"  class="rounded-circle author-box-picture">
					<div class="clearfix"></div>
					<div class="author-box-name">
						<a href="#">{{ $producto->nombre }}</a>
					</div>
				</div>
				<div class="text-center">
					<div class="author-box-description">
						<p>
							{{ $producto->presentacion }} {{ $producto->medida->simbolo }}
						</p>
					</div>
					<div class="mb-2 mt-3">
						<div class="text-small font-weight-bold">{{ $producto->descripcion }}</div>
					</div>
					
					<div class="w-100 d-sm-none"></div>
				</div>
			</div>
		</div>
		<div class="card">
			<div class="card-header">
				<h4>Datos del Producto</h4>
			</div>
			<div class="card-body">
				<div >
					<p class="clearfix">
						<span class="float-left">
							Cuenta contable
						</span>
						<span class="float-right text-muted">
							{{ $producto->cuenta_contable }}
						</span>
					</p>
					<p class="clearfix">
						<span class="float-left">
							Precio Compra
						</span>
						<span class="float-right text-muted">
							{{ number_format($producto->precio_compra, 2) }}
						</span>
					</p>
					<p class="clearfix">
						<span class="float-left">
							Precio Venta
						</span>
						<span class="float-right text-muted">
							{{ number_format($producto->precio_venta, 2) }}
						</span>
					</p>
					<p class="clearfix">
						<span class="float-left">
							Stock
						</span>
						<span class="float-right badge badge-danger">
							{{ $producto->stock }}
						</span>
					</p>
					<p class="clearfix">
						<span class="float-left">
							Cantidad en <strong>({{ $producto->medida->simbolo }})</strong>
						</span>
						<span class="float-right badge badge-warning">
							{{ $producto->cantidad }}
						</span>
					</p>
				</div>
			</div>
		</div>
	</div>
	<div class="col-12 col-md-12 col-lg-8">
		<div class="card" style="height: 850px">
			<div wire:ignore.self class="padding-20">
				<ul class="nav nav-tabs" id="myTab" role="tablist">
					<li class="nav-item" role="presentation">
						<a class="nav-link active" id="ingresos-tab" data-toggle="tab" href="#ingresos" role="tab" aria-controls="ingresos" aria-selected="true">Ingresos</a>
					</li>
					<li class="nav-item" role="presentation">
						<a class="nav-link" id="egresos-tab" data-toggle="tab" href="#egresos" role="tab" aria-controls="egresos" aria-selected="false">Egresos</a>
					</li>
				</ul>
				<div wire:ignore.self  class="tab-content tab-bordered" id="myTabContent">
					<div class="tab-pane fade show active" id="ingresos" role="tabpanel" aria-labelledby="ingresos-tab" wire:ignore.self>
						<h3 class="text-center font-weight-bold text-danger">Ingresos</h3>
						<table class="table table-striped">
							<thead>
								<tr>
									<th class="text-center">Codigo</th>
									<th class="text-center">Detalle</th>
									<th class="text-center">Cantidad (U)</th>
									<th class="text-center">Cantidad ({{ $producto->medida->simbolo }})</th>
									
									<th class="text-center">Total Producto</th>
									<th class="text-center">Total Ingreso</th>
								</tr>
							</thead>
							<tbody>
								@foreach($producto->ingresos as $ingreso)
								<tr>
									<td class="text-center"><a  class="btn-link">{{ $ingreso->codigo }}</a></td>
									<td class="text-center">{{ $ingreso->descripcion }}</td>
									<td class="text-center">{{ $ingreso->pivot->cantidad }}</td>
									<td class="text-center">{{ ($ingreso->pivot->cantidad * $producto->presentacion) }}</td>

									<td class="text-center">{{ number_format($ingreso->pivot->total,2) }}</td>
									<td class="text-center">{{ number_format($ingreso->total_ingreso,2) }}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
						<div class="row justify-content-center">
						</div>
					</div>
					<div class="tab-pane fade" id="egresos" role="tabpanel" aria-labelledby="egresos-tab" wire:ignore.self>
						<h3 class="text-center font-weight-bold text-danger">Egresos</h3>
						<table class="table table-striped">
							<thead>
								<tr>
									<th class="text-center">Codigo</th>
									<th class="text-center">Detalle</th>
									<th class="text-center">Cantidad (U)</th>
									<th class="text-center">Cantidad ({{ $producto->medida->simbolo }})</th>
									<th class="text-center">Total Producto</th>
									<th class="text-center">Total Egreso</th>
								</tr>
							</thead>
							<tbody>
								@foreach($producto->egresos as $egreso)
								<tr>
									<td class="text-center"><a  class="btn-link">{{ $egreso->codigo }}</a></td>
									<td class="text-center">{{ $egreso->descripcion }}</td>
									<td class="text-center">{{ ($egreso->pivot->cantidad_real / $producto->presentacion) }}</td>
									<td class="text-center">{{ $egreso->pivot->cantidad_real }}</td>
									<td class="text-center">{{ number_format($egreso->pivot->total,2) }}</td>
									<td class="text-center">{{ number_format($egreso->total_egreso ,2)}}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
						<div class="row justify-content-center">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>