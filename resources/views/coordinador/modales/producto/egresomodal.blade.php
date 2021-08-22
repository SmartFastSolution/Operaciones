<div class="modal fade" id="crearEgreso" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="crearEgresoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="exampleModalCenterTitle">Engreso</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                    @click.prevent="resetInput()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h2 class="text-center text-danger font-weight-bold">DATOS DEL EGRESO</h2>
                <div class="form-row">
                    <div class="form-group col-lg-6 col-sm-12">
                        <label>Codigo de Egreso</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-key"></i>
                                </div>
                            </div>
                            <input type="text" v-model="codigo" class="form-control text-right"
                                placeholder="Codigo. Egreso">
                        </div>
                    </div>
                    {{-- <div class="form-group col-lg-6 col-sm-12">
                        <label>Total de Egreso</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-usd-square"></i>
                                </div>
                            </div>
                            <input type="number" v-model="total_egreso" class="form-control text-right">
                        </div>
                    </div> --}}
                    {{-- <div class="form-group col-lg-12 col-sm-12">
            <div class="form-row">
              <label for="" class="col-lg-3 col-sm-12"> Codigo de Egreso</label>
              <input type="text" class="form-control col-lg-3 col-sm-12  text-right" v-model="codigo">
              <label for="" class="col-lg-2 col-sm-12"> Total Egreso</label>
              <input type="number" class="form-control col-lg-3 col-sm-12 text-right" v-model="total_egreso">
            </div>

          </div> --}}
                    <div class="form-group col-lg-12 col-sm-12">
                        <label for="">Descripción del Egreso</label>
                        <textarea name="" id="" cols="30" rows="10" class="form-control"
                            v-model="descripcion"></textarea>
                    </div>
                </div>
                <div class="border p-2">
                    <h4 class="text-center text-danger font-weight-bold">PRODUCTOS</h4>
                    <div class="form-row justify-content-center">
                        <div class="form-group col-lg-4 col-sm-12">
                            <model-list-select :list="getFilterProducto" v-model="producto_id" class="form-control"
                                option-value="id" option-text="producto" placeholder="Elije Un Producto"
                                @input="changeUnidad">
                                {{-- <select name="" v-model="producto_id" id="" class="form-control" @change="changeUnidad">
                                    <option value="" selected="" disabled="">SELECCIONA UN PRODUCTO</option>
                                    <option v-for="(producto, index) in productos" :value="producto.id">
                                        @{{ producto . nombre }}, @{{ producto . medida . simbolo }}</option>
                                </select> --}}
                        </div>
                        <div class="form-group col-lg-2 col-sm-12">
                            <input type="number" class="form-control text-right" v-model="cantidad" min="1"
                                @change="conversion" placeholder="cantidad">
                        </div>
                        <div class="form-group col-lg-4 col-sm-12">
                            <model-list-select :list="medidas" v-model="unidad_id" class="form-control"
                                option-value="id" option-text="conversion" placeholder="Elije Una Unidad"
                                @input="conversion">
                                {{-- <select name="" id="" v-model="unidad_id" class="custom-select" @change="conversion">
                                    <option value="" selected="" disabled="">Seleccione Unidad Base</option>
                                    <option v-for="(unidad, index) in medidas" :value="unidad.id">
                                        @{{ unidad . unidad }},
                                        @{{ unidad . simbolo }}</option>
                                </select> --}}
                        </div>
                        <div class="form-group col-lg-2 col-sm-12">
                            <input type="number" class="form-control text-right" disabled="" v-model="cantidad_real"
                                min="1" placeholder="Cant">
                        </div>
                        <div class="form-group col-lg-2 col-sm-12">
                            <button class="btn btn-danger" @click.prevent="agregarItem()">Agregar</button>
                        </div>
                    </div>
                    <h3 class="text-danger font-italic text-center">Productos</h3>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead class="text-light-all bg-dark">
                                <tr>
                                    <th class="text-center">Producto</th>
                                    {{-- <th>Cantidad</th> --}}
                                    <th class="text-center">Cantidad</th>
                                    {{-- <th>Precio</th> --}}
                                    <th class="text-center">Total($)</th>
                                    <th>Borrar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(product, index) in items">
                                    <td>@{{ product . nombre }}</td>
                                    {{-- <td width="150">
                    @{{ product.cantidad_unidad }}
                  </td> --}}
                                    <td class="text-center">@{{ product . cantidad_base }}
                                        (@{{ product . medida_real }})</td>
                                    <td class="text-center">@{{ formatdecimal(product . total) }}</td>
                                    <td width="25"><button class="btn btn-danger"
                                            @click.prevent="eliminarProducto(index)"><i
                                                class="fa fa-trash"></i></button></td>
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
                                        <td>
                                            <money :value="total_egreso" v-bind="money" disabled
                                                class="form-control text-right">
                                            </money>
                                            {{-- <input type="number" class="form-control text-right" :value="total_egreso"
                                                placeholder="Total" disabled> --}}
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer br">
                <div v-if="!updateMode" class="text-center">
                    <a v-if="!creating" href="" class="btn btn-success" @click.prevent="generarEgreso()">Generar
                        Egreso</a>
                    <button v-else class="btn btn-primary" type="button" disabled>
                        <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                        Creando...
                    </button>
                </div>
                <div v-if="updateMode">
                    <a v-if="!updating" href="" class="btn btn-success" @click.prevent="actualizarEgreso()">Actualizar
                        Egreso</a>
                    <button v-else class="btn btn-primary" type="button" disabled>
                        <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                        Actualizando...
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
