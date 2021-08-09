<div class="row">

    <div class="col-12">
        @if ($errors->any())
            <div class="alert alert-danger alert-has-icon">
                <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
                <div class="alert-body">
                    <div class="alert-title">Tienes estos errores</div>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
            </div>
            <div class="card-body">
                <div class="row">
                    {{-- <a href="" class="btn btn-outline-primary mr-2" wire:click.prevent="selectionLiberar()">Selecionar todo</a> --}}
                    <a href="" class="btn btn-primary btn-sm"
                        wire:target="liberarRequerimiento,asignacionMasiva, liberacionMasiva,seleccionesMultiples"
                        wire:loading.class="disabled" wire:click.prevent="liberacionMasiva()">Liberación Masiva</a>
                </div>
                <h2 class="text-center text-danger font-weight-bold">REQUERIMIENTOS ASIGNADOS</h2>
                <div class="row p-2 justify-content-center">
                    <div class="col-lg-3 col-sm-12 mt-2">
                        <input wire:model.debounce.300ms="search" type="text" class="form-control p-"
                            placeholder="Buscar Requerimientos...">
                    </div>
                    <div class="col-lg-3 col-sm-12 mt-2">
                        <input wire:model.debounce.300ms="codigoCatastral" type="text" class="form-control p-2"
                            placeholder="Buscar Codigo Catastral...">
                    </div>
                    <div class="col-lg-2 col-sm-12 mt-2">
                        <select wire:model="orderBy" class="custom-select " id="grid-state">
                            <option value="requerimientos.id">ID</option>
                            <option value="requerimientos.codigo">Codigo</option>
                            <option value="requerimientos.nombres">Nombre</option>
                            <option value="requerimientos.cedula">Cedula</option>
                            <option value="sectors.nombre">Sector</option>
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
                                <th class="px-4 py-2 text-center "><input type="checkbox" class="custom-checkbox"
                                        wire:target="liberarRequerimiento,asignacionMasiva,liberacionMasiva, seleccionesMultiples"
                                        wire:loading.attr="disabled" wire:change="seleccionesMultiples()"
                                        wire:model="liberacioncompleta"></th>
                                <th class="px-4 py-2 text-center ">Codigo</th>
                                <th class="px-4 py-2 text-center ">Codigo Catastral</th>
                                <th class="px-4 py-2 text-center ">Operador</th>
                                <th class="px-4 py-2 text-center ">Nombre</th>
                                <th class="px-4 py-2 text-center ">Cedula</th>
                                <th class="px-4 py-2 text-center">Dirección</th>
                                <th class="px-4 py-2 text-center">Sector</th>
                                <th class="px-4 py-2 text-center">Tipo de Requerimiento</th>
                                <th class="px-4 py-2 text-center">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($asignados as $asignado)
                                <tr>
                                    <td class="text-center"><input type="checkbox" class="custom-radio"
                                            wire:target="liberarRequerimiento,asignacionMasiva,liberacionMasiva, seleccionesMultiples"
                                            wire:loading.attr="disabled" wire:model="liberados"
                                            value="{{ $asignado->id }}"></td>
                                    <td class="text-center">{{ $asignado->codigo }}</td>
                                    <td class="text-center">{{ $asignado->codigo_catastral }}</td>
                                    <td class="text-center">{{ $asignado->operador }}</td>
                                    <td class="text-center">{{ $asignado->nombres }}</td>
                                    <td class="text-center">{{ $asignado->cedula }}</td>
                                    <td class="text-center">{{ $asignado->direccion }}</td>
                                    <td class="text-center">{{ $asignado->sector }}</td>
                                    <td class="text-center">{{ $asignado->requerimiento }}</td>
                                    <td class="text-center"> <a href="" class="btn btn-danger"
                                            wire:target="liberarRequerimiento,asignacionMasiva,liberacionMasiva, seleccionesMultiples"
                                            wire:loading.class="disabled"
                                            wire:click.prevent="liberarRequerimiento({{ $asignado->id }})">LIBERAR</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="row justify-content-center">
                    {!! $asignados->links() !!}
                </div>
            </div>
        </div>
    </div>
</div>
