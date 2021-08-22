<div>
    @include('coordinador.modales.producto.modal')
    <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#crearProducto"><i
            class="fad fa-store"></i>
        Crear Nuevo Producto
    </button>
    </button>
    <button type="button" class="btn btn-outline-success mb-2" wire:click.prevent="generaExcel()">
        <i class="fa fa-file-excel"></i> Generar Reporte
    </button>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                </div>
                <div class="card-body">
                    <div class="row p-2">
                        <div class="col-lg-3 col-sm-12 mt-2">
                            <input wire:model.debounce.300ms="search" type="text" class="form-control p-2"
                                placeholder="Buscar Productos...">
                        </div>
                        <div class="col-lg-2 col-sm-12 mt-2">
                            <select wire:model="orderBy" class="custom-select " id="grid-state">
                                <option value="id">ID</option>
                                <option value="products.nombre">Nombre</option>
                                <option value="products.presentacion">Presentación</option>
                                <option value="products.stock">Stock</option>
                                {{-- <option value="products.cedula">Cedula</option> --}}
                            </select>

                        </div>
                        <div class="col-lg-2 col-sm-12 mt-2">
                            <select wire:model="orderAsc" class="custom-select " id="grid-state">
                                <option value="1">Ascendente</option>
                                <option value="0">Descenente</option>
                            </select>

                        </div>
                        <div class="col-lg-3 col-sm-12 mt-2">
                            <select wire:model="statu" class="custom-select " id="grid-state">
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
                                    <th class="px-4 py-2 text-center ">Nombre</th>
                                    <th class="px-4 py-2 text-center ">Presentación</th>
                                    <th class="px-4 py-2 text-center ">Unidad de Medida</th>
                                    <th class="px-4 py-2 text-center ">Precio Compra</th>
                                    <th class="px-4 py-2 text-center ">Precio Venta</th>
                                    <th class="px-4 py-2 text-center ">Iva (%)</th>
                                    <th class="px-4 py-2 text-center ">Stock</th>
                                    <th class="px-4 py-2 text-center ">Cuenta Contable</th>
                                    <th class="px-4 py-2 text-center ">Estado</th>
                                    <th class="px-4 py-2 text-center " colspan="3">Acción</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @if ($productos->isNotEmpty())
                                    @foreach ($productos as $producto)
                                        <tr>
                                            <td class="" width="200">
                                                <figure class="avatar mr-2 avatar-sm">
                                                    <img src="{{ $producto->foto }}">
                                                </figure> {{ $producto->nombre }}
                                            </td>
                                            <td class="text-center">{{ $producto->presentacion }}</td>
                                            <td class="text-center">{{ $producto->unidad }}</td>
                                            <td class="text-center">
                                                {{ number_format($producto->precio_compra, 3, ',', '.') }}</td>
                                            <td class="text-center">
                                                {{ number_format($producto->precio_venta, 3, ',', '.') }}</td>
                                            <td class="text-center">{{ $producto->iva }}</td>
                                            <td class="text-center">
                                                <span class="badge  @if ($producto->stock < 10) badge-danger
@elseif ($producto->stock > 10)
           badge-success @endif">
                                                        {{ number_format($producto->stock, 2) }}
                                                </span>
                                            </td>
                                            <td class="text-center">{{ $producto->cuenta_contable }}</td>
                                            <td class="text-center">
                                                <span style="cursor: pointer;"
                                                    wire:click.prevent="estadochange('{{ $producto->id }}')"
                                                    class="badge @if ($producto->estado ==
                                                    'on') badge-success
                                                @else
                                                    badge-danger @endif">{{ $producto->estado }}</span>

                                            </td>
                                            <td class="text-center"><a
                                                    href="{{ route('coordinador.producto.show', $producto->id) }}"
                                                    class="btn btn-primary"><i class="fa fa-eye"></i></a></td>
                                            <td class="text-center" width="50">
                                                <a class="btn btn-warning text-dark" data-toggle="modal"
                                                    data-target="#crearProducto"
                                                    wire:click.prevent="editProducto({{ $producto->id }})">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            </td>
                                            <td class="text-center" width="50">
                                                <a class="btn btn-danger text-dark"
                                                    wire:click.prevent="$emit('eliminarRegistro','Seguro que deseas eliminar este Producto?','eliminarProducto', {{ $producto->id }})">
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
                </div>
                <div class="row justify-content-center">
                    {!! $productos->links() !!}
                </div>
            </div>
        </div>
    </div>
</div>
