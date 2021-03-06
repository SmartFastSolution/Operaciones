<div>
    <div class="card">
        <div class="card-body">
            <div id="requerimiento" wire:ignore>
                <div class="form-group row justify-content-center">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">OPERADOR</label>
                    <div class="col-sm-8">
                        <model-list-select :list="operadores" v-model="operador_id" class="form-control"
                            option-value="id" option-text="nombres" placeholder="Elije Un Operador"
                            @input="operadorEmit">
                        </model-list-select>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                {{-- @if ($operador_id !== '')
				<small class="text-center text-danger">Este usuario solo puede ser asignado a {{ $disponible }} requerimientos mas</small>
				@endif --}}
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
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                </div>
                <div class="card-body">
                    <div class="row">
                        {{-- <a href="" class="btn btn-outline-primary mr-2" wire:click.prevent="selectionAll()">Selecionar todo</a> --}}
                        <a href=""
                            wire:target="asignarRequerimiento,asignacionMasiva,liberacionMasiva, seleccionesMultiples, updatingCodigoCatastral"
                            wire:loading.class="disabled" class="btn btn-danger btn-sm @if ($asignando==true) disabled @endif"
                            wire:click.prevent="asignacionMasiva()">Asignaci??n
                            Masiva</a>
                    </div>
                    <div class="row p-2 justify-content-center">
                        <div class="col-lg-3 col-sm-12 mt-2">
                            <input wire:model.debounce.300ms="search" type="text" class="form-control p-2"
                                wire:target="asignarRequerimiento,asignacionMasiva,liberacionMasiva"
                                wire:loading.class="disabled" placeholder="Buscar Requerimientos...">
                        </div>
                        <div class="col-lg-3 col-sm-12 mt-2">
                            <input wire:model="codigoCatastral" type="text" class="form-control p-2"
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
                            <input wire:model="fechaini" type="date" class="form-control p-2">
                        </div>
                        <div class="col-lg-3 col-sm-12 mt-2">
                            <strong>Fecha Fin</strong>
                            <input wire:model="fechafin" type="date" class="form-control p-2">
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead class="">
                                <tr class="">
                                    <th class="px-4 py-2 text-center "><input type="checkbox" class="custom-checkbox"
                                            wire:target="asignarRequerimiento,asignacionMasiva,liberacionMasiva, seleccionesMultiples, updatingCodigoCatastral"
                                            wire:loading.attr="disabled" wire:change="seleccionesMultiples()"
                                            wire:model="selectioncompleta"></th>
                                    <th class="px-4 py-2 text-center ">Codigo</th>
                                    <th class="px-4 py-2 text-center ">Codigo Catastral</th>
                                    <th class="px-4 py-2 text-center ">Nombre</th>
                                    <th class="px-4 py-2 text-center ">Cedula</th>
                                    <th class="px-4 py-2 text-center">Direcci??n</th>
                                    <th class="px-4 py-2 text-center">Sector</th>
                                    <th class="px-4 py-2 text-center">Tipo de Requerimiento</th>
                                    <th class="px-4 py-2 text-center">Acci??n</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($requerimientos as $requerimiento)
                                    <tr>
                                        <td class="text-center"><input type="checkbox" class="custom-radio"
                                                wire:target="asignarRequerimiento,asignacionMasiva,liberacionMasiva, seleccionesMultiples"
                                                wire:loading.attr="disabled" value="{{ intval($requerimiento->id) }}"
                                                wire:model.defer="selecionados"></td>
                                        <td class="text-center">{{ $requerimiento->codigo }}</td>
                                        <td class="text-center">{{ $requerimiento->codigo_catastral }}</td>
                                        <td class="text-center">{{ $requerimiento->nombres }}</td>
                                        <td class="text-center">{{ $requerimiento->cedula }}</td>
                                        <td class="text-center">{{ $requerimiento->direccion }}</td>
                                        <td class="text-center">{{ $requerimiento->sector }}</td>
                                        <td class="text-center">{{ $requerimiento->requerimiento }}</td>
                                        <td class="text-center"> <a href="" class="btn btn-success"
                                                wire:target="asignarRequerimiento,asignacionMasiva,liberacionMasiva"
                                                wire:loading.class="disabled"
                                                wire:click.prevent="asignarRequerimiento({{ $requerimiento->id }})">ASIGNAR</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row justify-content-center">
                        {!! $requerimientos->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
