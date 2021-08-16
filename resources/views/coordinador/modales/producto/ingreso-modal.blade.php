<div wire:ignore.self class="modal fade" id="crearIngreso" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="crearIngresoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title text-dark" id="exampleModalCenterTitle">Ingreso</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="resetInput">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if ($errors->all())
                    <div class="alert alert-danger alert-has-icon">
                        <div class="alert-icon"><i class="far fa-lightbulb"></i></div>
                        <div class="alert-body">
                            <div class="alert-title">Tienes estos errores</div>
                            @foreach ($errors->all() as $err)
                                <p class="error-message  font-weight-bold">{{ $err }}</p>
                            @endforeach
                        </div>
                    </div>

                @endif
                <div id="ingreso" wire:ignore>
                    <h3 class="text-center font-weight-bold">DATOS DEL INGRESO</h3>
                    <div class="form-row">
                        <div class="form-group col-lg-4 col-sm-12">
                            <label for="">CODIGO</label>
                            <input type="text" class="form-control" v-model="codigo_ingreso" placeholder="Cod.">
                        </div>
                        {{-- <div class="form-group col-lg-2 col-sm-12">
                            <label for="">VALOR TOTAL</label>
                            <input type="number" class="form-control text-right" v-model="total_ingreso"
                                placeholder="Valor.">

                        </div> --}}
                        <div class="form-group col-lg-8 col-sm-12">
                            <label for="">DESCRIPCIÓN</label>
                            <input type="text" class="form-control" v-model="descripcion_ingreso"
                                placeholder="Descripción del Ingreso">
                        </div>
                    </div>
                    <div class="border p-2">
                        <h3 class="text-center">PRODUCTO</h3>
                        <div class="form-row justify-content-center">
                            <div class="form-group col-lg-4 col-sm-12">
                                <model-list-select :list="getFilterProducto" v-model="producto_id" class="form-control"
                                    option-value="id" option-text="producto" placeholder="Elije Un Productos"
                                    @input="getPrecio">
                                    {{-- <select name="" id="" class="custom-select" wire:model.defer="producto_id">
                                        <option value="" selected="" disabled="">Seleccione un Producto</option>
                                        @foreach ($productos as $producto)
                                            <option value="{{ $producto->id }}">{{ $producto->nombre }},
                                                {{ $producto->presentacion }} {{ $producto->medida->simbolo }}
                                            </option>
                                        @endforeach
                                    </select> --}}

                            </div>
                            <div class="form-group col-lg-3 col-sm-12">
                                <input type="number" class="form-control text-right" v-model="producto_cantidad"
                                    placeholder="Cantidad">

                            </div>
                            <div class="form-group col-lg-3 col-sm-12">
                                <input type="number" class="form-control text-right" v-model="producto_precio" disabled
                                    placeholder="Precio">

                            </div>
                            <div class="form-group col-lg-2 col-sm-12">
                                <label for=""></label>
                                <button class="btn btn-success" @click.prevent="agregarItem">Agregar</button>
                            </div>
                        </div>
                        <h3 class="text-danger font-italic text-center">Productos</h3>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead class="text-light-all bg-dark">
                                    <tr>
                                        <th>Producto</th>
                                        <th class="text-center">Cantidad</th>
                                        <th class="text-center">Precio</th>
                                        <th class="text-center">Total($)</th>
                                        <th class="text-center">Borrar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(producto, index) in items">
                                        <td>@{{ producto . nombre }}</td>
                                        <td width="150" class="text-center">
                                            @{{ producto . cantidad }}
                                        </td>
                                        <td class="text-center">@{{ formtatNumber(producto . precio) }}</td>
                                        <td class="text-center">@{{ formtatNumber(producto . total) }}</td>
                                        <td width="25"><button class="btn btn-danger"
                                                @click.prevent="eliminarItem(index)"><i
                                                    class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-lg-4">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>Total</td>
                                            <td><input type="number" class="form-control text-right"
                                                    :value="total_ingreso" placeholder="Total" disabled></td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer br">
                @if ($editMode)
                    <button type="button" class="btn btn-warning" wire:click="$emit('updateIngreso')">Actualizar
                        Ingreso</button>
                @else
                    <button type="button" class="btn btn-primary" wire:click="$emit('generarIngreso')">Generar
                        Ingreso</button>

                @endif
            </div>
        </div>
    </div>
</div>
