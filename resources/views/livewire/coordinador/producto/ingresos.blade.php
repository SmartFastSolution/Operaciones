<div>
    @include('coordinador.modales.producto.ingreso-modal')
    <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#crearIngreso"><i
            class="fas fa-store"></i>
        Agregar Ingreso
    </button>
    <div class="row ">
        <div class="col-12">
            <div class="card">
                <div class="card-header">

                </div>
                <div class="card-body p-0">
                    <div class="row p-2 justify-content-center">
                        <div class="col-lg-3 col-sm-12 mt-2">
                            <input wire:model.debounce.300ms="search" type="text" class="form-control p-2"
                                placeholder="Buscar Ingresos...">
                        </div>
                        <div class="col-lg-2 col-sm-12 mt-2">
                            <select wire:model="orderBy" class="custom-select " id="grid-state">
                                <option value="id">ID</option>
                                <option value="descripcion">Descripción</option>
                                <option value="total_ingreso">Total Ingreso</option>
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
                                    <th class="px-4 py-2 text-center " colspan="3">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @if ($ingresos->isNotEmpty())
                                    @foreach ($ingresos as $ingreso)
                                        <tr>
                                            <td class="p-0 text-center">{{ $ingreso->codigo }}</td>
                                            <td class="p-0 text-center">{{ $ingreso->descripcion }}</td>
                                            <td class="p-0 text-center">
                                                {{ number_format($ingreso->total_ingreso, 2) }}</td>
                                            <td class="p-0 text-center" width="50"><a
                                                    href="{{ route('coordinador.producto.ingresoshow', $ingreso->id) }}"
                                                    class="btn btn-primary"><i class="fa fa-eye"></i></a></td>
                                            <td width="50" class="p-0 text-center"><a href="" class="btn btn-warning"
                                                    data-toggle="modal" data-target="#crearIngreso"
                                                    wire:click.prevent="editIngreso({{ $ingreso->id }})"><i
                                                        class="fa fa-edit"></i></a></td>
                                            <td class="p-0 text-center" width="50">
                                                <a class="btn btn-danger text-dark"
                                                    wire:click.prevent="$emit('eliminarRegistro','Seguro que deseas eliminar este Ingreso?','eliminarIngreso', {{ $ingreso->id }})">
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
                                                <strong>{{ $perPage }} </strong> por pagina
                                            </p>
                                        </td>
                                    </tr>

                                @endif
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! $ingresos->links() !!}
</div>

@push('scripts')
    <script type="text/javascript">
        let productos = @json($productos);
        const ingreso = new Vue({
            el: "#ingreso",
            name: "Ingreso",
            data: {
                codigo_ingreso: '',
                total_ingreso: '',
                descripcion_ingreso: '',
                producto_id: '',
                producto_cantidad: 1,
                producto_precio: '',
                productos: productos,
                items: [],
            },
            computed: {
                getIds() {
                    let ids = []
                    this.items.forEach(cuenta => {
                        ids.push(cuenta.id);
                    });
                    return ids;
                },
                getFilterProducto: function() {
                    let ids = this.getIds;
                    // const cuentas = this.cuentas.reduce((obj, item) => (obj[item.id] = true, obj), {});
                    const results = this.productos.filter(({
                        id: id1
                    }) => !ids.some(
                        id2 => id2 === id1));
                    // const result = this.cuentas.filter(el.id => !datos2.includes(el.id));
                    // var result = this.cuentas.filter(el.id => !ids.includes(el.id));
                    return results;
                }
            },
            methods: {
                getPrecio() {
                    let consulta = this.productos.filter(x => x.id == this.producto_id);
                    console.log(consulta);
                    this.producto_precio = consulta[0].porcentual ? consulta[0].precio_iva : consulta[0]
                        .precio_venta;

                },
                eliminarItem(index) {
                    this.items.splice(index, 1);
                    this.sumatorias();
                    return iziToast.error({
                        title: 'Municipio',
                        message: 'Producto Eliminado Correctamente',
                        position: 'topRight'
                    });
                },
                sumatorias() {
                    let total = 0;
                    this.items.forEach(producto => {
                        total += Number(producto.total);
                    });
                    this.total_ingreso = Number(total.toFixed(2));
                },
                formtatNumber(number) {
                    return new Intl.NumberFormat("de-DE", {
                        style: "currency",
                        currency: "USD"
                    }).format(number);
                    // new Intl.NumberFormat("us-US").format(number) + 'USD'
                },
                agregarItem() {
                    let consulta = this.productos.filter(x => x.id == this.producto_id);
                    let total = this.producto_cantidad * this.producto_precio
                    if (consulta.length == 1) {
                        let producto = {
                            id: consulta[0].id,
                            nombre: consulta[0].nombre,
                            cantidad: this.producto_cantidad,
                            precio: this.producto_precio,
                            total: Number(total.toFixed(3))
                        };
                        console.log(Number(total.toFixed(3)))
                        this.items.push(producto);
                        this.producto_cantidad = 1;
                        this.producto_precio = 0;
                        this.producto_id = '';
                        this.sumatorias();
                    }

                },
                storeIngreso() {
                    @this.set('codigo_ingreso', this.codigo_ingreso);
                    @this.set('descripcion_ingreso', this.descripcion_ingreso);
                    @this.set('total_ingreso', this.total_ingreso);
                    @this.set('items', this.items);
                    @this.generarIngreso();
                },
                updateIngreso() {
                    @this.set('codigo_ingreso', this.codigo_ingreso);
                    @this.set('descripcion_ingreso', this.descripcion_ingreso);
                    @this.set('total_ingreso', this.total_ingreso);
                    @this.set('items', this.items);
                    @this.updateIngreso();

                    // setTimeout(() => {}, 1000);
                },
                resetIngreso() {
                    this.items = [];
                    this.producto_cantidad = 1;
                    this.producto_precio = 0;
                    this.producto_id = '';
                    this.descripcion_ingreso = '';
                    this.codigo_ingreso = '';
                    this.total_ingreso = '';
                },
                editIngreso(data) {
                    this.items = data.items;
                    this.producto_cantidad = 1;
                    this.producto_precio = 0;
                    this.producto_id = '';
                    this.descripcion_ingreso = data.descripcion_ingreso;
                    this.codigo_ingreso = data.codigo_ingreso;
                    this.total_ingreso = data.total_ingreso;
                }
            }
        });
        Livewire.on('generarIngreso', function() {
            ingreso.storeIngreso();
        });
        Livewire.on('reset', function() {
            ingreso.resetIngreso();
        });
        Livewire.on('edit', function(data) {
            ingreso.editIngreso(data)
            console.log(data);
        });
        Livewire.on('updateIngreso', function() {
            ingreso.updateIngreso();
        });
    </script>
@endpush
