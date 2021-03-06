<div>
    @include('admin.modales.medidas.modalmedida')
    <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#createMedida"><i
            class="fa fa-plus"></i>
        Crear Nueva Unidad de Medida
    </button>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                </div>
                <div class="card-body p-0">
                    <div class="row p-2">
                        <div class="col-lg-3 col-sm-12 mt-2">
                            <input wire:model.debounce.300ms="search" type="text" class="form-control p-2"
                                placeholder="Buscar Unidad de Medida...">
                        </div>
                        <div class="col-lg-2 col-sm-12 mt-2">
                            <select wire:model="orderBy" class="custom-select " id="grid-state">
                                <option value="id">ID</option>
                                <option value="unidad">Unidad</option>
                                <option value="simbolo">Simbolo</option>
                                <option value="descripcion">Descripción</option>
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
                                    <th class="px-4 py-2 text-center ">Magnitud</th>
                                    <th class="px-4 py-2 text-center ">Unidad</th>
                                    <th class="px-4 py-2 text-center ">Icono</th>
                                    <th class="px-4 py-2 text-center ">Descripción</th>
                                    <th class="px-4 py-2 text-center ">Estado</th>
                                    <th class="px-4 py-2 text-center " colspan="3">Acción</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @if ($medidas->isNotEmpty())
                                    @foreach ($medidas as $medida)
                                        <tr>
                                            <td class="p-0 text-center">{{ $medida->magnitud }}</td>
                                            <td class="p-0 text-center">{{ $medida->unidad }}</td>
                                            <td class="p-0 text-center"><span
                                                    class="badge-warning badge">{{ $medida->simbolo }}</span></td>
                                            <td class="p-0 text-left">{{ $medida->descripcion }}</td>
                                            <td class="p-0 text-center">
                                                <span style="cursor: pointer;"
                                                    wire:click.prevent="estadochange('{{ $medida->id }}')"
                                                    class="badge @if ($medida->estado == 'on') badge-success
                                                @else
                                                    badge-danger @endif">{{ $medida->estado }}</span>

                                            </td>
                                            <td class="p-0 text-center" width="50">
                                                <a class="btn btn-info text-dark" data-toggle="modal"
                                                    data-target="#createConversion"
                                                    wire:click.prevent="conversion({{ $medida->id }})">
                                                    <i class="fa fa-map"></i>
                                                </a>
                                            </td>
                                            <td class="p-0 text-center" width="50">
                                                <a class="btn btn-warning text-dark" data-toggle="modal"
                                                    data-target="#createMedida"
                                                    wire:click.prevent="editMedida({{ $medida->id }})">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            </td>
                                            <td class="p-0 text-center" width="50">
                                                <a class="btn btn-danger text-dark"
                                                    wire:click.prevent="$emit('eliminarRegistro','Seguro que deseas eliminar esta Unidad de Medida?','eliminarMedida', {{ $medida->id }})">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7">
                                            <p class="text-center">No hay resultado para la busqueda
                                                <strong>{{ $search }}</strong> en la pagina
                                                <strong>{{ $page }}</strong> al mostrar
                                                <strong>{{ $perPage }} </strong> por pagina </p>
                                        </td>
                                    </tr>

                                @endif
                            </tbody>

                        </table>
                    </div>
                </div>
                <div class="row justify-content-center">
                    {!! $medidas->links() !!}

                </div>
            </div>
        </div>
    </div>
</div>
