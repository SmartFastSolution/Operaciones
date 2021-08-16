<div wire:ignore.self class="modal fade" id="crearIngreso" data-backdrop="static" data-keyboard="false" tabindex="-1"
    aria-labelledby="crearIngresoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="exampleModalCenterTitle">Ingreso</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click="resetInput">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h3 class="text-center font-weight-bold">DATOS DEL INGRESO</h3>
                <div class="form-row">
                    <div class="form-group col-lg-2 col-sm-12">
                        <label for="">CODIGO</label>
                        <input type="text" class="form-control" wire:model.defer="codigo_ingreso">
                        @error('codigo_ingreso') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group col-lg-2 col-sm-12">
                        <label for="">VALOR TOTAL</label>
                        <input type="number" class="form-control" wire:model.defer="total_ingreso">
                        @error('total_ingreso') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group col-lg-8 col-sm-12">
                        <label for="">DESCRIPCIÓN</label>
                        <input type="text" class="form-control" wire:model.defer="descripcion_ingreso">
                        @error('descripcion_ingreso') <span class="error text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="border p-2">
                    <h3 class="text-center">PRODUCTO</h3>
                    <div class="form-row justify-content-center">
                        <div class="form-group col-lg-4 col-sm-12">
                            <select name="" id="" class="custom-select" wire:model.defer="producto_id">
                                <option value="" selected="" disabled="">Seleccione un Producto</option>
                                @foreach ($productos as $producto)
                                    <option value="{{ $producto->id }}">{{ $producto->nombre }},
                                        {{ $producto->presentacion }} {{ $producto->medida->simbolo }}</option>
                                @endforeach
                            </select>
                            @error('producto_id') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="form-group col-lg-3 col-sm-12">
                            <input type="number" class="form-control text-right" wire:model.defer="producto_cantidad"
                                placeholder="Cantidad">
                            @error('producto_cantidad') <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-lg-3 col-sm-12">
                            <input type="number" class="form-control text-right" wire:model.defer="producto_precio"
                                placeholder="Precio">
                            @error('producto_precio') <span class="error text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group col-lg-2 col-sm-12">
                            <label for=""></label>
                            <button class="btn btn-success" wire:click="agregarItem">Agregar</button>
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
                                @foreach ($items as $key => $item)
                                    <tr>
                                        <td>{{ $item['nombre'] }}</td>
                                        <td width="150" class="text-center">
                                            {{ $item['cantidad'] }}
                                        </td>
                                        <td class="text-center">{{ number_format($item['precio'], 2) }}</td>
                                        <td class="text-center">{{ number_format($item['total'], 2) }}</td>
                                        <td width="25"><button class="btn btn-danger"
                                                wire:click="eliminarItem({{ $key }})"><i
                                                    class="fa fa-trash"></i></button></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer br">
                @if ($exportando)
                    <button class="btn btn-primary" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Espere...
                    </button>
                @else

                    @if ($editMode)
                        <button type="button" class="btn btn-warning" wire:click="updateIngreso">Actualizar
                            Ingreso</button>
                    @else
                        <button type="button" class="btn btn-primary" wire:click="generarIngreso">Generar
                            Ingreso</button>

                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
