<div class="row mt-sm-4">
	<div class="col-12 col-md-12 col-lg-4">
		<div class="card author-box">
			<div class="card-body">
				<div class="author-box-center">
					<img alt="image" src="{{ Avatar::create($egreso->codigo)->setFontSize(35)->setChars(4) }}"  class="rounded-circle author-box-picture">
					<div class="clearfix"></div>
					<div class="author-box-name">
						<a href="#"> Egreso #{{ $egreso->id }}</a>
					</div>
				</div>
				<div class="text-center">
					<div class="author-box-description">
						{{-- 	<p>
							{{ $egreso->nombre }}
						</p> --}}
					</div>
					<div class="mb-2 mt-3">
						<div class="text-small font-weight-bold">{{ $egreso->descripcion }}</div>
					</div>
					
					<div class="w-100 d-sm-none"></div>
				</div>
			</div>
		</div>
		<div class="card">
			<div class="card-header">
				<h4>Datos del Egreso</h4>
			</div>
			<div class="card-body">
				<div >
					<p class="clearfix">
						<span class="float-left">
							Codigo
						</span>
						<span class="float-right text-muted">
							{{ $egreso->codigo }}
						</span>
					</p>
					<p class="clearfix">
						<span class="float-left">
							Total Egreso
						</span>
						<span class="float-right badge badge-info">
							{{ number_format($egreso->total_egreso, 2) }}
						</span>
					</p>
				</div>
			</div>
		</div>
	</div>
	<div class="col-12 col-md-12 col-lg-8">
		<div class="card" style="height: 850px">
			<div wire:ignore.self class="padding-20">
				<div wire:ignore.self  class="tab-content tab-bordered" id="myTab3Content">
					<div class="tab-pane fade show active" id="estudiante" role="tabpanel" aria-labelledby="estudiante-tab2" wire:ignore.self>
						<h3 class="text-center font-weight-bold text-danger">Productos</h3>
						<table class="table table-striped">
							<thead>
								<tr>
									<th class="">Nombre</th>
									<th class="">Cantidad</th>
									<th class="text-center">Total</th>
								</tr>
							</thead>
							<tbody>
								@foreach($egreso->productos as $producto)
								<tr>
									<td><a  class="btn-link">{{ $producto->nombre }}</a></td>
									<td>{{ $producto->pivot->cantidad_real }} ({{ $producto->medida->simbolo }})</td>
									<td class="text-center">{{ number_format($producto->pivot->total,2) }}</td>
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