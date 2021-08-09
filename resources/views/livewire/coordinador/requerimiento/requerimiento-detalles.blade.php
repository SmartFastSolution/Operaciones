<div class="row mt-sm-4">
    @include('coordinador.modales.requerimientos.modalatencion')
    <div class="col-12 col-md-12 col-lg-4">
        @if ($requerimiento->estado !== 'ejecutado')
            <div class="card author-box">
                <div class="card-body">
                    {{-- <div class="author-box-center">
					<img alt="image" src="{{ Avatar::create($requerimiento->codigo)->setFontSize(35)->setChars(4) }}"  class="rounded-circle author-box-picture">
					<div class="clearfix"></div>
					<div class="author-box-name">
						<a href="#"> Requerimiento #{{ $requerimiento->id }}</a>
					</div>
				</div> --}}
                    <div class="text-center">
                        <div class="author-box-description">
                            <p>
                                <a href="{{ route('coordinador.requerimiento.atencion', $requerimiento->id) }}"
                                    class="btn btn-warning"><i class="fa fa-arrow-up"></i> Atender Requerimiento</a>
                                {{-- <a href="" class="btn btn-warning" data-toggle="modal" data-target="#atenderRequerimiento"><i class="fa fa-arrow-up"></i> Atender Requerimiento</a> --}}
                            </p>

                        </div>
                        <div class="mb-2 mt-3">
                            <div class="text-small font-weight-bold">{{ $requerimiento->descripcion }}</div>
                        </div>

                        <div class="w-100 d-sm-none"></div>
                    </div>
                </div>
            </div>
        @endif
        <div class="card">
            <div class="card-header">
                <h4>Datos del Requerimiento</h4>
            </div>
            <div class="card-body">
                <div>
                    @isset($requerimiento->sector)
                        <p class="clearfix">
                            <span class="float-left">
                                Sector
                            </span>
                            <span class="float-right text-muted">
                                {{ $requerimiento->sector->nombre }}
                            </span>
                        </p>
                    @endisset
                    @isset($requerimiento->tipo)
                        <p class="clearfix">
                            <span class="float-left">
                                Tipo De Requerimiento
                            </span>
                            <span class="float-right text-muted">
                                {{ $requerimiento->tipo->nombre }}
                            </span>
                        </p>
                    @endisset
                    <p class="clearfix">
                        <span class="float-left">
                            Codigo
                        </span>
                        <span class="float-right text-muted">
                            {{ $requerimiento->codigo }}
                        </span>
                    </p>
                    <p class="clearfix">
                        <span class="float-left">
                            Cuenta
                        </span>
                        <span class="float-right text-muted">
                            {{ $requerimiento->cuenta }}
                        </span>
                    </p>
                    <p class="clearfix">
                        <span class="float-left">
                            Estado
                        </span>
                        <span class="float-right text-capitalize badge @if ($requerimiento->estado
                            == 'pendiente') badge-danger
                        @elseif ($requerimiento->estado == 'asignado')
                            badge-warning
                        @else
                            badge-success @endif">
                            {{ $requerimiento->estado }}
                        </span>
                    </p>
                    @if ($requerimiento->estado == 'ejecutado')
                        <p class="clearfix">
                            <span class="float-left">
                                Fecha Atencion
                            </span>
                            <span class="float-right text-muted">
                                {{ $requerimiento->atencion->fecha_atencion }}
                            </span>
                        </p>
                    @endif
                    @isset($requerimiento->operador->nombres)
                        <p class="clearfix">
                            <span class="float-left">
                                Operador
                            </span>
                            <span class="float-right text-muted">
                                {{ $requerimiento->operador->nombres }}
                            </span>
                        </p>
                    @endisset

                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-12 col-lg-8">
        <div class="card" style="height: 800px">
            <div class="padding-20">
                <ul class="nav nav-tabs" id="myTab4" role="tablist">
                    <li class="nav-item">
                        <a wire:ignore class="nav-link active" id="datos-tab2" data-toggle="tab" href="#datos"
                            role="tab" aria-selected="true">Datos</a>
                    </li>
                    <li class="nav-item">
                        <a wire:ignore class="nav-link" id="observacion-tab2" data-toggle="tab" href="#observacion"
                            role="tab" aria-selected="true">Observación</a>
                    </li>
                    <li class="nav-item">
                        <a wire:ignore class="nav-link" id="geolocalizacion-tab2" data-toggle="tab"
                            href="#geolocalizacion" role="tab" aria-selected="true">Geolocalización</a>
                    </li>
                    <li class="nav-item">
                        <a wire:ignore class="nav-link" id="archivos-tab2" data-toggle="tab" href="#archivos" role="tab"
                            aria-selected="false"> Archivos</a>
                    </li>
                </ul>
                <div class="tab-content tab-bordered" id="myTab3Content">
                    <div class="tab-pane fade show active" id="datos" role="tabpanel" aria-labelledby="datos-tab2"
                        wire:ignore.self>
                        <h3 class="text-center font-weight-bold text-danger">Datos</h3>
                        <div class="form-row">
                            <div class="form-group col-lg-6 col-sm-12">
                                <label for="">Nombres</label>
                                <input type="text" class="form-control" disabled
                                    value="{{ $requerimiento->nombres }}">
                            </div>
                            <div class="form-group col-lg-6 col-sm-12">
                                <label for="">Cedula</label>
                                <input type="number" class="form-control" disabled
                                    value="{{ $requerimiento->cedula }}">
                            </div>
                            <div class="form-group col-lg-12 col-sm-12">
                                <label for="">Correos</label>
                                <input type="text" class="form-control" disabled
                                    value="{{ $requerimiento->correos }}">
                            </div>
                            <div class="form-group col-lg-12 col-sm-12">
                                <label for="">Telefonos</label>
                                <input type="text" class="form-control" disabled
                                    value="{{ $requerimiento->telefonos }}">
                            </div>
                            @isset($requerimiento->coordinador->nombres)
                                <div class="form-group col-lg-12 col-sm-12">
                                    <label for="">Coordinador</label>
                                    <input type="text" class="form-control" disabled
                                        value="{{ $requerimiento->coordinador->nombres }}">
                                </div>
                            @endisset
                            <div class="form-group col-lg-12 col-sm-12">
                                <label for="">Dirección</label>
                                <input type="text" class="form-control" disabled
                                    value="{{ $requerimiento->direccion }}">
                            </div>
                            @isset($requerimiento->sector)
                                <div class="form-group col-lg-6 col-sm-12">
                                    <label for="">Sector</label>
                                    <input type="text" class="form-control" disabled
                                        value="{{ $requerimiento->sector->nombre }}">
                                </div>
                            @endisset
                            @isset($requerimiento->tipo)
                                <div class="form-group col-lg-6 col-sm-12">
                                    <label for="">Tipo de Requerimiento</label>
                                    <input type="text" class="form-control" disabled
                                        value="{{ $requerimiento->tipo->nombre }}">
                                </div>
                            @endisset

                        </div>
                    </div>
                    <div class="tab-pane fade " id="observacion" role="tabpanel" aria-labelledby="observacion-tab2"
                        wire:ignore.self>
                        <h3 class="text-center font-weight-bold text-danger">Observaciones</h3>
                        {!! $requerimiento->observacion !!}
                    </div>
                    <div class="tab-pane fade " id="geolocalizacion" role="tabpanel"
                        aria-labelledby="geolocalizacion-tab2" wire:ignore.self>
                        <h3 class="text-center font-weight-bold text-danger">Geolocalización</h3>
                        <div id="mapa" wire:ignore>
                            <gmap-map :center="center" :zoom="12" style="width:100%;  height: 350px;">
                                <gmap-marker :position="center"
                                    icon="http://maps.google.com/mapfiles/kml/paddle/grn-circle.png"></gmap-marker>
                            </gmap-map>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="archivos" role="tabpanel" aria-labelledby="archivos-tab2"
                        wire:ignore.self>
                        <h3 class="text-center font-weight-bold text-danger">Archivos</h3>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Extensión</th>
                                    <th colspan="2">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($requerimiento->documentos as $documento)
                                    <tr>
                                        <td>{{ $documento->nombre }}</td>
                                        <td>{{ $documento->extension }}</td>
                                        <td width="25"><a target="_blank" href="{{ $documento->archivo }}"
                                                class="btn btn-primary"><i class="fa fa-download"></i></a></td>
                                        <td width="25"><a href="" class="btn btn-danger"
                                                wire:click.prevent="$emit('eliminarRegistro','Seguro que deseas eliminar este Archivo?','eliminarDocumento', {{ $documento->id }})"><i
                                                    class="fa fa-trash"></i></a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if ($requerimiento->estado == 'ejecutado')
        <div class="col-12 col-md-12 col-lg-12">
            <div class="card">
                <div class="padding-20">
                    <h2 class="text-danger text-center font-weight-bold">ATENCIÓN DE REQUERIMIENTO</h2>
                    <div class="m-1">
                        <a href="{{ route('coordinador.requerimiento.edit', ['id' => $requerimiento->id, 'atencion' => $requerimiento->atencion->id]) }}"
                            class="btn btn-warning mr-2">Editar Atencion</a>
                        <a href="" class="btn btn-danger"
                            wire:click.prevent="$emit('eliminarRegistro','Seguro que deseas eliminar la atencion?','eliminarAtencion', {{ $requerimiento->atencion->id }})">Eliminar
                            Atención</a>
                    </div>
                    <ul class="nav nav-tabs" id="myTab4" role="tablist">
                        <li class="nav-item">
                            <a wire:ignore class="nav-link active" id="atencion-datos-tab2" data-toggle="tab"
                                href="#atencion-datos" role="tab" aria-selected="true">Datos</a>
                        </li>

                        <li class="nav-item">
                            <a wire:ignore class="nav-link" id="atencion-geolocalizacion-tab2" data-toggle="tab"
                                href="#atencion-geolocalizacion" role="tab" aria-selected="true">Geolocalización</a>
                        </li>
                        <li class="nav-item">
                            <a wire:ignore class="nav-link" id="atencion-archivos-tab2" data-toggle="tab"
                                href="#atencion-archivos" role="tab" aria-selected="false"> Archivos</a>
                        </li>
                        <li class="nav-item">
                            <a wire:ignore class="nav-link" id="egreso-tab2" data-toggle="tab" href="#egreso" role="tab"
                                aria-selected="true">Egreso</a>
                        </li>
                    </ul>
                    <div class="tab-content tab-bordered" id="myTab3Content">
                        <div class="tab-pane fade show active" id="atencion-datos" role="tabpanel"
                            aria-labelledby="atencion-datos-tab2" wire:ignore.self>
                            <h3 class="text-center font-weight-bold text-danger">Datos</h3>
                            <div class="form-row">
                                <div class="form-group col-lg-12 col-sm-12">
                                    <label for="">Detalles de atención</label>
                                    <textarea class="form-control" disabled="">{{ $requerimiento->atencion->detalle }}
        </textarea>
                                    {{-- <input type="text" class="form-control" disabled value="{{ $requerimiento->nombres }}"> --}}
                                </div>
                                <div class="form-group col-lg-12 col-sm-12">
                                    <label for="">Observación de Atención</label>
                                    <div>
                                        {!! $requerimiento->atencion->observacion !!}
                                    </div>
                                    {{-- <input type="text" class="form-control" disabled value="{{ $requerimiento->nombres }}"> --}}
                                </div>
                                <div class="form-group col-lg-6 col-sm-12">
                                    <label for="">Fecha de Atención</label>
                                    <input type="date" class="form-control" disabled
                                        value="{{ $requerimiento->atencion->fecha_atencion }}">
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade " id="atencion-observacion" role="tabpanel"
                            aria-labelledby="atencion-observacion-tab2" wire:ignore.self>
                            <h3 class="text-center font-weight-bold text-danger">Observaciones</h3>
                            {!! $requerimiento->observacion !!}
                        </div>
                        <div class="tab-pane fade " id="atencion-geolocalizacion" role="tabpanel"
                            aria-labelledby="atencion-geolocalizacion-tab2" wire:ignore.self>
                            <h3 class="text-center font-weight-bold text-danger">Distancia: <strong>
                                    @if ($distancia < 1)
                                        {{ number_format($distancia * 1000, 2) }} Mts
                                    @else {{ number_format($distancia, 2) }} KM
                                    @endif
                                </strong></h3>
                            <div id="atencion" wire:ignore>
                                <gmap-map :center="center" :zoom="12" style="width:100%;  height: 350px;">
                                    <gmap-marker :position="center"
                                        icon="http://maps.google.com/mapfiles/kml/paddle/grn-circle.png"></gmap-marker>
                                    <gmap-marker :position="position"
                                        icon="http://maps.google.com/mapfiles/kml/paddle/red-circle.png"></gmap-marker>
                                </gmap-map>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="atencion-archivos" role="tabpanel"
                            aria-labelledby="atencion-archivos-tab2" wire:ignore.self>
                            <h3 class="text-center font-weight-bold text-danger">Archivos</h3>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Extensión</th>
                                        <th colspan="2">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($requerimiento->atencion->documentos as $documento)
                                        <tr>
                                            <td>{{ $documento->nombre }}</td>
                                            <td>{{ $documento->extension }}</td>
                                            <td width="25"><a target="_blank" href="{{ $documento->archivo }}"
                                                    class="btn btn-primary"><i class="fa fa-download"></i></a></td>
                                            <td width="25"><a href="" class="btn btn-danger"
                                                    wire:click.prevent="$emit('eliminarRegistro','Seguro que deseas eliminar este Archivo?','deleteDocumento', {{ $documento->id }})"><i
                                                        class="fa fa-trash"></i></a></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="egreso" role="tabpanel" aria-labelledby="egreso-tab2"
                            wire:ignore.self>
                            <h3 class="text-center font-weight-bold text-danger">Egreso</h3>
                            @isset($requerimiento->atencion->egreso)
                                <div class="row">
                                    <div class="col-lg-6 col-sm-12">
                                        <h3 class="text-center">Detalles</h3>
                                        <div class="form-row">
                                            <div class="form-group col-lg-6 col-sm-12">
                                                <label>Codigo</label>
                                                <input type="text" class="form-control" disabled=""
                                                    value="{{ $requerimiento->atencion->egreso->codigo }}">
                                            </div>
                                            <div class="form-group col-lg-6 col-sm-12">
                                                <label>Total</label>
                                                <input type="text" class="form-control" disabled=""
                                                    value="{{ $requerimiento->atencion->egreso->total_egreso }}">
                                            </div>
                                            <div class="form-group col-lg-12 col-sm-12">
                                                <label>Descripción</label>
                                                <textarea name="" class="form-control" disabled="" id="" cols="30"
                                                    rows="10">{{ $requerimiento->atencion->egreso->descripcion }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-sm-12">
                                        <h3 class="text-center">Productos</h3>

                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th class="">Nombre</th>
                                                        <th class="">Cantidad</th>
                                                        <th class="text-center">Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($requerimiento->atencion->egreso->productos as $producto)
                                                        <tr>
                                                            <td><a class="btn-link">{{ $producto->nombre }}</a></td>
                                                            <td>{{ $producto->pivot->cantidad_real }}
                                                                ({{ $producto->medida->simbolo }})</td>
                                                            <td class="text-center">
                                                                {{ number_format($producto->pivot->total, 2) }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @endisset


                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
