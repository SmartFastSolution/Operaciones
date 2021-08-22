<div>
    <div id="egresos" wire:ignore>
        @include('coordinador.modales.producto.egresomodal')
        <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#crearEgreso"><i
                class="fas fa-store"></i>
            Agregar Egreso
        </button>
        <button type="button" class="btn btn-outline-success mb-2" wire:click.prevent="generaExcel()">
            <i class="fa fa-file-excel"></i> Generar Reporte
        </button>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">

                </div>
                <div class="card-body p-0">
                    <div class="row p-2 justify-content-center">
                        <div class="col-lg-3 col-sm-12 mt-2">
                            <input wire:model.debounce.300ms="search" type="text" class="form-control p-2"
                                placeholder="Buscar Egreso...">
                        </div>
                        <div class="col-lg-2 col-sm-12 mt-2">
                            <select wire:model="orderBy" class="custom-select " id="grid-state">
                                <option value="id">ID</option>
                                <option value="codigo">Codigo</option>
                                <option value="total_egreso">Total Egreso</option>
                                <option value="descripcion">Descripcion</option>
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
                                    <th class="px-4 py-2 text-center ">Productos</th>
                                    <th class="px-4 py-2 text-center " colspan="3" width="50">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @if ($egresos->isNotEmpty())
                                    @foreach ($egresos as $egreso)
                                        <tr>
                                            <td class="p-0 text-center">{{ $egreso->codigo }}</td>
                                            <td class="p-0 text-center">{{ $egreso->descripcion }}</td>
                                            <td class="p-0 text-center">
                                                {{ number_format($egreso->total_egreso, 3, ',', '.') }}
                                            </td>
                                            <td class="p-0 text-center">{{ $egreso->productos_count }}</td>
                                            <td width="50" class="p-0 text-center"><a
                                                    href="{{ route('coordinador.producto.egresoshow', $egreso->id) }}"
                                                    class="btn btn-primary"><i class="fa fa-eye"></i></a></td>
                                            <td width="50" class="p-0 text-center"><a href="" class="btn btn-warning"
                                                    data-toggle="modal" data-target="#crearEgreso"
                                                    wire:click.prevent="editarEgreso({{ $egreso->id }})"><i
                                                        class="fa fa-edit"></i></a></td>
                                            <td class="p-0 text-center" width="50">
                                                <a class="btn btn-danger text-dark"
                                                    wire:click.prevent="$emit('eliminarRegistro','Seguro que deseas eliminar este Egreso?','eliminarEgreso', {{ $egreso->id }})">
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
    {!! $egresos->links() !!}
</div>
@push('scripts')
    <script src="https://unpkg.com/currency.js@~2.0.0/dist/currency.min.js"></script>

    <script type="text/javascript">
        let productos = @json($productos);
        let medidas = @json($medidas);
        let conversiones = @json($conversiones);
        const egresos = new Vue({
            el: "#egresos",
            name: "Egresos",
            data: {
                codigo: '',
                descripcion: '',
                total_egreso: '',
                productos: productos,
                medidas: medidas,
                conversiones: conversiones,
                items: [],
                medida: {},
                money: {
                    decimal: ',',
                    thousands: '.',
                    prefix: '$',
                    suffix: '',
                    precision: 3,
                    masked: false
                },
                atencion_id: '',
                egreso_id: '',
                producto_id: '',
                cantidad: 1,
                cantidad_real: null,
                unidad_id: '',
                updateMode: false,
                creating: false,
                updating: false,
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
                changeUnidad() {
                    let find = this.productos.filter(x => x.id == this.producto_id);
                    this.medida = find[0].medida;
                    this.unidad_id = find[0].medida_id;
                    this.conversion();
                },
                conversion() {
                    // console.log(find[0])
                    this.cantidad_real = this.calcularfactor();
                    // this.unidad_id = find[0].medida_id;
                },
                calcularfactor() {
                    let find = this.conversiones.filter(x => x.medida_base == this.medida.id && x
                        .medida_conversion == this.unidad_id);
                    if (find.length == 1) {
                        let real = find[0].factor * this.cantidad;
                        return real;
                    } else {
                        return 0;
                    }

                },
                numberformat(number) {
                    let convert = currency(number, {
                        precision: 3
                    });
                    return convert.value;
                },
                formatdecimal(number) {
                    let convert = currency(number, {
                        decimal: ',',
                        precision: 3
                    }).format();
                    return convert;
                },
                agregarItem() {
                    if (this.producto_id === '') {
                        iziToast.error({
                            title: 'Operaciones',
                            message: 'No has seleccionado un Producto',
                            position: 'topRight'
                        });
                    } else {
                        let find = this.items.filter(x => x.id == this.producto_id);
                        if (find.length == 1) {
                            return iziToast.error({
                                title: 'Operaciones',
                                message: 'Este producto ya esta en la lista',
                                position: 'topRight'
                            });
                        } else if (this.cantidad_real === 0) {
                            return iziToast.error({
                                title: 'Operaciones',
                                message: 'No puedes agregar una cantidad de 0',
                                position: 'topRight'
                            });

                        }

                        // if (find.length == 1) {
                        // 	let can = (find[0].cantidad + Number(this.cantidad));
                        // 	find[0].cantidad = can;
                        // 	let producto  = this.productos.filter(x => x.id == this.producto_id );
                        // 	let total = (producto[0].precio_iva * this.cantidad);
                        // 	find[0].total = find[0].total + total;
                        // } else {
                        let producto = this.productos.filter(x => x.id == this.producto_id);
                        // console.log(producto)
                        // if (producto[0].cantidad < this.cantidad_real){
                        // iziToast.error({
                        //           title: 'Operaciones',
                        //           message: 'La cantidad seleccionada supera el stock',
                        //           position: 'topRight'
                        //         });
                        // return
                        // }
                        let valorxunidad = producto[0].precio_iva / producto[0].presentacion;
                        let total = Number(valorxunidad * this.cantidad_real);
                        let item = {
                            id: this.producto_id,
                            nombre: producto[0].nombre,
                            medida_base: this.unidad_id,
                            medida_conversion: this.medida.id,
                            cantidad_unidad: Number(this.cantidad),
                            cantidad_base: this.cantidad_real,
                            medida_real: producto[0].medida.simbolo,
                            total: this.numberformat(total)
                        }
                        this.items.push(item);
                        this.sumatorias();

                        console.log(item);
                        // }
                        this.cantidad = 1;
                        this.producto_id = '';
                        this.unidad_id = '';
                        this.cantidad_real = null;
                        this.medida = {};

                    }
                },
                cambioCantidad(index) {
                    let producto = this.productos.filter(x => x.id == this.items[index].id);
                    let total = Number(this.items[index].cantidad) * producto[0].precio_iva;
                    this.items[index].total = total.toFixed(3);
                },
                incremento(index) {
                    let cantidad = this.items[index].cantidad + 1;
                    let producto = this.productos.filter(x => x.id == this.items[index].id);
                    let total = Number(cantidad) * producto[0].precio_iva;
                    this.items[index].cantidad = cantidad;
                    this.items[index].total = total.toFixed(3);
                },
                decremento(index) {
                    let cantidad = this.items[index].cantidad - 1;
                    let producto = this.productos.filter(x => x.id == this.items[index].id);
                    let total = Number(cantidad) * producto[0].precio_iva;
                    this.items[index].cantidad = cantidad;
                    this.items[index].total = total.toFixed(3);
                },
                eliminarProducto(index) {
                    this.items.splice(index, 1);
                    this.sumatorias();
                },
                generarEgreso() {
                    if (this.codigo === '') {
                        iziToast.error({
                            title: 'Operaciones',
                            message: 'No has agregado el codigo del egreso',
                            position: 'topRight'
                        });
                    } else if (this.descripcion === '') {
                        iziToast.error({
                            title: 'Operaciones',
                            message: 'No has agregado la descripción',
                            position: 'topRight'
                        });
                    } else if (this.total_egreso === '') {
                        iziToast.error({
                            title: 'Operaciones',
                            message: 'No has agregado el total de egreso',
                            position: 'topRight'
                        });
                    } else if (this.items.length == 0) {
                        iziToast.error({
                            title: 'Operaciones',
                            message: 'No has seleccionado ningun producto',
                            position: 'topRight'
                        });
                    } else {
                        this.creating = true;
                        let datos = {
                            codigo: this.codigo,
                            descripcion: this.descripcion,
                            items: this.items,
                            total_egreso: this.total_egreso,
                        }
                        Livewire.emit('guardarEgreso', datos);
                        this.codigo = '';
                        this.descripcion = '';
                        this.items = [];
                        this.total_egreso = '';
                        this.creating = false;
                    }

                },
                sumatorias() {
                    let total = 0;
                    this.items.forEach(producto => {
                        total += Number(producto.total);
                    });
                    this.total_egreso = this.numberformat(total);
                },
                resetInput() {
                    this.creating = false;
                    this.updating = false;
                    this.codigo = '';
                    this.descripcion = '';
                    this.items = [];
                    this.total_egreso = '';
                    this.producto_id = '';
                },
                actualizarEgreso() {
                    if (this.codigo === '') {
                        iziToast.error({
                            title: 'Operaciones',
                            message: 'No has agregado el codigo del egreso',
                            position: 'topRight'
                        });
                    } else if (this.descripcion === '') {
                        iziToast.error({
                            title: 'Operaciones',
                            message: 'No has agregado la descripción',
                            position: 'topRight'
                        });
                    } else if (this.total_egreso === '') {
                        iziToast.error({
                            title: 'Operaciones',
                            message: 'No has agregado el total de egreso',
                            position: 'topRight'
                        });
                    } else if (this.items.length == 0) {
                        iziToast.error({
                            title: 'Operaciones',
                            message: 'No has seleccionado ningun producto',
                            position: 'topRight'
                        });
                    } else {
                        this.updating = true;
                        let datos = {
                            codigo: this.codigo,
                            descripcion: this.descripcion,
                            items: this.items,
                            total_egreso: this.total_egreso,
                        }
                        Livewire.emit('actualizarEgreso', datos);
                        this.codigo = '';
                        this.descripcion = '';
                        this.items = [];
                        this.total_egreso = '';
                        this.updating = false;


                    }
                },
                editarEgreso(datos) {
                    this.egreso_id = datos.egreso.id;
                    this.codigo = datos.egreso.codigo;
                    this.descripcion = datos.egreso.descripcion;
                    this.total_egreso = datos.egreso.total_egreso;
                    this.cargarItems(datos.items);
                    this.updateMode = true;
                },
                cargarItems(items) {
                    let set = this;
                    items.forEach(function(item) {
                        let producto = set.productos.filter(x => x.id == item.id);

                        let valorxunidad = producto[0].precio_iva / producto[0].presentacion;
                        let total = Number(valorxunidad * item.pivot.cantidad_real).toFixed(3);
                        let ite = {
                            id: producto[0].id,
                            nombre: producto[0].nombre,
                            medida_base: set.unidad_id,
                            medida_conversion: set.medida.id,
                            cantidad_unidad: Number(set.cantidad),
                            cantidad_base: item.pivot.cantidad_real,
                            medida_real: producto[0].medida.simbolo,
                            total: set.numberformat(total)
                        }
                        set.items.push(ite);
                    });

                }
            }
        });

        Livewire.on('editarEgreso', function(datos) {
            egresos.editarEgreso(datos);
            console.log(datos);
        });
    </script>
@endpush
