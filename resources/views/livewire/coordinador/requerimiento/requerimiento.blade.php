<div>
    {{-- @include('coordinador.modales.requerimientos.modalrequerimiento') --}}
    @include('coordinador.modales.requerimientos.modalimport')
    {{-- <button wire:target="exportarExcel" wire:loading.attr="disabled" type="button" class="btn btn-primary mb-2"
        data-toggle="modal" data-target="#createRequerimiento"><i class="fas fa-clipboard-list"></i>
        Crear Requerimiento
    </button> --}}
    <a wire:target="exportarExcel" wire:loading.attr="disabled" type="button" class="btn btn-primary mb-2"
        href="{{ route('coordinador.requerimiento.create') }}"><i class="fas fa-clipboard-list"></i>
        Crear Requerimiento</a>
    <button wire:target="exportarExcel" wire:loading.attr="disabled" type="button" class="btn btn-warning mb-2"
        data-toggle="modal" data-target="#importarRequerimiento"><i class="fas fa-file-excel"></i>
        Importar
    </button>
    {{-- @if ($exporting)
        <button class="btn btn-success" type="button" disabled>
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            Exportando...
        </button>
    @else --}}
    <button type="button" wire:target="exportarExcel" wire:loading.attr="disabled" class="btn btn-success mb-2"
        wire:click.prevent="exportarExcel"><i class="fas fa-file-excel"></i>
        Exportar
    </button>
    {{-- @endif --}}

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                </div>
                <div class="card-body p-0">
                    <div class="row p-2">
                        <div class="col-lg-3 col-sm-12 mt-2">
                            <input wire:model.debounce.300ms="search" type="text" class="form-control p-2"
                                placeholder="Buscar Requerimientos...">
                        </div>
                        <div class="col-lg-2 col-sm-12 mt-2">
                            <input wire:model.debounce.300ms="codigoCatastral" type="text" class="form-control p-2"
                                placeholder="Buscar Codigo Catastral...">
                        </div>
                        <div class="col-lg-2 col-sm-12 mt-2">
                            <select wire:model="orderBy" class="custom-select " id="grid-state">
                                <option value="requerimientos.id">ID</option>
                                <option value="requerimientos.nombres">Nombre</option>
                                <option value="requerimientos.cedula">Cedula</option>
                                <option value="requerimientos.codigo">Codigo</option>
                                <option value="atencions.distancia">Distancia</option>
                                <option value="atencions.fecha_atencion">Fecha de Atención</option>
                            </select>

                        </div>
                        <div class="col-lg-2 col-sm-12 mt-2">
                            <select wire:model="orderAsc" class="custom-select " id="grid-state">
                                <option value="1">Ascendente</option>
                                <option value="0">Descenente</option>
                            </select>

                        </div>
                        <div class="col-lg-2 col-sm-12 mt-2">
                            <select wire:model="status" class="custom-select " id="grid-state">
                                <option value="">ESTADO</option>
                                <option value="pendiente">PENDIENTE</option>
                                <option value="asignado">ASIGNADO</option>
                                <option value="ejecutado">EJECUTADO</option>
                            </select>

                        </div>
                        <div class="col-lg-1 col-sm-12 mt-2">
                            <select wire:model="perPage" class="custom-select " id="grid-state">
                                <option>10</option>
                                <option>50</option>
                                <option>100</option>
                                <option>300</option>
                                <option>500</option>
                            </select>

                        </div>
                    </div>
                    <div class="row justify-content-center p-2 form-inline">
                        <div class="col-lg-3 col-sm-12 mt-2">
                            <strong>Fecha Inicio</strong>
                            <input wire:model="fechaini" type="date" class="form-control p-2"
                                placeholder="Buscar Requerimientos...">
                        </div>
                        <div class="col-lg-3 col-sm-12 mt-2">
                            <strong>Fecha Fin</strong>
                            <input wire:model="fechafin" type="date" class="form-control p-2"
                                placeholder="Buscar Requerimientos...">
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead class="">
                                <tr class="">
                                    {{-- <th class="px-4 py-2 ">Codigo</th> --}}
                                    <th class="px-4 py-2 text-center">Sector</th>
                                    <th class="px-4 py-2 ">Codigo Catastral</th>
                                    <th class="px-4 py-2 ">Nombre</th>
                                    <th class="px-4 py-2 ">Fecha Maxima</th>
                                    <th class="px-4 py-2 ">Fecha Atención</th>
                                    <th class="px-4 py-2 ">Distancia</th>
                                    {{-- <th class="px-4 py-2 ">Cedula</th> --}}
                                    {{-- <th class="px-4 py-2 ">Telefonos</th> --}}
                                    <th class="px-4 py-2 text-center">Tipo de Requerimiento</th>
                                    <th class="px-4 py-2 text-center ">Estado</th>
                                    <th class="px-4 py-2 text-center" colspan="3">Accion</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @if ($requerimientos->isNotEmpty())
                                    @foreach ($requerimientos as $requerimiento)
                                        <tr>
                                            {{-- <td class="text-left">{{ $requerimiento->codigo }}</td> --}}
                                            <td class="text-center">{{ $requerimiento->sector }}</td>
                                            <td class="text-left">{{ $requerimiento->codigo_catastral }}</td>
                                            <td class="text-left">{{ $requerimiento->nombres }}</td>
                                            <td class="text-center">
                                                {{ Carbon\Carbon::parse($requerimiento->fecha_maxima)->formatLocalized('%d de %B %Y ') }}
                                            </td>
                                            <td class="text-center"> @isset($requerimiento->fecha_atencion)
                                                    {{ Carbon\Carbon::parse($requerimiento->fecha_atencion)->formatLocalized('%d de %B %Y ') }}
                                                @endisset</td>
                                            <td class="text-center">
                                                @isset($requerimiento->distancia)


                                                    @if ($requerimiento->distancia < 1)
                                                        {{ number_format($requerimiento->distancia * 1000, 2) }} Mts
                                                    @else {{ number_format($requerimiento->distancia, 2) }} KM
                                                    @endif
                                                @endisset
                                            </td>
                                            {{-- <td class="text-left">{{ $requerimiento->telefonos }}</td> --}}
                                            <td class="text-center">{{ $requerimiento->requerimiento }}</td>
                                            <td class="p-0 text-center">
                                                <span class="badge @if ($requerimiento->estado ==
                                                    'ejecutado') badge-success
                                                @elseif ($requerimiento->estado == 'pendiente')
                                                    badge-danger
                                                @else
                                                    badge-warning @endif">{{ $requerimiento->estado }}</span>

                                            </td>
                                            <td class="p-0 text-center" width="50">
                                                <a wire:loading.class="disabled" class="btn btn-primary text-dark"
                                                    wire:target="exportarExcel" wire:loading.attr="disabled"
                                                    href="{{ route('coordinador.requerimiento.show', $requerimiento->id) }}">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                            </td>
                                            <td class="p-0 text-center" width="50">
                                                <a wire:loading.class="disabled" class="btn btn-warning text-dark"
                                                    data-toggle="modal" wire:target="exportarExcel"
                                                    wire:loading.attr="disabled" data-target="#createRequerimiento"
                                                    wire:click.prevent="editRequerimiento({{ $requerimiento->id }})">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            </td>
                                            <td class="p-0 text-center" width="50">
                                                <a wire:loading.class="disabled" class="btn btn-danger text-dark"
                                                    wire:target="exportarExcel" wire:loading.attr="disabled"
                                                    wire:click.prevent="$emit('eliminarRegistro','Seguro que deseas eliminar este Requerimiento?','eliminarRequerimiento', {{ $requerimiento->id }})">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="10">
                                            <p class="text-center">No hay resultado para la busqueda
                                                <strong>{{ $search }}</strong> en la pagina
                                                <strong>{{ $page }}</strong> al mostrar
                                                <strong>{{ $perPage }} </strong> por pagina
                                            </p>
                                        </td>
                                    </tr>

                                @endif
                            </tbody>

                        </table>
                    </div>
                    <div class=" row justify-content-center">
                        {!! $requerimientos->links() !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
